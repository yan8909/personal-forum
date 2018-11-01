# personal-forum

This project is built by using [Laravel](https://laravel.com/)  
The purpose of this project is to learn Laravel framwork by making a forum

## Main used package
- [Laravel](https://laravel.com/)
- [Carbon](https://github.com/mohd-isa/carbon)
- [startbootstrap-clean-blog](https://github.com/BlackrockDigital/startbootstrap-clean-blog)

## Feature
- Sign up
- Login
- admin and normal user
- Channel
- Post
- Reply

## Build setup
install XAMPP and put all file into X:/xampp/htdocs  
open the file X:\xampp\apache\conf\extra\httpd-vhosts.conf  
add these text at the bottom of the file
```
<VirtualHost *:80>
	ServerName personal-forum
	DocumentRoot "X:\xampp\htdocs\personal-forum\public"
</VirtualHost>  
```
open xampp control panel and start both Apache and MySQL  
create a new database at  
```
http://localhost/phpmyadmin
```
open .env file and edit DB_DATABASE to the database name you just created
```
DB_DATABASE=your database name
```
make migration
```
php artisan migrate
```
restart Apache and MySQL, link to [localhost](http://localhost) should work

