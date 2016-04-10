<?php include 'frm_header.inc.php'; ?>
<h1>Member Login</h1>
<form method="post" action="frm_transact_user.php">
 <table>
  <tr>
   <td><label for="email">Email Address:</label></td>
   <td><input type="text" id="email" name="email" maxlength="100"/></td>
  </tr><tr>
   <td><label for="passwd">Password:</label></td>
   <td><input type="password" id="passwd" name="passwd" maxlength="20"/></td>
  </tr><tr>
   <td> </td>
   <td><input type="submit" class="submit" name="action" value="Login"/></td>
  </tr>
 </table>
</form>
<p>Not a member yet? <a href="frm_useraccount.php">Create a new account!</a></p>
<p><a href="frm_forgotpass.php">Forgot your password?</a></p>
<?php include 'frm_footer.inc.php'; ?>