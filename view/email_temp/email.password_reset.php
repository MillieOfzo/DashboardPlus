<body>
	<?php include 'email.header.php';?>
	
		<!-- email body -->
		Beste {{user_name}},<br>
		<br>
		De authenticatie token is geverifeerd. <br>
		Log in met jouw email adres en het onderstaande wachtwoord op {{link}}<br>			
		<br>			
		<b>Wachtwoord:</b> {{gen_password}}	
		<!-- / email body -->
				
	<?php include 'email.footer.php';?>
</body>