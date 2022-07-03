<?php
require_once __DIR__ . "/PHPMailer/src/Exception.php";
require_once __DIR__ . "/PHPMailer/src/OAuthTokenProvider.php";
require_once __DIR__ . "/PHPMailer/src/OAuth.php";
require_once __DIR__ . "/PHPMailer/src/PHPMailer.php";
require_once __DIR__ . "/PHPMailer/src/POP3.php";
require_once __DIR__ . "/PHPMailer/src/SMTP.php";

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$adSoyad = $_POST["ad"] ?? '-';
$targetEmail = $_POST["email"] ?? '-';
$phoneNumber = $_POST["telefon_numarasi"] ?? '-';
$subject = $_POST["konu"] ?? '-';
$message = $_POST["mesaj"] ?? '-';

if (empty($targetEmail) && empty($phoneNumber)) {
    echo "<script type='text/javascript'>
        alert('Telefon numarası veya Email adresi girmediniz!');
        window.location.href = window.location.origin;
    </script>";
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$result = [
    "success" => false
];

try {
    //Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mail.virgomimarlik.com.tr';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'info@virgomimarlik.com.tr';                     //SMTP username
    $mail->Password   = 'Klznmdjxy12!';                               //SMTP password
    $mail->SMTPAutoTLS = false;
    $mail->SMTPSecure = false;
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    $mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom('info@virgomimarlik.com.tr', 'İletişim Formu');
    $mail->addAddress('info@virgomimarlik.com.tr');
    $mail->addAddress('onur@virgomimarlik.com.tr');

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'İletişim Formu Dolduruldu!';
    $mail->Body    = "<div>
            <h2>Ad Soyad:</h2>
            <p>$adSoyad</p>
        </div>
        <div>
            <h2>Email:</h2>
            <p>$targetEmail</p>
        </div>
        <div>
            <h2>Telefon Numarası:</h2>
            <p>$phoneNumber</p>
        </div>
        <div>
            <h2>Konu:</h2>
            <p>$subject</p>
        </div>
        <div>
            <h2>Mesaj:</h2>
            <p>$message</p>
        </div>";
    $mail->AltBody = strip_tags($mail->Body);

    $mail->send();
    echo "<script type='text/javascript'>
        alert('Destek talebi iletildi!');
        window.location.href = window.location.origin;
    </script>";
    //header("Location: /?success=1");
} catch (Exception $e) {
    echo "<script type='text/javascript'>
        alert('Destek talebi iletilemedi!');
        window.location.href = window.location.origin;
    </script>";
    //header("Location: /?success=0");
}