# Code Refactoring

--> Created the controller Main.php so that we can have only one controller that delegates to the data access methods in specific models
    based on the api requests.


# Modified the Database
Business table sample data
 { 
        "id": 1,
        "name": "omnify",
        "description": "A software Company",
        "location": "Bangalore"
        "code":"omni"
      }

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

CREATE TABLE `business` (
 `id` int(12) NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 `description` text NOT NULL,
 `location` varchar(255) NOT NULL,
 PRIMARY KEY (`id`)
);
CREATE TABLE `customer` (
 `id` int(12) NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 `email` varchar(255) NOT NULL,
 `phone_no` varchar(255) NOT NULL,
 `business_id` int(12) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `business_customer_fk` (`business_id`),
 CONSTRAINT `business_customer_fk` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`)
) ;
CREATE TABLE `staff` (
 `id` int(12) NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 `email` varchar(255) NOT NULL,
 `phone_no` varchar(255) NOT NULL,
 `business_id` int(12) DEFAULT NULL,
 PRIMARY KEY (`id`),
 KEY `business_staff_fk` (`business_id`),
 CONSTRAINT `business_staff_fk` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`)
); 

ALTER TABLE `business` ADD `code` VARCHAR(10) NOT NULL AFTER `location`, ADD UNIQUE `business_code` (`code`);

</code>



# For searching based on business name

Method: GET

Url: http://localhost/kohana_rest_services/index.php/v1/main?main=business&search=Omnify

![Alt text](/public/images/bname.png?raw=true "bname")


# To Get all business

Method: GET
				
Url: http://localhost/kohana_rest_services/index.php/v1/main?main=business

![Alt text](/public/images/allBusiness.png?raw=true "allBusiness")

# To create a business

Method: POST

Url: http://localhost/kohana_rest_services/index.php/v1/main?main=business&name=ThinkDesign&description=S/w Company&location=hyderabad&code=ThinkD

![Alt text](/public/images/createBusiness.png?raw=true "createBusiness")

# To create a staff

Method: POST

Url: http://localhost/kohana_rest_services/index.php/v1/main?main=staff&name=sam&phone_no=1700297988&email=ggg@l.com&business_id=11

![Alt text](/public/images/createStaff.png?raw=true "createStaff")

# To create a customer

Method: POST

Url: http://localhost/kohana_rest_services/index.php/v1/main?main=customer&name=ram&phone_no=1900297988&email=gggi@live.com&business_id=11

![Alt text](/public/images/createCust.png?raw=true "createCust")

# To get all customers based on business code

Method: GET

Url: http://localhost/kohana_rest_services/index.php/v1/main?main=customer&code=MS

![Alt text](/public/images/bcode.png?raw=true "bcode")


# To get all customers based on business id

Method: GET

Url: http://localhost/kohana_rest_services/index.php/v1/main?main=customer&id=1

![Alt text](/public/images/bid.png?raw=true "bid")


# To check whether a customer is of particular business based on id of business

Method: GET

Url: http://localhost/kohana_rest_services/index.php/v1/main?main=customer&check_customer=3&id=11

![Alt text](/public/images/checkCust.png?raw=true "checkCust")



# To check whether a customer is of particular business based on code of business 

Method: GET

Url: http://localhost/kohana_rest_services/index.php/v1/main?main=customer&check_customer=3&code=Omni


![Alt text](/public/images/checkCust1.png?raw=true "checkCust1")





