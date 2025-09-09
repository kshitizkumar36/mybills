<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

$host = "localhost";
$user = "u302659638_mybills"; // change if needed
$pass = "Harmu@1234";     // change if needed
$db   = "u302659638_mybills"; // your database name

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("DB Connection Failed: " . $conn->connect_error);
}



class AESCipher {
    private $cipher = "AES-256-CBC"; // AES encryption algorithm
    private $key;  // Secret key

    public function __construct($key) {
        // Ensure key is 32 bytes for AES-256
        $this->key = hash('sha256', $key, true);
    }

    // Encrypt function
    public function encrypt($plaintext) {
        // Generate a random IV (16 bytes for AES-256-CBC)
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($this->cipher));

        // Encrypt the data
        $ciphertext = openssl_encrypt($plaintext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);

        // Return base64-encoded IV + ciphertext
        return base64_encode($iv . $ciphertext);
    }

    // Decrypt function
    public function decrypt($ciphertext_base64) {
        $data = base64_decode($ciphertext_base64);

        $iv_length = openssl_cipher_iv_length($this->cipher);
        $iv = substr($data, 0, $iv_length);
        $ciphertext = substr($data, $iv_length);

        // Decrypt
        return openssl_decrypt($ciphertext, $this->cipher, $this->key, OPENSSL_RAW_DATA, $iv);
    }
}



?>