<?php include 'menu/menu.php'; ?>
<div class="conteudo">
<?php 
include ("includes/conectar.php");
$get_unidade = $_GET['unidade'];
$get_grupo = $_GET['grupo'];
$get_modulo = $_GET['modulo'];
$get_modelo = $_GET['modelo'];
$get_nivel = $_GET['nivel'];

if($get_grupo == ""){
	$filtro_grupo = "WHERE ";
} else {
	$filtro_grupo = "WHERE grupo LIKE '$get_grupo' ";
}

if($get_modulo == ""){
	$filtro_modulo = "";
} else {
	$filtro_modulo = "AND modulo = '$get_modulo' ";
}

if($get_unidade == ""){
	$filtro_unidade = "";
} else {
	$filtro_unidade = "AND unidade LIKE '%$get_unidade%' ";
}

if($get_nivel == ""){
	$filtro_nivel = "";
} else {
	$filtro_nivel = "AND nivel LIKE '%$get_nivel%' ";
}
//gera o filtro completo
$filtro_completo = $filtro_grupo.$filtro_modulo.$filtro_unidade.$filtro_nivel;

//PEGA DADOS DO FILTRO
$sql_filtro = mysql_query("SELECT * FROM ced_filtro WHERE id_filtro = $get_modelo");
$dados_filtro = mysql_fetch_array($sql_filtro);
$filtro_tabela = $dados_filtro["tabela"];
$filtro_campos = $dados_filtro["campos"];
$filtro_cabecalho = $dados_filtro["cabecalho"];
$filtro_nome = $dados_filtro["layout"];
$filtro_ordem = $dados_filtro["ordem"];
$filtro_groupby = $dados_filtro["groupby"];

$sql = "SELECT $filtro_campos FROM $filtro_tabela $filtro_completo $filtro_groupby $filtro_ordem";
$sql_grafico = mysql_query($sql);

$total_span=mysql_num_fields($sql_grafico);
$sql2 = 0;//mysql_query("SELECT distinct codigo, curso FROM geral WHERE unidade LIKE '%$unidade%' AND grupo LIKE '%$grupo%'  AND modulo = '$modulo' AND nivel LIKE 'CURSO TECNICO'");
$qtd_sql = 0;//mysql_num_rows($sql2);

?>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
        data.addRows([

<?php
if($get_modelo ==6){
	$total_parcial = 0;
    while ($dados_grafico = mysql_fetch_array($sql_grafico)) {
        // enquanto houverem resultados...
		$curso          = format_curso($dados_grafico["Curso"]);
		$qtd_grupo          = $dados_grafico["Quantidade"];
		$qtd_total = $total_parcial + $qtd_grupo;
		$total_parcial = $qtd_total;
        echo "
		['$curso', $qtd_grupo],
		\n";
		
        // exibir a coluna nome e a coluna email
    }
}

if($get_modelo ==7){
	$total_parcial = 0;
    while ($dados_grafico = mysql_fetch_array($sql_grafico)) {
        // enquanto houverem resultados...
		$unidade          = format_curso($dados_grafico["Unidade"]);
		$qtd_grupo          = $dados_grafico["Quantidade"];
		$qtd_total = $total_parcial + $qtd_grupo;
		$total_parcial = $qtd_total;
        echo "
		['$unidade', $qtd_grupo],
		\n";
		
        // exibir a coluna nome e a coluna email
    }
}
?>
       
        ]);

        // Set chart options
        var options = {'title':'CEDTEC - MATRÍCULAS (<?PHP echo $get_nivel;?>): <?PHP echo $get_unidade;?> - <?php echo $get_grupo;?>',
                       'width':600,
                       'height':'330'};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>


    <!--Div that will hold the pie chart-->
    <div align="center" class="filtro"><a href="javascript:window.print()">[IMPRIMIR]</a></div>
    <div id="chart_div" align="center"> </div>
<div style="z-index:9999999">
<table class="full_table_list2" width="auto" align="center" border="1">
<tr> 
<td align="center" colspan="<?php echo $total_span;?>"><b style="font-size:14px"> <?php echo $filtro_nome;?></b>
</td></tr>

<tr>
<?php //colunas

$i = 0;
while ($i < mysql_num_fields($sql_grafico)){
	 $meta = mysql_fetch_field($sql_grafico, $i);
	 
	 echo 
	 "<td align=\"center\" bgcolor=\"#C0C0C0\"><b>".$meta->name."</b></td>";
	 $i++;

}
?>
</tr>

<?php //dados das linhas

$sql_grafico2 = mysql_query($sql);
while($dados_grafico2 = mysql_fetch_array($sql_grafico2)){
	echo "<tr>";
	$i2 =0;
	$total_parcial = 0;
	while ($i2 < mysql_num_fields($sql_grafico2)){
	 $meta2 = mysql_fetch_field($sql_grafico2, $i2);
	 //configurações do campo
	 
	 echo 
	 "<td align=\"center\">".format_curso($dados_grafico2[$meta2->name])."</td>";

	 $i2++;
	}
	echo "</tr>";
}
?>
<tr>
<td colspan="<?php echo $total_span;?>"><b>Total:</b> <?php echo $qtd_total;?></td>
</tr>
</table>



</div>    
    
    

    
</div>
    <?php include ('menu/footer.php'); ?>


 <script language='JavaScript'>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script> 