## Database Schema (Updated)

This document describes the current database schema, including tables, key fields, and relationships. It includes recent changes such as the `users.is_active` flag for customer activation/deactivation and the updated `orders.status` enum.

### Entities and Relationships

```mermaid
erDiagram
    USERS ||--o{ ORDERS : places
    USERS ||--o{ CARTS : has

    CARTS ||--o{ CART_ITEMS : contains
    PRODUCTS ||--o{ CART_ITEMS : appears_in

    ORDERS ||--o{ ORDER_ITEMS : contains
    PRODUCTS ||--o{ ORDER_ITEMS : sold_as

    ORDERS ||--|| PAYMENTS : has_one
    ORDERS ||--|| DELIVERIES : has_one

    CATEGORIES ||--o{ PRODUCTS : groups

    USERS {
        bigint id PK
        string name
        string email UNIQUE
        timestamp email_verified_at NULL
        boolean is_active DEFAULT true
        string password
        timestamps
    }

    CATEGORIES {
        bigint id PK
        string name
        text description NULL
        timestamps
    }

    PRODUCTS {
        bigint id PK
        string dish_name
        text description NULL
        decimal price(10,2)
        bigint category_id FK -> CATEGORIES.id
        string image_path NULL
        boolean is_available DEFAULT true
        timestamps
    }

    ORDERS {
        bigint id PK
        bigint user_id FK -> USERS.id
        enum status('pending','confirmed','preparing','ready','delivered','cancelled') DEFAULT 'pending'
        decimal total_amount(10,2)
        timestamps
    }

    ORDER_ITEMS {
        bigint id PK
        bigint order_id FK -> ORDERS.id
        bigint product_id FK -> PRODUCTS.id
        integer quantity
        decimal price(10,2)
        timestamps
    }

    CARTS {
        bigint id PK
        bigint user_id FK -> USERS.id
        timestamps
    }

    CART_ITEMS {
        bigint id PK
        bigint cart_id FK -> CARTS.id
        bigint product_id FK -> PRODUCTS.id
        integer quantity
        timestamps
    }

    PAYMENTS {
        bigint id PK
        bigint order_id FK -> ORDERS.id UNIQUE
        enum payment_method('cod','gcash','card')
        decimal amount(10,2)
        enum status('pending','paid','failed') DEFAULT 'pending'
        string proof_path NULL
        timestamps
    }

    DELIVERIES {
        bigint id PK
        bigint order_id FK -> ORDERS.id UNIQUE
        string address
        enum status('pending','shipped','delivered') DEFAULT 'pending'
        date delivery_date NULL
        timestamps
    }
```

### Table Details

- Users (`users`)
  - Fields: `id`, `name`, `email`, `email_verified_at`, `is_active` (NEW), `password`, `created_at`, `updated_at`
  - Relationships: has many `orders`, has one `cart`

- Categories (`categories`)
  - Fields: `id`, `name`, `description`, timestamps
  - Relationships: has many `products`

- Products (`products`)
  - Fields: `id`, `dish_name`, `description`, `price`, `category_id`, `image_path`, `is_available`, timestamps
  - Relationships: belongs to `category`, has many `order_items`, has many `cart_items`

- Orders (`orders`)
  - Fields: `id`, `user_id`, `status` (enum updated to: pending, confirmed, preparing, ready, delivered, cancelled), `total_amount`, timestamps
  - Relationships: belongs to `user`, has many `order_items`, has one `payment`, has one `delivery`

- Order Items (`order_items`)
  - Fields: `id`, `order_id`, `product_id`, `quantity`, `price`, timestamps
  - Relationships: belongs to `order`, belongs to `product`

- Carts (`carts`)
  - Fields: `id`, `user_id`, timestamps
  - Relationships: belongs to `user`, has many `cart_items`

- Cart Items (`cart_items`)
  - Fields: `id`, `cart_id`, `product_id`, `quantity`, timestamps
  - Relationships: belongs to `cart`, belongs to `product`

- Payments (`payments`)
  - Fields: `id`, `order_id`, `payment_method` (cod|gcash|card), `amount`, `status` (pending|paid|failed), `proof_path` (optional), timestamps
  - Relationships: belongs to `order`

- Deliveries (`deliveries`)
  - Fields: `id`, `order_id`, `address`, `status` (pending|shipped|delivered), `delivery_date` (optional), timestamps
  - Relationships: belongs to `order`

### Notes

- `users.is_active` controls whether a customer account is active. The Customers page toggles this flag.
- `orders.status` enum set is aligned with the UI: `pending`, `confirmed`, `preparing`, `ready`, `delivered`, `cancelled`.
- `payments.order_id` and `deliveries.order_id` are one-to-one with `orders`.
- Image files are stored under `storage/app/public/menu-images` with DB path `menu-images/<filename>`.

### Suggested Indexes (optional)

- `orders`: index on `(user_id, status, created_at)`
- `order_items`: index on `(order_id)`, `(product_id)`
- `cart_items`: index on `(cart_id)`, `(product_id)`
- `products`: index on `(category_id)`, `(is_available)`

# Online Karinderya Database Schema

## Overview
This document outlines the complete database schema for the Online Karinderya application, including all tables, relationships, and constraints.

## Database Tables

### 1. **users** Table
**Purpose**: Store user accounts (customers and admins)

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique user identifier |
| name | varchar(255) | NOT NULL | User's full name |
| email | varchar(255) | UNIQUE, NOT NULL | User's email address |
| email_verified_at | timestamp | NULLABLE | Email verification timestamp |
| password | varchar(255) | NOT NULL | Hashed password |
| is_admin | boolean | DEFAULT false | Admin status flag |
| remember_token | varchar(100) | NULLABLE | Remember me token |
| created_at | timestamp | NOT NULL | Record creation time |
| updated_at | timestamp | NOT NULL | Record last update time |

### 2. **categories** Table
**Purpose**: Store food categories (e.g., Main Course, Desserts, Beverages)

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique category identifier |
| name | varchar(255) | NOT NULL | Category name |
| description | text | NULLABLE | Category description |
| created_at | timestamp | NOT NULL | Record creation time |
| updated_at | timestamp | NOT NULL | Record last update time |

### 3. **products** Table
**Purpose**: Store menu items/food products

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique product identifier |
| dish_name | varchar(255) | NOT NULL | Name of the dish |
| description | text | NULLABLE | Product description |
| price | decimal(10,2) | NOT NULL | Product price |
| is_available | boolean | NOT NULL | Availability status |
| is_featured | boolean | NULLABLE | Featured item flag |
| image_path | varchar(255) | NOT NULL | Product image file path |
| category_id | bigint | FOREIGN KEY → categories(id) | Category reference |
| created_at | timestamp | NOT NULL | Record creation time |
| updated_at | timestamp | NOT NULL | Record last update time |

### 4. **orders** Table
**Purpose**: Store customer orders

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique order identifier |
| user_id | bigint | FOREIGN KEY → users(id) | Customer reference |
| status | enum | DEFAULT 'pending' | Order status (pending, paid, shipped, delivered, cancelled) |
| total_amount | decimal(10,2) | NOT NULL | Total order amount |
| created_at | timestamp | NOT NULL | Record creation time |
| updated_at | timestamp | NOT NULL | Record last update time |

### 5. **order_items** Table
**Purpose**: Store individual items within an order

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique order item identifier |
| order_id | bigint | FOREIGN KEY → orders(id) | Order reference |
| product_id | bigint | FOREIGN KEY → products(id) | Product reference |
| quantity | integer | NOT NULL | Quantity ordered |
| price | decimal(10,2) | NOT NULL | Price at time of order |

### 6. **carts** Table
**Purpose**: Store user shopping carts

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique cart identifier |
| user_id | bigint | FOREIGN KEY → users(id) | User reference |
| created_at | timestamp | NOT NULL | Record creation time |
| updated_at | timestamp | NOT NULL | Record last update time |

### 7. **cart_items** Table
**Purpose**: Store items in user shopping carts

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique cart item identifier |
| cart_id | bigint | FOREIGN KEY → carts(id) | Cart reference |
| product_id | bigint | FOREIGN KEY → products(id) | Product reference |
| quantity | integer | NOT NULL | Quantity in cart |

### 8. **payments** Table
**Purpose**: Store payment information for orders

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique payment identifier |
| order_id | bigint | FOREIGN KEY → orders(id) | Order reference |
| payment_method | enum | NOT NULL | Payment method (cod, gcash, card) |
| amount | decimal(10,2) | NOT NULL | Payment amount |
| status | enum | DEFAULT 'pending' | Payment status (pending, paid, failed) |
| created_at | timestamp | NOT NULL | Record creation time |
| updated_at | timestamp | NOT NULL | Record last update time |

### 9. **deliveries** Table
**Purpose**: Store delivery information for orders

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique delivery identifier |
| order_id | bigint | FOREIGN KEY → orders(id) | Order reference |
| address | varchar(255) | NOT NULL | Delivery address |
| status | enum | DEFAULT 'pending' | Delivery status (pending, shipped, delivered) |
| delivery_date | date | NULLABLE | Scheduled delivery date |
| created_at | timestamp | NOT NULL | Record creation time |
| updated_at | timestamp | NOT NULL | Record last update time |

### 10. **personal_access_tokens** Table
**Purpose**: Store API tokens for authentication (Laravel Sanctum)

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | bigint | PRIMARY KEY, AUTO_INCREMENT | Unique token identifier |
| tokenable_type | varchar(255) | NOT NULL | Model type (usually 'App\Models\User') |
| tokenable_id | bigint | NOT NULL | Model ID reference |
| name | varchar(255) | NOT NULL | Token name |
| token | varchar(64) | UNIQUE, NOT NULL | Hashed token |
| abilities | text | NULLABLE | Token permissions |
| last_used_at | timestamp | NULLABLE | Last usage timestamp |
| expires_at | timestamp | NULLABLE | Token expiration |
| created_at | timestamp | NOT NULL | Record creation time |
| updated_at | timestamp | NOT NULL | Record last update time |

## Entity Relationships

### Primary Relationships

1. **User → Orders** (One-to-Many)
   - One user can have many orders
   - Each order belongs to one user

2. **User → Cart** (One-to-One)
   - Each user has one shopping cart
   - Each cart belongs to one user

3. **Category → Products** (One-to-Many)
   - One category can have many products
   - Each product belongs to one category

4. **Order → Order Items** (One-to-Many)
   - One order can have many order items
   - Each order item belongs to one order

5. **Order → Payment** (One-to-One)
   - Each order has one payment record
   - Each payment belongs to one order

6. **Order → Delivery** (One-to-One)
   - Each order has one delivery record
   - Each delivery belongs to one order

7. **Cart → Cart Items** (One-to-Many)
   - One cart can have many cart items
   - Each cart item belongs to one cart

8. **Product → Order Items** (One-to-Many)
   - One product can be in many order items
   - Each order item references one product

9. **Product → Cart Items** (One-to-Many)
   - One product can be in many cart items
   - Each cart item references one product

## Business Logic Flow

### Order Processing Flow
1. **User Registration/Login** → `users` table
2. **Browse Products** → `products` table (filtered by `categories`)
3. **Add to Cart** → `cart_items` table (linked to user's `cart`)
4. **Checkout** → Create `order` record
5. **Order Items** → Create `order_items` records
6. **Payment** → Create `payment` record
7. **Delivery** → Create `delivery` record
8. **Order Fulfillment** → Update order status, payment status, delivery status

### Data Integrity Rules
- All foreign key constraints have CASCADE DELETE
- Order items are deleted when order is deleted
- Cart items are deleted when cart is deleted
- Payment and delivery records are deleted when order is deleted
- User deletion cascades to all related records

## Indexes and Performance
- Primary keys are auto-incrementing bigint
- Foreign keys are indexed automatically
- Email field has unique constraint
- Token field has unique constraint
- Consider adding indexes on frequently queried fields like `status` columns

## Security Considerations
- Passwords are hashed using Laravel's built-in hashing
- API tokens are hashed and stored securely
- Email verification is supported
- Admin privileges are controlled via `is_admin` flag
