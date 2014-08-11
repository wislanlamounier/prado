<?php include 'menu/menu.php';
$dias_atraso = 10;
$data_ini = date("Y-m-d");
$data_fim =  date("Y-m-d", time() - ($dias_atraso * 86400));


?>
<div class="conteudo">

<table width="50%" border="0" class="full_table_list3" align="center">

	<tr>
		<td><div align="center"><strong>ALUNO</strong></div></td>
		<td><div align="center"><strong>VALOR DO D&Eacute;BITO</strong></div></td>
        <td><div align="center"><strong>ENVIAR E-MAIL</strong></div></td>
	</tr>

<?php
include 'includes/conectar.php';


//SELECT

$sql = mysql_query("SELECT codigo, nome, SUM( valor ) as VALORTOTAL FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto = '' OR data_pagto is null) AND tipo = 3 AND (vencimento between '$data_fim' AND '$data_ini') AND conta_nome LIKE '%$user_unidade%'  AND status = 0  GROUP BY codigo ORDER BY nome");
$sql_max = mysql_query("SELECT SUM( valor ) as VALOR_FINAL FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto = '' OR data_pagto is null) AND tipo = 3 AND (vencimento between '$data_fim' AND '$data_ini')  AND conta_nome LIKE '%$user_unidade%'  AND status = 0 ORDER BY nome");
$total_valor = mysql_fetch_array($sql_max);
$sql_max2 = mysql_query("SELECT SUM( valor_pagto ) as VALOR_FATURADO FROM geral_titulos WHERE tipo_titulo = 2 AND (data_pagto <> '' OR data_pagto is not null) AND tipo = 3 AND (vencimento between '$data_fim' AND '$data_ini')  AND conta_nome LIKE '%$user_unidade%'  AND status = 0 ORDER BY nome");
$total_faturado = mysql_fetch_array($sql_max2);
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


    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$idcli			 = $dados["codigo"];
		$nome			 = $dados["nome"];
		$valortotal			 = number_format($dados["VALORTOTAL"], 2, ',', '.');
		$sql3 = mysql_query("SELECT * FROM alunos WHERE codigo = '$idcli'");
		$dados2 = mysql_fetch_array($sql3);
		$aluno = format_curso(strtoupper($dados2["nome"]));
        echo "
	<tr>
		<td>&nbsp;$aluno</td>
		<td align='center'>R$ &nbsp;$valortotal</td>
		<td align=\"center\">&nbsp;<a href=\"javascript:abrir('enviar_emails.php?id=$idcli');\">[ENVIAR]</a></td>
		\n";
        // exibir a coluna nome e a coluna email
    }
}

?>

<tr>
<td colspan="8">
<strong>Valor a Receber: <font color="#FF0000">R$ <?php echo number_format($total_valor["VALOR_FINAL"], 2, ',', '.');?></font></strong></td>
  
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
//-->

</script>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 950;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
    
    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
	    <script type="text/javascript">
		$(function(){
			$('#empresa').change(function(){
				if( $(this).val() ) {
					$('#unidade').hide();
					$('.carregando').show();
					$.getJSON('unidade.ajax.php?search=',{empresa: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="*">Geral</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].unidade + '">' + j[i].unidade + '</option>';
						}	
						$('#unidade').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#unidade').html('<option value="*">Geral</option>');
				}
			});
		});
		</script>
<script type="text/javascript">
		$(function(){
			$('#unidade').change(function(){
				if( $(this).val() ) {
					$('#conta').hide();
					$('.carregando').show();
					$.getJSON('contas.ajax.php?search=',{unidade: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="*">Geral</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].ref_conta + '">' + j[i].conta + '</option>';
						}	
						$('#conta').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#conta').html('<option value="*">Geral</option>');
				}
			});
		});
		</script>