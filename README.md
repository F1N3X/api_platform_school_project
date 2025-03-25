# API Platform project
## Contributors

- [Quentin Garnier](https://github.com/F1N3X)
- [Pierric Letard](https://github.com/Mrpierrouge)

## Description

This project is a veterinary clinic management API built with Symfony and API Platform. It provides a REST API to manage veterinary clinic operations.

## Installation

1. Clone the repository
2. copy the `.env` file to `.env.local` and set the `DATABASE_URL` variable to your database configuration
3. Install dependencies with `composer install`
4. Create the database with `php bin/console doctrine:database:create`
5. Run migrations with `php bin/console doctrine:migrations:migrate`
6. Load fixtures with `php bin/console doctrine:fixtures:load`
7. Start the server with `symfony server:start`
8. Remove the User POST role restriction in the `src/Entity/User.php` file
9. Insert the first user with the `ROLE_DIRECTOR` role
10. Add the restriction back

```php
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
```


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
    - Set Content-Type header to `application/merge-patch+json`
    - Requires user ID
    - requires ROLE_DIRECTOR
    - prevent user to change other user's password
    

- `DELETE /api/users/{id}`: Delete a user
    - Requires user ID
    - requires ROLE_DIRECTOR
    - Returns status code 204 (No Content) on success


### Clients
- `GET /api/clients`:
    - Returns all clients
    - Requires ROLE_DIRECTOR or ROLE_VETERINARIAN or ROLE_ASSISTANT

- `POST /api/clients`:
    - Creates a new client
    - Returns the created client resource with status code 201
    - Example request body:
        ```json
        {
            "nom": "string",
            "prenom": "string",
            "email": "string"
        }
        ```
    - Requires ROLE_DIRECTOR or ROLE_VETERINARIAN or ROLE_ASSISTANT


### Medias
- `GET /api/media`:
    - Returns all media files
    - Requires ROLE_DIRECTOR or ROLE_VETERINARIAN or ROLE_ASSISTANT

- `POST /api/media`:
    - Creates a new media file
    - Returns the created media resource with status code 201
    - Example request body:
        ```form-data
        {
            "file": "file"
        }
        ```
    - Requires ROLE_DIRECTOR or ROLE_VETERINARIAN or ROLE_ASSISTANT


### Animals
- `GET /api/animals`:
    - Returns all animals
    - Requires ROLE_DIRECTOR or ROLE_VETERINARIAN or ROLE_ASSISTANT

- `GET /api/animals/{id}`:
    - Returns a single animal
    - Requires ROLE_DIRECTOR or ROLE_VETERINARIAN or ROLE_ASSISTANT

- `POST /api/animals`:
    - Creates a new animal
    - Returns the created animal resource with status code 201
    - Example request body:
        ```json
        {
            "nom": "string",
            "espece": "string",
            "bithdate": "2000-12-01T00:00:00.000Z",
            "photo": "/api/medias/{id}",
            "proprietaire": "/api/clients/{id}"
        }
        ```
    - Requires ROLE_DIRECTOR or ROLE_VETERINARIAN or ROLE_ASSISTANT


### Traitements
- `GET /api/traitements`:
    - Returns all treatments
    - Requires ROLE_VETERINARIAN

- `GET /api/traitements/{id}`:
    - Returns a single treatment
    - Requires ROLE_VETERINARIAN

- `POST /api/traitements`:
    - Creates a new treatment
    - Returns the created treatment resource with status code 201
    - Example request body:
        ```json
        {
            "nom": "string",
            "description": "string",
            "prix": float,
            "durée": "P3M14D"
        }
        ```
    - Requires ROLE_VETERINARIAN

- `PATCH /api/traitements/{id}`:
    - Updates an existing treatment
    - Returns the updated treatment resource
    - Example request body:
        ```json
        {
            "nom": "string",
            "description": "string",
            "prix": float,
            "durée": "P3M14D"
        }
        ```
    - Set Content-Type header to `application/merge-patch+json`
    - Requires ROLE_VETERINARIAN

- `DELETE /api/traitements/{id}`:
    - Deletes a treatment
    - Returns status code 204 (No Content) on success
    - Requires ROLE_VETERINARIAN


### Consultations
- `GET /api/consultations`:
    - Returns all consultations
    - Requires ROLE_DIRECTOR or ROLE_VETERINARIAN or ROLE_ASSISTANT

- `GET /api/consultations/{id}`:
    - Returns a single consultation
    - Requires ROLE_VETERINARIAN or ROLE_ASSISTANT

- `POST /api/consultations`:
    - Creates a new consultation
    - Returns the created consultation resource with status code 201
    - Example request body:
        ```json
        {
            "date": "2000-12-01T00:00:00.000Z",
            "motif": "string",
            "animal": "/api/animals/{id}",
            "assistant": "api/users/{id}",
            "veterinaire": "api/users/{id}",
            "statut": "programmé",
            "traitements": [
                "/api/traitements/{id}"
            ],
            "isPaid" : bool
        }
        ```
    - Requires ROLE_ASSISTANT or ROLE_VETERINARIAN
    - Status can be "programmé", "en cours", "terminé"

- `PATCH /api/consultations/{id}`:
    - Updates an existing consultation
    - Returns the updated consultation resource
    - Example request body:
        ```json
        {
            "date": "2000-12-01T00:00:00.000Z",
            "motif": "string",
            "animal": "/api/animals/{id}",
            "assistant": "api/users/{id}",
            "veterinaire": "api/users/{id}",
            "statut": "programmé",
            "traitements": [
                "/api/traitements/{id}"
            ],
            "isPaid" : bool
        }
        ```
    - Set Content-Type header to `application/merge-patch+json`
    - Requires ROLE_ASSISTANT or ROLE_VETERINARIAN
    - Status can be "programmé", "en cours", "terminé"