<link href="http://fonts.googleapis.com/css?family=Nunito:300" rel="stylesheet" type="text/css">
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
$id_forum = $_GET["id_forum"];
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
$sql_forum = mysql_query("SELECT * FROM ea_forum WHERE id_forum = $id_forum");
$dados_forum = mysql_fetch_array($sql_forum);
$forum_topico = $dados_forum["titulo"];
$forum_inicio = $dados_forum["data_inicio"];
$forum_fim = $dados_forum["data_fim"];
$forum_descricao = $dados_forum["descricao"];

//verifica os posts existentes para o f�rum
$sql_post_forum = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum = $id_forum AND post_resposta = 0 ORDER BY data_modif ASC");
$total_post_forum = mysql_num_rows($sql_post_forum);

$sql_forum = mysql_query("SELECT * FROM ea_forum WHERE cod_ativ = '$cod_ativ' AND turma_disc = '$turma_disc' ORDER BY data_criacao");
$total_forum = mysql_num_rows($sql_forum);
?>
<div id="central" style="margin-bottom:100px;">
<table width="100%" align="center" cellpadding="4" cellspacing="4">
<tr>
<td colspan="3" bgcolor="#6C6C6C" align="left">
<font color="#FFFFFF" size="+1">
<?php
echo ($nome_atividade." - ".$forum_topico);
?>
</font> 
<font size="-1" color="#FFFFFF">(<?php echo format_data($forum_inicio)." � ".format_data($forum_fim);?>)</font>

</td>
</tr>
<tr>
<td colspan="3" bgcolor="#D5D5D5" align="left">
<?php echo $forum_descricao;?>
</td>
</tr>

</table>

<hr>

<?php 
if($total_post_forum >=1){
	while($dados_post = mysql_fetch_array($sql_post_forum)){
		$post_matricula = $dados_post["matricula"];
		$post_data =format_data_hora($dados_post["data_modif"]);
		$post_comentario =$dados_post["comentario"];
		$post_comentario_nota = format_valor($dados_post["nota_comentario"]);
		$post_id =$dados_post["id_post"];
		
		//PEGA DADOS DO USU�RIO QUE POSTOU
		$sql_dados_usuario = mysql_query("SELECT * FROM users WHERE usuario LIKE '$post_matricula'");
		if(mysql_num_rows($sql_dados_usuario)==0){
			$sql_dados_usuario = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$post_matricula'");
		} else {
			$sql_dados_usuario = $sql_dados_usuario;
		}
		$dados_usuario = mysql_fetch_array($sql_dados_usuario);
		$usuario_nome = format_curso($dados_usuario["nome"]);
		$usuario_foto = "../".$dados_usuario["foto_perfil"];
		
		//PEGA A NOTA ATUAL DO ALUNO
		$id_atividade = "F_".$id_forum;
		
		$sql_atividade_boletim = mysql_query("SELECT * FROM ced_turma_ativ WHERE id_atividade LIKE '$id_atividade' AND cod_turma_d = '$turma_disc'");
		$dados_atividade_boletim = mysql_fetch_array($sql_atividade_boletim);
		$ref_atividade = $dados_atividade_boletim["ref_id"];
		
		$sql_nota = mysql_query("SELECT cta.valor, cn.nota, cn.codnota FROM ced_turma_ativ cta
INNER JOIN ced_notas cn
ON cn.ref_ativ = cta.ref_id
WHERE cn.matricula LIKE '$post_matricula' AND turma_disc = '$turma_disc' AND cta.id_atividade LIKE '$id_atividade' ");
		if(mysql_num_rows($sql_nota)==0){
			$nota_aluno = "0,00";
		} else {
			$dados_nota = mysql_fetch_array($sql_nota);
			$nota_aluno = format_valor($dados_nota["nota"]);
			$cod_nota = $dados_nota["codnota"];
		}

		echo "
		<table width=\"100%\" align=\"center\" border=\"0\" cellpadding=\"1\" cellspacing=\"0\" style=\"font-family: Nunito, sans-serif;\">
		<tr bgcolor=\"#bfd2cc\">
		<td width=\"45px\">
		<a href=\"javascript:abrir('../ficha.php?codigo=$post_matricula');\"><img src=\"$usuario_foto\" width=\"40px\" height=\"40px\"></a>
		</td>
		<td colspan=\"2\">
		Coment�rio de: <a href=\"javascript:abrir('../ficha.php?codigo=$post_matricula');\">$usuario_nome</a><br>
		<font size=\"-2\">$post_data <a href=\"javascript:abrir('filtrar_post_forum.php?id_forum=$id_forum&matricula=$post_matricula');\"><img src=\"../icones/icone_filtrar.png\"/></a></font>
		</td>
		</tr>
		<tr bgcolor=\"#e3faf2\">
		<td colspan=\"3\">
		<div style=\"padding:10px\">$post_comentario</div>
		</td>
		</tr>
		
		<tr bgcolor=\"#bfd2cc\">
		<td bgcolor=\"#818181\" colspan=\"2\"><a style=\"color:#FFF\" href=\"javascript:abrir('registrar_nota_forum.php?id=$cod_nota&matricula=$post_matricula&ref_id=$ref_atividade');\">Nota: $nota_aluno</a></td>
		<td align=\"right\" bgcolor=\"#818181\">
		<a style=\"color:#FFF\" href=\"javascript:abrir('responder_forum.php?id=$id_forum&user_resposta=$post_id');\">[Responder ao aluno]</a>
		</td>
		</tr>
		";
		//PEGA RESPOSTAS DOS TUTORES/ADMINISTRADORES
		$sql_post_forum_adm = mysql_query("SELECT * FROM ea_post_forum WHERE id_forum = $id_forum AND post_resposta LIKE '$post_id' ORDER BY data_modif ASC");
		if(mysql_num_rows($sql_post_forum_adm)>=1){
			while($dados_post_forum_adm = mysql_fetch_array($sql_post_forum_adm)){
				$post_matricula2 = $dados_post_forum_adm["matricula"];
				$post_data2 =format_data_hora($dados_post_forum_adm["data_modif"]);
				$post_comentario2 =$dados_post_forum_adm["comentario"];
				$post_comentario_nota2 = format_valor($dados_post_forum_adm["nota_comentario"]);
				$post_id2 =$dados_post_forum_adm["id_post"];
				
				//PEGA DADOS DO USU�RIO QUE POSTOU
				$sql_dados_usuario2 = mysql_query("SELECT * FROM users WHERE usuario LIKE '$post_matricula2'");
				if(mysql_num_rows($sql_dados_usuario2)==0){
					$sql_dados_usuario2 = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$post_matricula2'");
				} else {
					$sql_dados_usuario2 = $sql_dados_usuario2;
				}
				$dados_usuario2 = mysql_fetch_array($sql_dados_usuario2);
				$usuario_nome2 = format_curso($dados_usuario2["nome"]);
				$usuario_foto2 = "../".$dados_usuario2["foto_perfil"];
				echo "
				<tr>
				<td width=\"45px\">
				</td>
				<td width=\"45px\" bgcolor=\"#bfd2cc\">
				<a href=\"javascript:abrir('../ficha.php?id=$post_matricula2');\"><img src=\"$usuario_foto2\" width=\"40px\" height=\"40px\"></a>
				</td>
				<td colspan=\"2\" bgcolor=\"#bfd2cc\">
				Resposta de: <a href=\"javascript:abrir('../ficha.php?id=$post_matricula2');\">$usuario_nome2</a><br>
				<font size=\"-2\">$post_data2</font>
				</td>
				</tr>
				<tr>
				<td width=\"45px\">
				</td>
				<td colspan=\"2\" bgcolor=\"#e3faf2\">
				<div style=\"padding:10px\">$post_comentario2</div>
				</td>
				</tr>
				";
			}
			
		}
		echo "</table>
				<br>";
		
	}
	
}
?>

<tr>
<td colspan="3" align="right">
<a href="javascript:abrir('responder_forum.php?id=<?php echo $id_forum;?>&user_resposta=0');">[Responder F�rum]</a>
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