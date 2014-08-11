<?php include 'menu/tabela.php';
?>
<div class="conteudo">
<?php
$id = $_GET["turma_disc"]; 
include 'includes/conectar.php';

$sql = mysql_query("select * from ea_questionario WHERE turma_disc = $id");

$count = mysql_num_rows($sql);
if($count == 0){
	echo "<a href=\"cad_avaliacao.php?id=$id\">[NOVO]</a>";
}
?>


<table class="full_table_list" border="1" cellspacing="3">
	<tr style="font-size:17px">
		<td><div align="center"><strong>A&ccedil;&otilde;es</strong></div></td>
	  <td><div align="center"><strong>Disciplina</strong></div></td>
        <td><div align="center"><strong>Data Inicial</strong></div></td>
        <td><div align="center"><strong>Data Final</strong></div></td>
        <td><div align="center"><strong>Questões</strong></div></td>
        <td><div align="center"><strong>Valor</strong></div></td>
        <td><div align="center"><strong>Tentativa(s)</strong></div></td>
        <td><div align="center"><strong>Senha</strong></div></td>
        <td><div align="center"><strong>Revis&atilde;o de Tentativas</strong></div></td>
        
	</tr>

<?php

// conta quantos registros encontrados com a nossa especificação
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM RESULTADO ENCONTRADO')
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem
    while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
		$id_questionario          = ($dados["id_questionario"]);
		$data_inicio          = format_data_hora($dados["data_inicio"]);
		$data_fim          = format_data_hora($dados["data_fim"]);
		$valor          = number_format($dados["valor"],2,",",".");
		$senha          = ($dados["senha"]);
		$tentativas          = ($dados["tentativas"]);
		$cod_disc          = ($dados["cod_disc"]);
		$grupo          = ($dados["grupo"]);
		$qtd_questoes = $dados["qtd_questoes"] + $dados["qtd_questoes2"] + $dados["qtd_questoes3"];
		
		
        echo "
	<tr>
		<td align='center'>&nbsp;<a href=javascript:abrir('alterar_avaliacao.php?codigo=$id_questionario')>[EDITAR]</a></td>
		<td>&nbsp;$cod_disc</td>
		<td align='center'>$data_inicio</td>
		<td align='center'>$data_fim</td>
		<td align='center'>$qtd_questoes</td>
		<td><center>$valor</center></td>
		<td align='center'>$tentativas</td>
		<td align='center'><a href=\"resetar_senha_avaliacao.php?id=$id_questionario\">$senha</a></td>
		<td align='center'><a href=\"revisao_tentativas_avaliacao.php?id=$id_questionario\">[VER]</a></td>
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

function baixa (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar2.php?id="+data,'_blank');
}
else
{
return;
}

}
</SCRIPT>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 900;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>