<?php 
    define("TITLE", "Profile");
    include("Includes/Header.php");
    DisplayAccountDetails();
?>

    <link href="plugins/bower_components/bootstrap-form-helper/dist/css/bootstrap-formhelpers.min.css">
    <script src="plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="plugins/bower_components/bootstrap-form-helper/dist/js/bootstrap-formhelpers.min.js"></script>

    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Profile page</h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="../Admin/">Dashboard</a></li>
                        <li class="active">Profile Page</li>
                    </ol>
                </div>
            </div>
            <!-- /.row -->
            <!-- .row -->
            <?php echo (isset($ProfileMsg)) ? $ProfileMsg : ""; ?>
            <div class="row">
                <div class="col-md-4 col-xs-12">
                    <div class="white-box">
                        <div class="user-bg"> <img width="100%" height="100%" alt="user" src="https://cdn.allwallpaper.in/wallpapers/900x600/1637/cityscapes-night-dubai-900x600-wallpaper.jpg">
                            <div class="overlay-box">
                                <div class="user-content">
                                    <a href=""><img src="<?php echo GravatarImage($Email); ?>" class="thumb-lg img-circle" alt="Username"></a>
                                    <h4 class="text-white"><?php echo (isset($Phone)) ? $Phone : ""; ?></h4>
                                    <h5 class="text-white"><?php echo (isset($Email)) ? $Email : ""; ?></h5> </div>
                            </div>
                        </div>
                        <div class="user-btm-box">
                            <div class="col-md-4 col-sm-4 text-center">
                                <h1 style="white-space: nowrap;"><?php echo  (isset($Username)) ? "User " .  $Username : ""; ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <div class="white-box">
                        <h3 class="box-title">Profile</h3>
                        <form method="post" action="" class="form-horizontal form-material">
                            <div class="form-group">
                                <?php echo (isset($NameError)) ? $NameError : ""; ?>
                                <label class="col-md-12">Full Name</label>
                                <div class="col-md-12">
                                    <input disabled name="Fullname" type="text" placeholder="Johnathan Doe" class="form-control form-control-line" value="<?php echo (isset($Name)) ? $Name : ""; ?>"> 
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo (isset($EmailError)) ? $EmailError : ""; ?>
                                <label class="col-md-12">Email</label>
                                <div class="col-md-12">
                                    <input disable name="Email" type="email" placeholder="johnathan@admin.com" class="form-control form-control-line" value="<?php echo (isset($Email)) ? $Email : ""; ?>" disabled>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo (isset($UsernameError)) ? $UsernameError : ""; ?>
                                <label for="" class="col-md-12">Username</label>
                                <div class="col-md-12">
                                    <input disabled name="Username" type="text" class="form-control form-control-line" placeholder="<?php echo (isset($Username)) ? $Username : "Drakemesk"; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo (isset($PhoneError)) ? $PhoneError : ""; ?>
                                <label class="col-md-12">Phone No</label>
                                <div class="col-md-12">
                                    <input disabled name="Phone" type="text" placeholder="123 456 7890" class="form-control form-control-line" value="<?php echo (isset($Phone)) ? $Phone : ""; ?>">
                                </div>
                            </div>
                           
                            
                        </form>
                    </div>
                </div>
                
            </div>

            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center">
            <?php echo date('Y'); ?> &copy; Design  And Developed by  <a href="https://www.ikontel.com/"> Ikontel</a> | All Rights Reserved </footer>
    </div>
    <!-- /#page-wrapper -->

<?php 

    include("Includes/Footer.php");

?>
<script>
//Match New Password and Confirm New Password
var NPass = document.getElementById("NPass")
  , CNPass = document.getElementById("CNPass");

function validatePassword(){
  if(NPass.value != CNPass.value) {
    CNPass.setCustomValidity("Passwords Don't Match");
  } else {
    CNPass.setCustomValidity('');
  }
}

NPass.onchange = validatePassword;
CNPass.onkeyup = validatePassword;
    
</script>