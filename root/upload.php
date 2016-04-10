<?php
session_start();
require 'db.inc.php';
require 'functions.inc.php';
$userid = $_SESSION['id'];
$cid = get_group_id($db, $userid);

$pic_img = '<img src="../images/filetypes/img.png" width="80px" border="0" />';
$pic_doc = '<img src="../images/filetypes/doc.png" width="80px" border="0" />';
$pic_arc = '<img src="../images/filetypes/arc.png" width="80px" border="0" />';
$pic_av = '<img src="../images/filetypes/av.png" width="80px" border="0" />';
$pic_code = '<img src="../images/filetypes/code.png" width="80px" border="0" />';

$filesql = mysql_query("SELECT * FROM files WHERE userid = '$userid'");
while($row = mysql_fetch_array($filesql))
{
	$title = $row["Title"];
	$fileloc = $row["FileLocation"];
	$path_parts = pathinfo($fileloc);
	$uldate = get_cool_date($row["Time"]);
if($path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'png')
{
$file3 .= '
			<table width="100%" cellpadding="4" frame="below">
        <tr>
          <td width="7%">
		  ' . $pic_img . '
          </td>
          <td width="93%" > <a href="'.$row['FileLocation'].'" class = "filetext">
          ' . $title . '</a></br>
		   <span style="font-size:10px;">Uploaded on ' . $uldate . '</span></td>
        </tr>
      </table>';}
	  else if($path_parts['extension'] == 'pdf' || $path_parts['extension'] == 'doc' || $path_parts['extension'] == 'docx' || $path_parts['extension'] == 'ppt' || $path_parts['extension'] == 'pptx' || $path_parts['extension'] == 'txt')

	  {
		 $file3 .= '
			<table width="100%" cellpadding="4" frame="below">
        <tr>
          <td width="7%">
		  ' . $pic_doc . '
          </td>
           <td width="93%" > <a href="'.$row['FileLocation'].'" class = "filetext">
          ' . $title . '</a></br>
		   <span style="font-size:10px;">Uploaded on ' . $uldate . '</span>
		  
		  </td>
        </tr>
      </table>'; }
	   else if($path_parts['extension'] == 'rar' || $path_parts['extension'] == 'zip')

	  {
		 $file3 .= '
			<table width="100%" cellpadding="4" frame="below">
        <tr>
          <td width="7%">
		  ' . $pic_arc . '
          </td>
           <td width="93%" > <a href="'.$row['FileLocation'].'" class = "filetext">
          ' . $title . '</a></br>
		   <span style="font-size:10px;">Uploaded on ' . $uldate . '</span>
		  
		  </td>
        </tr>
      </table>';}
	   else if($path_parts['extension'] == 'avi' || $path_parts['extension'] == 'mp4' || $path_parts['extension'] == 'mp3')

	  {
		 $file3 .= '
			<table width="100%" cellpadding="4" frame="below">
        <tr>
          <td width="7%">
		  ' . $pic_av . '
          </td>
           <td width="93%" > <a href="'.$row['FileLocation'].'" class = "filetext">
          ' . $title . '</a></br>
		   <span style="font-size:10px;">Uploaded on ' . $uldate . '</span>
		  
		  </td>
        </tr>
      </table>';}
	  else if($path_parts['extension'] == 'html' || $path_parts['extension'] == 'css' || $path_parts['extension'] == 'php' || $path_parts['extension'] == 'js')

	  {
		 $file3 .= '
			<table width="100%" cellpadding="4" frame="below">
        <tr>
          <td width="7%">
		  ' . $pic_code . '
          </td>
           <td width="93%" > <a href="'.$row['FileLocation'].'" class = "filetext">
          ' . $title . '</a></br>
		   <span style="font-size:10px;">Uploaded on ' . $uldate . '</span>
		  
		  </td>
        </tr>
      </table>';}

}
 
$filesql2 = mysql_query("SELECT * FROM files WHERE cid = '$cid'");
while($row = mysql_fetch_array($filesql2))
{
	$title = $row["Title"];
	$fileloc = $row["FileLocation"];
	$path_parts = pathinfo($fileloc);
	$uldate = get_cool_date($row["Time"]);
	$uploader = $row["uploader"];
if($path_parts['extension'] == 'jpg' || $path_parts['extension'] == 'png')
{
$file .= '
			<table width="100%" cellpadding="4" frame="below">
        <tr>
          <td width="7%">
		  ' . $pic_img . '
          </td>
           <td width="93%" > <a href="'.$row['FileLocation'].'" class = "filetext">
          ' . $title . '</a></br>
		   <span style="font-size:10px;">Uploaded on ' . $uldate . ' by ' . $uploader . '</span></td>
        </tr>
      </table>';}
	  else if($path_parts['extension'] == 'pdf' || $path_parts['extension'] == 'doc' || $path_parts['extension'] == 'docx' || $path_parts['extension'] == 'ppt' || $path_parts['extension'] == 'pptx' || $path_parts['extension'] == 'txt')

	  {
		 $file .= '
			<table width="100%" cellpadding="4" frame="below">
        <tr>
          <td width="7%">
		  ' . $pic_doc . '
          </td>
           <td width="93%" > <a href="'.$row['FileLocation'].'" class = "filetext">
          ' . $title . '</a></br>
		   <span style="font-size:10px;">Uploaded on ' . $uldate . ' by ' . $uploader . '</span>
		  
		  </td>
        </tr>
      </table>'; }
	   else if($path_parts['extension'] == 'rar' || $path_parts['extension'] == 'zip')

	  {
		 $file .= '
			<table width="100%" cellpadding="4" frame="below">
        <tr>
          <td width="7%">
		  ' . $pic_arc . '
          </td>
           <td width="93%" > <a href="'.$row['FileLocation'].'" class = "filetext">
          ' . $title . '</a></br>
		   <span style="font-size:10px;">Uploaded on ' . $uldate . ' by ' . $uploader . '</span>
		  
		  </td>
        </tr>
      </table>';}
	   else if($path_parts['extension'] == 'avi' || $path_parts['extension'] == 'mp4' || $path_parts['extension'] == 'mp3')

	  {
		 $file .= '
			<table width="100%" cellpadding="4" frame="below">
        <tr>
          <td width="7%">
		  ' . $pic_av . '
          </td>
           <td width="93%" > <a href="'.$row['FileLocation'].'" class = "filetext">
          ' . $title . '</a></br>
		   <span style="font-size:10px;">Uploaded on ' . $uldate . ' by ' . $uploader . '</span>
		  
		  </td>
        </tr>
      </table>';}
	  else if($path_parts['extension'] == 'html' || $path_parts['extension'] == 'php' || $path_parts['extension'] == 'css' || $path_parts['extension'] == 'js')

	  {
		 $file .= '
			<table width="100%" cellpadding="4" frame="below">
        <tr>
          <td width="7%">
		  ' . $pic_code . '
          </td>
           <td width="93%" > <a href="'.$row['FileLocation'].'" class = "filetext">
          ' . $title . '</a></br>
		   <span style="font-size:10px;">Uploaded on ' . $uldate . ' by ' . $uploader . '</span>
		  
		  </td>
        </tr>
      </table>';}
}
 

?>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
function Show_Popup(action, userid) {
$('#popup').fadeIn('fast');
$('#window').fadeIn('fast');


}
function Close_Popup() {
$('#popup').fadeOut('fast');
$('#window').fadeOut('fast');

}
</script>

<?php 
/*$ucheck_pic = "button2.JPG";
$pic9 = "<img src=\"$ucheck_pic\" width=\"94px\" height=\"38.84px\" border=\"0\" />";*/
?>
<div id="sidebar">
<button class="addBtn" onclick="Show_Popup()">Add File</button><br /><br /><br />
<span id="leftbutton">Group Feed</span><br />
<span id="rightbutton">Personal</span>
</div>
<div id="featContent">
<div id="files">
<?php print "$file"; ?>
</div>

<div id="files2">
<?php print "$file3"; ?>
</div>
</div>
<div id="popup" style="display: none;"></div>
<div id="window" style="display: none;">
<div id="popup_content" ><a href="#" onclick="Close_Popup();">Close</a>

        
        <title>Upload Index</title>



<form enctype="multipart/form-data" action="files.php?id=<?php echo $userid; ?>" method="post">
        <p>Choose your file to upload!
  <input name="uploadedfile" type="file" />
  <input name="Upload" type="submit" id="Upload" value="Upload">
          <br />
          And what would you like to call it? <input name="title" type="text" />
        </p>
        <p><br />
        </p>
        <p>&nbsp;</p>
</form>
</div>
</div>

<!--<link rel="stylesheet" href="demo.css" type="text/css"  media="screen" />-->
<style type="text/css">
#popup {
height: 100%;
width: 100%;
background: #000000;
position: absolute;
top: 0;
-moz-opacity:0.75;
-khtml-opacity: 0.75;
opacity: 0.75;
filter:alpha(opacity=75);
}
#window {
width: 600px;
height: 300px;
margin: 0 auto;
border: 1px solid #000000;
background: #ffffff;
position: absolute;
top: 200px;
left: 25%;
}


<html>
<style type="text/css">
a.filetext {
	text-decoration: none;
}
#button
{
right: 180px;
top: 50px;
border-radius: 5px;
border:thick;}
#files
{ /*position:relative;
top:100px;*/
}
#files1
{ /*position:fixed;
top:253px;
left:265px;*/
width:1000px;
display:none;
opacity:0.75;

}
#files2
{ /*position:relative;
top:100px;*/
display:none;
}
#files3
{ /*position:fixed;
top:253px;
left:265px;*/
width:1000px;
display:none;
opacity:0.75;

}
</style>
<!--<div class="buttons">
		<a id="leftbutton" class="button left">Personal</a><a id="rightbutton" class="button right">Project Feed</a>
	</div>-->
     <script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script> 
   <script type="text/javascript">
   
   $('#leftbutton').click(function()
   {
    $('#files').show();
	//$('#files1').show();
	$('#files2').hide();
	//$('#files3').hide();
   return false;
	   });
	   $('#rightbutton').click(function()
   {
    $('#files2').show();
	//$('#files3').show();
	$('#files').hide();
	//$('#files1').hide();
	
   return false;
	   });
  
	   
   </script> 
    
    