<?
  include("../config.php");
  $dbhandle = mysql_connect(CONN_SERVER, CONN_USER, CONN_PASS);
  mysql_select_db(CONN_DB);
  
  $data = mysql_query("SELECT * FROM jenChat_Users");
  echo "online = ".mysql_num_rows($data).";";
?>