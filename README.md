# Wishlist API

A Laravel-based RESTful API for managing user wishlists with token-based authentication.

## Requirements

- PHP 8.4+
- Composer
- SQLite (default for testing) or MySQL/PostgreSQL

## Installation

1. **Clone and install dependencies:**
   ```bash
   composer install
   ```

2. **Environment setup:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Run migrations:**
   ```bash
   php artisan migrate
   ```

4. **Seed database with demo data:**
   ```bash
   php artisan db:seed
   ```
   
   **Demo Data Includes:**
   - 1 test user: `test@example.com` / `password`
   - 10 sample products (electronics and accessories)
   - 3 random products in test user's wishlist

## API Documentation

Base URL: `/api`

### Authentication

#### Register
Register a new user account.

```
POST /api/register
Content-Type: application/json

{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response (201):**
```json
{
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "2026-04-08T12:00:00.000000Z"
    },
    "meta": {
        "api_token": "1|abc123..."
    }
}
```

**Validation Errors (422):**
```json
{
    "message": "The name field is required.",
    "errors": {
        "name": ["The name field is required."],
        "email": ["The email must be a valid email address."]
    }
}
```

---

#### Login
Authenticate an existing user.

```
POST /api/login
Content-Type: application/json

{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "data": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "2026-04-08T12:00:00.000000Z"
    },
    "meta": {
        "api_token": "2|def456..."
    }
}
```

**Invalid Credentials (401):**
```json
{
    "message": "Invalid credentials"
}
```

---

#### Logout
Logout the authenticated user (revoke current token).

```
POST /api/logout
Authorization: Bearer {api_token}
```

**Response (200):**
```json
{
    "message": "Logged out successfully"
}
```

---

### API Token Usage

Include the `api_token` from login/register responses in subsequent requests:

```bash
# Login to get token
curl -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'

# Use token for authenticated requests
curl -X GET http://localhost/api/wishlist \
  -H "Authorization: Bearer {api_token}"
```

---

## Quick Demo

After seeding, test the API:

```bash
# 1. Login with demo user
curl -X POST http://localhost/api/login \
  -H "Content-Type: application/json" \
  -d '{"email":"test@example.com","password":"password"}'

# 2. List all products
curl http://localhost/api/products

# 3. Get wishlist (use token from step 1)
curl http://localhost/api/wishlist \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"

# 4. Add product to wishlist
curl -X POST http://localhost/api/wishlist/add \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{"product_id":5}'

# 5. Remove from wishlist
curl -X DELETE http://localhost/api/wishlist/remove \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Content-Type: application/json" \
  -d '{"product_id":5}'
```

---

### Products

#### List Products
Retrieve all products with pagination.

```
GET /api/products
```

**Query Parameters:**
- `page` (optional): Page number (default: 1)

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Product Name",
            "description": "Product description",
            "price": "99.99",
            "created_at": "2026-04-08T12:00:00.000000Z",
            "updated_at": "2026-04-08T12:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "per_page": 15,
        "total": 50,
        "last_page": 4,
        "next_page_url": "http://localhost/api/products?page=2",
        "prev_page_url": null
    }
}
```

---

### Wishlist

Requires authentication via `Authorization: Bearer {api_token}` header.

#### Get Wishlist
Retrieve the authenticated user's wishlist.

```
GET /api/wishlist
Authorization: Bearer {api_token}
```

**Response (200):**
```json
{
    "data": [
        {
            "id": 1,
            "name": "Product Name",
            "description": "Product description",
            "price": "99.99",
            "created_at": "2026-04-08T12:00:00.000000Z",
            "updated_at": "2026-04-08T12:00:00.000000Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "per_page": 15,
        "total": 1,
        "last_page": 1,
        "next_page_url": null,
        "prev_page_url": null
    }
}
```

**Unauthorized (401):**
```json
{
    "message": "Unauthenticated."
}
```

---

#### Add to Wishlist
Add a product to the authenticated user's wishlist.

```
POST /api/wishlist/add
Authorization: Bearer {api_token}
Content-Type: application/json

{
    "product_id": 1
}
```

**Response (201):**
```json
{
    "message": "Product added to wishlist"
}
```

**Already in Wishlist (409):**
```json
{
    "message": "Product already in wishlist"
}
```

---

#### Remove from Wishlist
Remove a product from the authenticated user's wishlist.

```
DELETE /api/wishlist/remove
Authorization: Bearer {api_token}
Content-Type: application/json

{
    "product_id": 1
}
```

**Response (200):**
```json
{
    "message": "Product removed from wishlist"
}
```

**Not Found (404):**
```json
{
    "message": "Product not found in wishlist"
}
```

---

## Testing

### Run All Tests
```bash
php artisan test
```

### Run Tests with Compact Output
```bash
php artisan test --compact
```

### Run Specific Test File
```bash
php artisan test tests/Feature/Api/AuthenticationTest.php
php artisan test tests/Feature/Api/ProductTest.php
php artisan test tests/Feature/Api/WishListTest.php
```

### Test Coverage

| Feature | Tests                             |
|---------|-----------------------------------|
| Authentication | Register, Login, Logout |
| Products | List                              |
| Wishlist | List, Add, Remove                 |

## Project Structure

```
app/
├── Http/
│   ├── Controllers/Api/
│   │   ├── AuthenticationController.php
│   │   ├── ProductController.php
│   │   └── WishListController.php
│   ├── Requests/
│   │   ├── LoginRequest.php
│   │   ├── RegisterRequest.php
│   │   └── WishListRequest.php
│   └── Resources/
│       ├── ProductResource.php
│       └── UserResource.php
└── Models/
    ├── Product.php
    ├── User.php
    └── WishList.php
database/
├── factories/
│   ├── ProductFactory.php
│   ├── UserFactory.php
│   └── WishListFactory.php
└── migrations/
routes/
└── api.php
tests/
└── Feature/Api/
    ├── AuthenticationTest.php
    ├── ProductTest.php
    └── WishListTest.php
```
