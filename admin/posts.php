<?php include "includes/admin_header.php" ?>
<?php ob_start(); ?>
<div id="wrapper">

    <!-- Navigation -->
    <?php include "includes/admin_nav.php" ?>
    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        Welcome to Admin
                        <small>Author</small>
                    </h1>
                    <?php
                    if(isset($_GET['source'])){
                        $source=escape($_GET['source']);
                    }
                    else{
                        $source='';
                    }
                    switch ($source){
                        case 'add_posts': include "includes/add_posts.php"; break;
                        case 'edit_posts': include "includes/edit_posts.php"; break;
                        case 50:  echo "Nice 50"; break;
                        default: include "includes/view_all_posts.php";
                    }
                    ?>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>
