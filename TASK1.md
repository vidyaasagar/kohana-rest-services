# Database and API call design

-->Created Business,Customer and Staff tables in Database as follows

Business->id(primary Key), name, description, location
sample data in table:
  [{     "id": 1,
        "name": "omnify",
        "description": "A software Company",
        "location": "Bangalore"
  },
  {     "id": 2,
        "name": "omnify Mobile Apps",
        "description": "A Mobile Apps software Company",
        "location": "Bangalore"
  }]

Customer->id(pk), email, phone_no, business_id(fk)(references 'id' from business table)
sample data in table:
    [{   "id":1,
        "name": "trendysoft",
        "email": "trendy@soft.com",
        "phone_no": "1235467890",
        "business_id":"1"
    },
    {
        "name": "CustMicrosoft",
        "email": "cust@microsoft.com",
        "phone_no": "1234567890",
        "business_id":"1"
    },
    {
        "name": "technotrends1",
        "email": "tech1@trends.com",
        "phone_no": "1234567890",
        "business_id":"2"
    }]

Staff->id(pk), email, phone_no, business_id(fk)(references 'id' from business table)
sample data in the table:
[
    {
        "name": "sam",
        "email": "sam@microsoft.com",
        "phone_no": "1234567890",
        "business_id":"1"
    },
    {
        "name": "ram",
        "email": "ram@omnify.com",
        "phone_no": "1235467590",
        "business_id":"1"
    },
    {
        "name": "ramu",
        "email": "ramu@omnify.com",
        "phone_no": "1235467591",
        "business_id":"2"
    }
]

API Call Design:

1)List All customers of a business
Method: GET
parameter:id=1(id of business omnify)
URL: http://localhost/rest_services_kohana/index.php/v1/customer?id=1

output:
[{       
        "name": "trendysoft",
        "email": "trendy@soft.com",
        "phone_no": "1235467890"        
    },
    {
        "name": "CustMicrosoft",
        "email": "cust@microsoft.com",
        "phone_no": "1234567890"
    }
]

2)List All the staff of a business
Method:GET
parameter:id=1(id of business omnify)
Url: http://localhost/rest_services_kohana/index.php/v1/staff?id=1

output:
[
    
    {
        "name": "sam",
        "email": "sam@omnify.com",
        "phone_no": "1234567890"
    },
    {
        "name": "ram",
        "email": "ram@omnify.com",
        "phone_no": "1235467590"
    },
    {
        "name": "sagar",
        "email": "sagar@omnify.com",
        "phone_no": "1235467591"
    }
]

3)Find out if a particular person is a customer of a business
Method:GET
parameters:id=1(id of business omnify),check_customer(id of a customer)
Url: http://localhost/kohana_rest_services/index.php/v1/customer?id=1&check_customer=1
 
output:

{
    "message": "trendysoft Is a customer"
}

4)Find out if a particular person is a staff of a business
Method:GET
Url: http://localhost/kohana_rest_services/index.php/v1/staff?id=1&check_staff=3
parameters:id=1(id of business omnify),check_staff(id of a staff)

 
output:

{
    "message": "ramu Is a staff"
}

5)Edit basic info of a staff 
Method:PUT
Url:http://localhost/kohana_rest_services/index.php/v1/staff?id=1&name=sam&email=sam@omnify.com&business_id=1&phone_no=1234598760

query parameters: id=1,name=sam,email=sam@omnify.com,business_id=1,phone_no=1234598760

output:

{
    "staff": {
        "id": "1",
        "name": "sam",
        "message": "successfully updated"
    }
}

6)Edit basic info of customer
Method:PUT
Url:http://localhost/kohana_rest_services/index.php/v1/customer?id=2&business_id=1&phone_no=1234598762
query parameters:id=2&business_id=1&phone_no=1234598762

output:
{
    "customer": {
        "id": "2",
        "name": "CustMicrosoft",
        "message": "successfully updated"
    }
}