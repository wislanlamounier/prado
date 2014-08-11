<?php
	header( 'Cache-Control: no-cache' );
	header( 'Content-type: application/xml; charset="ISO-8859-1"', true );

	$con = mysql_connect( 'mysql1.cedtec.com.br', 'cedtecvi_pincel', 'BDPA2013ced' ) ;
	mysql_select_db( 'cedtecvi_pincel', $con );

	$tipo = mysql_real_escape_string($_REQUEST['tipo']);
	$tipo2 = substr($tipo,0,5);
	$curso = array();
	$sql = "SELECT distinct curso FROM cursosead WHERE tipo LIKE '%$tipo2%' ORDER BY curso";
	$res = mysql_query( $sql );
	while ( $row = mysql_fetch_array( $res ) ) {
		$curso[] = array(
			'curso'			=> utf8_encode($row['curso'])
			
		);
	}

	echo( json_encode( $curso ) );
	
	
	?>
	
    
    