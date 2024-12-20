<?php
// Start the session to store form data temporarily
session_start();

// If the form is submitted, process and store the data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and process input data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $gender = htmlspecialchars($_POST['gender']);
    $dob = htmlspecialchars($_POST['dob']);
    $hobbies = isset($_POST['hobbies']) ? implode(', ', $_POST['hobbies']) : 'None';

    // Initialize error message
    $errorMessage = "";

    // Check if the session already has the same data
    if (isset($_SESSION['name']) && isset($_SESSION['email']) && $_SESSION['name'] === $name && $_SESSION['email'] === $email) {
        $errorMessage = "The same data has already been submitted.";
    } else {
        // Store form data in session if it's not a duplicate
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        $_SESSION['gender'] = $gender;
        $_SESSION['dob'] = $dob;
        $_SESSION['hobbies'] = $hobbies;

        // Flag to show success message
        $formSubmitted = true;
    }
} else {
    $formSubmitted = false;
    $errorMessage = "";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #218838;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .back-btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            text-align: center;
            display: inline-block;
            margin-top: 20px;
        }

        .back-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($formSubmitted): ?>
            <!-- Success message after form submission -->
            <div class="success-message">
                <h3>Form Submitted Successfully!</h3>
                <p><strong>Name:</strong> <?php echo $_SESSION['name']; ?></p>
                <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
                <p><strong>Password:</strong> (Hidden for security)</p>
                <p><strong>Gender:</strong> <?php echo $_SESSION['gender']; ?></p>
                <p><strong>Date of Birth:</strong> <?php echo $_SESSION['dob']; ?></p>
                <p><strong>Hobbies:</strong> <?php echo $_SESSION['hobbies']; ?></p>
            </div>
            <!-- Back to form button -->
            <a href="web.php" class="back-btn">Back to Form</a>
        <?php else: ?>
            <!-- Registration form -->
            <h2>Online Registration Form</h2>
            <?php if ($errorMessage): ?>
                <div class="error-message"><?php echo $errorMessage; ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="form-group">
                    <label for="name">Full Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="button" id="toggle-password" style="margin-top: 5px;">Show</button>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" required>
                </div>
                <div class="form-group">
                    <label>Hobbies:</label>
                    <input type="checkbox" name="hobbies[]" value="Reading"> Reading
                    <input type="checkbox" name="hobbies[]" value="Traveling"> Traveling
                    <input type="checkbox" name="hobbies[]" value="Gaming"> Gaming
                </div>
                <button type="submit">Submit</button>
            </form>
        <?php endif; ?>
    </div>

    <script>
        // JavaScript to toggle the visibility of the password
        const passwordField = document.getElementById('password');
        const togglePasswordButton = document.getElementById('toggle-password');

        togglePasswordButton.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                togglePasswordButton.textContent = 'Hide';
            } else {
                passwordField.type = 'password';
                togglePasswordButton.textContent = 'Show';
            }
        });
    </script>
</body>
</html>