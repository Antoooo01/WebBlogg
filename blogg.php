<?php
session_start();

if (!isset($_SESSION['url'])) {
  $_SESSION['url'] = "index.html";
} 

//Database creation
$db = "CREATE DATABASE BloggDB";
$conn = mysqli_connect("localhost", "root", "");
mysqli_query($conn, $db);

$conn = mysqli_connect("localhost", "root", "", "BloggDB");

$createTable = "CREATE TABLE AccountTable(
    user VARCHAR(25) PRIMARY KEY,
    pass VARCHAR(30),
    author BOOLEAN
    )";

mysqli_query($conn, $createTable);

//Registration check
if(isset($_POST['Skapa'])){
    $user = $_POST['S_user'];
    $pass = $_POST['S_pass'];
    
    //check if user already exists
    $sql = "SELECT user, pass FROM AccountTable WHERE user='$user'";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) == 0) {
        //add account
        $addData = "INSERT INTO AccountTable (user, pass, author)
        VALUES ('$user','$pass', 0)";

        mysqli_query($conn, $addData);
        $_SESSION['url'] = "index.html";
    }
    else {
        //tell client username is taken
        echo "<p>Kontot finns redan</p>";
        $_SESSION['url'] = "skapaKonto.html";
    }


    //add account
    $addData = "INSERT INTO tableTest(firstName, lastName, user, pass)
        VALUES ('$user','$pass', 0)";

    mysqli_query($conn, $addData);
}

//Login check
if(isset($_POST['Inlogg'])){
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    //check if user already exists
    $sql = "SELECT pass FROM AccountTable WHERE user='$user'";
    $result = $conn->query($sql);

    if ($result && mysqli_fetch_array($result, MYSQLI_ASSOC)["pass"] == $pass) {
        //logga in
        echo "<p>Works</p>";
        $_SESSION['url'] = "homePage.php";
        $_SESSION['user'] = $user;
    }
    else{
        //Meddela att något är fel
        echo "<p>Kolla att användarnamn och lösenord stämmer</p>";
        $_SESSION['url'] = "index.html";
    }

}

$url = $_SESSION['url'];
header("Location:$url");

mysqli_close($conn);
?>