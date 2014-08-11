<?php include 'menu/menu.php'; ?>
<?php 

include 'includes/conectar.php';

$get_unidade = $_GET["unidade"];
$get_inicio = $_GET["dataini"];
$get_fim = $_GET["datafin"];


$sql = mysql_query("SELECT * FROM ced_turma WHERE unidade LIKE '%$get_unidade%' ORDER BY nivel,curso,modulo,grupo");


// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);

?>
<div class="conteudo">
<center><strong><font size="+1">Relatório: Receitas / Turma</font></strong></center>
<hr />
<form method="GET" action="gerar_receita_turma.php">
  Unidade:
    <select name="unidade" class="textBox" id="unidade">
    <option  value="<?php echo $get_unidade;?>" selected="selected"><?php echo $get_unidade;?></option>
    <?php
include("menu/config_drop.php");?>
    <?php
$sql_p = "SELECT distinct unidade FROM unidades WHERE categoria > 0 OR unidade LIKE '%ead%' ORDER BY unidade";
$result = mysql_query($sql_p);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
  </select>
  
  De
  <input name="dataini" type="date" value="<?php echo $get_inicio;?>" />
at&eacute; <input name="datafin" type="date"  value="<?php echo $get_fim;?>"/> 
<input type="submit" name="Buscar" id="Buscar" value="Pesquisar" />
</form>
<table width="100%" border="1" class="full_table_list" style="font-size:12px">
	<tr>
    	<td><div align="center"><strong>Turma</strong></div></td>
        <td><div align="center"><strong>Nível</strong></div></td>
		<td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>Módulo</strong></div></td>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Turno</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
        <td><div align="center"><strong>Receita</strong></div></td>
	</tr>

<?php

// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUMA TURMA ENCONTRADA')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo	   = $dados["cod_turma"];
		$id_turma	   = $dados["id_turma"];
		$modulo	   = $dados["modulo"];
		$grupo	   = $dados["grupo"];
		$nivel	   = $dados["nivel"];
		$curso	   = $dados["curso"];
		$unidade	   = $dados["unidade"];
		$turno	   = strtoupper($dados["turno"]);
		$sql_recebimento = mysql_query("SELECT SUM(valor_pagto) as recebimento_total FROM titulos WHERE tipo = 2 AND conta NOT LIKE '%LT%' AND (data_pagto BETWEEN '$get_inicio' AND '$get_fim') AND cliente_fornecedor IN (SELECT codigo FROM alunos WHERE codigo IN (SELECT matricula FROM ced_turma_aluno WHERE id_turma=$id_turma))");
		$dados_recebimento = mysql_fetch_array($sql_recebimento);
		$recebimento_turma = number_format($dados_recebimento["recebimento_total"],2,",",".");


		
        echo "
	<tr>
		<td><a href=\"detalhe_receita_turma.php?id_turma=$id_turma&id=$codigo&turno=$turno&grade=$grupo&inicio=$get_inicio&fim=$get_fim&unidade=$get_unidade\"><b><center>$codigo</b></center></a></td>
		<td>$nivel</td>
		<td><center>$curso</center></td>
		<td><center>$modulo</center></td>
		<td><center>$unidade</center></td>
		<td><center>$turno</center></td>
		<td><center>$grupo</center></td>
		<td align=\"right\"><b>R$ $recebimento_turma</b></td>
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

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>


</div>
</body>
</html>

    <script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
	    <script type="text/javascript">
		$(function(){
			$('#grupo').change(function(){
				if( $(this).val() ) {
					$('#turma').hide();
					$('.carregando').show();
					$.getJSON('turma.ajax.php?search=',{grupo: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value=""></option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cod_turma + '">' + '[' + j[i].cod_turma + '] ' + j[i].nivel + ': '+ j[i].curso +' - (MOD. '+ j[i].modulo +')' +' - '+ j[i].unidade +' / '+ j[i].polo +'</option>';
						}	
						$('#turma').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#turma').html('<option value="">– Selecione a Turma –</option>');
				}
			});
		});
		</script>
