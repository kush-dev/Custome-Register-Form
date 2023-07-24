<?php
session_start();

// Database connection details
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "users";

// Create a new mysqli object and establish a connection to the database
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve user input from the form
    
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Perform basic input validation
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    if (empty($email)) {
        $errors[] = "Email is required";
    }
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    // If there are no errors, insert the user data into the database
    if (empty($errors)) {
        // Prepare the SQL statement
        $sql = "INSERT INTO users2 (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind parameters to the statement
        $stmt->bind_param("sss",$username, $email, $password);

        // Execute the statement
        if ($stmt->execute()) {
            // User registration successful
            $_SESSION["success_message"] = "Registration successful!";
            header("Location: welcome.php");
            exit();
        } else {
            $errors[] = "An error occurred while registering. Please try again.";
        }

        // Close the statement
        $stmt->close();
    }
}
?>

<!-- HTML form -->
<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" type="text/css" href="signup.css">
    <title>User Registration</title>
</head>
<body>
    <h2>User Registration</h2>
    <div class='error'>
       <?php
       // Display error messages, if any
      if (!empty($errors)) {
          echo "<ul>";
          foreach ($errors as $error) {
            echo "<li>$error</li>";
         }
         echo "</ul>";
       }
      ?>
    </div>
    <form method="POST" action="">
        

        <label>Username:</label>
        <input type="text" name="username"><br>

        <label>Email:</label>
        <input type="email" name="email"><br>


        <label>Password:</label>
        <input type="password" name="password"><br>

        <input type="submit" value="Register">
        <br>
        <h6 style="text-decoration: red;"><a href="login.php">Already have an account? Login here</a></h6>
    </form>
    
                </form>
            </div>
        </div>
        <footer class="row tm-mt-big mb-3">
            <div class="col-xl-12">
                <p class="text-center grey-text text-lighten-2 tm-footer-text-small">
                    Copyright &copy; 2022 Sub-County Hospital


                </p>
            </div>
        </footer>
    <script src="js/jquery-3.2.1.slim.min.js"></script>
    <script src="js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select').formSelect();
        });
    </script>
</body>
</html>
