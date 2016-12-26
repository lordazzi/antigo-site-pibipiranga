<?php
//INICIANDO A SESSÃO EM TODOS OS ARQUIVOS QUE IMPORTAM ESSE
session_start();

//IMPORTANDO O ARQUIVO DE FUNÇÕES GENÉRICAS E CONFIGURAÇÕES
include("../../../plugins/php/functions.php");
include("../../../plugins/php/config.php");

//CONECTANDO COM O BANCO DE DADOS
mysql_connect(CONN_SERVER, CONN_USER, CONN_PASS);
mysql_select_db(CONN_DB);

//VERIFICANDO SE O USUÁRIO PODE FICAR AQUI
$data = mysql_query("SELECT * FROM membros_poderes WHERE IDmembros=".$_SESSION["S_IDmembros"]);
if (@mysql_num_rows($data) == 0) { header("location: ../../content/index.php"); exit; }
?>