<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Show images in folder</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="inc/style.css">
    <!-- style for images insertion -->
    <link rel="stylesheet" type="text/css" href="inc/ins-imgs.css">
</head>
<body>

<?php
//***PHP debug
error_reporting(E_ALL);
ini_set('display_errors', 1);
//***
?>
    <header><div><h1>Show all images in my folder</h1></div></header>
    <!-- images insertion -->
    <?php include "inc/ins-imgs.php"; ?>
    <footer><div>2017 // source code <a target="_blank" href="https://github.com/dvdn/show-all-images-in-a-folder-with-php">dvdn/show-all-images-in-a-folder-with-php</a></div></footer>
</body>
</html>
