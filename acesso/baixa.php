
<?php include ('menu/menu.php');?>
<div class="conteudo">
<center><strong><font size="+1">Arquivo Retorno</font></strong></center>
<hr />
<form id="form1" name="form1" enctype="multipart/form-data" method="post"  onsubmit="validarAction(this);return false;">
<p>Banco: </select>  
           <select name="tipo" id="tipo" onKeyPress="return arrumaEnter(this, event)" onchange="validar(this.checked)">
		    <option value="baixa.php" selected="selected">BANCO DE RETORNO</option>
            <option value="ler.php">021 - BANESTES</option>
            <option value="ler_santander.php">033 - SANTANDER</option>
           
		   
                            </select>   </p>
<p>Selecione o arquivo retorno para leitura.</p>

  <input type="file" name="arq" id="arq" />
  <input type="submit" name="Enviar" id="Enviar" value="Enviar" />
</form>
</div>
<?php include ('menu/footer.php');?>


 <script language='JavaScript'>
function validarAction(frm){
   frm.action = frm.tipo.value;
   frm.submit();
}
  </script>