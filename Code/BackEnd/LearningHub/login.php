<?php

class DatabaseConnection {
	private $db;

	public function __construct() {
		session_start();
		require_once 'connect.php';
		$this->db = new connect();
	}

	public function getConnection() {
		return $this->db->connection();
	}
}

class login {
	private $db;

	public function __construct(DatabaseConnection $db) {
		$this->db = $db;
	}

	public function authenticateUser($username, $password) {
		$conn = $this->db->getConnection();
		$stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ? LIMIT 1");
		$stmt->bind_param("ss", $username, $password);
		$execval = $stmt->execute();

		if (!$execval) {
			echo "Error: " . $stmt->error;
		} else {
			$result = $stmt->get_result();
			if ($result->num_rows == 1) {
				$row = $result->fetch_assoc();
				// Set the username in the session
				$_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['role'] = $row['role'];


				echo "Login successfully...";
				header('Location: HomePage.php');
			} else {
				echo "Invalid username or password.";
			}
		}
	}
}

// Usage
$database = new DatabaseConnection();
$auth = new login($database);
if (isset($_POST['loginbtn'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];
	$auth->authenticateUser($username, $password);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login Page</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f2f2f2;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        padding: 20px;
        max-width: 800px;
        margin: 0 auto;
    }

    .left-side {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .right-side {
        flex: 1;
        padding: 20px;
        background-color: #fff;
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    }

    img {
        max-width: 100%;
        height: auto;
        margin-bottom: 20px;
    }

    input[type="text"],
    input[type="password"] {
        padding: 10px;
        border-radius: 3px;
        border: none;
        width: 100%;
        margin-bottom: 20px;
        box-sizing: border-box;
        background-color: #f2f2f2;
    }

    input[type="submit"] {
        background-color: #4CAF50;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;

    }

    input[type="submit"]:hover {
        background-color: #3e8e41;
    }

    label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }

    h1 {
        text-align: center;
        margin-top: 50px;
        margin-bottom: 20px;
    }

    .signup-link {
        display: block;
        margin-top: 20px;
        text-align: center;
        font-size: 14px;
        color: #666;
    }

    .signup-link a {
        color: #4CAF50;
        text-decoration: none;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <h1>Login Page</h1>
    <div class="container">
        <div class="left-side">
            <img src="image.jpg" alt="Login Image">
        </div>
        <div class="right-side">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" value="Login" name="loginbtn"
                    ></button>

            </form>
            <div class="signup-link">
                Don't have an account? <a href="signup.php">Sign up</a>
            </div>
        </div>
    </div>
</body>

</html>