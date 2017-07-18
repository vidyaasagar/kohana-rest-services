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

10. 
11. 
<code>
CREATE TABLE IF NOT EXISTS `api_tokens` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_agent` varchar(40) NOT NULL,
  `token` varchar(40) NOT NULL,
  `created` int(10) UNSIGNED NOT NULL,
  `expires` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `uniq_token` (`token`),
  KEY `fk_user_id` (`user_id`),
  KEY `expires` (`expires`)
)
</code>