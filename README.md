# Vastrika NX - Backend (Laravel API)

A production-ready Laravel REST API for the Vastrika NX luxury saree eCommerce platform.

## Features

- **Authentication**: Laravel Sanctum SPA authentication (Admin & Customer roles)
- **Products**: Complete product management with categories, images, and filtering
- **Cart System**: Add, update, remove items from cart
- **Wishlist**: Save favorite products
- **Orders**: Place orders with COD and Razorpay payment options
- **Addresses**: Manage multiple delivery addresses
- **Reviews & Ratings**: Customer reviews and ratings for products
- **Coupons**: Discount coupon system
- **Admin Dashboard**: Administrative APIs for managing products, orders, customers
- **Repository Pattern**: Clean, maintainable code structure
- **Service Layer**: Business logic separation
- **API Resources**: Consistent API response formatting
- **Form Validation**: Request validation with custom rules

## Tech Stack

- **Framework**: Laravel (Latest version)
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **File Storage**: Local storage with public disk

## Installation

### Prerequisites

- PHP 8.2+
- Composer
- MySQL
- Laravel Herd (or any PHP dev environment)
- Node.js (for frontend)

### Setup Steps

1. **Clone or Navigate to Backend Folder**
   ```bash
   cd backend
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Create Environment File**
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Configure Database in .env**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=vastrika_nx
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Run Migrations**
   ```bash
   php artisan migrate --seed
   ```

7. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Start Development Server**
   ```bash
   php artisan serve
   ```

The API will be available at: `http://vastrika-nx-backend.test`

## Project Structure

```
backend/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # API Controllers
│   │   │   ├── Api/Auth/     # Authentication
│   │   │   ├── Api/Customer/ # Customer APIs
│   │   │   └── Api/Admin/    # Admin APIs
│   │   ├── Requests/         # Form validation
│   │   ├── Resources/        # API response formatting
│   │   └── Middleware/       # Custom middleware
│   ├── Models/               # Eloquent models
│   ├── Services/             # Business logic
│   └── Repositories/         # Data access layer
├── database/
│   ├── migrations/           # Database schema
│   ├── seeders/             # Sample data
│   └── factories/           # Model factories
├── routes/
│   └── api.php              # API routes
├── config/                  # Configuration files
└── storage/
    └── app/public/          # Public uploads
```

## API Endpoints

### Authentication
- `POST /api/register` - Register new customer
- `POST /api/login` - Login
- `POST /api/logout` - Logout (requires auth)
- `GET /api/me` - Get current user (requires auth)

### Products (Public)
- `GET /api/customer/products` - List all products with filters
- `GET /api/customer/products/featured` - Featured products
- `GET /api/customer/products/trending` - Trending products
- `GET /api/customer/products/latest` - Latest products
- `GET /api/customer/products/{id}` - Product details
- `GET /api/customer/products/{id}/related` - Related products
- `GET /api/customer/category/{categoryId}/products` - Category products

### Categories (Public)
- `GET /api/customer/categories` - List all categories
- `GET /api/customer/categories/{slug}` - Category details

### Cart (Protected)
- `GET /api/customer/cart` - Get cart
- `POST /api/customer/cart/add` - Add to cart
- `PUT /api/customer/cart/items/{itemId}` - Update cart item
- `DELETE /api/customer/cart/items/{itemId}` - Remove from cart
- `DELETE /api/customer/cart/clear` - Clear cart

### Orders (Protected)
- `GET /api/customer/orders` - List customer orders
- `GET /api/customer/orders/{id}` - Order details
- `POST /api/customer/orders/create` - Create order
- `DELETE /api/customer/orders/{id}/cancel` - Cancel order

### Addresses (Protected)
- `GET /api/customer/addresses` - List addresses
- `POST /api/customer/addresses/create` - Add address
- `PUT /api/customer/addresses/{id}` - Update address
- `DELETE /api/customer/addresses/{id}` - Delete address
- `POST /api/customer/addresses/{id}/set-default` - Set default

### Reviews (Protected)
- `POST /api/customer/reviews/create` - Submit review
- `GET /api/customer/reviews/product/{productId}` - Get reviews

### Wishlist (Protected)
- `GET /api/customer/wishlist` - Get wishlist
- `POST /api/customer/wishlist/{productId}/add` - Add to wishlist
- `DELETE /api/customer/wishlist/{productId}/remove` - Remove from wishlist
- `GET /api/customer/wishlist/{productId}/check` - Check if in wishlist

### Admin APIs (Protected - Admin only)

**Dashboard**
- `GET /api/admin/dashboard/stats` - Dashboard statistics

**Products**
- `GET /api/admin/products` - List products
- `POST /api/admin/products/create` - Create product
- `GET /api/admin/products/{id}` - Product details
- `PUT /api/admin/products/{id}` - Update product
- `DELETE /api/admin/products/{id}` - Delete product

**Categories**
- `GET /api/admin/categories` - List categories
- `POST /api/admin/categories/create` - Create category
- `PUT /api/admin/categories/{id}` - Update category
- `DELETE /api/admin/categories/{id}` - Delete category

**Orders**
- `GET /api/admin/orders` - List orders
- `GET /api/admin/orders/{id}` - Order details
- `PUT /api/admin/orders/{id}/status` - Update order status

**Customers**
- `GET /api/admin/customers` - List customers
- `GET /api/admin/customers/{id}` - Customer details
- `PUT /api/admin/customers/{id}/status` - Update customer status

## Authentication

The API uses Laravel Sanctum for token-based authentication.

### Login Flow
1. Send credentials to `POST /api/login`
2. Receive token in response
3. Include token in Authorization header: `Authorization: Bearer {token}`

### Example Request
```bash
curl -X GET http://vastrika-nx-backend.test/api/me \
  -H "Authorization: Bearer your_token_here" \
  -H "Accept: application/json"
```

## Default Credentials

After running seeders, use these credentials:

**Admin:**
- Email: `admin@vastrika.test`
- Password: `password123`

**Customer:**
- Email: `john@example.com`
- Password: `password123`

## Testing

Run tests with:
```bash
php artisan test
```

## Deployment

1. Clone repository
2. Run `composer install --no-dev`
3. Set production `.env` values
4. Run `php artisan migrate --force`
5. Run `php artisan storage:link`
6. Set proper permissions on `storage/` and `bootstrap/cache/`

## Environment Variables

Key environment variables to configure:

```
APP_NAME=Vastrika NX
APP_ENV=production
APP_DEBUG=false
APP_URL=http://vastrika-nx-backend.test

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=vastrika_nx
DB_USERNAME=root
DB_PASSWORD=

SANCTUM_STATEFUL_DOMAINS=vastrika-nx-frontend.test
SESSION_DOMAIN=.test

RAZORPAY_KEY_ID=your_key
RAZORPAY_KEY_SECRET=your_secret

CORS_ALLOWED_ORIGINS=http://vastrika-nx-frontend.test
```

## Support & Documentation

For more information, refer to:
- [Laravel Documentation](https://laravel.com/docs)
- [Laravel Sanctum](https://laravel.com/docs/sanctum)

## License

MIT License
