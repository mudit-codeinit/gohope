<?php
echo  require_once("/var/www/html/gohope/vendor/autoload.php");
exit;
$mail = new PHPMailer();
pr($mail);exit;
$mail->IsSMTP();
$mail->Mailer = "smtp";
$mail->SMTPDebug  = 1;  
$mail->SMTPAuth   = TRUE;
$mail->SMTPSecure = "tls";
$mail->Port       = 587;
$mail->Host       = "smtp.gmail.com";
$mail->Username   = "gohopeforapp@gmail.com";
$mail->Password   = "admin#240";
$mail->IsHTML(true);
$mail->AddAddress($email, "Nisha");
$mail->SetFrom("gohopeforapp@gmail.com", "Gohope");
//$mail->AddReplyTo("reply-to-email@domain", "reply-to-name");
//$mail->AddCC("cc-recipient-email@domain", "cc-recipient-name");
$mail->Subject = "Test is Test Email sent via Gmail SMTP Server using PHP Mailer";
$content = "<b>This is a Test Email sent via Gmail SMTP Server using PHP mailer class.</b>";
$mail->MsgHTML($content); 

if(!$mail->send()) 
{
    echo "Mailer Error: " . $mail->ErrorInfo;
} 
else 
{
    echo "Message has been sent successfully";
}