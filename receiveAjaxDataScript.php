<?php
	$resultVar = $_POST['var'];
	$resultName = $_POST['name'];
	$resultID = $_POST['id'];
	//echo $resultName.' e '.$resultID;
	//echo $resultName;
	$link = mysql_connect('localhost', 'drupalAdmin', 'admin');
	mysql_select_db('drupal', $link);
	
	$result = mysql_query("SELECT * FROM testuuidupload");
	if (!$result) {
		die('Invalid query: ' . mysql_error());
		}		
		
	$roleTeacher = '4';    
	$roleStudent = '3';
	
	$resultTeachers = mysql_query("SELECT uid FROM drupaltbl_users_roles WHERE rid= '$roleTeacher'");
	if(!$resultTeachers){
		die('Invalid query: '.mysql_error());
	}	
		
	$rows = mysql_num_rows($result);
	//echo $rows; 
	//$files = array();
	$uuids = array();
	for($i=0;$i < $rows;$i++){
		//while($row = mysql_fetch_array($result)){
			$row = mysql_fetch_array($result);
			//$files[$i] = $row['filename'];
			$uuids[$i] = $row['uuid'];
			//echo "<p><center>".$row['uuid']." and : ".$row['filename']."</p></center>";
			}
			
	$rowsTeachers = mysql_num_rows($resultTeachers);
	$teachers = array();
	for($i=0;$i < $rowsTeachers;$i++){
		$rowTeacher = mysql_fetch_array($resultTeachers);
		$teachers[$i] = $rowTeacher['uid'];
	}
	
	//echo var_dump($teachers);
	$teachersConcatenate = '';
	for($i=0;$i < count($teachers);$i++){
		if($i == count($teachers) -1){
			$teachersConcatenate .= $teachers[$i];
		}
		else
			$teachersConcatenate .= $teachers[$i].',';
				
		
	}
	
	$resultRole = mysql_query("SELECT rid FROM drupaltbl_users_roles WHERE uid= '$resultID'");
	if(!$resultRole){
		die('Invalid query: '.mysql_error());
	}
	
	$rowRole = mysql_fetch_array($resultRole);
	$userRole =  $rowRole['rid'];
	
	//$teachersConcatenate = str_replace('"',"'",$teachersConcatenate);

	
		//}
	//$q=$_POST["q"];

	//echo "<p>result retrieved : $str</p>";
//if($_POST['var']) {
    
	//$resultUuids = $_POST['uuids'];
	//$resultUuid = json_decode($resultUuids);
	//$resultUuid = json_decode($_POST['']);
	//echo var_dump($resultUuid);
	/*$link = mysql_connect('localhost', 'root', 'root');
	mysql_select_db('drupaldb', $link);
	$result = mysql_query("SELECT uuid FROM testuuidupload WHERE filename='".$resultVar."'");
	if (!$result) {
		die('Invalid query: ' . mysql_error());
		}
		
	$row = mysql_fetch_array($result);*/
	//echo $row['uuid'];

    	
		
	//$uuid = $resultUuid->{"0"};
	
	//$resultUuids = json_decode($_POST['$uuids']);
	//echo "$resultUuids";
	//echo $uuid;
	//$uuids = echo $resultUuids; 
    //echo $resultVar.' is successfully passed to the same page using Ajax Post. And I have this : :)';    
	//echo $uuid.' is successfully passed to the same page using Ajax Post. And I have this : :)';    
//} else {
  //  echo 'There is no POST variable passed to the same page. :( ';  
//}
 

	
//echo '<br> Above indicates the ajax post function \'.\' ';
	function createSession($uuid,$userName,$userID,$userRoleID,$annotationFilter) {
	//$prova='4';
	//$filter1 = $prova.",".'1';	
//$filter = $teachersConcatenate1;
        global $roleTeacher;
		$api_key = 'JhOYEo9yT5v2RcfbzAwHQFr4';
		$api_url = 'https://crocodoc.com/api/v2/';
		$url = $api_url.'session/create';
        if($userID == 1 || ($userRoleID == $roleTeacher)){
		//$url = $api_url.'session/create';
			$data = array(
             'token' => $api_key,
             'uuid' => $uuid,
             'editable' => "true",
             'user' => $userID.",".$userName,
			 'admin' => "true",
             //'user' => $userID.",".$userName,
             'downloadable' => "true");
//this is a POST request
             $output = doCurlPost($url, $data);
			 //echo $output;
			 //$output = "qui è admin";
             return $output;
			 }		
		else {
		    //$url = $api_url.'session/create';
			$data = array(
			 'token' => $api_key,
             'uuid' => $uuid,
			 'filter' => "$userID,$annotationFilter",
			 'admin' => "false",
             'editable' => "true",
             //'user' => $userID.",".$userName,
			 'user' => $userID.",".$userName,
             'downloadable' => "true");	     
             $output = doCurlPost($url, $data);
			 //$output = "qui è altro utente";
             return $output;
		}	 
  }
  
      function doCurlPost($url, $data){
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
			//echo $output;
			return $output;
		}
		
		//$uuid = $row['uuid'];
		//$resultInt = intval($result);
		//var_dump($uuids);
		$uuid = $uuids[intval($resultVar)];
		$session = createSession($uuid,$resultName,$resultID,$userRole,$teachersConcatenate);
		$decodeSession = json_decode($session);
		$session = $decodeSession->{"session"};
		
		$url="https://crocodoc.com/view/";
		$url .=$session;
		//echo $uuid;
        echo $url;
		//echo $session;
  
  if($_POST['var']){exit();}
	
?>