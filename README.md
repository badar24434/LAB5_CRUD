# User Management System

A simple CRUD application for managing users with different role categories (admin, student, lecturer).

## Prerequisites

- XAMPP (or equivalent Apache, MySQL, PHP stack)
- Web browser
- MySQL database

## Setup Instructions

### Step 1: Install XAMPP

1. Download and install XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
2. Start the Apache and MySQL services from the XAMPP Control Panel

### Step 2: Clone/Download Project Files

1. Clone this repository or download the project files
2. Place all files in the `htdocs/LAB5_CRUD` directory of your XAMPP installation
   - Typically: `C:\xampp\htdocs\LAB5_CRUD\`

### Step 3: Initialize the Database

There are two ways to set up the database:

#### Option 1: Using the Setup Script

1. Open your browser and navigate to: [http://localhost/LAB5_CRUD/db_setup.php](http://localhost/LAB5_CRUD/db_setup.php)
2. The script will automatically create the required tables and sample users
3. Click the "Go to Login Page" button after successful setup

#### Option 2: Manual SQL Import

1. In phpMyAdmin, select the `user_system` database
2. Click on the "Import" tab
3. Click "Browse" and select the `database.sql` file from the project directory
4. Click "Go" to run the SQL commands

### Step 4: Access the Application

1. Open your browser and navigate to: [http://localhost/LAB5_CRUD/](http://localhost/LAB5_CRUD/)
2. You will be redirected to the login page

### Default Login Credentials

The system comes with three predefined user accounts:

| Username  | Password    | Role      |
|-----------|-------------|-----------|
| admin     | password123 | Admin     |
| student1  | password123 | Student   |
| lecturer1 | password123 | Lecturer  |

### Troubleshooting

If you encounter any issues:

1. Check that Apache and MySQL are running in XAMPP Control Panel
2. Verify the database connection settings in `config.php`
3. Use the debug page: [http://localhost/LAB5_CRUD/login_debug.php](http://localhost/LAB5_CRUD/login_debug.php)
4. If the table becomes corrupted, you can delete it from phpMyAdmin and rerun the db_setup.php script

### Resetting the Database

If you need to reset the database:

1. Go to phpMyAdmin: [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
2. Select the `user_system` database
3. Delete the `users` table and then run `db_setup.php` again
   
## Features

- User authentication system with role-based access control
- Admin dashboard for managing all users
- Student and lecturer portals with role-specific interfaces
- CRUD operations for user management (Create, Read, Update, Delete)
- Session management and security controls

## File Structure

- `login.php` - Login interface
- `admin_dashboard.php` - Admin control panel
- `student_dashboard.php` - Student portal
- `lecturer_dashboard.php` - Lecturer portal
- `db_setup.php` - Database initialization script
- `login_debug.php` - Debugging tool
- `user_processing.php` - Backend for user CRUD operations
- `config.php` - Database connection settings
- `session_check.php` - Session validation and security
