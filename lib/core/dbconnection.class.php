<?php

define ('HOST', 'localhost') ;
define ('USER', 'uapv1602171'  ) ;
define ('PASS', 'NrxTCT' ) ;
define ('DB', 'etd' ) ;

class dbconnection
{
  private $link, $error ;

  public function __construct()
  {
    $this->link = null;
    $this->error = null;
    try{
        $this->link = new PDO('pgsql:host='.HOST.';dbname='.DB, USER, PASS);
    }catch( PDOException $e ){
        $this->error =  $e->getMessage();
    }
  }

  public function getLastInsertId($att)
  {
    return $this->link->lastInsertId($att."_id_seq");
  }

  public function doExec( $sql , $attributes=NULL)
  {
    $prepared = $this->link->prepare( $sql );
    return $prepared->execute($attributes);
  }


  public function doQuery($sql, $attributes=NULL) //gère les injections SQL, on le met à NULL au cas où il n'y est pas d'attributs
	{
		$prepared = $this->link->prepare($sql);
		$prepared->execute($attributes);
		$res = $prepared->fetchAll( PDO::FETCH_ASSOC );
		if(!empty($res))
			$res = $res[0]; //cette methode est utilisée lorsqu'il y a un seul objet
		else
			return false;

		return $res;
	}

	public function doQueryAll($sql, $attributes=NULL) //gère les injections SQL, on le met à NULL au cas où il n'y est pas d'attributs
	{
		$prepared = $this->link->prepare($sql);
		$prepared->execute($attributes);
		$res = $prepared->fetchAll( PDO::FETCH_ASSOC );

		return $res;
	}

	public function doQueryObject( $sql, $className, $attributes=NULL ) //gère les injections SQL
	{
		$prepared = $this->link->prepare( $sql );
		$prepared->execute($attributes);
		$res = $prepared->fetchAll( PDO::FETCH_CLASS, $className );
		if(!empty($res)){
			$res = $res[0]; //cette methode est utilisée lorsqu'il y a un seul objet
		}
		else
			return false;

		return $res;
	}

	public function doQueryAllObject( $sql, $className, $attributes=NULL ) //gère les injections SQL
	{
		$prepared = $this->link->prepare( $sql );
		$prepared->execute($attributes);
		$res = $prepared->fetchAll( PDO::FETCH_CLASS, $className );

		return $res;
	}

  public function __destruct()
  {
    $this->link = null;
  }
}
