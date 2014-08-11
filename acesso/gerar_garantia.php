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
	$nasc_fiador = $dados_aluno["nasc_fia"];
	$nacio_fiador = $dados_aluno["nacio_fia"];
	$rg_fiador = $dados_aluno["rg_fia"];
	$end_fia = $dados_aluno["end_fia"];
	$bairro_fia = $dados_aluno["bairro_fia"];
	$cidade_fia = $dados_aluno["cidade_fia"];
	$uf_fia = $dados_aluno["uf_fia"];
	$cep_fia = $dados_aluno["cep_fia"];
	$tel_fia = $dados_aluno["tel_fia"];
	$email_fia = $dados_aluno["email_fia"];
	
	
	$nome_conj = $dados_aluno["nome_conj"];
	$nasc_conj = $dados_aluno["nasc_conj"];
	$nacio_conj = $dados_aluno["nacio_conj"];
	$cpf_conj = $dados_aluno["cpf_conj"];
	$rg_conj = $dados_aluno["rg_conj"];
	
	if(trim($nome_fiador) == ""){
		$nome_fiador = "________________________________________";	
		$cpf_fiador = "________________________________________";
		
	$nasc_fiador ="________________________________________";	
	$nacio_fiador = "________________________________________";	
	$rg_fiador = "________________________________________";	
	$end_fia = "________________________________________";	
	$bairro_fia = "________________________________________";	
	$cidade_fia = "________________________________________";	
	$uf_fia = "________________________________________";	
	$cep_fia = "________________________________________";	
	$tel_fia = "________________________________________";	
	$email_fia = "________________________________________";	
	
	
	$nome_conj = "________________________________________";	
	$nasc_conj = "________________________________________";	
	$nacio_conj = "________________________________________";	
	$cpf_conj = "________________________________________";	
	$rg_conj = "________________________________________";	
	}
	$nome = strtoupper($dados_aluno["nome"]);
	
	//dados da empresa
	$sql_turma = mysql_query("SELECT * FROM ced_turma WHERE id_turma = $get_turma");
	$dados_turma = mysql_fetch_array($sql_turma);
	$unidade = trim($dados_turma["unidade"]);
	$sql_empresa = mysql_query("SELECT * FROM unidades WHERE unidade LIKE '%$unidade%' LIMIT 1");
	$dados_empresa = mysql_fetch_array($sql_empresa);
	$sigla = substr(trim($dados_empresa["sigla"]),0,2);
	$sql_cc2 = mysql_query("SELECT * FROM cc2 WHERE id_filial LIKE '$sigla'");
	$dados_cc2 = mysql_fetch_array($sql_cc2);
	$cnpj = $dados_cc2["cnpj"];
	$endereco = $dados_cc2["endereco"]." - ".$dados_cc2["bairro"].", ".$dados_cc2["cidade"]." - ".$dados_cc2["uf"].", CEP: ".$dados_cc2["cep"];
echo "
	<p align=\"center\"><strong>Anexo I - Da Garantia  Contratual</strong></p>
<p><strong> </strong></p>
<p>Como  garantia deste contrato, o <strong>CONTRATANTE</strong> indica a modalidade fiança pessoal ora prestada pelo <strong>FIADOR</strong> abaixo qualificado, que, como <strong><u>principal pagador e solidariamente responsável até a conclusão do  curso, compromete-se por si e seus herdeiros, ilimitadamente, a satisfazer  todas as obrigações pecuniárias aqui contraídas, como também, as dívidas que,  decorrentes deste instrumento, venham a ser constituídas por força de  renovações de matrícula para módulo subsequente ou de parcelamentos (moratória)  de parcelas mensais em atraso e, ainda por todos os acessórios da dívida  principal, inclusive as despesas extrajudiciais e judiciais</u></strong>, nos termos  do art. 821 e 822 da Lei 10.406 de 10 de janeiro de 2002.</p>
<p>&nbsp;</p>
<div>
  <p><strong>FIADOR</strong>: $nome_fiador<br />
    Data de nascimento: $nasc_fiador Nacionalidade: $nacio_fiador<br />
    CPF: $cpf_fiador RG:  $rg_fiador <br />
    <strong>CÔNJUGE:</strong> $nome_conj<br />
    Data de nascimento: $nasc_conj Nacionalidade: $nasc_conj<br />
    CPF: $cpf_conj RG: $rg_conj<br />
    Endereço: $end_fia<br />
    Bairro: $bairro_fia Cidade: $cidade_fia  UF: $uf_fia<br />
    CEP: $cep_fia Telefone(s):  $tel_fia<br />
    E-mail: $email_fia</p>
</div>
<p><strong>&nbsp;</strong></p>
<p>____________________(ES),  ________ de _______________________ de ______</p>
<p align=\"center\">&nbsp;</p>
<p>_________________________________             ____________________________<br />
  <strong>CONTRATADA                                                 CONTRATANTE</strong></p>
<p>_________________________________           _____________________________<br />
  <strong>ALUNO                                                             FIADOR</strong></p>
<p align=\"center\">                                        <br />
  _____________________________________<br />
  <strong>CÔNJUGE DO FIADOR</strong></p>
<p>TESTEMUNHAS: </p>
<p>1)  _________________________________________<br />
  CPF:_______________________________________</p>
<p>2)  _________________________________________<br />
  CPF:_______________________________________</p>

	
<div style=\"page-break-after: always;\"></div>
	
";
}


?>