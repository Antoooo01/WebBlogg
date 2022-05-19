<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Home Page</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h2>Min Blogg</h2>
    <div id="mainPage">
        <div id="feed">
            <h4>Feed</h4>
            <?php
                //Loops trough the database of entries and displays them in cards
                $conn = mysqli_connect("localhost", "root", "", "BloggDB");
                $sql = "SELECT * FROM Feed";
                $result = $conn->query($sql);

                if (!$result) {
                    trigger_error('Invalid query: ' . $conn->error);
                }
                else if ($result->num_rows > 0) {
                // output data of each row
                    while($row = $result->fetch_assoc()) {
                        //style a bootstrap card and fill the feed
                        echo "<div class=\"card\" style=\"width: 95%; justify-content:center;\">
                            <div class=\"card-body\">
                                <h5 class=\"card-title\">".$row["title"]."</h5>
                                <p class=\"card-text\">".$row["content"]."</p>
                            </div>
                        </div>";
                    }
                }else {
                    echo "0 results";
                }
                mysqli_close($conn);
            ?>
        </div>

        <div id="profile">
            <h4>Profil</h4>
            <!-- Hann inte
            <p>välj färg</p>
            <select name="colors" id="colors">
                <option value="1">Röd</option>
                <option value="2">Blå</option>
                <option value="3">Grön</option>
                <option value="4">Vit</option>
            </select>
            <button onclick="UpdateBackground()">Spara</button>
            <br>
            -->
            <?php 
                //checks if the logged in user is an author, and displays a link for submissions
                $conn = mysqli_connect("localhost", "root", "", "BloggDB");
                $user = $_SESSION['user'];
                $sql = "SELECT author FROM AccountTable WHERE user='$user'";
                $result = $conn->query($sql);
                
                if (mysqli_fetch_array($result, MYSQLI_ASSOC)["author"]) {
                echo '<a href="inlägg.php">Gör ett inlägg</a>';
                }
                mysqli_close($conn);
            ?>
        </div>
    </div>
</body>
</html>