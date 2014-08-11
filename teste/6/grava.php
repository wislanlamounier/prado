<?php

	//Conexão à base de dados
	mysql_connect("mysql1.cedtec.com.br", "cedtecvi_pincel", "BDPA2013ced") or die(mysql_error());
	mysql_select_db("cedtecvi_pincel") or die(mysql_error());
	
	//recebe os parâmetros

    $matricula = $_REQUEST['matricula'];
    $turma_disc = $_REQUEST['turma_disc'];
	$n_aula = $_REQUEST['n_aula'];
	$data_falta = $_REQUEST['data_falta'];
	$falta = $_REQUEST['falta'];
	$quantidade = 2;

    try
    {
        //insere na BD
		$sql_verificar = mysql_query("SELECT * FROM faltas WHERE matricula = '".trim($matricula)."' AND turma_disc = '".trim($turma_disc)."' AND n_aula = '".trim($n_aula)."'");
		if(mysql_num_rows($sql_verificar)==1){
			$sql = "UPDATE faltas SET falta ='".trim($falta)."' WHERE matricula = '".trim($matricula)."' AND turma_disc = '".trim($turma_disc)."' AND n_aula = '".trim($n_aula)."'";
		} else {
			$sql = "INSERT INTO faltas (matricula, turma_disc,n_aula,data_falta,falta) VALUES('".trim($matricula)."','".trim($turma_disc)."','".trim($n_aula)."','".trim($data_falta)."','".trim($falta)."')";
		}

        $result = mysql_query($sql) or die(mysql_error());
		
        
        //retorna 1 para no sucesso do ajax saber que foi com inserido sucesso
        echo "1";
    } 
    catch (Exception $ex)
    {
        //retorna 0 para no sucesso do ajax saber que foi um erro
        echo "0";
    }
	$i+=1;
?>