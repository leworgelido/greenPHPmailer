<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';
require_once './includes/connect.php';




function ranNum(){
  $random_number = random_int(100000,999999);
  return $random_number;
}



function sendMail($email, $username) {
  try {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'greenyauction@gmail.com';                     //SMTP username
    $mail->Password   = 'drqn coud gnbd ksfg';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('greenyauction@gmail.com', 'GreenAuction');
    $mail->addAddress( $email, $username);     //Add a recipient
    $mail->addReplyTo('greenyauction@gmail.com', 'GreenAuction');

    // GENERATING RANDOM NUMBER
    $random_number = ranNum();

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'OTP Verification';
    $mail->Body    = "<h2>OTP Verification</h2><br>
                      What's up, sir/madam " . $email . '<br>
                      your OTP is : <h2>' . $random_number . '</h2>'; 
    $mail->AltBody = 'your OTP is : ' . $random_number;

    // SESSION THE OTP
    $_SESSION["OTP"] = $random_number;

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}



function ranPWD(){
  $random_pwd = bin2hex(random_bytes(5));
  return $random_pwd;
}

function sendVerificationEmail($email, $username) {
  try {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'greenyauction@gmail.com';                     //SMTP username
    $mail->Password   = 'drqn coud gnbd ksfg';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('greenyauction@gmail.com', 'GreenAuction');
    $mail->addAddress( $email, $username);     //Add a recipient
    $mail->addReplyTo('greenyauction@gmail.com', 'GreenAuction');

    // GENERATING RANDOM NUMBER
    $random_pwd = ranPWD();

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email Verification';
    $mail->Body    = "Your Email : " . $email . "<br>
                      Your password : <h2>" . $random_pwd . "</h2>";
    $mail->AltBody = "Your Email : " . $email . "<br>
                      Your password : " . $random_pwd;

    // SESSION THE OTP
    $_SESSION["pass"] = $random_pwd;
    $_SESSION["email-verify"] = $email;

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}

function insertUser($pdo, $email, $username, $Generated_pass) {

  require_once './includes/connect.php';

  $hash_pass = password_hash($Generated_pass, PASSWORD_DEFAULT);
  

  $qry = "INSERT INTO users (username, email, pwd) VALUES (:username, :email, :pwd)";
  $stmt = $pdo->prepare($qry);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":username", $username);
  $stmt->bindParam(":pwd",$hash_pass);
  $stmt->execute();  
}

function sendResetPassword($email, $hex_token) {
  try {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'greenyauction@gmail.com';                     //SMTP username
    $mail->Password   = 'drqn coud gnbd ksfg';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('greenyauction@gmail.com', 'GreenAuction');
    $mail->addAddress( $email, "User");     //Add a recipient
    $mail->addReplyTo('greenyauction@gmail.com', 'GreenAuction');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Password Reset';
    $mail->Body    = '<h1>Password Reset</h1>';
    $mail->Body    .= 'Hello, ' . $email;
    $mail->Body    .= '<br>We have received a request to reset your password.<br><br><br>';
    $mail->Body    .= '<a style="padding:14px; background-color: #7630ff; color: white; text-decoration: none; border-radius: 4px; font-size: 16px;"href="localhost/PHPMAILER/reset-pass.php?code=' . $hex_token . '">Reset Password</a><br>';
    $mail->Body    .= '<br><br>Thank you!<br>';

    $mail->AltBody = 'Password Reset<br>';
    $mail->AltBody .= 'We have received a request to reset your password.<br>';
    $mail->AltBody .= '<a href="http://localhost/PHPMAILER/reset-pass.php?code="' . $hex_token . '">Reset Password</a><br>';

    $_SESSION["token"] = $hex_token;
    $_SESSION["email-verify"] = $email;

    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}

function updateToken($pdo, $email, $hash_token, $exp_resetpass) {

  require_once './includes/connect.php';

  $qry = "UPDATE users SET hash_token = :hash_token, exp_resetpass = :exp_resetpass WHERE email = :email";
  $stmt = $pdo->prepare($qry);
  $stmt->bindParam(":email", $email);
  $stmt->bindParam(":hash_token", $hash_token);
  $stmt->bindParam(":exp_resetpass",$exp_resetpass);
  $stmt->execute();  
}

