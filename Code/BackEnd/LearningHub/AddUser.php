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


//check if user came from HTTP Post 
class AddUser {
  private $db;

  public function __construct(DatabaseConnection $db) {
      $this->db = $db;
  }

  public function addNewUser($username, $email, $password, $role) {
      $conn = $this->db->getConnection();
      $stmt = $conn->prepare("INSERT INTO `users` (`username`, `password`, `email`, `role`) values(?, ?, ?, ?)");
      $stmt->bind_param("ssss", $username, $password, $email, $role);
      $execval = $stmt->execute();
      if (!$execval) {
          echo "Error: " . $stmt->error;
      } else {
          echo "User added successfully...";
      }
  }
}

$database = new DatabaseConnection();
$user = new AddUser($database);

if (isset($_POST['addBtn'])) {
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = $_POST['my-radio'];

  $user->addNewUser($username, $email, $password, $role);
}

?>



<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <style>
    /* CSS for the toolbar */
    .toolbar {
        background-color: #f2f2f2;
        height: 50px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
    }

    .toolbar__logo {
        font-size: 24px;
        font-weight: bold;
    }

    .toolbar__menu {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .toolbar__menu-item {
        margin-right: 20px;
        cursor: pointer;
    }

    .toolbar__menu-item:hover {
        text-decoration: underline;
    }

    /* CSS for the profile page */
    body {
        font-family: Arial, sans-serif;
    }

    .profile {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .profile__image {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
    }

    .profile__name {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .profile__info {
        font-size: 16px;
        line-height: 1.5;
        text-align: center;
        max-width: 400px;
        margin-bottom: 20px;
    }

    .profile__info-item {
        margin-bottom: 10px;
    }

    .profile__info-label {
        font-weight: bold;
        margin-right: 10px;
    }

    input[type="text"],
    input[type="email"],
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

    .container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        padding: 20px;
        max-width: 800px;
        margin: 0 auto;

    }

    a {
        text-decoration: none;
        color: black;
    }
    </style>

</head>

<body>
    <div class="toolbar">
        <div class="toolbar__logo"> <a href="Home Page.html">Learning HUB</a></div>
        <div class="toolbar__menu">
            <div class="toolbar__menu-item"><a href="Languge.html">Languge</a></div>
            <div class="toolbar__menu-item"><a href="Mathematics.html">Mathematics</a></div>
            <div class="toolbar__menu-item"> <a href="Technology.html">Technology</a></div>
        </div>

        <div <h1>
            </h1>

            <select id="menu" onchange="window.location.href=this.value;">
                <option value=""></option>
                <option value="notification.html">notification</option>
                <option value="profile.html">profile</option>

            </select>
        </div>
        <div class="toolbar__menu-item"><a href="login.html">Log out</a></div>
    </div>
    </div>
    <div class="profile">
        <img class="profile__image" src="https://via.placeholder.com/200" alt="Profile Image">
        <input type="submit" value="Edit Profle picture">
        <h1 class="profile__name"> <?php echo $_SESSION['username'] ; ?> (<?php echo $_SESSION['role'];?> )</h1>

        <h1>Add User Information</h1>
        <div class="container">

            <div class="right-side">
                <form action="#" method="post">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>

                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <label for="Role">Role:
                        <input type="radio" name="my-radio" value="Admin"> Admin
                        <input type="radio" name="my-radio" value="User"> User
                    </label>
                    <br>


                    <input type="submit" name="addBtn" value="Add">
                </form>
            </div>
        </div>


    </div>
    </div>
</body>

</html>