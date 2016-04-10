<?php
session_start();
include_once("connect_to_mysql.php");
if (isset($_SESSION['id'])) {
$userid = $_SESSION['id'];
$username = $_SESSION['username'];
}

$id1 = $userid;
if ($id1 == "") {
	echo "Missing Data to Run";
	exit();
}$cnt1=0;
$sql987=mysql_query("Select * from private_messages where recipient_id like '".$userid."' and opened like '0'");
while($row = mysql_fetch_array($sql987)){
	$cnt1++;
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Message inbox </title>
</head>
<div id="emp">
<div id="sidebar"><br/><br/>
<div id="sidebox">
<table cellspacing="0" width="100%" cellpadding="10">
<tr><td id="sidetitle">Folders</td></tr>
<tr><td class="sideitems" id="inbClk">Inbox
<?php

if(!$cnt1==0)
echo ' <div style="font-size:13px"><img src="unread.png" style="right:2px">('.$cnt1.' Unread messages)</div>';

?>
</td></tr>
<tr><td class="sideitems" id="sentbClk">Sent box</td></tr>
</table>
</div>
</div>
<div id="featContent">

<style type="text/css">
div.pmbox
{
	text-align:center;
	background-color:#999999;
	font:large;
	display:none;
	border-radius: 5px;
}
#customers
{

border-collapse:collapse;
}
#customers td, #customers th 
{
font-size:1em;

padding:3px 7px 2px 7px;
}
#customers th 
{
font-size:1.1em;
padding-left:15px;
padding-top:5px;
padding-bottom:4px;
background-color:#00f;
color:#ffffff;
}
#customers tr.alt td 
{
color:#000000;
background-color:#EBF5FF;
}
</style>

<div id="mes_tab">
<form id="del" name="del">
<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION["id"];?>" />
<button type="button" onclick="deleteit()">Delete</button>
</form>
<a href="#"><button id="addBtn">New Private Message</button></a>
<div name="interactionResults" id="interactionResults" style="font-size:15px; padding:10px;"></div>
<div  class="pmbox" id="pmb" style="width:700px">
<form name="pmform" id="pm" method="POST" class="pmform">
<div id='send' align='left'>
<p>&nbsp;&nbsp;To:         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php
$s=$_SESSION['cid'];
$sql231=mysql_query("Select name from groupmembers where cid like '".$s."'");
 $list='<select name="rec" id="rec">';
 
while($row = mysql_fetch_array($sql231))
{$name = $row["name"];
$list .= '
   
   <option>' . $name . '</option>
   ';
	}
$list.='</select>';	
print "$list";
?>
</p>
</div>
<p>Subject:  
  <input name="pmsub" type="text" class="pmsub" id="pmsub" style="width:600px" />
</p>
<p>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;
<textarea name="message" rows="10" id="mess"  class="mess" style="width:600px"></textarea>
</p>
<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION["id"];?>" />
<input type="hidden" name="sender_name"  id="sender_name" value="<?php echo $_SESSION["name"];?>" />
<button type="button" id="sub1" onclick="idpro()">Send Message</button>
 Or <a href="#" id="close" >Close</a>
 </form>
</div>
<div style="padding-left:50px">
<?php
$sql12 = "SELECT * FROM private_messages WHERE recipient_id like '".$id1."' && rec_del like '0' ORDER BY Time DESC";
$ret_pm=mysql_query($sql12);
echo "<form name='t' id='t'>";
echo "<table frame='box' style='width:750px' id='customers' '>
<tr class='alt'>
<th></th>
<th style='width:150px'>Sender</th> 
<th style='width:300px'>Subject</th>
<th style='width:50px'></th>
</tr>";
while($row = mysql_fetch_array($ret_pm)){
$m=$row['id'];
$sub=$row['subject'];
$idf=$row['sender_id'];
$mes=$row['message'];
$open=$row['opened'];
$tim=$row['Time'];

$sql12 = "SELECT * FROM groupmembers WHERE id like '".$idf."'  ";
$res=mysql_query($sql12);
while($row1 = mysql_fetch_array($res)){
	
	$name=$row1['name'];
}

if($open==0)
		{
 echo "  <tr class='alt' id='r$m' >";
          echo" <td width='4%' valign='top' style='padding-left:10px'>";
          echo" <input type='checkbox' name='cb$m' id='cb$m' value='$m' onClick='change(cb$m,$m)' />";
          echo" </td>";
          echo"<td width='20%' valign='top' style='padding-left:10px'>";   
		
		  echo" <a href= '#' onClick='showMessage($m)'>";
		  echo "<strong>$name</strong>";
		  echo "</a>";
		  echo "</td>";
		  echo "<td width='36%' valign='top' align='center' style='padding-left:10px'>";         
		  echo" <a href= '#' onClick='showMessage($m)'>";
		  echo "<strong>$sub</strong>";
		  $cnt1=$cnt1+1;
		}
		else
		
		{
			echo "  <tr id='r$m' >";
          echo" <td width='4%' valign='top' style='padding-left:10px'>";
          echo" <input type='checkbox' name='cb$m' id='cb$m' value='$m' onClick='change(cb$m,$m)' />";
          echo" </td>";
          echo"<td width='20%' valign='top' style='padding-left:10px'>";   
		  echo" <a href= '#' onClick='showMessage($m)'>";
		  echo "$name";
		  echo "</a>";
		  echo "</td>";
		  echo "<td width='36%' valign='top' align='center' style='padding-left:10px'>";         
		  echo" <a href= '#' onClick='showMessage($m)'>";
		  echo "$sub";
		  
		}
		 
		  echo "</a>";
		  echo "</td>";
		  echo "<td style='position:center'>";
		
		  echo "<div align='center' style='font-size:12px' >";
	  	
		  echo $tim;
		  echo "</div>";
		  echo "<br/>";
		  echo "</tr>";
		  echo "<div id='popup' style='display: none'>$mes</div>";
		  echo "<div id='window$m' style='display: none;width:600px; height:300px; margin:0 auto; 			          border:2px solid #CCCCCC; background:#D1E0FF; position:absolute;top:200px;border-radius:5px; left:35%'>
		 ";
		  echo "<div id='popup_content$m' style='width:100%; height:100%;position: absolute;top: 0;-moz-opacity:0.75;-khtml-opacity: 0.75;opacity: 0.75;filter:alpha(opacity=75); '><a href='#' onclick='Close_Popup($m);'>Close Message</a> 
		   <br/><br/><br/><b>
		  <strong>Sender:</b></strong> $name <br/><br/> 
		  <strong>Subject:</strong> $sub<br/><br/> 
		  <strong>Message:</strong> $mes<br/><br/><br/><br/><br/></div></div>";
		  
		  
}
echo "</table>";
echo "</form>";
?> 
</div>        
</div>
<div name="sent" id="sent">

<div id="mes_t" style="display:none">
<form id="del" >
<input type="hidden" name="sender_id" id="sender_id" value="<?php echo $_SESSION["id"];?>" />
<button type="button" onclick="deleteit1()">Delete</button>
</form>
<div style="padding-left:50px">
<?php
$sql12 = "SELECT * FROM private_messages WHERE sender_id like '".$userid."' && sender_del like '0' ORDER BY Time DESC";
$ret_pm=mysql_query($sql12);
echo "<form name='t' id='t'>";
echo "<table frame='box' style='width:750px' id='customers' '>
<tr class='alt'>
<th></th>
<th style='width:150px'>Sent to</th> 
<th style='width:300px'>Subject</th>
<th style='width:50px'></th>
</tr>";
$e=1;
while($row = mysql_fetch_array($ret_pm)){
$m=$row['id'];
$sub=$row['subject'];
$idf=$row['recipient_id'];
$mes=$row['message'];
$open=$row['opened'];
$tim=$row['Time'];
$sql12 = "SELECT * FROM groupmembers WHERE id like '".$idf."'  ";
$res=mysql_query($sql12);
while($row1 = mysql_fetch_array($res)){
	$name=$row1['name'];
}


	{
			echo "  <tr id='r$m' >";
          echo" <td width='4%' valign='top' style='padding-left:10px'>";
          echo" <input type='checkbox' name='cb$m' id='cb$m' value='$m' onClick='change1(cb$m,$m)' />";
          echo" </td>";
          echo"<td width='20%' valign='top' style='padding-left:10px'>";   
		  echo" <a href= '#' onClick='showMessage1($m)'>";
		  echo "$name";
		  echo "</a>";
		  echo "</td>";
		  echo "<td width='36%' valign='top' align='center' style='padding-left:10px'>";         
		  echo" <a href= '#' onClick='showMessage1($m)'>";
		  echo "$sub";
		}
		  echo "</a>";
		  echo "</td>";
		  echo "<td style='position:center'>";
		  echo "<div align='center' style='font-size:12px'>$tim</div>";
		  echo "<br/>";
		  echo "</tr>";
echo "<div id='popup1' style='display: none'>$mes</div>";
		  echo "<div id='window1$m' style='display: none;width:600px; height:300px; margin:0 auto; 			          border:2px solid #CCCCCC; background:#D1E0FF; position:absolute;top:200px;border-radius:5px; left:35%'>
		 ";
		  echo "<div id='popup_content1$m' style='width:100%; height:100%;position: absolute;top: 0;-moz-opacity:0.75;-khtml-opacity: 0.75;opacity: 0.75;filter:alpha(opacity=75); '><a href='#' onclick='Close_Popup1($m);'>Close Message</a> 
		   <br/><br/><br/><b>
		  <strong>Sender:</b> $name </strong><br/><br/> 
		  Subject: $sub<br/><br/> 
		  Message: $mes<br/><br/><br/><br/><br/></div></div>";
}
echo "</table>";
echo "</form>";
?> 
</div>        
</div>
</div>
</div>
 </div>
<script type="text/javascript" src=".//jquery.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $("#sentbClk").click(function(){
    $("#mes_t").show();
	 $("#mes_tab").hide();
  });
});


$(document).ready(function(){
  $("#inbClk").click(function(){
    $("#mes_tab").show();
	 $("#mes_t").hide();
  });
});


function showMessage(data)
{
	$('#popup'+data).fadeIn('fast');
	$('#window'+data).fadeIn('fast');
	$.post('markrd.php',{idm:data},function(){
	}) ;	
}


function Close_Popup(data1) {
$('#popup'+data1).fadeOut('fast');
$('#window'+data1).fadeOut('fast');
$('#emp').load('inbox.php');
}


function deleteit()
{
	var dat=document.getElementById("sender_id").value;
	$.post('del_mes.php',{id12:dat}, function(){
	$('#emp').load('inbox.php'); 
	}
	);
}

function change(data3,ids)
{ 	
	if(data3.checked)
	$.post('chan.php',{chk:'1',chg:ids});
	else
	$.post('chan.php',{chk:'0',chg:ids}) ;
}


$(document).ready(function(){
  $("#addBtn").click(function(){
    $(".pmbox").slideDown("slow");
  });
});


$(document).ready(function(){
  $("#close").click(function(){
    $(".pmbox").slideUp("slow");
  });
});


function idpro() {
	var msg = document.getElementById("mess").value;
	var to=document.getElementById("rec").value;
	var subj=document.getElementById("pmsub").value;
	var senderid=document.getElementById("sender_id").value;
	var sendername=document.getElementById("sender_name").value;
	var url='demo.php';
	var url1='private_msg_parse.php';
	  if (subj=="") {
          $("#interactionResults").html('<img src="error.png" alt="Error" width="31" height="30" /> &nbsp; Please type a subject.')					.show().fadeOut(6000);
      } 
      else if (msg == "") {
		   $("#interactionResults").html('<img src="error.png" alt="Error" width="31" height="30" /> &nbsp; Please type in your message.').show().fadeOut(6000);
     } 
	 else
   {
	$.post(url,{message:msg,subject:subj,recipient:to,ids:senderid,idn:sendername},function(datar) {
$.post(url1,{recei:datar.recid1,recni:datar.recn,subji:datar.subje,sendei:datar.senderi,sendernmi:datar.sendernm,messi:datar.meesg},function(dataul) {
		$("#interactionResults").html(dataul).show().fadeOut(6000);
		document.pmform.mess.value='';
		document.pmform.pmsub.value='';
		
	});
	},'json');
   }
}
   


function showMessage1(data)
{
	$('#popup1'+data).fadeIn('fast');
	$('#window1'+data).fadeIn('fast');
		
}


function Close_Popup1(data1) {
$('#popup1'+data1).fadeOut('fast');
$('#window1'+data1).fadeOut('fast');

}


function deleteit1()
{
	var dat=document.getElementById("sender_id").value;
	$.post('del_mess.php',{id12:dat}, function(){
	$('#emp').load('inbox.php');
	}
	);
}

function change1(data3,ids)
{ 	
	if(data3.checked)
	$.post('chans.php',{chk:'1',chg:ids});
	else
	$.post('chans.php',{chk:'0',chg:ids}) ;
}
</script>

<style type="text/css">
#addBtn
{
	-webkit-box-shadow: rgba(0, 0, 0, 0.199219) 0px 1px 0px 0px;
	background: transparent url("../images/New Mail.png") center left no-repeat;
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
}
</style>