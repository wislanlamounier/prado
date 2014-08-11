<?php


	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	$con = mysql_connect( 'mysql1.cedtec.com.br', 'cedtecvi_pincel', 'BDPA2013ced' ) ;
	mysql_select_db( 'cedtecvi_pincel', $con );

	$unidade = mysql_real_escape_string( $_REQUEST['unidade'] );
	$trocarIsso = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ',);
	$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','O','U','U','U','Y',);
	$unidade2 = str_replace($trocarIsso, $porIsso, $unidade);
	$conta = array();
	session_start();
	$user_unidade = $_SESSION["MM_unidade"];
	
	
	$sql = "SELECT * FROM contas WHERE conta LIKE '%$unidade2%' AND conta LIKE '%$user_unidade%' ORDER BY conta";
	$res = mysql_query( $sql );
	while ( $row = mysql_fetch_array( $res ) ) {
		$conta[] = array(
			'ref_conta'			=> $row['ref_conta'],
			'conta'			=> utf8_encode($row['conta']),
			
		);
	}

	echo( json_encode( $conta ) );
	
	?>