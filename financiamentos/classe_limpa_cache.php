<?php


class LimpaCache
{






	public function limpaCache($host)
	{
		$url = "http://".$host.":9000/cliqq/api/cache/clearAll";
		
		
		$ch = curl_init($url);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$resultado = json_decode(curl_exec($ch));
		
		

		if ($resultado == true) 
		{
			echo "<div class='alert alert-success alert-cache' role='alert'>
			Cache Limpo Com Sucesso </div>";
			
		}
		else
		{
			echo "Falha ao limpar Cache";
		}
		


	}


}

?>