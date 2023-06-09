# pje - PHP Jquery UI Editor

Client and server side library of simple functions in JQUERY UI and PHP for editing rows of dynamic data tables (datagrid) generated by a Postgresql database. The library includes all functions of a CRUD application (create, retrieve, update, delete). The library also includes functions for pagination, column sorting, number of lines per page, export to file. Bootstrap is used for the front end. You can export the result in an excel table, csv or text with a Jquery module.

The editing functions are inspired by the blog [PHP Ajax Crud using JQuery UI Dialog][8] from [Weblesson][9]

![image](https://user-images.githubusercontent.com/24400013/232899941-93e4c8fd-f55a-40e8-989b-3c061eded5f0.png)
![image](https://user-images.githubusercontent.com/24400013/232901912-4ccf9840-f7b6-4a20-a20d-2cf05d7a8088.png)
![image](https://user-images.githubusercontent.com/24400013/232902025-6b71c2cc-d561-4d5a-9d1f-735966b05976.png)
![image](https://user-images.githubusercontent.com/24400013/232902106-dd795234-f55b-4546-92db-9fec946364e2.png)
![image](https://user-images.githubusercontent.com/24400013/232902252-7b098361-b4f4-4e02-b9b8-5e967dddf219.png)

Requirements
------------

  * PHP 7.2.9 or higher;
  * pdo_pgsql PHP extension enabled in php.ini;
  * Postgresql standalone OR Docker-compose

Installation
------------

Verify that you have installed, depending on your environment, [docker-compose][1] OR [postgresql][2], [npm][4], [yarn][5], [nodejs][6] and [git][7].

Verify that you have PHP installed : `sudo apt-get install php` on linux or, for windows, use php already included in [xampp][3].
If you have Windows, do not forget to indicate in the environment variable PATH, 
the path to access php.exe (for example, C:\xampp\php).

run these linux commands (password : test):

```bash
sudo su postgres
psql
CREATE DATABASE test
    WITH 
    OWNER = postgres
    ENCODING = 'UTF8'
    CONNECTION LIMIT = -1;
CREATE USER test WITH
  LOGIN
  NOSUPERUSER
  INHERIT
  NOCREATEDB
  NOCREATEROLE
  NOREPLICATION;
ALTER ROLE test with password 'test';
ALTER USER test with password 'test';
REVOKE ALL ON DATABASE test FROM public;
GRANT ALL ON DATABASE test TO test;        
exit
cd /var/www/html
sudo git clone https://github.com/coyote333666/pje pje
cd pje
psql -f script.sql -U test
```
Install dependencies:

```bash
cd /var/www/html
sudo yarn add jquery-ui
sudo npm install tableexport
sudo yarn add bootstrap
```

Then access the application in your browser at the given URL (localhost/pje).

[1]: https://docs.docker.com/compose/install/
[2]: https://www.postgresql.org/
[3]: https://www.apachefriends.org/index.html
[4]: https://www.npmjs.com/
[5]: https://yarnpkg.com/
[6]: https://nodejs.org/en/
[7]: https://git-scm.com/
[8]: https://www.webslesson.info/2018/03/php-ajax-crud-using-jquery-ui-dialog.html
[9]: https://www.webslesson.info/
