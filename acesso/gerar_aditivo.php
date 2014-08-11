<?php include ("menu/tabela.php");
$matricula = $_GET["id_aluno"];
$get_turma = $_GET["id_turma"];
?>
<div class="filtro"><center><a href="javascript:window.print();">[IMPRIMIR]</a></center></div>
<?php
$sql_aluno_turma = mysql_query("SELECT distinct cta.matricula FROM ced_turma_aluno cta INNER JOIN alunos a
ON cta.matricula = a.codigo
 WHERE cta.id_turma = $get_turma AND cta.matricula = '$matricula' ORDER BY a.nome");
while($dados_aluno_turma = mysql_fetch_array($sql_aluno_turma)){
	$matricula = $dados_aluno_turma["matricula"];
	//dados do aluno
	$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo = $matricula");
	$dados_aluno = mysql_fetch_array($sql_aluno);
	$nome_fin = strtoupper($dados_aluno["nome_fin"]);
	$nome_fiador = strtoupper($dados_aluno["nome_fia"]);
	$cpf_fiador = $dados_aluno["cpf_fia"];
	if(trim($nome_fiador) == ""){
		$nome_fiador = "________________________________________";	
		$cpf_fiador = "____________________";
	}
	$nome = strtoupper($dados_aluno["nome"]);
	
	//dados da empresa
	$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $get_turma");
	$dados_turma = mysql_fetch_array($sql_turma);
	$unidade = trim($dados_turma["unidade"]);
	$sql_empresa = mysql_query("SELECT * FROM unidades WHERE unidade LIKE '%$unidade%' LIMIT 1");
	$dados_empresa = mysql_fetch_array($sql_empresa);
	$sigla = substr(trim($dados_empresa["aditivo"]),0,2);
	$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$sigla'");
	$dados_cc2 = mysql_fetch_array($sql_cc2);
	$razao = $dados_cc2["razao"];
	$cnpj = $dados_cc2["cnpj"];
	$endereco = $dados_cc2["endereco"]." - ".$dados_cc2["bairro"].", ".$dados_cc2["cidade"]." - ".$dados_cc2["uf"].", CEP: ".$dados_cc2["cep"];
echo "
<div class=\"topo\">
<div align=\"center\" style=\" border: 2px solid; margin-bottom:20px; background-color:#C0C0C0; font-family:Arial, Helvetica, sans-serif; font-weight:bold; font-size:14px;\"> ADITIVO AO CONTRATO DE PRESTA&Ccedil;&Atilde;O DE SERVI&Ccedil;OS EDUCACIONAIS </div>
<div align=\"justify\" style=\" border: 2px solid; left:auto; float:right; position:relative;  margin-bottom:20px; background-color:#C0C0C0; width:40%; font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;\">
  <p>Pelo  presente ADITIVO ao <u>Contrato de Presta&ccedil;&atilde;o de Servi&ccedil;os Educacionais  Presencial e &agrave; Dist&acirc;ncia</u>, j&aacute; firmados entre as partes e na melhor forma de  direito, de um lado o:</p>
</div>
</div>
<div class=\"corpo\" style=\"margin-top:160px; text-align:justify; font-family:Arial, Helvetica, sans-serif; font-size:14px;\">
  <p><strong>$razao</strong>, devidamente  inscrito no CNPJ sob o n&ordm;. <strong>$cnpj</strong>, com endere&ccedil;o na $endereco, neste  ato, representado pelo seu Diretor Geral Corporativo e procurador, pelo Diretor  por ele nomeado, ou procurador devidamente constitu&iacute;do, doravante denominada <strong>CONTRATADA, </strong>e<strong> </strong>de outro lado, <u>$nome_fin</u> como<strong> CONTRATANTE </strong>assim denominado, nos termos  da Lei e do Contrato de Presta&ccedil;&atilde;o de Servi&ccedil;os Educacionais, assinado em  __/__/____, para Presta&ccedil;&atilde;o de Servi&ccedil;os Educacionais ao aluno <u>$nome</u>,  mat. n&ordm; <u>$matricula</u>, devidamente qualificado no seu requerimento de matr&iacute;cula. Tem entre si justo e acordado o que se segue: <br />
    <strong>CL&Aacute;USULA PRIMEIRA</strong>: Constitui objeto deste termo aditivo  a prorroga&ccedil;&atilde;o da vig&ecirc;ncia do Contrato de Presta&ccedil;&atilde;o de Servi&ccedil;os Educacionais por  mais um semestre letivo, per&iacute;odo 2014.2, ao fim  do qual, o <strong>CONTRATANTE</strong> dever&aacute;  renovar sua matr&iacute;cula mediante um novo TERMO ADITIVO, para que possa realizar  as disciplinas subsequentes, condicionado a aprova&ccedil;&atilde;o nas disciplinas do  per&iacute;odo/m&oacute;dulo anterior, conforme a matriz curricular (fluxograma) e seu  calend&aacute;rio, ambos definidos pela <strong>CONTRATADA</strong>.<br />
    <strong>PAR&Aacute;GRAFO &Uacute;NICO: </strong>A configura&ccedil;&atilde;o formal  da prorroga&ccedil;&atilde;o da vig&ecirc;ncia do Contrato de Presta&ccedil;&atilde;o de Servi&ccedil;os Educacionais dar-se-&aacute;  pela assinatura e entrega deste Termo Aditivo, por parte do <strong>CONTRATANTE</strong>, no Setor da Secretaria da <strong>CONTRATADA, </strong>bem como pelo pagamento da  primeira parcela do per&iacute;odo contratado.</p>
  <p><strong>CL&Aacute;USULA SEGUNDA: </strong>O presente Termo de Aditamento passa a  fazer parte integrante do Contrato de Presta&ccedil;&atilde;o de Servi&ccedil;os Educacionais Presencial  e &agrave; Dist&acirc;ncia, permanecendo inalteradas todas as demais disposi&ccedil;&otilde;es nele  contidas e n&atilde;o referidas no presente aditivo.</p>
  <p>E  por estarem, assim, justas e contratadas, assinam o presente em 02 (duas) vias  de igual teor e forma, juntamente com as testemunhas abaixo.</p>
</div>
<div class=\"base\" style=\"margin-top:40px; text-align:justify; font-family:Arial, Helvetica, sans-serif; font-size:12px;\">
  <p><center>_________________, ____ de&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; de 2014.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </center><br />
  </p>
  <p>
    <strong>CONTRATANTE:  __________________________________________________</strong></p><br>
  <p><strong>CONTRATADA:  ____________________________________________________</strong><br />
    <strong>$razao</strong></p>
  <p><strong>Testemunhas:</strong></p>
  <p>Nome: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Nome:</p>
  <p>CPF: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CPF:</p>
</div>
<div style=\"page-break-after: always;\"></div>
<div style=\"page-break-after: always;\"></div>
";
}

?>