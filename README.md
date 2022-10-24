## Structure application

    - used konekt/concord as modules
    - used tymon/jwt-auth as jwt
    - used prettus/l5-repository as repository
    - Project has some moudles: 
        - Admin: Manage admin users
        - User: Manage users (customers)
        - Core: basic function, helper, customize and fix some issue of prettus/l5-repository
        - Auth: use to auth
        - Loan: the business logic
    - Mysql as database
    - Redis as cache

## Run source code
    cd <path_to_source>
    docker-compose up -d

## Github repo
https://github.com/huytt/aspire-test

## Postman API Documentation



## Features

-   Customer creates a loan
-   Admin approves the loan
-   Customer can only view self owned loan
-   Customer can repay the loan only once Admin approves the loan
-   Customer pays all the scheduled payment, the Loan is automatically marked as Paid