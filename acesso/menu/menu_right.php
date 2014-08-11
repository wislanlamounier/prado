<div class="right-ead">
<table width="100%">
<tr>
<td bgcolor="#6C6C6C">
<?php
include("includes/conectar.php");
$turma_disc = $_SESSION["turma_disc"];
?>
</td>
</tr>

<?php
$sql_turma_disciplinas = mysql_query("SELECT * FROM ced_turma_disc WHERE codigo = $turma_disc LIMIT 1");
if(mysql_num_rows($sql_turma_disciplinas)==0){
} else {
$dados_turma_disciplinas = mysql_fetch_array($sql_turma_disciplinas);
$turma_cod = $dados_turma_disciplinas["id_turma"];
$sql_disciplinas2 = mysql_query("SELECT * FROM ced_turma_disc WHERE id_turma LIKE '$turma_cod'");
if(mysql_num_rows($sql_disciplinas2)==0){
	echo "";
} else {
	while($dados_disc2 = mysql_fetch_array($sql_disciplinas2)){
		$p_cod_disc = $dados_disc2["disciplina"];
		$p_anograde = $dados_disc2["ano_grade"];
		$sql_disciplina_final = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '$p_cod_disc' AND anograde LIKE '%$p_anograde%'");
		$dados_disciplina_final = mysql_fetch_array($sql_disciplina_final);
		$nome_disciplina_link = $dados_disciplina_final["disciplina"];
		echo "
		<font size=\"-1\"><a href=\"javascript:void(0);\" onclick=\"expandcollapse('$p_cod_disc')\">$nome_disciplina_link</a></font><br/>
		<ul id=\"$p_cod_disc\" class=\"texthidden\">
		<font size=\"-2\">
		<li><a href=\"javascript:acessar_disciplina('ea_disciplina.php?turma_disc=$turma_disc&anograde=$p_anograde&coddisc=$p_cod_disc','$nome_disciplina_link', 'a página inicial','1')\">Início</a></li>
		";
		$sql_menu_lateral = mysql_query("SELECT eat.tipo, eta.tipo as nome_atividade, eta.link, eat.cod_ativ
FROM ea_ativ eat
INNER JOIN ea_tipo_ativ eta
ON eat.tipo = eta.cod_tipo WHERE eat.cod_disc LIKE '$p_cod_disc' AND eat.ano_grade LIKE '$p_anograde'");
		while($dados_menu_lateral = mysql_fetch_array($sql_menu_lateral)){
			$nome_atividade = $dados_menu_lateral["nome_atividade"];
			$cod_atividade = $dados_menu_lateral["tipo"];
			$cod_atividade_turma = $dados_menu_lateral["cod_ativ"];
			$link_atividade = $dados_menu_lateral["link"];
			if($cod_atividade == 1){
				$target = "_blank";	
				$comp_link = "";
			} else {
				$target = "frame_central_ead";
				$comp_link = "frames_ead";
			}
			$sql_ativ_turma = mysql_query("SELECT * FROM ea_ativ WHERE cod_ativ = '$cod_atividade_turma'");
			$dados_ativ_turma = mysql_fetch_array($sql_ativ_turma);
			if($link_atividade=="#"){
				$link_final = $dados_ativ_turma["link"];
			} else {
				$link_final = "$comp_link/$link_atividade?turma_disc=$turma_disc&tipo_ativ=$cod_atividade&anograde=$p_anograde&cod_disc=$p_cod_disc&cod_ativ=$cod_atividade_turma";
			}
		
		
			echo "
			<li><a href=\"$link_final\" target=\"$target\">$nome_atividade</a></li>

			";
		}
		echo "</font></ul>";
	}
}
}

?>

<tr>
<td> 
<br /><br />

</td>
</tr>
<tr>
<td>
<?php //verifica modo de edição

if(isset($_SESSION["edicao"])){
	$edicao = $_SESSION["edicao"];
} else {
	$edicao = 0;
}
if($edicao ==0){
	$edicao_exib = "Ativar";
	$edicao_status = 1;
}
if($edicao ==1){
	$edicao_exib = "Desativar";
	$edicao_status = 0;
}
$pagina_atual = $_SERVER["PHP_SELF"];

echo "<a href=\"$pagina_atual?edicao=$edicao_status\">[$edicao_exib Edi&ccedil;&atilde;o]</a>";
?>
 </td>
</tr>
</table>


</div>

<script type='text/javascript'>document.write('<style>.texthidden {display:none} </style>');</script>
<script type='text/Javascript'>
function expandcollapse (postid) 
{whichpost = document.getElementById(postid);
if (whichpost.className=="shown") 
{
	whichpost.className="texthidden";
}else {
	whichpost.className="shown";
}

}</script>

<script type="text/Javascript">
function acessar_disciplina(link_final, disciplina, pagina, tipo_link)
{
	
var r = confirm("Deseja acessar "+ pagina +" disciplina "+disciplina + " ?");
if (r == true) {
	if(tipo_link == 1){
		location.href= link_final;	
	} else {
		location.href= link_final;
	}
    
} else {
    x = "Você cancelou!";
}
}
</script>