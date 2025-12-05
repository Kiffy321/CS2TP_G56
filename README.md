# CS2TP_G56
Group 56's Project Repo for CS2TP Module

Seraphine Atelier - Luxury Jewellery E-Commerce Website
A modern, responsive e-commerce website for Seraphine Atelier, showcasing handcrafted luxury jewellery pieces made with ethically sourced materials.

📋 Table of Contents
About

Features

Project Structure

Technologies Used

Setup Instructions

Pages Overview

API Endpoints

🌟 About
Seraphine Atelier is a luxury jewellery brand offering timeless, handcrafted pieces ranging from everyday elegance to statement heirlooms. This website provides customers with an intuitive shopping experience to browse, select, and purchase premium jewellery items.

✨ Features
Core Functionality
Responsive Design: Fully mobile-friendly layout with viewport optimization

Product Catalog: Browse products by category (Rings, Earrings, Bracelets, Necklaces, Watches)

Shopping Cart: Add/remove items with dynamic cart count display

User Authentication: Login and registration system with session management

Product Filtering: Category-based navigation and filtering

Stock Management: Real-time stock status indicators (In Stock/Low Stock)

Contact System: Dedicated contact page for customer inquiries

User Experience
Hero section with compelling call-to-action buttons

Featured crafts showcase on landing page

Product cards with images, descriptions, pricing, and badges

Dynamic footer with social media integration

Accessible navigation with ARIA labels

Dynamic copyright year update

📁 Project Structure
text
seraphine-atelier/
├── css/
│   └── index.css              # Main stylesheet
├── js/
│   ├── index.js               # Core JavaScript functionality
│   └── footer.js              # Footer-specific scripts
├── assets/
│   └── images/                # Product images and icons
│       ├── ProfileIcon.png
│       ├── CartIcon.png
│       ├── FacebookIcon.png
│       ├── InstagramIcon.png
│       ├── YoutubeIcon.png
│       └── [Product Images]
├── api/                       # Backend API endpoints
│   ├── check-auth.php         # Authentication verification
│   ├── logout.php             # User logout handler
│   └── add-to-cart.php        # Cart management
├── home.html                  # Landing page
├── products.html              # Main products catalog
├── rings.html                 # Rings category page
├── necklaces.html             # Necklaces category page
├── watches.html               # Watches category page
├── login.html                 # User login page
├── register.html              # User registration page
├── product.html               # Individual product details
├── cart.html                  # Shopping cart page
├── contact.html               # Contact form page
├── about.html                 # About us page
├── footer.html                # Footer component
└── index.html                 # Entry point
🛠️ Technologies Used
Frontend
HTML5: Semantic markup with accessibility features

CSS3: Custom styling with responsive design

JavaScript (ES6+): Dynamic functionality and user interactions

ARIA Labels: Enhanced accessibility support

Backend
PHP: Server-side processing for authentication and cart management

Session Management: Secure user session handling

JSON API: RESTful endpoints for data exchange

Assets
Custom icon set for navigation and social media

High-quality product photography

Optimized images for web performance

🚀 Setup Instructions
Prerequisites
Web server (Apache/Nginx) with PHP support

PHP 7.4 or higher

Modern web browser

Installation
Clone the repository

bash
git clone https://github.com/yourusername/seraphine-atelier.git
cd seraphine-atelier
Configure your web server

Point document root to the project directory

Ensure PHP is enabled

Set up the database (if applicable)

Import database schema

Update API connection credentials

Configure file permissions

bash
chmod 755 css/ js/ assets/
chmod 644 *.html css/*.css js/*.js
Launch the application

Navigate to http://localhost/seraphine-atelier/home.html

Or open home.html directly in your browser for frontend-only testing

📄 Pages Overview
Public Pages
Home (home.html)

Hero section with brand messaging

Featured products showcase

Call-to-action buttons for shopping and learning more

Social media footer integration

Products (products.html)

Complete product catalog with grid layout

Category filtering system

Add to cart functionality on each product

Stock status indicators

Product badges (category tags)

Category Pages

rings.html - Dedicated rings collection

necklaces.html - Necklaces and pendants

watches.html - Timepiece collection

Each with category-specific navigation

Product Details (product.html)

Individual product information

URL parameter-based product selection

Detailed descriptions and pricing

User Authentication
Login (login.html)

Email and password authentication

Link to registration page

Session management integration

Register (register.html)

User account creation form

Full name, email, password, and confirmation fields

Link to login for existing users

Additional Pages
Cart (cart.html)

Shopping cart management

Add/remove items

Quantity adjustment

Dynamic cart count display

Contact (contact.html)

Contact form for customer inquiries

Accessible from navigation and footer

About (about.html)

Brand story and values

Company information

🔌 API Endpoints
Authentication
POST /api/check-auth.php - Verify user authentication status

POST /api/logout.php - End user session

Shopping Cart
POST /api/add-to-cart.php - Add items to cart

Request body: { "productName": "string", "quantity": number }

🎨 Customization
Styling
Modify css/index.css to customize:

Color scheme and branding

Typography and fonts

Layout and spacing

Responsive breakpoints

Products
Update product information in:

Product HTML pages (prices, descriptions)

assets/images/ directory for product photos

Navigation
Edit navigation links in each HTML file's header section to add/remove pages.

📱 Browser Support
Chrome (latest)

Firefox (latest)

Safari (latest)

Edge (latest)

Mobile browsers (iOS Safari, Chrome Mobile)

🔒 Security Features
HTML escaping for user-generated content

Session-based authentication

CSRF protection on forms (recommended)

Secure password handling (server-side)

📞 Contact & Support
For questions or support regarding Seraphine Atelier:

Use the contact form on the website

Email: info@seraphine-atelier.com

Social Media: Facebook | Instagram | YouTube

📝 License
This project is proprietary. All rights reserved © 2025 Seraphine Atelier.

🤝 Contributing
This is a private project. For collaboration inquiries, please contact the development team.


