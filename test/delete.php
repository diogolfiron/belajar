<?php

// Mengimpor file kelas StudentData
require_once 'StudentData.php';

// Inisialisasi koneksi database
require_once 'config.php';

// Ambil ID dari URL
$id = $_GET['id'];

// Buat instance kelas StudentData
$studentData = new StudentData($con);

// Panggil fungsi untuk menghapus data siswa berdasarkan ID
$deleteSuccess = $studentData->deleteStudentById($id);

// Tindak lanjut setelah penghapusan data
if ($deleteSuccess) {
    header('location:index.php');
} else {
    echo "Data gagal dihapus";
}

?>
