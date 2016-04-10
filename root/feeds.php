<?php
session_start();
require "db.inc.php";
require "functions.inc.php";

$uid=$_SESSION['id'];
$filepic = '<img class="feedIndicator" src="../images/ifile.png" />';
$eventpic = '<img class="feedIndicator" src="../images/ievent.png" />';
$todopic = '<img class="feedIndicator" src="../images/itask.png" />';
$msgpic = '<img class="feedIndicator" src="../images/imsg.png" />';
$cid = get_group_id($db,$uid);
$sql = mysql_query("SELECT * FROM feeds WHERE cid='$cid' ORDER BY feeddate DESC LIMIT 20");
while($row = mysql_fetch_array($sql))
{
	$name = $row["name"];
	$uid = $row["userid"];
	$ufeed = $row["feed"];
	$feeddate = get_cool_date($row["feeddate"]);
	$type = $row["type"];
	$nameofuploader = $row["nameofuploader"];
	$sql2 = mysql_query("SELECT last_name FROM groupmembers WHERE name='$nameofuploader'");
	$nameoflist = $row["nameoflist"];
	$assign = $row["assign"];
	$title = $row["Title"];
	$location = $row["FileLocation"];


	
	
	if($type == "file")
{
$feeds .= '
			<table frame="below" width="100%" cellspacing="0">
        <tr><br/>
          <td width="7%" bgcolor="#FFFFFF">'.$filepic.'<br />
          </td>
          <td width="93%" class = "border" >
          ' . $nameofuploader . '  added a file <a href="'.$row['FileLocation'].'" class = "filetext">
          ' . $title . '</a><br /><span style="font-size:10px; font-weight:bold; color:#A6A6A6;">' . $feeddate . '</span></td>
        </tr>
      </table>';}
	  else if($type == "todo"){
		  $feeds .= '
			<table frame="below" width="100%" cellspacing="0">
        <tr><br/>
          <td width="7%" bgcolor="#FFFFFF">'.$todopic.'<br />
          </td>
          <td width="93%" class = "border" >' . $nameofuploader . ' assigned task list "' . $nameoflist . '" to ' . $assign . '<br /><span style="font-size:10px; font-weight:bold; color:#A6A6A6;">' . $feeddate . '</span></td>
        </tr>
      </table>';
		  }
		  else if($type == "event"){
		  $feeds .= '
			<table frame="below" width="100%" cellspacing="0">
        <tr><br/>
          <td width="7%" bgcolor="#FFFFFF">'.$eventpic.'<br />
          </td>
          <td width="93%" class = "border" >' . $name . ' added an event &nbsp;"' . $ufeed . '"<br /><span style="font-size:10px; font-weight:bold; color:#A6A6A6;">' . $feeddate . '</span></td>
        </tr>
      </table>';
		  } else if ($type == "message") {
			   $feeds .= '
			<table frame="below" width="100%" cellspacing="0">
        <tr><br/>
          <td width="7%" bgcolor="#FFFFFF">'.$msgpic.'<br />
          </td>
          <td width="93%" class = "border" >' . $nameofuploader . ' added a message &nbsp;"' . $title . '"<br /><span style="font-size:10px; font-weight:bold; color:#A6A6A6;">' . $feeddate . '</span></td>
        </tr>
      </table>';
		  }

}?>
<div id="sidebar">
<div style="font-weight:bold;font-size:16px;width:210px;border-style:solid;border-width:0 0 1px 0;border-color:#0099FF;color:#0099FF;padding:0 10px 0 10px">Project Members</div>
<?php $sql3 = mysql_query("SELECT * FROM groupmembers WHERE cid = '$cid'");
while($row = mysql_fetch_array($sql3))
{
	$name12 = $row["name"];
	$designation = $row["designation"];
	$city = $row["city"];
	$number = $row["number"];
	$newid = $row["id"];
	$memberpic = '<img src="../memberFiles/'.$newid.'/pic1.jpg" width="60px" height="60px" />'; 
	$miniprofile ='&nbsp;<table class="mprofile" frame="box" width="230px;">
<tr>
<td rowspan="4" width="70px;">'.$memberpic.'</td>
<td><span>Name :</span><b> '.$name12.'</b></td></tr>
<tr><td><span>Number :</span><b>'.$number.'</b></td></tr>
<tr><td><span>Designation :</span><b>'.$designation.'</b></td></tr>
<tr><td><span>Location :</span><b> '.$city.'</b></td></tr>
</table>';
print $miniprofile;
	 }
  ?>
</div>
<div id="featContent">
<?php print "$feeds"; ?>
</div>
<p>&nbsp;</p>
<!--<script src="http://code.jquery.com/jquery-latest.js"></script>
<script>
$("td.border").hover(
  function () {
    $(this).append($("<a href=# class='ad'> er</a>"));
  }, 
  function () {
     $("a.ad").remove();
  }
);

</script>-->
<style type="text/css">
tr
{margin-top:5px;
margin-bottom:5px;

}
table.mprofile
{
font-size:12px;
background-color:#F0F0F0;
border-radius:4px;
margin:0 auto 0 auto;

}
span
{color:#666666;}
</style>