<?php include 'menu/menu.php' ?>
<?php
include 'includes/conectar.php';
$atual = date("Y-m-d H:i:s");
$ipativo = $_SERVER["REMOTE_ADDR"];

$id = $_GET["id"];
$aluno = $_GET["aluno"];

 if( isset ( $_POST[ 'Atualizar' ] ) ) {
		              for( $i = 0 , $x = count( $_POST[ 'titulo' ] ) ; $i < $x ; $i++ ) {
						 mysql_query("INSERT INTO logs (usuario,data_hora,cod_acao,acao,ip_usuario)
VALUES ('$user_usuario','$atual','08','INATIVOU O TÍTULO '".$_POST[ 'titulo' ]."','$ipativo');");
			
						 mysql_query("UPDATE titulos SET status = '".$_POST[ 'checkbox' ][$i]."' WHERE id_titulo = '".$_POST[ 'titulo' ][ $i ]."'");
							
		              }
				echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('TITULOS ATUALIZADOS COM SUCESSO');
			window.location.reload();
			</SCRIPT>");
 }


$alunobusca = mysql_query("SELECT * FROM alunos WHERE codigo = $id");
$dadosaluno = mysql_fetch_array($alunobusca);
$alunonome = $dadosaluno["nome"];
?>
<div class="conteudo">
<form id="form1" name="form1" method="GET" action="buscar_receitas.php">
Nome: 
    <input type="text" name="buscar" id="buscar" />
  <input type="submit" name="Filtrar" id="Buscar" value="Buscar" />
  <br>
  <input type="radio" name="tipo_cliente" checked id="tipo_cliente" value="1"> Aluno | <input type="radio" name="tipo_cliente" id="tipo_cliente" value="2"> Cliente/Fornecedor

</form>
<form action="#"  method="post">
  <input type="submit" value="Atualizar T&iacute;tulos" name="Atualizar" /> 
<?php  
if($user_unidade == "PERTEL"){
	echo"
   | <a target=\"_blank\" href=\"cob_cad_titulo.php?tipo=2&id=$id\">[NOVO T&Iacute;TULO]</a>";
}
   ?>
<table width="100%" border="1" style="font-size:12px;">
	<tr bgcolor="#999999">
    <td><center><?php echo $id; ?></center></td>
    <td colspan="10"><a style="color:#030303" href="javascript:abrir('ficha.php?codigo=<?php echo $id;?>');"><strong><?php echo strtoupper($alunonome); ?></strong></a></td>
    <td align="center"><b><a style="color:#FFF" href="javascript:abrir('rel_declaracao_ir.php?matricula=<?php echo $id;?>')">[Declara&ccedil;&atilde;o IR]</a></b></td>
    </tr>
	<tr>
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
        <td><div align="center"><strong>Parcela</strong></div></td>
        <td><div align="center"><strong>Vencimento</strong></div></td>
        <td><div align="center"><strong>Valor do T&iacute;tulo</strong></div></td>
        <td><div align="center"><strong>Multa</strong></div></td>
        <td><div align="center"><strong>Juros (Dia)</strong></div></td>
        <td><div align="center"><strong>Honor&aacute;rio</strong></div></td>
        <td><div align="center"><strong>Valor Calculado</strong></div></td>
        <td><div align="center"><strong>Data de Pagamento</strong></div></td>
        <td><div align="center"><strong>Valor Recebido</strong></div></td>
        <td><div align="center"><strong>Conta</strong></div></td>
        <td><div align="center"><strong>--</strong></div></td>
	</tr>

<?php

if($user_unidade == "" || $user_unidade == "PERTEL"){
$sql = mysql_query("SELECT * FROM geral_titulos WHERE (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id' ORDER BY vencimento");
} else {
$sql = mysql_query("SELECT * FROM geral_titulos WHERE (conta_nome LIKE '%$user_unidade%' OR conta_nome LIKE '%livraria%' OR conta_nome LIKE '%pertel%' OR conta_nome LIKE '%EAD%') AND (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id' ORDER BY vencimento");
}
//PRIMEIRA PARTE - JUROS TOTAL
$juros1 = mysql_query("SELECT SUM( juros1 ) as juros1 FROM geral_titulos WHERE codigo LIKE '$id'");
$juros2 = mysql_query("SELECT SUM( juros2 ) as juros2 FROM geral_titulos WHERE codigo LIKE '$id'");
$juros3 = mysql_query("SELECT SUM( juros3 ) as juros3 FROM geral_titulos WHERE codigo LIKE '$id'");
$juros4 = mysql_query("SELECT SUM( juros4 ) as juros4 FROM geral_titulos WHERE codigo LIKE '$id'");
$acrescimo1 = mysql_query("SELECT SUM( acrescimo ) as acrescimo1 FROM geral_titulos WHERE codigo LIKE '$id'");
$desconto1 = mysql_query("SELECT SUM( desconto ) as desconto1 FROM geral_titulos WHERE codigo LIKE '$id'");

//SEGUNDA PARTE - JUROS A RECEBER
$juros11 = mysql_query("SELECT SUM( juros1 ) as juros11 FROM geral_titulos WHERE valor_pagto = '' AND codigo LIKE '$id'");
$juros22 = mysql_query("SELECT SUM( juros2 ) as juros22 FROM geral_titulos WHERE valor_pagto = '' AND codigo LIKE '$id'");
$juros33 = mysql_query("SELECT SUM( juros3 ) as juros33 FROM geral_titulos WHERE valor_pagto = '' AND codigo LIKE '$id'");
$juros44 = mysql_query("SELECT SUM( juros4 ) as juros44 FROM geral_titulos WHERE valor_pagto = '' AND codigo LIKE '$id'");
$acrescimo11 = mysql_query("SELECT SUM( acrescimo ) as acrescimo11 FROM geral_titulos WHERE valor_pagto = '' AND codigo LIKE '$id'");
$desconto11 = mysql_query("SELECT SUM( desconto ) as desconto11 FROM geral_titulos WHERE valor_pagto = '' AND codigo LIKE '$id'");

//SELECT SUM

$receita = mysql_query("SELECT SUM( valor ) as receita FROM geral_titulos WHERE (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id'");

$receita2 = mysql_query("SELECT SUM( valor_pagto ) as receitaatual FROM geral_titulos WHERE (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id'");

$receita3 = mysql_query("SELECT SUM( valor ) as areceber FROM geral_titulos WHERE valor_pagto = '' AND (tipo_titulo = 2 OR tipo_titulo = 99) AND codigo LIKE '$id'");



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
	
	
    while ($l = mysql_fetch_array($receita)) {
		$receitamax = $l["receita"];
	}
    while ($l = mysql_fetch_array($receita2)) {
		$receitaatual = $l["receitaatual"];
	}
    while ($l = mysql_fetch_array($receita3)) {
		$areceber = $l["areceber"]+$juros11t+$juros22t+$juros33t+$juros44t+$acrescimo11t;
	}
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idtitulo          = $dados["id_titulo"];
		$idcli			 = $dados["codigo"];
		$cliente          = strtoupper($dados["nome"]);
		$parcela          = $dados["parcela"];
		$vencimento          = $dados["vencimento"];
		$valorreal          = number_format($dados["valor"], 2, ',', '');
		$valortitulo          = $dados["valor"]+$dados["juros1"]+$dados["juros2"]+$dados["juros3"]+$dados["juros4"]+$dados["acrescimo"]-(($dados["valor"]*$dados["desconto"])/100);
		$valortitulofinal	= number_format($valortitulo, 2, ',', '.');
		$datapagt          = $dados["data_pagto"];
		$valorpagt          = number_format($dados["valor_pagto"],2,',','.');
		$status          = $dados["status"];
		$conta          = $dados["conta"];
		$nome_conta         = $dados["conta_nome"];
		$contasel = mysql_query("SELECT * FROM contas WHERE ref_conta = '$conta'");
		$dadosconta = mysql_fetch_array($contasel);
		$layout = $dadosconta["layout"];
		if(trim($datapagt) <> ""){
			$layout = 'comprovante.php';
		}
		$venc 			= substr($vencimento,8,2)."/". substr($vencimento,5,2)."/".substr($vencimento,0,4);
		$pagamento		= substr($datapagt,8,2)."/". substr($datapagt,5,2)."/".substr($datapagt,0,4);
		if($status == 1){
			$bgstatus = "#FFDAB9";
			$statuscheck = "Inativo";
		} else {
			$bgstatus = "";
			$statuscheck = "Ativo";
		}
		if($conta == "B00CB"&&$status==0&&$user_unidade!="PERTEL"){
			$bgstatus = "#FFFF00";
		}
		if($user_unidade=="PERTEL"&&$vencimento < date("Y-m-d")&&$status==0&&$datapagt==""){
			$bgstatus = "#E6E6E6";
		}
		
		//INICIA CALCULO DINÂMICO DE JUROS
		$data_atual = date("Y-m-d");
		$sql_calculo = mysql_query("SELECT t1.id_titulo, t1.vencimento, t1.valor, t1.dias_atraso , 
t1.multa, t1.juros_dia, t1.honorario,
t1.multa+t1.juros_dia+t1.honorario as acrescimos_totais,
t1.valor+t1.multa+t1.juros_dia+t1.honorario as valor_calculado

FROM (
SELECT id_titulo, vencimento,data_pagto, valor_pagto, valor, DATEDIFF(NOW(), vencimento) as dias_atraso,  status,

IF(DATEDIFF(NOW(), vencimento) >=1,0.02*valor,0) as multa,
IF(DATEDIFF(NOW(), vencimento) >=1,((DATEDIFF(NOW(), vencimento)-1)* 0.00233)*(valor),0) as juros_dia,
IF(DATEDIFF(NOW(), vencimento) >=11,0.10*(valor+(((DATEDIFF(NOW(), vencimento)-1)* 0.00233)*valor)+(0.02*valor)),0) as honorario


FROM titulos 
) as t1
WHERE (t1.data_pagto = '' OR t1.data_pagto IS NULL) AND t1.vencimento < '$data_atual' AND t1.status = 0 AND t1.id_titulo = $idtitulo");
		if(mysql_num_rows($sql_calculo)==1){
			$dados_calculo = mysql_fetch_array($sql_calculo);
			$valortitulofinal = format_valor($dados_calculo["valor_calculado"]);
			$multa = format_valor($dados_calculo["multa"]);
			$juros_dia = format_valor($dados_calculo["juros_dia"]);
			$honorario = format_valor($dados_calculo["honorario"]);
		} else {
			$multa = format_valor($dados["juros1"]);
			$juros_dia = format_valor($dados["juros2"]);
			$honorario = format_valor($dados["juros3"]);
		}
		
		
		
		
        echo "
	<tr bgcolor=\"$bgstatus\">
		<td align='center'>&nbsp;<a href=\"javascript:abrir('editar.php?id=$idtitulo')\">[Editar]</a> <a href=\"../boleto/$layout?id=$idtitulo&p=$parcela&id2=$idcli&refreshed=no\" target=\"_blank\">[Gerar Boleto]</a></td>
		<td align=\"center\">&nbsp;$parcela</td>
		<td align=\"center\">&nbsp;$venc</td>
		<td align=\"right\">R$ $valorreal</td>
		<td align=\"right\">R$ $multa</td>
		<td align=\"right\">R$ $juros_dia</td>
		<td align=\"right\">R$ $honorario</td>
		<td  align=\"right\">R$ $valortitulofinal</td>
		<td  align=\"center\"> $pagamento</td>
		<td  align=\"right\">R$&nbsp;$valorpagt</td>
		<td><center>$nome_conta</center></td>
		<td align=\"center\"><input name='titulo[]' id='titulo[]' type='hidden' value='$idtitulo' />
		
		<select name='checkbox[]' class='a' id='checkbox[]' style='width:auto; height:25px;'>
    <option value='$status'>$statuscheck</option>
  	<option value='0'>Ativo</option>
    <option value='1'>Inativo</option>
  </select>
  
  </td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

</table>
</form>
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
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
    
   