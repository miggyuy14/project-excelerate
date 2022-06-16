# Project Excelerate

[![forthebadge](https://forthebadge.com/images/badges/made-with-vue.svg)](https://forthebadge.com)
[![forthebadge](https://forthebadge.com/images/badges/powered-by-black-magic.svg)](https://forthebadge.com)

----
## Developers

**Miguel Sebastian Uy**

---



## About Project Excelerate
To follow.


## Requirements
- PHP 7.0^ | 8.0^
- Composer
- NPM


## Setup

Please check the official [Laravel Installation Guide](https://laravel.com/docs/8.x/installation) for server requirements before you start.


Clone the repository

```
git clone https://github.com/miggyuy14/project-excelerate.git
```

Switch to the repository folder and install the project dependencies using composer

```
cd project-excelerate
composer install
```

Install the frontend dependencies using npm
```
npm install
```

Copy the example env and make the necessary changes for your project settings
```
cp .env.example .env
```

Generate the application key
```
php artisan key:generate
```


Run the database migrations and seeders (**Note: Do not forget to set the database settings in the .env**)
```
php artisan migrate:fresh --seed
```

Start the local development server
```
php artisan serve
```
