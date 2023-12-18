Prerequisite:
	1. PHP 8.2
	2. Apache2 server
	3. Mysql 8.0
	4. Composer 2.6

How to install:
	1. Download todo.zip and extract it and get in the main directory of the project.
	2. connect your mysql database by entering username, password and database name
	4. Run the following commands:

		sudo chmod -R 777 storage
		composer install
		php artisan key:generate
		php artisan cache:clear
		php artisan config:cache
		php artisan migrate

	5. I have also attached the database dump if migrations doesn't work. You can find it in database/todo.sql


How to run:
	1. After everything is done, access the public directory of this project from your browser which will hit index.php and the project should run.



Contact in case anything doesn't work.
Suhail Husain
8532080060
suhail.husain111@gmail.com