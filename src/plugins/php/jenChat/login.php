<?php
  require_once('init.php');
  require_once("../functions.php");
  
  if($_GET['logout']){ //they are logging out
    mysql_query("DELETE FROM jenChat_Users WHERE UserID = " . $_SESSION['jenChat_UserID']);
    if(isset($_COOKIE[session_name()])){
      setcookie(session_name(), '', 1, '/');
      unset($_COOKIE[session_name()]);
    }
    unset($_SESSION['jenChat_UserID']); // To delete the old session file
    unset($_SESSION['jenChat_Prevtime']);
	header("Location: ./login.php");
    exit;
  }

  if(sizeof($_POST)){
    $expiretime = date("YmdHis", time() - 5);
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      if(preg_match('/^[_a-z0-9-]+$/i',$_POST['who'])){
        $result = mysql_query("SELECT UserID FROM jenChat_Users WHERE UserName = '".mysql_real_escape_string($_POST['who'])."' AND LastUpdate > " . $expiretime);
        if(!mysql_fetch_array($result)){
		  mysql_query("UPDATE visitas SET chatname='".mysql_real_escape_string($_POST['who'])."' WHERE ipadress='".getip()."' AND data='".date("Y-m-d")."'");
          mysql_query("DELETE FROM jenChat_Users WHERE LastUpdate <= " .$expiretime);
          mysql_query("DELETE FROM jenChat_Messages WHERE Posted <= " . $expiretime);
          mysql_query("INSERT INTO jenChat_Users(UserName,LastUpdate) VALUES ('".mysql_real_escape_string($_POST['who'])."'," . date("YmdHis",time()).")");
          $_SESSION['jenChat_UserID'] = mysql_insert_id();
          $_SESSION['jenChat_Prevtime'] = date("YmdHis",time());
          header("Location: ./chat.php");
          exit;
        }
        else
          echo "<script type='text/javascript'> alert('Existe um usuário com o mesmo nome no chat. Escolha um nome diferente!'); </script>";
      }
      else
        echo "<script type='text/javascript'> alert('Seu nome só pode conter letras sem acento e números.'); </script>";
    }
    else
      echo "<script type='text/javascript'> alert('Você precisa escrever um nome para entrar no chat.'); </script>";
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en-US" xml:lang="en-US" style="overflow: hidden;">
  <head>
	<style type="text/css">
		img {
			width: 175px;
			margin: 0 0 25px;
		}
		
		label {
			font-size: 12px;
		}
		
		input {
			border: 1px solid #000000;
			background-color: #FFFFFF;
		}
		
		input[type='text'] {
			width: 115px;
		}
		
	</style>
  </head>
  <body>
	<img src="logo.png" />
	<br /> <br />
    <form class="grid" method="post" action="./login.php">
      <label for="who">Escolha um nome para iniciar o chat:</label><br />
	  <input type="text" id="who" name="who" value="<? echo htmlspecialchars($_POST['who']) ?>" />
      <input type="submit" value="Iniciar" class="submit" />
    </form>
  </body>
</html>
