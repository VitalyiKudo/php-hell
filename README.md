# NexSource JetOnSet V2 (NSJ)

This project runs with Laravel Framework version 5.8.38

## Installation

Assuming you've already installed on your machine: PHP (>= 7.2), [Laravel](https://laravel.com/) and [Composer](https://getcomposer.org/)

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository into a specific folder on your local server

Switch to the repo folder

    cd Code/

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Put this code in ib the end of your .env file

    # Square
    ENVIRONMENT=sandbox

    # Production credentials
    PRODUCTION_ACCESS_TOKEN=EAAAEHzxmth3iuW-fWM4upgTseZlRFBfz9qz9ZKADmOSAi1EQ9hMR-cw-_Lxvky1
    PRODUCTION_APP_ID=sandbox-sq0idb-T-6f2DihhYklkBSzSNpcvA
    PRODUCTION_LOCATION_ID=LT8GFPJ9TJSAR

    # Sandbox credentials
    SANDBOX_ACCESS_TOKEN=EAAAEHzxmth3iuW-fWM4upgTseZlRFBfz9qz9ZKADmOSAi1EQ9hMR-cw-_Lxvky1
    SANDBOX_APP_ID=sandbox-sq0idb-T-6f2DihhYklkBSzSNpcvA

Set SMTP settings in to your .env file

Make your storage folder writable

    sudo chown -R 777 /path/to/your/project/storage

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

Run the database seeder

    php artisan db:seed

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

## Configuration

All of the configuration files for the Laravel framework are stored in the config directory.

***Note*** : To combine all of your config files into one, use:

    php artisan config:cache

***Note*** : To refresh the config cache, run the above command again
