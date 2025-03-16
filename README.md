# velstore

Velstore is a powerful and scalable Laravel eCommerce boilerplate designed for developers who want to build online stores quickly.

## Features

- Built with Laravel
- Multi-Vendor & Multi-Lingual Support  
- Dedicated Admin, Seller, and Customer Panels 
- Modular & Extensible Architecture 

## 🛠️ Installation Guide  

Follow these steps to set up Velstore:  

### **Install via Composer**  
Run the following command to create a new Velstore project:  
```sh
composer create-project velstorelabs/velstore

Create database and rename .env.example to .env

```md
Run the command `php artisan install:velstore --with-import` to install Velstore.

### **Options**
- `--with-import` Imports sample data to help you get started quickly.

Start the Laravel server:
```sh
php artisan serve

Your Velstore instance is now running! Open your browser and visit:
```sh
http://127.0.0.1:8000

## Tech Stack
- Backend: Laravel 10+
- Database: MySQL
- Frontend: Blade (with Laravel UI)
- Authentication: Laravel Sanctum
- DataTables: Yajra Laravel Datatables