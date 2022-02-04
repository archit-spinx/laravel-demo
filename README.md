
#Laravel Learning

## **Setup Laravel Using Composer**

    composer create-project --prefer-dist laravel/laravel:^7.0  <Project Name>
    
    php artisan serve
    
    npm install [ require minimum v12.14.0 ]
    
    npm run dev
    
    npm run watch
    
    php artisan serve
    
    Configure Login / Registration
    
    composer require laravel/ui
    
    php artisan ui bootstrap –auth
    
    npm run watch
    
    php artisan serve



## **Database Configuration**

Create Database in PHPMyAdmin.
Open .env file

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=laravel
    DB_USERNAME=root
    DB_PASSWORD=****(Set based on your database configuration)

Change your details with the above code in the .env file.
After Done all the above things.
Run `php artisan migrate` 

## **Create Controller**

    php artisan make:controller <controller_name>

## **Create Model**

    php artisan make:model <model_name>

 

## **Convert Image path to URL and did it to accessible**

    php artisan storage:link
    
    URL::asset(uploads/'.$fileName)


## **How To add a page into a router**

Go to the routes directory located in the root folder. You get there a web.php file and add a route for a page.

**For Example:** 

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');