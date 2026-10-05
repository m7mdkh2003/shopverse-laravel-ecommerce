# Security

This repository is a portfolio application, not a production commerce platform.

- Passwords use Laravel's hashed password cast.
- Admin routes are protected by authentication plus Admin middleware.
- Forms use Laravel CSRF protection and validation.
- Checkout uses database transactions and row locking for inventory consistency.
- No card numbers or sensitive payment credentials are collected; checkout is cash-on-delivery only.

For a production deployment, disable debug mode, use HTTPS, rotate all demo credentials, configure secure cookies and trusted proxies, add monitoring/backups, and integrate payment only through a PCI-compliant provider.
