<?php
    class Crocodoc {
		public $api_key = 'JhOYEo9yT5v2RcfbzAwHQFr4';
		public $api_url = 'https://crocodoc.com/api/v2/';

		private function doCurlPost($url, $data){
			$ch = curl_init();
		//echo curl_multi_getcontent($ch);
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
$data = array(
'token' => $this->api_key,
'uuid' => $uuid,
'editable' => "true",
//'user' => "2,saro",
'user' => $userID.",".$userName,
'downloadable' => "false");
//this is a POST request
$output = $this->doCurlPost($url, $data);
return $output;
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
