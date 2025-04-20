<p align="center">
  <img src="https://i.ibb.co/dHx2ZR3/velstore.png" alt="Velstore open-source multi-vendor Laravel eCommerce solution">
</p>

<p align="center">

  <a href="https://packagist.org/packages/velstorelabs/velstore">
    <img src="https://poser.pugx.org/velstorelabs/velstore/d/total" alt="Velstore Packagist Downloads">
  </a>
  <!-- Latest Stable Version Badge -->
  <a href="https://github.com/velstorelabs/velstore/releases">
    <img src="https://poser.pugx.org/velstorelabs/velstore/v/stable" alt="Velstore Latest Stable Version">
  </a>

  <!-- License Badge -->
  <a href="https://github.com/velstorelabs/velstore/blob/master/LICENSE">
    <img src="https://poser.pugx.org/velstorelabs/velstore/license" alt="License">
  </a>
</p>

<p align="center">
  <img src="https://i.ibb.co/mCdHFb8s/demo-website-1.png" alt="Velstore open-source multi-vendor Laravel eCommerce solution demo">
</p>


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