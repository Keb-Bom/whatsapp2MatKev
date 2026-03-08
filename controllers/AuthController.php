<?php

require_once __DIR__ . '/../config/Database.php';

class AuthController {

    public function register() {

        $data = json_decode(file_get_contents("php://input"));

        if (
            !isset($data->nombre) ||
            !isset($data->apellido_paterno) ||
            !isset($data->apellido_materno) ||
            !isset($data->email)
        ) {
            echo json_encode(["error" => "Datos incompletos"]);
            return;
        }

        $database = new Database();
        $db = $database->connect();

        // Generar contraseña aleatoria
        $plainPassword = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 8);

        // Encriptar contraseña
        $hashedPassword = password_hash($plainPassword, PASSWORD_BCRYPT);

        $query = "INSERT INTO users 
                  (nombre, apellido_paterno, apellido_materno, email, password)
                  VALUES 
                  (:nombre, :apellido_paterno, :apellido_materno, :email, :password)";

        $stmt = $db->prepare($query);

        $stmt->bindParam(":nombre", $data->nombre);
        $stmt->bindParam(":apellido_paterno", $data->apellido_paterno);
        $stmt->bindParam(":apellido_materno", $data->apellido_materno);
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":password", $hashedPassword);

        try {

            $stmt->execute();

            echo json_encode([
                "message" => "Usuario registrado correctamente",
                "generated_password" => $plainPassword
            ]);

        } catch(PDOException $e) {

            echo json_encode([
                "error" => "El correo ya está registrado"
            ]);

        }
        
    }
    public function login() {

    $data = json_decode(file_get_contents("php://input"));

    if (!isset($data->email) || !isset($data->password)) {
        echo json_encode(["error" => "Datos incompletos"]);
        return;
    }

    $database = new Database();
    $db = $database->connect();

    $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":email", $data->email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user || !password_verify($data->password, $user["password"])) {
        echo json_encode(["error" => "Credenciales incorrectas"]);
        return;
    }

    // Crear sesión
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["user_email"] = $user["email"];

    echo json_encode([
    "message" => "Login exitoso",
    "session_id" => session_id(),
    "user_id" => $_SESSION["user_id"]
]);
}

}