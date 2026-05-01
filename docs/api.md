# API Reference

## Authentication

### Login
```
POST /api/login
```

**Request:**
```json
{
  "email": "user@example.com",
  "password": "password"
}
```

### Register
```
POST /api/register
```

## Market Prices

### Get All Prices
```
GET /api/market-prices
```

### Get Price by Product
```
GET /api/market-prices/{product_id}
```

## Products

### List Products
```
GET /api/products
```

### Create Product
```
POST /api/products
```

**Request:**
```json
{
  "name": "Tomatoes",
  "category": "vegetables",
  "unit": "kg"
}
```

## Subscriptions

### Subscribe
```
POST /api/subscriptions
```

**Request:**
```json
{
  "user_id": 1,
  "product_id": 1,
  "frequency": "daily"
}
```

---

*Previous: [Usage](usage.md)*