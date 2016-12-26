<?
include("../conn.php");
include("../header.php");
?>

<form method="POST" action="">
	<label for="login">LOGIN: <input name="login" type="text" /></label><br />
	<label for="senha">SENHA: <input name="senha" type="password" /></label><br />
	<input name="fazer_login" type="submit" value="FAZER LOGIN" />
</form>

<a href="index.php">
	<div class="button">VOLTAR</div>
</a>

<?
include("../footer.php");
?>