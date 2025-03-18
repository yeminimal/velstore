# Velstore

Velstore is a powerful and open-source multi-vendor Laravel eCommerce solution. It is fully customizable and ready to use. It is the perfect choice for launching your online store with ease and efficiency.

## Features

- Built with Laravel
- Multi vendor support
- Multi lingual support  
- Dedicated Admin, Seller, and Customer panels 
- Modular and extensible architecture 

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
- Database: MySQLi
- Frontend: Blade (with Laravel UI)
- Authentication: Laravel Sanctum
- DataTables: Yajra Laravel Datatables