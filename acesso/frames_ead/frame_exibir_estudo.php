<script type="text/javascript">
      window.onload = function(){
         parent.document.getElementById("frame_central_ead").height = document.getElementById("central").scrollHeight + 35;
     }
    </script>
    
<?php 
include('../includes/conectar.php');
include('../menu/funcoes.php');

$turma_disc = $_GET["turma_disc"];
$cod_disc = $_GET["coddisc"];
$anograde = $_GET["anograde"];
$id_estudo = $_GET["id_estudo"];
$cod_ativ = $_GET["cod_ativ"];


if(isset($_GET["edicao"])){
	$_SESSION["edicao"] = $_GET["edicao"];
	$edicao = $_GET["edicao"];
} else {
	$_SESSION["edicao"] = 0;
	$edicao = 0;
}
$sql_atividade = mysql_query("SELECT * FROM ea_ativ WHERE cod_disc LIKE '$cod_disc' AND ano_grade LIKE '$anograde' AND cod_ativ = '$cod_ativ' ORDER BY ordem_ativ");
$dados_atividade = mysql_fetch_array($sql_atividade);
$conteudo_atividade = $dados_atividade["conteudo"];
$tipo_atividade = $dados_atividade["tipo"];

$sql_tipo_atividade = mysql_query("SELECT * FROM ea_tipo_ativ WHERE  cod_tipo = '$tipo_atividade'");
$dados_tipo_atividade = mysql_fetch_array($sql_tipo_atividade);

$nome_atividade = $dados_tipo_atividade["tipo"];


//PEGA NOME DO TOPICO
$sql_estudo = mysql_query("SELECT * FROM ea_estudo_dirigido WHERE id_estudo = $id_estudo");
$dados_estudo = mysql_fetch_array($sql_estudo);
$estudo_titulo = $dados_estudo["titulo"];
$estudo_inicio = $dados_estudo["data_inicio"];
$estudo_fim = $dados_estudo["data_fim"];
$estudo_descricao = $dados_estudo["descricao"];


?>
<div id="central" style="margin-bottom:100px;">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td colspan="3" bgcolor="#6C6C6C" align="left">
<font color="#FFFFFF" size="+1">
<?php
echo ($nome_atividade." - ".$estudo_titulo);
?>
</font> 
<font size="-1" color="#FFFFFF">(<?php echo format_data($estudo_inicio)." à ".format_data($estudo_fim);?>)</font>

</td>
</tr>
<tr>
<td colspan="3" bgcolor="#D5D5D5" align="left">
<?php echo $estudo_descricao;?>
</td>
</tr>

</table>

<hr>
<table width="100%" align="center" border="1" style="border:solid">
<tr>
<td align="center"><b>Nome</b></td>
<td align="center"><b>Data de Envio</b></td>
<td align="center"><b>Arquivo</b></td>
<td align="center"><b>Nota</b></td>
</tr>

<?php
$sql_envios = mysql_query("SELECT * FROM ea_estudo_envio WHERE id_estudo = $id_estudo ORDER BY data_envio ASC");
while($dados_envios = mysql_fetch_array($sql_envios)){
	$matricula = $dados_envios["matricula"];
	$data_envio = format_data_hora($dados_envios["data_envio"]);
	$arquivo = $dados_envios["arquivo"];
	//PEGA DADOS DO USUÁRIO QUE POSTOU
	$sql_dados_usuario = mysql_query("SELECT * FROM users WHERE usuario LIKE '$matricula'");
	if(mysql_num_rows($sql_dados_usuario)==0){
		$sql_dados_usuario = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$matricula'");
	} else {
		$sql_dados_usuario = $sql_dados_usuario;
	}
	$dados_usuario = mysql_fetch_array($sql_dados_usuario);
	$usuario_nome = format_curso($dados_usuario["nome"]);
	//PEGA A NOTA ATUAL DO ALUNO
		$id_atividade = "E_".$id_estudo;
		
		$sql_atividade_boletim = mysql_query("SELECT * FROM ced_turma_ativ WHERE id_atividade LIKE '$id_atividade' AND cod_turma_d = '$turma_disc'");
		$dados_atividade_boletim = mysql_fetch_array($sql_atividade_boletim);
		$ref_atividade = $dados_atividade_boletim["ref_id"];
		
		$sql_nota = mysql_query("SELECT cta.valor, cn.nota, cn.codnota FROM ced_turma_ativ cta
INNER JOIN ced_notas cn
ON cn.ref_ativ = cta.ref_id
WHERE cn.matricula LIKE '$matricula' AND turma_disc = '$turma_disc' AND cta.id_atividade LIKE '$id_atividade' ");
		if(mysql_num_rows($sql_nota)==0){
			$nota_aluno = "0,00";
		} else {
			$dados_nota = mysql_fetch_array($sql_nota);
			$nota_aluno = format_valor($dados_nota["nota"]);
			$cod_nota = $dados_nota["codnota"];
		}
	
	
	echo "
	<tr>
<td align=\"center\">$usuario_nome</td>
<td align=\"center\">$data_envio</td>
<td align=\"center\"><a href=\"javascript:abrir('trabalhos/$arquivo');\"><b>[Visualizar]</b></a></td>
<td align=\"center\"><a href=\"javascript:abrir('registrar_nota_estudo.php?id=$cod_nota&matricula=$matricula&ref_id=$ref_atividade');\"><b>$nota_aluno</b></a></td>
</tr>
	";
}

?>

<tr>
<td colspan="4" align="right">
<a href="javascript:abrir('enviar_estudo.php?id=<?php echo $id_estudo;?>&user_resposta=0');">[Enviar Trabalho]</a>
</td>
</tr>
<tr>
<td colspan="3" align="right">
</td>
</tr>
</table>
<br /><br />
</div>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 800;
      var height = 600;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>