<html>
<head>
	
	
</head>
<body>


<?php
    	include 'crocodoc.php';
  	    $croco = new Crocodoc();
		
		
		$file = 'example.pdf';
		
	    $uuid = $croco->upload('C://Users//albert//Desktop//example.pdf', false);
	 	
	    $resultUuid = json_decode($uuid);
		
		$uuid = $resultUuid->{"uuid"};
				
		
		//$link = mysql_connect('localhost', 'root', 'root');
		//mysql_select_db('drupaldb', $link);
		//echo "mysql_ping = " . (mysql_ping($link) ? "LIVE" : "DEAD") . "<br /><br />";
        //$result = mysql_query('SELECT * FROM testuuidupload');
        //if (!$result) {
			//die('Invalid query: ' . mysql_error());
		//}
        //echo $result;
        //while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
			//printf("uuid: %s  filename: %s", $row[0], $row[1]);  
		//}
        
		
		//$result = mysql_query("INSERT INTO testuuidupload "."(uuid,filename) "."VALUES "."('$uuid', '$file')");
		//if (!$result) {
			//die('Invalid query: ' . mysql_error());
		//}
		//echo $result;
		
		
		//mysql_free_result($result);
		
	    
		sleep(7);
	
	    
	    $status = $croco->getStatus($uuid);
	    
		$resultStatus = json_decode($status);
		$status = $resultStatus[0]->{"status"};
		//$url = "";

		if(strcmp($status, 'DONE') == 0){
		    $userID = 1;
			$userName = "pippo";
			$session = $croco->createSession($uuid,$userID,$userName);
		
			$resultSession = json_decode($session);
			$session = $resultSession->{"session"};
	 	

		

			$url="https://crocodoc.com/view/";
			$url .=$session;
	
		
		}
	
	
	
			$downloadOutput = $croco->download($uuid);
			$downloadOutputAnn = $croco->downloadAnnotated($uuid);
			
			
     ?>

	
<br><p><button id="submit">Read Document</button></p></br>
<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
<script type="text/javascript">
$(document).ready("#submit").click(function() {
		
		
		$('#link').attr('href','<?php echo "$downloadOutput"?>');
		$('#frameview').attr('src','<?php echo "$url" ?>');});

	
</script>

<br><p>
<iframe name="frameview" id="frameview" src="" width="800" height="500"></iframe>
</p></br>
<br><p><button id="downloadFile">Download File</button></p></br>
<p><a href="ciao.html" id="link">Download</a></p>
</form>
</body>
</html>