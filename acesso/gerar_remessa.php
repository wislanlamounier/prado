<?php 
include ("includes/conectar.php");
$conta = $_POST["conta"];
$dataini = $_POST["dataini"];
$diaini = substr($dataini,8,2);
$mesini = substr($dataini,5,2);
$anoini = substr($dataini,0,4);
$datainifinal = $diaini."/".$mesini."/".$anoini;

$datafin = $_POST["datafin"];
$diafin = substr($datafin,8,2);
$mesfin = substr($datafin,5,2);
$anofin = substr($datafin,0,4);
$datafinfinal = $diafin."/".$mesfin."/".$anofin;
$conta2 = mysql_query("SELECT * FROM contas WHERE ref_conta LIKE '$conta'");
$conta3 = mysql_fetch_array($conta2);
$contafinal = $conta3["conta"];
$banco = $conta3["banco"];
$agencia = $conta3["agencia"];
$n_conta = $conta3["n_conta"];
$banco1 = mysql_query("SELECT * FROM bancos WHERE codigo LIKE '$banco'");
$banco2 = mysql_fetch_array($banco1);
$bancofinal = $banco2["banco"];
if($conta == "*"){
	$contafinal = "TODOS";
}




$date = date("Y-m-d");


if($conta =='selecione'){
	echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('VOCÊ DEVE SELECIONAR A CONTA')
    history.go(-1);
    </SCRIPT>");
	return;
}



//TODAS AS CONTAS
if($conta != '*'&&$dataini == ""&&$datafin == ""){
	$sql2 =  mysql_query("SELECT * FROM contas WHERE ref_conta LIKE  '%$conta%'");
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE conta LIKE  '%$conta%' AND valor_pagto = 0 AND id_titulo NOT IN (select codigo FROM remessa) AND (tipo_titulo = 2 OR tipo_titulo = 99) AND status = 0");
	$soma = mysql_query("SELECT SUM(valor) as total FROM geral_titulos WHERE conta LIKE  '%$conta%' AND valor_pagto = 0 AND id_titulo NOT IN (select codigo FROM remessa) AND (tipo_titulo = 2 OR tipo_titulo = 99)  AND status = 0");
	
}
//TODAS AS CONTAS - PERIODO INICIAL
if($conta != '*'&&$dataini != ""&&$datafin == ""){
	$sql2 =  mysql_query("SELECT * FROM contas WHERE ref_conta LIKE  '%$conta%'");
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE conta LIKE  '%$conta%' AND (dt_doc >= '$dataini' OR vencimento >= '$dataini' ) AND valor_pagto = 0 AND id_titulo NOT IN (select codigo FROM remessa) AND (tipo_titulo = 2 OR tipo_titulo = 99)  AND status = 0");
	$soma = mysql_query("SELECT SUM(valor) as total FROM geral_titulos WHERE conta LIKE  '%$conta%' AND (dt_doc >= '$dataini' OR vencimento >= '$dataini' ) AND valor_pagto = 0 AND id_titulo NOT IN (select codigo FROM remessa) AND (tipo_titulo = 2 OR tipo_titulo = 99)  AND status = 0");

}

//TODAS AS CONTAS - PERIODO FINAL
if($conta != '*'&&$dataini == ""&&$datafin != ""){
	$sql2 =  mysql_query("SELECT * FROM contas WHERE ref_conta LIKE  '%$conta%'");
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE conta LIKE  '%$conta%' AND (dt_doc <= '$dataini' OR vencimento <= '$dataini' ) AND valor_pagto = 0 AND id_titulo NOT IN (select codigo FROM remessa) AND (tipo_titulo = 2 OR tipo_titulo = 99)  AND status = 0");
	$soma = mysql_query("SELECT SUM(valor) as total FROM geral_titulos WHERE conta LIKE  '%$conta%' AND (dt_doc <= '$dataini' OR vencimento <= '$dataini' ) AND valor_pagto = 0 AND id_titulo NOT IN (select codigo FROM remessa) AND (tipo_titulo = 2 OR tipo_titulo = 99)  AND status = 0");
	
}


//OUTRAS CONTAS - PERIODO INICIAL E FINAL
if($conta != '*'&&$dataini != ""&&$datafin != ""){
	$sql2 =  mysql_query("SELECT * FROM contas WHERE ref_conta LIKE  '%$conta%'");
	$sql = mysql_query("SELECT * FROM geral_titulos WHERE conta LIKE  '%$conta%' AND (vencimento BETWEEN '$dataini' AND '$datafin' ) AND valor_pagto = 0 AND id_titulo NOT IN (select codigo FROM remessa) AND (tipo_titulo = 2 OR tipo_titulo = 99)  AND status = 0");
	$soma = mysql_query("SELECT SUM(valor) as total FROM geral_titulos WHERE conta LIKE  '%$conta%' AND (vencimento BETWEEN '$dataini' AND '$datafin' ) AND valor_pagto = 0 AND id_titulo NOT IN (select codigo FROM remessa) AND (tipo_titulo = 2 OR tipo_titulo = 99)  AND status = 0");
}



$somando = mysql_fetch_array($soma);
$total = $somando["total"];


$count = mysql_num_rows($sql);
if ($count == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NÃO HÁ DADOS PARA SEREM GERADOS')
    history.back();
    </SCRIPT>");}

?>

<?php include 'menu/menu.php' ?>
<div class="conteudo">
<?php

/*

* @descr: Gera o arquivo de remessa para cobranca no padrao CEDTEC - SANTANDER CNAB 400

*/


// funções

/***
 * Função para remover acentos de uma string
 *
 * @autor Thiago Belem <contato@thiagobelem.net>
 */
function removeAcentos($string, $slug = false) {
	$string = strtolower($string);

	// Código ASCII das vogais
	$ascii['a'] = range(224, 230);
	$ascii['e'] = range(232, 235);
	$ascii['i'] = range(236, 239);
	$ascii['o'] = array_merge(range(242, 246), array(240, 248));
	$ascii['u'] = range(249, 252);

	// Código ASCII dos outros caracteres
	$ascii['b'] = array(223);
	$ascii['c'] = array(231);
	$ascii['d'] = array(208);
	$ascii['n'] = array(241);
	$ascii['y'] = array(253, 255);

	foreach ($ascii as $key=>$item) {
		$acentos = '';
		foreach ($item AS $codigo) $acentos .= chr($codigo);
		$troca[$key] = '/['.$acentos.']/i';
	}

	$string = preg_replace(array_values($troca), array_keys($troca), $string);

	// Slug?
	if ($slug) {
		// Troca tudo que não for letra ou número por um caractere ($slug)
		$string = preg_replace('/[^a-z0-9]/i', $slug, $string);
		// Tira os caracteres ($slug) repetidos
		$string = preg_replace('/' . $slug . '{2,}/i', $slug, $string);
		$string = trim($string, $slug);
	}

	return $string;
}

function modulo_11($num, $base=9, $r=0)  {
    /**
     *   Autor:
     *           Pablo Costa <pablo@users.sourceforge.net>
     *
     *   Função:
     *    Calculo do Modulo 11 para geracao do digito verificador 
     *    de boletos bancarios conforme documentos obtidos 
     *    da Febraban - www.febraban.org.br 
     *
     *   Entrada:
     *     $num: string numérica para a qual se deseja calcularo digito verificador;
     *     $base: valor maximo de multiplicacao [2-$base]
     *     $r: quando especificado um devolve somente o resto
     *
     *   Saída:
     *     Retorna o Digito verificador.
     *
     *   Observações:
     *     - Script desenvolvido sem nenhum reaproveitamento de código pré existente.
     *     - Assume-se que a verificação do formato das variáveis de entrada é feita antes da execução deste script.
     */                                        

    $soma = 0;
    $fator = 2;

    /* Separacao dos numeros */
    for ($i = strlen($num); $i > 0; $i--) {
        // pega cada numero isoladamente
        $numeros[$i] = substr($num,$i-1,1);
        // Efetua multiplicacao do numero pelo falor
        $parcial[$i] = $numeros[$i] * $fator;
        // Soma dos digitos
        $soma += $parcial[$i];
        if ($fator == $base) {
            // restaura fator de multiplicacao para 2 
            $fator = 1;
        }
        $fator++;
    }

    /* Calculo do modulo 11 */
    if ($r == 0) {
        $soma *= 10;
        $digito = $soma % 11;
        if ($digito == 10) {
            $digito = 0;
        }
        return $digito;
    } elseif ($r == 1){
        $resto = $soma % 11;
        return $resto;
    }
}


function formata_numero($numero,$loop,$insert,$tipo = "geral") {
	if ($tipo == "geral") {
		$numero = str_replace(",","",$numero);
		while(strlen($numero)<$loop){
			$numero = $insert . $numero;
		}
	}
	if ($tipo == "valor") {
		/*
		retira as virgulas
		formata o numero
		preenche com zeros
		*/
		$numero = str_replace(",","",$numero);
		while(strlen($numero)<$loop){
			$numero = $insert . $numero;
		}
	}
	if ($tipo == "convenio") {
		while(strlen($numero)<$loop){
			$numero = $numero . $insert;
		}
	}
	return $numero;
}


function digitoVerificador_nossonumero($numero) {
	$resto2 = modulo_11($numero, 9, 1);
     $digito = 11 - $resto2;
     if ($digito == 10 || $digito == 11) {
        $dv = 0;
     } else {
        $dv = $digito;
     }
	 return $dv;
}

//fim de funcoes

function limit($palavra,$limite)

{

    if(strlen($palavra) >= $limite)

    {

        $var = substr($palavra, 0,$limite);

    }

    else

    {

        $max = (int)($limite-strlen($palavra));

        $var = $palavra.complementoRegistro($max,"brancos");

    }

    return $var;

}



function sequencial($i)

{

    if($i < 10)

    {

        return zeros(0,5).$i;

    }

    else if($i > 10 && $i < 100)

    {

        return zeros(0,4).$i;

    }

    else if($i > 100 && $i < 1000)

    {

        return zeros(0,3).$i;

    }

    else if($i > 1000 && $i < 10000)

    {

        return zeros(0,2).$i;

    }

    else if($i > 10000 && $i < 100000)

    {

        return zeros(0,1).$i;

    }

}



function zeros($min,$max)

{

    $x = ($max - strlen($min));

    for($i = 0; $i < $x; $i++)

    {

        $zeros = '0';

    }

    return $zeros.$min;

}



function complementoRegistro($int,$tipo)

{

    if($tipo == "zeros")

    {

        $space = '';

        for($i = 1; $i <= $int; $i++)

        {

            $space .= '0';

        }

    }

    else if($tipo == "brancos")

    {

        $space = '';

        for($i = 1; $i <= $int; $i++)

        {

            $space .= ' ';

        }

    }

    

    return $space;

}



$fusohorario = 3; // como o servidor de hospedagem é a dreamhost pego o fuso para o horario do brasil

$timestamp = mktime(date("H") - $fusohorario, date("i"), date("s"), date("m"), date("d"), date("Y"));



$DATAHORA['PT'] = gmdate("d/m/Y H:i:s", $timestamp);

$DATAHORA['EN'] = gmdate("Y-m-d H:i:s", $timestamp);

$DATA['PT'] = gmdate("d/m/Y", $timestamp);

$DATA['EN'] = gmdate("Y-m-d", $timestamp);

$DATA['DIA'] = gmdate("d",$timestamp);

$DATA['MES'] = gmdate("m",$timestamp);

$DATA['ANO'] = gmdate("y",$timestamp);

$HORA = gmdate("H:i:s", $timestamp);



define("REMESSA","remessa/",true);



$filename = REMESSA.$DATA['DIA'].$DATA['MES'].$DATA['ANO']." - ".$conta.".txt";

$conteudo = '';


#LÊ OS DADOS DA EMPRESA NO SERVIDOR
$dados2 = mysql_fetch_array($sql2);

## REGISTRO HEADER

                                #NOME DO CAMPO        #SIGNIFICADO            #POSICAO    #PICTURE

$conteudo .= '0';             //    tipo de registro    id registro header        001 001        9(01) 

$conteudo .= 1;             //     operacao            tipo operacao remessa    002 002        9(01)

$conteudo .= 'REMESSA';        //    literal remessa        escr. extenso            003 009        X(07)

$conteudo .= '01';            //     codigo servico        id tipo servico            010 011        9(02)

$conteudo .= limit('COBRANCA',15);    //     literal cobranca    escr. extenso    012 026        X(15)

$conteudo .= $dados2["cod_trans"];            //  codigo de transmissão        027 046        9(020)

$conteudo .= limit($dados2["razao"],30);  //  NOME DO CEDENTE      047 076        X(030)

$conteudo .= '033';				// código do banco    077 079        9(003)

$conteudo .= limit('SANTANDER',15);        //      nome do banco        080 094        X(15)

$conteudo .= $DATA['DIA'].$DATA['MES'].$DATA['ANO'];//data geracao arquivo    095 100        9(06)

$conteudo .= complementoRegistro(16,"zeros"); // complemento de registr    101 116        X(016)

$conteudo .= complementoRegistro(275,"brancos");// complemento de registr    117 391        X(274)

$conteudo .= '000';            //versão da remessa OPCIONAL    392 394        9(03)

$conteudo .= str_pad(sequencial(1), 6,"0", STR_PAD_LEFT);        // numero sequencial    registro no arquivo        395 400        9(06)



$conteudo .= "\n"; //essa é a quebra de linha



### DADOS DOS CLIENTES PARA TESTE

while ($dados = mysql_fetch_array($sql)) {
        // enquanto houverem resultados...
	$id_titulo          = utf8_encode($dados["id_titulo"]);
	$nome_cliente          = strtoupper(removeAcentos($dados["nome"]));
	$cpf_cliente          = $dados["cpf_cnpj"];
	$endereco          = strtoupper(removeAcentos($dados["endereco"]));
	$bairro          = strtoupper(removeAcentos($dados["bairro"]));
	
	$emissao          = (substr($dados["dt_doc"],8,2)).substr($dados["dt_doc"],5,2).substr($dados["dt_doc"],2,2);
	$data_desconto          = $dados["dia_desc"].substr($dados["vencimento"],5,2).substr($dados["vencimento"],2,2);
	$diavenc = substr($dados["vencimento"],8,2);
	$vencimento          = substr($dados["vencimento"],8,2).substr($dados["vencimento"],5,2).substr($dados["vencimento"],2,2);
	$data_s_desconto          = ($diavenc+1).substr($dados["vencimento"],5,2).substr($dados["vencimento"],2,2);
	$valor_titulo 		= number_format($dados["valor"], 2, ',', '');
	$valor_desconto 		= number_format((($dados["valor"]*$dados["desconto"])/100), 2, ',', '');
	$jurosmora = number_format($dados["valor"]*0.0023, 2, ',', '');
	$nnum = substr($dados["id_titulo"],1,8);
	$trocar = array('.', '-', '/');
	$hoje = date("Y-m-d");
	$cep2          = str_replace($trocar,"",$dados["cep"]);
	if(strlen($cep2)<8){
		$cep = '29000000';
	} else {
		$cep = $cep2;
	}
	
	$cidade		  = strtoupper(removeAcentos($dados["cidade"]));
	$uf2		  = strtoupper(removeAcentos($dados["uf"]));
	if(strlen($uf2) < 2){
		$uf = "ES";
	} else {
		$uf = $uf2;
	}
	mysql_query("INSERT INTO remessa (codigo, data) VALUES ('$id_titulo', '$hoje');");
	$dv_nosso_numero =digitoVerificador_nossonumero($nnum);
	$nosso_numero = $nnum.$dv_nosso_numero;
	$clientes[] = array("$id_titulo","$nome_cliente","$cpf_cliente","$valor_titulo","$nosso_numero","$data_desconto","$data_s_desconto","$vencimento","$emissao","$jurosmora","$valor_desconto","$endereco","$bairro","$cep","$cidade","$uf");
	
    
		
    }

/*
$clientes[] = array("BOLETO001","Cliente A","11111111111","100,00");

$clientes[] = array("BOLETO002","Cliente B","22222222222","200,00");

$clientes[] = array("BOLETO003","Cliente C","33333333333","300,00");

$clientes[] = array("BOLETO004","Cliente D","44444444444","400,00");
*/


$i = 2;

foreach($clientes as $cliente)

{

    ## REGISTRO DETALHE (OBRIGATORIO)

                                                                           #NOME DO CAMPO                #SIGNIFICADO            #POSICAO    #PICTURE

    $conteudo .= 1;                                                        //    tipo registro                id registro transacac.    001 001        9(01)

    $conteudo .= '02';                                                    //     codigo inscricao            tipo inscricao empresa    002 003        9(02)

    $conteudo .= $dados2["cnpj"];                                        //    cnpj da empresa                                        004 017        9(14)

    $conteudo .= $dados2["cod_trans"];                                                    //     codigo de trasmissão                        mantenedora da conta    018 021        9(04)

    $conteudo .= limit($cliente[0],25);                                                    //   numero do titulo cedtec 	022 023        9(02)

    $conteudo .= substr($cliente[4],0,8);                                                //     conta                        numero da conta            024 028        9(05)

    $conteudo .= str_pad($cliente[5], 6,"0", STR_PAD_LEFT);                                                        //     dac                            dig autoconf conta        029 029        9(01)

    $conteudo .= complementoRegistro(1,"brancos");                        //     brancos                        complemento registro     030 033        X(04)

    $conteudo .= "4";                        //  CÓD.INSTRUÇÃO/ALEGAÇÃO A SER CANC NOTA 27             034 037        9(04)

    $conteudo .= "0200";                                    //     USO / IDENT. DO TÍTULO NA EMPRESA NOTA 2            038 062        X(25)

    $conteudo .= complementoRegistro(2,"zeros");                        //     NOSSO NUMERO / ID TITULO DO BANCO NOTA 3            063 070        9(08)

    $conteudo .= '0000000000000';                                        //verificar santander        NOTA 4                            071 083        9(08)V9(5)

    $conteudo .= complementoRegistro(4,"brancos");                                                    //     nº da carteira        nº carteira banco                084 086        9(03)            

    $conteudo .= str_pad($cliente[6], 6,"0", STR_PAD_LEFT);                        // uso do banco ident. oper. no banco                    087 107        X(21)

    $conteudo .= 5;
	
	$conteudo .= '01';
	
	$conteudo .= str_pad($cliente[0], 10,"0", STR_PAD_LEFT);
	
	$conteudo .= str_pad($cliente[7], 6,"0", STR_PAD_LEFT);
	
	$conteudo .= str_pad(str_replace(",","",$cliente[3]), 13,"0", STR_PAD_LEFT); //valor do titulo
	
	$conteudo .= '033'; //numero do banco
	
	$conteudo .= '47511'; //numero da agencia
	
	$conteudo .= '01'; //espécie do documento
	
	$conteudo .= 'N'; //tipo de aceite
	
	$conteudo .= str_pad($cliente[8], 6,"0", STR_PAD_LEFT); //DATA DE EMISSÃO
	
	$conteudo .= '00'; //INSTRUÇÃO 1
	
	$conteudo .= '00'; //INSTRUÇÃO 2
	
	$conteudo .= str_pad(str_replace(",","",$cliente[9]), 13,"0", STR_PAD_LEFT); //JUROS DE MORA AO DIA
	
	$conteudo .= str_pad($cliente[5], 6,"0", STR_PAD_LEFT); //DATA PARA DESCONTO
	
	$conteudo .= str_pad(str_replace(",","",$cliente[10]), 13,"0", STR_PAD_LEFT); //VALOR DO DESCONTO
	
	$conteudo .= complementoRegistro(13,"zeros");; //VALOR DO IOF
	
	$conteudo .= complementoRegistro(13,"zeros");; //VALOR DO SEGUNDO DESCONTO
	
	$conteudo .= '01';; //TIPO DE INSCRIÇÃO DO SACADO - 01 CPF - 02 CNPJ
	
	$conteudo .= str_pad(str_replace($trocar,"",$cliente[2]), 14,"0", STR_PAD_LEFT); // CPF DO SACADO
	
	$conteudo .= limit($cliente[1],40);    // NOME SACADO
	
	$conteudo .= limit($cliente[11],40);    // ENDEREÇO SACADO
	
	$conteudo .= limit($cliente[12],12);    // BAIRRO SACADO
	
	$conteudo .= substr($cliente[13],0,5);    // CEP SACADO
	
	$conteudo .= substr($cliente[13],5,3);    // CEP SACADO COMPLEMENTO
	
	$conteudo .= limit($cliente[14],15);    // MUNICIPIO SACADO
	
	$conteudo .= limit($cliente[15],2);    // UF SACADO
	
	$conteudo .= complementoRegistro(30,"brancos");    // NOME DO SACADOR OU COOBRIGADO
	
	$conteudo .= complementoRegistro(1,"brancos"); //COMPLEMENTO BRANCO
	
	$conteudo .= $dados2["rem_comp"];    // COMPLEMENTO (BANCO)	
	
	$conteudo .= complementoRegistro(6,"brancos");; //COMPLEMENTO BRANCO
	
	$conteudo .= complementoRegistro(2,"zeros");; //COMPLEMENTO BRANCO
	
	$conteudo .= complementoRegistro(1,"brancos");; //COMPLEMENTO BRANCO
	
	$conteudo .= str_pad(sequencial($i++), 6,"0", STR_PAD_LEFT);            // numero sequencial    do registro no arquivo    395 400        9(06)

    

    $conteudo .= "\n";//chr(13).chr(10); //essa é a quebra de linha
	
	

	


}

## REGISTRO TRAILER

                                #NOME DO CAMPO        #SIGNIFICADO            #POSICAO    #PICTURE

$conteudo .= '9';             //    tipo de registro    id registro header        001 001        9(01) 

$conteudo .= str_pad(sequencial($i), 6,"0", STR_PAD_LEFT);

$conteudo .= str_pad(str_replace(".","",number_format($total, 2, '.', '')), 13,"0", STR_PAD_LEFT); //VALOR TOTAL
 
$conteudo .= complementoRegistro(374,"zeros");; //COMPLEMENTO ZEROS        //    literal remessa        escr. extenso            003 009        X(07)

$conteudo .= str_pad(sequencial($i++), 6,"0", STR_PAD_LEFT);            //     codigo servico        id tipo servico            010 011        9(02)
	

// fecha loop de clientes



//$conteudo .= chr(13).chr(10); //essa é a quebra de linha



## REGISTRO TRAILER DE ARQUIVO

/*

CORRETO LAYOUT ITAU

                                #NOME DO CAMPO        #SIGNIFICADO            #POSICAO    #PICTURE

$conteudo .= 9;                //    tipo de registro    id registro trailer        001 001        9(01)

$conteudo .= complementoRegistro(393,"zeros");    //     brancos                complemento de registro    002 394        X(393)    

$conteudo .= zeros($sequencial,6);         //     nº sequencial        do regsitro no arquivo    395 400        9(06)

*/



/* TENTATIVA SEM SUCESSO

$conteudo .= '9201341          000000000000000000000000000000          000000000000000000000000000000                                                  000000000000000000000000000000          000000000000000000000000000000000010000000800000000000000                                                                                                                                                                '.sequencial($i);

*/



// Em nosso exemplo, nós vamos abrir o arquivo $filename

// em modo de adição. O ponteiro do arquivo estará no final

// do arquivo, e é pra lá que $conteudo irá quando o 

// escrevermos com fwrite().

// 'w+' e 'w' apaga tudo e escreve do zero

// 'a+' comeca a escrever do inicio para o fim preservando o conteudo do arquivo



if (!$handle = fopen($filename, 'w+')) 

{

     erro("Não foi possível abrir o arquivo ($filename)");

}



// Escreve $conteudo no nosso arquivo aberto.

if (fwrite($handle, "$conteudo") === FALSE) 

{

    erro("Não foi possível escrever no arquivo ($filename)");

}

fclose($handle);



echo("Arquivo de remessa gerado com sucesso! <Br><br> <a href=\"/$filename\"> Baixar arquivo remessa ( $filename )</a>");



?>
</div>

<?php include 'menu/footer.php' ?>