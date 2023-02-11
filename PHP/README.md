# PHP Teste

   - Install database 
   - Configure the connection on "Config/Database.php"
   - run php -S localhost

## API Routes
    - yourdomain/api/*

### USERS 
    [GET] users/ - Retrieve all users stored
    [GET] users/{user_id} - Retrieve all data for user
    [POST] users/create - Store user - (ex. 1)
    [PUT] users/{user_id} - Update the user information  - (ex. 2)
    [DELETE] users/{user_id} - Delete user

    ##Ex: 01 Store user request

    Storing user with complete address
        {
            "name":"User teste",
            "email":"user.test@test.com",
            "password":"teste",
            "address":{
                "cep":"010101",
                "street":"street user",
                "number":"number",
                "complement":"0101 AB",
                "hood":"street hood"
            },
            "state":{
                "uf":"sp",
                "state":"São Paulo"
            },
            "city":{
                "city":"São Paulo"
            }
        }

    - Storing user with parcial address
        {
            "name":"User teste",
            "email":"user.test@test.com",
            "password":"teste",
            "address":{
                "cep":"010101",
                "street":"street user two",
                "number":"number",
                "complement":"0101 AB",
                "hood":"street hood"
            },
            "state": "1",
            "city": "1"
        }
    
    ##EX: 02 Update user request with address

        - Updating user 
            "data" : {
                "name":"User teste Update",
                "address":{
                    "cep":"010101",
                    "street":"street user updated",
                    "number":"number",
                    "complement":"0101 AB",
                    "hood":"street hood"
                },
            }

### ADDRESSES
    [GET] addresses/ - Retrieve all addresses stored
    [GET] addresses/{address_id} - Retrieve all data for address

### STATES
    [GET] states/ - Retrieve all states stored
    [GET] states/{state_id} - Retrieve all data for state

### CITIES 
    [GET] city/ - Retrieve all cities stored
    [GET] city/{city_id} - Retrieve all data for city
