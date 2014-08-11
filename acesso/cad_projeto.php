<?php include 'menu/menu.php'?>

<div class="conteudo">
<center><strong><font size="+1">Cadastro de Projeto</font></strong></center>
<hr />
<div class="container_12"><br />

                <form action="salvar_proj.php" method="POST" onKeyPress="return arrumaEnter(this, event)">

                    <div class="grid_12">

                        <div class="grid_4">
                         <div class="input-prepend">
                                <span class="add-on">Empresa</span> <select name="empresa" style="width:auto;" id="empresa" onkeypress="return arrumaEnter(this, event)">
      <?php
include("menu/config_drop.php");?>
      <?php
$sql = "SELECT * FROM cc1";
$result = mysql_query($sql);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['id_empresa'] . "'>" . $row['nome_cc1'] . "</option>";
}
?>
    </select></div>     
                       	  <div class="input-prepend">
                                <span class="add-on">Nome</span>
                                <input id="nome" name="nome" type="text" placeholder="Nome do Projeto" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                          
                            <div class="input-prepend">
                                <span class="add-on">Valor</span>
                                <input id="valor" required name="valor" type="text"  onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                            <div class="input-prepend">
                                <span class="add-on">Data de &Iacute;nicio</span>
                                <input id="inicio" required name="inicio" type="date" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                            <div class="input-prepend">
                                <span class="add-on">Data Final</span>
                                <input id="final" name="final" required type="date" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                            <div class="input-prepend">
                                <span class="add-on">Descri&ccedil;&atilde;o</span>
                                <textarea name="desc" cols="30" rows="10" class="ckeditor" id="desc" onKeyPress="return arrumaEnter(this, event)"></textarea>
                            </div>
                          <input id="tipo" name="tipo" type="hidden" placeholder="TIPO" required onKeyPress="return arrumaEnter(this, event)" value="2"/>
                            
                            <input type="submit" name="Cadastrar" id="Cadastrar" value="Cadastrar">
                        </div>

                        <div class="grid_7 map" id="map1"></div>
                    </div>

                </form>   
</div></div>
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