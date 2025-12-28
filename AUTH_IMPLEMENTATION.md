# Authentication & CSRF Implementation

## Overview

Minimum viable session-based authentication with CSRF protection.

**Roles:**
- `admin` - Full access to admin editor
- `client` - Access to client dashboard

**Gates:**
- `/admin/*` - Admin only
- `/app/clients/*` - Client role required

---

## Files Created

1. **`lib/auth.php`** - Authentication functions
2. **`lib/csrf.php`** - CSRF token generation/validation
3. **`login.php`** - Login page
4. **`config/users.example.php`** - User config template

---

## Configuration

### Option 1: Environment Variables (Recommended)

```bash
export ADMIN_USERNAME="admin"
export ADMIN_PASSWORD="your-secure-password"
export CLIENT_USERNAME="client"
export CLIENT_PASSWORD="your-secure-password"
```

### Option 2: Config File

1. Copy `config/users.example.php` to `config/users.php`
2. Set your passwords
3. **DO NOT commit `config/users.php` to version control**

### Option 3: Database (Future)

Replace `get_users()` in `lib/auth.php` with database query.

---

## Default Credentials (Development Only)

**⚠️ CHANGE IN PRODUCTION**

- Admin: `admin` / `admin`
- Client: `client` / `client`

---

## Usage

### In Protected Pages

```php
require_once __DIR__ . '/../lib/auth.php';

require_admin(); // Admin only
// or
require_client(); // Client role required
```

### In Forms

```php
require_once __DIR__ . '/../lib/csrf.php';

// In form
<?= csrf_field() ?>

// On POST
require_csrf_token(); // Validates and dies if invalid
```

---

## Security Notes

1. **Passwords:** Use `password_hash()` / `password_verify()` (already implemented)
2. **Sessions:** PHP sessions with secure cookies (configure in php.ini)
3. **CSRF:** Synchronizer token pattern (classic, proven)
4. **HTTPS:** Required in production

---

## Production Checklist

- [ ] Set environment variables or config file
- [ ] Change default passwords
- [ ] Enable HTTPS
- [ ] Configure secure session cookies
- [ ] Add rate limiting (optional)
- [ ] Add 2FA (optional, future)

---

**Implementation Complete:** 2025-12-28

