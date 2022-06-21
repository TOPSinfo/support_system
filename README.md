#### Documentations

* [Laravel 8.x](https://laravel.com/docs/8.x/installation)
---
#### Installation

* Git clone
```
$ git clone https://git.topsdemo.in/root/support-system.git
```

Step by Step

* Install Laravel packages
```
$ composer install
```

* Duplicate .env.example and rename duplicated file to .env and change credentials for DB and set your application domain "SANCTUM_STATEFUL_DOMAINS"

* Generate Application Key
```
$ php artisan key:generate
```
* Generate a compiled class file with default options
```
$ php artisan optimize
```
* Create Database tables
```
$ php artisan migrate
```
* Add custom data on database
```
$ php artisan db:seed
```
* Start server (http://localhost:8000)
```
$ php artisan serve
```
* Admin panel login url
```
http://localhost:8000/admin/login
```
* Admin panel login credential
```
email    : vijahat@topsinfosolutions.com
password : password
```
* Front panel login credential
```
email    : testvijahat@gmail.com
password : password
```
* API details
```
URL 	: http://localhost:8000/api/ticket
Method 	: POST
For daily
Request : {"type":"daily","type_value":"2022-06-21","api_key":"test@123"}
For monthly
Request : {"type":"monthly","type_value":"6","year":"2022","api_key":"test@123"}
```

* That's everything on the backend part.