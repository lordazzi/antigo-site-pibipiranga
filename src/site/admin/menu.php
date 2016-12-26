<div id="menu" class="admin">
  <ul>
    <li><a href="../../content/index.php">Inicio</a>
	  <ul>
		<li><a href="index.php">Instruções</a></li>
		<li><a href="../../content/index.php">Voltar</a></li>
	  </ul>
	</li>
	<?php
	  if ($_SESSION["S_poderes2"] OR $_SESSION["S_poderes4"] OR $_SESSION["S_poderes5"] OR $_SESSION["S_poderes6"])
	  {
		  echo "<li><a href='#'>ADM</a><ul>";
			if ($_SESSION["S_poderes2"]) { echo '<li><a href="adm_adm.php" title="Administra os acessos dos administradores do site">ADM de ADM</a></li>'; }
			if ($_SESSION["S_poderes4"]) { echo '<li><a href="adm_logs.php">Logs (0)</a></li>'; } 
			$data = mysql_query("SELECT * FROM membros_solicitacoes");
			if ($_SESSION["S_poderes5"]) { echo '<li><a href="adm_solicita.php">Solicitações ('.mysql_num_rows($data).')</a></li>'; }
			if ($_SESSION["S_poderes6"]) { echo '<li><a href="adm_naolog.php">Não logados (0)</a></li>'; }
		  echo "</ul></li>";
	  }
	  
	  if ($_SESSION["S_poderes7"] OR $_SESSION["S_poderes8"] OR $_SESSION["S_poderes23"])
	  {
		  echo "<li><a href='#'>Relatórios</a><ul>";
			if ($_SESSION["S_poderes7"])  { echo '<li><a href="relat_visitantes.php">Visitantes</a></li>'; }
			if ($_SESSION["S_poderes8"])  { echo '<li><a href="#">Gerais</a></li>'; }
			if ($_SESSION["S_poderes23"]) { echo '<li><a href="relat_membros_info.php">Membros</a></li>'; }
		  echo "</ul></li>";
	  }
	  
	  if ($_SESSION["S_poderes9"])
	  {
		  echo "<li><a href='#'>Enquetes</a><ul>
			  <!-- Todos são o mesmo acesso -->
			  <li><a href='enquete_config.php'>Configurações</a></li>
			  <li><a href='enquete_relatorios.php'>Relatório</a></li>
			  <li><a href='enquete_criar.php'>Criar</a></li>
			</ul></li>";
	  }
	  
	  if ($_SESSION["S_poderes10"] OR $_SESSION["S_poderes15"] OR $_SESSION["S_poderes16"])
	  {
		  echo "<li><a href='#'>Pastor</a><ul>";
			if ($_SESSION["S_poderes10"]) { echo '<li><a href="past_membros_controle.php">Membros</a></li>'; }
			if ($_SESSION["S_poderes15"]) { echo '<li><a href="past_oracao.php">Oração</a></li>'; }
			if ($_SESSION["S_poderes16"]) { echo '<li><a href="past_pastorais.php">Pastorais</a></li>'; }
		  echo "</ul></li>";
	  }
	  
	  if ($_SESSION["S_poderes11"] OR $_SESSION["S_poderes12"] OR $_SESSION["S_poderes13"] OR $_SESSION["S_poderes14"])
	  {
		  echo "<li><a href='#'>Presidente</a><ul>";
		    if ($_SESSION["S_poderes11"]) { echo '<li><a href="presida_ministerios.php">Ministérios</a></li>'; }
			if ($_SESSION["S_poderes12"]) { echo '<li><a href="presida_avisos.php">Avisos</a></li>'; }
			if ($_SESSION["S_poderes13"]) { echo '<li><a href="presida_eventos.php">Eventos</a></li>'; }
			if ($_SESSION["S_poderes14"]) { echo '<li><a href="presida_campanhas.php">Campanhas</a></li>'; }
		  echo "</ul></li>";
	  }
	  
	  if ($_SESSION["S_poderes18"] OR $_SESSION["S_poderes19"] OR $_SESSION["S_poderes14"])
	  {
		  echo "<li><a href='#'>Audiovisual</a><ul>";
			if ($_SESSION["S_poderes18"]) { echo '<li><a href="av_fotos.php">Fotos</a></li>'; }
			if ($_SESSION["S_poderes19"]) { echo '<li><a href="av_videos.php">Videos</a></li>'; }
			if ($_SESSION["S_poderes14"]) { echo '<li><a href="av_import.php" title="Aqui você pode importar imagens para usar como foto de ministérios, destaques, anuncio de evento etc.">Importar</a></li>'; }
		  echo "</ul></li>";
	  }
	  
	  if ($_SESSION["S_poderes17"] OR $_SESSION["S_poderes20"] OR $_SESSION["S_poderes21"] OR $_SESSION["S_poderes22"])
	  {
		  echo "<li><a href='#'>Arquivo</a><ul>";
			if ($_SESSION["S_poderes17"]) { echo '<li><a href="escalas.php">Escalas</a></li>'; }
			if ($_SESSION["S_poderes20"]) { echo '<li><a href="boletim.php">Boletim</a></li>'; }
			if ($_SESSION["S_poderes21"]) { echo '<li><a href="partituras.php">Partituras</a></li>'; }
			if ($_SESSION["S_poderes22"]) { echo '<li><a href="upload.php">Upload</a></li>'; }
		  echo "</ul></li>";
	  }
	?>
  </ul>
</div>
<div id="admin">