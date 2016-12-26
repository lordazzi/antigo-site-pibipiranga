<?php 
include("../conn.php");
if (!$_SESSION["S_poderes5"]) { header("../../content"); exit; }

//aceitando a solicitação
if ($_POST["aceita_solicita"]) {

	$data = mysql_query("SELECT * FROM membros_solicitacoes WHERE IDmembros=".addslashes($_GET["id"]));
	$solicita = mysql_fetch_array($data);	
	if ($_POST["nome"]) {
		mysql_query("UPDATE membros SET nome='".$solicita["nome"]."' WHERE IDmembros=".addslashes($_GET["id"]));
	}
	
	if ($_POST["sobrenome"]) {
		mysql_query("UPDATE membros SET sobrenome='".$solicita["sobrenome"]."' WHERE IDmembros=".addslashes($_GET["id"]));
	}
	
	if ($_POST["cep"]) {
		mysql_query("UPDATE membros SET cep='".$solicita["cep"]."' WHERE IDmembros=".addslashes($_GET["id"]));
	}
	
	$idpais = $solicita["pais"];
	if ($_POST["pais"]) {
		if ($solicita["pais_solicita"] != "") {
			mysql_query("INSERT INTO endereco_paises (nome) VALUES ('".$solicita["pais_solicita"]."')");
			$idpais = mysql_insert_id();
			mysql_query("UPDATE membros SET pais='$idpais' WHERE IDmembros=".addslashes($_GET["id"]));
		}
		
		else {
			mysql_query("UPDATE membros SET pais='".$solicita["pais"]."' WHERE IDmembros=".addslashes($_GET["id"]));
		}
	}
	
	if ($_POST["estado"]) {
		if ($solicita["uf_solicita"] != "") {
			mysql_query("INSERT INTO endereco_uf (IDpais, nome) VALUES ('$idpais', '".$solicita["pais_solicita"]."')");
			$iduf = mysql_insert_id();
			mysql_query("UPDATE membros SET uf='$iduf' WHERE IDmembros=".addslashes($_GET["id"]));
		}
		
		else {
			mysql_query("UPDATE membros SET uf='".$solicita["uf"]."' WHERE IDmembros=".addslashes($_GET["id"]));
		}
	}
	
	if ($_POST["cidade"]) {
		mysql_query("UPDATE membros SET cidade='".$solicita["cidade"]."' WHERE IDmembros=".addslashes($_GET["id"]));
	}
	
	if ($_POST["bairro"]) {
		mysql_query("UPDATE membros SET bairro='".$solicita["bairro"]."' WHERE IDmembros=".addslashes($_GET["id"]));
	}
	
	if ($_POST["logradouro"]) {
		mysql_query("UPDATE membros SET logradouro='".$solicita["logradouro"]."' WHERE IDmembros=".addslashes($_GET["id"]));
	}
	
	if ($_POST["numero"]) {
		mysql_query("UPDATE membros SET numero='".$solicita["numero"]."' WHERE IDmembros=".addslashes($_GET["id"]));
	}
	
	if ($_POST["complemento"]) {
		mysql_query("UPDATE membros SET complemento='".$solicita["complemento"]."' WHERE IDmembros=".addslashes($_GET["id"]));
	}
	
	if ($_POST["nascimento"]) {
		mysql_query("UPDATE membros SET nascimento='".$solicita["nascimento"]."' WHERE IDmembros=".addslashes($_GET["id"]));
	}
	
	if ($_POST["tipo"]) {
		mysql_query("UPDATE membros SET tipo='".$solicita["tipo"]."' WHERE IDmembros=".addslashes($_GET["id"]));
	}
	
	mysql_query("DELETE FROM membros_solicitacoes WHERE IDmembros=".addslashes($_GET["id"]));
	echo "
		<script type='text/javascript'>
			window.location.href = '?';
		</script>
	";
	exit();
}

include("../header.php");
include("../menu.php");

echo "<h1 style='text-align: center;'>Solicitações de alterações de informações</h1>";

$data = mysql_query("SELECT * FROM membros_solicitacoes");
echo "<div class='subcontent' style='width: 200px;'>";
	echo "
	<table style='width: 100%;'>
		<tr>
			<td><b>Solicitações</b></td>
		</tr>";
while ($solicita = mysql_fetch_array($data)) {
	echo "
		<tr>
			<td onClick=\" window.location.href = '?id=".$solicita["IDmembros"]."' \">".$solicita["nome"]." ".$solicita["sobrenome"]."</td>
		</tr>";
}
echo "</table>
</div>";

include("../footer.php");

if (!$_GET["id"]) { exit; }
$data = mysql_query("SELECT * FROM membros_solicitacoes WHERE IDmembros=".addslashes($_GET["id"]));
$solicita = mysql_fetch_array($data);

$data = mysql_query("SELECT * FROM membros WHERE IDmembros=".addslashes($_GET["id"]));
$membro = mysql_fetch_array($data);
?>

<div id="css_back_black" style="display: block;">
	<div class="solicita">
		<form method="POST" action="">
			<table>
				<tr>
					<td></td>
					<td><b>Registro atual</b></td>
					<td><b>Alterar para</b></td>
				</tr>
				
				<!-- NOME -->
				<?
					if ($membro["nome"] != $solicita["nome"]) { $checked = " checked='checked' "; }
					else { $checked = " disabled='disabled' "; }
				?>
				<tr>
					<td><input name="nome" type="checkbox" <? echo $checked; ?> /> Nome</td>
					<td><b><input type="text" disabled="disabled" value="<? echo $membro["nome"]; ?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<? echo $solicita["nome"]; ?>" /></b></td>
				</tr>
				
				<!-- SOBRENOME -->
				<?
					if ($membro["sobrenome"] != $solicita["sobrenome"]) { $checked = " checked='checked' "; }
					else { $checked = " disabled='disabled' "; }
				?>
				<tr>
					<td><input name="sobrenome" type="checkbox" <? echo $checked; ?> /> Sobrenome</td>
					<td><b><input type="text" disabled="disabled" value="<? echo $membro["sobrenome"]; ?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<? echo $solicita["sobrenome"]; ?>" /></b></td>
				</tr>
				
				<!-- CEP -->
				<?
					if ($membro["cep"] != $solicita["cep"]) { $checked = " checked='checked' "; }
					else { $checked = " disabled='disabled' "; }
				?>
				<tr>
					<td><input name="cep" type="checkbox" <? echo $checked; ?> /> CEP</td>
					<td><b><input type="text" disabled="disabled" value="<? echo $membro["cep"]; ?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<? echo $solicita["cep"]; ?>" /></b></td>
				</tr>
				
				<!-- PAÍS -->
				<?
					if ($solicita["pais_solicita"] == "") {
						if ($membro["pais"] != $solicita["pais"]) { $checked = " checked='checked' "; }
						else { $checked = " disabled='disabled' "; }
					}
					
					else {
						$TRclass = " class='active' ";
						$checked = " checked='checked' ";
					}
				?>
				<tr>
					<td><input name="pais" type="checkbox" <? echo $checked; ?> /> País</td>
					<td><b><input type="text" disabled="disabled" value="<?
					
					if ($membro["pais_solicita"] == "") {
						$data = mysql_query("SELECT * FROM endereco_paises WHERE IDpais=".$membro["pais"]);
						$pais = mysql_fetch_array($data);
						echo $pais["nome"];
					}

					else {
						echo $membro["pais_solicita"];
					}
					
					?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<?
					
					if ($solicita["pais_solicita"] == "") {
						$data = mysql_query("SELECT * FROM endereco_paises WHERE IDpais=".$solicita["pais"]);
						$pais = mysql_fetch_array($data);
						echo $pais["nome"];
					}

					else {
						echo $solicita["pais_solicita"];
					}
					
					?>" /></b></td>
				</tr>
				
				<!-- ESTADO -->
				<?
					if ($solicita["uf_solicita"] == "") {
						if ($membro["uf"] != $solicita["uf"]) { $checked = " checked='checked' "; }
						else { $checked = " disabled='disabled' "; }
					}
					
					else {
						$TRclass = " class='active' ";
						$checked = " checked='checked' ";
					}
				?>
				<tr>
					<td><input name="estado" type="checkbox" <? echo $checked; ?> /> Estado</td>
					<td><b><input type="text" disabled="disabled" value="<?
					
					if ($membro["uf_solicita"] == "") {
						$data = mysql_query("SELECT * FROM endereco_uf WHERE IDuf=".$membro["uf"]);
						$uf = mysql_fetch_array($data);
						echo $uf["nome"];
					}

					else {
						echo $membro["uf_solicita"];
					}
					
					?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<?
					
					if ($solicita["uf_solicita"] == "") {
						$data = mysql_query("SELECT * FROM endereco_uf WHERE IDuf=".$solicita["uf"]);
						$uf = mysql_fetch_array($data);
						echo $uf["nome"];
					}

					else {
						echo $solicita["uf_solicita"];
					}
					
					?>" /></b></td>
				</tr>
				
				<!-- CIDADE -->
				<?
					if ($membro["cidade"] != $solicita["cidade"]) { $checked = " checked='checked' "; }
					else { $checked = " disabled='disabled' "; }
				?>
				<tr>
					<td><input name="cidade" type="checkbox" <? echo $checked; ?> /> Cidade</td>
					<td><b><input type="text" disabled="disabled" value="<? echo $membro["cidade"]; ?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<? echo $solicita["cidade"]; ?>" /></b></td>
				</tr>
				
				<!-- BAIRRO -->
				<?
					if ($membro["bairro"] != $solicita["bairro"]) { $checked = " checked='checked' "; }
					else { $checked = " disabled='disabled' "; }
				?>
				<tr>
					<td><input name="bairro" type="checkbox" <? echo $checked; ?> /> Bairro</td>
					<td><b><input type="text" disabled="disabled" value="<? echo $membro["bairro"]; ?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<? echo $solicita["bairro"]; ?>" /></b></td>
				</tr>
				
				<!-- LOGRADOURO -->
				<?
					if ($membro["logradouro"] != $solicita["logradouro"]) { $checked = " checked='checked' "; }
					else { $checked = " disabled='disabled' "; }
				?>
				<tr>
					<td><input name="logradouro" type="checkbox" <? echo $checked; ?> /> Logradouro</td>
					<td><b><input type="text" disabled="disabled" value="<? echo $membro["logradouro"]; ?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<? echo $solicita["logradouro"]; ?>" /></b></td>
				</tr>
				
				<!-- NÚMERO -->
				<?
					if ($membro["numero"] != $solicita["numero"]) { $checked = " checked='checked' "; }
					else { $checked = " disabled='disabled' "; }
				?>
				<tr>
					<td><input name="numero" type="checkbox" <? echo $checked; ?> /> Número</td>
					<td><b><input type="text" disabled="disabled" value="<? echo $membro["numero"]; ?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<? echo $solicita["numero"]; ?>" /></b></td>
				</tr>
				
				<!-- COMPLEMENTO -->
				<?
					if ($membro["complemento"] != $solicita["complemento"]) { $checked = " checked='checked' "; }
					else { $checked = " disabled='disabled' "; }
				?>
				<tr>
					<td><input name="complemento" type="checkbox" <? echo $checked; ?> /> Complemento</td>
					<td><b><input type="text" disabled="disabled" value="<? echo $membro["complemento"]; ?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<? echo $solicita["complemento"]; ?>" /></b></td>
				</tr>
				
				<!-- NASCIMENTO -->
				<?
					if ($membro["nascimento"] != $solicita["nascimento"]) { $checked = " checked='checked' "; }
					else { $checked = " disabled='disabled' "; }
				?>
				<tr>
					<td><input name="nascimento" type="checkbox" <? echo $checked; ?> /> Nascimento</td>
					<td><b><input type="text" disabled="disabled" value="<? echo bd2human($membro["nascimento"]); ?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<? echo bd2human($solicita["nascimento"]); ?>" /></b></td>
				</tr>
				
				<!-- TIPO -->
				<?
					if ($membro["tipo"] != $solicita["tipo"]) { $checked = " checked='checked' "; }
					else { $checked = " disabled='disabled' "; }
				?>
				<tr>
					<td><input name="tipo" type="checkbox" <? echo $checked; ?> /> Tipo</td>
					<td><b><input type="text" disabled="disabled" value="<?
						if ($membro["tipo"] == "NL") {
							echo "Nulo";
						}
						
						elseif ($membro["tipo"] == "MB") {
							echo "Membro";
						}
						
						elseif ($membro["tipo"] == "CG") {
							echo "Congregado";
						}
						
						elseif ($membro["tipo"] == "HR") {
							echo "Honorário";
						}
						
						elseif ($membro["tipo"] == "CR") {
							echo "Curioso";
						}
					?>" /></b></td>
					<td><b><input type="text" disabled="disabled" value="<?
						if ($solicita["tipo"] == "NL") {
							echo "Nulo";
						}
						
						elseif ($solicita["tipo"] == "MB") {
							echo "Membro";
						}
						
						elseif ($solicita["tipo"] == "CG") {
							echo "Congregado";
						}
						
						elseif ($solicita["tipo"] == "HR") {
							echo "Honorário";
						}
						
						elseif ($solicita["tipo"] == "CR") {
							echo "Curioso";
						}
					?>" /></b></td>
				</tr>
			</table>
			<input type="button" value="Ver depois" onClick=" window.location.href = '?'; " />
			<input type="submit" name="aceita_solicita" value="Aceitar" />
		</form>
	</div>
</div>