<?php

// Pastikan mengimpor koneksi ke database (config.php)
require_once 'config.php';

class StudentData {
    private $con;

    public function __construct($db_connection) {
        $this->con = $db_connection;
    }

    public function deleteStudentById($id) {
        // Prepare the DELETE query
        $deleteQuery = "DELETE FROM student_data WHERE id = $id";

        // Execute the query
        $result = mysqli_query($this->con, $deleteQuery);

        return $result;
    }
}

?>
