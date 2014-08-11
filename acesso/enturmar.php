<?php include 'menu/tabela.php' ?>
<?php
include 'includes/conectar.php';


$turma = $_GET["turma"];
$p_turno = $_GET["turno"];
$id_turma = $_GET["id_turma"];
$p_polo = trim($_GET["polo"]);
$turma_pesq = mysql_query("SELECT * FROM ced_turma WHERE id_turma LIKE '$id_turma'");
$dados_turma = mysql_fetch_array($turma_pesq);
$max_aluno = $dados_turma["max_aluno"];
$nivel = $dados_turma["nivel"];
$curso = $dados_turma["curso"];
$modulo = $dados_turma["modulo"];
$unidade = $dados_turma["unidade"];
$polo = $dados_turma["polo"];
$turno = $dados_turma["turno"];
$grupo = $dados_turma["grupo"];
$anograde = $dados_turma["anograde"];
if($modulo == 1){
	$moduloexib = "I";
}
if($modulo == 2){
	$moduloexib = "II";
}
if($modulo == 3){
	$moduloexib = "III";
}
if($modulo == 4){
	$moduloexib = "IV";
}
?>

<?php

//verifica alunos enturmados
$sql = mysql_query("SELECT * FROM alunos WHERE codigo IN (SELECT cta.matricula FROM ced_turma_aluno cta
INNER JOIN ced_turma ct 
ON ct.id_turma = cta.id_turma WHERE ct.grupo LIKE '$grupo') ORDER BY nome");
//verifica alunos não enturmados
$sql2 = mysql_query("SELECT distinct codigo, nome, grupo FROM geral WHERE grupo LIKE '$grupo' 
AND nivel LIKE '%$nivel%' AND curso LIKE '%$curso%' AND modulo LIKE '%$modulo%' 
AND unidade LIKE '%$unidade%' AND polo LIKE '%$polo%'
AND codigo NOT IN (SELECT A.matricula FROM ced_turma_aluno A 
INNER JOIN ced_turma B ON A.id_turma = B.id_turma WHERE B.grupo LIKE '$grupo' AND B.modulo = '$modulo' AND B.turno LIKE '%$turno%') ORDER BY rand()");




// query para selecionar todos os campos da tabela usuários se $busca contiver na coluna nome ou na coluna email
// % antes e depois de $busca serve para indicar que $busca por ser apenas parte da palavra ou frase
// $busca é a variável que foi enviada pelo nosso formulário da página anterior
$enturmado = mysql_num_rows($sql);
$desenturmado = mysql_num_rows($sql2);
$vagas = $max_aluno - $enturmado;

if ($vagas == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('ESSA TURMA NÃO TEM MAIS VAGAS DISPONÍVEIS');
	window.close();
    </SCRIPT>");}
// conta quantos registros encontrados com a nossa especificação
if ($desenturmado == 0) {
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.alert('NENHUM ALUNO DESENTURMADO PARA SER INSERIDO NESSA TURMA');
	window.close();
    </SCRIPT>");
} else {
    // senão
    // se houver mais de um resultado diz quantos resultados existem

    while (($dados = mysql_fetch_array($sql2))) {
        // enquanto houverem resultados...
		$codigo          = $dados["codigo"];
		$nome          = strtoupper($dados["nome"]);
		mysql_query("INSERT INTO  ced_turma_aluno (matricula ,codturma, turno, polo,anograde,id_turma,agrupamento) VALUES ('$codigo', '$turma','$turno','$polo','$anograde','$id_turma','$id_turma')");
		$vagas -= 1;
		echo "Aluno(a) $nome foi inserido na turma $turma<br><hr><br>";
		
		
		//PESQUISA DISCIPLINAS DA TURMA
		$sql_disc = mysql_query("SELECT * FROM ced_turma_disc WHERE id_turma = '$id_turma'");
		//cadastra as disciplinas do aluno
		while ($dados2 = mysql_fetch_array($sql_disc)){
			$disciplina          = $dados2["codigo"];
			mysql_query("INSERT INTO  ced_aluno_disc (matricula ,turma_disc) VALUES ('$codigo',  '$disciplina');");
		}
	echo ("<SCRIPT LANGUAGE='JavaScript'>
			window.alert('Alunos enturmados na turma $turma');
			window.close();
			window.opener.location.reload();
			</SCRIPT>");
	}
		

        // exibir a coluna nome e a coluna email
    
}

?>
</tr>
		<tr>
        <td bgcolor="#ABABAB" colspan="2"><strong><?php echo $enturmado;?> Alunos</strong></td>
	</tr>
</table>
</div>
<?php include 'menu/footer.php' ?>

<script language= 'javascript'>
<!--
function aviso(id){
if(confirm (' Deseja realmente excluir o titulo? '))
{
location.href="apagar_receita.php?id="+id;
}
else
{
return false;
}
}

function usuario(id){
alert("o nº de usuário é: "+id);
}
//-->

</script>

<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">

function baixa (id){
var data;
do {
    data = prompt ("Qual a data de pagamento?");
} while (data == null || data == "");
if(confirm ("Deseja mesmo efetuar a baixa do titulo para a data:  "+data))
{
location.href="baixa_receita.php?id="+id+"&data="+data;
}
else
{

}

}
</SCRIPT>

    <script language="JavaScript">
    function abrir(URL) {
     
      var width = 700;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>