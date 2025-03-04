NativePHP Desktop Application

This project is a NativePHP-based desktop application developed with PHP. It is a Laravel-based application that can run on Linux, MacOS, and Windows platforms.

Installation and Running

After cloning the project to your system, follow these steps to run the application.

1. Install Dependencies

Navigate to the project's root directory in your terminal or command line and install Laravel dependencies:

composer install

2. Configure Environment File

Create your .env file and set the necessary values:

cp .env.example .env
php artisan key:generate

3. Start the NativePHP Server

Use the following command to start the application in a desktop environment:

php artisan native:serve

This command runs the application in development mode.

Building for Specific Platforms

To build the application for a specific platform, use the following commands:

Build for Linux

php artisan native:build linux

Build for MacOS

php artisan native:build mac

Build for Windows

php artisan native:build win

These commands compile and package the application as a user-friendly desktop app for the specified platform.

If you encounter any issues, please report them in the GitHub Issues section or contribute by submitting a pull request.
