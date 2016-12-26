<div id="menu">
	<h3>Categorias: </h3>
	<ul class="menu">
		<?php
			$sql = new MySql();
			$categorias = $sql->Query("SELECT idcategoria, idusuario, txtnome, txtdescricao FROM categorias ORDER BY dtcadastro");
			if ($categorias <> FALSE) {
				foreach ($categorias as $categoria) {
					echo("<li><a href='#'>$categoria[txtnome]</a></li>");
				}
			}
		?>
	</ul>
</div>
<div id="content">