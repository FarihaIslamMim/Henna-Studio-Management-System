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

## 🗄️ Database Structure

The system uses a relational database with seven interconnected tables.

### 🔐 Admin

| Column | Type | Constraints |
|---|---|---|
| Admin_ID | INT(11) | PRIMARY KEY, AUTO_INCREMENT |
| Username | VARCHAR(50) | NOT NULL |
| Password | VARCHAR(255) | NOT NULL |
| Email | VARCHAR(100) | NULL |
| reset_token | VARCHAR(255) | NULL |
| token_expiry | DATETIME | NULL |

### 👤 Artists

| Column | Type | Constraints |
|---|---|---|
| Artist_ID | INT(11) | PRIMARY KEY, AUTO_INCREMENT |
| Name | VARCHAR(100) | NOT NULL |
| Phone | VARCHAR(15) | NOT NULL, UNIQUE |
| Email | VARCHAR(100) | NULL, UNIQUE |
| User_Password | VARCHAR(255) | NOT NULL |
| Address | VARCHAR(255) | NULL |
| Specialization | VARCHAR(100) | NULL, CHECK |
| Experience_Years | INT(11) | NULL, CHECK (>= 0) |
| Joining_Date | DATE | DEFAULT CURRENT_DATE |
| Status | VARCHAR(20) | DEFAULT 'Active' |

### 👥 Customers

| Column | Type | Constraints |
|---|---|---|
| Customer_ID | INT(11) | PRIMARY KEY, AUTO_INCREMENT |
| Name | VARCHAR(100) | NOT NULL |
| Phone | VARCHAR(15) | NULL, UNIQUE |
| Email | VARCHAR(100) | NULL |
| Password | VARCHAR(255) | NOT NULL |
| Address | VARCHAR(255) | NULL |
| Registration_Date | DATE | DEFAULT CURRENT_DATE |
| Status | ENUM('Active','Inactive') | DEFAULT 'Active' |

### 🎨 Designs

| Column | Type | Constraints |
|---|---|---|
| Design_ID | INT(11) | PRIMARY KEY, AUTO_INCREMENT |
| Design_Code | VARCHAR(20) | NOT NULL |
| Category | VARCHAR(50) | NULL, CHECK |
| Price | DECIMAL(10,2) | NULL, CHECK (>= 0) |
| Availability | ENUM('Available','Unavailable') | NULL |
| Image | VARCHAR(255) | NULL |

### 📅 Bookings

| Column | Type | Constraints |
|---|---|---|
| Booking_ID | INT(11) | PRIMARY KEY, AUTO_INCREMENT |
| Customer_ID | INT(11) | NULL, FOREIGN KEY |
| Artist_ID | INT(11) | NULL, FOREIGN KEY |
| Design_ID | INT(11) | NULL, FOREIGN KEY |
| Booking_Date | DATE | NOT NULL |
| Booking_Time | TIME | NOT NULL |
| Status | ENUM('Pending','Confirmed','Completed','Cancelled') | DEFAULT 'Pending' |
| Custom_Design_Image | VARCHAR(255) | NULL |
| Custom_Design_Note | TEXT | NULL |
| Payment_Option | VARCHAR(20) | NULL |

### 💳 Payments

| Column | Type | Constraints |
|---|---|---|
| Payment_ID | INT(11) | PRIMARY KEY, AUTO_INCREMENT |
| Booking_ID | INT(11) | NULL, FOREIGN KEY |
| Amount | DECIMAL(10,2) | NULL, CHECK (>= 0) |
| Payment_Method | ENUM('Bkash','Nagad') | NULL |
| Payment_Date | DATE | DEFAULT CURRENT_DATE |
| Payment_Status | ENUM('Paid','Unpaid','Refunded') | DEFAULT 'Unpaid' |

### ⭐ Reviews

| Column | Type | Constraints |
|---|---|---|
| Review_ID | INT(11) | PRIMARY KEY, AUTO_INCREMENT |
| Customer_ID | INT(11) | NULL, FOREIGN KEY |
| Booking_ID | INT(11) | NULL, FOREIGN KEY |
| Rating | INT(11) | NULL, CHECK (1–5) |
| Comment | TEXT | NULL |
| Review_Date | DATE | DEFAULT CURRENT_DATE |

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
