1. Setup Kohana MVC framework (https://kohanaframework.org/) on a LAMP stack.
2. Install the REST API module for Kohana ( https://github.com/SupersonicAds/kohana-restful-api)
3. Use Kohana’s default Auth module and ORM module to setup the authentication module
4. Create API end point for the following Signup, Login, Create User Profile (After Login), View User Profile (After Login)

The API endpoints that are behind the authentication should be authenticated with a User Token.

Notes/Log
1. Downloaded the framework and extracted files
2. in application/bootstarp.php uncommented Cookie::$salt and assigned some some random text
3. Changed base url to rest_services_kohana in application/bootstarp.php
4. Downloaded the zip from https://github.com/SupersonicAds/kohana-restful-api and copied zip folder to modules folder and extracted it and renamed the folder to rest.
5. Enabled the following modules (By uncommenting:bootstarp.php)
-auth
-orm
-database
6. Enabled the REST API Module by adding the following line to Kohana::modules in bootstarp.php

'rest'        => MODPATH.'rest',        // Rest API Module

7. Created Task database in mysql using PHPMYADMIN
- Also executed queries in modules/orm/auth-shema-mysql.php

8. override modules/database/config/database.php to application/config/
-Also changed default connection type to MySQLi and gave hostname,username,passoword accordingly

9. override modules/auth/config/auth.php to application/config/
-Also changed the driver to orm and given hash key

10. Created API end point for the following Signup, Login, Create User Profile (After Login), View User Profile (After Login)


11.POSTMAN Collection

Signup

Method: POST
Url: http://localhost/kohana_rest_services/index.php/v1/signup?
parameters:username=sam1&email=sam1@live.com&password=123456

Login

Method: GET


Url: http://localhost/kohana_rest_services/index.php/v1/user?
parameter:apiKey=18c244afc5370fa64064abfedc14fdfe1d1a6229

Updating User

Mehtod:PUT

Url:http://localhost/kohana_rest_services/index.php/v1/signup?
parameters:apiKey=39e7598676e6721a06a0c2c64abba77cefeb0df4&email=admin2@live.com


