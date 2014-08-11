<?php include 'menu/menu.php' ;?>

<div class="conteudo">
<?php

$id = $user_usuario;


$re    = mysql_query("select count(*) as total from geral WHERE codigo = $id" );	
$total = 1;

if($total == 1) {
	$re    = mysql_query("select * from geral WHERE codigo LIKE '$id'");
	$dados = mysql_fetch_array($re);	
	$pesq = mysql_query("select * from geral WHERE codigo = '$id'" );
}
$nome = strtoupper($dados["nome"]);
?>

  
    
	    <script type="text/javascript">
		$(function(){
			$('#modal').change(function(){
				if( $(this).val() ) {
					$('#unidade').hide();
					$('#curso2').html('');
					$('.carregando').show();
					$.getJSON('unidade.ajax.php?search=',{modal: $(this).val(), ajax: 'true'}, function(j){
						var options = '<option value="selecione">– Escolha o Polo –</option>';	
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].sigla + '">' + j[i].unidade + '</option>';
						}	
						$('#unidade').html(options).show();
						$('.carregando').hide();
					});
				} else {
					$('#unidade').html('<option value="selecione">– Escolha o Polo –</option>');
				}
			});
		});
		</script>
       
        <script type="text/javascript">
		$(function(){
			$('#unidade').change(function(){
				if( $(this).val() ) {
					$('#curso2').hide();
					$('.carregando').show();
					$.getJSON('curso.ajax.php?search=',{unidade: $(this).val(), ajax: 'true'}, function(j){
						var options = '';
						for (var i = 0; i < j.length; i++) {
							options += '<option value="' + j[i].curso + '">'+ j[i].tipo + ': ' + j[i].curso + '</option>';
						}	
						$('#curso2').html(options).show();
						$('.carregando').hide();

					});
				} else {
					$('#curso2').html('<option value="selecione">– Escolha o Curso –</option>');
				}
			});
		});
		</script>
        





<div class="container_12">


                <form action="a_salvar_rematricula.php" name="formulario" id="formulario" method="POST" onKeyPress="return arrumaEnter(this, event)">

                    <div class="grid_12">

                        <div class="grid_4">
                        
                        <input name="id" type="hidden" id="id" placeholder="Insira o seu e-mail" required value="<?php echo $_GET["id"]; ?>"onKeyPress="return arrumaEnter(this, event)"/>
                        <input name="ref_curso" type="hidden" id="ref_curso" placeholder="Insira o seu e-mail" required value="<?php echo $_GET["ref"]; ?>"onKeyPress="return arrumaEnter(this, event)"/>
                        	
         <br>                   
<table width="100%" border="0" class="full_table_list2" align="center">
  <tr> 
  <td colspan="2" bgcolor="#CCCCCC"><center><strong>Dados do Aluno</strong></center></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Nome</span>
                                <input name="nome" type="text" readonly id="nome" placeholder="Nome Completo" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)" value="<?php echo $dados["nome"]; ?>"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">E-mail</span>
                                <input name="email" type="text" id="email" placeholder="Insira o seu e-mail" required value="<?php echo strtolower($dados["email"]); ?>"onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">RG</span>
                                <input name="rg" type="text" id="rg" readonly placeholder="Insira o Seu RG" required value="<?php echo $dados["rg"]; ?>" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">CPF</span>
                                <input name="cpf" type="text" id="cpf" readonly placeholder="Insira o Seu CPF" required value="<?php echo $dados["cpf"]; ?>" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Data de Nascimento</span>
                                <input name="nascimento" type="text" readonly id="nascimento" placeholder="Data de Nascimento" required value="<?php echo $dados["nascimento"]; ?>" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Estado Civil</span>
                                <select name="civil" size="1" id="civil" onKeyPress="return arrumaEnter(this, event)">
	      <option value="<?php echo $dados["civil"]; ?>"><?php echo $dados["civil"]; ?></option>
	      <option value="Casado">Casado</option>
	      <option value="Divorciado">Divorciado</option>
	      <option value="Solteiro">Solteiro</option></select>
	      
                            </div></td>
  </tr>
  <tr>
  <td><div class="input-prepend">
                                <span class="add-on">Telefone</span>
                                <input id="telefone" name="telefone" type="text" value="<?php echo $dados["telefone"]; ?>" placeholder="Informe o Telefone" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
  </td>
  <td><div class="input-prepend">
                                <span class="add-on">Celular</span>
                                <input id="celular" name="celular" type="text" value="<?php echo $dados["celular"]; ?>" placeholder="Informe o Nº do seu celular" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
 <tr>
   <td><div class="input-prepend">
                                <span class="add-on">Nacionalidade</span>
                                <input name="nacionalidade" readonly type="text" id="nacionalidade" value="<?php echo $dados["nacionalidade"]; ?>" placeholder="Nacionalidade do Aluno" style="text-transform:uppercase" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Nome do Pai</span>
                                <input name="pai" type="text" required id="pai" value="<?php echo $dados["pai"]; ?>" placeholder="Nome do Pai" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
  </td>
  </tr>
  <tr>
  
  <td><div class="input-prepend">
                                <span class="add-on">Nome da Mãe</span>
                                <input name="mae" type="text" id="mae" value="<?php echo $dados["mae"]; ?>" placeholder="Nome do Mãe" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
   

  
  <tr> 
  <td colspan="2" bgcolor="#CCCCCC"><center>
    <strong>Endere&ccedil;o do Aluno</strong>
  </center></td>
  </tr>
  <tr>
    <td height="28"><div class="input-prepend cep-label">
                                <span class="add-on">CEP</span>
                                <input id="cep" name="cep" type="text" maxlength="9" value="<?php echo $dados["cep"]; ?>" placeholder="Informe o CEP" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">UF</span>
                                <input id="uf" name="uf" type="text" value="<?php echo $dados["uf"]; ?>" placeholder="Informe a UF" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Cidade</span>
                                <input id="cidade" name="cidade" type="text" value="<?php echo $dados["cidade"]; ?>" placeholder="Informe a Cidade" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td></td>
  </tr>
<tr>
<td><div class="input-prepend">
                                <span class="add-on">Bairro</span>
                                <input id="bairro" name="bairro" type="text" value="<?php echo $dados["bairro"]; ?>" placeholder="Informe o Bairro" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td></td>
</tr>
<tr>
<td><div class="input-prepend">
                                <span class="add-on">Rua</span>
                                <input id="rua" name="rua" type="text" value="<?php echo $dados["endereco"]; ?>" placeholder="Nome da Rua / Logradouro" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/><input id="num" name="num" type="text" value="" placeholder="Nº" style="text-transform:uppercase; width:30px;" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td></td>
</tr>
<tr>
<td><div class="input-prepend">
                                <span class="add-on">Complemento</span>
                                <input id="complemento" name="complemento" value="<?php echo $dados["complemento"]; ?>" type="text" placeholder="Complemento" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td></td>
</tr>




<tr>
<td colspan="2" align="center">
                            <input type="submit" name="Cadastrar" id="Cadastrar" value="Confirmar Dados">
                            </td></tr>
                            
                            </table>
                        </div>

                        <div class="grid_7 map" id="map1"></div>
                    </div>

                </form>      
		</div>
        		</div>
                
<?php include 'menu/footer.php' ;?>

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

</div>
</body>
</html>