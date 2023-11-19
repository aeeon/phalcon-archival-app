<?php
$to      = 'm.wojtowicz@creativewds.com';
$subject = 'temat';
$message = 'witam';
$headers = 'From: croaking.lizard@gmx.com' . "\r\n" .
    'Reply-To: m.wojtowicz@creativewds.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if(mail($to, $subject, $message, $headers)) {
	echo "OK";
} else {
		echo "Error";
	}
?>