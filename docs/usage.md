# Usage

## Running the Application

### Development Server
```bash
php artisan serve
```
Access at: `http://localhost:8000`

### Queue Worker (for SMS processing)
```bash
php artisan queue:work
```

## Common Commands

| Command | Description |
|---------|-------------|
| `php artisan migrate` | Run database migrations |
| `php artisan db:seed` | Seed database with sample data |
| `php artisan cache:clear` | Clear application cache |
| `php artisan config:clear` | Clear config cache |

## Features

### Market Prices
View current agricultural market prices via the web interface.

### SMS Notifications
- Check SMS status: `php artisan sms:check`
- Simulate SMS: `php artisan sms:simulate`

### Phone Validation
Validate farmer phone numbers:
```bash
php artisan phones:check
```

---

*Previous: [Configuration](configuration.md) | Next: [API Reference](api.md)*