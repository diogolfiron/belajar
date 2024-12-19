using Microsoft.AspNetCore.Mvc;
using MyApp.Services;
using MyApp.Models;

namespace MyApp.Controllers
{
    public class UserController : Controller
    {
        private readonly UserService _userService;

        // Dependency Injection UserService
        public UserController(UserService userService)
        {
            _userService = userService;
        }

        // Action method untuk menangani form registrasi
        [HttpPost]
        public IActionResult Register(string username, string password, string confirmPassword)
        {
            if (_userService.Register(username, password, confirmPassword))
            {
                // Redirect ke halaman login jika berhasil
                return RedirectToAction("Login");
            }
            else
            {
                // Kirimkan error jika gagal
                ViewBag.UsernameErr = _userService.UsernameError;
                ViewBag.PasswordErr = _userService.PasswordError;
                ViewBag.ConfirmPasswordErr = _userService.ConfirmPasswordError;
                return View();
            }
        }
    }
}
