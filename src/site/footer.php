	  <div id="footer">
	      <div style='float: left'>
            <a href='contato.php' style='color: #FFFFFF;'>
            São Paulo, Moinho Velho - Rua Elba, 318 <br />
            Telefone: 2272.7254 / 9800.0263 </a>
          </div>
          <div style='float: right'>
            <a href="http://www.ovelhasonline.comze.com" target="_blank"><IMG src="../../plugins/img/ovelhas.png" style="width:30px; margin:0pt 2px 0pt -10px;" /></a>
          </div>
	  </div>
	</div><!-- fechando a DIV container -->
	
	<!-- O CHAT -->
	<div id="chat">
		<div id="js_change_online">PIBI CHAT (0)</div>
		<span id="subchat" style="display: none;">
		<iframe src="../../plugins/php/jenChat/chat.php" frameBorder="0"></iframe>
		</span>
	</div>
	
	<iframe style="display: none;" id="js_seeonline" src="../../plugins/php/jenChat/online.php"></iframe>
	
	<!-- jQuery do Chat -->
	<script type="text/javascript">
		$(document).ready(function(){
			$('#chat').click(function(){
					$('#subchat').slideToggle('medium');
			});
		});
		
		var online; online = 0;
		function whoisonline() {
			window.setTimeout("import_js('../../plugins/php/jenChat/online.php')", 1000);
			window.setTimeout('document.getElementById("js_change_online").innerHTML = "PIBI CHAT ('+online+')"', 500);
			window.setTimeout("whoisonline()", 500);
		}
		whoisonline();
		
	</script>
	<?
		if ($_SESSION["S_poderes5"]) {
			$data = mysql_query("SELECT * FROM membros_solicitacoes");
			if (mysql_num_rows($data)) {
				echo "<div id='alert3' onClick=\" window.location.href = '../admin/content/adm_solicita.php'; \">Há novas solicitações de alteração<br />de informações enviadas.</div>";
			}
		}
	?>
  </body>
</html>