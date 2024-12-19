using MyApp.Services;
using Microsoft.AspNetCore.Builder;
using Microsoft.Extensions.DependencyInjection;
using Microsoft.Extensions.Hosting;

var builder = WebApplication.CreateBuilder(args);

// Tambahkan UserService ke DI container
builder.Services.AddSingleton<UserService>();

var app = builder.Build();

// Tentukan route, dll
app.MapControllers();

app.Run();
