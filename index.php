<?php
            require_once "vendor/autoload.php";

            use PHPMailer\PHPMailer\PHPMailer;
            use PHPMailer\PHPMailer\Exception;

            // Message
            $msg = '';
            $msgClass = '';

            // Check for submit
            if (filter_has_var(INPUT_POST, 'submit')) {
                // Passed
                // Get variables
                $smtp_host = htmlspecialchars($_POST['smtp_host']);
                $smtp_port = htmlspecialchars($_POST['smtp_port']);
                $smtp_user = htmlspecialchars($_POST['smtp_user']);
                $smtp_pwd = htmlspecialchars($_POST['smtp_pwd']);
                $mail_from = htmlspecialchars($_POST['mail_from']);
                $mail_to = htmlspecialchars($_POST['mail_to']);
                $mail_subject = htmlspecialchars($_POST['mail_subject']);
                $mail_body = htmlspecialchars($_POST['mail_body']);

                // Check for fields
                if (!empty($smtp_host) && !empty($smtp_port) && !empty($smtp_user) && !empty($smtp_pwd) && !empty($mail_from) && !empty($mail_to) && !empty($mail_subject) && !empty($mail_body)) {
            //PHPMailer Object
                    $mail = new PHPMailer(true); //Argument true in constructor enables exceptions
                    $mail-> isSMTP();
                    $mail->SMTPDebug   = 0;
                    $mail->Host = $smtp_host;
                    //Set the SMTP port number - likely to be 25, 465 or 587
                    $mail->Port = $smtp_port;
                    //Whether to use SMTP authentication
                    $mail->SMTPAuth = true;
                    //Username to use for SMTP authentication
                    $mail->Username = $smtp_user;
                    //Password to use for SMTP authentication
                    $mail->Password = $smtp_pwd;
                    //Set who the message is to be sent from
                    $mail->setFrom($mail_from);
                    //Set who the message is to be sent to
                    $mail->addAddress($mail_to);
                    //Set the subject line
                    $mail->Subject = $mail_subject;
                    // Set the message line
                    $mail->Body = $mail_body;
                    $mail->isHTML(true);

                    if ($mail->send()) {
                        $msg = 'Successfully send email';
                        $msgClass = 'alert-success';
                    } else {
                        $msg = 'Failed to send. Reason: '. $mail->ErrorInfo;
                        $msgClass = 'alert-danger';
                    }
                } else {
                    // Failed
                    $msg = 'Fill out all forms';
                    $msgClass = 'alert-warning';
                }
            }

            ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Raiyan Sarker">
    <meta name="description"
        content="This page is built with php. It is made just to test out smtp. Check yours today!">
    <meta name="keyword" content="Raiyan Sarker, php Mailer, smtp tester, raiyan media co ltd">
    <title> Mailer | Test Your Smtp Server</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/e1d59b268c.js" crossorigin="anonymous"></script>
    <link href='https://fonts.googleapis.com/css?family=Lato:400,100,300' rel='stylesheet' type='text/css'>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Container -->
    <div class="container">
        <h1 id="logo" class="text-center">SMTP Checker</h1>
        <!-- Message -->
        <?php if ($msg != ""): ?>
        <div class="alert <?php echo $msgClass; ?>"><?php echo $msg; ?></div>
        <?php endif; ?>
        <!-- Form -->
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <p class="menu">SMTP Credentials</p>
            <!-- Grid -->
            <div class="row form-group">
                <div class="col-md-9">
                    <label for="smtp-host">Host:</label>
                    <input name="smtp_host" value="<?php echo isset($_POST['smtp_host']) ? $smtp_host : ''; ?>" required
                        class="form-control" type="text" placeholder="Enter your smtp hostname" id="smtp-host">
                </div>
                <div class="col-md-3">
                    <label for="smtp-port">Port:</label>
                    <input name="smtp_port" value="<?php echo isset($_POST['smtp_port']) ? $smtp_port : ''; ?>" required
                        class="form-control" type="number" placeholder="Enter your smtp port" id="smtp-port">
                </div>
                <div class="col-md-6">
                    <label class="padding-top" for="smtp-user">Username:</label>
                    <input name="smtp_user" value="<?php echo isset($_POST['smtp_user']) ? $smtp_user : ''; ?>" required
                        class="form-control" type="text" placeholder="Enter your smtp username" id="smtp-user">
                </div>
                <div class="col-md-6">
                    <label class="padding-top" for="smtp-password">Password:</label>
                    <input name="smtp_pwd" value="<?php echo isset($_POST['smtp_pwd']) ? $smtp_pwd : ''; ?>" required
                        class="form-control" type="password" placeholder="Enter your smtp password" id="smtp-password">
                </div>
            </div>
            <p class="menu">Mail</p>
            <div class="row form-group">
                <div class="col-md-6">
                    <label for="mail-from">From:</label>
                    <input name="mail_from" value="<?php echo isset($_POST['mail_from']) ? $mail_from : ''; ?>" required
                        class="form-control" type="email" placeholder="Enter from email address" id="mail-from">
                </div>
                <div class="col-md-6">
                    <label for="mail-to">To:</label>
                    <input name="mail_to" value="<?php echo isset($_POST['mail_to']) ? $mail_to : ''; ?>" required
                        class="form-control" type="email" placeholder="Enter to email address" id="mail-to">
                </div>
            </div>
            <label for="mail-subject">Subject:</label>
            <input name="mail_subject" value="<?php echo isset($_POST['mail_subject']) ? $mail_subject : ''; ?>"
                required class="form-control" type="text" placeholder="Enter your subject" id="mail-subject">
            <label class="padding-top" for="mail-body">Message:</label>
            <textarea name="mail_body" value="<?php echo isset($_POST['mail_body']) ? $mail_body : ''; ?>" required
                class="form-control" placeholder="Message" id="mail-body" cols="30" rows="5"></textarea>
            <input name="submit" type="submit" class="btn btn-outline-dark" value="Send Email">
        </form>
        <div style="height:50px;"></div>
    </div>
    <!-- Footer -->
    <div class="footer">
        <!-- Container -->
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <p class="text-uppercase" style="font-size:16px;">&copy;<?php echo date('Y'); ?>, Deepak Kewalramani, All Rights Reserved</p>
                </div>
                 <div class="col-md-5 d-flex justify-content-md-end">
                    <script type="text/javascript" src="https://cdnjs.buymeacoffee.com/1.0.0/button.prod.min.js" data-name="bmc-button" data-slug="Dkewalramani" data-color="#FFDD00" data-emoji=""  data-font="Cookie" data-text="Buy me a coffee" data-outline-color="#000000" data-font-color="#000000" data-coffee-color="#ffffff" ></script>
                </div>
            </div>
        </div>
    </div>

</body>

</html>