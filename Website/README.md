Laravel + Inertia.js + React CRUD Application

A modern full-stack web application featuring item/inventory management with categories, user authentication, and interactive React UI components built using Laravel, Inertia.js, and React.

🛠️ Tech Stack & Dependencies

Backend Framework: Laravel (PHP)

Frontend Framework: React (JSX)

Adapter: Inertia.js (Monolithic Single-Page Application architecture)

Database: MySQL

Styling: Tailwind CSS

Build Tool: Vite

✨ Features

Authentication System: User registration, login, password reset, and profile management (Laravel Breeze / Inertia).

Item Management (CRUD):

Create, view, edit, and delete inventory items.

Category assignment for each item.

Real-time form validations and modal popups.

Database Migrations: Structured schema for users, items, and categories.

🚀 Local Development Setup

Follow these steps to run the project on your local machine:

1. Prerequisites

Ensure you have the following installed:

PHP (v8.2 or higher)

Composer

Node.js & npm

MySQL (via XAMPP, WampServer, or native installation)

2. Clone the Repository

git clone https://github.com/Reljayyyy/LARAVEL-PROJECT-WEB.-DEVELOPMENT.git
cd Website


3. Install Backend Dependencies

composer install


4. Install Frontend Dependencies

npm install


5. Configure Environment Variables

Copy the .env.example file to create your .env file:

cp .env.example .env


Open .env and configure your database credentials:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_local_database_name
DB_USERNAME=root
DB_PASSWORD=


6. Generate Application Key & Run Migrations

php artisan key:generate
php artisan migrate --seed


7. Run Local Servers

In one terminal, start the PHP server:

php artisan serve


In a second terminal, start the Vite development server for React:

npm run dev


Visit the application at http://127.0.0.1:8000.

📦 Deployment Instructions

Preparing Frontend Assets for Production

Before deploying to any web host (such as Fly.io, InfinityFree, or Caleho Cloud), always compile production assets:

npm run build