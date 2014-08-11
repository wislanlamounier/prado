<?php include 'menu/tabela.php' ?>
<?php
include 'includes/conectar.php';


$id = $_GET["id"];

$alunobusca = mysql_query("SELECT * FROM alunos WHERE codigo = $id");
$dadosaluno = mysql_fetch_array($alunobusca);
$alunonome = $dadosaluno["nome"];
?>
<div class="conteudo">
  <div class="filtro" align="center">
    <p><a target="_blank" href="alterar_dados.php?id=<?php echo $id; ?>">EDITAR</a> |  <a target="_self" href="javascript:window.print()">IMPRIMIR</a> |  <a target="_self" href="javascript:window.close()">FECHAR</a><br /> <select name="select" id="select">
        <option selected="selected" value="ficha.php?codigo=<?php echo $id; ?>">Ficha de Matr&iacute;cula</option>
        <option value="aluno_financeira.php?id=<?php echo $id; ?>">Resumo Financeiro</option>
        <option value="ficha_dados.php?id=<?php echo $id; ?>">Dados do Aluno</option>
      </select>
      <input type="button" name="button" id="button" value="Ver" />
    </p>
  </div>
  <table width="100%" border="1">
	<tr bgcolor="#999999">
    <td><center><?php echo $id; ?></center></td>
    <td colspan="6"><strong><?php echo utf8_encode(strtoupper($alunonome)); ?></strong></td>
    </tr>
	<tr>
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
        <td><div align="center"><strong>Parcela</strong></div></td>
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
        <td><div align="center"><strong>Valor Calculado</strong></div></td>
        <td><div align="center"><strong>Data de Pagamento</strong></div></td>
        <td><div align="center"><strong>Valor Recebido</strong></div></td>
	</tr>

<?php


$sql = mysql_query("SELECT * FROM geral_titulos WHERE (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id' AND status = 0 ORDER BY vencimento");
//PRIMEIRA PARTE - JUROS TOTAL
$juros1 = mysql_query("SELECT SUM( juros1 ) as juros1 FROM geral_titulos WHERE codigo LIKE '$id'");
$juros2 = mysql_query("SELECT SUM( juros2 ) as juros2 FROM geral_titulos WHERE codigo LIKE '$id'");
$juros3 = mysql_query("SELECT SUM( juros3 ) as juros3 FROM geral_titulos WHERE codigo LIKE '$id'");
$juros4 = mysql_query("SELECT SUM( juros4 ) as juros4 FROM geral_titulos WHERE codigo LIKE '$id'");
$acrescimo1 = mysql_query("SELECT SUM( acrescimo ) as acrescimo1 FROM geral_titulos WHERE codigo LIKE '$id'");
$desconto1 = mysql_query("SELECT SUM( desconto ) as desconto1 FROM geral_titulos WHERE codigo LIKE '$id'");

//SEGUNDA PARTE - JUROS A RECEBER
$juros11 = mysql_query("SELECT SUM( juros1 ) as juros11 FROM geral_titulos WHERE data_pagto = '' AND codigo LIKE '$id'");
$juros22 = mysql_query("SELECT SUM( juros2 ) as juros22 FROM geral_titulos WHERE data_pagto = '' AND codigo LIKE '$id'");
$juros33 = mysql_query("SELECT SUM( juros3 ) as juros33 FROM geral_titulos WHERE data_pagto = '' AND codigo LIKE '$id'");
$juros44 = mysql_query("SELECT SUM( juros4 ) as juros44 FROM geral_titulos WHERE data_pagto = '' AND codigo LIKE '$id'");
$acrescimo11 = mysql_query("SELECT SUM( acrescimo ) as acrescimo11 FROM geral_titulos WHERE data_pagto = '' AND codigo LIKE '$id'");
$desconto11 = mysql_query("SELECT SUM( desconto ) as desconto11 FROM geral_titulos WHERE data_pagto = '' AND codigo LIKE '$id'");

//SELECT SUM

$receita = mysql_query("SELECT SUM( valor ) as receita FROM geral_titulos WHERE (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id'");

$receita2 = mysql_query("SELECT SUM( valor_pagto ) as receitaatual FROM geral_titulos WHERE (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id'");

$receita3 = mysql_query("SELECT SUM( valor ) as areceber FROM geral_titulos WHERE data_pagto = '' AND (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id'");



// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);
// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    window.location.href='index.php';
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	while ($l = mysql_fetch_array($juros1)) {
		$juros1t = $l["juros1"];
	}
	while ($l = mysql_fetch_array($juros2)) {
		$juros2t = $l["juros2"];
	}
	while ($l = mysql_fetch_array($juros3)) {
		$juros3t = $l["juros3"];
	}
	while ($l = mysql_fetch_array($juros4)) {
		$juros4t = $l["juros4"];
	}
	while ($l = mysql_fetch_array($juros11)) {
		$juros11t = $l["juros11"];
	}
	while ($l = mysql_fetch_array($juros22)) {
		$juros22t = $l["juros22"];
	}
	while ($l = mysql_fetch_array($juros33)) {
		$juros33t = $l["juros33"];
	}
	while ($l = mysql_fetch_array($juros44)) {
		$juros44t = $l["juros44"];
	}
	while ($l = mysql_fetch_array($desconto1)) {
		$desconto1t = $l["desconto1"];
	}
	while ($l = mysql_fetch_array($acrescimo1)) {
		$acrescimo1t = $l["acrescimo1"];
	}
	while ($l = mysql_fetch_array($desconto11)) {
		$desconto11t = $l["desconto11"];
	}
	while ($l = mysql_fetch_array($acrescimo11)) {
		$acrescimo11t = $l["acrescimo11"];
	}
	
	
    while ($l = mysql_fetch_array($receita)) {
		$receitamax = $l["receita"];
	}
    while ($l = mysql_fetch_array($receita2)) {
		$receitaatual = $l["receitaatual"];
	}
    while ($l = mysql_fetch_array($receita3)) {
		$areceber = $l["areceber"];
	}
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = strtoupper($dados["nome"]);
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valortitulo          = $dados["valor"];
		$valorcalculo          = ($dados["valor"]+$dados["juros1"]+$dados["juros2"]+$dados["juros3"]+$dados["juros4"]+$dados["acrescimo"])-(($dados["valor"]*$dados["desconto"])/100);
		$valortitulofinal	= number_format($valortitulo, 2, ',', '');
		$valorcalculofinal	= number_format($valorcalculo, 2, ',', '');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = $dados["valor_pagto"];
		$layout          = $dados["layout"];
		$ccusto          = $dados["c_custo"];
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
        echo "
	<tr>
		<td align='center'>&nbsp;<a href=\"boleto/$layout?id=$idtitulo&p=$parcela&id2=$idcli&refreshed=no\" target=\"_blank\">[Gerar Boleto]</a></td>
		<td>&nbsp;$parcela</td>
		<td>&nbsp;$venc</td>
		<td><center>R$&nbsp;$valortitulofinal</center></td>
		<td><center>R$&nbsp;$valorcalculofinal</center></td>
		<td>&nbsp;$pagamento</td>
		<td><center>R$&nbsp;$valorpagt</center></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

<tr>
<td colspan="8"><strong>Valor Contratado:</strong> R$ <?php echo number_format($receitamax, 2, ',', ''); ?><br />
<strong>Valor a Receber:</strong> R$ <?php echo number_format($areceber, 2, ',', ''); ?><br />
  <strong>Valor Recebido:</strong> R$ <?php echo number_format($receitaatual, 2, ',', ''); ?></td>
  
</tr>
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
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
     <script type="text/javascript">
     $(document).ready(function() {
   
   $("#button").click(function() {
      var theURL = $("#select").val();
window.location = theURL;
});
       
});
     </script>