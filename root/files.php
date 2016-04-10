<?php
session_start();
include_once "connect_to_mysql.php";

$name = $_SESSION['name'];
$userid = $_SESSION['id'];
$cid = $_SESSION['cid'];
$sql10 = mysql_query("SELECT name,id,cid FROM groupmembers WHERE id='$userid' LIMIT 1");
while($rw1 = mysql_fetch_array($sql10))
{$name2 = $rw1['name'];

}
print "$cid";

$ucheck_pic = "employees/276350_1124904293_4887288_q.jpg";
$pic = "<img src=\"$ucheck_pic\" width=\"40px\" border=\"0\" />";

include_once "connect_to_mysql.php";

//time to see if the file is uploaded.
$putItAt = "employees/$userid/".basename($_FILES['uploadedfile']['name']);
//hmm, will they try uploading a script or a page that might be a security risk?
//lets prevent any .php from getting in, and rename with .txt
$putItAt = str_replace("php","txt", $putItAt);


if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'],$putItAt)){
    //we could echo, but why don't we just go to the file list now?
    savedata();
	
   
    
}else{
        //we totally failed... so lets tell them.
        echo 'You totally failed. click <a href="index.php">here</a> to go back and try again.';
    }


//function time!
function savedata(){
    global $_FILES, $_POST, $putItAt;
    $sql = "INSERT INTO files (
ID ,
userid ,
Time ,
FileLocation ,
IP ,
Title,cid
)
VALUES (
NULL , " . $_GET['id'] . " , now() , '".mysql_real_escape_string($putItAt)."', '".$_SERVER['REMOTE_ADDR']."', '".mysql_real_escape_string($_POST['title'])."','". $_SESSION['cid'] ."');";
mysql_query($sql);
 $sql = mysql_query("INSERT INTO feeds (FileLocation,Title,feeddate,nameofuploader,type) 
     VALUES('".mysql_real_escape_string($putItAt)."','".mysql_real_escape_string($_POST['title'])."',now(),'". $_SESSION['name'] ."','file')")  
     or die (mysql_error());
	 

    
}?>
<html>
Your file has been uploaded <a href="emp_profile.php?id=<?php echo $userid; ?>">Back</a>
</html>