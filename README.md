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


API Endpoints

All endpoints are authenticated using Sanctum and are under the /api/v1 route prefix.

1. Add Team Availability

Method: POST

Endpoint: /v1/teams/{id}/availability

Description: Adds a recurring weekly availability schedule for a specific team.

Authentication: Required.

Request Body Example:

{
"day_of_week": "monday",
"start_time": "09:00",
"end_time": "17:00"
}

2. Generate Available Slots

Method: GET

Endpoint: /v1/teams/{id}/generate-slots

Description: Returns a list of available slots for a given team, based on its weekly availability and existing bookings.

Authentication: Required.

Query Parameters:

from: The start date (e.g., 2025-06-01)

to: The end date (e.g., 2025-06-07)

3. Create a New Booking

Method: POST

Endpoint: /v1/bookings

Description: Creates a new booking. It checks for time conflicts before saving.

Authentication: Required.

Request Body Example:

{
"team_id": 1,
"start_time": "2025-06-02 09:00:00",
"end_time": "2025-06-02 10:00:00"
}

4. List Bookings

Method: GET

Endpoint: /v1/bookings

Description: Returns a list of all bookings for the authenticated user.

Authentication: Required.

5. Cancel a Booking

Method: DELETE

Endpoint: /v1/bookings/{id}

Description: Cancels a specific booking.

Authentication: Required.

