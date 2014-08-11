<?php include 'menu/menu.php'; ?>
<div class="conteudo">

  <?php
include 'includes/conectar.php';

if($user_unidade == ""){
	$sql_cursos = mysql_query("SELECT c.*, u.cidade_uf as nome_unidade FROM cursosead c
	INNER JOIN unidades u
	ON u.sigla = c.unidade WHERE c.conta NOT LIKE '' OR c.filial NOT LIKE ''
	ORDER BY  c.filial, c.tipo, c.curso, c.modulo");
} else {
	$sql_cursos = mysql_query("SELECT c.*, u.cidade_uf as nome_unidade FROM cursosead c
	INNER JOIN unidades u
	ON u.sigla = c.unidade WHERE c.nome_unidade LIKE '%$user_unidade%' AND (c.conta NOT LIKE '' OR c.filial NOT LIKE '')
	ORDER BY c.filial, c.tipo, c.curso, c.modulo");
	
}

?>
<table class="full_table_list" align="center" width="100%" border="1">
<tr>
	<td align="center"><b>--</b></td>
    <td align="center"><b>Filial</b></td>
    <td align="center"><b>Curso</b></td>
    <td align="center"><b>M&oacute;dulo</b></td>
    <td align="center"><b>Complemento</b></td>
    <td align="center"><b>Valor Integral</b></td>
    <td align="center"><b>Parcelas</b></td>
    <td align="center"><b>Vencimento</b></td>
    <td align="center"><b>Conta Padr&atilde;o</b></td>
</tr>
<?php
if(mysql_num_rows($sql_cursos)>=1){
	while($dados_cursos = mysql_fetch_array($sql_cursos)){
		$curso_id = $dados_cursos["codigo"];
		$curso_filial = $dados_cursos["filial"];
		$curso_nivel = $dados_cursos["tipo"];
		$curso_nome = $dados_cursos["curso"];
		$curso_modulo = $dados_cursos["modulo"];
		$curso_complemento = $dados_cursos["complemento"];
		$curso_valor = format_valor($dados_cursos["valor"]);
		$curso_min_parcela = $dados_cursos["min_parcela"];
		$curso_max_parcela = $dados_cursos["max_parcela"];
		$curso_vencimento = format_data($dados_cursos["vencimento"]);
		$curso_conta = $dados_cursos["conta"];
		
		if($curso_filial !=""){
			//PEGA A FILIAL
			$sql_filial = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$curso_filial'");
			$dados_filial = mysql_fetch_array($sql_filial);
			$nome_filial = $dados_filial["nome_filial"];
		
		} else {
			$nome_filial = "--";
		}
		
		if($curso_conta !=""){
			//PEGA A FILIAL
			$sql_conta = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$curso_conta'");
			$dados_conta = mysql_fetch_array($sql_conta);
			$nome_conta = $dados_conta["conta"];
		
		} else {
			$nome_conta = "--";
		}
			
		
		echo "
		<tr>
	<td align=\"center\"><a href=\"javascript:abrir('editar_curso_unidade.php?id=$curso_id')\">[Editar]</a></td>
    <td align=\"center\">$nome_filial</td>
	<td align=\"center\">$curso_nivel: $curso_nome</td>
    <td align=\"center\">$curso_modulo</td>
    <td align=\"center\">$curso_complemento</td>
    <td align=\"center\">$curso_valor</td>
    <td align=\"center\">$curso_min_parcela - $curso_max_parcela</td>
    <td align=\"center\">$curso_vencimento</td>
    <td align=\"center\">$nome_conta</td>
</tr>
		
		";
		
	}
	
}

?>

</table>
</div>
  <?php include 'menu/footer.php' ?>

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir? '))
{
location.href="excluir.php?id="+id;
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
     
      var width = 1000;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>


