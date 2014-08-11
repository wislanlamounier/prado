<?php
include('conectar.php');
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$usuario = $_POST["usuario"];
	$email = $_POST["email"];
	
$sql_lembrar = mysql_query("SELECT * FROM users WHERE usuario LIKE '$usuario' AND email LIKE '$email'");
if(mysql_num_rows($sql_lembrar)==1){
	$dados_lembrar = mysql_fetch_array($sql_lembrar);
} else {
	$sql_lembrar = mysql_query("SELECT * FROM acessos_completos WHERE usuario LIKE '$usuario' AND email LIKE '$email'");
	$dados_lembrar = mysql_fetch_array($sql_lembrar);
}


if(mysql_num_rows($sql_lembrar) == 1){
	$user_nome = $dados_lembrar["nome"];
	$user_email = $dados_lembrar["email"];
	$user_senha = $dados_lembrar["senha"];
	$user_usuario = $dados_lembrar["usuario"];
	$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";		 
//endereço do remitente
$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";		 
//endereço de resposta, se queremos que seja diferente a do remitente
$headers .= "Reply-To: patryky@cedtec.com.br". "\r\n";			 
//endereços que receberão uma copia oculta
$headers .= "Bcc: cob.cedtec@gmail.com". "\r\n";

$mesagem1 = "Olá <b>$user_nome</b>,
<br><br>
Foi solicitado o lembrete de sua senha através do nosso site, segue abaixo dados de acesso:
<br><br>
<b>Usuário / Matrícula:</b> $user_usuario<br>
<b>Senha:</b> $user_senha
<br><br>
Caso não tenha solicitado o lembrete de senha desconsidere este e-mail.
<br><br>
--<br>
Atenciosamente<br>
<b>Escola Técnica CEDTEC</b><br>
<i>Educação Profissional Levada a Sério</i>";

$assunto = "[CEDTEC] Lembrete de Senha";
$destinatario =$user_email;
mail($destinatario,$assunto,$mesagem1,$headers);
echo "<script language=\"javascript\">
alert('DADOS DE ACESSOS ENVIADOS PARA O E-MAIL CADASTRADO.');
window.close();
</script>";
	
} else {
	
echo "<script language=\"javascript\">
alert('DADOS DE ACESSOS INCORRETOS');
</script>";

}


}

?>

<head>
  <link href='http://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="css/main.css">
</head>
<body> 

  <div class="login">
  <img src="images/logo_pincel.png">
<div class="carregando" id="carregando" style="display:none;"> Confirmando dados... </div>
  
  <form action="#" method="POST">
    <div class="input">
      <div class="blockinput">
        <i class="icon-envelope-alt"><img height="20" src="images/icone_usuario.png"></i><input name="usuario" type="text" placeholder="Usuário / Matrícula">
      </div>
      <div class="blockinput">
        <i style="margin-top:10px;"><img height="20" src="images/icone_email.png"></i><input name="email"  type="text" placeholder="Digite seu e-mail">
      </div>
      </div>
       
       <center><button type="submit" onClick="document.getElementById('carregando').style.display=''">Confirmar Dados</button></center>
  </form>
  </div>

</body>


<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
function pesquisar (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while(data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar2.php?id="+data,'_blank');
}
else
{
exit;
}

}

function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
}
</SCRIPT>