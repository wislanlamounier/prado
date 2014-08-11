<?php include('menu/tabela.php');?>

<?php
include('includes/conectar.php');
$id = $_GET["codigo"];

$re    = mysql_query("select count(*) as total from geral WHERE codigo = $id" );	
$total = 1;

if($total == 1) {
	$re    = mysql_query("select * from geral WHERE codigo LIKE $id");
	$dados = mysql_fetch_array($re);	
	$pesq = mysql_query("select distinct codigo, turno, curso, nivel, modulo, grupo, unidade, polo from geral WHERE codigo = $id" );
	$ocorrencias = mysql_query("select * from ocorrencias WHERE matricula = $id" );
	
	$sql_perfil    = mysql_query("select * from acessos_completos WHERE usuario = $id");
	$dados_perfil = mysql_fetch_array($sql_perfil);	
	$perfil_senha = substr($dados_perfil["senha"],0,3)."***";	

}
$nome = strtoupper($dados["nome"]);
?>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
     <script type="text/javascript">
     $(document).ready(function() {
   
   $("#button").click(function() {
      var theURL = $("#select").val();
window.location = theURL;
});
       
});
     </script>
<div class="conteudo_ficha">
<div class="filtro" align="center">
  <p><a target="_blank" href="alterar_dados.php?id=<?php echo $id; ?>">EDITAR</a> |  <a target="_self" href="javascript:window.print()">IMPRIMIR</a> | <a href="javascript:abrir('declaracao.php?codigo=<?php echo $id;?>');">[DECLARA&Ccedil;&Otilde;ES]</a> | <a target="_self" href="javascript:window.close()">FECHAR</a><br /> 
    <select name="select" id="select">
        <option selected="selected" value="ficha.php?codigo=<?php echo $id; ?>">Ficha de Matr&iacute;cula</option>
        <option value="aluno_financeira.php?id=<?php echo $id; ?>">Resumo Financeiro</option>
        <option value="ficha_dados.php?id=<?php echo $id; ?>">Dados do Aluno</option>
      </select>
      <input type="button" name="button" id="button" value="Ver" />
</div>



<table width="98%" class="full_table_list" border="1" style="font-size:12px" >
      <tr>
        <td width="15%" align="center"><img src="images/logo-color.png" /></td>
        <td colspan="3" align="center" ><B><font size="+1">FICHA DE MATR&Iacute;CULA - <?php echo $id; ?></font></B><div class="filtro"><b>Senha:</b> <a href="javascript:abrir('resetar_senha.php?id=<?php echo $id;?>');"><?php echo $pefil_senha;?> [GERAR NOVA SENHA]</a></div></td>
      </tr>
      <tr>
      <td colspan="4" bgcolor="#C0C0C0" align="center"><b>DADOS DO ALUNO</b></td>
      </tr>
      <tr>
        <td colspan="3">Matr&iacutecula: <b><?php echo $dados["codigo"];?></b> <br />
        Aluno(a): <b><?php echo ($dados["nome"]);?></b><br />
		E-mail: <b><?php echo strtolower(($dados["email"]));?></b><br />
        Telefone(s): <b><?php echo ($dados["telefone"])." / ".($dados["celular"]);?></b><br />
        Endere&ccedil;o: <b><?php echo ($dados["endereco"]);?></b><br />
        Bairro: <b><?php echo ($dados["bairro"]);?></b><br />
        Cidade: <b><?php echo ($dados["cidade"]);?></b><br />
        CEP: <b><?php echo ($dados["cep"]);?></b><br />
        Data da Matr&iacutecula: <b><?php echo substr($dados["Dtpaga"],8,2)."/".substr($dados["Dtpaga"],5,2)."/".substr($dados["Dtpaga"],0,4);?></b></td>
        <td width="38%" align="right"><a href="javascript:abrir('foto_academica.php?id=<?php echo $id;?>');"><img src="<?php echo $dados_perfil["foto_academica"];?>" /></a></td>
      </tr>
      <tr>
      <td colspan="4" bgcolor="#C0C0C0" align="center"><b>DADOS RESPONS&Aacute;VEL FINANCEIRO</b></td>
      </tr>
      <tr>
      <td colspan="4">
		Nome: <b><?php echo strtoupper(($dados["nome_fin"]));?></b><br />
        CPF: <b><?php echo strtolower(($dados["cpf_fin"]));?></b><br />
        Bairro: <b><?php echo ($dados["bairro_fin"]);?></b><br />
        Cidade: <b><?php echo ($dados["cidade_fin"]);?></b><br />
        Telefone: <b><?php echo ($dados["tel_fin"]);?></b><br />
        </td>
    </tr>  
      
      
      <tr>
        <td colspan="4" align="center"><B>CURSOS CONTRATADOS</B><div class="filtro"><a href="javascript:abrir('listar_curso.php?id=<?php echo $id; ?>')">[ALTERAR]</a></div></td>
      </tr>
      <tr>
        <td colspan="4"><table border="1" width="100%"><?php
        while ($dados2 = mysql_fetch_array($pesq)) {
        // enquanto houverem resultados...
		$curso          = ($dados2["curso"]);
		$nivel          = ($dados2["nivel"]);
		$modulo          = ($dados2["modulo"]);
		$grupo          = ($dados2["grupo"]);
		$turno          = ($dados2["turno"]);
		$unidade          = ($dados2["unidade"]);
		$polo          = ($dados2["polo"]);
        echo "
		<tr>
			<td>Turno: <b>$turno</b></td>
			<td>$nivel: <b>$curso</b></td>
			<td>Ano/M&oacute;dulo: <b>$modulo</b></td>
			<td>Grupo/Semestre: <b>$grupo</b></td>
			<td>Unidade: <b>$unidade</b></td>
			<td>Polo: <b>$polo</b></td>
		</tr>
		
		
		\n";
        // exibir a coluna nome e a coluna email
    }
		?></table></td>
      </tr>
      <tr>
        <td colspan="4" align="center"><strong>OBSERVA&Ccedil;&Otilde;ES E OCORR&Ecirc;NCIAS</strong> <div class="filtro"><a href="javascript:abrir('cad_ocorrencia.php?id=<?php echo $id; ?>')">[NOVA OCORR&Ecirc;NCIA]</a></div></td>
      </tr>
      <tr>
        <td colspan="4" valign="top"><table border="1" width="100%">
		<tr>
         <td width="1%"><b>ID.</b></td>
         <td width="10%"><b>Data Ocorr&ecirc;ncia</b></td>
         <td width="89%"><b>Ocorr&ecirc;ncia</b></td>
        </tr>
		<?php
        while ($dados3 = mysql_fetch_array($ocorrencias)) {
        // enquanto houverem resultados...
		$n_ocorrencia          = ($dados3["n_ocorrencia"]);
		$ocorrencia          = ($dados3["ocorrencia"]);
		$dataoc          = substr($dados3["data"],8,2)."/".substr($dados3["data"],5,2)."/".substr($dados3["data"],0,4);
        echo "
		<tr>
			<td><b>$n_ocorrencia</b></td>
			<td><b>$dataoc</b></td>
			<td><b>$ocorrencia</b></td>
		</tr>
		\n";
        // exibir a coluna nome e a coluna email
    	} 
		?></table></td>
      </tr>
</table>
<div class="filtro">
<table width="100%" class="full_table_list" border="1">
<tr>
<td colspan="10" align="center" bgcolor="#D5D5D5"><b>Turmas Vinculadas</b></td>
</tr>
<?php
$sql_turmas = mysql_query("SELECT * FROM ced_turma_aluno WHERE matricula = $id ORDER BY id_turma");
if(mysql_num_rows($sql_turmas) >= 1){
	echo "<tr>
	<td align=\"center\"><b>Turma</b></td>
	<td align=\"center\"><b>N&iacute;vel</b></td>
	<td align=\"center\"><b>Curso</b></td>
	<td align=\"center\"><b>M&oacute;dulo</b></td>
	<td align=\"center\"><b>Unidade</b></td>
	<td align=\"center\"><b>Polo</b></td>
	<td align=\"center\"><b>Grupo</b></td>
	<td align=\"center\"><b>[BOLETIM]</b></td>
	<td align=\"center\"><b>[ADITIVO]</b></td>
	<td align=\"center\"><b>[GARANTIA CONTRATUAL]</b></td>
	</tr>";
	while($dados_turmas = mysql_fetch_array($sql_turmas)){
		$id_turma = $dados_turmas["id_turma"];	
		$sql_turma2 = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $id_turma ORDER BY id_turma");
		$dados_turma2 = mysql_fetch_array($sql_turma2);
		$turma_nivel = strtoupper($dados_turma2["nivel"]);	
		$turma_curso = strtoupper($dados_turma2["curso"]);	
		$turma_modulo = strtoupper($dados_turma2["modulo"]);	
		$turma_unidade = strtoupper($dados_turma2["unidade"]);	
		$turma_polo = strtoupper($dados_turma2["polo"]);
		$turma_grupo = strtoupper($dados_turma2["grupo"]);	
		$turma_cod = strtoupper($dados_turma2["cod_turma"]);	
		echo "<tr>
	<td align=\"center\"><b>$turma_cod</b></td>
	<td align=\"center\"><b>$turma_nivel</b></td>
	<td align=\"center\"><b>$turma_curso</b></td>
	<td align=\"center\"><b>$modulo</b></td>
	<td align=\"center\"><b>$unidade</b></td>
	<td align=\"center\"><b>$polo</b></td>
	<td align=\"center\"><b>$grupo</b></td>
	<td align=\"center\"><b><a href=\"gerar_boletim_turma.php?id_turma=$id_turma&id_aluno=$id\" target=\"_blank\">[GERAR BOLETIM]</a></b></td>
	<td align=\"center\"><b><a href=\"gerar_aditivo.php?id_turma=$id_turma&id_aluno=$id\" target=\"_blank\">[ADITIVO DE REMATR&Iacute;CULA]</a></b></td>
	<td align=\"center\"><b><a href=\"gerar_garantia.php?id_turma=$id_turma&id_aluno=$id\" target=\"_blank\">[ADITIVO DE REMATR&Iacute;CULA]</a></b></td>
	</tr>";
	}
}


?>
</table>

</div>

<br /><br /><br /><br /><br /><br />
<div align="center">___________________________________________
<br />
Assinatura do Respons&aacute;vel</div>

<br /><br /><br /><br /><br /><br /><br /><br />
</div>
<?php include ('menu/footer.php');?>

  <script language="JavaScript">  
function FormataCpf(campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(campo.value);
				vr = vr.replace(".", "");
				vr = vr.replace("/", "");
				vr = vr.replace("-", "");
				tam = vr.length + 1;
				if (tecla != 14)
				{
					if (tam == 4)
						campo.value = vr.substr(0, 3) + '.';
					if (tam == 7)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 6) + '.';
					if (tam == 11)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(7, 3) + '-' + vr.substr(11, 2);
				}
			}   

function FormataData(campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(campo.value);
				vr = vr.replace(".", "");
				tam = vr.length + 1;
				if (tecla != 10)
				{
					if (tam == 3)
						campo.value = vr.substr(0, 2) + '/';
					if (tam == 6)
						campo.value = vr.substr(0, 2) + '/' + vr.substr(3, 6) + '/';
				}
			}   

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