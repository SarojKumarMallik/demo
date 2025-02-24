<?php 
    include("Includes/Header.php");

    if(isset($_GET['Delete'])){
        DeleteComment();
    }
?>

    <!-- ============================================================== -->
    <!-- Page Content -->
    <!-- ============================================================== -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Dashboard</h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="../Admin/">Dashboard</a></li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- ============================================================== -->
            <!-- Different data widgets -->
            <!-- ============================================================== -->
            <!-- .row -->
            <?php echo (isset($CommentMsg)) ? $CommentMsg : ""; ?>
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h3 class="box-title">Total Posts</h3>
                        <ul class="list-inline two-part">
                            <li>
                                <div id="sparklinedash3"></div>
                            </li>
                            <li class="text-right"><i class="ti-arrow-up text-info"></i> <span class="counter text-info"><?php echo TotalPostsCount(); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h3 class="box-title">Total Comments</h3>
                        <ul class="list-inline two-part">
                            <li>
                                <div id="sparklinedash"></div>
                            </li>
                            <li class="text-right"><i class="ti-arrow-up text-success"></i> <span class="counter text-success"><?php TotalVisit(); ?></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <div class="white-box analytics-info">
                        <h3 class="box-title">Total Page Views</h3>
                        <ul class="list-inline two-part">
                            <li>
                                <div id="sparklinedash2"></div>
                            </li>
                            <li class="text-right"><i class="ti-arrow-up text-purple"></i> <span class="counter text-purple"><?php TotalPageViews(); ?></span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/.row -->
            <!--row -->
            <!-- /.row -->
         
            <!-- ============================================================== -->
            <!-- table -->
            <!-- ============================================================== -->
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">Recent Posts</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Post Title</th>
                                        <th>Category</th>
                                        <th>Date</th>
                                        <th>Visits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php DisplayRecentPostsIndex(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- chat-listing & recent comments -->
            <!-- ============================================================== -->
            <div class="row">
                <!-- .col -->
                <div class="col-md-12 col-lg-8 col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">Recent Comments</h3>
                        <div class="comment-center p-t-10">
                            <?php DisplayComments(); ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="panel">
                        <div class="panel panel-default">
                            <div class="panel-heading">To Do List</div>
                            <div class="panel-body">
                                <form class="form-material" name="checkListForm">
                                    <div class="form-group">
                                        <input id="Task" type="text" class="form-control form-control-line" name="Task" placeholder="Add Task...">
                                        <span class="error text-danger"></span>
                                        <br>
                                        <div class="form-group">
                                            <button class="Add btn btn-success waves-effect" type="button"> Add</button>

                                            <button class="Clear btn btn-warning waves-effect" type="button"> Clear</button>
                                        </div>
                                    </div>
                                </form>
                                <ul id="todo"></ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->
            </div>
        </div>
        <!-- /.container-fluid -->
        <footer class="footer text-center">
            <?php echo date('Y'); ?> &copy; Design  And Developed by  <a href="https://www.ikontel.com/"> Ikontel</a> | All Rights Reserved </footer>

    </div>
    <!-- ============================================================== -->
    <!-- End Page Content -->
    <!-- ============================================================== -->

<?php 

    include("Includes/Footer.php");

?>
<script>
//Remove Parameters                                     
$(document).ready(function(){
    var uri = window.location.toString();
	if (uri.indexOf("?") > 0) {
	    var clean_uri = uri.substring(0, uri.indexOf("?"));
	    window.history.replaceState({}, document.title, clean_uri);
	}
});
</script>