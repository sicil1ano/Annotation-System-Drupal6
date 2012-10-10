<html>
<head>
</head>
<body>
<p><br>This is the page to view and annotate documents, please click on the Read Document button..</br></p>
<?php 
        $resultNid = $_GET['id'];
        $resultFound;
	$link = mysql_connect('localhost', 'root', 'root');
	mysql_select_db('drupaldb', $link);
	$result = mysql_query("SELECT filename,uuid FROM testuuidupload WHERE nid='$resultNid'");
        $rows = mysql_num_rows($result);
	if (!$result) {
		die('Invalid query: ' . mysql_error());
		}
        if($rows == '0'){
            $resultFound = false;
            echo "The requested query returned no results. Please, check your page and contact the administrator.";
        }
		
	else{
        $resultFound = true;
	//echo $rows; 
	$files = array();
	$uuids = array();
	for($i=0;$i < $rows;$i++){
		
			$row = mysql_fetch_array($result);
			$files[$i] = $row['filename'];
			$uuids[$i] = $row['uuid'];
			
		
		
	}
	
	
	
	$userID;
    $userName;
    
    if (user_is_logged_in() == TRUE) {
       global $user;
       

                   
       $userID = $user->uid;
       $userName = $user->name;
    }
	
	
	
	function generateSelect($name= '', $options = array()){
		$html = '<p><br><select id="dropdown" name="'.$name.'">';
		
		foreach ($options as $option => $value) {
			
			$html .= '<option value='.$option.'>'.$value.'</option>';
		}
		$html .= '</select></br></p>';
		return $html;
	}
	
	$html = generateSelect('records',$files);
	echo $html;
        }
	
	
?>
<br><p><center><button id="submit">Read Document</button></center></p></br>
<div id="loadingimage"></div>
<script type="text/javascript" src="js/jquery-1.8.1.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
        var resultFound = '<?php echo $resultFound ?>';
        if(resultFound)
             $('#submit').attr('disabled',false);
        else
            $('#submit').attr('disabled',true);

	$('#submit').click(function(){
		
		
		
		var valueSelected = $('#dropdown').val();
		
		
		var username = '<?php echo $userName ?>';
                var userid = '<?php echo $userID ?>';
		
		$.ajax({
			type: "POST",
		    url:"http://localhost:1234/mydomain.drupal/sites/default/files/testPass.php",
			data: {"var": valueSelected, "name": username, "id": userid},
            beforeSend: function(){
				$('#loadingimage').html('<img src="http://localhost:1234/mydomain.drupal/sites/default/files/loading.gif" />');
			},
			complete: function(){
				$('#loadingimage').html('');
			},
			success: function(result){
				
				$('#frameview').attr('src',result);
				
			}
        });
		
		
	});
	
	});

</script>
<br><p>
<iframe name="frameview" id="frameview" src="" width="620" height="600" frameborder="0"></iframe>
</p></br>
<div id="result"></div>
</body>
</html>