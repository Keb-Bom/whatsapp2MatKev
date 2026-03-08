<?php

class Encryption {

    private $method = 'AES-256-CBC';
    private $secret_key = 'mi_clave_super_secreta_123';
    private $secret_iv = 'mi_vector_secreto_456';

    private function getKey() {
        return hash('sha256', $this->secret_key);
    }

    private function getIV() {
        return substr(hash('sha256', $this->secret_iv), 0, 16);
    }

    public function encrypt($text) {

        $output = openssl_encrypt(
            $text,
            $this->method,
            $this->getKey(),
            0,
            $this->getIV()
        );

        return base64_encode($output);
    }

    public function decrypt($text) {

        return openssl_decrypt(
            base64_decode($text),
            $this->method,
            $this->getKey(),
            0,
            $this->getIV()
        );
    }

}