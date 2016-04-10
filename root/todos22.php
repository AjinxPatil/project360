<?php
session_start();
?>
<html>
<head>
<link href="styleButton.css" rel="stylesheet" type="text/css" media="screen" />


<?php
include_once "connect_to_mysql.php";
$sql = mysql_query("SELECT * FROM timetracking WHERE cid = '$cid'");
$finaltable1 ='<table frame="below" width="650">
  <tr>
    <td width="33%"><strong>Name of Task</strong></td>
    <td width="33%"><strong>Description</strong></td>
    <td width="33%"><strong>Hours Invested</strong></td>
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
$finaltable1 .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Total:</strong>'.$total.' hours';
/*$finaltable1 .=
'<table frame="below">
<tr class="row">
    <td align="left"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total time spent on Project:</b>'.$total.'</td>
    
  </tr>
  

';*/

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



<? $finaltable4 = '<div id="total"><div align="right"><a href="#"><button id="addBtn">Log Time</button></a></div>
</div>';?>
<?php $finaltable3 .= '

<br/><div id="formajax">
Name of task:   
  <label for="name"></label>
  <input type="text" name="name" id="name">
<br/>
&nbsp;&nbsp;&nbsp;Description:
  <textarea name="description" id="description" cols="45" rows="5"></textarea>
<br/>
  <label for="time"></label>
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hours :       
   <select name="time" id="list">
    <option>1</option>
    <option>2</option>
    <option>3</option>
    <option>4</option>
  </select>
  <br />  
  
  
  
</p>
<p>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input name="myBtn" align="absmiddle" type="submit" class="greyBtn" value="Submit Data" onClick="javascript:ajax_post();">
</p><br/>
</div>';?>


 </body> 
</html>
<div id="sidebar"></div>
<div id="featContent">
<div id="status">
<div id="form1"><?php print $finaltable1;

 ?> </div></div>
 <div id="logbutton"><?php print $finaltable4;?>
<br/><div id="form"><?php 
print $finaltable3; ?> </div></div>

<script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script>
<script type="text/javascript">
 $('#addBtn').click(function()
   {
    $('#form').slideDown();

	   });
</script>
<style type="text/css">
div.addblock
{
	background-color: #999;
}
table
{
	border-bottom: 1px #CCC solid;
	
	
}

#form
{background-color:00CCFF;
border-radius:5px;
width:650px;
display:none;
position:absolute;

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
#btn
{}
#addBtn
{
	-webkit-box-shadow: rgba(0, 0, 0, 0.199219) 0px 1px 0px 0px;
	background: transparent url("../images/logtime.png") center left no-repeat;
	background-color: #999999;
	border-bottom-color:#333;
	border:0;
	box-shadow: rgba(0, 0, 0, 0.199219) 0px 1px 0px 0px;
	color: #FFF;
	font-size: 12px;
	height: 35px;
	padding:5px;
	text-decoration:none;
	cursor:pointer;
	text-indent:28px;
	text-shadow: 0px 1px 2px #555;
	border-radius:2px;
	position:relative;
right:520px;
top:10px;
}
</style>





