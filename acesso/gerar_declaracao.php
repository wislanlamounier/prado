<?php include 'menu/tabela.php';
 include 'includes/conectar.php';
$get_matricula = $_GET["matricula"];
$get_ref_curso = $_GET["curso_id"];
$get_modelo = $_GET["modelo"];
$get_ch_estagio = $_GET["ch_estagio"];
$inicio_periodo = substr($_GET["inicio_periodo"],8,2)."/".substr($_GET["inicio_periodo"],5,2)."/".substr($_GET["inicio_periodo"],0,4);
$fim_periodo = substr($_GET["fim_periodo"],8,2)."/".substr($_GET["fim_periodo"],5,2)."/".substr($_GET["fim_periodo"],0,4);
//pega declaracao
$sql_declaracao = mysql_query("select * from ced_declaracoes where id_declaracao = $get_modelo");
$dec_dados = mysql_fetch_array($sql_declaracao);

//pega dados do aluno
$sql_aluno  =mysql_query("select * from alunos where codigo = $get_matricula");
$dados_alunos = mysql_fetch_array($sql_aluno);
$aluno_nome = $dados_alunos["nome"];
$aluno_mae = $dados_alunos["mae"];
$aluno_pai = $dados_alunos["pai"];
$aluno_nascimento = $dados_alunos["nascimento"];
$aluno_cpf = $dados_alunos["cpf"];
$aluno_rg = $dados_alunos["rg"];
$aluno_matricula = $dados_alunos["codigo"];



//PEGA DADOS DO CURSO
$sql_curso =mysql_query("select * from curso_aluno where matricula LIKE '$get_matricula' AND ref_id LIKE '$get_ref_curso'");
$dados_curso = mysql_fetch_array($sql_curso);
$curso_unidade = trim($dados_curso["unidade"]);
$curso_polo = trim($dados_curso["polo"]);
$curso_turno = $dados_curso["turno"];
$curso_modulo = $dados_curso["modulo"];
$curso_nivel =  trim($dados_curso["nivel"]);
$curso_nome =  trim($dados_curso["curso"]);
$curso_grupo = $dados_curso["grupo"];
$curso_grupo2 = $dados_curso["grupo2"];
if(strtolower(remover_acentos($curso_nivel)) == "ensino medio"){
	$curso_nome_final = strtoupper($curso_nivel);
} else {
	$curso_nome_final = strtoupper($curso_nivel)." - ".strtoupper($curso_nome);
}

//PEGA DADOS DA UNIDADE
$sql_unidade =mysql_query("SELECT DISTINCT unidade,cidade_uf,endereco FROM unidades WHERE unidade LIKE '%$curso_unidade%'");
$dados_unidade = mysql_fetch_array($sql_unidade);
$unidade_endereco = $dados_unidade["endereco"];
$unidade_cidadeuf = $dados_unidade["cidade_uf"];



//GERA A DATA COMPLETA
$data_dia = date('d');
$data_mes = format_mes(date('m'));
$data_ano = date('Y');

$data_completa = $data_dia." de ".$data_mes." de ".$data_ano;

$trocar_isso = array("<<aluno_nome>>","<<curso_nome_final>>"
,"<<curso_datafinal>>","<<data_completa>>","<<unidade_cidadeuf>>"
,"<<aluno_cpf>>","<<aluno_rg>>","<<aluno_matricula>>","<<inicio_periodo>>","<<fim_periodo>>","<<ch_estagio>>","<<aluno_nascimento>>"
,"<<aluno_pai>>","<<aluno_mae>>","<<curso_modulo>>");


$por_isso = array("$aluno_nome","$curso_nome_final","$curso_data_final",
"$data_completa","$unidade_cidadeuf","$aluno_cpf",
"$aluno_rg","$aluno_matricula","$inicio_periodo","$fim_periodo","$get_ch_estagio","$aluno_nascimento"
,"$aluno_pai","$aluno_mae","$curso_modulo");
 ?>
<div class="conteudo">
<div class="filtro"><center><a href="javascript:window.print()">[IMPRIMIR]</a></center></div>
<div class="declaracao">
<div class="declaracao-top">
<?php print_r(str_replace($trocar_isso,$por_isso,$dec_dados["topo"]));?>
</div>
<div class="declaracao-body">
<?php print_r(str_replace($trocar_isso,$por_isso,$dec_dados["corpo"]));?>
</div>
<div class="declaracao-footer">
<?php print_r(str_replace($trocar_isso,$por_isso,$dec_dados["footer"]));?>
</div>

</div>
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

function baixa (){
var data;
do {
    data = prompt ("DIGITE O NÚMERO DO TÍTULO?");

	var width = 700;
    var height = 500;
    var left = 300;
    var top = 0;
} while (data == null || data == "");
if(confirm ("DESEJA VISUALIZAR O TÍTULO Nº:  "+data))
{
window.open("editar2.php?id="+data,'_blank');
}
else
{
return;
}

}
</SCRIPT>

<script language="JavaScript">
    function abrir(URL) {
     
      var width = 900;
      var height = 500;
     
      var left = 300;
      var top = 0;
     
      window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', right='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
     
    }
    </script>