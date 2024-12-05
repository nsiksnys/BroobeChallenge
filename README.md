# Broobe challenge 
Technical challange done with Laravel 10, PHP 8.1, Javascript, CSS and MySQL

## Bussiness Logic
Please go to the `bussiness logic.md` file for more information about this topic.

## Composer packages
Run `composer install` to install all required packages

## Database creation
First of all, set the environment variables for the database. For more information, check the Environment Variables section.
Then, run all database migration with the `php artisan migrate`. If the database does not exist, you will be offered the chance to create it.

## Environment variables
All envirnoment variables are managed using a .env file, which should not be commited for security reasons. This project provides an example file, .env.example, that you can copy to create your own.

These are the basic variables that must be set for this project.

### APP
#### APP_NAME - Application Name
This value is the name of your application. This value is used when the framework needs to place the application's name in a notification or any other location as required by the application or its packages.

#### APP_ENV - Application Environment
This value determines the "environment" your application is currently running in. This may determine how you prefer to configure various services the application utilizes. Set this in your ".env" file.

#### APP_DEBUG - Application Debug Mode
When your application is in debug mode, detailed error messages with stack traces will be shown on every error that occurs within your application. If disabled, a simple generic error page is shown.

#### APP_URL - Application URL
This URL is used by the console to properly generate URLs when using the Artisan command line tool. You should set this to the root of your application so that it is used when running Artisan tasks.

#### APP_KEY -  Encryption Key
This key is used by the Illuminate encrypter service and should be set to a random, 32 character string, otherwise these encrypted strings will not be safe. Please do this before deploying an application! This key is generated when the project is created.

### LOG
#### LOG_CHANNEL - Default Log Channel
This option defines the default log channel that gets used when writing messages to the logs. The name specified in this option should match one of the channels defined in the "channels" configuration array. 

#### LOG_DEPRECATIONS_CHANNEL - Deprecations Log Channel
This option controls the log channel that should be used to log warnings regarding deprecated PHP and library features. This allows you to get your application ready for upcoming major versions of dependencies. 

#### LOG_LEVEL
Logging levels. Defaults to `debug`.

### DB 
#### DB_CONNECTION  - Database connection name
Here you may specify which of the database connections below you wish to use as your default connection for all database work. Of course you may use many connections at once using the Database library. Values can be `sqlite`, `mysql`, `pgsql`, `sqlsrv`. If you need to connect to a different database, please check its documentation.

#### DB_HOST
URL used to connect to the database. For local databases and sqlite, use `http://localhost`.

#### DB_PORT
Port used by the database. Can be commented out when using sqlite. Defaults to `3306`.

#### DB_DATABASE
Database name. Can be commented out when using sqlite. Default is `Laravel`.

#### DB_USERNAME and DB_PASSWORD
Database user credentials. Can be commented out when using sqlite. This may or not coincide with the current user credentials. Proceed with caution.

### GOOGLE_API
Used to communicate with the Google PageSpeed API
#### GOOGLE_API_KEY
API key. This variable is blank by default. To generate a key, please go to [Get Started with the PageSpeed Insights API - Google for Developers](https://developers.google.com/speed/docs/insights/v5/get-started)

#### GOOGLE_API_URL
API endpoint url. Defaults to `https://www.googleapis.com/pagespeedonline/v5/runPagespeed`.

## Running locally
For local development, run `php artisan serve` to run just the local server.

## Screenshots
* Home page
![Home page](/screenshots/Run%20metric%20page.png)

* Validation error message
![Validation error message](/screenshots/Validation%20fail%20message.png)

* Showing metrics
![Metrics results](/screenshots/Results%20page.png)

* Saved metric runs
![Metrics history page](/screenshots/Metric%20history%20page.png)
