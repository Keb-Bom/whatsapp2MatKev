<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../services/Encryption.php';

class MessageController {

    public function send() {

        if (!isset($_SESSION["user_id"])) {
            echo json_encode(["error" => "No autorizado"]);
            return;
        }

        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->receiver_id) || !isset($data->message)) {
            echo json_encode(["error" => "Datos incompletos"]);
            return;
        }

        $database = new Database();
        $db = $database->connect();

        $encryption = new Encryption();
        $encryptedMessage = $encryption->encrypt($data->message);

        $query = "INSERT INTO messages (sender_id, receiver_id, message_encrypted)
                  VALUES (:sender, :receiver, :message)";

        $stmt = $db->prepare($query);

        $stmt->bindParam(":sender", $_SESSION["user_id"]);
        $stmt->bindParam(":receiver", $data->receiver_id);
        $stmt->bindParam(":message", $encryptedMessage);

        if ($stmt->execute()) {

            echo json_encode([
                "message" => "Mensaje enviado"
            ]);

        } else {

            echo json_encode([
                "error" => "Error al enviar mensaje"
            ]);
        }
    }

    public function getMessages($otherUserId) {

        if (!isset($_SESSION["user_id"])) {
            echo json_encode(["error" => "No autorizado"]);
            return;
        }

        $database = new Database();
        $db = $database->connect();

        $query = "SELECT * FROM messages
                  WHERE (sender_id = :me AND receiver_id = :other)
                  OR (sender_id = :other AND receiver_id = :me)
                  ORDER BY created_at ASC";

        $stmt = $db->prepare($query);

        $stmt->bindParam(":me", $_SESSION["user_id"]);
        $stmt->bindParam(":other", $otherUserId);

        $stmt->execute();

        $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $encryption = new Encryption();

        foreach ($messages as &$msg) {
            $msg["message"] = $encryption->decrypt($msg["message_encrypted"]);
            unset($msg["message_encrypted"]);
        }

        echo json_encode($messages);
    }

    public function poll($otherUserId) {

        if (!isset($_SESSION["user_id"])) {
            echo json_encode(["error" => "No autorizado"]);
            return;
        }

        $database = new Database();
        $db = $database->connect();

        $startTime = time();
        $timeout = 20;

        while (time() - $startTime < $timeout) {

            $query = "SELECT * FROM messages
                      WHERE (sender_id = :me AND receiver_id = :other)
                      OR (sender_id = :other AND receiver_id = :me)
                      ORDER BY created_at DESC
                      LIMIT 1";

            $stmt = $db->prepare($query);

            $stmt->bindParam(":me", $_SESSION["user_id"]);
            $stmt->bindParam(":other", $otherUserId);

            $stmt->execute();

            $message = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($message) {

                $encryption = new Encryption();
                $message["message"] = $encryption->decrypt($message["message_encrypted"]);
                unset($message["message_encrypted"]);

                echo json_encode($message);
                return;
            }

            sleep(2);
        }

        echo json_encode([
            "message" => "sin_nuevos_mensajes"
        ]);
    }
}