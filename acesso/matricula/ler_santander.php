﻿<?php include ('menu/menu.php');
include('includes/conectar.php');
$arquivo_head = $_FILES['arq']['tmp_name'];
$fp = fopen($arquivo_head, "r");
$ler_header = fread($fp, 400); //lê header 400 bytes
$agencia_movimento = substr($ler_header,26,4);
$cedente_movimento = substr($ler_header,30,8);
$cobranca_movimento = substr($ler_header,38,8);
$banco_movimento = substr($ler_header,76,3);
$banco_cedente = trim(substr($ler_header,110,8));
$sql_conta =mysql_query("SELECT * FROM contas WHERE agencia LIKE '%$agencia_movimento%' AND cedente LIKE '%$banco_cedente%'");
$dados_conta = mysql_fetch_array($sql_conta);
$conta_ref = $dados_conta["ref_conta"];
$conta_razao = $dados_conta["razao"];
$conta_nome = $dados_conta["conta"];
?>
<div class="conteudo">
<table width="100%" border="0" class="full_table_list2" align="center">
  <th align="center" colspan="5"><font size="+1"><?php echo $conta_nome;?></font></th>
  <tr>
    <td width="24%" align="center"><strong>TÍTULO</strong></td>
    <td width="26%" align="center"><strong>NOME</strong></td>
    <td width="24%" align="center"><strong>DATA</strong></td>
    <td width="15%" align="center"><strong>PARCELA</strong></td>
    <td width="22%"><strong>VALOR</strong></td>
  </tr>

  <?php


// usuário
$user 				=$_SESSION['MM_Username'];
$atual = date("Y-m-d H:i:s");
$ipativo = $_SERVER["REMOTE_ADDR"];

$arquivo = $_FILES['arq']['tmp_name'];
$arquivo_nome = $_FILES['arq']['name'];
$handle = @fopen($arquivo, 'r');

mysql_query("INSERT INTO logs (usuario,data_hora,cod_acao,acao,ip_usuario)
VALUES ('$user','$atual','07','ARQUIVO $arquivo_name BAIXADO','$ipativo');");
if($handle)
{
	$parcial_matricula = 0;
	$parcial_boletos = 0;
	echo"Arquivo retorno importado com sucesso";
        while( ! feof($handle))
        {
                $buffer = fgets($handle, 50000);
				$codigo = "9".trim(substr($buffer, 62, 7));
				$realpago =((int)substr($buffer, 256, 8));
				$centspago =substr($buffer, 264, 2);
				$valorpago = $realpago.".".$centspago;
				$diavenc = substr($buffer, 146, 2);
                $mesvenc = substr($buffer, 148, 2);
				$anovenc = substr($buffer, 150, 2);
				$diapag = substr($buffer, 110, 2);
                $mespag = substr($buffer, 112, 2);
				$anopag = substr($buffer, 114, 2);
				$cod = substr($codigo, 0, 5);
				$cod2 = substr(trim($codigo), 0, 3);
				$tipoentrada = trim(substr($buffer, 108, 2));
				$cod3 = substr($codigo, 0, 2);
				$atraso = utf8_decode("NÃO");
				$vencimento = "20".$anovenc."-".$mesvenc."-".$diavenc;
				$datapag = "20".$anopag."-".$mespag."-".$diapag;
				$dataexib = substr($datapag,8,2)."/".substr($datapag,5,2)."/".substr($datapag,0,4);
				/*teste (excluir)
				echo "$tipoentrada
				<br>$codigo<br>
				$cod2 <br>
				$cod3 <br>
				$valorpago<br>
				$vencimento<br>
				$datapag<br><br><br>";*/
				
				//VERIFICA SE HÁ OUTRO TITULO RECEBIDO E DA BAIXA
				if($cod2 == "920"&&$tipoentrada=="06"){
					mysql_query("INSERT INTO baixas (codigo,valor_pagto,data_pagto,arquivo) VALUES ('$codigo' , '$valorpago' ,'$datapag','$arquivo_nome')");
					//processamento e saldo					
					
					$tit = mysql_query("SELECT * FROM titulos WHERE id_titulo = '$codigo'");
						while($titu = mysql_fetch_array($tit)) {
							$titulo = $titu["id_titulo"];
							$cliente = $titu["cliente_fornecedor"];
							$tipo = $titu["tipo"];
							$conta = $titu["conta"];
							$status = $titu["status"];
							$parcelab = $titu["parcela"];
							$data_pagtoex = trim($titu["data_pagto"]);
							$valorexib = number_format($valorpago, 2, '.','');
							sleep(0.01);
							$processamento = date("Y-m-d H:i:s:").microtime();
							$total_boletos = $parcial_boletos + $valorpago;
							$parcial_boletos = $total_boletos;
							
							//EXIBE NA TELA RETORNOS BAIXADOS
							$clientesql = mysql_query("SELECT * FROM cliente_fornecedor WHERE codigo = $cliente");
							$sql = mysql_fetch_array($clientesql);
							$nomecliente = utf8_encode(strtoupper($sql["nome"]));
							echo "<tr>
							<td align=\"center\">$titulo</td>
							<td>$nomecliente</td>
							<td align=\"center\">$dataexib</td>
							<td align=\"center\">$parcelab</td>
							<td>R$ $valorexib</td></tr>";
							
							if($status = 1 || $status == 99){
								mysql_query("UPDATE titulos SET status = 0 WHERE id_titulo = $titulo");
							}
							
							if($tipo ==2 || $tipo ==99){
								$saldo    = mysql_query("SELECT REPLACE(FORMAT(saldo, 2),',','') as SALDO FROM titulos WHERE processamento = ( SELECT MAX( processamento ) FROM titulos WHERE (valor_pagto >  0 OR data_pagto <> '') AND conta = '$conta' )");
								$saldofin = mysql_fetch_array($saldo);
								$saldofinal2 = $saldofin["SALDO"];
								$saldofinal3 = $saldofinal2 + $valorpago;
								if($data_pagtoex ==""){
									mysql_query("UPDATE titulos SET valor_pagto='$valorpago', data_pagto='$datapag', atraso='$atraso', processamento='$processamento', saldo='$saldofinal3', conta='$conta_ref' WHERE id_titulo=$codigo");}
							}
							if($tipo ==1){
								$saldo    = mysql_query("SELECT REPLACE(FORMAT(saldo, 2),',','') as SALDO FROM titulos WHERE processamento = ( SELECT MAX( processamento ) FROM titulos WHERE (valor_pagto >  0 OR data_pagto <> '') AND conta = '$conta' )");
								$saldofin = mysql_fetch_array($saldo);
								$saldofinal2 = $saldofin["SALDO"];
								$saldofinal3 = $saldofinal2 - $valorpago;
								if($data_pagtoex ==""){
									mysql_query("UPDATE titulos SET valor_pagto='$valorpago', data_pagto='$datapag', atraso='$atraso', processamento='$processamento',conta='$conta_ref', saldo='$saldofinal3' WHERE id_titulo=$codigo");}
							}
								
						}
				}
				
                //VERIFICA TITULOS DA 1ª PARCELA E GERA OS PRÓXIMOS // TRANSFERE PAGANTES COMO CLIENTES
				if($cod == "9009"&&$tipoentrada=="06" || $cod2 =="901"&&$tipoentrada=="06"|| $cod3 =="91"&&$tipoentrada=="06"){
					
					//EXIBE NA TELA RETORNOS BAIXADOS
					$clientesql2 = mysql_query("SELECT * FROM inscritos WHERE codigo = $codigo");
					$sql2 = mysql_fetch_array($clientesql2);
					$nomecliente2 = utf8_encode(strtoupper($sql2["nome"]));
					$total_matriculas = $parcial_matricula + $valorpago;
					$parcial_matricula = $total_matriculas;
					echo "<tr>
						<td bgcolor=\"#FFFF99\" align=\"center\">$codigo</td>
						<td>$nomecliente2</td>
						<td align=\"center\">$dataexib</td>
						<td align=\"center\">MATRÍCULA</td>
						<td>R$ $valorpago</td></tr>";
					if(@mysql_query("INSERT INTO baixas (codigo,valor_pagto,data_pagto,arquivo) VALUES ('$codigo' , '$valorpago' ,'$datapag','$arquivo_nome')")) {
						if(mysql_affected_rows() == 1){
							//soma as matrículas
							$re2 = mysql_query("SELECT * FROM inscritos WHERE codigo = $codigo");
							while($dados = mysql_fetch_array($re2)) {
								//dados alunos get
								$cod2 = $dados["codigo"];
								$nome = $dados["nome"];
								$nacionalidade = $dados["nacionalidade"];
								$civil = $dados["civil"];
								$email2 = $dados["email"];
								$cpf = $dados["cpf"];
								$rg = $dados["rg"];
								$nascimento = $dados["nascimento"];
								$cep = $dados["cep"];
								$cidade = $dados["cidade"];
								$bairro = $dados["bairro"];
								$uf = $dados["uf"];
								$endereco = $dados["endereco"];
								$complemento = $dados["complemento"];
								$tel2 = $dados["telefone"];	
								$tel3 = $dados["celular"];
								$mae = $dados["mae"];
								$pai = $dados["pai"];
								$cargo = $dados["cargo"];
								$empresa = $dados["empresa"];
								$renda = $dados["renda"];
								$formacao = $dados["formacao"];
								$escola = $dados["escola"];
								$aluno = $dados["aluno"];
								$se_aluno = $dados["se_aluno"];
								
								
								//OUTROS DADOS
								$fin2 = $dados["nome_fin"];
								$civil_fin = $dados["civil_fin"];
								$email_fin = $dados["email_fin"];
								$rg2 = $dados["rg_fin"];
								$cpf2 = $dados["cpf_fin"];	
								$cep2 = $dados["cep_fin"];
								$uf_fin = $dados["uf_fin"];				
								$cidade_fin = $dados["cidade_fin"];
								$bairro2 = $dados["bairro_fin"];
								$end_fin = $dados["end_fin"];
								$comp_fin = $dados["comp_fin"];
								$nasc_fin = $dados["nasc_fin"];
								$nacio_fin = $dados["nacio_fin"];
								$tel_fin = $dados["tel_fin"];
								$nome_fia = $dados["nome_fia"];
								$rg_fia = $dados["rg_fia"];
								$email_fia = $dados["email_fia"];
								$cpf_fia = $dados["cpf_fia"];
								$cep_fia = $dados["cep_fia"];
								$uf_fia = $dados["uf_fia"];
								$cidade_fia = $dados["cidade_fia"];
								$bairro_fia = $dados["bairro_fia"];
								$end_fia = $dados["end_fia"];
								$nasc_fia = $dados["nasc_fia"];
								$nacio_fia = $dados["nacio_fia"];
								$tel_fia = $dados["tel_fia"];
								$nome_conj = $dados["nome_conj"];
								$rg_conj = $dados["rg_conj"];
								$cpf_conj = $dados["cpf_fia"];
								$nasc_conj = $dados["nasc_fia"];
								$nacio_conj = $dados["nacio_conj"];
								$datacad = $dados["datacad"];
								$hora = $dados["hora"];
								$noticia = $dados["noticia"];
								$dia_venc = $dados["dia_venc"];
								
								//dados do curso
								$modalidade = $dados["modalidade"];
								$curso2 = $dados["curso"];
								$cursopesq2   = mysql_query("SELECT * FROM cursosead WHERE codigo = '$curso2'");
								$dadoscur2 = mysql_fetch_array($cursopesq2);
								$curso3 = strtoupper($dadoscur2["curso"]);
								$nivel = strtoupper($dadoscur2["tipo"]);
								$turno = strtoupper($dadoscur2["turno"]);
								$venc_curso = substr($dadoscur2["vencimento"],0,7)."-".$dia_venc;
								$grupo_curso = strtoupper($dadoscur2["grupo"]);
								$modcurso = $dadoscur2["modulo"];
								$contapadrao = $dadoscur2["conta"];
								$valorexib2 = number_format($valorpago, 2, '.','');
								if($modalidade ==1){
									$unidade = $dados["unidade"];
									$unidade2 = strstr($unidade,"-",-34);
									$nome_usuario = strstr($nome," ",-60);
									$sobrenome_usuario = strstr($nome," ");
									$senha = str_replace("/","",$nascimento);
									$polo = strstr($unidade,"-",-34);
								} else {
									$unidade = $dados["unidade"];
									$unidade2= "EAD";
									$senha = str_replace("/","",$nascimento);
									$nome_usuario = strstr($nome," ",-60);
									$sobrenome_usuario = strstr($nome," ");
									$polo = strstr($unidade,"-",-34);
								}
								
								
								if($curso3 <> ""){
									// INSERE O GRUPO AUTOMÁTICO DO ALUNO
									$grupopesq = mysql_query("SELECT * FROM grupos WHERE status = 1 AND grupo LIKE '%$grupo_curso%'");
									$grdados = mysql_fetch_array($grupopesq);
									$grupo = $grdados["grupo"];
									$venc_grupo = $grdados["vencimento"];
									
									// CENTRO DE CUSTO EMPRESA 1
									$cc1 = 10;
									
									// CENTRO DE CUSTO FILIAL 2
									$cc2final = $dadoscur2["filial"];
	
									

									
									// CENTRO DE CUSTO 3
									$cc3 = 21;
									
									// CENTRO DE CUSTO 4									
									$cc4 = mysql_query("SELECT * FROM cc4 WHERE nome_cc4 LIKE '%$nivel%'");
									$c4dados = mysql_fetch_array($cc4);
									$cc4final = $c4dados["cc4"];
									
									// CENTRO DE CUSTO DO CURSO 5
									$cc5    = mysql_query("SELECT * FROM cc5 WHERE nome_cc5 LIKE '%$curso3%' AND id_cc5 LIKE '%$cc4final%'");
									$cdados = mysql_fetch_array($cc5);
									$cc5final = $cdados["cc5"];
									
									// CENTRO DE CUSTO FINAL
									$c_custo = $cc1.$cc2final.$cc3.$cc4final.$cc5final;
									
									
									}

									
								$destinatario = "$email2";
								$assunto = "[CEDTEC] Acesso Portal Acadêmico CEDTEC";
								$corpo = "
								<html>
								<head>
								  <title>[CEDTEC] Bem-vindo ao CEDTEC</title>
								</head>
								<body>
								<h2>Caro(a) $nomecliente2,</h2>
								<p>Sua matrícula já foi efetivada e agora você é um &quot;aluno CEDTEC&quot;.<br>
								  Para acessar seu ambiente acadêmico basta clicar em &quot;Sistema Acadêmico&quot; no nosso site. Digite a sua matrícula (usuário) e a senha inicial.</p>
								<p>Usuário/Matrícula: $cod2<br>
       							Senha: $senha</p>
								<p>A senha inicial é a sua data de nascimento com todos os dígitos sem as barras. Altere sua senha no primeiro acesso evitando senhas óbvias.                                
								<p>No ambiente acadêmico você terá acesso aos seus dados acadêmicos e financeiros, poderá emitir declarações e acessar o EAD CEDTEC.                                
								<p>                                
								<p>Seja bem-vindo ao CEDTEC!
								<p>&nbsp;</p>
								<p>--<br>
								  Atenciosamente</p>
								<p><br>
								  <b><font size=\"+1\">Escola Técnica CEDTEC</font><br>
								  </b>
								  <i>Educação Profissional Levada a Sério</i> </p>
								</body>
								</html>";
								//para o envio em formato HTML
								$headers  = 'MIME-Version: 1.0' . "\r\n";
								$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
									 
								//endereço do remitente
								$headers .= "From: CEDTEC <cedtec@cedtec.com.br>". "\r\n";
								 
								//endereço de resposta, se queremos que seja diferente a do remitente
								$headers .= "Reply-To: comunicacao@cedtec.com.br". "\r\n";
									 
								//endereços que receberão uma copia oculta
								$headers .= "Bcc: cob.cedtec@gmail.com". "\r\n";
								mail($destinatario,$assunto,$corpo,$headers);	
								if($modalidade == 2  ||$modalidade == 1){
									include('includes/conectar_md.php');
									mysql_query("INSERT INTO ced_user (username,password, firstname,lastname, email,city, country, lang, timezone, confirmed,mnethostid) VALUES ('$cod2',MD5('$senha'),'$nome_usuario','$sobrenome_usuario','$email2','$polo','BR','pt_br',99,1,1)");
								}	
								//CRIA ACESSO AO ACADÊMICO DO ALUNO
								include('includes/conectar.php');
								mysql_query("INSERT INTO acesso (codigo, senha, status, nivel) VALUES ('$cod2','$senha', '1','1')");
								mysql_query("INSERT INTO comp_acesso (id_user, usuario, nivel, acessos,unidade,empresa,foto_perfil) VALUES (NULL,'$cod2','90','90', 'CEDTEC','10','images/perfil/sem_foto.jpg')");	
								//INSERE DADOS NA TABELA CLIENTE_FORNECEDOR	
								mysql_query("INSERT INTO cliente_fornecedor (codigo, nome, email, telefone,telefone2,cpf_cnpj,rg,endereco,numero,complemento,cep,tipo) VALUES ('$cod2','$fin2', '$email2','$tel2','$tel3','$cpf2','$rg2','$bairro2','9999','ALUNO','$cep2','3')");
								//INSERE DADOS NA TABELA ALUNOS
								mysql_query("INSERT INTO `alunos` (`codigo`, `nome`, `civil`, `nacionalidade`, `email`, `cpf`, `rg`, `nascimento`, `cep`, `cidade`, `bairro`, `uf`, `endereco`, `complemento`, `telefone`, `celular`, `mae`, `pai`, `cargo`, `empresa`, `renda`, `formacao`, `escola`, `aluno`, `se_aluno`, `nome_fin`, `rg_fin`, `email_fin`, `cpf_fin`, `cep_fin`, `uf_fin`, `cidade_fin`, `bairro_fin`, `end_fin`, `comp_fin`, `nasc_fin`, `nacio_fin`, `tel_fin`, `nome_fia`, `rg_fia`, `email_fia`, `cpf_fia`, `cep_fia`, `uf_fia`, `cidade_fia`, `bairro_fia`, `end_fia`, `nasc_fia`, `nacio_fia`, `tel_fia`, `nome_conj`, `rg_conj`, `cpf_conj`, `nasc_conj`, `nacio_conj`, `datacad`, `hora`, `noticia`, `civil_fin`) VALUES ($cod2, '$nome', '$civil', '$nacionalidade', '$email2', '$cpf', '$rg', '$nascimento', '$cep', '$cidade', '$bairro', '$uf', '$endereco', '$complemento', '$tel2', '$tel3', '$mae', '$pai', '$cargo', '$empresa', '$renda', '$formacao', '$escola', '$aluno', '$se_aluno', '$fin2', '$rg2', '$email_fin', '$cpf2', '$cep2', '$uf_fin', '$cidade_fin', '$bairro2', '$end_fin', '$comp_fin', '$nasc_fin', '$nacio_fin', '$tel_fin', '$nome_fia', '$rg_fia', '$email_fia', '$cpf_fia', '$cep_fia', '$uf_fia', '$cidade_fia', '$bairro_fia', '$end_fia', '$nasc_fia', '$nacio_fia', '$tel_fia', '$nome_conj', '$rg_conj', '$cpf_conj', '$nasc_conj', '$nacio_conj', '$datacad', '$hora', '$noticia', '$civil_fin');");
								//INSERE DADOS NA TABELA CURSO_ALUNO
								mysql_query("INSERT INTO curso_aluno (matricula, nivel, curso,modulo, grupo, turno, unidade, polo) VALUES ('$cod2','$nivel', '$curso3','$modcurso','$grupo_curso','$turno','$unidade2','$polo')");
								//ATUALIZA VENCIMENTO
								mysql_query("UPDATE inscritos SET vencimento = '$venc_grupo' WHERE codigo = $cod2");
								}
							
							$re = mysql_query("SELECT * FROM inscritos WHERE codigo = $codigo");
							while($l = mysql_fetch_array($re)) {
								$curso          = $l["curso"];
								$parcela			= $l["parcelas"];
								//PEGA VALOR DA PARCELA DO CURSO
								$cursopesq    = mysql_query("SELECT * FROM cursosead WHERE codigo = '$curso'");
								$dadoscur = mysql_fetch_array($cursopesq);
								$desconto = $dadoscur["desconto"];
								$valor = ($dadoscur["valor"])/$parcela;
								
								$parcelas		= 1;
								$venc	= $l["vencimento"];
								$vencimento = $venc_curso;
								$saldo2    = mysql_query("SELECT REPLACE(FORMAT(saldo, 2),',','') as SALDO FROM titulos WHERE processamento = ( SELECT MAX( processamento ) FROM titulos WHERE (valor_pagto >  0 OR data_pagto <> '') AND conta = '$contapadrao' )");
								$saldofin2 = mysql_fetch_array($saldo2);
								$saldofinal22 = $saldofin2["SALDO"];
								$saldofinal32 = $saldofinal22 + $valorpago;
								sleep(0.01);
								$processamento2 = date("Y-m-d H:i:s:").microtime();
								$datadoc = date("Y-m-d");
								while($parcelas <= $parcela){
									if(@mysql_query("INSERT INTO titulos(cliente_fornecedor,dt_doc, descricao, vencimento, valor,desconto, parcela, tipo, c_custo,valor_pagto,conta) VALUES( (SELECT codigo FROM inscritos WHERE codigo LIKE $codigo),'$datadoc','Boleto Aluno','$vencimento','$valor','$desconto','$parcelas','2','$c_custo','','$contapadrao')")) {
										
										if(mysql_affected_rows() == 1){
											$parcelas += 1;
								//CALCULA SALDO APÓS MATRÍCULA NOVA
											mysql_query("UPDATE titulos SET valor_pagto='$valorpago', data_pagto='$datapag',conta='$contapadrao',saldo='$saldofinal32',processamento ='$processamento2'  WHERE parcela=1 AND cliente_fornecedor=$codigo AND valor_pagto = ''");
											for ($i = 1; $i <= $parcelas; $i++)
												$vencimento = date("Y-m-d", strtotime(" " . $i-1 . " Month", strtotime($venc)));
										}	
									} else {
										if(mysql_errno() == 1062) {
											echo $erros[mysql_errno()];
											exit;
										} else {	
											echo "";
											exit;
										}
										@mysql_close();
									}
								}
								}
						}
							
				}
				}
                
        }
        fclose($handle);
}
?>
</p>
<tr>
<td colspan="4" align="right">Total baixado:</td>
<td align="right"><?php 
if($total_boletos >0 || $total_matricula >0){
echo number_format($total_boletos+$total_matriculas,2,',','.');
}
?></td>
</tr>
</table>
</div>
<?php include ('menu/footer.php');?>

