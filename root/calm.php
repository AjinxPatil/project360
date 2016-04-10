

<?php 

$ucheck_pic = "Close.JPG";

$pic9 = "<img src=\"$ucheck_pic\" width=\"20px\" height=\"20px\" border=\"0\" />";

?>
 <?php
 include_once "connect_to_mysql.php";
$eventt='';
$userid = $_GET['id'];



$days = array();

$n = 5;



      

	  $my_t=getdate(date("U"));

 $m=$my_t[mon];

 $y=$my_t[year];

 $mth = (int) $m;

 $yr = (int) $y; 
		


		$sql = mysql_query("SELECT events

FROM events

WHERE userid = '$userid'

and month = '$mth' ");

		while($rw = mysql_fetch_array($sql))

		{

		

	$eventt.= $rw["events"];

	

		

		}

		$sql2 = mysql_query("SELECT day

FROM events

WHERE userid = '$userid'

and month = '$mth' ");

$rw2 = mysql_fetch_array($sql2);

           array_push($days, $rw2["day"]);

		while($rw2 = mysql_fetch_array($sql2))

		{

			array_push($days, $rw2["day"]);

		}

		$nd=count($days);

		$sql3 = mysql_query("SELECT * FROM events WHERE userid = '$userid' and milestone='no'");

		$sql4 = mysql_query("SELECT * FROM events WHERE userid = '$userid' and milestone='yes'");

		$dayn=date("d");

		$yearn=date("Y");

		$monthn=date("m");

		echo '<div id="sidebar">';
		echo " <div id='even'>";
		echo "<strong>Events</strong> <br/>";

		echo "<table border='0'>";

		while($rw3 = mysql_fetch_array($sql3))

		{

			$dayt=$rw3['day'];

			$montht=$rw3['month'];

			$yeart=$rw3['year'];

	

		if(($yearn)==($yeart))

		{

			if(($monthn)<($montht))

			echo "<tr><td>".$rw3['events']."-&ensp; &ensp;</td> <td>starting on ".$dayt."/".$montht."</td></tr>";

			else

			if((($monthn)==($montht))&&(($dayn)<($dayt)))

			echo "<tr><td>".$rw3['events']."-&ensp; &ensp;</td> <td>starting on ".$dayt."/".$montht."</td></tr>";

		}

		

		}

		echo "</table>";

		echo "<br/><br/><strong>Milestones</strong><br/><br/>";

		echo "<table border='0'>";

		while($rw4 = mysql_fetch_array($sql4))

		{

			$dayt=$rw4['day'];

			$montht=$rw4['month'];

			$yeart=$rw4['year'];

	

		if(($yearn)==($yeart))

		{

			if(($monthn)<($montht))

			{

				

				echo "<tr><td>".$rw4['events']."-&ensp; &ens;p</td> <td>starting on ".$dayt."/".$montht."</td></tr>";

			}

			else

			if((($monthn)==($montht))&&(($dayn)<($dayt)))

			{

				$ev=$rw4['events'];

				echo "<tr><td>".$rw4['events']."-&ensp; &ensp;</td> <td>starting on ".$dayt."/".$montht."</td></tr>";

			}

		}

		

		}

		echo "</table>";

		echo "</div></div>";

		
	    /* sample usages echo date("l"); */
		echo "<div id='featContent'>";
        echo date("F");
		echo date("Y");

		

        echo draw_calendar($mth, $yr);
		echo '<div id="status"></div>';

		echo "</div>";
        
	

		

        ?>

<?php

/* draws a calendar */

function draw_calendar($month, $year) {



    /* draw table */

    $calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';



    /* table headings */

    $headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

    $calendar.= '<tr class="calendar-row"><td class="calendar-day-head">' . implode('</td><td class="calendar-day-head">', $headings) . '</td></tr>';



    /* days and weeks vars now ... */

    $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));

    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));

    $days_in_this_week = 1;

    $day_counter = 0;

    $dates_array = array();



    /* row for week one */

    $calendar.= '<tr class="calendar-row">';



    /* print "blank" days until the first of the current week */

    for ($x = 0; $x < $running_day; $x++):

        $calendar.= '<td class="calendar-day-np" >&nbsp;</td>';

        $days_in_this_week++;

    endfor;

    $numbervar = 0;



    /* keep going with days.... */

    for ($list_day = 1; $list_day <= $days_in_month; $list_day++):



			

        $calendar.= '<td class="calendar-day">';

        /* add in the day number */

        $numbervar++;

				for ($i=0; $i<=$nd; $i++)

  {if($numbervar==$days[$i])

         {		

        $calendar.= '<div class="day-number-event" onClick="store(' . $numbervar . ',' . $month . ',' . $year . ')">' . $list_day . '</div>';

		 }

		 else

		 {$calendar.= '<div class="day-number" onClick="store(' . $numbervar . ',' . $month . ',' . $year . ')">' . $list_day . '</div>';

}}

        /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! * */

        $calendar.= str_repeat('<p>&nbsp;</p>', 2);



        $calendar.= '</td>';

        if ($running_day == 6):

            $calendar.= '</tr>';

            if (($day_counter + 1) != $days_in_month):

                $calendar.= '<tr class="calendar-row">';

            endif;

            $running_day = -1;

            $days_in_this_week = 0;

        endif;

        $days_in_this_week++;

        $running_day++;

        $day_counter++;

    endfor;



    /* finish the rest of the days in the week */

    if ($days_in_this_week < 8):

        for ($x = 1; $x <= (8 - $days_in_this_week); $x++):

            $calendar.= '<td class="calendar-day-np">&nbsp;</td>';

        endfor;

    endif;



    /* final row */

    $calendar.= '</tr>';



    /* end the table */

    $calendar.= '</table>';



    /* all done, return result */

    return $calendar;

	



}



?>



<!DOCTYPE HTML>

<html>

    <head>

        <title>Calender</title>

    <style type="text/css">

        /* calendar */

        table.calendar		{ border-left:1px solid #999; }

        tr.calendar-row	{  }

        td.calendar-day	{ min-height:80px; font-size:11px; /*position:relative;*/ } * html div.calendar-day { height:80px; }

        td.calendar-day:hover	{ background:#eceff5; }

        td.calendar-day-np	{ background:#eee; min-height:80px; } * html div.calendar-day-np { height:80px; }

        td.calendar-day-head { background:#ccc; font-weight:bold; text-align:center; width:120px; padding:5px; border-bottom:1px solid #999; border-top:1px solid #999; border-right:1px solid #999; }

        div.day-number		{

            background:#999;

            padding:5px;

            color:#9C0;

            font-weight:bold;

            float:right;

            margin:-5px -5px 0 0;

            width:20px;

            text-align:center;

        }

		div.day-number-event		{

	background:#999;

	padding:5px;

	color:#009;

	font-weight:bold;

	float:right;

	margin:-5px -5px 0 0;

	width:20px;

	text-align:center;

        }

        /* shared */

        td.calendar-day, td.calendar-day-np { width:120px; padding:5px; border-bottom:1px solid #999; border-right:1px solid #999; }

   

  

table {

border-collapse:separate;

border-spacing:0pt;

}

caption, th, td {

font-weight:normal;

text-align:left;

}

blockquote:before, blockquote:after, q:before, q:after {

content:"";

}

blockquote, q {

quotes:"" "";

}

a{

cursor: pointer;

text-decoration:none;

}

br.both{

clear:both;

}

#backgroundPopup{

display:none;

position:fixed;

_position:absolute; 

height:100%;

width:100%;

top:0;

left:0;

background:#000000;

border:1px solid #cecece;

z-index:1;

}

#popupContact{

display:none;

position:fixed;

_position:absolute; 

height:384px;

width:408px;

background:#FFFFFF;

border:2px solid #cecece;

z-index:2;

padding:12px;

font-size:13px;

}

#popupContact h1{

text-align:left;

color:#6FA5FD;

font-size:22px;

font-weight:700;

border-bottom:1px dotted #D3D3D3;

padding-bottom:2px;

margin-bottom:20px;

}

#popupContactClose{

font-size:14px;

line-height:14px;

right:6px;

top:4px;

position:absolute;

color:#6fa5fd;

font-weight:700;

display:block;

}

#button{

text-align:center;

margin:100px;

}





   

   

   

    </style>



  <script src="http://jqueryjs.googlecode.com/files/jquery-1.2.6.min.js" type="text/javascript"></script>  

    <script src="popup.js" type="text/javascript"></script> 

     <script type='text/javascript'>

	

   var xx, yy, zz; //These are your global variables

   var tt=false;

   var popupStatus = 0;

   //loading popup with jQuery magic!

function loadPopup(){

//loads popup only if it is disabled

if(popupStatus==0){

$("#backgroundPopup").css({

"opacity": "0.7"

});

$("#backgroundPopup").fadeIn("slow");

$("#popupContact").fadeIn("slow");

popupStatus = 1;

}

}

//disabling popup with jQuery magic!

function disablePopup(){

//disables popup only if it is enabled

if(popupStatus==1){

$("#backgroundPopup").fadeOut("slow");

$("#popupContact").fadeOut("slow");

popupStatus = 0;

}

}

//centering popup

function centerPopup(){

//request data for centering

var windowWidth = document.documentElement.clientWidth;

var windowHeight = document.documentElement.clientHeight;

var popupHeight = $("#popupContact").height();

var popupWidth = $("#popupContact").width();

//centering

$("#popupContact").css({

"position": "absolute",

"top": windowHeight/2-popupHeight/2,

"left": windowWidth/2-popupWidth/2

});

//only need force for IE6



$("#backgroundPopup").css({

"height": windowHeight

});



}

//CLOSING POPUP

//Click the x event!

$("#popupContactClose").click(function(){

disablePopup();

});

//Click out event!

$("#backgroundPopup").click(function(){

disablePopup();

});







   function store(x,y,z) {   

      xx = x;

      yy = y;

      zz = z;          

      var date = x+" "+y+" "+z;

      document.getElementById("date").value=date;

	  $(document).ready(function(){

//LOADING POPUP

//Click the button event!



//centering with css

centerPopup();

//load popup

loadPopup();





});

   }

</script>

<script type='text/javascript' src='jquery.js'></script>

<script type="text/javascript">

   function send(){

	   var hr = new XMLHttpRequest();

    

	

    var url = "ajaxevent.php";

    var date = document.getElementById("date").value;

	  var events = document.getElementById("events").value;

	  var milestone = $("#mil").val();

     var vars = "date="+date+"&events="+events+"&milestone="+milestone;

    hr.open("POST", url, true);

   

    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    hr.onreadystatechange = function() {

	    if(hr.readyState == 4 && hr.status == 200) {

		    var return_data = hr.responseText;

			document.getElementById("status").innerHTML = return_data;

	    }

    }

    hr.send(vars);  

	$('#graphic').fadeIn('slow');

	$('#graphic').fadeOut('slow');

   }

   

   

   </script>

   

    

</script>

    </head>

    <body>

    <div id="popupContact"> 

<form name="form1" >

  <p>

    <label for="date">date</label>

    <input name="date" type="text" id="date">

    <label for="event"><br>

      event</label>

    <input type="text" name="event" id="events">

  </p>

  <p>Do you want to make this item a milestone?<br/></p>

  <select id="mil">

  <option value="yes">Yes</option>

  <option value="no" selected="selected">No</option>

  </select>

  <p>

     <input name="button" type="button" id="button" onclick="send()"       value="Confirm" />

  </p>

</form>



  <div id="graphic"> Added Successfully</div> 

	<div id="close" onClick="disablePopup()"><?php echo "$pic9";?></div>

       </div>

      

        <div id="backgroundPopup"></div> 

    



    

    </body>

</html>

<style type="text/css">

#graphic{background-color:#CCFF00;

font:Verdana, Geneva, sans-serif;

display:none;

position:relative;

bottom:16px;}

#close

{position:relative;

bottom:410px;

left:403px;

border:0.3px solid;

border-radius:25px;}

</style>