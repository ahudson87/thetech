<?php

	function sanitize($data){

		// remove spaces from the input
		$data = trim($data);

		// convert special characters to html entities
		// most hacking inputs in XSS are HTML in nature, so converting them to special characters so that they are not harmful
		$data = htmlspecialchars($data);

		// sanitize before using any MySQL database queries
		// this will escape quotes in the input.
		//$data = mysql_real_escape_string($data);
		return $data;
	}

	if(isset($_POST['email'])){

		$name 			= sanitize($_POST['name']);
		$email 			= sanitize($_POST['email']);
		$phone 			= sanitize($_POST['phone']);
		$message 		= $_POST['message'];

		// rudimentary validation ... need to identify fixed string from form to test against
		// if (strpos($message, 'rock star') === false) {
		// 	echo 'error';
		// 	error_log("Doesn't match. Is this from the HRI server?" . $message);
		// 	return false;
		// }

		$to = 'mpappas@thetech.org'; // should be email address, ex: contact@hyperrelevance.com 
		$subject = "I'd like to know more about The Tech Reinvented Campaign"; // should be subject line address, ex: Web Contact Form

		$headers = "From: " . strip_tags( $email ) . PHP_EOL;
		$headers .= "Reply-To: ". strip_tags( $email ) . PHP_EOL;
		$headers .= "MIME-Version: 1.0" . PHP_EOL;
		$headers .= "Content-Type: text/html; charset=ISO-8859-1" . PHP_EOL;


		$htmlmessage = '<html><body style="color:#000; font-family: Helvetica, Arial, sans-serif;">';
		$htmlmessage .= '<table border="0" cellpadding="0" width="600" style="margin:0 auto; background-color: whitesmoke; border-color: #55a4df;">';
		$htmlmessage .= '<tr><td colspan="2" cellpadding="0" cellspacing="0"><img src="http://thetech.org/joinus/images/auto-email-header.jpg" alt="The Tech Museum of Innovation" title="The Tech Museum of Innovation" width="600" height="243"></td></tr>';
		$htmlmessage .= '<tr><td colspan="2" style="padding: 20px;">Incoming message from:</td></tr>';

		$htmlmessage .= '<tr><td style="padding: 10px 40px;"><strong>Name:</strong> </td><td>' . strip_tags( $name ) . '</td></tr>';
		$htmlmessage .= '<tr><td style="padding: 10px 40px;"><strong>Email:</strong> </td><td>' . strip_tags( $email ) . '</td></tr>';
		$htmlmessage .= '<tr><td style="padding: 10px 40px;"><strong>Phone:</strong> </td><td>' . strip_tags( $phone ) . '</td></tr>';
		
		$htmlmessage .= '<tr><td colspan="2" style="padding: 10px;"><tr><td colspan="2" style="background-color: whitesmoke; color: black; padding: 30px;">' . $message . '</td></tr></td></tr>';
		
		$htmlmessage .= '<tr><td colspan="2" style="padding: 20px 40px; font-size: 12px; color: white; background-color: #18478f;"><p style="line-height: 17px;">The Tech Museum of Innovation<br>201 South Market Street<br>San Jose, CA 95113</p></td></tr>';
		$htmlmessage .= '</table>';
		$htmlmessage .= '</body></html>';

		/*
		echo $to;
		echo '\r\n';
		echo $subject;
		echo '\r\n';
		echo $htmlmessage;
		echo '\r\n';
		echo $headers;
		*/

		if (mail ($to, $subject, $htmlmessage, $headers)) {
			echo 'success';
		} else {
			echo 'error';
		}
	}
?>
