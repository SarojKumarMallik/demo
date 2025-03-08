<?php
// Include the database connection
include("Includes/Connection.php");
date_default_timezone_set("Asia/Karachi");

// Check if the slug exists in the URL
if (isset($_GET['slug'])) {
    $PostSlug = ValidateFormData($_GET['slug']);
    // Fetch the Post ID using the slug
    $Query = "SELECT Post_ID FROM blog_post WHERE Post_Slug = '$PostSlug' LIMIT 1";
    $Result = $Connection->query($Query);

    if ($Result && $Result->num_rows > 0) {
        $Row = $Result->fetch_assoc();
        $PostID = $Row['Post_ID'];
    } else {
        echo "<p>Post not found for slug: $PostSlug</p>";
        header("Location: index.php");
        exit();
    }
} else {
    echo "<p>No slug provided.</p>";
    header("Location: index.php");
    exit();
}


// Update Post Stats
$Query = "SELECT * FROM post_visits WHERE Post_ID = '$PostID'";
$Result = $Connection->query($Query);

// $Query1 = "SELECT * FROM blog_post WHERE Post_ID = '$PostID'";
// $Result1 = $Connection->query($Query1);

// if ($Result1->num_rows > 0) {
//     while($row = $Result1->fetch_assoc()) {
//       // Meta
//         $MetaTitle=$row['MetaTitle'];
      
//         $MetaDesc = $row['MetaDesc'];
//         $MetaKey = $row['MetaKey'];
//       //   Meta
//     }
// } 
//meta Information
// if ($Result && $Result->num_rows > 0) {
//    $Row = $Result->fetch_assoc();
//    $MetaTitle = $Row['MetaTitle'];
//    $MetaDesc = $Row['MetaDesc'];
//    $MetaKey = $Row['MetaKey'];
// }
// Meta Information

if ($Result && $Result->num_rows > 0) {
    $Query = "UPDATE post_visits SET Post_Visits = Post_Visits + 1 WHERE Post_ID = '$PostID'";
    $Connection->query($Query);
} else {
    $Query = "INSERT INTO post_visits(Post_ID, Post_Visits) VALUES($PostID, 1)";
    $Connection->query($Query);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-G6Z6Y153JZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-G6Z6Y153JZ');
</script>

<title>Sonu | Blog</title>
	<!-- meta -->
	<meta name="keywords" content="<?php echo $MetaKey?>">
    <meta name="description" content="<?php echo $MetaDesc?>">
    <meta name="title" content="<?php echo $MetaTitle?>">
    <!-- meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="https://kit.fontawesome.com/0b170b98a9.js" crossorigin="anonymous"></script>

	

	<link rel="icon" type="image/png" href="../images/favicon.jpg">

	<!--main file-->
	<link href="../css/medical-guide.css" rel="stylesheet" type="text/css">

	<!--Medical Guide Icons-->
	<link href="../fonts/medical-guide-icons.css" rel="stylesheet" type="text/css">

	<!-- Default Color-->
	<link href="../css/default-color.css" rel="stylesheet" id="color" type="text/css">

	<!--bootstrap-->
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">

	<!--Dropmenu-->
	<link href="../css/dropmenu.css" rel="stylesheet" type="text/css">

	<!--Sticky Header-->
	<link href="../css/sticky-header.css" rel="stylesheet" type="text/css">

	<!--revolution-->
	<link href="../css/style.css" rel="stylesheet" type="text/css">
	<link href="../css/settings.css" rel="stylesheet" type="text/css">
	<link href="../css/extralayers.css" rel="stylesheet" type="text/css">

	<!--Accordion-->
	<link href="../css/accordion.css" rel="stylesheet" type="text/css">

	<!--tabs-->
	<link href="../css/tabs.css" rel="stylesheet" type="text/css">

	<!--Owl Carousel-->
	<link href="../css/owl.carousel.css" rel="stylesheet" type="text/css">

	<!--PieChart-->
	<link href="../css/piechart-style.css" rel="stylesheet" type="text/css">

	<!-- Mobile Menu -->
	<link rel="stylesheet" type="text/css" href="../css/jquery.mmenu.all.css" />
	<link rel="stylesheet" type="text/css" href="../css/demo.css" />

	<!--PreLoader-->
	<link href="../css/loader.css" rel="stylesheet" type="text/css">
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
    <!-- Template Stylesheet -->
    <!-- <link href="../css/style.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="../assets_blog/style.css">
</head>
<body>

		<!--Start Top Bar-->
 <div class="top-bar">
	<div class="container">
		<div class="row">

			<div class="col-md-5">
				<span>Sonu Hospital Come to Expect the Best in Town.</span>
			</div>

			<div class="col-md-7">
				<div class="get-touch">

					<ul>
						<li><a href="tel:+91 +919686151857"><i class="icon-phone4"></i>+919686151857</a></li>
						<li><a href="mailto:info@sonuhospital.com"><i
									class="icon-mail"></i>info@sonuhospital.com</a></li>
					</ul>

					<ul class="social-icons">
                        <li><a href="https://www.facebook.com/SonuHospitalBegur" class="fb"><i
                                    class="icon-euro"></i> </a></li>
                        <li><a href="https://www.instagram.com/sonu_hospital/" class="tw"><i
                                    class="fa fa-instagram"></i> </a></li>
                        <li><a href="https://www.linkedin.com/company/sonu-hospital/"
                                class="gp"><i class="fa fa-linkedin"></i> </a></li>
                        <li><a href="https://www.google.com/maps?ll=12.898988,77.626797&z=13&t=m&hl=en&gl=IN&mapclient=embed&cid=6124837909030033745"
                                class="gp"><i class="icon-caddieshoppingstreamline"></i> </a></li>
								<li><a href="https://www.youtube.com/@Sonu-Hospital" class="gp"><i class="fa fa-youtube"></i> </a></li>

                    </ul>

				</div>
			</div>

		</div>
	</div>
</div>
<!--Top Bar End-->

<!--Start Header-->
<header class="header">
	<div class="container">


		<div class="row">

			<div class="col-md-3">
				<a href="../index.html" class="logo"><img style="width: 165px;" src="../images/sonu_logo.jpg" alt=""></a>
			</div>

			<div class="col-md-9">


				<nav class="menu-2">
					<ul class="nav wtf-menu">
						<li class="parent"><a href="../index.html">Home</a>
						</li>

						<li class="parent"><a href="../about-us.html">About Us</a>
						</li>

						<li class="parent"><a href="../services.html">Services</a>
						</li>

						<li class="parent"><a href="../gallery.html">Gallery</a>
						</li>

						<li class="parent"><a href="../team.html">Doctors</a>
						</li>
                        <li class="item-select parent"><a href="../blog.php">Blog</a>
						</li>
						<li class="parent"><a href="../contact-us2.html">Contact Us</a>
						</li>

						

					</ul>
				</nav>

			</div>

		</div>


	</div>
</header>
<!--End Header-->


		<!--Start Banner-->

		<div class="sub-banner">

			<img class="banner-img" src="../images/Banner/gallery.webp" alt="">
			<div class="detail">
				<div class="container">
					<div class="row">
						<div class="col-md-12">

							<div class="paging" style="text-align: center;
                            display: flex;
                            flex-direction: column;
                            align-items: center;">
								<h2 style="margin-left: -23px; text-transform:none;">Blog</h2>
								<ul>
									<li><a href="../index.html">Home</a></li>
									<li><a href="../blog.php">blog</a></li>
									<li><?php blogTitle($PostID); ?></li>
								</ul>
							</div>

						</div>
					</div>
				</div>
			</div>

		</div>

		<!--End Banner-->
      

        <!-- start post-body -->
        <div class="w3-row">
            <div class="w3-container"><?php echo isset($CommentMessage) ? $CommentMessage : ""; ?></div>
            <div class="w3-col l8 s12">
                <!-- Display the post content -->
                <?php DisplayPost($PostID); ?>

                <!-- COMMENTS -->
                <div class="w3-margin">
                    <div class="w3-container">
                        <h4><b style="color:black; text-transform:none;">Comments</b></h4>
                        <hr>
                    </div>
                    <form method="post" action="" class="w3-container"
                        style="background-color:aliceblue;padding:30px 10px">
                        <div class="w3-row-padding">
                            <p class="w3-text-red"> <?php echo isset($NameError) ? $NameError : ""; ?></p>
                            <p class="w3-text-red"> <?php echo isset($CommentError) ? $CommentError : ""; ?></p>
                            <div class="w3-quarter">
                                <input name="Name" class="w3-input w3-round" type="text" placeholder="Your Name"
                                    required>
                            </div>
                            <div class="w3-rest">
                                <textarea name="Comment" style="resize: none;" rows="1" class="w3-input w3-round"
                                    placeholder="Your Comment" required></textarea>
                            </div>
                            <input name="PostId" value="<?php echo $PostID ?>" type="hidden">
                            <div style="margin-left:10px;margin-top:20px">
                                <button style="background-color:#FF7C5B;color:white;padding:15px 40px" name="AddComment"
                                    type="submit" class="w3-button w3-white w3-border"><b>Comment</b></button>
                            </div>
                        </div>
                    </form>
                    <hr>
                    <?php DisplayComments($PostID); ?>
                </div>
                <!-- END COMMENTS -->
            </div>

            <!-- Sidebar -->
            <div class="w3-col l4">
                <div class="w3-card w3-margin">
                    <div class="w3-container w3-padding">
                        <h4 style="color:black;text-transform: none;">Popular Posts</h4>
                    </div>
                    <ul class="w3-ul w3-hoverable w3-white">
                        <?php PopularPosts(); ?>
                    </ul>
                </div>
                <hr>
                <div class="w3-card w3-margin">
                    <div class="w3-container w3-padding">
                        <h4 style="color:black;text-transform: none;">Tags</h4>
                    </div>
                    <div class="w3-container w3-white">
                        <p><?php Tags(); ?></p>
                    </div>
                </div>
            </div>
            <!-- END Sidebar -->
        </div>
        <!-- end post-body -->


    </div><!-- /.page-wrapper -->

 


 <!--Start Footer-->
 <footer class="footer" id="footer">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="emergency">
                    <i class="icon-phone5"></i>
                    <span class="text">For emergency cases</span>
                    <a href="tel:+91 +919686151857"><span class="number">+919686151857</span></a>
					<span>
						<a href="tel:080-25744114" class="em-cases"><span class="number">080-25744114</span></a>
						<a href="tel:08041154114" class="em-cases"><span class="number">080-41154114 </span></a>
					</span>
                    <img src="images/emergency-divider.png" alt="">
                </div>
            </div>
        </div>


        <div class="main-footer">
            <div class="row">

                <div class="col-md-3">

                    <div class="useful-links">
                        <div class="title">
                            <h5>ABOUT US</h5>
                        </div>

                        <div class="detail">
                            <div class="signup-text">
                                <i class=""></i>
                                <span style="color: white;font-size:14px">
									“To care for anyone else enough to make their problems one’s
own is ever the beginning of one’s real humanity.”
								</span>
                            </div>
                        </div>
                        <div class="">
                            <h5>
                                <p>&nbsp;</p>
                            </h5>
                        </div>
                        <div class="">
                            <img src="../images/sonu_logo.jpg" style="width: 190px;" alt="">
                        </div>
                    </div>

                </div>


                <div class="col-md-3">

                    <div class="useful-links">
                        <div class="title">
                            <h5>Medical guide</h5>
                        </div>

                        <div class="detail">
                            <ul>
                                <li><a href="../index.html">Home</a></li>
                                <li><a href="../about-us.html">About Us</a></li>
                                <li><a href="../services.html">Services</a></li>
                                <li><a href="../gallery.html">Gallery</a></li>
                                <li><a href="../team.html">Specilaties</a></li>
                                <li><a href="../contact-us2.html">Contact Us</a></li>

                            </ul>
                        </div>

                    </div>

                </div>

                <div class="col-md-3">

                    <div class="get-touch">
                        <div class="title">
                            <h5>GET IN TOUCH</h5>
                        </div>

                        <div class="detail">
                            <div class="get-touch">


                                <span class="text">For inquiries or appointments, contact Sonu Hospital
                                    today.</span>


                                <ul>
                                    <li><a style="display: flex; align-items: center;" href="https://maps.app.goo.gl/p7etrEEZANdLQCV67"><i
                                                class="icon-location"></i> <span>Sonu Hospital, Begur Rd, Hongasandra, Bengaluru, Karnataka 560068</span></a></li>
												<li style="display: flex; align-items: center;"><i class="icon-phone4"></i>
                                                    <div class="num" style="display: flex; flex-direction: column;">
                                                       <a href="tel:8025744114"><span>080-25744114</span></a> 
                                                       <a href="tel:8041154114"><span>080-41154114</span></a>
                                                       <a href="tel:9686151857"><span>+91 9686151857</span></a>
                                                    </div>
                                                        
                                                </li>
                                    <li><a href="mailto:info@sonuhospital.com"><i
                                                class="icon-dollar"></i>
                                            <span>info@sonuhospital.com</span></a></li>
                                </ul>

                            </div>
                        </div>

                    </div>

                </div>

                <div class="col-md-3">


                    <div class="title">
                        <h5>GET DIRECTION</h5>
                    </div>

                    <div class="detail">

                        <div class="tweets">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d62226.172841863714!2d77.626797!3d12.898988!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bae15b376b575e3%3A0x54ffcba0a294d951!2sSonu%20Hospital!5e0!3m2!1sen!2sin!4v1727422553256!5m2!1sen!2si"
                                width="270" height="240" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                    </div>



                </div>

            </div>

        </div>

    </div>

    <div class="footer-bottom">
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <span class="copyrights">Copyright &copy; 2024 Sonu Hospital. All right reserved.</span>
                </div>

                <div class="col-md-6">
					<div class="social-icons">
						<a href="https://www.facebook.com/SonuHospitalBegur" class="fb"><i
								class="icon-euro"></i></a>
						<a href="https://www.google.com/maps/place/Sonu+Hospital/@12.898988,77.626797,13z/data=!4m6!3m5!1s0x3bae15b376b575e3:0x54ffcba0a294d951!8m2!3d12.898988!4d77.6267973!16s%2Fg%2F11rhrk59g7?hl=en&entry=ttu&g_ep=EgoyMDI0MTAwMi4xIKXMDSoASAFQAw%3D%3D"
							class="icon-caddieshoppingstreamline"></a>
						<a href="https://www.instagram.com/sonu_hospital/" class="gp"><i
								class="fa fa-instagram"></i></a>
						<a href="https://www.linkedin.com/company/sonu-hospital/"
							class="vimeo"><i class="fa fa-linkedin"></i></a>

						<a href="https://www.youtube.com/@Sonu-Hospital" class="gp"><i class="fa fa-youtube"></i> </a>

					</div>
				</div>

            </div>
        </div>

        <a class="back-to-top" href="#."></a>

    </div>

</footer>
<!--End Footer-->


<a href="#0" class="cd-top"></a>

	<script type="text/javascript" src="../js/jquery.js"></script>

	<!-- SMOOTH SCROLL -->
	<script type="text/javascript" src="../js/scroll-desktop.js"></script>
	<script type="text/javascript" src="../js/scroll-desktop-smooth.js"></script>

	<!-- START REVOLUTION SLIDER -->
	<script type="text/javascript" src="../js/jquery.themepunch.revolution.min.js"></script>
	<script type="text/javascript" src="../js/jquery.themepunch.tools.min.js"></script>


	<!-- Date Picker and input hover -->
	<script type="text/javascript" src="../js/classie.js"></script>
	<script type="text/javascript" src="../js/jquery-ui-1.10.3.custom.js"></script>


	<!-- Date Picker and input hover -->
	<script type="text/javascript" src="../js/jquery.fancybox.js"></script>
	<script type="text/javascript" src="../js/jquery.fancybox-media.js"></script>


	<!-- Welcome Tabs -->
	<script type="text/javascript" src="../js/tabs.js"></script>


	<!-- All Carousel -->
	<script type="text/javascript" src="../js/owl.carousel.js"></script>

	<!-- Mobile Menu -->
	<script type="text/javascript" src="../js/jquery.mmenu.min.all.js"></script>

	<!-- All Scripts -->
	<script type="text/javascript" src="../js/custom.js"></script>

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