<html>
<head>
<link href="styleButton.css" rel="stylesheet" type="text/css" media="screen" />
<div id="popup" style="display: none;"></div>
<div id="bgo"></div>
<div id="container" onClick="Show_Popup()">

<a href="#" class="btn">Log Time</a>

</div>
<div id="head1"></div>
<?php
include_once "connect_to_mysql.php";
$sql = mysql_query("SELECT * FROM timetracking");
$finaltable1 ='<table frame="below" width="650">
  <tr>
    <td width="33%"><b>Name of Task</b></td>
    <td width="33%"><b>Description</b></td>
    <td width="33%"><b>Hours Invested</b></td>
  </tr>
</table>
';
$total = 0;
while($row = mysql_fetch_array($sql))
{$name = $row['name'];
$description = $row['description'];
$hours = $row['hours_invested'];
$total = $total + $hours;
$finaltable1 .= '<table frame="below" class="ftable" width="650">
<tr class="row">
    <td width="33%">'.$name.'</td>
    <td width="33%">'.$description.'</td>
    <td width="33%"> '.$hours.'</td>
  </tr></table>
  
';}
$finaltable1 .=
'<table frame="below">
<tr class="row">
    <td align="left"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total time spent on Project:</b>'.$total.'</td>
    
  </tr>
  

';
?>


<script src="http://code.jquery.com/jquery-latest.js"></script>
<script language="JavaScript" type="text/javascript">

function ajax_post(){
    $("#form1").hide();
    var hr = new XMLHttpRequest();
    
	
    var url = "my_parse_filefe.php";
    var fn = document.getElementById("description").value;
	  var nm = document.getElementById("name").value;
	  var sel = $('#list option:selected').text()

     var vars = "todo="+fn+"&name="+nm+"&sel="+sel;
    hr.open("POST", url, true);
   
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("status").innerHTML = return_data;
	    }
    }
    hr.send(vars); // Actually execute the request
  
}
</script>

</head>
<body>



<div id="status"></div>
<div id="total"></div>
<?php $finaltable3 .= '<div class="addblock">
<p>Name of task:   
  <label for="name"></label>
  <input type="text" name="name" id="name">
</p>
<p>Description:
  <textarea name="description" id="description" cols="45" rows="5"></textarea>
</p>
<p>
  <label for="time"></label>
   Hours :       
   <select name="time" id="list">
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
  </select>
  <br />
  
  
  
  
</p>
<p>
  <input name="myBtn" type="submit" value="Submit Data" onClick="javascript:ajax_post();">
</p>
</div>';?>
<p>
  <br />
  <br /> 
</p>



</body>
</html>
<div id="form1"><?php print $finaltable1; ?> </div>

<script type="text/javascript">
function ajax_pfost(){
    
    var hr = new XMLHttpRequest();
    
	
    var url = "test5.php";
    

    
    hr.open("POST", url, true);
   
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("total").innerHTML = return_data;
	    }
    }
    // Actually execute the request
  
}

</script>
<style type="text/css">
div.addblock
{
	background-color: #999;
}
table
{
	border-bottom: 1px #CCC solid;
	font-family:Verdana, Geneva, sans-serif;
	
}
#form1
{position:absolute;
left:95px;
top:115px;}
#total
{position:absolute;
top:0px;
}
#head1
{
	background-color:#69F;
	position:absolute;
	top:114px;
	left:95px;
	height:26px;
	width:650px;
}
#bgo
{
width:1380px;height:650px;

opacity:0.7;
display:none;


position: absolute;
top: 0;
-moz-opacity:0.75;
-khtml-opacity: 0.75;
opacity: 0.75;
filter:alpha(opacity=75);
}
</style>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
function Show_Popup(action, userid) {


$('#popup').fadeIn('fast');
$('#popup2').fadeIn('fast');
$('#window').fadeIn('fast');


}
function Close_Popup() {
$('#popup').fadeOut('fast');
$('#popup2').fadeOut('fast');
$('#window').fadeOut('fast');
}
</script>
<div id="popup2" style="display: none;"></div>
<div id="window" style="display: none;">
<div id="popup_content" ><a href="#" onclick="Close_Popup();">Close</a>
<?php print $finaltable3; ?>
 </div>
</div>


<style type="text/css">
#popup {
height: 100%;
width: 100%;;
background: #000000;
position: absolute;
top: 0;
-moz-opacity:0.75;
-khtml-opacity: 0.75;
opacity: 0.75;
filter:alpha(opacity=75);
}
#popup2 {
height: 100%;
width: 100%;;
background: #000000;
position: absolute;
top: 0;
-moz-opacity:0.75;
-khtml-opacity: 0.75;
opacity: 0.75;
filter:alpha(opacity=75);
}
#window {
width: 700px;
height: 300px;
margin: 0 auto;
border: 1px solid #000000;
background: #ffffff;
position: absolute;
top: 20px;
left: 25%;
}
#container
{
	position: absolute;
	top: 75px;
	left:643px;
}
</style>
