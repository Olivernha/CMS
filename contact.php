
<?php use PHPMailer\PHPMailer\PHPMailer;

include "includes/header.php"; ?>

<!-- Navigation -->

<?php  include "includes/nav.php";

?>








<?php
//
////  $msg = "First line of text\nSecond line of text";
//
////  // use wordwrap() if lines are longer than 70 characters
////  $msg = wordwrap($msg, 70);
//
////  // send email
////  mail("oliver201733@gmail.com", "My subject", $msg);
//
//
//
//
////if(isset($_POST['submit'])){
////    $to="oliver201733@gmail.com";
////    $subject= wordwrap($_POST['subject'],70);
////    $body=$_POST['body'];
////    $header="From: ".$_POST['email'];
////    mail($to,$subject,$body,$header);
////}
//?>

<?php
        require './vendor/autoload.php';

if(ifItIsMethod('post')){
    if(isset($_POST['submit'])) {
        $email = trim($_POST['email']);
        $body = trim($_POST['body']);
        $subject = trim($_POST['subject']);

        $error = [
            'email' => '',
            'body' => '',
            'subject' => ''
        ];


        if ($body == '') {
            $error['body'] = 'Body cannot be empty';
        }

        if ($email == '') {
            $error['email'] = 'Email cannot be empty';
        }

        if ($subject == '') {
            $error['subject'] = 'Subject cannot be empty';
        }

        foreach ($error as $key => $value) {
            if (empty($value)) {
                unset($error[$key]);
            }
        }
        if (empty($error)) {

            $email = $_POST['email'];
            /***
             * configure PHPMailer
             */
            $mail = new PHPMailer();

            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
            $mail->isSMTP();                                            // Send using SMTP
            $mail->Host = config::SMTP_HOST;                    // Set the SMTP server to send through
            $mail->SMTPAuth = true;                                   // Enable SMTP authentication
            $mail->Username = config::SMTP_USER;                     // SMTP username
            $mail->Password = config::SMTP_PASSWORD;                               // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port = config::SMTP_PORT;
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            $mail->setFrom('nayhtetaung201733@gmail.com', 'oliver');
            $mail->addAddress($email);     // Add a recipient

            $mail->Subject = $_POST['subject'];
            $mail->Body = $_POST['body'];

            if ($mail->send()) {
                $emailSent = true;
            } else {
                echo "Not Sent";
            }
        }
    }

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
                                <p><?php echo isset($error['email']) ? $error['email'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <label for="subject" class="sr-only">Subject</label>
                                <input type="text" name="subject" id="email" class="form-control" placeholder="Enter your Subject">
                                <p><?php echo isset($error['subject']) ? $error['subject'] : '' ?></p>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="body" id="" cols="50" rows="10"></textarea>
                                <p><?php echo isset($error['body']) ? $error['body'] : '' ?></p>
                            </div>

                            <input type="submit" name="submit" id="btn-login" class="btn btn-danger btn-lg btn-block" value="Submit">
                        </form>

                    </div>
                </div> <!-- /.col-xs-12 -->
            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </section>


    <hr>



    <?php include "includes/footer.php";?>
