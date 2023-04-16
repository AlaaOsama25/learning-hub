<?php
// Database connection
if (empty(session_id()) && !headers_sent()) {
  session_start();
}

require_once 'connect.php';
$db = new connect();
$conn = $db->connection();

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
    $path = 'C:\xampp\htdocs\Articles' . $filename;

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


if(isset($_POST["uploadButton"])){
	


 $path = 'Videos/';

$allowedExts = array("mp3", "mp4");
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

if (in_array($extension, $allowedExts))

  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("VideosImported/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "VideosImported/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "VideosImported/" . $_FILES["file"]["name"];
	  $path = 'C:\xampp\htdocs\VideosImported' . $_FILES["file"]["name"];
	  if($extension=="mp3")
	  {
	  $type="Record";}
	  if($extension=="mp4")
	  {
	  $type="Video";}
	  
    $category = $_POST['hidden_category'];

	 
	  
	   $sql = "INSERT INTO content (ContentPath, CategoryName, Type
    ) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $path, $category, $type);

    // Execute the SQL statement

    if ($stmt->execute() === false) {
      echo "Error: " . $stmt->error;
      return;
    }

    echo "Record created successfully";
	  
      }
    }
  }
else
  {
  echo "Invalid file";
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
        justify-content: flex-start;
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
        width: 300px;
        height: 100px;
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
                <option value="profile.php">profile</option>

            </select>
        </div>
        <div class="toolbar__menu-item"><a href="login.php">Log out</a></div>
    </div>
    </div>
    <div class="container">
        <div class="center">
            <img src="image.jpg" alt="Login Image">
        </div>
    </div>
    <div class="share" style="align-items:left">

        <div>
            <fieldset>
                <legend></legend>
                <h1></h1>
                <p><a href="#" onclick="showPopup()">What do you to share ?</a></p>

                <div id="popup1" class="popup">
                    <p>puplisher
                        &nbsp; &nbsp;&nbsp;
                        <select id="menu1" name="category" onchange="">
                            <option value="" disabled selected>category name</option>
                            <option value="Language">Language</option>
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
                    <form class="record"action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                        <label for="file">Choose video or record:</label>
                        <input type="file" id="file" name="file">
                        <br><br>
						<input type="hidden" name="hidden_category" id="hidden_category" value="">
                        <input type="submit" value="Upload" name="uploadButton" >
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
					var category = document.getElementById("menu1").value;
                    document.getElementById("hidden_category").value = category;
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
    <div>
        <?php
        
$sql = "SELECT * FROM content";
$result = mysqli_query($conn, $sql);

// check if any rows returned
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        // use $row data to generate HTML code
        echo '<div class="container">';
        echo '<div class="Publicher">';
        echo '<h1>'.$row['CategoryName'].'</h1>';
        echo '<h3>'.$row['ContentPath'].'</h3>';
        echo '<p>'.$row['Type'].'</p>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo "0 results";
}
?>


        
</div>



</body>

</html>