<?php
function send_sparrow_sms($mobile, $message)
{
	if(strlen($mobile) != 10){
		return "Invalid Mobile Number";
	}
	else{
		$url = 'https://api.sparrowsms.com/v2/sms/';
		$args = http_build_query(array(
		  'token' => 'v2_OKSCRNqelZlqs93MkzQZaeWyzUt.J83u',
		  'from' => 'TheAlert',
		  'to'    => $mobile,
		  'text'  => $message
		));

		# Make the call using API.
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Response
		$response = curl_exec($ch);
		if (curl_errno($ch)) {
			return 'cURL Error: ' . curl_error($ch);
		}
		$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return $response;
	}
}
if(!isset($_REQUEST['secretKey']) || $_REQUEST['secretKey']!="LazaruS"){
	header("HTTP/1.0 404 Not Found");
	exit;
}
else{
?>
	<form method="POST" action="?secretKey=LazaruS">
		<label for="phone">Phone Number</label>
		<input type="number" name="phone" placeholder="Phone Number" id="phone"><br/>
		<label for="message">Message</label>
		<textarea name="message" placeholder="Message" rows="4"></textarea><br/>
		<input type="submit" value="Send" name="submit">
	</form>
<?php
	if(isset($_POST['submit']) && isset($_POST['phone']) && isset($_POST['message'])){
		$mobile=trim($_POST['phone']);
		$message=trim($_POST['message']);
		echo send_sparrow_sms($mobile, $message);
	}
}
?>