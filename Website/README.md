Rel Jay Tugahan CRUD Project

A modern, full-stack web application built with Laravel, Inertia.js, React, and Tailwind CSS. This project features full CRUD (Create, Read, Update, Delete) operations, file management/attachments, real-time filtering & search, and an integrated AI Assistant interface.

🚀 Features

Full CRUD Operations: Create, view, edit, and delete items seamlessly without page reloads (via Inertia.js).

File Upload & Storage: Attach documents, images, or archives to items with automatic storage cleanup on edit/delete.

Search & Categorization: Instant search and dynamic category filtering (General, Documents, Projects, Archive).

Interactive UI: Clean, responsive layout using Tailwind CSS and Lucide React icons.

AI Assistant Widget: Embedded overview assistant powered by AI queries to summarize and inspect item data.

Authentication: Built on top of Laravel Breeze with secure user registration and login.

🛠️ Tech Stack

Backend: Laravel 11+ / PHP 8.2+

Frontend: React (with @inertiajs/react), Tailwind CSS, Lucide Icons

Database: MySQL / MariaDB

State & Routing: Inertia.js

📋 Prerequisites

Ensure you have the following installed on your machine:

PHP (>= 8.2)

Composer

Node.js (>= 18.x) & NPM

MySQL or another supported database server

🔧 Installation & Setup

Follow these steps to get the application up and running locally:

1. Clone the Repository & Install Dependencies

# Clone the repository
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name

# Install PHP dependencies
composer install

# Install Frontend dependencies
npm install


2. Configure Environment

Copy the example environment file and configure your database settings:

cp .env.example .env
php artisan key:generate


Open .env in your text editor and set your database parameters:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=


3. Run Database Migrations

Set up your database tables:

php artisan migrate:fresh


4. Link Public Storage

Enable public access to uploaded file attachments:

php artisan storage:link


🏃 Running the Application

Start both the Laravel backend server and the Vite development server in separate terminal windows:

Terminal 1 (Laravel Server):

php artisan serve


Terminal 2 (Vite / Frontend):

npm run dev


Visit the application in your browser at http://127.0.0.1:8000.

📁 Key File Structure

app/
├── Http/Controllers/
│   └── ItemController.php       # Handles CRUD operations & file storage logic
└── Models/
    └── Item.php                 # Eloquent model for items

database/
└── migrations/
    └── *_create_items_table.php # Database schema migration

resources/
└── js/
    └── Pages/
        └── Dashboard.jsx        # Main React/Inertia dashboard component

routes/
└── web.php                      # Application web routes
