<?
include("../conn.php");
include("../header.php");
?>

<? if ($_GET["mapa"]) { ?>
<center>
  <iframe style="width: 100%; height: 200px; border: 2px solid #000000;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com.br/maps?f=q&amp;source=s_q&amp;hl=pt-BR&amp;geocode=&amp;q=r.+elba,+318&amp;aq=&amp;sll=-23.612559,-46.602888&amp;sspn=0.02029,0.038581&amp;ie=UTF8&amp;hq=&amp;hnear=R.+Elba,+318+-+Sacom%C3%A3,+S%C3%A3o+Paulo,+04285-000&amp;ll=-23.610082,-46.602287&amp;spn=0.027526,0.036478&amp;z=14&amp;iwloc=A&amp;output=embed"></iframe>
</center>
<a href="contato.php">
	<div class="button">VER INFORMAÇÕES</div>
</a>
<? } else { ?>
	<b>Endereço:</b> R. Elba, 318<br />CEP: 04285-000<br />
	<br />
	<h1>Contato</h1>
	<table>
	  <tr><td style="width: 110px;"><b>Pr. Valdir:</b></td>		<td> 9800.0263</td></tr>
	  <tr><td style="width: 110px;"><b>Igreja:</b></td>			<td> 2272.7254</td></tr>
	  <tr><td style="width: 110px;"><b>Email:</b></td>			<td style="font-size: 13px;"> pastorvaldir@yahoo.com.br</td></tr>
	</table>

<a href="contato.php?mapa=true">
	<div class="button">VER MAPA</div>
</a>

<? } ?>

<a href="index.php">
	<div class="button">VOLTAR</div>
</a>

<? include("../footer.php"); ?>