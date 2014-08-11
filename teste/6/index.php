<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt" xml:lang="pt"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Inserção de dados em MySQL com PHP + AJAX</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
</head>
<body>
<div class="logo"><img src="img/logo_pplware.png" alt="Peopleware" title="Peopleware"/></div>
<div class="gravar">
		<div class="inputgravar">
			<div class="tituloinput">Preencha o seguinte formulário:</div>
			
			
            <input type="text" name="turma_disc"  id="turma_disc"  placeholder="turma_disc" /><br />
            <input type="text" name="n_aula" id="n_aula"  placeholder="n_aula" /><br />
            <input type="date" name="data" id="data"  /><br />
            
            <input type="text" name="matricula[]" id="matricula[]"  placeholder="matricula" /><br />
           <select id="falta" name="falta" onchange="javascript:inserir_registo()">
           <option value="P" selected="selected">P</option>
           <option value="F" >F</option>
           <option value="J" >J</option>
           </select><br />
           <br />
           <input type="text" name="matricula[]" id="matricula[]"  placeholder="matricula 2" /><br />
           <select id="falta" name="falta" onchange="javascript:inserir_registo()">
           <option value="P" selected="selected">P</option>
           <option value="F" >F</option>
           <option value="J" >J</option>
           </select><br />
		</div>
</div>
<script type="text/javascript">
function inserir_registo()
{
i = 1;
    //dados a enviar, vai buscar os valores dos campos que queremos enviar para a BD
var matricula  = document.getElementById('matricula');
var iElementos  = matricula.length;
var sBusca      = 'matricula[]';
var sValores    = '';

 for( var i = 0; i < iElementos; i++ )
      {
      if( matricula[ i ])
         {
             if( matricula[ i ].name == sBusca )
                {
                  var dadosajax = {
		
        'matricula' : matricula,
        'turma_disc' : $("#turma_disc").val(),
        'n_aula' : $("#n_aula").val(),
        'data_falta' : $("#data").val(),
        'falta' : $("#falta").val()
    };
                
	
	
    pageurl = 'grava.php';
    //para consultar mais opcoes possiveis numa chamada ajax
    //http://api.jquery.com/jQuery.ajax/
    $.ajax({
	
        //url da pagina
        url: pageurl,
        //parametros a passar
        data: dadosajax,
        //tipo: POST ou GET
        type: 'POST',
        //cache
        cache: false,
        //se ocorrer um erro na chamada ajax, retorna este alerta
        //possiveis erros: pagina nao existe, erro de codigo na pagina, falha de comunicacao/internet, etc etc etc
        error: function(){
            alert('Erro: Inserir Registo!!');
        },
        //retorna o resultado da pagina para onde enviamos os dados
        success: function(result)
        { 
            //se foi inserido com sucesso
            if($.trim(result) >= '1')
            {
				//alert("O seu registo foi inserido com sucesso!");
            }
            //se foi um erro
            else
            {
                alert("Ocorreu um erro ao inserir o seu registo!");
            }

        }
    });
}

}
                }
            }
</script>
</body>
</html>