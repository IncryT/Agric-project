# Configuration

## Environment Variables

Edit the `.env` file in your project root:

| Variable | Description | Default |
|----------|-------------|---------|
| `APP_NAME` | Application name | `Agricultural Project` |
| `APP_URL` | Application URL | `http://localhost` |
| `DB_CONNECTION` | Database driver | `sqlite` |
| `MAIL_MAILER` | Mail driver | `log` |

## Database Setup

### SQLite (Default)
```env
DB_CONNECTION=sqlite
```

### MySQL
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=agricultural_project
DB_USERNAME=root
DB_PASSWORD=
```

## SMS Configuration

Configure SMS settings in `.env`:
```env
SMS_API_KEY=your_api_key
SMS_SENDER=YourSenderID
```

---

*Previous: [Installation](installation.md) | Next: [Usage](usage.md)*