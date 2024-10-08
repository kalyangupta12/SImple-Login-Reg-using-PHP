# Simple Login, Register, and Display Username System using PHP and MySQL

This is a simple web application that allows users to register, log in, and display their username after a successful login. The project is built using PHP and MySQL for backend functionality.

## Features

- **User Registration**: Users can create a new account with an email and password.
- **User Login**: Users can log in using their email and password.
- **Display Username**: Once logged in, the username is displayed on the welcome page.
- **Password Security**: Passwords are hashed using `password_hash()` to ensure security.
- **Session Management**: Sessions are used to track logged-in users.
- **Responsive UI**: Simple and clean UI designed using Bootstrap 5.

## Technologies Used

- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML, CSS (Bootstrap 5 for UI styling)
- **Session Management**: PHP Sessions

## Project Structure

```
project-folder/
│
├── includes/
│   └── db_connect.php        # Database connection script
│
├── login.php                 # User login page
├── register.php              # User registration page
├── hello.php                 # Page displaying the username after login
├── css/
│   └── login.css             # Optional: Custom CSS for login page styling
├── README.md                 # Project documentation
└── signup-users.sql          # SQL file for creating the database table
```

## Installation

### Step 1: Clone the repository

```bash
git clone https://github.com/kalyangupta12/SImple-Login-Reg-using-PHP.git
```

### Step 2: Setup MySQL Database

1. Create a database in MySQL (e.g., `user_system`).
2. Import the `signup-users.sql` file into your MySQL database.

```sql
CREATE TABLE `signup-users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL UNIQUE,
  `user_password` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);
```

### Step 3: Configure Database Connection

Edit the `includes/db_connect.php` file with your database credentials.

```php
<?php
$host = 'localhost';  // Change if your database is hosted elsewhere
$user = 'root';       // Your MySQL username
$password = '';       // Your MySQL password
$db_name = 'user_system';  // Your MySQL database name

$con = mysqli_connect($host, $user, $password, $db_name);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

### Step 4: Run the Project

1. Start your PHP server (e.g., XAMPP, WAMP, or built-in PHP server).
2. Visit the following URLs in your browser:
   - **Registration Page**: `http://localhost/your-project-folder/register.php`
   - **Login Page**: `http://localhost/your-project-folder/login.php`
   - **Welcome Page (after login)**: `http://localhost/your-project-folder/hello.php`

## Usage

1. **Register** a new account with your username, email, and password.
2. **Log in** with your registered email and password.
3. After logging in, you will be redirected to the welcome page, where your **username** will be displayed.

## Security Considerations

- Passwords are securely hashed using PHP’s `password_hash()` function and verified using `password_verify()`.
- Always ensure your database credentials are kept secure.
- Consider implementing more robust security practices such as HTTPS, CSRF protection, and additional validation checks.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.
