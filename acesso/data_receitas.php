<?php include 'menu/menu.php' ?>
<?php 
$inicio = $_GET['dataini'];
$fim = $_GET['datafin'];
?>
<div class="conteudo">
<center><strong><font size="+1">T&iacute;tulos a Receber</font></strong></center>
<hr />
<form id="form1" name="form1" method="get" action="buscar_receitas.php">
Nome: 
    <input type="text" name="buscar" id="buscar" />
  <input type="submit" name="Filtrar" id="Buscar" value="Pesquisar" />
  <input class="botao" type="button" name="acessar" id="acessar" onclick="javascript:pesquisar()" value="PESQUISAR TITULO" />
</form>
<form id="form1" name="form1" method="get" action="data_receitas.php">
  De: 
  <input type="date" name="dataini" id="dataini" value="<?php echo $inicio;?>"/>
At&eacute;: 
<input type="date" name="datafin" id="datafin" value="<?php echo $fim;?>" />
<input type="submit" name="Filtrar" id="Filtrar" value="Pesquisar" />
</form>
<table width="100%" border="1" class="full_table_list">
	<tr>
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
		<td><div align="center"><strong>Cliente / Fornecedor</strong></div></td>
        <td><div align="center"><strong>Parcela</strong></div></td>
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';
if($user_unidade==""){
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 2 AND (vencimento BETWEEN '$inicio' AND '$fim') AND valor_pagto = 0 AND data_pagto =''");
} else {
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE tipo_titulo = 2 AND (vencimento BETWEEN '$inicio' AND '$fim') AND valor_pagto = 0 AND data_pagto ='' AND conta_nome LIKE '%$user_unidade%'");
}

// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    history.back();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
  while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = strtoupper($dados["nome"]);
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = $dados["valor"]+$dados["juros1"]+$dados["juros2"]+$dados["juros3"]+$dados["juros4"];
		$valortitulofinal	= number_format($valortitulo, 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = $dados["valor_pagto"];
		$ccusto          = $dados["c_custo"];
		$layout          = $dados["layout"];
		$conta          = $dados["conta_nome"];
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
        echo "
	<tr>
		<td align='center'>&nbsp;<a href=\"javascript:abrir('editar.php?id=$idtitulo')\">[Editar]</a> <a href=\"../boleto/$layout?id=$idtitulo&p=$parcela&id2=$idcli\" target=\"_blank\">[Gerar Multa]</a></td>
		<td>&nbsp;<a href='buscar_receitas2.php?id=$idcli&aluno=$cliente'>$cliente</a></td>
		<td>&nbsp;$parcela</td>
		<td>&nbsp;$venc</td>
		<td><center>R$&nbsp;$valortitulofinal</center></td>
		<td>&nbsp;$conta</td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>
</table>
</div>
<?php include 'menu/footer.php' ?>
<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o titulo? '))
{
location.href="apagar_receita.php?id="+id;
}
else
{
return false;
}
}
//-->

</script>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>