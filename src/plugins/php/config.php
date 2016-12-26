<?php
//conexão com o banco de dados
define("CONN_SERVER", "servidor");
define("CONN_USER", "usuaurio");
define("CONN_PASS", "senha");
define("CONN_DB", "base");

//quantos acessos existem?
define("ACESSOS_QTD", 23);

global $ACESSOS;
$ACESSOS[1][0] = "Inadiministravel";
$ACESSOS[1][1] = "Ninguém tira seus acessos, nem deleta suas postagens.";

$ACESSOS[2][0] = "Administrador de administradores";
$ACESSOS[2][1] = "Você controla os acessos dos outros administradores (desde que não sejam inadministraveis).";

$ACESSOS[3][0] = "Moderador";
$ACESSOS[3][1] = "Pode deletar postagens de outros usuários no forúm, aprova vídeos e álbuns de fotos.";

$ACESSOS[4][0] = "Ler logs";
$ACESSOS[4][1] = "Os logs são reclamações sobre o site e registros de erros gerados, variam desde erros de português, sugestões simples ou erros no código.";

$ACESSOS[5][0] = "Controle de solicitações";
$ACESSOS[5][1] = "Algumas informações que o usuário altera só são alteradas quando são aprovadas pelos administradores, para evitar perda de dados de membros.";

$ACESSOS[6][0] = "Controle de postagens de não-logados";
$ACESSOS[6][1] = "Pessoas não logadas podem comentar em cosias do site, mas para as postagens desse aparecer, esse moderador precisa aprovar, pode escolher também, se os não logados podem ou não postar no site.";

$ACESSOS[7][0] = "Relatório de visitantes do site";
$ACESSOS[7][1] = "Pode visualizar os visitantes do site, registrados e não registrados.";

$ACESSOS[8][0] = "Relatórios de movimentações gerais no site";
$ACESSOS[8][1] = "Todo tipo de relatório do site.";

$ACESSOS[9][0] = "Controle de enquetes";
$ACESSOS[9][1] = "Pode criar enquetes, verificar o resultado das respostas, fechar enquetes, públicar resultados e alterar outros tipos de configurações relacionados a enquetes.";

$ACESSOS[10][0] = "Controle de membros";
$ACESSOS[10][1] = "Pode acrescentar pessoas como membros, retirar e alterar informações.";

$ACESSOS[11][0] = "Controle de ministérios";
$ACESSOS[11][1] = "Pode alterar a foto dos ministérios, nomes, posição, deletar, criar.";

$ACESSOS[12][0] = "Cadastro de avisos";
$ACESSOS[12][1] = "Pode cadastrar avisos no mural para todos verem.";

$ACESSOS[13][0] = "Cadastro de eventos";
$ACESSOS[13][1] = "Pode cadastrar eventos no calendario e fazer upload de banners de eventos.";

$ACESSOS[14][0] = "Destaques e Ênfase do Mês";
$ACESSOS[14][1] = "Pode escolher quais são as coisas mais importantes a serem apresentadas no jQuery de destaques.";

$ACESSOS[15][0] = "Motivos de oração";
$ACESSOS[15][1] = "Pode adicionar, alterar, remover pedidos de oração público para as pessoas do site.";

$ACESSOS[16][0] = "Pastorais";
$ACESSOS[16][1] = "Como um blog, com escritas, postagens, edições.";

$ACESSOS[17][0] = "Cadastro de escalas";
$ACESSOS[17][1] = "Cadastro de escalas para as pessoas do site.";

$ACESSOS[18][0] = "Upload de fotos";
$ACESSOS[18][1] = "Pode criar álbum de fotos, editar, deletar fotos e álbuns.";

$ACESSOS[19][0] = "Importar vídeos";
$ACESSOS[19][1] = "Pode chamar vídeos, do Youtube, para serem vistos do site, a organização também é feita em formato de álbuns.";

$ACESSOS[20][0] = "Upload de boletins";
$ACESSOS[20][1] = "Pode fazer upload de boletins PDF.";

$ACESSOS[21][0] = "Upload de partituras";
$ACESSOS[21][1] = "Pode fazer upload de partituras da Igreja.";

$ACESSOS[22][0] = "Upload de arquivos";
$ACESSOS[22][1] = "Faz o upload de arquivos de outros tipos no site.";

$ACESSOS[23][0] = "Ver informações dos membros";
$ACESSOS[23][1] = "Existem informações de membros que são reservadas apenas para a secretária, com esse acesso essas informações se tornam visiveis, além de poder gerar listas de nomes para assinas, arquivos em ordem de agenda, etc.";

?>