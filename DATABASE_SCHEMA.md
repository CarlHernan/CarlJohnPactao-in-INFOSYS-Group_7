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
