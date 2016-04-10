<?php
header("Location:http://www.project360.in/login.php");
exit();
/*
session_start(); // Must start session first thing

// See if they are a logged in member by checking Session data

$toplinks = "";

if (isset($_SESSION['id'])) {

	// Put stored session variables into local php variable

    $userid = $_SESSION['id'];

    $username = $_SESSION['username'];

	$toplinks = '

	

	

	<a href="member_profile.php?id=' . $userid . '">' . $username . '</a> &bull; 

	<a href="member_account.php">Account</a> &bull; 

	<a href="logout.php">Log Out</a>';

} else {

	$toplinks = '<html dir="ltr">

<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />



	<!-- Start css3menu.com HEAD section -->

	<link rel="stylesheet" href="style.css" type="text/css" /><style>._css3m{display:none}</style>

	<!-- End css3menu.com HEAD section -->

	

</head>

<body style="background-color:#EBEBEB">



<!-- Start css3menu.com BODY section -->

<ul id="css3menu1" class="topmenu">

	<li class="topmenu"><a href="#" style="height:16px;line-height:16px;"><span>Login</span></a>

	<ul>

		<li class="subfirst"><a href="login.php">Login </a></li>

		<li class="sublast"><a href="loginemp.php">LoginEmp</a></li>

	</ul></li>

	<li class="topmenu"><a href="mailform.php" style="height:16px;line-height:16px;">Feedback</a></li>

	<li class="topmenu"><a href="join_form.php" style="height:16px;line-height:16px;">Register</a></li>

</ul><p class="_css3m"><a href="http://css3menu.com/">CSS Menu Li Css3Menu.com</a></p>

<!-- End css3menu.com BODY section -->



</body>





	

	</html>' ;

	

}
*/
?>

<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>My Homepage</title>

<style type="text/css">

<!--

body {margin: 0px}

-->

<!--</style></head>



<body>

<table style="background-color: #CCC" width="100%" border="0" cellpadding="12">

  <tr>

    <td width="66%"><h1>My Website Logo</h1></td>

    <td width="34%"> echo $toplinks; </td>

  </tr>

</table>

<div style="padding:12px">

  <h2>Welcome to the home page of my website.</h2>

  <p>This is where we do a summary or showcase of  content the site has to offer.</p>

</div>

</body>

</html>-->