<?php if(!class_exists('raintpl')){exit;}?><table id="formulario-opcoes">
	<thead>
		<tr>
			<th><span>Nome</span></th>
			<th><span>Tipo</span></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php $counter1=-1; if( isset($this->var['campos']) && is_array($this->var['campos']) && sizeof($this->var['campos']) ) foreach( $this->var['campos'] as $key1 => $value1 ){ $counter1++; ?>
			<tr>
				<td><span><?php echo $value1["txtlabel"];?></span></td>
				<td><span><?php echo $value1["txttipo"];?></span></td>
				<td><span class="deletar"><img src="/resource/icons/16/delete.png" data-id="<?php echo $value1["idinformacao"];?>" /></span></td>
			</tr>
		<?php } ?>
	</tbody>
</table>

<form method="POST">
	<label for="formulario-nome">Nome:</label>
	<input name="formulario-nome" id="formulario-nome" type="text" maxlength="16" /><br />
	
	<label for="formulario-tipo">Tipo:</label>
	<select name="formulario-tipo" id="formulario-tipo">
		<?php $counter1=-1; if( isset($this->var['opcoes']) && is_array($this->var['opcoes']) && sizeof($this->var['opcoes']) ) foreach( $this->var['opcoes'] as $key1 => $value1 ){ $counter1++; ?>
			<option value="<?php echo $value1["idtipo"];?>"><?php echo $value1["txttipo"];?></option>
		<?php } ?>
	</select><br />
	<button id="adicionar-campo">Adicionar campo</button>
</form>

<div class="block-background ghost">
	<div id="alert-campo-ja-existe" class="modal">
		Um campo com este mesmo nome já foi criado, selecione um nome diferente.<br />
		<button>Ok</button>
	</div>
</div>