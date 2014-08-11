<?php include 'menu/menu.php'; ?>
<?php 

include 'includes/conectar.php';

$grupo = $_GET["grupo"];
$turma = $_GET["turma"];
$turno = trim($_GET["turno"]);
$polo_pesq = $_GET["polo"];
$id_turma = $_GET["id_turma"];

$turma_pesq = mysql_query("SELECT * FROM ced_turma WHERE cod_turma LIKE '$turma' AND turno LIKE '$turno' AND polo LIKE '$polo_pesq' AND id_turma = '$id_turma'");
$dados_turma = mysql_fetch_array($turma_pesq);
$nivel = $dados_turma["nivel"];
$curso = $dados_turma["curso"];
$modulo = $dados_turma["modulo"];
$grupo_turma = $dados_turma["grupo"];
$unidade = $dados_turma["unidade"];
$polo = $dados_turma["polo"];
$turno = trim($dados_turma["turno"]);
$max_alunos = $dados_turma["max_aluno"];

$sql = mysql_query("SELECT distinct codigo, nome, grupo, turno FROM geral WHERE grupo LIKE '$grupo' 
AND nivel LIKE '%$nivel%' AND curso LIKE '%$curso%' AND modulo LIKE '$modulo' 
AND unidade LIKE '%$unidade%' AND polo LIKE '%$polo%' AND turno LIKE '%$turno%'
AND codigo NOT IN (SELECT matricula FROM ced_turma_aluno A INNER JOIN
ced_turma B ON A.id_turma = B.id_turma WHERE A.polo LIKE '%$polo%' AND A.turno = '$turno' AND B.grupo LIKE '$grupo' AND modulo LIKE '$modulo')  ORDER BY nome");

// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);

?>
<div class="conteudo">
<form id="form2" name="form1" method="GET" action="buscar_turmas.php">
    Grupo:
    <select name="grupo" class="textBox" id="grupo">
    <option value="nenhum">Escolha o Grupo</option>
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
  <label><strong>Alunos sem turma:</strong> <?php echo $count; ?></label>
</form>
<b>TURMA:</b> <?php echo "<a href=\"javascript:abrir('detalhe_turma.php?id=$turma&turno=$turno&polo=$polo&id_turma=$id_turma')\" >[".$turma."] ".utf8_encode(strtoupper($nivel)).": ".utf8_encode(strtoupper($curso))." - (MOD. ".utf8_encode(strtoupper($modulo)).") - ".utf8_encode(strtoupper($unidade))." / ".utf8_encode(strtoupper($polo))."</a>";?>
<br>
<table width="100%" border="1" class="full_table_list" style="font-size:12px">
	<tr>
    	<td><div align="center"><strong>Enturmar</strong></div></td>
        <td><div align="center"><strong>N&ordm; de Matricula</strong></div></td>
		<td><div align="center"><strong>Nome</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
        <td><div align="center"><strong>Turno</strong></div></td>
	</tr>

<?php

// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM ALUNO DESENTURMADO PARA O PERIODO E CURSO SELECIONADO')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
	
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$codigo	   = $dados["codigo"];
		$nome          = strtoupper($dados["nome"]);
		$grupo	   = $dados["grupo"];
		$turno	   = strtoupper($dados["turno"]);
		
        echo "
	<tr>
		<td><a href=\"javascript:abrir('enturmar_aluno.php?matricula=$codigo&turma=$turma&turno=$turno&polo=$polo&id_turma=$id_turma')\" ><center>[Enturmar]</center></td>
		<td><b><center>$codigo</b></center></td>
		<td>$nome</td>
		<td><center>$grupo</center></td>
		<td><center>$turno</center></td>
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
