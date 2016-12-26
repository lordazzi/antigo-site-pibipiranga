<?
include("../conn.php");
echo "NOME;CIDADE;BAIRRO;RUA;NUMERO;COMPLEMENTO;NASCIMENTO;TIPO;\n";
$data = mysql_query("SELECT * FROM membros WHERE ultimaentrada<>'0000-00-00 00:00:00' OR bairro <>''");
while ($membros = mysql_fetch_array($data)) {
	if ($membros["tipo"] == "CG") { $tipo = "Congregado"; }
	elseif ($membros["tipo"] == "MB") { $tipo = "Membro"; }
	echo $membros["nome"]." ".$membros["sobrenome"].";".$membros["cidade"].";".$membros["bairro"].";".$membros["logradouro"].";".$membros["numero"].";".$membros["complemento"].";".bd2human($membros["nascimento"]).";".$tipo.";\n";
	$data1 = mysql_query("SELECT * FROM membros_contatos WHERE IDmembros=".$membros["IDmembros"]);
	while ($contato = mysql_fetch_array($data1)) {
		if ($contato["tipo"] == "mail") { $tipo = "EMAIL"; $op=""; }
		elseif ($contato["tipo"] == "tel") { $tipo = "TEL"; $op=""; }
		elseif ($contato["tipo"] == "cel") { $tipo = "CEL"; $op=$contato["op"]; }
		echo ";$tipo;".$contato["contato"].";$op;\n";
	}
}
?>
