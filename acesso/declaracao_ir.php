<?php
include ('menu/tabela.php');// inclui o menu
?>
<script type='text/javascript' src='js/jquery.toastmessage-min.js'></script>

<?php
$get_matricula = $_GET["matricula"]; 
$get_ano =$_GET["ano"]; 
$get_unidade =$_GET["unidade"]; 
$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo = '$get_matricula'");
$dados_aluno = mysql_fetch_array($sql_aluno);
$aluno_nome = $dados_aluno["nome"];
$aluno_pai = $dados_aluno["pai"];
$aluno_mae = $dados_aluno["mae"];
$aluno_nascimento = $dados_aluno["nascimento"];
$aluno_responsavel = $dados_aluno["nome_fin"];

//PEGA DADOS DA FILIAL
$sql_filial = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$get_unidade'");
$dados_filial = mysql_fetch_array($sql_filial);
$filial_cidade = $dados_filial["cidade"];
?>
<div class="conteudo">
<div class="filtro"><center><a href="javascript:window.print();">[IMPRIMIR]</a></center></div>
<div class="declaracao_ir">
<br /><br /><br /><br />
<table width="100%" border="1">
<tr>
	<td width="200"><img src="images/logo-cedtec.png" width="150"/></td>
    <td><center>
<b><font size="+1"><?php echo $dados_filial["razao"];?></font></b>
</center></td>
</tr>
</table>


<table width="100%">
<tr>
	<td colspan="2"><b>Endere&ccedil;o: <?php echo $dados_filial["endereco"];?></b></td>
</tr>
<tr>
	<td><b>Bairro: <?php echo $dados_filial["bairro"];?></b></td>
    <td><b>CEP: <?php echo $dados_filial["cep"];?></b></td>
</tr>
<tr>
	<td><b>Cidade: <?php echo $dados_filial["cidade"];?></b></td>
    <td><b>Estado: <?php echo $dados_filial["uf"];?></b></td>
</tr>
<tr>
	<td colspan="2"><b>Telefone: <?php echo $dados_filial["telefones"];?></b></td>
</tr>
<tr>
	<td colspan="2"><b>CNPJ: <?php echo $dados_filial["cnpj"];?></b></td>
</tr>
</table>
<br /><br />
<center>
<b><u><font size="+2" style="font-stretch:extra-expanded;">DECLARA&Ccedil;&Atilde;O</font></u></b>
</center>
<p><br />
  <br /> 
  Declaramos para fins de declara&ccedil;&atilde;o de imposto de renda, que o aluno(a) 
  <b><?php echo format_curso($aluno_nome);?></b> nascido(a) em <b><?php echo format_data_escrita_BR($aluno_nascimento);?></b> filho(a) de 
  
  <b><?php echo format_curso($aluno_mae);?></b> e de <b><?php echo format_curso($aluno_pai);?></b>, tendo como respons&aacute;vel financeiro <b><?php echo format_curso($aluno_responsavel);?></b>, esteve matriculado no ano letivo de <b><?php echo $get_data;?></b> e tendo pago todas as mensalidades abaixo relacionadas.</p>

<br /><br /><br />
<table width="100%" class="full_table_list" border="1">
<tr>
	<td align="center"><b>Parcela</b></td>
    <td align="center"><b>Data do Pagamento</b></td>
    <td align="center"><b>Valor Pago</b></td>
    <td align="center"><b>Tipo</b></td>
</tr>
<?php
$sql_financeiro = mysql_query("SELECT * FROM geral_titulos WHERE conta_nome LIKE '%$filial_cidade%' AND codigo = '$get_matricula' AND data_pagto LIKE '%$get_ano%' AND valor_pagto <> 0 AND (tipo_titulo =2 OR tipo_titulo = 99) ORDER BY data_pagto");
$parcela = 1;
$valor_total = 0;
while($dados_financeiro = mysql_fetch_array($sql_financeiro)){
	$data_pagto = format_data($dados_financeiro["data_pagto"]);
	$valor_pagto = format_valor($dados_financeiro["valor_pagto"]);
	$valor_total += $dados_financeiro["valor_pagto"];
	echo"
	<tr>
	<td align=\"center\">$parcela</td>
    <td align=\"center\">$data_pagto</td>
    <td align=\"right\">$valor_pagto</td>
    <td align=\"center\">Mensalidade</td>
</tr>
	";
	$parcela +=1;
	
}
?>
<tr>
	<td align="right" colspan="2">Total:</td>
    <td align="right"> R$ <?php echo format_valor($valor_total);?></td>
    <td align="left"></td>

</tr>
</table>
<br />
<?php echo format_data_escrita(date("Y-m-d"));?>
<br /><br /><br /><br />
<center>______________________________________________<br />
<?php echo $dados_filial["razao"];?><br />
<?php echo $dados_filial["cnpj"];?>
</center>
</div>
</div>
<?php
include ('menu/footer.php');?>