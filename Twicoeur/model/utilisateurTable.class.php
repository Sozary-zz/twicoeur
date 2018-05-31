<?php

class utilisateurTable
{
	public static function getUserByLoginAndPass($login,$pass)
	{
		$connection = new dbconnection();
		$sql = "SELECT * from jabaianb.utilisateur where identifiant=? and pass=? ;" ;

		$res = $connection->doQueryObject($sql, "utilisateur", [$login, sha1($pass)]);

		if($res === false)
			return false;

		return $res;
	}

public static function updateUserAvatar($id,$name){
		$connection = new dbconnection();
	$sql = "UPDATE jabaianb.utilisateur SET avatar=? WHERE id=? ;";
	$connection->doExec($sql, [$name, $id]);
}

public static function updateUserPass($id,$currentPass,$newPass){
	$connection = new dbconnection();
	$sql = "SELECT * from jabaianb.utilisateur where id=? and pass=? ;" ;

	$res = $connection->doQueryObject($sql, "utilisateur", [$id, sha1($currentPass)]);

		if($res === false)
			return false;

	$sql = "UPDATE jabaianb.utilisateur SET pass=? WHERE id=? ;";
	$connection->doExec($sql, [sha1($newPass), $id]);

	return true;
}

	public static function getUserById($id)
	{
		$connection = new dbconnection() ;
		$sql = "SELECT * from jabaianb.utilisateur where id=? ;";

		$res = $connection->doQueryObject($sql, "utilisateur", [$id]);

		if($res === false)
			return false;

		return $res;
	}

	public static function getUsers()
	{
		$connection = new dbconnection() ;
		$sql = "SELECT * from jabaianb.utilisateur ORDER BY id;";

		$res = $connection->doQueryAllObject($sql, "utilisateur");

		if($res === false)
			return false;

		return $res;
	}

	public static function setUserInfo($id, $fname,$lname,$identifiant){
		$connection = new dbconnection();
		$sql = "UPDATE jabaianb.utilisateur SET prenom=?,nom=?,identifiant=?  WHERE id=? ;";
		$connection->doExec($sql, [$fname,$lname,$identifiant, $id]);
	}

	//renvoie l'id du premier utilisateur de la table => ce sera un id par défault
	public static function getFirstIdUser(){
		return utilisateurTable::getUsers()[0]->id;
	}

	//modifie le statut de l'utilisateur $id
	public static function setUserStatut($id, $statut){
		$connection = new dbconnection();
		$sql = "UPDATE jabaianb.utilisateur SET statut=? WHERE id=? ;";
		$connection->doExec($sql, [$statut, $id]);
	}
}
?>
