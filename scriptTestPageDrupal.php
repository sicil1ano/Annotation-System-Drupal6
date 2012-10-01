<script>
function PopupCenter(pageURL, title,w,h) {
 var left = (screen.width/2)-(w/2);
 var top = (screen.height/2)-(h/2);
 var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
} 
</script>

<a href="javascript:void(0);" onclick="PopupCenter('http://www.nigraphic.com', 'Test Popup',500,500);">CLICK TO OPEN POPUP</a>

<?php 
    	//include 'crocodoc.php';
class Crocodoc {
		public $api_key = 'JhOYEo9yT5v2RcfbzAwHQFr4';
		public $api_url = 'https://crocodoc.com/api/v2/';

		private function doCurlPost($url, $data){
			$ch = curl_init();
		
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			$output = curl_exec($ch);
			//echo curl_error($ch);
			curl_close($ch);
			return $output;
		}


		private function doCurlPostS($url, $data){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
		}


private function doCurlGet($url, $dataStr) {
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url.$dataStr);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$output = curl_exec($ch);
echo curl_error($ch);
curl_close($ch);
return $output;
}

public function sayHello(){
	echo "Hello from crocodoc!";
}

public function upload($file, $upload_from_url = true) {
$url = $this->api_url.'document/upload';
$data['token'] = $this->api_key;
if ($upload_from_url)
	$data['url'] = $file;
else
	$data['file'] = "@".$file;
//this is a POST request
$output = $this->doCurlPost($url, $data);
//echo var_dump($output);
return $output;
}


public function getStatus($uuids){
$url = $this->api_url.'document/status';
$token = $this->api_key;
$dataStr = '?token='.$token.'&uuids='.$uuids;
// this is a GET request
$output = $this->doCurlGet($url, $dataStr);
return $output;
}

public function delete($uuid) {
$url = $this->api_url.'document/delete';
$data = array(
'token' => $this->api_key,
'uuid' => $uuid
);
//this is a POST request
$output = $this->doCurlPost($url, $data);
return $output;
}

public function createSession($uuid,$userID,$userName) {
$url = $this->api_url.'session/create';
if($userID > 1){
$data = array(
'token' => $this->api_key,
'uuid' => $uuid,
'editable' => "true",
'user' => $userID.",".$userName,
'downloadable' => "false");
//this is a POST request
$output = $this->doCurlPost($url, $data);
echo "outputsession: $output";
return $output;
}
else {
$data = array(
'token' => $this->api_key,
'uuid' => $uuid,
'editable' => "false",
'admin' => "true",
'downloadable' => "false");
//this is a POST request
$output = $this->doCurlPost($url, $data);
echo "outputsession: $output";
return $output;
}
  }

  public function download($uuid) {
  	$url = $this->api_url.'download/document';
	$token = $this->api_key;
	$filename = 'iaffio.pdf';
	$dataStr = '?token='.$token.'&uuid='.$uuid.'&filename='.$filename;
  	$output = $url.$dataStr;
  	//$output = $this->doCurlGet($url,$dataStr);
  	return $output;
  }


	public function downloadAnnotated($uuid)
	{
		$url = $this->api_url.'download/document';
  		$token = $this->api_key;
		$filename = 'iaffio.pdf';
		$dataStr = '?token='.$token.'&annotated=true'.'&uuid='.$uuid.'&filename='.$filename;
		$output = $url.$dataStr;
		return $output;

	}

}

?>  	    

<br><?php
$croco = new Crocodoc();
		
		
		$file = 'C://xampp//htdocs//mydomain.drupal//sites//default//files//private//retiMobili.pdf';
		
	    $uuid = $croco->upload('C://xampp//htdocs//mydomain.drupal//sites//default//files//private//retiMobili.pdf', false);
	 	
	    $resultUuid = json_decode($uuid);
		//echo $resultUuid;
		$uuid = $resultUuid->{"uuid"};
                echo $uuid;
                $userID;
                $userName;
                 sleep(7);
                  if (user_is_logged_in() == TRUE) {
                    global $user;

                   //print "Welcome " . $user->name;
                   //print "uid: " . $user->uid;
                   $userID = $user->uid;
                   $userName = $user->name;
                    }
                

                  $session = $croco->createSession($uuid,$userID,$userName);
		
		  $resultSession = json_decode($session);
		  $session = $resultSession->{"session"};
                  echo "<p> session: $session </p>";
	 	

			

		$url="https://crocodoc.com/view/";
		$url .=$session;
                
		 
                //$link = mysql_connect('localhost', 'root', 'root');
		//mysql_select_db('drupaldb', $link);
		//echo "mysql_ping = " . (mysql_ping($link) ? "LIVE" : "DEAD") . "<br /><br />";
                //$result = mysql_query('SELECT * FROM testuuidupload');
                //if (!$result) {
		//	die('Invalid query: ' . mysql_error());
		//}
                //echo $result;
                //while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		//	printf("uuid: %s  filename: %s", $row[0], $row[1]);  
		//}

		//mysql_free_result($result);
                 
                
                

                  $downloadOutput = $croco->download($uuid);
		$downloadOutputAnn = $croco->downloadAnnotated($uuid);
?></br>

<br><p><button id="submit">Read Document</button></p></br>
<script type="text/javascript">
$(document).ready("#submit").click(function() {
		
		
		$('#link').attr('href','<?php echo "$downloadOutput"?>');
		$('#frameview').attr('src','<?php echo "$url" ?>');});

	
</script>
<iframe name="frameview" id="frameview" src="" width="800" height="500"></iframe>
</p></br>
<p><a href="ciao.html" id="link">Download</a></p>