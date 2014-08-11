
<table width="100%">
<tr>
<td bgcolor="#6C6C6C">
<a href="javascript:window.close()" style="color:#FFF" title="Fechar" >Fechar</a>

<tr>
<td> 
<?php
include('includes/conectar.php');
include('menu/funcoes.php');
$turma_disc = $_GET["turma_disc"];
$sql_turma_disciplinas = mysql_query("SELECT ct.id_turma, ct.grupo, ctd.ano_grade, ctd.disciplina, ctd.codigo as turma_disc, d.nivel, d.curso, d.modulo FROM ced_turma_disc ctd
INNER JOIN ced_turma ct
ON ct.id_turma = ctd.id_turma
INNER JOIN disciplinas d
ON ct.anograde = d.anograde AND d.cod_disciplina = ctd.disciplina
WHERE ctd.codigo = '$turma_disc'");
$dados_turma = mysql_fetch_array($sql_turma_disciplinas);
$grupo = $dados_turma["grupo"];
$curso = $dados_turma["curso"];
$nivel = $dados_turma["nivel"];
$modulo = $dados_turma["modulo"];

function MostreSemanas()
{
	$semanas = "DSTQQSS";
 
	for( $i = 0; $i < 7; $i++ )
	 echo "<td bgcolor=\"#6C6C6C\" align=\"center\"><font size=\"+3\" color=\"white\">".$semanas{$i}."</font></td>";
 
}
 
function GetNumeroDias( $mes )
{
	$numero_dias = array( 
			'01' => 31, '02' => 28, '03' => 31, '04' =>30, '05' => 31, '06' => 30,
			'07' => 31, '08' =>31, '09' => 30, '10' => 31, '11' => 30, '12' => 31
	);
 
	if (((date('Y') % 4) == 0 and (date('Y') % 100)!=0) or (date('Y') % 400)==0)
	{
	    $numero_dias['02'] = 29;	// altera o numero de dias de fevereiro se o ano for bissexto
	}
 
	return $numero_dias[$mes];
}
 
function GetNomeMes( $mes )
{
     $meses = array( '01' => "Janeiro", '02' => "Fevereiro", '03' => "Março",
                     '04' => "Abril",   '05' => "Maio",      '06' => "Junho",
                     '07' => "Julho",   '08' => "Agosto",    '09' => "Setembro",
                     '10' => "Outubro", '11' => "Novembro",  '12' => "Dezembro"
                     );
 
      if( $mes >= 01 && $mes <= 12)
        return $meses[$mes];
 
        return "Mês deconhecido";
 
}
 
 
 
function MostreCalendario( $mes  )
{
 
	$numero_dias = GetNumeroDias( $mes );	// retorna o número de dias que tem o mês desejado
	$nome_mes = GetNomeMes( $mes );
	$diacorrente = 0;	
 	$ano = date('Y');
	$diasemana = jddayofweek( cal_to_jd(CAL_GREGORIAN, $mes,"01",date('Y')) , 0 );	// função que descobre o dia da semana
 
	echo "<table border = 1 width=\"100%\" cellspacing = '0' align = 'center'>";
	 echo "<tr>";
         echo "<td colspan = 7 bgcolor=\"#6C6C6C\"><font size='+3' color='white'>".$nome_mes."/".date('Y')."</font></h3></td>";
	 echo "</tr>";
	 echo "<tr>";
	   MostreSemanas();	// função que mostra as semanas aqui
	 echo "</tr>";
	for( $linha = 0; $linha < 6; $linha++ )
	{
 
 
	   echo "<tr>";
 
	   for( $coluna = 0; $coluna < 7; $coluna++ )
	   {
		echo "<td width = 20 height = 20 ";
 
		  if( ($diacorrente == ( date('d') - 1) && date('m') == $mes) )
		  {	
			   echo " id = 'dia_atual' ";
		  }
		  else
		  {
			     if(($diacorrente + 1) <= $numero_dias )
			     {
			         if( $coluna < $diasemana && $linha == 0)
				 {
					echo " id = 'dia_branco' ";
				 }
				 else
				 {
				  	echo " id = 'dia_comum' ";
				 }
			     }
			     else
			     {
				echo " ";
			     }
		  }
		echo " align = \"center\" valign = \"center\"";
 
 
		   /* TRECHO IMPORTANTE: A PARTIR DESTE TRECHO É MOSTRADO UM DIA DO CALENDÁRIO (MUITA ATENÇÃO NA HORA DA MANUTENÇÃO) */
 
		      if( $diacorrente + 1 <= $numero_dias )
		      {
				  
			 if( $coluna < $diasemana && $linha == 0)
			 {
			  	 echo " ";
			 }
			 else
			 {
				$p_data_evento = date("Y-m-").$diacorrente;
				 $sql_calendario_exib = mysql_query("SELECT * FROM ea_calendario WHERE grupo LIKE '$grupo' AND nivel LIKE '%$nivel%' AND curso LIKE '%$curso%' AND modulo LIKE '$modulo' AND data_evento LIKE '$p_data_evento' ORDER BY data_evento ASC LIMIT 1");
				 $dados_calendario_exib = mysql_fetch_array($sql_calendario_exib);
				 $tipo_evento = $dados_calendario_exib["tipo_evento"];
				 if($diacorrente +1 == date("d")){
			  	// echo "<input type = 'button' id = 'dia_comum' name = 'dia".($diacorrente+1)."'  value = '".++$diacorrente."' onclick = "acao(this.value)">";
				
				   echo "bgcolor=\"#ccc\"><a href =\"inf_calendario.php?turma_disc=".$_SESSION["turma_disc"]."&mes=$mes&ano=$ano&dia=".($diacorrente+1)."\"><font size=\"+3\" color=\"green\"><b>[".++$diacorrente .$tipo_evento. "]</b></font></a>";
				 } else {
					 echo "><a href =\"inf_calendario.php?turma_disc=".$_SESSION["turma_disc"]."&ano=$ano&mes=$mes&dia=".($diacorrente+1)."\"><font size=\"+3\">".++$diacorrente.$tipo_evento. "</font></a>";
				  
				 }
			 }
		      }
		      else
		      {
			break;
		      }
 
		   /* FIM DO TRECHO MUITO IMPORTANTE */
 
 
 
		echo "</td>";
	   }
	   echo "</tr>";
	}
 
	echo "</table>";
}
 
function MostreCalendarioCompleto()
{
	    echo "<table align = \"center\">";
	    $cont = 1;
	    for( $j = 0; $j < 4; $j++ )
	    {
		  echo "<tr>";
		for( $i = 0; $i < 3; $i++ )
		{
		 
		  echo "<td>";
			MostreCalendario( ($cont < 10 ) ? "0".$cont : $cont );  
 
		        $cont++;
		  echo "</td>";
 
	 	}
		echo "</tr>";
	   }
	   echo "</table>";
}
 $mes_ano_atual = date("Y-m-");
MostreCalendario(date("m"));
?>
</td>
</tr>

</table>
<table width="100%" border="1">
<tr bgcolor="#CCCCCC">
	<td align="center"><b>Evento</b></td>
    <td align="center"><b>Data</b></td>
    <td align="center"><b>Descrição</b></td>
</tr>
<?php
$sql_calendario = mysql_query("SELECT * FROM ea_calendario WHERE grupo LIKE '$grupo' AND nivel LIKE '%$nivel%' AND curso LIKE '%$curso%' AND modulo LIKE '$modulo' AND tipo_evento > 1 AND data_evento LIKE '%$mes_ano_atual%' ORDER BY data_evento ASC");
while($dados_calendario = mysql_fetch_array($sql_calendario)){
	$evento_tipo = $dados_calendario["tipo_evento"];
	$evento_data = format_data($dados_calendario["data_evento"]);
	$evento_desc = $dados_calendario["evento"];	
	echo "
	<tr>
	<td align=\"center\">$evento_tipo</td>
    <td align=\"center\">$evento_data</td>
    <td>$evento_desc
	</td>
</tr>
	";
}

?>

</table>


<script type='text/javascript'>document.write('<style>.texthidden {display:none} </style>');</script>
<script type='text/Javascript'>
function expandcollapse (postid) 
{whichpost = document.getElementById(postid);
if (whichpost.className=="shown") 
{
	whichpost.className="texthidden";
}else {
var r = confirm("Deseja acessar o link?");
if (r == true) {
    x = "Você selecionou OK";
} else {
    x = "Você cancelou!";
}
	whichpost.className="shown";
}


}</script>
