<?PHP
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta_plugin.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("dbforms/db_funcoes.php");
require_once("libs/db_app.utils.php");
require_once("libs/db_utils.php");
require_once("classes/db_slipdepartamento_classe.php");
db_postmemory($HTTP_POST_VARS);

db_app::load("scripts.js");
db_app::load("dbtextField.widget.js");
db_app::load("prototype.js");
db_app::load("datagrid.widget.js");
db_app::load("DBLancador.widget.js");
db_app::load("strings.js");
db_app::load("grid.style.css");
db_app::load("estilos.css");
db_app::load("classes/DBViewSlipPagamento.classe.js");
db_app::load("widgets/windowAux.widget.js");
db_app::load("widgets/dbmessageBoard.widget.js");
db_app::load("dbcomboBox.widget.js");
db_app::load("widgets/DBToogle.widget.js");

$oPost = db_utils::postMemory($_POST);
$oGet  = db_utils::postMemory($_GET);

$sDescricaoFieldSet  = "Alteração";
$lComponenteReadOnly = "false";

$oSlipDepartamento = db_utils::getDao("slipdepartamento");

$db_opcao = 22;
$db_botao = false;
if(isset($alterar)){

  $db_opcao = 2;
  $lErro    = false;

  db_inicio_transacao();
  
    $oSlipDepartamento->slip = $k17_codigo;
    $oSlipDepartamento->departamento = $coddepto;
    if (empty($sequencial)) {
      $oSlipDepartamento->sequencial = null;
      $oSlipDepartamento->incluir(null);
    } else {
      $oSlipDepartamento->sequencial = $sequencial;
      $oSlipDepartamento->alterar($sequencial);
    }

    $sMsgErro = $oSlipDepartamento->erro_msg;
    if ($oSlipDepartamento->erro_status == "0") {
      $lErro = true;
    }

  db_fim_transacao($lErro);
}else if(isset($chavepesquisa)){
   $db_opcao = 2;
   $result = $oSlipDepartamento->sql_record($oSlipDepartamento->sql_query_departamento($chavepesquisa)); 
   //echo $oSlipDepartamento->sql_query_departamento($chavepesquisa);
   db_fieldsmemory($result,0);
   $db_botao = true;
}

?>
<html>
<head>
<title>DBSeller Inform&aacute;tica Ltda - P&aacute;gina Inicial</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Expires" CONTENT="0">
<link href="estilos.css" rel="stylesheet" type="text/css">
<script src="scripts/widgets/DBAncora.widget.js" type="text/javascript"></script>
<script src="scripts/widgets/dbtextField.widget.js" type="text/javascript"></script>
</head>
<body bgcolor=#CCCCCC leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="a=1" >

<center>

<form name="form1" method="post" action="">

<div style="margin-top: 50px; width: 698px;">

	<fieldset >

	<legend><strong>Alteração de Departamento do Slip</strong></legend>

		<table border="0" align='left'>

      <tr>
        <td>
          <?
            db_input('sequencial',8,$sequencial,true,'hidden',3);
          ?>
        </td>
      </tr>
		  <tr>
		    <td nowrap >
		      <strong>
		        Slip:
		      </strong>
		    </td>
		    <td nowrap>
		      <?
		        db_input('k17_codigo',8,$k17_codigo,true,'text',3,"onchange='js_pesquisaSlip(false);'");
		      ?>
		      <!--  <input name="consultaslip" type="button" id="consultaslip" value="Consulta Slip" onclick="js_consultaslip();"> -->
		    </td>
		  </tr>
      
      <tr>
        <td>
          <strong>
            <? db_ancora("Departamento:","js_pesquisaDepartamento(true);", 1); ?>
          </strong>
        </td>
        <td>
          <?
            db_input('coddepto',8,$coddepto,true,'text',1,"onchange='js_pesquisaDepartamento(false);' onkeyup='js_ValidaCampos(this,1,\"\",\"\",\"\",event);' ");
            db_input('descrdepto',50,$descrdepto,true,'text',3,"onchange='js_pesquisaDepartamento(false);'");
          ?>
        </td>
      </tr>

	  </table>

	</fieldset>

	<div style="margin-top: 10px;">
	  <input name="<?=($db_opcao==1?"incluir":($db_opcao==2||$db_opcao==22?"alterar":"excluir"))?>" 
         type="submit" id="db_opcao" value="<?=($db_opcao==1?"Incluir":($db_opcao==2||$db_opcao==22?"Alterar":"Excluir"))?>" 
         <?=($db_botao==false?"disabled":"")?> >
    <input name="pesquisar" type="button" id="pesquisar" value="Pesquisar" onclick="js_pesquisaSlip();">
  </div>

</div>

</form>
</center>

<?
  db_menu(db_getsession("DB_id_usuario"),db_getsession("DB_modulo"),db_getsession("DB_anousu"),db_getsession("DB_instit"));
?>

</body>
</html>

<script>
//função de pesquisa para o Slip
function js_pesquisaSlip() {
  js_OpenJanelaIframe('top.corpo',
              'db_iframe_slip',
              'func_slipAutenticacao.php?lAltera=1&funcao_js=parent.js_preenchePesquisa|k17_codigo',
              'Pesquisar Slip',
              true);
}

function js_preenchePesquisa(chave){
  db_iframe_slip.hide();
  <?
    if($db_opcao!=1){
      echo " location.href = '".basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"])."?chavepesquisa='+chave";
    }
  ?>
 } 

//função de pesquisa para o departamento
function js_pesquisaDepartamento(mostra) {
  
  if (mostra==true) {
    var sUrl = 'func_departamento.php?lAltera=1&funcao_js=parent.js_mostraDepartamento1|coddepto|descrdepto';
      js_OpenJanelaIframe('top.corpo',
                          'db_iframe_departamento',
                          sUrl,
                          'Pesquisar Departamento',
                          true);
    } else {

    if ($('coddepto').value != '') {

      js_OpenJanelaIframe('top.corpo',
                          'db_iframe_departamento',
                          'func_departamento.php?lAltera=1&pesquisa_chave='+$('coddepto').value+
                          '&funcao_js=parent.js_mostraDepartamento',
                          'Pesquisar Departamento',
                          false);
    }
  }
}

//quando digita
function js_mostraDepartamento(chave,erro) {

  $('descrdepto').value = chave;
  if (erro == true) {

    $('coddepto').focus();
    $('coddepto').value = '';
  } 

}

//quando clica
function js_mostraDepartamento1(chave1, chave2) {

  $('coddepto').value = chave1;
  $('descrdepto').value = chave2;

  $('coddepto').focus();
  db_iframe_departamento.hide();
}

</script>

<?
  if (isset($alterar)) {

    if (!$lErro) {
      db_msgbox("Departamento do slip alterado com sucesso.");
      echo "<script>document.form1.pesquisar.click();</script>";
    } else {

      $db_botao = true;
      db_msgbox($sMsgErro);
      echo "<script> document.form1.db_opcao.disabled=false;</script>  ";
    }
  }
  if ($db_opcao == 22) {
    echo "<script>document.form1.pesquisar.click();</script>";
  }
?>
