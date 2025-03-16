# velstore

![Packagist Downloads](https://img.shields.io/packagist/dt/velstorelabs/velstore?style=for-the-badge)

Velstore is a powerful and scalable Laravel eCommerce boilerplate designed for developers who want to build online stores quickly.

## Features

- Built with Laravel
- Multi-Vendor & Multi-Lingual Support  
- Dedicated Admin, Seller, and Customer Panels 
- Modular & Extensible Architecture 

## Installation Guide  

Follow these steps to set up Velstore:  

### **Install via Composer**  
Run the following command to create a new Velstore project:
```sh
composer create-project velstorelabs/velstore
```

Create a new database, then rename `.env.example` to `.env` and update the database credentials. Run the following command to install Velstore:
```sh
php artisan install:velstore --with-import
```

### **Options**
- `--with-import` Imports sample data to help you get started quickly.

Start the Laravel server:
```sh
php artisan serve
```

Your Velstore instance is now running! Open your browser and visit:
```sh
http://127.0.0.1:8000
```

## Tech Stack
- Backend: Laravel 10+
- Database: MySQL
- Frontend: Blade (with Laravel UI)
- Authentication: Laravel Sanctum
- DataTables: Yajra Laravel Datatables