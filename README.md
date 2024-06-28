**Cushon Recruitment Scenario**

***Setup***

- This application requires docker to be installed in the local environment. It also relies on `make` for some helper commands.
  - Docker can be downloaded from https://www.docker.com/products/docker-desktop/
  - Make is used for some helper commands and can be downloaded from https://www.gnu.org/software/make/ or `sudo apt-get install make`. The `Makefile` with the commands can be found at in the project root folder.
- Download the source from github at https://github.com/ianthurbon/isa_application
- From the root directory run `make up` followed by `make first-time`

***Introduction***

I chose Slim 4 as the PHP framework for the solution. This was because of my familiarity with the framework having worked with it for the past 4 years and the timescale available for the solution. The solution could equally have been implemented in Symfony, Laravel or Yii. I added a standard docker and docker-compose file to include a PHP application container and a mysql container to store the data. I edited the docker file to include xdebug to aid development.

The Dockerfile can be found at `docker/Dockerfile` and the `docker-compose.yml` file is in the root directory for the project.

I used PHPStorm 2024.1 as my IDE with copilot turned off.

I have laid the code out in a hexagonal architecture format that lends itself to SOLID priinciples and makes the classes easy to find and follow. All entry points to the application are in the `src/Application` folder. All single responsibility domain functionality is in the `src/Domain` folder and all access to external services and databases are in the `src/Infrastucture` folder. Data Transfer Objects (DTO's) are used to move data through the layers.

Given the role was solely a backend role, I focused on creating an API application that would serve any frontend that could consume a REST API.

***Packages***

A package called `phinx` is installed to handle db migrations. 

A package called `dotenv` is installed to handle environment variables.

A package called `illuminate/database` is installed that allows the application to use the Eloquent ORM.

A package called `respect/validation`is installed to validate entry data.

A package called `mockery/mockery` is installed to assist with unit testing.

***Database***

The database is created and seeded with initial values when `make first-time` is executed. There are 6 tables:

`fund_type` - Stores the available investment funds that can be used within an ISA along with the current fund price.

`account_types`  - The different types of ISA accounts that are available to the user.

`users` - The retail account holders along with their NI number and api token.

`accounts` - The ISA accounts created by a user.

`fund_allocations` - The allocation of each fund within each account.

`account_transactions` - A ledger of the fund units bought and sold for a fund within an ISA account.

After `make first-time` is run, the database is seeded with two users, a fund type that corresponds to the Cushon Equities Fund and 3 account types that represent the 3 ISA types.

***Endpoints***

There are 10 endpoints to support the inital applications. When running locally the api can be accessed with the following url `http://127.0.0.1:89`.

**Fund Types**

- Get all available fund types.

```
GET /fund-types

# Example response
{
    "status_code": 200,
    "data": [
        {
            "id": 1,
            "name": "Cushon Equities Fund",
            "current_price": 12.3456
        }
    ]
}
```

**Account Types**

- Get all account types

```
GET /account-types

# Example response
{
    "status_code": 200,
    "data": [
        {
            "id": 1,
            "name": "Cushon ISA",
            "max_allowance": 20000
        },
        {
            "id": 2,
            "name": "Cushon Lifetime ISA",
            "max_allowance": 4000
        },
        {
            "id": 3,
            "name": "Cushon Junior ISA",
            "max_allowance": 9000
        }
    ]
}
```

**Users**

- Get all users

```
GET /users

# Example response
{
    "status_code": 200,
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "ni_number": "AB 12 34 56 C",
            "api_token": "my_secret_token"
        },
        {
            "id": 2,
            "name": "Jane Ray",
            "ni_number": "DE 34 56 78 F",
            "api_token": "my_secret_token2"
        }
    ]
}
```

- Get a single user.

```
GET /users/{id}

# Example response
{
    "status_code": 200,
    "data": {
        "id": 1,
        "name": "John Doe",
        "ni_number": "AB 12 34 56 C",
        "api_token": "my_secret_token"
    }
}
```

**Accounts**

These endpoints require  the HTTP Header `Account-Token` to provide authentication, see the Authentication section for more details.

- Create new account.  The account takes a single account type parameter and creates an account with 100% of the deposits being allocated to the Cushon Equities Fund.

```
POST /accounts
# Example request payload
{
    "type": 2   # ID for account type Cushon Lifetime ISA
}

# Example response
{
    "status_code": 200,
    "data": {
        "id": 4,
        "user": 1,
        "user_name": "John Doe",
        "type": 2,
        "account_type_name": "Cushon Lifetime ISA",
        "max_allowance": 4000,
        "fund_allocations": [
            {
                "fund_id": 1,
                "percentage_allocation": 100,
                "current_price": 12.3456
            }
        ],
        "transactions": null
    }
}
```

- Account deposit.  The url `id` parameter identifies the account and the deposit request takes a single `gbp_total` parameter to indicate the total amount deposited. The function automatically purchases units in the fund based on the fund current price, both the `deposit` and `buy` transactions can be seen in the `transactions` property in the response.

```
POST /accounts/{id}/deposit
# Example request payload
{
    "gbp_total": 100   # The amount in GBP deposited to the account.
}

# Example response
{
    "status_code": 200,
    "data": {
        "id": 4,
        "user": 1,
        "user_name": "John Doe",
        "type": 2,
        "account_type_name": "Cushon Lifetime ISA",
        "max_allowance": 4000,
        "fund_allocations": [
            {
                "fund_id": 1,
                "percentage_allocation": 100,
                "current_price": 12.3456
            }
        ],
        "transactions": [
            {
                "date": "2024-06-28T14:19:19.000000Z",
                "fund_id": null,
                "fund_current_price": null,
                "type": "deposit",
                "units": null,
                "gbp_total": "100.0000"
            },
            {
                "date": "2024-06-28T14:19:19.000000Z",
                "fund_id": 1,
                "fund_current_price": 12.3456,
                "type": "buy",
                "units": "8.1001",
                "gbp_total": "100.0000"
            }
        ]
    }
}
```

- Get all accounts

```
GET /accounts

# Example response
{
    "status_code": 200,
    "data": [
        {
            "id": 1,
            "user": 1,
            "user_name": "John Doe",
            "type": 1,
            "account_type_name": "Cushon ISA",
            "max_allowance": 20000,
            "fund_allocations": [
                {
                    "fund_id": 1,
                    "percentage_allocation": 100,
                    "current_price": 12.3456
                }
            ],
            "transactions": [
                {
                    "date": "2024-06-27T11:13:12.000000Z",
                    "fund_id": null,
                    "fund_current_price": null,
                    "type": "deposit",
                    "units": null,
                    "gbp_total": "20000.0000"
                },
                {
                    "date": "2024-06-27T11:13:12.000000Z",
                    "fund_id": 1,
                    "fund_current_price": 12.3456,
                    "type": "buy",
                    "units": "1620.0104",
                    "gbp_total": "20000.0000"
                }
            ]
        },
        {
            "id": 4,
            "user": 1,
            "user_name": "John Doe",
            "type": 2,
            "account_type_name": "Cushon Lifetime ISA",
            "max_allowance": 4000,
            "fund_allocations": [
                {
                    "fund_id": 1,
                    "percentage_allocation": 100,
                    "current_price": 12.3456
                }
            ],
            "transactions": [
                {
                    "date": "2024-06-28T14:19:19.000000Z",
                    "fund_id": null,
                    "fund_current_price": null,
                    "type": "deposit",
                    "units": null,
                    "gbp_total": "100.0000"
                },
                {
                    "date": "2024-06-28T14:19:19.000000Z",
                    "fund_id": 1,
                    "fund_current_price": 12.3456,
                    "type": "buy",
                    "units": "8.1001",
                    "gbp_total": "100.0000"
                }
            ]
        }
    ]
}
```

- Get all transactions. The url `id` parameter identifies the account for which the transactions should be returned.

```
GET /accounts/{id}/transactions

# Example response
{
    "status_code": 200,
    "data": [
        {
            "id": 7,
            "date": "2024-06-28 14:19:19",
            "user": 1,
            "account": 4,
            "fund": null,
            "transaction_type": "deposit",
            "units": null,
            "gbp_total": 100
        },
        {
            "id": 8,
            "date": "2024-06-28 14:19:19",
            "user": 1,
            "account": 4,
            "fund": 1,
            "transaction_type": "buy",
            "units": 8.1001,
            "gbp_total": 100
        }
    ]
}
```

- Get a single account. The url `id` parameter identifies the account

```
GET /accounts/{id}

# Example response
{
    "status_code": 200,
    "data": {
        "id": 4,
        "user": 1,
        "user_name": "John Doe",
        "type": 2,
        "account_type_name": "Cushon Lifetime ISA",
        "max_allowance": 4000,
        "fund_allocations": [
            {
                "fund_id": 1,
                "percentage_allocation": 100,
                "current_price": 12.3456
            }
        ],
        "transactions": [
            {
                "date": "2024-06-28T14:19:19.000000Z",
                "fund_id": null,
                "fund_current_price": null,
                "type": "deposit",
                "units": null,
                "gbp_total": "100.0000"
            },
            {
                "date": "2024-06-28T14:19:19.000000Z",
                "fund_id": 1,
                "fund_current_price": 12.3456,
                "type": "buy",
                "units": "8.1001",
                "gbp_total": "100.0000"
            }
        ]
    }
}
```

- Delete account. The url `id` parameter identifies the account

```
DELETE /accounts/{id}
```



***Authentication***

There is a simple authentication system where each user account has an `api_token` property that is passed in the `Account-Token` header for all requests to the `/accounts` endpoints to authenticate the user and ensure that the referenced account belongs to the user. Example curl request:

```
curl --location 'http://127.0.0.1:89/accounts/4' \
--header 'Account-Token: my_secret_token'
```



***Unit Tests***

Units test can be found in the `tests` directory in the project folder. For demonstation purposes tests have been completed for the `Accounts` and `Users` domain sections. These can be executed with the following command `make test` 

***Assumptions***

- There are three types of ISA accounts that can be available. Cushon ISA,  Lifetime ISA and Junior ISA.
- The maximum ISA investment is 20000GBP per user per year, 4000GBP for Lifetime ISA and 9000GBP for Junior ISA.
- When extra invetsment funds are added in the future, that a single account can split proportionally across multiple funds.
- The application assumes commission free fund trades.
- All deposits are automatically invested in the funds

***Enhancements***

- Endpoints to create and edit users could be added.
- The authentication is a simple token based mechanism. This would be replaced with a more robust solution such as OAuth or a package such as Sentinel for a production system.
- The `accounts` endpoint could be extended to support `withdrawals`
- The `current_price` value in the funds table is could updated periodically to reflect the account balance, this has not been implemented.
- Further integration and unit tests should be added to the appliction and infrastructure layers
- Add a package such as [zircote/swagger-php](https://github.com/zircote/swagger-php) to improve api documentation and user testing.





