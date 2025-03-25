# API Platform project
## Contributors

- [Quentin Garnier](https://github.com/F1N3X)
- [Pierric Letard](https://github.com/Mrpierrouge)

## Description

This project is a veterinary clinic management API built with Symfony and API Platform. It provides a REST API to manage veterinary clinic operations.

## Installation

1. Clone the repository
2. Install dependencies with `composer install`
3. Create the database with `php bin/console doctrine:database:create`
4. Run migrations with `php bin/console doctrine:migrations:migrate`
5. Load fixtures with `php bin/console doctrine:fixtures:load`
6. Start the server with `symfony server:start`


## Usage

For some endpoints, you need to be authenticated. You can authenticate by sending a POST request to `/api/auth` with the following body:

```json
{
    "identifiant": "admin",
    "password": "admin"
}
```

This will return a JWT token that you can use to authenticate in the API by adding an `Authorization` header with the auth type `Bearer Token` and the token as the value.

#### Endpoints
The API provides the following endpoints:

### Users
- `GET /api/users`:
    - Returns all users
    - requires ROLE_DIRECTOR
    
- `GET /api/users/{id}`:
    - Returns a single user
    - requires ROLE_DIRECTOR

- `POST /api/users`:
    - Returns the created user resource with status code 201
    - Example request body:
        ```json
        {
            "identifiant" : "Tom@gmail.com",
            "plainPassword" : "123soleil",
            "roles" :[
                "ROLE_VETERINARIAN"
            ],
            "nom" : "Black",
            "prenom" : "Jack"
        }
        ```
    - Requires user details in the request body
    - requires ROLE_DIRECTOR

- `PATCH /api/users/{id}`:
    - Returns the updated user resource
    - Example request body:
        ```json
        {
            "identifiant": "string",
            "roles": [
                "string"
            ],
            "nom": "string",
            "prenom": "string",
            "plainPassword": "string"
        }
        ```
    - Supports JSON Merge Patch format
    - Requires user ID
    - requires ROLE_DIRECTOR
    - prevent user to change other user's password
    

- `DELETE /api/users/{id}`: Delete a user
    - Requires user ID
    - requires ROLE_DIRECTOR
    - Returns status code 204 (No Content) on success