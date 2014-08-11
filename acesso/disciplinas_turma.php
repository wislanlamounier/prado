<?php include 'menu/menu.php'; ?>
<?php 

include 'includes/conectar.php';
$turma = $_GET["id"];
$grade = $_GET["grade"];
$turno = $_GET["turno"];
$p_polo = $_GET["polo"];
$id_turma = $_GET["id_turma"];
$turma_pesq = mysql_query("SELECT * FROM ced_turma WHERE cod_turma LIKE '$turma' AND grupo LIKE '$grade' AND polo LIKE '%$p_polo%' AND id_turma = '$id_turma'");
$dados_turma = mysql_fetch_array($turma_pesq);
$nivel = $dados_turma["nivel"];
$curso = $dados_turma["curso"];
$modulo = $dados_turma["modulo"];
$unidade = $dados_turma["unidade"];
$polo = $dados_turma["polo"];
$turno = $dados_turma["turno"];
$grupo = $dados_turma["grupo"];
$anograde = $dados_turma["anograde"];


$sql = mysql_query("SELECT A.*, B.grupo as grupo FROM ced_turma_disc A INNER JOIN ced_turma B ON B.id_turma = A.id_turma AND B.turno = A.turno AND A.polo = B.polo
 where A.codturma LIKE '$turma' AND B.grupo LIKE '$grade' AND B.turno LIKE '%$turno%' AND B.polo = '$polo' AND A.id_turma = '$id_turma'");


// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);

?>
<div class="conteudo">
<form id="form2" name="form1" method="post" action="filtrar_turma.php">
    Grupo:
    <select name="grupo" class="textBox" id="grupo">
    <option value="">Escolha o Grupo</option>
    <?php
include("menu/config_drop.php");?>
    <?php
if($user_unidade == ""){
		$sql2 = "SELECT distinct grupo FROM ced_turma ORDER BY grupo";
	} else {
		$sql2 = "SELECT distinct grupo FROM ced_turma WHERE unidade LIKE '%$user_unidade%' ORDER BY grupo";
	}
$result = mysql_query($sql2);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . $row['grupo'] . "</option>";
}
?>
  </select>
  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
  <label><strong>Turma:</strong> <?php echo "[".$turma."] ".strtoupper($nivel).": ".strtoupper($curso)." - (MOD. ".strtoupper($modulo).") - ".strtoupper($unidade)." / ".strtoupper($polo);?> - <a target="_blank" href="exibir_ata.php?id=<?php echo $id_turma;?>">Ata de Resultados</a></label>
</form>
<table width="70%" border="1" class="full_table_list2" style="font-size:12px">
	<tr>
    	<td><div align="center"><strong>Disciplina</strong></div></td>
        <td><div align="center"><strong>Carga Hor&aacute;ria</strong></div></td>
        <td><div align="center"><strong>Professor / Tutor</strong></div></td>
        <td><div align="center"><strong>Di&aacute;rio Online</strong></div></td>
        <td><div align="center"><strong>Avalia&ccedil;&atilde;o Online</strong></div></td>
        <td><div align="center"><strong>Senha</strong></div></td>  
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
		$codigo	   = $dados["codigo"];
		$cod_disciplina	   = $dados["disciplina"];
		$ano_grade	   = $dados["ano_grade"];
		$cod_prof	   = $dados["cod_prof"];
		$disc_pesq = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '$cod_disciplina' AND anograde LIKE '$ano_grade'");
		$dados_disc = mysql_fetch_array($disc_pesq);
		$disciplina = $dados_disc["disciplina"];
		$ch = $dados_disc["ch"];
		$sql_questionario = mysql_query("select * from ea_questionario WHERE turma_disc = '$codigo' LIMIT 1");
		if(mysql_num_rows($sql_questionario)==0){
			$exib_senha = "--";	
			$link_senha = "javascript:alert('Prova ainda não agendada');";
		} else {
			$dados_questionario = mysql_fetch_array($sql_questionario);
			$exib_senha = $dados_questionario["senha"];
			$id_questionario = $dados_questionario["id_questionario"];
			$link_senha = "javascript:abrir('resetar_senha_avaliacao.php?id=$id_questionario');";
		}
		
		if($cod_prof == 0){
			$nome_prof = '[DEFINIR]';
			
		} else {
			$prof_pesq = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo LIKE '$cod_prof'");
			$dados_prof = mysql_fetch_array($prof_pesq);
			$nome_prof = $dados_prof["nome"];
		}
		

		
        echo "
	<tr>
		<td><a href=\"listar_aulas.php?id=$codigo&id_turma=$id_turma\">$disciplina</a></td>
		<td><center>$ch</center></td>
		<td><center><a href=\"javascript:abrir('definir_professor.php?id=$codigo')\">$nome_prof</center></a></td>
		<td><div align=\"center\"><a target=\"_blank\" href=\"exibir_diario.php?id=$codigo&id_turma=$id_turma\">[FREQU&Ecirc;NCIA]</a> | <a target=\"_blank\" href=\"exibir_notas.php?id=$codigo&id_turma=$id_turma\">[NOTAS]</a> | <a target=\"_blank\" href=\"exibir_conteudo.php?id=$codigo&id_turma=$id_turma\">[CONTE&Uacute;DO]</a> </div></td>
		<td><center><a href=\"javascript:abrir('abrir_avaliacao.php?turma_disc=$codigo')\">[AGENDAR]</center></a></td>
		<td><center><a href=\"$link_senha\">$exib_senha</center></a></td>\n";
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
     
      var width = 600;
      var height = 600;
     
      var left = 0;
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
