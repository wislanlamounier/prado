<?php
include ('menu/menu.php');// inclui o menu
?>
<script type='text/javascript' src='js/jquery.toastmessage-min.js'></script>




<div class="conteudo">
  <p><strong>Aos usu&aacute;rios do sistema  acad&ecirc;mico PINCEL AT&Ocirc;MICO</strong></p>
  <p>O PINCEL AT&Ocirc;MICO &eacute; o novo sistema acad&ecirc;mico e  financeiro da rede CEDTEC. A partir de 21/10/2013 todas as novas matr&iacute;culas e  rematr&iacute;culas ser&atilde;o registradas no Sistema e em 1&ordm; de novembro come&ccedil;a o controle  financeiro, conforme cronograma de implanta&ccedil;&atilde;o definido pela Dire&ccedil;&atilde;o Geral da  empresa.</p>
  <p><strong>Dados  T&eacute;cnicos:</strong><br />
    - O PINCEL AT&Ocirc;MICO foi desenvolvido em  linguagem PHP, utilizando p&aacute;ginas em HTML e CSS, com base de dados em SQL. O  banco de dados est&aacute; instalado em Servidor remoto, com servi&ccedil;o contratado em  &ldquo;nuvem&rdquo;.</p>
  <p><strong>Acesso  ao Sistema:</strong><br />
    - O acesso ao Sistema &eacute; feito via Internet,  pelo site do CEDTEC ou diretamente no endere&ccedil;o http://www.cedtec.com.br/pincelatomico;<br />
    - O PINCEL AT&Ocirc;MICO pode ser acessado de  qualquer computador ou unidade port&aacute;til; incluindo notebooks, tablets ou  aparelhos telef&ocirc;nicos celulares.</p>
  <p><strong>Requisitos  de Acesso:</strong><br />
    - Sistemas operacionais Windows XP ou  superior, Linux, iOS e outros;<br />
    - Navegadores: Preferencialmente Google Chrome  e Internet Explorer 7 ou superior.</p>
  <p><strong>N&iacute;veis  de Acesso:</strong><br />
    - Os n&iacute;veis de acesso est&atilde;o divididos  conforme os grupos de usu&aacute;rios definidos abaixo.</p>
  <table border="1" cellspacing="0" cellpadding="0">
    <tr>
      <td width="127"><br />
        <strong>Grupo</strong></td>
      <td width="348"><p align="center"><strong>N&iacute;vel de Acesso</strong></p></td>
      <td width="192"><p align="center"><strong>Abrang&ecirc;ncia</strong></p></td>
    </tr>
    <tr>
      <td width="127"><p>P&Uacute;BLICO</p></td>
      <td width="348"><p>Formul&aacute;rio de inscri&ccedil;&atilde;o. Gera&ccedil;&atilde;o e    impress&atilde;o de contrato e primeiro boleto</p></td>
      <td width="192"><p>Somente inscri&ccedil;&atilde;o</p></td>
    </tr>
    <tr>
      <td width="127"><p>ALUNO</p></td>
      <td width="348"><p>Extrato financeiro. Gera&ccedil;&atilde;o de boletos.    Boletim acad&ecirc;mico. Declara&ccedil;&otilde;es. Exerc&iacute;cios e avalia&ccedil;&otilde;es online</p></td>
      <td width="192"><p>Pessoal</p></td>
    </tr>
    <tr>
      <td width="127"><p>RESPONS&Aacute;VEL</p></td>
      <td width="348"><p>Extrato financeiro. Gera&ccedil;&atilde;o de boletos.    Boletim acad&ecirc;mico. Declara&ccedil;&otilde;es</p></td>
      <td width="192"><p>Pessoal (aluno)</p></td>
    </tr>
    <tr>
      <td width="127"><p>PROFESSOR</p></td>
      <td width="348"><p>Lan&ccedil;amento de notas e faltas. Registro de    planejamento de aula. Registro de ocorr&ecirc;ncias</p></td>
      <td width="192"><p>Alunos / turmas sob sua responsabilidade</p></td>
    </tr>
    <tr>
      <td width="127"><p>SECRETARIA</p></td>
      <td width="348"><p>P&Uacute;BLICO / ALUNO / PROFESSOR</p></td>
      <td width="192"><p>Alunos / turmas da Unidade de Ensino</p></td>
    </tr>
    <tr>
      <td width="127"><p>PEDAG&Oacute;GICO</p></td>
      <td width="348"><p>SECRETARIA. Edi&ccedil;&atilde;o (altera&ccedil;&atilde;o) de notas e    faltas. Enturmar alunos.</p></td>
      <td width="192"><p>Alunos / turmas da Unidade de Ensino</p></td>
    </tr>
    <tr>
      <td width="127"><p>FINANCEIRO</p></td>
      <td width="348"><p>Extrato financeiro. Gera&ccedil;&atilde;o de boletos.    Contas a pagar. Contas a receber. Controle de contas. Cadastro de    fornecedores. </p></td>
      <td width="192"><p>Alunos    / contas / funcion&aacute;rios da Unidade de Ensino. </p></td>
    </tr>
    <tr>
      <td width="127"><p>GESTOR</p></td>
      <td width="348"><p>PEDAG&Oacute;GICO / FINANCEIRO. </p></td>
      <td width="192"><p>Alunos / turmas / contas / funcion&aacute;rios da    Unidade de Ensino.</p></td>
    </tr>
    <tr>
      <td width="127"><p>ENSINO</p></td>
      <td width="348"><p>PEDAG&Oacute;GICO</p></td>
      <td width="192"><p>Rede</p></td>
    </tr>
    <tr>
      <td width="127"><p>ADM</p></td>
      <td width="348"><p>FINANCEIRO</p></td>
      <td width="192"><p>Rede</p></td>
    </tr>
    <tr>
      <td width="127"><p>LIVRARIA</p></td>
      <td width="348"><p>Extrato financeiro. Gera&ccedil;&atilde;o de boletos.    Contas a pagar. Contas a receber. Controle de contas. Cadastro de    fornecedores.</p></td>
      <td width="192"><p>Livraria</p></td>
    </tr>
    <tr>
      <td width="127"><p>DIRE&Ccedil;&Atilde;O</p></td>
      <td width="348"><p>ENSINO / ADM / LIVRARIA</p></td>
      <td width="192"><p>Rede. Livraria</p></td>
    </tr>
    <tr>
      <td width="127"><p>SUPORTE</p></td>
      <td width="348"><p>Fontes e banco de dados.</p></td>
      <td width="192"><p>Banco de dados</p></td>
    </tr>
  </table>
  <p><strong>Controle  de Acesso:</strong><br />
    - O acesso ao PINCEL AT&Ocirc;MICO exige a  identifica&ccedil;&atilde;o do usu&aacute;rio (login) e senha;<br />
    - O Sistema possuiu controle de &lsquo;logs&rsquo; de  forma a identificar os usu&aacute;rios e os processos utilizados.</p>
  <p><strong>Senhas  e Seguran&ccedil;a:</strong><br />
    - As senhas s&atilde;o sigilosas;<br />
    - Os logins (usu&aacute;rios) s&atilde;o pessoais e  intransfer&iacute;veis;<br />
    - A senha deve possuir, no m&iacute;nimo, 6 (seis)  d&iacute;gitos alfanum&eacute;ricos (letras e n&uacute;meros);<br />
    - Evite senhas &oacute;bvias; por exemplo, com as  inicias do nome do usu&aacute;rio e o ano em curso ou de nascimento;<br />
    - A cess&atilde;o dos dados de acesso para outro  usu&aacute;rio, funcion&aacute;rio ou qualquer outra pessoa acarretar&aacute; em penalidades e  responsabiliza&ccedil;&atilde;o do usu&aacute;rio pelos preju&iacute;zos ou danos materiais, financeiros e  morais que a empresa ou pessoas venham a sofrer;<br />
    - A cria&ccedil;&atilde;o de usu&aacute;rios (login) &eacute; fun&ccedil;&atilde;o do  SUPORTE do Sistema, a partir da solicita&ccedil;&atilde;o do GESTOR da Unidade de Ensino.</p>
  <p>&nbsp;</p>
  <p>D&uacute;vidas ou sugest&otilde;es devem ser encaminhadas  ao SUPORTE do PINCEL AT&Ocirc;MICO: </p>
  <p><strong>Patryky Prado </strong>&ndash; telefone (27)9845-0730 &ndash; E-mail patryky@cedtec.com.br</p>

</div>
<?php
include ('menu/footer.php');?>