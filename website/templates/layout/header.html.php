<!DOCTYPE html>
<html>
<head>
    <title>Zeus Drive</title>
    <?php // Java script ?>
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>
    <?php // CSS ?>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" href="../css/FontAwesome/css/font-awesome.min.css">
</head>
<body>
    <div id="header">
        <div id="mainTitle">ZEUS DRIVE</div>
        <div id="username">
            <?php if(isset($_SESSION) && isset($_SESSION["IsLoggedIn"])){echo "<a href='/logout' style='color:blue;'>(" . $_SESSION["email"] . ")</a>"; } ?>
        </div>
    </div>