<?php

// Login.php
class Login {
    private $con;

    // Konstruktor menerima koneksi database
    public function __construct($db_connection) {
        $this->con = $db_connection;
    }

    public function validate_credentials($username, $password) {
        $username_err = $password_err = $login_err = "";

        if (empty(trim($username))) {
            $username_err = "Silahkan masukkan nama pengguna.";
        }

        if (empty(trim($password))) {
            $password_err = "Silahkan masukkan password.";
        }

        if (empty($username_err) && empty($password_err)) {
            $sql = "SELECT id, username, password FROM users WHERE username = ?";
            if ($stmt = mysqli_prepare($this->con, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $param_username);
                $param_username = $username;

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);
                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                        if (mysqli_stmt_fetch($stmt)) {
                            if (password_verify($password, $hashed_password)) {
                                return ['success' => true, 'id' => $id, 'username' => $username];
                            } else {
                                $login_err = "Password yang Anda masukkan salah.";
                            }
                        }
                    } else {
                        $login_err = "Username tidak ditemukan.";
                    }
                }
            }
        }

        return ['success' => false, 'error' => $login_err];
    }
}
