<?php include ('menu/tabela.php');?>
<?php
include('includes/conectar.php');

$id = $_GET["id"];

$re    = mysql_query("select count(*) as total from geral WHERE codigo = $id" );	
$total = 1;

if($total == 1) {
	$re    = mysql_query("select * from geral WHERE codigo LIKE $id");
	$dados = mysql_fetch_array($re);		
}
$nome = strtoupper($dados["nome"]);
?>

<div class="conteudo">
  <div class="filtro" align="center">
    <p><a target="_blank" href="alterar_dados.php?id=<?php echo $id; ?>">EDITAR</a> |  <a target="_self" href="javascript:window.print()">IMPRIMIR</a> |  <a target="_self" href="javascript:window.close()">FECHAR</a><br /> <select name="select" id="select">
        <option selected="selected" value="ficha.php?codigo=<?php echo $id; ?>">Ficha de Matr&iacute;cula</option>
        <option value="aluno_financeira.php?id=<?php echo $id; ?>">Resumo Financeiro</option>
        <option value="ficha_dados.php?id=<?php echo $id; ?>">Dados do Aluno</option>
      </select>
      <input type="button" name="button" id="button" value="Ver" />
    </p>
  </div>
  <table width="100%" border="1">
  	<tr>
    <td colspan="2" height="147" bgcolor="#CCCCCC"><div style="float:left" align="Left"><strong><img src="images/logo-color.png" width="130" />
    </strong></div>
    <div align="center" style="margin-left:-15px"><br /><br /><br /><br />
    <B><font size="+1">FICHA DE DADOS - <?php echo $id;?></font></B><br />
    </div>
    <div style="float:right"><br />
    Data de Matricula: <?php echo strtoupper($dados["datacad"]); ?><br />
      Hora: <?php echo strtoupper($dados["hora"]); ?></div></td>
    </tr>
    <tr>
      <td width="22%"><strong>Nome do Aluno:</strong></td>
      <td width="78%"><?php echo (strtoupper($dados["nome"])); ?></td>
    </tr>
    <tr>
      <td><strong>Data de Nascimento:</strong></td>
      <td><?php echo $dados["nascimento"]; ?></td>
    </tr>
    <tr>
      <td><strong>Estado Civil:</strong></td>
      <td><?php echo strtoupper($dados["civil"]); ?></td>
    </tr>
    <tr>
      <td><strong>RG:</strong></td>
      <td><?php echo $dados["rg"]; ?></td>
    </tr>
    <tr>
      <td><strong>CPF:</strong></td>
      <td><?php echo $dados["cpf"]; ?></td>
    </tr>
    <tr>
      <td><strong>E-mail:</strong></td>
      <td><?php echo $dados["email"]; ?></td>
    </tr>
    <tr>
      <td><strong>Telefone(s):</strong></td>
      <td><?php echo $dados["telefone"]; ?> / <?php echo $dados["celular"]; ?> </td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#ABABAB"><div align="center" class="titulo">INFORMA&Ccedil;&Otilde;ES ADICIONAIS</div></td>
    </tr>
    <tr>
      <td><strong>Pai:</strong></td>
      <td><?php echo (strtoupper($dados["pai"])); ?></td>
    </tr>
    <tr>
      <td><strong>M&atilde;e:</strong></td>
      <td><?php echo (strtoupper($dados["mae"])); ?></td>
    </tr>
    <tr>
      <td><strong>Unidade:</strong></td>
      <td><?php echo (strtoupper($dados["unidade"])); ?></td>
    </tr>
     <tr>
      <td><strong>Polo:</strong></td>
      <td><?php echo (strtoupper($dados["polo"])); ?></td>
    </tr>
    <tr>
      <td><strong>Curso:</strong></td>
      <td><?php echo (strtoupper($dados["curso"])); ?></td>
    </tr>

    <tr>
      <td colspan="2" bgcolor="#ABABAB"><div align="center" class="titulo">ENDERE&Ccedil;O</div></td>
    </tr>
    <tr>
      <td><strong>Endere&ccedil;o:</strong></td>
      <td><?php echo (strtoupper($dados["endereco"])); ?></td>
    </tr>
    <tr>
      <td><strong>Bairro: </strong></td>
      <td><?php echo (strtoupper($dados["bairro"])); ?> - <?php echo strtoupper($dados["uf"]); ?></td>
    </tr>
    <tr>
      <td><strong>CEP:</strong></td>
      <td><?php echo $dados["cep"]; ?></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#ABABAB"><div align="center" class="titulo">FINANCEIRO</div></td>
    </tr>
    <tr>
      <td><strong>Respons&aacute;vel Fin.:</strong></td>
      <td><?php echo (strtoupper($dados["nome_fin"])); ?></td>
    </tr>
    <tr>
      <td><strong>CPF:</strong></td>
      <td><?php echo $dados["cpf_fin"]; ?></td>
    </tr>
    <tr>
      <td><strong>Endere&ccedil;o:</strong></td>
      <td><?php echo (strtoupper($dados["end_fin"])); ?></td>
    </tr>
    <tr>
      <td><strong>Bairro: </strong></td>
      <td><?php echo (strtoupper($dados["bairro_fin"])); ?></td>
    </tr>
    <tr>
      <td><strong>Cidade: </strong></td>
      <td><?php echo (strtoupper($dados["cidade_fin"])); ?></td>
    </tr>
    <tr>
      <td><strong>E-mail:</strong></td>
      <td><?php echo strtoupper($dados["email_fin"]); ?></td>
    </tr>
    <tr>
      <td colspan="2" bgcolor="#C0C0C0"><div align="center" class="titulo"><font size="+1">DADOS FIADOR</font></div></td>
    </tr>
    <tr>
      <td><strong>Nome:</strong></td>
      <td><?php echo utf8_encode(strtoupper($dados["nome_fia"])); ?></td>
    </tr>
    <tr>
      <td><strong>CPF:</strong></td>
      <td><?php echo $dados["cpf_fia"]; ?></td>
    </tr>
    <tr>
      <td><strong>Endere&ccedil;o:</strong></td>
      <td><?php echo utf8_encode(strtoupper($dados["end_fia"])); ?></td>
    </tr>
    <tr>
      <td><strong>Bairro: </strong></td>
      <td><?php echo utf8_encode(strtoupper($dados["bairro_fia"])); ?></td>
    </tr>
    <tr>
      <td><strong>Cidade: </strong></td>
      <td><?php echo utf8_encode(strtoupper($dados["cidade_fia"])); ?></td>
    </tr>
    <tr>
      <td><strong>E-mail:</strong></td>
      <td><?php echo strtoupper($dados["email_fia"]); ?></td>
    </tr>
    <tr>
      <td><strong>Telefone(s):</strong></td>
      <td><?php echo strtoupper($dados["tel_fia"]); ?></td>
    </tr>

    <tr>
      <td colspan="2" bgcolor="#CCCCCC">
      <div align="right"><font size="-1">&copy; Copyright 2013 - Escola T&eacute;cnica CEDTEC. Todos os direitos reservados</font></div></td>
    </tr>

  </table>

  
  <DIV class="titulo" align="center"></DIV>
</form>


  <script language="JavaScript">  
function FormataCpf(campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(campo.value);
				vr = vr.replace(".", "");
				vr = vr.replace("/", "");
				vr = vr.replace("-", "");
				tam = vr.length + 1;
				if (tecla != 14)
				{
					if (tam == 4)
						campo.value = vr.substr(0, 3) + '.';
					if (tam == 7)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 6) + '.';
					if (tam == 11)
						campo.value = vr.substr(0, 3) + '.' + vr.substr(3, 3) + '.' + vr.substr(7, 3) + '-' + vr.substr(11, 2);
				}
			}   

function FormataData(campo, teclapres)
			{
				var tecla = teclapres.keyCode;
				var vr = new String(campo.value);
				vr = vr.replace(".", "");
				tam = vr.length + 1;
				if (tecla != 10)
				{
					if (tam == 3)
						campo.value = vr.substr(0, 2) + '/';
					if (tam == 6)
						campo.value = vr.substr(0, 2) + '/' + vr.substr(3, 6) + '/';
				}
			}   

  </script> 
  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
     <script type="text/javascript">
     $(document).ready(function() {
   
   $("#button").click(function() {
      var theURL = $("#select").val();
window.location = theURL;
});
       
});
     </script>
  