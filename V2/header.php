<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>My Website</title>
        <link rel="stylesheet" href="css/reset.css">
        <link rel="stylesheet" href="css/web_style_1.css">
    </head>

    <body>
        <nav>
            <div class="wrapper">
                <ul>
                <li><a display:inline href="./index">Home</a></li>
                <li><a display:inline href="./about">About</a></li>
                <li><a display:inline href="./GEANT4">GEANT4</a></li>
                <li><a display:inline href="./ROOT">ROOT</a></li>
                <li><a display:inline href="./contact">Contact</a></li>
                <li><a display:inline href="./archive">Archive</a></li>
                    <?php
                        #if (isset($_SESSION["useruid"])) {
                            #echo "<li><a href='profile.php'>Profile Page</a></li>";
                            #echo "<li><a href='includes/logout.inc.php'>Logout</a></li>";
                        #}
                        #else {
                            #echo "<li><a href='signup.php'>Signup</a></li>";
                            #echo "<li><a href='login.php'>Login</a></li>";
                        #}
                    ?>
                </ul>
            </div>
        </nav>

        <div class="wrapper">