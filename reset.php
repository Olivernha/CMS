
<?php  include "includes/header.php"; ?>


<?php include "includes/nav.php"?>

<?php

    if(!isset($_GET['email']) && !isset($_GET['token'])){
            redirect('index');
    }

//    $email='nayhtetaung201733@gmail.com';
//    $token='c8a1446d881635033b0859d34310a183326b4f584da3ad547cbf0b45b9301845afdbe57e571a67941d42e9739a25c926bfbf';
        if($stmt=mysqli_prepare($connection,'Select username,user_email,token From users WHERE token=?')){
            mysqli_stmt_bind_param($stmt,'s',$_GET['token']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt,$username,$user_email,$token);
            mysqli_stmt_fetch($stmt);
            mysqli_stmt_close($stmt);


//            if($_GET['token'] !== $token || $_GET['email'] !==$user_email){
//                redirect('index');
//            }

            if(isset($_POST['password']) && isset($_POST['confirmPassword'])){
                if($_POST['password'] == $_POST['confirmPassword']){
                    $password=$_POST['password'];
                    $hashedPassword=password_hash($password,PASSWORD_BCRYPT,array('cost'=>12));
                    if($stmt=mysqli_prepare($connection,"Update users Set token='',user_password='{$hashedPassword}'Where user_email=?"));
                    mysqli_stmt_bind_param($stmt,"s",$_GET['email']);
                    mysqli_stmt_execute($stmt);
                    if(mysqli_stmt_affected_rows($stmt) >= 1){
                       redirect('/cms/login.php');
                    }
                    mysqli_stmt_close($stmt);

                }
            }
        }
?>
<!-- Page Content -->
<div class="container">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                                <input id="password" name="password" placeholder="Enter Password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                                <input id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

<!--                            <h2>Please check your email</h2>-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

