<?php if(!class_exists('raintpl')){exit;}?><label class="spacer">Campanha:</label>
<select class="field" id="campanhas" name="campanhas">
	&lt;?=$opcoes?&gt;
	<?php $counter1=-1; if( isset($this->var['campanhas']) && is_array($this->var['campanhas']) && sizeof($this->var['campanhas']) ) foreach( $this->var['campanhas'] as $key1 => $value1 ){ $counter1++; ?>
		<option value="<?php echo $value1["idcampanha"];?>"><?php echo $value1["txtnome"];?></option>
	<?php } ?>
	<option value="0">Todas campanhas</option>
</select><br />

<label class="spacer">Filtrar:</label>
<input class="field" id="searcher" name="seacher" type="text" /><br />

<hr class="black" />

<table>
	<thead>
		<tr>
			<th>Nome</th>
			<th>Observação<th>
		</tr>
	</thead>
	<tbody>
		<tr>
		</tr>
	</tbody>
</table>