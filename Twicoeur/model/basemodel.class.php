<?php

abstract class basemodel
{
	private $data = array();

	public function getAll()
      {
				$res = array();
				foreach($this->data as $att => $value) {
					$res[$att] = $value;
						$set[] = "$att = '".$value."'";

				}
    return $res;
      }

	public function __construct($array = NULL){
		if(!empty($array)){
			foreach ($array as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	public function save()
	{
		$connection = new dbconnection();
			$class = get_class($this) == "twic"?"tweet":get_class($this);
    if(isset($this->id)) {
      $sql = "update jabaianb.".$class." set ";
      $set = array();
      foreach($this->data as $att => $value) {
        if($att != 'id' && $value) {
          $set[] = "$att = '".$value."'";
        }
      }
      $sql .= implode(",", $set);
      $sql .= " where id=".$this->id;
    } else {

      $sql = "insert into jabaianb.".$class." ";
      $sql .= "(".implode(",",array_keys($this->data)).") ";
      $sql .= "values ('".implode("','",array_values($this->data))."')";
    }

    $connection->doExec($sql);

    $id = $connection->getLastInsertId("jabaianb.".$class);

    return $id == false ? NULL : $id;
	}

	public function __get($prop)
	{
		if(array_key_exists($prop, $this->data))
			return $this->data[$prop];
		return null;
	}

	public function __set($prop, $value)
	{
		$this->data[$prop]=$value;
	}

}
