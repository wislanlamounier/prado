<?php include 'menu/menu.php'; ?>
<?php 

include 'includes/conectar.php';



$busca = $_GET["buscar"];
$modalidade = "";
if($busca == "EAD" || $busca == "ead"){
	$modalidade = "OR modalidade = 2";
} 
if($busca == "PRESENCIAL" || $busca == "presencial"){ 
	$modalidade = "OR modalidade = 1";
}

$sql = mysql_query("SELECT * FROM inscritos WHERE noticia <> 'MANUAL' AND nome LIKE '%$busca%' OR nome_fin LIKE  '%$busca%' OR cidade LIKE  '%$busca%'  OR bairro LIKE  '%$busca%' OR curso LIKE  '%$busca%' OR unidade LIKE  '%$busca%' OR codigo LIKE '%$busca%' $modalidade  AND cpf NOT IN (select cpf from alunos) order by codigo");


// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$count = mysql_num_rows($sql);

?>
<div class="conteudo">
<center><strong><font size="+1">Lista de Interessados</font></strong></center>
<hr />
<form id="form2" name="form1" method="GET" action="buscar_mat_interessados.php">
  <b>Nome/Matr&iacute;cula:</b>
  <input type="text" name="buscar" id="buscar" />
  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
  <label><strong>Resultados encontrados:</strong> <?php echo $count; ?></label>
</form>
<table width="100%" border="1" class="full_table_list" style="font-size:12px">
	<tr>
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
        <td><div align="center"><strong>N&ordm; de Matricula</strong></div></td>
		<td><div align="center"><strong>Nome</strong></div></td>
        <td><div align="center"><strong>Unidade</strong></div></td>
        <td><div align="center"><strong>Modalidade</strong></div></td>
        <td><div align="center"><strong>Grupo</strong></div></td>
        <td><div align="center"><strong>Curso</strong></div></td>
        <td><div align="center"><strong>Telefones</strong></div></td>
        <td><div align="center"><strong>Data de Inscri&ccedil;&atilde;o</strong></div></td>
	</tr>

<?php

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
		$codigo	   = $dados["codigo"];
		$nome          = (strtoupper($dados["nome"]));
		$curso	   = ($dados["curso"]);
		$exp_unidade = explode("-",$dados["unidade"]);
		$unidade	   = ($exp_unidade[0]);
		$datacad = $dados["datacad"];
		if($dados["modalidade"] == 1){
			$mod_exib = "Presencial";
		} else {
			$mod_exib = "EAD";
		}
		
		$telefones	   = $dados["telefone"]." / ".$dados["celular"];
		$cursopesq2   = mysql_query("SELECT * FROM cursosead WHERE codigo = '$curso'");
		$dadoscur2 = mysql_fetch_array($cursopesq2);
		$curso2 = (strtoupper($dadoscur2["tipo"].": ".$dadoscur2["curso"]));
		$grupo = $dadoscur2["grupo"];
		
		
        echo "
	<tr>
		<td align='center'><a href=\"javascript:abrir('matricular.php?id=$codigo')\">[MATRICULAR]</a></td>
		<td><b><center>$codigo</b></center></td>
		<td>$nome</td>
		<td>$unidade</td>
		<td>$mod_exib</td>
		<td>$grupo</td>
		<td>$curso2</td>
		<td>$telefones</td>
		<td>$datacad</td>
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