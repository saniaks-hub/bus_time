<?php
// Database configuration
$host = 'localhost';
$dbname = 'registration_db';
$username = 'root';
$password = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $createTableQuery = "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            username VARCHAR(200) NOT NULL UNIQUE,
            password VARCHAR(200) NOT NULL,
            phone_no VARCHAR(15),
            email VARCHAR(200) NOT NULL UNIQUE,
            usertype ENUM('pass', 'drive', 'own') NOT NULL,
            gender ENUM('male', 'female', 'transgender') NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $pdo->exec($createTableQuery);

        $name = $_POST['nm'];
        $uname = $_POST['uname'];
        $passwd = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
        $phno = $_POST['phno'];
        $email = $_POST['email'];
        $usertype = $_POST['usertype'];
        $gender = $_POST['gender'];

        $stmt = $pdo->prepare("INSERT INTO users (name, username, password, phone_no, email, usertype, gender) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$name, $uname, $passwd, $phno, $email, $usertype, $gender]);

        echo "<script>alert('Registration successful!');</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-image: url("backgroundforms.jpg"); /* Your background image URL here */
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Full height of the viewport */
            padding: 20px;
            color: #333;
            overflow: auto; /* Allow scrolling */
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            border: 2px solid #007bff; /* Add border here */
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 400px; /* Max width for larger screens */
            min-width: 300px; /* Minimum width for smaller screens */
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="password"],
        input[type="email"],
        select {
            width: 100%; /* Full width for all inputs */
            padding: 10px;
            margin: 5px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box; /* Ensure padding is included in width */
        }
        .gender-label {
            margin-top: 10px;
            display: block; /* Ensure the label is a block element */
        }
        .gender-options {
            margin: 10px 0; /* Add some margin above and below */
            display: flex; /* Use flexbox for horizontal alignment */
            align-items: center; /* Center items vertically */
        }
        .gender-options input {
            margin-right: 5px; /* Space between radio button and label */
        }
        .submit-btn {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #007bff;
            color: white;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .submit-btn:hover {
            background-color: #0056b3;
        }
        .back-link {
            text-align: center;
            margin-top: 15px;
        }
        .back-link a {
            color: #007bff;
            text-decoration: none;
        }
        .back-link a:hover {
            text-decoration: underline;
        }

        /* Media Queries */
        @media (max-width: 600px) {
            .form-container {
                padding: 20px;
            }

            h1 {
                font-size: 1.5rem; /* Adjust heading size for smaller screens */
            }
            
            .submit-btn {
                font-size: 0.9rem; /* Smaller button font size */
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Registration Form</h1>
        <form name="regform" action="" method="POST">
            <label for="nm">Name:</label>
            <input type="text" id="nm" name="nm" required>

            <label for="uname">Username:</label>
            <input type="text" id="uname" name="uname" required>

            <label for="passwd">Password:</label>
            <input type="password" id="passwd" name="passwd" required>

            <label for="repasswd">Retype Password:</label>
            <input type="password" id="repasswd" name="repasswd" required>

            <label for="phno">Phone No:</label>
            <input type="text" id="phno" name="phno" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="usertype">User Type:</label>
            <select id="usertype" name="usertype" required>
                <option value="">Select</option>
                <option value="pass">Passenger</option>
                <option value="drive">Driver</option>
                <option value="own">Owner</option>
            </select>

            <label class="gender-label">Gender:</label>
            <div class="gender-options">
                <input type="radio" name="gender" id="m" value="male" required>
                <label for="m">Male</label>&nbsp&nbsp&nbsp&nbsp&nbsp
                <input type="radio" name="gender" id="f" value="female">
                <label for="f">Female</label>&nbsp&nbsp&nbsp&nbsp&nbsp
                <input type="radio" name="gender" id="t" value="transgender">
                <label for="t">Transgender</label>
            </div>

            <button type="submit" class="submit-btn">Register</button>
        </form>
        <div class="back-link">
            <a href="index.html"><i class="fa fa-arrow-circle-left"></i> Go Back</a>
        </div>
    </div>
</body>
</html>
