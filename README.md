# P8-ToDoAndCo

Improvement and documentation of an existing project ToDo & Co.

## Installation
1. Clone or download the GitHub repository to the desired folder:
````
    git clone https://github.com/Marc-Alban/ToDoList.git
````
2. Configure your environment variables such as the database connection in the local .env.' file that must be created at the root of the project by making a copy of the . env.' file and the connection to the test database in the . env.test' file.

3. Download and install project dependencies with [Composer](https://getcomposer.org/download/):
````
    composer install
```
Create the database if it does not already exist, type the command below in the project directory:
````
    php bin/console doctrine:database:create
````
5. Create the different tables in the database by applying the migrations:
````
    php bin/console doctrine:migrations:migrate
````
6. (Optional) Install the fixtures to have a demo of dummy data in development:
````
    php app/console doctrine:fixtures:load
````
7. Congratulations the project is installed correctly, you can now start using it as you wish!