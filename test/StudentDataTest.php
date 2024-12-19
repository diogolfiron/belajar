<?php

use PHPUnit\Framework\TestCase;

class StudentDataTest extends TestCase {

    public function testDeleteStudentById_Success() {
        // Mock koneksi database
        $mockCon = $this->createMock(mysqli::class);
        
        // Mock query result
        $mockCon->method('query')->willReturn(true);

        // Instance objek StudentData dengan koneksi mock
        $studentData = new StudentData($mockCon);

        // Panggil fungsi delete
        $result = $studentData->deleteStudentById(1);

        // Assert bahwa query berhasil dijalankan
        $this->assertTrue($result);
    }

    public function testDeleteStudentById_Failure() {
        // Mock koneksi database
        $mockCon = $this->createMock(mysqli::class);

        // Mock query result yang gagal
        $mockCon->method('query')->willReturn(false);

        // Instance objek StudentData dengan koneksi mock
        $studentData = new StudentData($mockCon);

        // Panggil fungsi delete
        $result = $studentData->deleteStudentById(1);

        // Assert bahwa query gagal dijalankan
        $this->assertFalse($result);
    }
}
?>
