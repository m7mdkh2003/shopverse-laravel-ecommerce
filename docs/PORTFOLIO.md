# Portfolio / GitHub Setup

## Recommended repository name

`shopverse-laravel-ecommerce`

## GitHub description

Full-stack Laravel 12 e-commerce app with persistent cart, wishlist, transactional checkout, inventory-safe orders, customer accounts and role-based Admin dashboard.

## Suggested topics

`laravel` `php` `ecommerce` `full-stack` `mysql` `sqlite` `shopping-cart` `inventory-management` `blade` `phpunit` `github-actions`

## Portfolio blurb

Built a full-stack e-commerce platform by migrating a static HTML/CSS/JavaScript storefront to Laravel. Implemented database-backed catalog management, customer authentication, persistent carts and wishlists, normalized order/order-item models, transactional checkout with row locking, inventory restoration on cancellation, server-side authorization, Admin KPIs, product archiving, contact-message management, automated feature tests and CI.

## What to demonstrate in an interview

1. Show the difference between the original static front end and the Laravel architecture.
2. Walk through `CheckoutService` and explain why checkout is wrapped in a transaction.
3. Explain order item snapshots and why they preserve purchase history.
4. Demonstrate Admin middleware and order state transitions.
5. Show the feature tests and GitHub Actions workflow.
6. Run a checkout, cancel the order, and show inventory being restored.
