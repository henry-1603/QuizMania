<?php
include "connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);
$score = $_GET['score'];
try {
    // Server settings// Enable verbose debugging
    $mail->isSMTP();
    $mail->Host = 'smtp.sendgrid.net';  // Specify your SMTP server
    $mail->SMTPAuth = true;  // Enable SMTP authentication
    $mail->Username = 'apikey';  // SMTP username
    $mail->Password = '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';  // SMTP password
    $mail->SMTPSecure = 'tls';  // Enable TLS encryption, 'ssl' also accepted
    $mail->Port = 587;  // TCP port to connect to

    // Recipients
    $mail->setFrom('henilsuhagiya0@gmail.com', 'Henil');  // Sender's email and name
    $mail->addAddress('henilsuhagiya0@gmail.com');  // Recipient's email and name


    // Content
    $mail->isHTML(true);  // Set email format to HTML
    $mail->Subject = 'YOUR QUIZ RESULT';
    $mail->Body    = 'You Scored '.$score.' Out Of 10';
    $mail->AltBody = 'This is the plain text version for non-HTML mail clients';

    // Send the email
    $mail->send();
    // echo 'Email has been sent successfully!';
} catch (Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}


unset($_SESSION['current_question_index']);
$_SESSION['answersubmit'] = [];
$_SESSION['current_question_index'] = 0;
$_SESSION['current_page'] = 1;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Score-Board</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>

<body>
    <div id="results" class="container py-5 my-5">
        <!-- USER -->
        <p id="quiz_giver" class="d-flex justify-content-center text-success h1 display-1">User: <?php echo $_GET['name']; ?></p>
        <!-- SCORE -->
        <p id="scores_recieved" class="d-flex justify-content-center text-secondary  h3">Scored <?= $_GET['score'] ?> Out Of 10</p>
        <div class="d-flex justify-content-center">
            <!-- HOME PAGE BUTTON -->
            <button onclick="homepage()" type="button" class="btn btn-secondary p-3 m-3 mx-auto "> Return to Home Page</button>
        </div>
        <div id="kbc">
            <div class="tenor-gif-embed d-flex justify-content-center mx-auto" data-postid="25613358" data-share-method="host" data-aspect-ratio="1.49533" data-width="40%">
                <a href="https://tenor.com/view/kbc-memes-7crore-meme-7crores-amitabh-bachchan-kbc-dhanrashi-gif-25613358"></a><a href="https://tenor.com/search/kbc+memes-gifs"></a>
            </div>
            <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function homepage() {
                $.ajax({
                    url:'functions.php',
                    type:'post',
                    data:{
                        action:'homeRedirect',
                    },
                    success:function(data,status) {
                        location.href = data;
                    },
                    error:function() {
                        console.log("Error");
                    }
                })
            }

    </script>


</body>

</html>