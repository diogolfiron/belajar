<?php
require_once __DIR__ . '/../vendor/autoload.php';
// LoginTest.php
use PHPUnit\Framework\TestCase;
// use PHPUnit\Framework\Login;

class LoginTest extends TestCase {
    private $db_mock;
    private $login;

    protected function setUp(): void {
        // Membuat mock untuk koneksi database (mysqli)
        $this->db_mock = $this->createMock(mysqli::class);
        // Membuat instance dari kelas Login
        $this->login = new Login($this->db_mock);
    }

    public function testValidateCredentialsSuccess() {
        // Simulasikan jika pengguna dan password benar
        $this->db_mock->method('prepare')
            ->willReturn($this->getMockPreparedStatement(true, true));  // Pengguna ditemukan dan password valid

        $result = $this->login->validate_credentials('validUser', 'validPassword');
        $this->assertTrue($result['success']);  // Memastikan login berhasil
    }

    public function testValidateCredentialsFailure() {
        // Simulasikan jika pengguna tidak ditemukan
        $this->db_mock->method('prepare')
            ->willReturn($this->getMockPreparedStatement(false, false));  // Pengguna tidak ditemukan

        $result = $this->login->validate_credentials('invalidUser', 'wrongPassword');
        $this->assertFalse($result['success']);  // Memastikan login gagal
        $this->assertEquals('Username tidak ditemukan.', $result['error']);
    }

    private function getMockPreparedStatement($userFound, $passwordVerified) {
        // Membuat mock untuk prepared statement
        $stmt_mock = $this->createMock(mysqli_stmt::class);

        if ($userFound) {
            // Jika pengguna ditemukan
            $stmt_mock->method('num_rows')->willReturn(1);  // Meniru num_rows yang mengindikasikan pengguna ditemukan
            $stmt_mock->method('bind_result')->willReturnCallback(function(&$id, &$username, &$password) {
                $id = 1;
                $username = 'validUser';
                $password = password_hash('validPassword', PASSWORD_DEFAULT);  // Meniru password yang di-hash
            });
            $stmt_mock->method('execute')->willReturn(true);  // Meniru eksekusi yang berhasil
        } else {
            // Jika pengguna tidak ditemukan
            $stmt_mock->method('num_rows')->willReturn(0);  // Tidak ada pengguna yang ditemukan
        }

        return $stmt_mock;
    }
}
