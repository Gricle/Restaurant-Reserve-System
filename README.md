# Restaurant Food Reservation System API

## Overview

This is a RESTful API for a Restaurant Food Reservation System. It provides endpoints for managing users, foods, food reservations, and generating reports.

## API Endpoints

The API provides the following resource endpoints:

### Users
- `GET /api/users` - List all users
- `POST /api/users` - Create a new user
- `GET /api/users/{id}` - Get a specific user
- `PUT /api/users/{id}` - Update a user
- `DELETE /api/users/{id}` - Delete a user

### Foods
- `GET /api/foods` - List all foods
- `POST /api/foods` - Add a new food item
- `GET /api/foods/{id}` - Get a specific food item
- `PUT /api/foods/{id}` - Update a food item
- `DELETE /api/foods/{id}` - Delete a food item

### Reserve Food
- `GET /api/reserve_food` - List all food reservations
- `POST /api/reserve_food` - Create a new food reservation
- `GET /api/reserve_food/{id}` - Get a specific food reservation
- `PUT /api/reserve_food/{id}` - Update a food reservation
- `DELETE /api/reserve_food/{id}` - Delete a food reservation

### Reserves
- `GET /api/reserves` - List all reserves
- `POST /api/reserves` - Create a new reserve
- `GET /api/reserves/{id}` - Get a specific reserve
- `PUT /api/reserves/{id}` - Update a reserve
- `DELETE /api/reserves/{id}` - Delete a reserve

### Reports

- `GET /api/users-pdf` - Generate a PDF report of users
- `GET /api/reserved-foods-pdf` - Generate a PDF report of reserved foods in a period time
it contains 2 query params named start_date like 2024-07-01 and end_date like 2024-07-31

## Technologies Used

- PHP 8.2+
- Laravel 11.x
- Mysql
- Laravel Resource Controllers for API endpoints
- TCPDF or similar library for PDF generation

## Installation

1. Clone the repository
2. Setup Your Database connections in .env file
3. Run ```php artisan migrate``` command to run migration files 
4. Run ```php artisan db:seed``` command to seed the database 
5. Run ```php artisan serve``` command to run your app
And Start Sending HTTP Requests with PostMan or other tools