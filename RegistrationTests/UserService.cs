using MyApp.Models;
using System;
using System.Collections.Generic;

namespace MyApp.Services
{
    public class UserService
    {
        // Daftar pengguna yang tersimpan
        private readonly List<User> _users = new List<User>();

        // Properti untuk pesan error
        public string UsernameError { get; private set; } = string.Empty;
        public string PasswordError { get; private set; } = string.Empty;
        public string ConfirmPasswordError { get; private set; } = string.Empty;

        // Properti untuk mengambil daftar user (readonly)
        public IReadOnlyList<User> Users => _users.AsReadOnly();

        // Konstruktor
        public UserService()
        {
            // Inisialisasi properti error dengan nilai default (kosong)
            UsernameError = string.Empty;
            PasswordError = string.Empty;
            ConfirmPasswordError = string.Empty;
        }

        // Metode untuk registrasi user
        public bool Register(string username, string password, string confirmPassword)
        {
            // Validasi Username
            if (string.IsNullOrWhiteSpace(username))
            {
                UsernameError = "Silakan masukkan nama pengguna.";
                return false;
            }

            if (username.Length < 6)
            {
                UsernameError = "Username harus minimal 6 karakter.";
                return false;
            }

            if (_users.Exists(u => u.Username == username))
            {
                UsernameError = "Nama pengguna ini sudah dipakai.";
                return false;
            }

            // Validasi Password
            if (string.IsNullOrWhiteSpace(password))
            {
                PasswordError = "Silakan masukkan password.";
                return false;
            }

            if (password.Length < 6)
            {
                PasswordError = "Password harus minimal 6 karakter.";
                return false;
            }

            // Validasi Confirm Password
            if (password != confirmPassword)
            {
                ConfirmPasswordError = "Password did not match.";
                return false;
            }

            // Simulasi penyimpanan user ke dalam "database"
            _users.Add(new User { Username = username, Password = password });
            return true;
        }
    }
}
