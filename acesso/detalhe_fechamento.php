<?php include 'menu/tabela.php' ?>
<div class="conteudo">
<?php
include 'includes/conectar.php';


$data = $_GET["data"];
$pesqtit = $_GET["tipo"];
$pesqconta = $_GET["conta"];

?>

<table width="100%" align="center" border="1" class="full_table_list2">
		<tr>
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
        <td><div align="center"><strong>T&iacute;tulo</strong></div></td>
        <td><div align="center"><strong>Aluno</strong></div></td>
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
        <td><div align="center"><strong>Data de Pagamento</strong></div></td>
        <td><div align="center"><strong>Valor da Transa&ccedil;&atilde;o</strong></div></td>
	</tr>

<?php


$sql = mysql_query("SELECT * FROM titulos WHERE tipo = '$pesqtit' AND data_pagto = '$data' AND conta = '$pesqconta'");



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.close();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem

    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$id_cliente          = $dados["cliente_fornecedor"];
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = $dados["valor"]+$dados["juros1"]+$dados["juros2"]+$dados["juros3"]+$dados["juros4"]+$dados["acrescimo"]-$dados["desconto"];
		$valortitulofinal	= number_format($valortitulo, 2, ',', '');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = $dados["valor_pagto"];
		$valorpagt2          = number_format($valorpagt, 2, ',', '');;
		$ccusto          = $dados["c_custo"];
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
		
		$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo = $id_cliente");
		if(mysql_num_rows($sql_aluno)>=1){
			$dados_aluno = mysql_fetch_array($sql_aluno);
			$nome_aluno = $dados_aluno["nome"];
		} else {
			$nome_aluno = "CLIENTE / FORNECEDOR";	
		}
		if($pesqtit == 2 || $pesqtit == 99){
			$tipo = "<font color='blue'><b>+</b></font>";
			$cor = "<font color='black'>R$ $valorpagt2</font>";
		}
		if($pesqtit == 1){
			$tipo = "<font color='red'><b>-</b></font>";
			$cor = "<font color='red'>R$ $valorpagt2</font>";
		}
        echo "
		
	<tr>
		<td align='center'>&nbsp;<a href=\"javascript:abrir('editar2.php?id=$idtitulo')\">[Editar]</a>
		<td>&nbsp;$idtitulo</td>
		<td>&nbsp;$nome_aluno</td>
		<td>&nbsp;$venc</td>
		<td><center>R$&nbsp;$valortitulofinal</center></td>
		<td>&nbsp;$pagamento</td>
		<td><center>$tipo  &nbsp;$cor</center></td>
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

function usuario(id){
alert("o nº de usuário é: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (id){
var data;
do {
    data = prompt ("Qual a data de pagamento?");
} while (data == null || data == "");
if(confirm ("Deseja mesmo efetuar a baixa do titulo para a data:  "+data))
{
location.href="baixa_receita.php?id="+id+"&data="+data;
}
else
{

}

}
</SCRIPT>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>