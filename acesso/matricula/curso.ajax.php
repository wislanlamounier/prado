<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="utf-8"', true );

	$con = mysql_connect( 'mysql1.cedtec.com.br', 'cedtecvi_pincel', 'BDPA2013ced' ) ;
	mysql_select_db( 'cedtecvi_pincel', $con );

	$unidade = mysql_real_escape_string( $_REQUEST['unidade'] );

	$curso2 = array();

	$sql = "SELECT * FROM cursosead WHERE unidade LIKE '%$unidade%' AND programa LIKE '0' ORDER BY tipo";
	$res = mysql_query( $sql );
	while ( $row = mysql_fetch_array( $res ) ) {
		$curso2[] = array(
		    'cod_curso'			=> $row['codigo'],
			'fiador'			=> $row['fiador'],
			'tipo'			=> utf8_encode($row['tipo']),
			'curso2'			=> utf8_encode($row['curso'].' | '.utf8_encode($row['turno'])),
			
		);
	}

	echo( json_encode( $curso2 ) );