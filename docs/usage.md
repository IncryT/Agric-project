# User Manual: Agricultural Price Advisor System (APAS)

## Overview
APAS (Agricultural Price Advisor System) is a web-based platform designed to help farmers make informed decisions about crop pricing and market trends. The system provides real-time market data, pricing calculators, AI-powered advice, and subscription-based SMS alerts.

## Accessing the Website
Once deployed, users can access APAS through a web browser at the deployed URL (e.g., https://apas.example.com).

## User Types
The system supports two primary user roles:
1. **Farmers** - Access pricing tools, calculators, chatbot, and subscription services
2. **Administrators** - Manage products, market prices, and farmer data

## Getting Started

### 1. Landing Page Experience
When visiting the root URL, users see:
- Live market ticker showing real-time crop prices (Wheat, Corn, Soybeans, Rice, Barley)
- Hero section explaining the value proposition
- "Get Started" button for registration
- "Sign In" button for existing users

### 2. User Registration
To create an account:
1. Click "Get Started" on the landing page or navigate to `/register`
2. Fill in required information (name, email, password)
3. Select user role (Farmer or Admin)
4. Complete email verification
5. Log in with credentials

### 3. User Login
Existing users can:
1. Click "Sign In" on landing page or navigate to `/login`
2. Enter email and password
3. Access their role-specific dashboard

## Farmer Interface

After logging in as a farmer, users access:

### Dashboard (`/farmer/dashboard`)
- Overview of market prices for various crops
- Minimum Recommended Price (MRP) calculations
- Visual indicators for price trends

### Calculator (`/farmer/calculator`)
- Input cost of production, desired profit margin, and risk factors
- Calculate optimal selling price
- View detailed breakdown of costs and profits

### Chatbot Advisor (`/farmer/chatbot`)
- AI-powered agricultural advisor
- Ask questions about pricing, market trends, or farming practices
- Receive data-driven recommendations

### Services Discovery (`/farmer/services`)
- Browse available agricultural services in the area
- Find input suppliers, equipment rentals, processing facilities

### Subscription Management (`/farmer/subscriptions`)
- Subscribe to SMS price alerts for specific crops
- Set price thresholds for notifications
- Manage active subscriptions

## Administrator Interface

After logging in as an admin, users access:

### Admin Dashboard (`/admin/dashboard`)
- System overview with product and price count statistics
- Data update scheduling controls
- Alert system configuration

### Product Management (`/admin/products`)
- View, create, and manage crop types
- Define units of measurement (kg, quintal, ton, etc.)

### Market Price Management (`/admin/market-prices`)
- Record and update market prices for different districts
- Track price history and trends

### Farmer Management (`/admin/farmers`)
- View registered farmers
- Manage farmer profiles and details
- Geographic distribution mapping

## Key Features Explained

### Live Market Ticker
- Continuously scrolls real-time prices for major crops
- Shows price changes with color coding (green for increase, red for decrease)
- Updates automatically from database

### Pricing Calculator
- Uses cost-plus pricing model with risk adjustment
- Factors in production costs, desired profit, market conditions
- Provides provisional prices when market data is limited

### AI Chatbot
- Trained on agricultural pricing data and best practices
- Answers questions in natural language
- Provides contextual advice based on user location and crop preferences

### SMS Alert System
- Sends price notifications via SMS
- Configurable thresholds and frequency
- Helps farmers time their market entries optimally

## Navigation
- Persistent top navigation bar with application logo
- Role-specific sidebar menus (not shown in Blade files but implied by route groups)
- Breadcrumb navigation in internal pages
- Responsive design for mobile and desktop use

## Security Features
- Email verification required for registration
- Password protection with Laravel's built-in authentication
- Role-based access control (Farmers vs Administrators)
- CSRF protection on all forms
- Session timeout for inactive users

## Getting Help
- In-app chatbot for immediate assistance
- Documentation links in footer
- Contact information available in website footer
- Email support for technical issues

## Mobile Access
The application is fully responsive and works on:
- Smartphones (iOS and Android)
- Tablets
- Desktop computers
- No separate mobile app required - accessible through any modern browser

---
*Last updated: 2026-05-02*