<?php include 'menu/menu.php'?>
<div class="conteudo">
<center><strong><font size="+1">Cadastro de Cliente / Fornecedor</font></strong></center>
<hr />

<div class="container_12"><br />

                <form action="salvar_forn.php" method="POST" onKeyPress="return arrumaEnter(this, event)">

                    <div class="grid_12">

                        <div class="grid_4">
                                               
                       	  <div class="input-prepend">
                                <span class="add-on">Nome</span>
                                <input id="nome" name="nome" type="text" placeholder="Informe o Nome" required onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                          <div class="input-prepend">
                                <span class="add-on">Nome Fantasia</span>
                                <input id="fantasia" name="fantasia" type="text" placeholder="Nome Fantasia (se houver)" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                            <div class="input-prepend">
                                <span class="add-on">CNPJ/CPF</span>
                                <input id="cpf" name="cpf" type="text" placeholder="Informe o CNPJ/CPF" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                            <div class="input-prepend">
                                <span class="add-on">E-mail</span>
                                <input id="email" name="email" type="text" placeholder="Informe o E-mail" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                            <div class="input-prepend">
                                <span class="add-on">Telefone</span>
                                <input id="tel" name="tel" type="text" placeholder="Informe o Telefone" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                            <div class="input-prepend">
                                <span class="add-on">Telefone 2</span>
                                <input id="tel2" name="tel2" type="text" placeholder="Informe Outro Telefone" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                            <div class="input-prepend">
                                <span class="add-on">RG</span>
                                <input id="rg" name="rg" type="text" placeholder="Informe o RG" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                       
                            
                            
                            
                            <div class="input-prepend cep-label">
                                <span class="add-on">CEP</span>
                                <input id="cep" name="cep" type="text" maxlength="9" placeholder="Informe o CEP" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>

                            <div class="input-prepend">
                                <span class="add-on">Rua</span>
                                <input id="rua" name="rua" type="text" placeholder="Nome da Rua / Logradouro" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>

                            <div class="input-prepend">
                                <span class="add-on">N&ordm;</span>
                                <input id="num" name="num" type="text" placeholder="Número" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>

                            <div class="input-prepend">
                                <span class="add-on">Bairro</span>
                                <input id="bairro" name="bairro" type="text" placeholder="Informe o Bairro" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
							<div class="input-prepend">
                                <span class="add-on">Complemento</span>
                                <input id="comp" name="comp" type="text" placeholder="Complemento" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>
                            <div class="input-prepend">
                                <span class="add-on">Cidade</span>
                                <input id="cidade" name="cidade" type="text" placeholder="Informe a Cidade" onKeyPress="return arrumaEnter(this, event)"/>
                            </div>

                            <div class="input-prepend">
                                <span class="add-on">UF</span>
                                <input id="uf" name="uf" type="text" placeholder="Informe a UF" onKeyPress="return arrumaEnter(this, event)"/>
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