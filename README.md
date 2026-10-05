# ShopVerse — Full-Stack Laravel E-Commerce

ShopVerse is a portfolio-ready **Laravel 12 / PHP 8.2** e-commerce application created by upgrading an existing static HTML/CSS/JavaScript storefront into a database-driven full-stack system.

The original visual assets and storefront character are preserved, while product data, accounts, carts, wishlists, checkout, inventory and administration now run through Laravel and a relational database.

## Highlights

- Public storefront with featured and latest products
- Product catalog with search, category filtering and price sorting
- Product detail pages with image galleries and related products
- Customer registration, login and secure password hashing
- Persistent database cart tied to the authenticated customer
- Wishlist support
- Checkout with delivery details and cash-on-delivery demo payment
- Normalized `orders` + `order_items` model with price/name snapshots
- Shipping calculation (free at $200+, otherwise $12)
- Transactional checkout with row locking to reduce overselling risk
- Stock decrement on checkout and automatic restoration when an eligible order is cancelled
- Explicit order state transitions (`pending → processing → shipped → completed`, with cancellation only before shipment)
- Customer order history and order detail pages
- Role-based Admin area
- Product and category management
- Product soft-delete archive and restore
- Order status management
- Contact form stored in the database with Admin inbox
- Admin KPI dashboard (products, orders, customers, revenue, low stock, unread messages)
- Seeded demo catalog based on the original storefront products
- PHPUnit feature tests and GitHub Actions CI
- Dependabot configuration

## Tech Stack

- PHP 8.2+
- Laravel 12
- Eloquent ORM
- SQLite by default (easy to switch to MySQL/PostgreSQL)
- Blade templates
- Original HTML/CSS storefront assets
- PHPUnit 11
- GitHub Actions

## Architecture

The application uses conventional Laravel separation:

- **Models** — users, categories, products, carts, orders, order items and contact messages
- **Controllers** — storefront, customer flows and Admin flows are separated
- **Form Requests** — registration, checkout and Admin product validation
- **Service layer** — `CheckoutService` owns checkout/cancellation inventory logic
- **Middleware** — Admin authorization is enforced server-side
- **Database transactions** — order creation and inventory updates happen atomically

## Quick Start

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

Then open `http://127.0.0.1:8000`.

### Demo Accounts

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@example.com` | `Admin12345` |
| Customer | `customer@example.com` | `Customer12345` |

> Demo passwords are intentionally simple for local portfolio testing. Change/remove seeded credentials before any real deployment.

## Main Routes

| Area | Route |
| --- | --- |
| Storefront | `/` |
| Catalog | `/shop` |
| Customer cart | `/cart` |
| Wishlist | `/wishlist` |
| Checkout | `/checkout` |
| Customer orders | `/orders` |
| Contact | `/contact` |
| Admin dashboard | `/admin` |

## Database Model

- `users`
- `categories`
- `products`
- `cart_items`
- `product_user` (wishlist pivot)
- `orders`
- `order_items`
- `contact_messages`

Products use soft deletes. Historical order items snapshot the product name and unit price so order history remains meaningful if a catalog product later changes or is removed.

## Order & Inventory Safety

Checkout is executed in a database transaction. Product rows are locked before stock is validated and decremented. An order is only created when all cart quantities can be fulfilled. Cancellation restores inventory only while the order is still in a cancellable state.

The project deliberately does **not** collect or process real card data. The included checkout uses cash on delivery as a safe portfolio workflow. A production payment gateway should be implemented through a PCI-compliant provider rather than storing card details directly.

## Testing

After installing Composer dependencies:

```bash
php artisan test
```

The feature suite covers authentication/authorization, cart behavior, checkout, stock reduction, cancellation stock restoration, terminal order states and storefront search.

## CI

`.github/workflows/tests.yml` installs Composer dependencies, prepares the Laravel environment and runs the test suite for pushes and pull requests.

## Original Front-End Upgrade

The source project was a static e-commerce front end that used JSON and browser storage for product/cart behavior. ShopVerse retains its image/CSS assets under `public/storefront/` while replacing that client-only state with Laravel routes, controllers, Eloquent models and database persistence.

## Production Checklist

Before deploying publicly:

1. Set `APP_ENV=production`, `APP_DEBUG=false` and a strong application key.
2. Use a production database and HTTPS.
3. Replace demo seed credentials.
4. Configure real mail delivery and queues if needed.
5. Add a PCI-compliant payment provider if online payment is required.
6. Configure backups, monitoring, rate limits and server-level security headers.

## License

MIT. See [LICENSE](LICENSE).
