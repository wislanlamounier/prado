<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	$con = mysql_connect( 'mysql1.cedtec.com.br', 'cedtecvi_pincel', 'BDPA2013ced' ) ;
	mysql_select_db( 'cedtecvi_pincel', $con );

	$cc4 = mysql_real_escape_string( $_REQUEST['cc4'] );
	$cc5 = array();

	$sql = "SELECT * FROM cc5 WHERE id_cc5 = '$cc4' ORDER BY nome_cc5";
	$res = mysql_query( $sql );
	while ( $row = mysql_fetch_array( $res ) ) {
		$cc5[] = array(
			'cc5'			=> $row['cc5'],
			'nome_cc5'			=> utf8_encode($row['nome_cc5']),
			
		);
	}

	echo( json_encode( $cc5 ) );
	
	
	?>