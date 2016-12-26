<?php if(!class_exists('raintpl')){exit;}?><form id="adicionar-pessoas" action="actions/" method="POST">
	<label for="nome">Nome:</label>
	<input class="field" data-as="ignore" data-notnull="true" id="nome" name="nome" type="text" maxlength="128" /><br />
	
	<label for="genero">Gênero:</label>
	<select name="genero" id="genero" data-as="ignore" data-notnull="true">
		<option value="M">Masculino</option>
		<option value="F">Feminino</option>
	</select><br />
	
	<label for="observacao">Observação:</label><br />
	<textarea class="min-text field" data-as="ignore" maxlength="64" id="observacao" name="observacao"></textarea><br />
	
	<label for="cep">CEP:</label>
	<input class="field" id="cep" data-as="cep" data-notnull="true" name="cep" type="text" /><br />
	
	<label for="logradouro">Logradouro:</label>
	<input class="field" disabled="disabled" id="logradouro" name="logradouro" type="text" /><br />
	
	<label for="bairro">Bairro:</label>
	<input class="field" disabled="disabled" id="bairro" name="bairro" type="text" /><br />
	
	<label for="cidade">Cidade:</label>
	<input class="field" disabled="disabled" id="cidade" name="cidade" type="text" /><br />
</form>