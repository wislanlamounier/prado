<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	$con = mysql_connect( 'mysql1.cedtec.com.br', 'cedtecvi_pincel', 'BDPA2013ced' ) ;
	mysql_select_db( 'cedtecvi_pincel', $con );

	$nivel = mysql_real_escape_string( $_REQUEST['nivel'] );
	$curso = array();
	$trocarIsso = array('à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ù','ü','ú','ÿ','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ñ','Ò','Ó','Ô','Õ','Ö','O','Ù','Ü','Ú','Ÿ',);
	$porIsso = array('a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','u','u','u','y','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','N','O','O','O','O','O','O','U','U','U','Y',);
	$nivel2 = str_replace($trocarIsso, $porIsso, $nivel);
	$sql = "SELECT distinct curso FROM cursosead WHERE tipo like '%$nivel2%' AND curso NOT LIKE '%profiss%' ORDER BY curso";
	$res = mysql_query( $sql );
	while ( $row = mysql_fetch_array( $res ) ) {
		$curso[] = array(
			'curso'			=> $row['curso'],
			'cursoexib'			=> utf8_encode(strtoupper($row['curso']))
			
		);
	}

	echo( json_encode( $curso ) );
	
	
	?>