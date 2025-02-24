<?php

include("Includes/Connection.php");
include("Includes/Functions_Index.php");

//Update Website Stat
$Query = "UPDATE total_visits SET Total_Visits=Total_Visits+1";
$Result = $Connection->query($Query);

if (isset($_GET['PostID'])) {
    $PostID = $_GET['PostID'];
    GetTitle($PostID);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
<title>Sonu | Blog</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="https://kit.fontawesome.com/0b170b98a9.js" crossorigin="anonymous"></script>

	

	<link rel="icon" type="image/png" href="images/favicon.jpg">

	<!--main file-->
	<link href="css/medical-guide.css" rel="stylesheet" type="text/css">

	<!--Medical Guide Icons-->
	<link href="fonts/medical-guide-icons.css" rel="stylesheet" type="text/css">

	<!-- Default Color-->
	<link href="css/default-color.css" rel="stylesheet" id="color" type="text/css">

	<!--bootstrap-->
	<link href="css/bootstrap.css" rel="stylesheet" type="text/css">

	<!--Dropmenu-->
	<link href="css/dropmenu.css" rel="stylesheet" type="text/css">

	<!--Sticky Header-->
	<link href="css/sticky-header.css" rel="stylesheet" type="text/css">

	<!--revolution-->
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="css/settings.css" rel="stylesheet" type="text/css">
	<link href="css/extralayers.css" rel="stylesheet" type="text/css">

	<!--Accordion-->
	<link href="css/accordion.css" rel="stylesheet" type="text/css">

	<!--tabs-->
	<link href="css/tabs.css" rel="stylesheet" type="text/css">

	<!--Owl Carousel-->
	<link href="css/owl.carousel.css" rel="stylesheet" type="text/css">

	<!--PieChart-->
	<link href="css/piechart-style.css" rel="stylesheet" type="text/css">

	<!-- Mobile Menu -->
	<link rel="stylesheet" type="text/css" href="css/jquery.mmenu.all.css" />
	<link rel="stylesheet" type="text/css" href="css/demo.css" />

	<!--PreLoader-->
	<link href="css/loader.css" rel="stylesheet" type="text/css">
	<!-- fontaswome  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<style>
        @import url('https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

        .cust-font {
            font-family: 'Raleway', sans-serif;
        }

        .cust-weight {
            font-weight: 300;
        }
    </style>
    <!-- <link href="../css/style.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="assets_blog/style.css">
    
</head>

<body>
		

<div id="wrap">

<?php 
include("header.php"); 
?>
	
		

    <?php
    // include("Includes/Header.php");
    include("Includes/TagsBody.php");

    ?>
<!-- </div> -->

<!-- footer area start -->
<!-- Header area start -->
<?php 
include("footer.php"); 
?>
<!-- Header area end -->
<!-- footer area end -->


	<a href="#0" class="cd-top"></a>

<script type="text/javascript" src="js/jquery.js"></script>

<!-- SMOOTH SCROLL -->
<script type="text/javascript" src="js/scroll-desktop.js"></script>
<script type="text/javascript" src="js/scroll-desktop-smooth.js"></script>

<!-- START REVOLUTION SLIDER -->
<script type="text/javascript" src="js/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="js/jquery.themepunch.tools.min.js"></script>


<!-- Date Picker and input hover -->
<script type="text/javascript" src="js/classie.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.10.3.custom.js"></script>


<!-- Date Picker and input hover -->
<script type="text/javascript" src="js/jquery.fancybox.js"></script>
<script type="text/javascript" src="js/jquery.fancybox-media.js"></script>


<!-- Welcome Tabs -->
<script type="text/javascript" src="js/tabs.js"></script>


<!-- All Carousel -->
<script type="text/javascript" src="js/owl.carousel.js"></script>

<!-- Mobile Menu -->
<script type="text/javascript" src="js/jquery.mmenu.min.all.js"></script>

<!-- All Scripts -->
<script type="text/javascript" src="js/custom.js"></script>

<script>
	<!-- Fancybox -->
	/*
				 *  Simple image gallery. Uses default settings
				 */

	$('.fancybox').fancybox();

	/*
	 *  Different effects
	 */

	$(document).ready(function () {
		$('.fancybox-media').fancybox({
			openEffect: 'none',
			closeEffect: 'none',
			helpers: {
				media: {}
			}
		});
	});
</script>



        
</body>

</html>