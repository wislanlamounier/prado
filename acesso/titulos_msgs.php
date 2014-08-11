<?php
include ('menu/tabela.php');// inclui o menu
include ('includes/conectar.php');// inclui o menu
$sql_msg2 = mysql_query("SELECT * FROM msgs WHERE (id_pessoa LIKE '$user_iduser' OR nivel LIKE '$user_acessos' OR unidade LIKE '$user_unidade' OR empresa LIKE '$user_empresa') ORDER BY data_envio, datahora DESC");
$total_msg2 = mysql_num_rows($sql_msg2);

?>
<div style="width:350px">
<?php 
if($total_msg2 >=1){
	echo "<table width=\"100%\" class=\"full_table_list\" border=\"1\">
	<tr>
			<td colspan=\"2\"><a href=\"javascript:abrir('nova_mensagem.php');\">[+] Nova Mensagem</a></td>
		</tr>
";
	while($dados_msg2 = mysql_fetch_array($sql_msg2)){
		$id_msg = $dados_msg2["id_msg"];
		$enviado_msg = $dados_msg2["enviado"];
		$visto_msg = $dados_msg2["visto"];
		$texto_msg = substr($dados_msg2["texto"],0,30)."...";
		if($visto_msg == 1){
			$comp_msg= "style='font-weight:bold;'";
		} else {
			$comp_msg= "";
		}
		echo "
		<tr>
			<td $comp_msg ><a style=\"color:#000\" href=\"corpo_msg.php?id=$id_msg\" target=\"corpo_msg\">$enviado_msg</a></td>
			<td $comp_msg ><a style=\"color:#000\" href=\"corpo_msg.php?id=$id_msg\" target=\"corpo_msg\">$texto_msg</a></td>
		</tr>";
	}
} else {
		echo "<table width=\"100%\" class=\"full_table_list\" border=\"1\">
		<tr>
			<td colspan=\"2\"><a href=\"javascript:abrir('nova_mensagem.php');\">[+] Nova Mensagem</a></td>
		</tr>
		<tr>
			<td colspan=\"2\" align=\"center\">N&atilde;o h&aacute; mensagens.</td>
		</tr>
		</table>
		
";
}
echo "</table>";
?>

</div>