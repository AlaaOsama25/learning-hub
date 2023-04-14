<?php
// Database connection
if (empty(session_id()) && !headers_sent()) {
  session_start();
}

require_once 'connect.php';
$db = new connect();
$conn = $db->connection();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
	// Redirect to the login page if not logged in
	header('Location: LoginPage.php');
	exit;
}

// Get the username from the session
$username = $_SESSION['username'];

if (!$conn) {
  echo "<script>alert('Connection failed: " . mysqli_connect_error() . "')</script>";
}

if (isset($_POST['addButton'])) {
  //Code to handle form submission goes here

  $category = $_POST['hidden_category'];
  $content = $_POST['textarea'];

  if (!empty($content)) {

    // Generate a unique filename for the text file
    $filename = uniqid() . '.txt';

    // Define the path where the text file will be saved
    $path = 'C:\xampp\htdocs\LearningHub\articleContents\. . $filename;

    // Save the content to the text file and check for errors
    $result = file_put_contents($path, $content);
    if ($result === false) {
      echo "Error: Could not save file";
      return;

    }

    // Prepare the SQL statement to insert the file path into the database
    $sql = "INSERT INTO content (ContentPath, CategoryName
    ) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $path, $category);

    // Execute the SQL statement

    if ($stmt->execute() === false) {
      echo "Error: " . $stmt->error;
      return;
    }

    echo "Record created successfully";

  } else {
    echo "Error: Content is empty";
    exit;
  }

}

?>
<!DOCTYPE html>

<html>

<head>
    <meta charset="UTF-8">
    <title>Home Page </title>
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

    .left-side {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 800px;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        margin: 0 auto;
    }

    .images {
        max-width: 100%;
        height: 5 px;
        margin-bottom: 20px;
        align: center;
    }

    .share {
        display: flex;
        flex-wrap: wrap;

        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 10px;
        margin: 0 auto;
    }

    /* CSS for the frame */
    fieldset {
        border: 2px solid #ddd;
        padding: 10px;
        margin: 20px 0;
    }

    legend {
        font-weight: bold;
    }

    /* CSS for the overlay */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
    }

    .overlay-content {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        text-align: center;
    }

    /* Style for the pop-up */
    .popup {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        width: 400px;
        height: 140px;
        transform: translate(-50%, -50%);
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        z-index: 9999;
    }

    .close-button {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
    }

    a {
        text-decoration: none;
        color: black;
    }
    </style>
    <script>
    // JavaScript to show/hide the overlay
    function showOverlay() {
        document.querySelector('.overlay').style.display = "flex";
    }

    function hideOverlay() {
        document.querySelector('.overlay').style.display = "none";
    }
    </script>




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
    <div class="container">
        <div class="center">
            <img src="image.jpg" alt="Login Image">
        </div>
    </div>
    <div class="share" style="align-items:left">

        <div>
            <h1>Hello <?php echo $username; ?></h1>
            <fieldset>
                <legend></legend>
                <h1></h1>
                <p><a href="#" onclick="showPopup()">What do you to share ?</a></p>

                <div id="popup1" class="popup">
                    <p>puplisher
                        &nbsp; &nbsp;&nbsp;
                        <select id="menu1" name="category" onchange="">
                            <option value="" disabled selected>category</option>
                            <option value="Languge">Languge</option>
                            <option value="Mathematics">Mathematics</option>
                            <option value="Technology">Technology</option>
                        </select>
                    </p>
                    <button onclick="showPopup2()">Upload</button>
                    <button onclick="showPopup3(); return false;">Article</button>
                    <span class="close-button"
                        onclick="document.getElementById('popup1').style.display = 'none'">&times;</span>
                </div>



                <div id="popup2" class="popup">
                    <p></p>
                    <span class="close-button"
                        onclick="document.getElementById('popup2').style.display = 'none'">&times;</span>
                    <form class="record" action="upload.php" method="POST" enctype="multipart/form-data">
                        <label for="voice">Choose record:</label>
                        <input type="file" id="voice" name="voice" accept="audio/*">
                        <br><br>
                        <input type="submit" value="Upload">
                    </form>
                </div>
                <div id="popup3" class="popup">
                    <p></p>
                    <span class="close-button"
                        onclick="document.getElementById('popup3').style.display = 'none'">&times;</span>
                    <label for="textarea">Enter your message:</label><br><br>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                        <textarea id="textarea" name="textarea" rows="4" cols="50"></textarea><br>
                        <input type="hidden" name="hidden_category" id="hidden_category" value="">
                        <input type="submit" value="add" name="addButton">
                </div>
                </form>

                <script>
                function showPopup() {
                    document.getElementById("popup1").style.display = "block";
                }

                function showPopup2() {
                    document.getElementById("popup2").style.display = "block";
                }

                function showPopup3() {
                    document.getElementById("popup3").style.display = "block";
                    var category = document.getElementById("menu1").value;
                    document.getElementById("hidden_category").value = category;
                }
                </script>
            </fieldset>
        </div>

    </div>

    <div class="container">

        <div class="Publicher ">
            <h1>Hasnaa Ahmed </h1>
            <h3> Languge </h3>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed auctor tristique lorem, vel sagittis elit.
                Nulla facilisi. Fusce sit amet dolor at augue ullamcorper auctor. Praesent varius luctus ex, ac rutrum
                turpis suscipit sit amet. Sed vel tellus eu massa molestie malesuada. Aenean vehicula, lorem sit amet
                pharetra aliquam, velit velit elementum lectus, ut tempus turpis sem vel enim. Praesent vel magna quam.
                Aliquam erat volutpat. Mauris lobortis arcu vel pellentesque pulvinar. Ut sed diam ac sapien feugiat
                consectetur.</p>
        </div>
    </div>
    <div class="container">
        <div class="Publicher ">
            <h1>Nada Mandour </h1>
            <h3> technology </h3>
            <img class="images" src="technology.jpg" alt="technology Image">
        </div>
    </div>



</body>

</html>