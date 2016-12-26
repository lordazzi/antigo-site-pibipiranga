<?php
//INICIANDO A SESSÃO EM TODOS OS ARQUIVOS QUE IMPORTAM ESSE
session_start();

//IMPORTANDO O ARQUIVO DE FUNÇÕES GENÉRICAS E CONFIGURAÇÕES
include("../../plugins/php/functions.php");
include("../../plugins/php/config.php");

//CONECTANDO COM O BANCO DE DADOS
mysql_connect(CONN_SERVER, CONN_USER, CONN_PASS);
mysql_select_db(CONN_DB);

//PEGANDO O ENDEREÇO DE IP E ANOTANDO PARA SABER QUE O SITE FOI VISITADO
$ipuser = getip();
$browser = getbrowser();
$os = getos();
$data = mysql_query("SELECT * FROM visitas WHERE ipadress='".$ipuser."' AND data='".date("Y-m-d")."' AND os='".$os."'");
@$conta = mysql_num_rows($data);

if ($conta == 0 AND $so != "Googlebot" AND $browser != "Googlebot" AND $so != "AhrefsBot" AND $browser != "AhrefsBot" AND $so != "BingBot" AND $browser != "BingBot") {
	mysql_query("INSERT INTO visitas (data, hora, ipadress, browser, os, ismobile) VALUES ('".date("Y-m-d")."', '".date("H:i:s")."', '$ipuser', '$browser', '$os', 0)");
}

?>