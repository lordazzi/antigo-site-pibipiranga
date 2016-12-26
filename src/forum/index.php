<?php
# AUTHOR: RICARDO AZZI #
# CREATED: 08/01/13 #
require_once($_SERVER["DOCUMENT_ROOT"]."/forum/plugins/config.php");
$page = new Page();
$sql = new MySql();

$categoria = get("?");
if ($categoria == "") {
	$categoria = $sql->Query("SELECT idcategoria FROM categorias ORDER BY dtcadastro DESC LIMIT 0 , 1");
	$categoria = $categoria[0]["idcategoria"];
	$tpcs = $sql->Query("SELECT idtopico, idusuario, txtnome FROM topicos WHERE idcategoria = '$categoria' ORDER BY dtcadastro DESC");
} else {
	$tpcs = $sql->Query("SELECT idtopico, idusuario, txtnome FROM topicos WHERE idcategoria = '$categoria' ORDER BY dtcadastro DESC");
}
?>

<div>
	<ul>
		<?php
			if ($tpcs <> FALSE) {
				foreach ($tpcs as $tpc) {
					echo("<li>$tpc[txtnome]</li>");
				}
			}
		?>
	</ul>
</div>