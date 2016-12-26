<?php
  require_once('init.php');

  /* make sure the person is logged in. */
  if(!isset($_SESSION['jenChat_UserID']))
    exit;
  
  /* make sure something was actually posted. */
  if(sizeof($_POST)){
    $expiretime = date("YmdHis",time() - 5);

    /* delete expired messages. */
    mysql_query("DELETE FROM jenChat_Messages 
                 WHERE Posted <= '" . $expiretime . "'"); 
    /* delete inactive participants. */
    mysql_query("DELETE FROM jenChat_Users 
                 WHERE LastUpdate <= '" . $expiretime. "'"); 
    /* post the message. */
    mysql_query("INSERT INTO jenChat_Messages (UserID,Posted,Message)
                 VALUES(
                  " . $_SESSION['jenChat_UserID'] . ",
                  '" . date("YmdHis", time()) . "',
                  '" . mysql_real_escape_string(strip_tags($_POST['message'])) . "'
                 )");
  
    header("Location: post.php");
    exit;
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US">
  <head>
    <script type="text/javascript"><!--
      if(parent.resetForm)
        parent.resetForm();
      //-->
    </script>
  </head>
</html>
