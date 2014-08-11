<?php include 'menu/menu.php'?>
<html>
    <body>

<div class="conteudo">
<center><strong><font size="+1">Cadastro de Turma</font></strong></center>
<hr />

<div class="container_12"><br />

                <form action="salvar_turma.php" method="POST" onKeyPress="return arrumaEnter(this, event)">

                    <div class="grid_12">

                        <div class="grid_4">
                         <div class="input-prepend">
                                <span class="add-on">Grupo</span> <select name="grupo" style="width:auto;" id="grupo" onkeypress="return arrumaEnter(this, event)">
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT * FROM grupos";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . $row['grupo'] . "</option>";
}
?>
    </select></div>     
                       	  <div class="input-prepend">
                                <span class="add-on">Nível</span>
                                
     
                                <select name="nivel" style="width:auto;" id="nivel" onkeypress="return arrumaEnter(this, event)">
     
     <option value="NULL">SELECIONE O NÍVEL</option>
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT distinct tipo FROM cursosead WHERE tipo NOT LIKE '%-%' AND tipo NOT LIKE '%profissio%'";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['tipo'] . "'>" . $row['tipo'] . "</option>";
}
?>
    </select>                            </div>
                          
                         <div class="input-prepend">
                                <span class="add-on">Curso</span> <select name="curso" class="textBox" id="curso" onKeyPress="return arrumaEnter(this, event)">
    <option value="NULL">SELECIONE O CURSO</option>
      
      </select></div>
                          
                          
    <div class="input-prepend">
                                <span class="add-on">Unidade</span>
                                <select name="unidade" style="width:auto;" id="unidade" onkeypress="return arrumaEnter(this, event)">
      <?php
include("menu/config_drop.php");?>
      <?php
	  if($user_unidade ==""){
		$sql = "SELECT distinct unidade FROM unidades where categoria >0 OR unidade LIKE '%ead%'";
	  } else {
		  $sql = "SELECT distinct unidade FROM unidades where unidade LIKE '%$user_unidade%'";
	  }
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
    </select>                                                        </div>
    
        <div class="input-prepend">
                                <span class="add-on">Polo</span>
                                <select name="polo" style="width:auto;" id="polo" onkeypress="return arrumaEnter(this, event)">
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT distinct unidade FROM unidades where categoria >0";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['unidade'] . "'>" . $row['unidade'] . "</option>";
}
?>
    </select>                                                        </div>
    
    
<div class="input-prepend">
<span class="add-on">Módulo</span>
                                <select name="modulo" style="width:auto;" id="modulo" onkeypress="return arrumaEnter(this, event)">
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT distinct modulo FROM cursosead";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['modulo'] . "'>" . $row['modulo'] . "</option>";
}
?>
    </select>                                                        </div>

<div class="input-prepend">
<span class="add-on">Turno</span>
                                <select name="turno" style="width:auto;" id="turno" onkeypress="return arrumaEnter(this, event)">
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT distinct turno FROM cursosead";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" .  strtoupper(utf8_encode($row['turno'])) . "'>" . strtoupper(utf8_encode($row['turno'])) . "</option>";
}
?>
    </select>                                                        </div>    
    
<div class="input-prepend">
<span class="add-on">Ano / Grade</span>
                                <select name="grade" style="width:auto;" id="grade" onkeypress="return arrumaEnter(this, event)">
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT distinct anograde FROM disciplinas";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['anograde'] . "'>" . $row['anograde'] . "</option>";
}
?>
    </select>                                                        </div>
                            <div class="input-prepend">
                                <span class="add-on">Data de Ínicio</span>
                                <input id="inicio" required name="inicio" type="date" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                            <div class="input-prepend">
                                <span class="add-on">Data Final</span>
                                <input id="final" name="final" required type="date" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                          <div class="input-prepend">
                                <span class="add-on">Turma</span>
                                <select name="turma_sigla" style="width:auto;" id="turma_sigla" onkeypress="return arrumaEnter(this, event)">
                                  <option value="A" selected="selected">A</option>
                                  <option value="B">B</option>
                                  <option value="C">C</option>
                                  <option value="D">D</option>
                                  <option value="E">E</option>
                                  <option value="F">F</option>
                                  <option value="G">G</option>
                                  <option value="H">H</option>
                                  <option value="I">I</option>
                                  <option value="J">J</option>
                                  <option value="K">K</option>
                                  <option value="L">L</option>

                            </select> 
                          </div>
                            <input type="submit" name="Cadastrar" id="Cadastrar" value="Cadastrar">
                        </div>

                        <div class="grid_7 map" id="map1"></div>
                    </div>

                </form>  
                </div>
</div>   
                <?php include 'menu/footer.php' ?>     



<script language="javascript">
function arrumaEnter (field, event) {
var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
if (keyCode == 13) {
var i;
for (i = 0; i < field.form.elements.length; i++)
if (field == field.form.elements[i])
break;
i = (i + 1) % field.form.elements.length;
field.form.elements[i].focus();
return false;
}
else
return true;
}
</script>



<script src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
		  google.load('jquery', '1.3');
		  </script>
        </p>
	<p>&nbsp;</p>
	    <script type="text/javascript">
		$(function(){
			$('#nivel').change(function(){
				if( $(this).val() ) {
					$('#curso').hide();
					$('.carregando').show();
					$.getJSON('curso.ajax.php?search=',{nivel: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="NULL">SELECIONE O CURSO</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].cursoexib + '">' + j[i].cursoexib + '</option>';
						}	
						$('#curso').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#curso').html('<option value="NULL">SELECIONE O CURSO</option>');
				}
			});
		});
		</script>