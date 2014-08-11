<?php include ("includes/conectar.php");?>
<?php

$id = $_GET["codigo"];
$sql = mysql_query("select * from geral WHERE ref_id = '$id'");
$dados = mysql_fetch_array($sql);

$nivelpes= $dados["nivel"];
include 'menu/tabela.php';
?>
<form id="form1" name="form1" method="post" action="salvar_edi_curso.php" onsubmit="return confirma(this)">
<input type="hidden" name="id" value="<?php echo $id; ?>" />

  <table width="430" border="0" align="center" class="full_table_cad">
        <td width="116">Matr&iacute;cula</td>
      <td width="304"><input name="nome" type="text" readonly="readonly" class="textBox" id="nome" value="<?php echo $dados["matricula"]; ?>" maxlength="100"/></td>
    </tr>
    <tr>
      <td>Grupo</td>
      <td><?php
			include('menu/config_drop.php');
		?>
		  <select name="grupo" id="grupo" onKeyPress="return arrumaEnter(this, event)">
		    <option value="<?php echo $dados["grupo"]; ?>"><?php echo ($dados["grupo"]); ?></option>
		    <?php
				$sql = "SELECT distinct grupo
						FROM grupos
						ORDER BY grupo";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.($row['grupo']).'">'.($row['grupo']).'</option>';
				}
			?></select></td>
    </tr>
    <tr>
      <td>Turno</td>
      <td><?php
			include('menu/config_drop.php');
		?>
		  <select name="turno" id="turno" onKeyPress="return arrumaEnter(this, event)">
		    <option value="<?php echo $dados["turno"]; ?>"><?php echo ($dados["turno"]); ?></option>
		    <?php
				$sql = "SELECT distinct turno
						FROM cursosead
						ORDER BY turno";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.($row['turno']).'">'.($row['turno']).'</option>';
				}
			?></select></td>
    </tr>
    <tr>
      <td>N&iacute;vel</td>
      <td>
		  <select name="nivel" id="nivel" onKeyPress="return arrumaEnter(this, event)">
		    <option value="<?php echo $dados["nivel"]; ?>">- Selecione o Nivel -</option>
		    <?php
				$sql = "SELECT distinct tipo
						FROM cursosead WHERE tipo NOT LIKE '%-%'
						ORDER BY tipo";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.($row['tipo']).'">'.($row['tipo']).'</option>';
				}
			?></select></td>
    </tr>
    <tr>
      <td>M&oacute;dulo</td>
      <td><select name="modulo" size="1" id="modulo" onKeyPress="return arrumaEnter(this, event)">
	      <option value="<?php echo $dados["modulo"]; ?>">Selecione...</option>
	      <option value="1">M&oacute;d. I</option>
	      <option value="2">M&oacute;d. II</option>
	      <option value="3">M&oacute;d. III</option></select></td>
    </tr>
    <tr>
      <td>Curso</td>
      <td>
		  <select name="curso" id="curso" onKeyPress="return arrumaEnter(this, event)">
		    <option value="<?php echo $dados["curso"]; ?>">- Selecione o Curso -</option>
		    <?php
				$sql = "SELECT distinct curso, tipo
						FROM cursosead WHERE tipo NOT LIKE '%-%'
						ORDER BY tipo";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.($row['curso']).'">'.($row['tipo']).": ".($row['curso']).'</option>';
				}
			?></select></td>
    </tr>

<tr>
      <td>Polo</td>
      <td>
		  <select name="polo" id="polo" onKeyPress="return arrumaEnter(this, event)">
		    <option value="<?php echo $dados["polo"]; ?>"><?php echo $dados["polo"]; ?></option>
		    <?php
				$sql = "SELECT distinct unidade
						FROM unidades
						ORDER BY unidade";
				$res = mysql_query( $sql );
				while ( $row = mysql_fetch_assoc( $res ) ) {
					echo '<option value="'.$row['unidade'].'">'.$row['unidade'].'</option>';
				}
			?></select></td>
    </tr>

    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" class="botao" value="SALVAR" style="cursor:pointer;"/></td>
    </tr>
  </table>

</form>
