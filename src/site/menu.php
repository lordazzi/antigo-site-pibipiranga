<div id="menu">
  <ul>
    <li><a href="index.php">Inicio</a></li>
	<?php
	  if ($_SESSION["S_IDmembros"])
	  {
	    $data = mysql_query("SELECT * FROM membros_poderes WHERE IDmembros=".$_SESSION["S_IDmembros"]);
		$poderes = mysql_num_rows($data);
	    
		$data = mysql_query("SELECT * FROM membros_novidades WHERE IDmembros_afetado=".$_SESSION["S_IDmembros"]);
		$novidades = mysql_num_rows($data);
		
	    echo "
		<li><a href='novidades.php'>".$_SESSION["S_nome"]."</a>
          <ul>
            <li><a href='cadastro.php'>Informações</a></li>
			<li><a href='novidades.php'>Novidades ($novidades)</a></li>";
			if ($poderes > 0) { echo "<li><a href='../admin/content/index.php'>Admin</a></li>"; } //Se o usuário tiver algum tipo de poder, seja qual for, ele pode entrar na area administrativa
        echo "</ul>
        </li>
		";
	  }
	?>
    <li><a href="#">Programação</a>
      <ul>
        <li><a href="calendario.php">Calendario</a></li>
        <!-- <li><a href="#">Avisos</a></li> -->
		<!-- <li><a href="#">Escalas</a></li> -->
      </ul>
    </li>
	<li><a href="#">Igreja</a>
      <ul>
        <li><a href="pastor.php">Pastor</a></li>
        <li><a href="ministerios.php">Ministérios</a></li>
        <li><a href="estatuto.php">Estatuto</a></li>
        <li><a href="contato.php">Contato</a></li>
      </ul>
    </li>
	<li><a href="#">Álbuns</a></a>
      <ul>
        <li><a href="albfotos.php">Fotos</a></li>
		<li><a href="albvideos.php">Vídeos</a></li>
      </ul>
	</li>
	<!--
	<li><a href="#">Downloads</a></a>
      <ul>
        <li><a href="">Cânticos</a></li>
		<li><a href="">Partituras</a></li>
		<li><a href="">Boletins</a></li>
      </ul>
	</li> -->
  </ul>
</div>