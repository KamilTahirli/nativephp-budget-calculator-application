# 🌟 NativePHP Desktop Application

This project is a <strong>NativePHP</strong>-based desktop application developed with PHP. It is a Laravel-based application that can run on <strong>Linux</strong>, <strong>MacOS</strong>, and <strong>Windows</strong> platforms.

---

## 🚀 Installation and Running

After cloning the project to your system, follow these steps to run the application.

### 📌 1. Install Dependencies

Navigate to the project's root directory in your terminal or command line and install Laravel dependencies:

```sh
composer install
```

### ⚙️ 2. Configure Environment File

Create your <code>.env</code> file and set the necessary values:

```sh
cp .env.example .env
php artisan key:generate
```

### ▶️ 3. Start the NativePHP Server

Use the following command to start the application in a desktop environment:

```sh
php artisan native:serve
```

This command runs the application in development mode.

---

## 💻 Building for Specific Platforms

To build the application for a specific platform, use the following commands:

### 🐧 Build for Linux
```sh
php artisan native:build linux
```

### 🍏 Build for MacOS
```sh
php artisan native:build mac
```

### 🖥️ Build for Windows
```sh
php artisan native:build win
```

These commands compile and package the application as a user-friendly desktop app for the specified platform.

---

### Preview:
![image](https://github.com/user-attachments/assets/81ab3a7a-d91f-4439-9058-ea85177190ff)
![image](https://github.com/user-attachments/assets/93f3d3c8-4fe9-4f44-b541-1072696486ea)


❗ <strong>If you encounter any issues, please report them in the <a href='https://github.com/YOUR_REPO/issues'>GitHub Issues</a> section or contribute by submitting a <a href='https://github.com/YOUR_REPO/pulls'>pull request</a>.</strong>
