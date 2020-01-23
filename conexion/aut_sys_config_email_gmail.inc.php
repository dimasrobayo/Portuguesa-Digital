<?php
	// Datos conexion para el envio de Email
	require_once('PHPMailer/class.phpmailer.php');
		
	//Create a new PHPMailer instance
	$mail = new PHPMailer;
	//Tell PHPMailer to use SMTP
	$mail->isSMTP();
	//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	//$mail->SMTPDebug = 2;
	$mail->SMTPSecure = 'tls';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;
	//or more succinctly:
	$mail->Host = 'tls://smtp.gmail.com:587';
	//Set the hostname of the mail server
	$mail->Host = 'smtp.gmail.com';
	// use
	// $mail->Host = gethostbyname('smtp.gmail.com');
	// if your network does not support SMTP over IPv6
	//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
	$mail->Port = 587;
	//Whether to use SMTP authentication
	$mail->SMTPAuth = true;
	$mail->SMTPOptions = array(
	    'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	    )
	);
	
	$mail->Username   = "dir.deatencionalportugueseno@gmail.com"; // SMTP account username

	$mail->Password   = "belitzaheredia";        // SMTP account password

	$mail->SetFrom('dir.deatencionalportugueseno@gmail.com', 'PORTUGUESA DIGITAL');
?>