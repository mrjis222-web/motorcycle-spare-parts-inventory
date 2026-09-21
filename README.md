# Motorcycle Spare Parts Inventory Management System

A full-stack web application for managing motorcycle spare parts inventory. The system allows registered users to securely manage spare parts, monitor stock levels, search and filter inventory, and maintain their account information.

## Project Information

**Student:** Md Jawad Alam
**Student ID:** 2022100000009
**Course:** CSE 472 - Web and Internet Programming
**Section:** 01
**Supervisor:** Abid Ahmad

## Project Overview

The Motorcycle Spare Parts Inventory Management System is designed to provide a simple and efficient way to manage motorcycle spare parts and stock information.

The application provides user authentication and inventory management functionality. Registered users can add, view, update and delete spare parts while monitoring available stock and identifying low-stock items.

## Technologies Used

### Frontend

* HTML5
* CSS3
* JavaScript

### Backend

* PHP

### Database

* MySQL

### Development Tools

* XAMPP
* phpMyAdmin
* Visual Studio Code
* GitHub

## Main Features

### 1. User Authentication

* User registration
* User login
* Secure password hashing
* Session-based authentication
* User logout

### 2. Inventory Management

Users can:

* Add new spare parts
* View spare parts
* Edit existing spare parts
* Delete spare parts
* View individual spare part details

### 3. Search and Filter

The inventory section provides search and category filtering functionality to help users find specific spare parts more easily.

### 4. Stock Monitoring

The system displays stock information and identifies items that require restocking based on their minimum stock level.

### 5. Dashboard

The dashboard provides an overview of:

* Total spare parts
* Total available stock
* Low-stock items
* Total inventory value
* Recently added spare parts

### 6. User Profile

Users can view their account information from the profile section.

## Project Structure

```text
motorcycle-spare-parts-inventory/
│
├── dashboard.php
├── index.php
├── profile.php
├── README.md
│
├── assets/
│   ├── css/
│   │   └── style.css
│   ├── images/
│   └── js/
│       └── script.js
│
├── auth/
│   ├── login.php
│   ├── logout.php
│   └── register.php
│
├── config/
│   └── db.php
│
├── includes/
│   ├── auth_check.php
│   ├── footer.php
│   ├── header.php
│   └── navbar.php
│
└── inventory/
    ├── add.php
    ├── delete.php
    ├── edit.php
    ├── index.php
    └── view.php
```

## Requirements

To run this project locally, install:

* XAMPP
* PHP
* MySQL
* phpMyAdmin
* Web browser
* Visual Studio Code

## Installation and Setup

### Step 1: Install XAMPP

Install XAMPP and start the following services:

* Apache
* MySQL

### Step 2: Copy the Project

Place the project folder inside the XAMPP `htdocs` directory:

```text
C:\xampp\htdocs\motorcycle-spare-parts-inventory
```

### Step 3: Create the Database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin/
```

Create the project database:

```text
spare_parts
```

Import or create the required database tables according to the SQL structure used by the project.

### Step 4: Configure Database Connection

Open:

```text
config/db.php
```

Configure the database connection using your local MySQL settings.

Typical XAMPP configuration:

```text
Host: localhost
Username: root
Password: 
Database: spare_parts
```

If your MySQL password is different, update the password in `config/db.php`.

### Step 5: Run the Application

Make sure Apache and MySQL are running in XAMPP.

Open the following URL in a browser:

```text
http://localhost/motorcycle-spare-parts-inventory/
```

## How to Use

### Registration

1. Open the application.
2. Select Register.
3. Enter your name, email and password.
4. Submit the registration form.
5. Login using the registered account.

### Login

Enter your registered email and password to access the dashboard.

### Add Spare Part

From the dashboard, select **Add Spare Part** and enter the required inventory information.

### Manage Inventory

From the Inventory page, users can:

* View spare parts
* Search for spare parts
* Filter by category
* Edit spare parts
* Delete spare parts
* View spare part details

### Dashboard

The dashboard provides a summary of the current inventory and stock condition.

### Profile

The Profile page displays the logged-in user's account information.

## Security and Validation

The application includes basic security and validation measures such as:

* Password hashing using PHP password hashing functions
* Session-based authentication
* Authentication checks for protected pages
* Email validation
* Required field validation
* Password length validation
* Password confirmation validation
* Prepared SQL statements
* Parameter binding to reduce SQL injection risks
* HTML escaping when displaying user-provided information

## Database

The application uses MySQL as its relational database.

The main data includes:

* User account information
* Motorcycle spare parts information
* Stock quantities
* Minimum stock levels
* Spare part categories
* Inventory pricing information

## Local Development Environment

The application was developed and tested using:

* XAMPP
* Apache
* MySQL
* phpMyAdmin
* Visual Studio Code
* Google Chrome

## Repository

GitHub Repository:

https://github.com/mrjis222-web/motorcycle-spare-parts-inventory

## Live Website

The live website link will be added after deployment.

## Academic Project

This project was developed as an individual assignment for:

**CSE 472 - Web and Internet Programming**
**Department of Computer Science & Engineering**
**Southeast University**

---

**Developed by Md Jawad Alam**
**Student ID: 2022100000009**
