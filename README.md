# APESTask Project

## 🚀 How to Run the Project

1. Clone the repository:
   ```bash
    git clone <your-repo-url>
   cd APESTask
Install dependencies:

 ```bash
    composer install
Copy .env.example to .env and update your environment variables (DB, etc.):
```
 ```bash
    cp .env.example .env
Generate application key:
```

 ```bash
    php artisan key:generate
Run migrations and seeders:
```

 ```bash  
    php artisan migrate --seed
Start the server:
```

```bash
  php artisan serve
🔑 Authentication
````
Register
Endpoint:
POST /api/register

Body:
````bash
  json
{
"name": "Ahmed",
"email": "ahmed@example.com",
"password": "password",
"password_confirmation": "password",
"tenant_name": "MyCompany"
}
````
Response:

```bash
  json

{
"message": "User and Tenant registered successfully.",
"user": {
"id": 1,
"name": "Ahmed",
"email": "ahmed@example.com",
"tenant": {
"id": 1,
"name": "MyCompany"
},
"roles": [
{
"id": 1,
"name": "admin"
}
]
},
"token": "your_generated_token_here"
}
```
Login
Endpoint:
POST /api/login

Body:
 ```bash
    json

{
"email": "ahmed@example.com",
"password": "password"
}
```
Response:

 ```bash
    json
{
"message": "Login successful.",
"user": {
"id": 1,
"name": "Ahmed",
"email": "ahmed@example.com",
"tenant": {
"id": 1,
"name": "MyCompany"
},
"roles": [
{
"id": 1,
"name": "admin"
}
]
},
"token": "your_generated_token_here"
}

```

