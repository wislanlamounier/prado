<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	$con = mysql_connect( 'mysql1.cedtec.com.br', 'cedtecvi_pincel', 'BDPA2013ced' ) ;
	mysql_select_db( 'cedtecvi_pincel', $con );

	$cc3 = mysql_real_escape_string( $_REQUEST['cc3'] );
	$cc4 = array();

	$sql = "SELECT * FROM cc4 WHERE cc4 LIKE '$cc3%' ORDER BY nome_cc4";
	$res = mysql_query( $sql );
	while ( $row = mysql_fetch_array( $res ) ) {
		$cc4[] = array(
			'cc4'			=> $row['cc4'],
			'nome_cc4'			=> utf8_encode($row['nome_cc4']),
			
		);
	}

	echo( json_encode( $cc4 ) );
	
	
	?>