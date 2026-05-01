# Installation

## Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL or SQLite

## Steps

1. **Clone the repository**
   ```bash
   git clone https://github.com/yourusername/project.git
   cd project
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   php artisan migrate
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

---

*Next: [Configuration](configuration.md)*