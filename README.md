# 🌿 Henna Studio
### Management & Booking System

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

1. Install and open **XAMPP**.
2. Start **Apache** and **MySQL** from the XAMPP Control Panel.
3. Place the project folder inside:
   `C:\xampp\htdocs\`
4. Open **phpMyAdmin** and create/import the project database.
5. Open the website in a browser using:
   `http://localhost/<project-folder>/`
6. Use the **Admin Login** option to access the administrative panel.

> The system runs locally through XAMPP and uses PHP with MySQL/MariaDB.

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
