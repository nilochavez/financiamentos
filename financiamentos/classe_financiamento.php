<?php

/**
 * 
 */
class Financiamento 
{
	
	private $pdo;
	

	public function __construct($dbname, $host, $user, $senha)
	
	{
		try
		{
			
			
			$this->pdo = new PDO("pgsql:host=$host; port=5432;dbname=$dbname user = $user password = $senha");

			//$this->pdo = new PDO("mysql:dbname=".$dbname
				//.";host=".$host,$user,$senha,'port=$port');
			
		}
		catch(PDOexception $e){
			echo "Erro com banco de dados ".$e->getMessage();
			exit();

		}
		catch(exception $e){
			echo "Erro generico ".$e->getMessage();
			exit();
			
		}
		
	}


	


	//FUNCAO CONECTA E BUSCA NO BANCO - MOSTRA A CONSULTA NAS TABELAS
	public function buscarDados()
	{
		$res  = array();
		$cmd = $this->pdo->query("select id,id_condicao_pagamento ,prazo_entre_parcelas ,altera_dia_minimo ,altera_dia_maximo,ativo   from forma_condicao_pagamento where id_forma_pagamento = 52 order by id_condicao_pagamento ");
		$res = $cmd->fetchALL(PDO::FETCH_ASSOC);
		return $res;

	}

	// funcao cadastrar parcela no banco
	public function Cadastrar($ativo,$id_condicao_pagamento, $prazo_entre_parcelas, $altera_dia_minimo, $altera_dia_maximo)
	{
		
		$cmd = $this->pdo->prepare("select id_condicao_pagamento from forma_condicao_pagamento where id_forma_pagamento = 52 and id_condicao_pagamento = :id_condicao_pagamento order by id_condicao_pagamento ");
		$cmd->bindValue(":id_condicao_pagamento" , $id_condicao_pagamento);
		$cmd->execute();
		if ($cmd->rowCount() > 0) // verifica se id ja existe
		{	
			echo "<div class='alert alert-danger' role='alert'>
			Número da Parcela Já Cadastrada!</div>";
			return false;
		}else // naõ foi encontrado o id_condicao_pagamento
		{



			$cmd = $this->pdo->prepare(" INSERT INTO forma_condicao_pagamento
				(ativo,id_forma_pagamento, id_condicao_pagamento, prazo_entre_parcelas, altera_data_parcela, altera_dia_minimo, altera_dia_maximo, parcela_ideal, id_cpg, sem_juros,  usuario_inclusao, data_inclusao, usuario_alteracao, data_ultima_alteracao, preferencia)
				VALUES( :ativo,52, :id_condicao_pagamento, :prazo_entre_parcelas, false, :altera_dia_minimo, :altera_dia_maximo, false, 52, true,'APLICACAO WEB', CURRENT_DATE, 'ROBO - FORMA_PAGAMENTO', CURRENT_DATE, 1); ");

			$cmd->bindValue(":ativo", $ativo);
			$cmd->bindValue(":id_condicao_pagamento", $id_condicao_pagamento);
			$cmd->bindValue(":prazo_entre_parcelas", $prazo_entre_parcelas);
			$cmd->bindValue(":altera_dia_minimo", $altera_dia_minimo);
			$cmd->bindValue(":altera_dia_maximo", $altera_dia_maximo);
			$cmd->execute();
			return true;


		}

	}


	public function excluirParcela($id)
	{

		
		$cmd = $this->pdo->prepare(" delete from forma_condicao_pagamento where id_forma_pagamento = 52 and id_condicao_pagamento = :id_condicao_pagamento");
		
		$cmd->bindValue(":id_condicao_pagamento", $id);
		$cmd->execute();

	}



	public function buscarDadosParcela($id)
	{
		$res = array();
		$cmd = $this->pdo->prepare(" select ativo,id,id_condicao_pagamento ,prazo_entre_parcelas ,altera_dia_minimo ,altera_dia_maximo  from forma_condicao_pagamento where id_forma_pagamento = 52 and id = :id;");
		$cmd-> bindValue(":id",$id);
		$cmd-> execute();
		$res = $cmd->fetch(PDO::FETCH_ASSOC);
		return $res; 

	}


	public function atualizarDados($ativo,$id,$id_condicao_pagamento,$prazo_entre_parcelas,$altera_dia_minimo,$altera_dia_maximo)
	{

		$cmd = $this->pdo->prepare(" UPDATE forma_condicao_pagamento SET ativo= :ativo, id_condicao_pagamento = :id_condicao_pagamento ,prazo_entre_parcelas = :prazo_entre_parcelas, altera_dia_minimo = :altera_dia_minimo, altera_dia_maximo = :altera_dia_maximo WHERE id = :id  ");
		$cmd->bindValue(":ativo", $ativo);
		$cmd->bindValue(":id", $id);
		$cmd->bindValue(":id_condicao_pagamento", $id_condicao_pagamento);
		$cmd->bindValue(":prazo_entre_parcelas", $prazo_entre_parcelas);
		$cmd->bindValue(":altera_dia_minimo", $altera_dia_minimo);
		$cmd->bindValue(":altera_dia_maximo", $altera_dia_maximo);
		
		$cmd-> execute();


	}




}







?>
