<?php 

    include("Includes/Connection.php");
    include("Includes/Functions_Index.php");

    //Update Website Stat
    $Query = "UPDATE total_visits SET Total_Visits=Total_Visits+1";
    $Result = $Connection->query($Query);

    if(isset($_GET['PostID'])){
        $PostID = $_GET['PostID'];  
        GetTitle($PostID);
    }
?>

<!DOCTYPE html>
<html>
<title><?php echo (defined('TITLE')) ? TITLE . " &mdash;" : "" ?> My Own Blog</title>
 <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="refresh" content="10800"/>
<meta name="description" content="">
<link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicon.png">

<link rel="stylesheet" href="assets_blog/style.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
<link href="Admin/css/animate.css" rel="stylesheet">
<script src="Admin/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<script src="Admin/plugins/bower_components/jquery-ui/jquery-ui.min.js"></script>
<link rel="icon" type="image/png" sizes="16x16" href="Admin/plugins/images/favicon.png">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> 

<style>
    body,h1,h2,h3,h4,h5 {
        /* font-family: "Raleway", sans-serif */
    }
</style>

<body class="w3-light-grey">