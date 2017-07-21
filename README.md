# Movie Database Application


### Installation

```sh
$ git clone https://github.com/matkodjipalo/movie_base.git
$ cd movie_base/
$ composer install
```
During the composer installation process, you will be asked to provide `database_host`, `database_port`, `database_name`... and some other parameters. You can enter them during installation or leave it for later when you can manually modify parameters inside `app/config/parameters.yml`

After you have specified all the database parameter you'll need to create a database for the application.
```sh
$ php bin/console doctrine:database:create
```

If the database was successfully created - you can create table structure:
```sh
$  php bin/console doctrine:migrations:migrate
```

Last step is to run PHP built in server. Position yourself inside root folder of the application and run:
```sh
$   php bin/console server:run
```

Then visit URL that is listed inside the terminal (it should be something like  http://127.0.0.1:8000) and start to use Movie Database application.