<?php

class voteTable //j'ai pas créée de classe vote donc je fais des doQuery simple
{
	public static function getVoteById($id)
	{
		$connection = new dbconnection();
		$sql = "SELECT * from jabaianb.vote where id=? ;";

		$res = $connection->doQuery($sql, [$id]);

		if($res === false)
			return false;

		return $res;
	}

	public static function getVotes()
	{
		$connection = new dbconnection();
		$sql = "SELECT * from jabaianb.vote ORDER BY id;";

		$res = $connection->doQueryAll($sql);

		if($res === false)
			return false;

		return $res;
	}

	public static function getVoteByUser($user)
	{
		$connection = new dbconnection();
		$sql = "SELECT * from jabaianb.vote where utilisateur=? ;";

		$res = $connection->doQuery($sql, [$user]);

		if($res === false)
			return false;

		return $res;
	}

	//retourne un vote par son id_user et son id_tweet
	public static function getVoteByUserAndTweet($user, $tweet)
	{
		$connection = new dbconnection();
		$sql = "SELECT * from jabaianb.vote where utilisateur=? AND message=? ;";

		$res = $connection->doQuery($sql, [$user, $tweet]);

		if($res === false)
			return false;

		return $res;
	}

	//permet de créer un vote s'il n'existe pas, sinon retourne le vote existant
	public static function setVote($twic, $user)
	{
		$vote = voteTable::getVoteByUserAndTweet($user, $twic);

		if($vote !== false) //si le vote existe on le return (pour pouvoir le delete dans updateVote)
			return $vote;

		$connection = new dbconnection(); //sinon on le créer
		$sql = "INSERT INTO jabaianb.vote(utilisateur, message) VALUES(:utilisateur, :message) ;";

		$connection->doExec($sql, [$user, $twic]);

		return true;
	}

	public static function updateVote($id_twic, $id_user) {
		$connection = new dbconnection();

		$twic = twicTable::getTweetById($id_twic); //on récupère le twic
		$vote = voteTable::setVote($id_twic, $id_user); //on récupère le vote

		if($vote !== true) { //si setVote() ne renvoie pas true c'est qu'il faut supprimer le vote de la table et dislike le twic
			$sql = "DELETE FROM jabaianb.vote WHERE id=? ;";
			$connection->doExec($sql, [$vote['id']]);
			$twic->nbvotes --;
		}
		else //sinon il faut le like
			$twic->nbvotes ++;

		return $twic;
	}

}
