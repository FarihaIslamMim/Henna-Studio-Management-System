## 🌿 Henna Studio Management & Booking System

A web-based DBMS project designed to manage henna studio operations — from customer bookings and design selection to payments, reviews, and administrative management.

## ⚙️  Project Scope

The system covers the complete workflow of a henna studio:

- Customer registration and online booking
- Henna design browsing and price viewing
- Artist and appointment selection
- Online payment through bKash and Nagad
- Custom design booking with payment after service
- Booking history and status tracking
- Admin login and administrative management
- Customer, artist, design, booking, payment, and review management
- Payment receipt generation and printing
- Data validation and consistency
  
## 👩‍💻Team
**Fabia Binte Faruk**  
  ID: 242-115-008  
**Fariha Islam Mim**  
  ID: 242-115-043  
Course: DBMS Lab  
Department: Computer Science & Engineering  
Metropolitan University, Sylhet

## 📋 System Overview

|    Customer Experience      |        Studio Management         |
|-----------------------------|----------------------------------|
|   Customer registration     |       Customer management        |
|  Design browsing & pricing  |        Artist management         |
| Artist & schedule selection | Design & availability management |
|      Online booking         |        Booking management        |
|     Booking history         |   Payment & receipt management   |
|   BKash / Nagad payment     |        Review management         |

The system also supports **custom design bookings**, where the design price is determined after consultation and payment is completed after the service.

## 💻 Technology Stack

**Frontend**

`HTML` · `CSS` · `JavaScript` · `Tailwind CSS`

**Backend**

`PHP`

**Database**

`MySQL / MariaDB`

**Development Environment**

`XAMPP` · `phpMyAdmin`  

## ▶ How to Run

### Requirements

- XAMPP
- PHP 8.2 or later
- MySQL/MariaDB
- A web browser

### Setup

1. Download or clone the repository and place the project folder inside the XAMPP `htdocs` directory.
2. Start **Apache** and **MySQL** from the XAMPP Control Panel.
3. Open **phpMyAdmin** by visiting `http://localhost/phpmyadmin`.
4. Create a database named:
   
   `henna studio management & booking system`

5. Select the database and import the SQL file from the `Database` folder.
6. Make sure the database connection settings in the PHP configuration file match your local MySQL/MariaDB settings.
7. Open the project in your browser using: `http://localhost/[project-folder-name]/`

### Demo Login

The SQL file contains sample accounts for demonstration purposes.

The passwords in the public SQL file are replaced with: `[DEMO_PASSWORD]`

After importing the database, replace `[DEMO_PASSWORD]` with your own password for the sample account you want to use.

> **Note:** `[DEMO_PASSWORD]` is only a placeholder and is not a real password.

## 🗄️ Database Structure

The system uses seven relational tables:

| Table | Purpose |
|---|---|
| `admin` | Stores administrator login and account recovery information |
| `artists` | Stores artist profiles, specialization, experience and availability status |
| `customers` | Stores customer registration and account information |
| `designs` | Stores henna designs, categories, prices and availability |
| `bookings` | Stores customer appointments and booking details |
| `payments` | Stores booking payment transactions and status |
| `reviews` | Stores customer ratings and feedback |  

### 🔗 Relationships

- `Bookings.Customer_ID` → `Customers.Customer_ID`
- `Bookings.Artist_ID` → `Artists.Artist_ID`
- `Bookings.Design_ID` → `Designs.Design_ID`
- `Payments.Booking_ID` → `Bookings.Booking_ID`
- `Reviews.Customer_ID` → `Customers.Customer_ID`
- `Reviews.Booking_ID` → `Bookings.Booking_ID`

## 🔐 Validation & Data Integrity

- ✓ Primary and foreign key relationships
- ✓ Unique customer phone and email
- ✓ Required-field validation
- ✓ Bangladeshi phone number validation
- ✓ Email and password validation
- ✓ Artist availability checking
- ✓ Design availability checking
- ✓ Duplicate booking prevention
- ✓ Valid booking date and time
- ✓ Active/inactive status handling

## 💰 Booking & Payment Flow

```text
      Select Design
            ↓
    View Fixed Price
            ↓
Select Artist + Date + Time
            ↓
  Choose Payment Option
            ↓
 ┌─────────────────────┐
 │ Available Design    │
 │ bKash / Nagad       │
 └─────────────────────┘
           OR
 ┌─────────────────────┐
 │ Custom Design       │
 │ Pay After Service   │
 └─────────────────────┘
           ↓
    Booking History
           ↓
   Payment / Receipt
