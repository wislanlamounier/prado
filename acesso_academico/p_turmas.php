<?php include 'menu/menu.php'; ?>
<div class="conteudo">
<form id="form2" name="form1" method="GET" action="p_buscar_turmas.php">
    Ano / Semestre:
    <select name="grupo" class="textBox" id="grupo">
    <option value="nenhum">Escolha o Grupo</option>
    <?php
include("menu/config_drop.php");?>
    <?php
$sql2 = "SELECT distinct ct.grupo FROM ced_turma ct
INNER JOIN ced_turma_disc ctd
ON ctd.id_turma = ct.id_turma
WHERE ctd.cod_prof LIKE '$user_usuario'
ORDER BY ct.grupo";
$result = mysql_query($sql2);

while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['grupo'] . "'>" . $row['grupo'] . "</option>";
}
?>
  </select>

  <input type="submit" name="Buscar" id="Buscar" value="Buscar" />
</form>


</div>

<?php include 'menu/footer.php' ?>

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
</div>
</body>
</html>
