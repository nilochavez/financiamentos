<?php
session_start();
require_once ('classe_financiamento.php');
require_once ('classe_limpa_cache.php');





function formata_loja($host)
{

	

	$h = "";
	if ($host > 9 and $host < 100){
		
		
		$h = 'qql0'  .$host. '00.qq';
		
		
	}   elseif ($host < 10) {
		$h = 'qql00'  .$host. '00.qq';
		
	} else {
		$h = 'qql'  .$host. '00.qq';
	}

	return $h;
}




$_SESSION['host'];


var_dump($_SESSION['host']);

$limpa_cache = new LimpaCache();
$e = new Financiamento("prd",$_SESSION['host'],"201865",  "rt6AFONC");

if (isset($_GET['id_condicao_pagamento'])) 
{ 
	?>
	<div class="mb-3">
		<label for="formGroupExampleInput" class="form-label" ></label>
	</div>
	<form action="menu.php" method="post">
		<input type="hidden" class="form-control" name="host" value='<?php echo $_POST['host']; ?> '>
	</form>	
	<?php  
	$id_parcela = addslashes($_GET['id_condicao_pagamento']);
	
	try{
		$e->excluirParcela($id_parcela);
		$limpa_cache->limpaCache($_SESSION['host']);
		
		header("location: menu.php");
	}catch (Exception $e){
		header('Location:excluir_exception.php');
	}

	
	
}





?>