<?php
//conex�o com o banco de dados
define("CONN_SERVER", "servidor");
define("CONN_USER", "usuaurio");
define("CONN_PASS", "senha");
define("CONN_DB", "base");

//quantos acessos existem?
define("ACESSOS_QTD", 23);

global $ACESSOS;
$ACESSOS[1][0] = "Inadiministravel";
$ACESSOS[1][1] = "Ningu�m tira seus acessos, nem deleta suas postagens.";

$ACESSOS[2][0] = "Administrador de administradores";
$ACESSOS[2][1] = "Voc� controla os acessos dos outros administradores (desde que n�o sejam inadministraveis).";

$ACESSOS[3][0] = "Moderador";
$ACESSOS[3][1] = "Pode deletar postagens de outros usu�rios no for�m, aprova v�deos e �lbuns de fotos.";

$ACESSOS[4][0] = "Ler logs";
$ACESSOS[4][1] = "Os logs s�o reclama��es sobre o site e registros de erros gerados, variam desde erros de portugu�s, sugest�es simples ou erros no c�digo.";

$ACESSOS[5][0] = "Controle de solicita��es";
$ACESSOS[5][1] = "Algumas informa��es que o usu�rio altera s� s�o alteradas quando s�o aprovadas pelos administradores, para evitar perda de dados de membros.";

$ACESSOS[6][0] = "Controle de postagens de n�o-logados";
$ACESSOS[6][1] = "Pessoas n�o logadas podem comentar em cosias do site, mas para as postagens desse aparecer, esse moderador precisa aprovar, pode escolher tamb�m, se os n�o logados podem ou n�o postar no site.";

$ACESSOS[7][0] = "Relat�rio de visitantes do site";
$ACESSOS[7][1] = "Pode visualizar os visitantes do site, registrados e n�o registrados.";

$ACESSOS[8][0] = "Relat�rios de movimenta��es gerais no site";
$ACESSOS[8][1] = "Todo tipo de relat�rio do site.";

$ACESSOS[9][0] = "Controle de enquetes";
$ACESSOS[9][1] = "Pode criar enquetes, verificar o resultado das respostas, fechar enquetes, p�blicar resultados e alterar outros tipos de configura��es relacionados a enquetes.";

$ACESSOS[10][0] = "Controle de membros";
$ACESSOS[10][1] = "Pode acrescentar pessoas como membros, retirar e alterar informa��es.";

$ACESSOS[11][0] = "Controle de minist�rios";
$ACESSOS[11][1] = "Pode alterar a foto dos minist�rios, nomes, posi��o, deletar, criar.";

$ACESSOS[12][0] = "Cadastro de avisos";
$ACESSOS[12][1] = "Pode cadastrar avisos no mural para todos verem.";

$ACESSOS[13][0] = "Cadastro de eventos";
$ACESSOS[13][1] = "Pode cadastrar eventos no calendario e fazer upload de banners de eventos.";

$ACESSOS[14][0] = "Destaques e �nfase do M�s";
$ACESSOS[14][1] = "Pode escolher quais s�o as coisas mais importantes a serem apresentadas no jQuery de destaques.";

$ACESSOS[15][0] = "Motivos de ora��o";
$ACESSOS[15][1] = "Pode adicionar, alterar, remover pedidos de ora��o p�blico para as pessoas do site.";

$ACESSOS[16][0] = "Pastorais";
$ACESSOS[16][1] = "Como um blog, com escritas, postagens, edi��es.";

$ACESSOS[17][0] = "Cadastro de escalas";
$ACESSOS[17][1] = "Cadastro de escalas para as pessoas do site.";

$ACESSOS[18][0] = "Upload de fotos";
$ACESSOS[18][1] = "Pode criar �lbum de fotos, editar, deletar fotos e �lbuns.";

$ACESSOS[19][0] = "Importar v�deos";
$ACESSOS[19][1] = "Pode chamar v�deos, do Youtube, para serem vistos do site, a organiza��o tamb�m � feita em formato de �lbuns.";

$ACESSOS[20][0] = "Upload de boletins";
$ACESSOS[20][1] = "Pode fazer upload de boletins PDF.";

$ACESSOS[21][0] = "Upload de partituras";
$ACESSOS[21][1] = "Pode fazer upload de partituras da Igreja.";

$ACESSOS[22][0] = "Upload de arquivos";
$ACESSOS[22][1] = "Faz o upload de arquivos de outros tipos no site.";

$ACESSOS[23][0] = "Ver informa��es dos membros";
$ACESSOS[23][1] = "Existem informa��es de membros que s�o reservadas apenas para a secret�ria, com esse acesso essas informa��es se tornam visiveis, al�m de poder gerar listas de nomes para assinas, arquivos em ordem de agenda, etc.";

?>