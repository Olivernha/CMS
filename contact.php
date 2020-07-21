
<?php  include "includes/header.php"; ?>

<!-- Navigation -->

<?php  include "includes/nav.php";

?>








<?php

//  $msg = "First line of text\nSecond line of text";

//  // use wordwrap() if lines are longer than 70 characters
//  $msg = wordwrap($msg, 70);

//  // send email
//  mail("oliver201733@gmail.com", "My subject", $msg);




if(isset($_POST['submit'])){
    $to="oliver201733@gmail.com";
    $subject= wordwrap($_POST['subject'],70);
    $body=$_POST['body'];
    $header="From: ".$_POST['email'];
    mail($to,$subject,$body,$header);
}
?>


<!-- Page Content -->
<div class="container">

    <section id="login">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="form-wrap">
                        <h1>Contact</h1>
                        <form role="form" action="" method="post" id="login-form" autocomplete="off">

                            <div class="form-group">
                                <label for="email" class="sr-only">Email</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Enter your Subject">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="body" id="" cols="50" rows="10"></textarea>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php";?>
