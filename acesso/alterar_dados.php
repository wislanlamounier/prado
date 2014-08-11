<?php
include('includes/conectar.php');
include('menu/tabela.php');
$id = $_GET["id"];


$re    = mysql_query("select count(*) as total from geral WHERE codigo = $id" );	
$total = 1;

if($total == 1) {
	$re    = mysql_query("select * from geral WHERE codigo LIKE $id");
	$dados = mysql_fetch_array($re);	
	$pesq = mysql_query("select * from geral WHERE codigo = $id" );
}
$nome = strtoupper($dados["nome"]);
?>
        <div class="container_12">


                <form action="salvar_dados.php" name="formulario" id="formulario" method="POST" onKeyPress="return arrumaEnter(this, event)">

                    <div class="grid_12">

                        <div class="grid_4">
                        
                        <input name="id" type="hidden" id="id" placeholder="Insira o seu e-mail" required value="<?php echo strtolower($dados["codigo"]); ?>"onKeyPress="return arrumaEnter(this, event)"/>

                        	
         <br>                   
<table width="100%" border="0">
  <tr> 
  <td colspan="2" bgcolor="#CCCCCC"><center><strong>Dados do Aluno</strong></center></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Nome</span>
                                <input name="nome" type="text" id="nome" placeholder="Nome Completo" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)" value="<?php echo $dados["nome"]; ?>"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">E-mail</span>
                                <input name="email" type="text" id="email" placeholder="Insira o seu e-mail" required value="<?php echo strtolower($dados["email"]); ?>"onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">RG</span>
                                <input name="rg" type="text" id="rg" placeholder="Insira o Seu RG" required value="<?php echo $dados["rg"]; ?>" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">CPF</span>
                                <input name="cpf" type="text" id="cpf" placeholder="Insira o Seu CPF" required value="<?php echo $dados["cpf"]; ?>" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Data de Nascimento</span>
                                <input name="nascimento" type="text" id="nascimento" placeholder="Data de Nascimento" required value="<?php echo $dados["nascimento"]; ?>" onKeyPress="return arrumaEnter(this, event)"/>
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
                                <input name="nacionalidade" type="text" id="nacionalidade" value="<?php echo $dados["nacionalidade"]; ?>" placeholder="Nacionalidade do Aluno" style="text-transform:uppercase" required onKeyPress="return arrumaEnter(this, event)"/>
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
  <td colspan="2" bgcolor="#CCCCCC"><center>
    <strong>Dados do Respons&aacute;vel Financeiro</strong>
  </center></td>
  </tr>
 
  
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Nome</span>
                                <input name="nome_fin" type="text" id="nome_fin" placeholder="Nome Completo do Responsável Financeiro" value="<?php echo $dados["nome_fin"]; ?>" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Data de Nascimento</span>
                                <input name="nasc_fin" type="text" id="nasc_fin" placeholder="Data de Nascimento" value="<?php echo $dados["nasc_fin"]; ?>" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">CPF</span>
                                <input name="cpf_fin" type="text" id="cpf_fin" placeholder="CPF do Responsável Financeiro" value="<?php echo $dados["cpf_fin"]; ?>" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">RG</span>
                                <input name="rg_fin" type="text" id="rg_fin" placeholder="RG do Responsável Financeiro" value="<?php echo $dados["rg_fin"]; ?>" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  
  
  
  
  <tr>
    <td height="28"><div class="input-prepend">
                                <span class="add-on">CEP</span>
                                <input id="cep_fin" name="cep_fin" type="text" maxlength="9" placeholder="Informe o CEP" value="<?php echo $dados["cep_fin"]; ?>" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Rua</span>
                                <input id="rua_fin" name="rua_fin" type="text" placeholder="Nome da Rua / Logradouro" value="<?php echo $dados["end_fin"]; ?>" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/><input id="num_fin" name="num_fin" type="text" value="" placeholder="Nº" style="text-transform:uppercase; width:30px;" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Cidade</span>
                                <input id="cidade_fin" name="cidade_fin" type="text" placeholder="Informe a Cidade" value="<?php echo $dados["cidade_fin"]; ?>" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td><div class="input-prepend">
                                <span class="add-on">UF</span>
                                <input id="uf_fin" name="uf_fin" type="text" placeholder="Informe a UF" value="<?php echo $dados["uf_fin"]; ?>" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
<tr>

<td><div class="input-prepend">
                                <span class="add-on">Bairro</span>
                                <input id="bairro_fin" name="bairro_fin" type="text" value="<?php echo $dados["bairro_fin"]; ?>" placeholder="Informe o Bairro" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
                            
<td><div class="input-prepend">
                                <span class="add-on">Telefone</span>
                                <input id="tel_fin" name="tel_fin" type="text" value="<?php echo $dados["tel_fin"]; ?>" placeholder="Telefone do Responsável Financeiro" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
  
  
<tr>
<td><div class="input-prepend">
                                <span class="add-on">Complemento</span>
                                <input id="comp_fin" name="comp_fin" type="text" value="<?php echo $dados["comp_fin"]; ?>" placeholder="Complemento" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>

<td><div class="input-prepend">
                                <span class="add-on">Nacionalidade</span>
                                <input id="nacio_fin" name="nacio_fin" type="text" value="<?php echo $dados["nacio_fin"]; ?>" placeholder="Nacionalidade" required style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
  
  
<tr>
<td><div class="input-prepend">
                                <span class="add-on">E-mail</span>
                                <input id="email_fin" name="email_fin" type="text" placeholder="E-mail do Responsável Financeiro" value="<?php echo strtolower($dados["email_fin"]); ?>" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
                            
</tr>

  
<tr> 
  <td colspan="2" bgcolor="#CCCCCC"><center>
    <strong>Dados do Fiador (Se Necessário)</strong>
  </center></td>
  </tr>
  
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Nome</span>
                                <input name="nome_fia" type="text" id="nome_fia" value="<?php echo $dados["nome_fia"]; ?>" placeholder="Nome Completo do Fiador" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Data de Nascimento</span>
                                <input name="nasc_fia" type="text" id="nasc_fia" value="<?php echo $dados["nasc_fia"]; ?>" placeholder="Data de Nascimento" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">CPF</span>
                                <input name="cpf_fia" type="text" id="cpf_fia" value="<?php echo $dados["cpf_fia"]; ?>" placeholder="CPF do Fiador" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">RG</span>
                                <input name="rg_fia" type="text" id="rg_fia" value="<?php echo $dados["rg_fia"]; ?>" placeholder="RG do Fiador" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  
  <tr>
    <td height="28"><div class="input-prepend">
                                <span class="add-on">CEP</span>
                                <input id="cep_fia" name="cep_fia" type="text" maxlength="9" value="<?php echo $dados["cep_fia"]; ?>" placeholder="Informe o CEP" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Rua</span>
                                <input id="rua_fia" name="rua_fia" type="text" value="<?php echo $dados["end_fia"]; ?>" placeholder="Nome da Rua / Logradouro" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/><input id="num_fia" name="num_fia" type="text" value="" placeholder="Nº" style="text-transform:uppercase; width:30px;" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">Cidade</span>
                                <input id="cidade_fia" name="cidade_fia" type="text" value="<?php echo $dados["cidade_fia"]; ?>" placeholder="Informe a Cidade" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td><div class="input-prepend">
                                <span class="add-on">UF</span>
                                <input id="uf_fia" name="uf_fia" type="text" value="<?php echo $dados["uf_fia"]; ?>" placeholder="Informe a UF" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
<tr>

<td><div class="input-prepend">
                                <span class="add-on">Bairro</span>
                                <input id="bairro_fia" name="bairro_fia" value="<?php echo $dados["bairro_fia"]; ?>" type="text" placeholder="Informe o Bairro" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td><div class="input-prepend">
                                <span class="add-on">Nacionalidade</span>
                                <input id="nacio_fia" name="nacio_fia" type="text" value="<?php echo $dados["nacio_fia"]; ?>" placeholder="Nacionalidade" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
</tr>
  

<tr>
<td><div class="input-prepend">
                                <span class="add-on">Telefone</span>
                                <input id="tel_fia" name="tel_fia" type="text" value="<?php echo $dados["tel_fia"]; ?>" placeholder="Telefone do Fiador" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
<td><div class="input-prepend">
                                <span class="add-on">E-mail</span>
                                <input id="email_fia" name="email_fia" value="<?php echo $dados["email_fia"]; ?>" type="text" placeholder="E-mail do Fiador" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
                            
</tr>

<tr>
    <td><div class="input-prepend">
                                <span class="add-on">Cônjuge</span>
                                <input name="nome_conj" type="text" id="nome_conj" value="<?php echo $dados["nome_conj"]; ?>" placeholder="Cônjuge do Fiador" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">Data de Nascimento</span>
                                <input name="nasc_conj" type="text" id="nasc_conj"value="<?php echo $dados["nasc_conj"]; ?>" placeholder="Data de Nascimento" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
    <td><div class="input-prepend">
                                <span class="add-on">CPF</span>
                                <input name="cpf_conj" type="text" id="cpf_conj" value="<?php echo $dados["cpf_conj"]; ?>" placeholder="CPF do Cônjuge" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
    <td><div class="input-prepend">
                                <span class="add-on">RG</span>
                                <input name="rg_conj" type="text" id="rg_conj" value="<?php echo $dados["rg_conj"]; ?>" placeholder="RG do Cônjuge" onKeyPress="return arrumaEnter(this, event)"/>
                            </div></td>
  </tr>
  <tr>
   <td><div class="input-prepend">
                                <span class="add-on">Nacionalidade</span>
                                <input name="nacio_conj" type="text" id="nacio_conj" value="<?php echo $dados["nacio_conj"]; ?>" placeholder="Nacionalidade do Cônjuge" style="text-transform:uppercase" onKeyPress="return arrumaEnter(this, event)"/>
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