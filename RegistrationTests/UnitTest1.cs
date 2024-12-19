using NUnit.Framework;
using MyApp.Services;

namespace MyApp.Tests
{
    [TestFixture]
    public class UserServiceTests
    {
        private UserService _userService;

        [SetUp]
        public void SetUp()
        {
            _userService = new UserService();  // Membuat instance baru dari UserService sebelum setiap test
        }

        [Test]
        public void Register_ValidData_ShouldReturnTrue()
        {
            // Arrange
            string username = "newuser";
            string password = "password123";
            string confirmPassword = "password123";

            // Act
            var result = _userService.Register(username, password, confirmPassword);

            // Assert
            Assert.IsTrue(result, "Registration should be successful.");
        }

        [Test]
        public void Register_UsernameTooShort_ShouldReturnFalseWithError()
        {
            // Arrange
            string username = "usr"; // Username terlalu pendek
            string password = "password123";
            string confirmPassword = "password123";

            // Act
            var result = _userService.Register(username, password, confirmPassword);

            // Assert
            Assert.IsFalse(result, "Registration should fail due to short username.");
            Assert.AreEqual("Username harus minimal 6 karakter.", _userService.UsernameError);
        }

        [Test]
        public void Register_UsernameAlreadyExists_ShouldReturnFalseWithError()
        {
            // Arrange
            string username = "existinguser";
            string password = "password123";
            string confirmPassword = "password123";

            // Simulasi user yang sudah ada
            _userService.Register(username, password, confirmPassword);

            // Act
            var result = _userService.Register(username, password, confirmPassword);

            // Assert
            Assert.IsFalse(result, "Registration should fail due to existing username.");
            Assert.AreEqual("Nama pengguna ini sudah dipakai.", _userService.UsernameError);
        }

        [Test]
        public void Register_PasswordMismatch_ShouldReturnFalseWithError()
        {
            // Arrange
            string username = "newuser";
            string password = "password123";
            string confirmPassword = "differentpassword";

            // Act
            var result = _userService.Register(username, password, confirmPassword);

            // Assert
            Assert.IsFalse(result, "Registration should fail due to password mismatch.");
            Assert.AreEqual("Password did not match.", _userService.ConfirmPasswordError);
        }

        [Test]
        public void Register_Successfully_ShouldAddUserToList()
        {
            // Arrange
            string username = "newuser";
            string password = "password123";
            string confirmPassword = "password123";

            // Act
            var result = _userService.Register(username, password, confirmPassword);

            // Assert
            Assert.IsTrue(result, "Registration should be successful.");
            Assert.AreEqual(1, _userService.Users.Count, "There should be one user in the list.");
        }
    }
}
