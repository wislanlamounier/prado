<?php include ('menu/menu.php');?>
<div class="conteudo">
<?php require_once('includes//conectar.php'); // lembrando que esta � uma conex�o padr�o 
$get_unidade = $_GET["unidade"];
$get_cc1 = $_GET["cc1"];
$get_cc2 = $_GET["cc2"];
$get_cc3 = $_GET["cc3"];
$inicio = $_GET["inicio"];
$fim = $_GET["fim"];
$limit_i = "0";
$limit = "50";
$get_tipo = "2";
if($get_tipo == 2){
	$get_tipo2 = 99;
} else {
	$get_tipo2 = 1;
}


?>

<?php
//FILTRO CC1
if($get_cc1 !=""&&$get_cc2 ==""&&$get_cc3 ==""){
$sql = mysql_query("SELECT * FROM view_iss WHERE id_titulo NOT IN (select id_titulo from iss_xml) AND
cc1 = '$get_cc1' AND iss LIKE '%S%' AND valor_pagto >100
AND status = 0 AND cc3 <> '90' AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6  LIMIT $limit_i , $limit");


$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_iss WHERE 
cc1 = '$get_cc1' AND valor_pagto >100
AND status = 0 AND cc3 <> '90' AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6  LIMIT $limit_i , $limit");
$dados_soma = mysql_fetch_array($sql_soma);
}
//FILTRO CC1 / CC2
if($get_cc1 !=""&&$get_cc2 !=""&&$get_cc3 ==""){
$sql = mysql_query("SELECT * FROM view_iss WHERE id_titulo NOT IN (select id_titulo from iss_xml) AND
cc1 = '$get_cc1' AND cc3 <> '90' AND cc3 <> '90' AND cc2 = '$get_cc2' AND iss LIKE '%S%'  AND valor_pagto >100
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6  LIMIT $limit_i , $limit");


$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_iss WHERE 
cc1 = '$get_cc1' AND cc2 = '$get_cc2'   AND valor_pagto >100
AND status = 0 AND cc3 <> '90' AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6  LIMIT $limit_i , $limit");
$dados_soma = mysql_fetch_array($sql_soma);
}
//FILTRO CC1 / CC2 / CC3
if($get_cc1 !=""&&$get_cc2 !=""&&$get_cc3 !=""){

$sql = mysql_query("SELECT * FROM view_iss WHERE id_titulo NOT IN (select id_titulo from iss_xml) AND
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3'  AND iss LIKE '%S%'  AND valor_pagto >100
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6 LIMIT $limit_i , $limit");


$sql_soma = mysql_query("SELECT SUM(valor_pagto) as soma FROM view_iss WHERE 
cc1 = '$get_cc1' AND cc3 <> '90' AND cc2 = '$get_cc2' AND cc3 = '$get_cc3'  AND valor_pagto >100
AND status = 0 AND (data_pagto BETWEEN '$inicio' AND '$fim') AND (tipo = '$get_tipo' OR tipo ='$get_tipo2') ORDER BY  cc1, cc2, cc3, cc4, cc5, cc6 LIMIT $limit_i , $limit");
$dados_soma = mysql_fetch_array($sql_soma);
}





//PEGA OS DADOS DE CONTROLE DO XML 
$sql_controle = mysql_query("SELECT * FROM controle_lote WHERE unidade LIKE '%$get_unidade%'");
$controle = mysql_fetch_array($sql_controle);
$cnpj = $controle["cnpj"];
$inscricao_municipal = $controle["insc_municipal"];
$cod_trib = $controle["cod_trib_municip"];
$cod_cnae = $controle["cnae"];
$cod_municip = $controle["cod_municip"];
$n_lote = $controle["lote"];
$contar_lote = $controle["max_num"];


$row = mysql_fetch_assoc($sql);
$total = mysql_num_rows($sql);


if ($total == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('N�O H� REGISTROS PARA CRIAR LOTE')
    history.back();
    </SCRIPT>");
	return;
}

$i = $contar_lote;


$emissao = date("Y-m-d")."T".date("h:i:s");
// abrindo o documento XML
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>

<EnviarLoteRpsEnvio><LoteRps>

<NumeroLote>".$n_lote."</NumeroLote>
<Cnpj>".$cnpj."</Cnpj>
<InscricaoMunicipal>".$inscricao_municipal."</InscricaoMunicipal>
<QuantidadeRps>".$total."</QuantidadeRps>
<ListaRps>";

// abrindo o while com os dados dos aniversariantes, isso delimita 
do { 

$cod_aluno = $row["cliente_fornecedor"];
//DADOS DO ALUNO
$sql_aluno = mysql_query("SELECT * FROM alunos WHERE codigo = '$cod_aluno'");
$dados_aluno = mysql_fetch_array($sql_aluno);

//NOME SEM ACENTUACAO
$trocarIsso = array('�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','�','O','�','�','�','�','/','.','-','�',',','�',);
$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','O','U','U','U','Y','','','','','','A',);
//$aluno = str_replace($trocarIsso, $porIsso, $dados_aluno["nome"]);
//$aluno = strtr($dados_aluno["nome"], "��������������������������", "aaaaeeiooouucAAAAEEIOOOUUC");

$aluno = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($dados_aluno["nome"]));
$aluno_res = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($dados_aluno["nome_fin"]));
//CPF SEM PONTUACAO
$trocarIsso2 = array('.','-',);
$porIsso2 = array('','',);
$aluno_cpf = str_replace($trocarIsso2, $porIsso2, $dados_aluno["cpf_fin"]);
$aluno_cep = str_replace($trocarIsso2, $porIsso2, $dados_aluno["cep"]);

//ENDERECO SEM ACENTUCAO
$aluno_end = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($dados_aluno["endereco"]));
$aluno_uf = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($dados_aluno["uf"]));
$aluno_cidade = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($dados_aluno["cidade"]));
$aluno_bairro = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($dados_aluno["bairro"]));;


$aluno_comp = preg_replace("/&([a-z])[a-z]+;/i", "$1", htmlentities($dados_aluno["complemento"]));;

//COD MUNICIPIO
$sql_municipio = mysql_query("SELECT * FROM cod_municipios WHERE uf LIKE '%$aluno_uf%' AND nome LIKE '%$aluno_cidade%'");
$dados_mun = mysql_fetch_array($sql_municipio);
$cont_mun = mysql_num_rows($sql_municipio);


if($cont_mun == 1){
$aluno_cod_municipio = $dados_mun["codigo"];
} else {
$aluno_cod_municipio = "00000000";
}


if(trim($aluno) == ""){
$aluno = "--";
} 
if(trim($aluno_bairro) == ""){
$aluno_bairro = "--";
} 
if(trim($aluno_cidade) == ""){
$aluno_cidade = "--";
} 
if(trim($aluno_comp) == ""){
$aluno_comp = "--";
} 
if(trim($aluno_cpf) == ""){
$aluno_cpf = "00000000000";
} 
if(trim($aluno_end) == ""){
$aluno_end = "--";
} 
if(trim($aluno_uf) == ""){
$aluno_uf = "ES";
} 
if(isset($aluno_num) == ""){
$aluno_num = "00";
} else {
$aluno_num = "00";
}

// abrindo um n� com o nome aniversariantes. cada n� neste, 

$xml .="

<Rps>
<InfRps>
<IdentificacaoRps>
<Numero>".$i."</Numero>
<Serie>M</Serie>
<Tipo>1</Tipo>
</IdentificacaoRps>

<DataEmissao>".$emissao."</DataEmissao>
<NaturezaOperacao>1</NaturezaOperacao>
<RegimeEspecialTributacao>6</RegimeEspecialTributacao>
<OptanteSimplesNacional>2</OptanteSimplesNacional>
<IncentivadorCultural>2</IncentivadorCultural>
<Status>1</Status>

<Servico>
<Valores>
<ValorServicos>".$row["valor_pagto"]."</ValorServicos>
<IssRetido>2</IssRetido>
<BaseCalculo>".$row["valor_pagto"]."</BaseCalculo>
<Aliquota>0</Aliquota>
</Valores>
<ItemListaServico>8.01</ItemListaServico>
<CodigoCnae>".$cod_cnae."</CodigoCnae>
<CodigoTributacaoMunicipio>".$cod_trib."</CodigoTributacaoMunicipio>
<Discriminacao>ALUNO: ".$aluno."- MENSALIDADE ".$row["parcela"]."</Discriminacao>
<CodigoMunicipio>".$cod_municip."</CodigoMunicipio>
</Servico>
<Prestador>
<Cnpj>".$cnpj."</Cnpj>
<InscricaoMunicipal>".$inscricao_municipal."</InscricaoMunicipal>
</Prestador>
<Tomador>
<IdentificacaoTomador>
<CpfCnpj>
<Cpf>".$aluno_cpf."</Cpf>
</CpfCnpj>
</IdentificacaoTomador>
<RazaoSocial>".$aluno_res."</RazaoSocial>
<Endereco>
<Endereco>".$aluno_end."</Endereco>
<Numero>".$aluno_num."</Numero>
<Complemento>".$aluno_comp."</Complemento>
<Bairro>".$aluno_bairro."</Bairro>
<CodigoMunicipio>".$cod_municip."</CodigoMunicipio>
<Uf>".$aluno_uf."</Uf>
<Cep>".$aluno_cep."</Cep>
</Endereco>
</Tomador>
</InfRps>
</Rps>
";
$titulo = $row["id_titulo"];
$data = date("Y-m-d");
mysql_query("INSERT INTO iss_xml (id_titulo, data, lote) VALUES ('$titulo','$data','$n_lote' )");
$i+=1;
// fechando o while dos dados
} while ($row = mysql_fetch_assoc($sql));

// fechando o n� principal
$xml .="</ListaRps></LoteRps></EnviarLoteRpsEnvio>";
$nome_arquivo = date("d-m-Y his");
$ponteiro = fopen("lotes/".$n_lote.".xml", 'w'); //cria um arquivo com o nome backup.xml
fwrite($ponteiro, $xml); // salva conte�do da vari�vel $xml dentro do arquivo backup.xml
 
$ponteiro = fclose($ponteiro); //fecha o arquivo
 

echo "Arquivo de lote <a href=\"lotes/".$n_lote.".xml\">[$n_lote]</a> gerado com sucesso!";
$novo_lote= $n_lote +1;
$novo_i = $i+1;
mysql_query("UPDATE controle_lote SET lote = '$novo_lote', max_num = '$novo_i' WHERE unidade LIKE '%$get_unidade%'");
// e liberando a consulta do banco, o que � sempre uma boa pr�tica :)
mysql_free_result($sql);
   ?>
   

</div>
<?php include ('menu/footer.php');?>
