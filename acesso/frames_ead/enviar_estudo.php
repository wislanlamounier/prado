<?php include '../menu/tabela_ead.php'; 
include('../includes/conectar.php');
$sql_disc = mysql_query("SELECT * FROM disciplinas WHERE cod_disciplina LIKE '". $_SESSION["coddisc"]."' AND anograde LIKE '". $_SESSION["anograde"]."'");
$dados_disc = mysql_fetch_array($sql_disc);
$nome_disciplina = ($dados_disc["disciplina"]);
$get_acao = 1;//$_GET["acao"];
$get_id_estudo = $_GET["id"];


if($get_acao == 1){
	$nome_acao = "Enviar arquivo - ";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
//PEGA DADOS DO ESTUDO
$sql_estudo = mysql_query("SELECT * FROM ea_estudo_dirigido WHERE id_estudo LIKE '$get_id_estudo'");
$dados_estudo = mysql_fetch_array($sql_estudo);
$estudo_max_tentativa = $dados_estudo["tentativas"];

//PEGA ENVIOS DO ALUNO
$sql_envios = mysql_query("SELECT * FROM ea_estudo_envio WHERE id_estudo LIKE '$get_id_estudo' AND matricula LIKE '$user_usuario'");
$contar_envios = mysql_num_rows($sql_envios);

if($contar_envios >= $estudo_max_tentativa){
	echo "<script language=\"javascript\">
	alert('Voc� j� realizou o m�ximo de envios de trabalho permitidos.');
	window.close();
	</script>
	";
	return;
		
}


// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = 'trabalhos/';

// Tamanho m�ximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 20; // 20Mb

// Array com as extens�es permitidas
$_UP['extensoes'] = array('jpg', 'png', 'gif','doc','docx','ppt', 'pptx', 'xls', 'csv', 'xlsx', 'pdf');

// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'N�o houve erro';
$_UP['erros'][1] = 'O arquivo no upload � maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'N�o foi feito o upload do arquivo';

// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {
die("N�o foi poss�vel fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
exit; // Para a execu��o do script
}

// Caso script chegue a esse ponto, n�o houve erro com o upload e o PHP pode continuar

// Faz a verifica��o da extens�o do arquivo
$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
echo "Por favor, envie arquivos com as extens�es permitidas";
}

// Faz a verifica��o do tamanho do arquivo
else if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
echo "O arquivo enviado � muito grande, envie arquivos de at� 20Mb.";
}

// O arquivo passou em todas as verifica��es, hora de tentar mov�-lo para a pasta
else {
$tentativa = $contar_envios +1;
// Primeiro verifica se deve trocar o nome do arquivo
$nome_final = $get_id_estudo."_".$_SESSION["MM_Username"]."_".$tentativa.".".$extensao;
}


// Depois verifica se � poss�vel mover o arquivo para a pasta escolhida
if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
// Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
	$datahoraatual = date("Y-m-d H:i:s");

	mysql_query("INSERT INTO `ea_estudo_envio` (`id_envio`, `id_estudo`, `matricula`, `data_envio`, `arquivo`, `tentativa`) VALUES (NULL, '$get_id_estudo', '$user_usuario', '$datahoraatual', '$nome_final', '$tentativa');");
	mysql_close();
	echo "<script language=\"javascript\">
	alert('Arquivo enviado com sucesso! Em breve ser� avaliado pelo tutor.');
	window.close();
	window.opener.location.reload();
	</script>";
} else {
// N�o foi poss�vel fazer o upload, provavelmente a pasta est� incorreta
echo "<script language=\"javascript\">
	alert('Erro: Arquivo n�o enviado! Tente novamente.');
	</script>";
}

}
}

?>

<div class="conteudo">

<form method="post" action="#" enctype="multipart/form-data">
<label>Escolha o Arquivo:</label>
<input type="file" name="arquivo" />
<input type="submit" value="Enviar" />
</form>

</div>
  <?php include '../menu/footer.php' ?>
<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir? '))
{
location.href="excluir.php?id="+id;
}
else
{
return false;
}
}
//-->

</script>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>
</div>
</body>
</html>

<script type="text/javascript">  
function habilitar(){  
    if(document.getElementById('check1').checked){  
        document.getElementById('d_ini').disabled = false; 
		document.getElementById('m_ini').disabled = false; 
		document.getElementById('a_ini').disabled = false;
		document.getElementById('hh_ini').disabled = false; 
		document.getElementById('mm_ini').disabled = false; 
		document.getElementById('ss_ini').disabled = false;  
		document.getElementById('d_fin').disabled = false; 
		document.getElementById('m_fin').disabled = false; 
		document.getElementById('a_fin').disabled = false;
		document.getElementById('hh_fin').disabled = false; 
		document.getElementById('mm_fin').disabled = false; 
		document.getElementById('ss_fin').disabled = false;  
    } else {  
        document.getElementById('d_ini').disabled = true; 
		document.getElementById('m_ini').disabled = true; 
		document.getElementById('a_ini').disabled = true;
		document.getElementById('hh_ini').disabled = true; 
		document.getElementById('mm_ini').disabled = true; 
		document.getElementById('ss_ini').disabled = true; 
		document.getElementById('d_fin').disabled = true; 
		document.getElementById('m_fin').disabled = true; 
		document.getElementById('a_fin').disabled = true;
		document.getElementById('hh_fin').disabled = true; 
		document.getElementById('mm_fin').disabled = true; 
		document.getElementById('ss_fin').disabled = true;    
    }  
	
	
	if(document.getElementById('check2').checked){  
        document.getElementById('nota').disabled = false;  
    } else {  
        document.getElementById('nota').disabled = true; 
    } 
	
}  
</script> 