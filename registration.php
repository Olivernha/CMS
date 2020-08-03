
<?php  include "includes/header.php"; ?>

<!-- Navigation -->

<?php  include "includes/nav.php"; ?>

<?php require 'vendor/autoload.php' ?>
<?php
//Setting Languages Variable
if(isset($_GET['lang']) && !empty($_GET['lang'])){
    $_SESSION['lang']=$_GET['lang'];
    if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
            echo "<script type='text/javascipt'>location.reload();</script>";
    }
    if(isset($_SESSION['lang'])){
        include "includes/languages/".$_SESSION['lang'].".php";

    }else{
        include "includes/languages/en.php";
    }
}


////Pusher
//$dotenv = new \Dotenv\Dotenv(__DIR__);
//$dotenv->load();
//$options=array(
//        'cluster'=>'us2',
//         'encrypted'=>true
//);
//$pusher=new \Pusher\Pusher(getenv('APP_KEY'),getenv('APP_SECRET'),getenv('APP_ID'),$options);

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $username=trim($_POST['username']);
    $email=trim($_POST['email']);
    $password=trim($_POST['password']);

    $error=[
            'username'=>'',
            'email'=>'',
            'password'=>''
    ];

    if(strlen($username) < 4){
        $error['username']='Username needs to be longer';
    }
    if($username ==''){
        $error['username']='Username cannot be empty';
    }
    if(username_exists($username)){
        $error['username']='Username already existed';
    }
    if(email_exists($email)){
        $error['email']="Email already existed,<a href='index.php'>Please Login</a>";
    }
    if($email == ''){
        $error['email']='Email cannot be empty';
    }

    if($password==''){
        $error['password']='Password cannot be empty';
    }

    foreach ($error as $key=>$value) {
        if(empty($value)){
//            register_user($username,$email,$password);
//            login_user($username,$password);
            unset($error[$key]);
        }
    }

        if(empty($error)){
            register_user($username,$email,$password);
            login_user($username,$password);
        }





}

?>



<!-- Page Content -->
<div class="container">
    <form method="get" class="navbar-form navbar-right" action=""  id="language_form">
        <div class="form-group">
            <select name="lang" class="form-control" onchange="changeLanguage()" >
                <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en') {echo "selected";}?>>English</option>
                <option value="mm" <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'mm') {echo "selected";}?>>Myanmar</option>
            </select>
        </div>
    </form>
    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1><?php echo !isset($_POST['lang']) ?  'Register ':_REGISTER ?></h1>
                        <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

                            <div class="form-group">
                                <label for="username" class="sr-only">username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo !isset($_POST['lang']) ?  'Enter your username': _USERNAME ?>" autocomplete="on"
                                       value="<?php echo !isset($_POST['lang']) && isset($username) ? $username : ''?>">
                                <p><?php echo isset( $error['username']) ? $error['username'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo !isset($_POST['lang']) ?  'Enter your email':  _EMAIL; ?>"  value="<?php echo  isset($_POST['lang']) && isset($email) ? $email : ''?>">
                                <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="password" class="sr-only">Password</label>
                                <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo !isset($_POST['lang']) ?  'Enter your password':  _PASSWORD;?>">
                                <p><?php echo isset($error['password']) ? $error['password'] : ''?></p>
                            </div>

                            <input type="submit" name="register" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>
    <script>
            function changeLanguage() {
                document.getElementById('language_form').submit();

            }
    </script>



    <?php include "includes/footer.php";?>
