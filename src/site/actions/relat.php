<?php
//ARQUIVO DE LOGOFF
session_start();
echo "<b>SESSION:</b><br />";
echo "<b>Logado: </b>".$_SESSION["S_logado"]."<br />";
echo "<b>IDmembros: </b>".$_SESSION["S_IDmembros"]."<br />";
echo "<b>UltimaEntrada: </b>".$_SESSION["S_ultimaentrada"]."<br />";
echo "<b>Login: </b>".$_SESSION["S_login"]."<br />";
echo "<b>Senha: </b>".$_SESSION["S_senha"]."<br />";
echo "<b>Nome: </b>".$_SESSION["S_nome"]."<br />";
echo "<b>Sobrenome: </b>".$_SESSION["S_sobrenome"]."<br />";
echo "<b>Apelido: </b>".$_SESSION["S_apelido"]."<br />";
echo "<b>Sexo: </b>".$_SESSION["S_sexo"]."<br />";
echo "<b>Endereço: </b>".$_SESSION["S_endereco"]."<br />";
echo "<b>CEP: </b>".$_SESSION["S_cep"]."<br />";
echo "<b>Nascimento: </b>".$_SESSION["S_nascimento"]."<br />";
echo "<b>Tipo: </b>".$_SESSION["S_tipo"]."<br />";
echo "<b>contatos: </b>".$_SESSION["S_contatos"]."<br />";
echo "<b>Poderes: </b>".$_SESSION["S_poderes"]."<br />";
echo "<br />";
echo "<b>Variavel normal:</b><br />";
echo "<b>Logado: </b>".$logado."<br />";
echo "<b>IDmembros: </b>".$IDmembros."<br />";
echo "<b>UltimaEntrada: </b>".$ultimaentrada."<br />";
echo "<b>Login: </b>".$login."<br />";
echo "<b>Senha: </b>".$senha."<br />";
echo "<b>Nome: </b>".$nome."<br />";
echo "<b>Sobrenome: </b>".$sobrenome."<br />";
echo "<b>Apelido: </b>".$apelido."<br />";
echo "<b>Sexo: </b>".$sexo."<br />";
echo "<b>Endereço: </b>".$endereco."<br />";
echo "<b>CEP: </b>".$cep."<br />";
echo "<b>Nascimento: </b>".$nascimento."<br />";
echo "<b>Tipo: </b>".$tipo."<br />";
echo "<b>contatos: </b>".$contatos."<br />";
echo "<b>Poderes: </b>".$poderes."<br />";
?>