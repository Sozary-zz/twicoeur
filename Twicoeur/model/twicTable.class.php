<?php

class twicTable
{
	public static function getTweets(){
		$connection = new dbconnection() ;
		$sql = "SELECT * from jabaianb.tweet ORDER BY id DESC;";

		$res = $connection->doQueryAllObject($sql, "twic"); //fais une requette $sql qui renvoie des objets tweet

		if($res === false)
		  return false ;

		return $res ;
	}


		public static function getLimUsers($lim,$offset){
			$connection = new dbconnection() ;
			$sql = "SELECT * from jabaianb.tweet  LIMIT $lim OFFSET $offset";

			$res = $connection->doQueryAllObject($sql, "twic");

			if($res === false)
				return false;

			return $res;
		}


	public static function alreadySharedTwic($user_id,$post_id){
		$connection = new dbconnection() ;
		$sql = "SELECT * from jabaianb.tweet WHERE emetteur=? AND post=? ;";

		$res = $connection->doQueryObject($sql, "twic", [$user_id,$post_id]);

		if($res === false)
			return false ;

		return $res->parent == $user_id?false:true ;

	}

	public static function getTweetById($id){
		$connection = new dbconnection() ;
		$sql = "SELECT * from jabaianb.tweet WHERE id=? ;";

		$res = $connection->doQueryObject($sql, "twic", [$id]);

		if($res === false)
		  return false ;

		return $res ;
	}

	public static function getTweetsPostedBy($id){
		$connection = new dbconnection() ;
		//ici il y a un argument $id donc le 3éme argument de Query est $id (pour éviter l'injection sql)
		$sql = "SELECT * from jabaianb.tweet WHERE emetteur=? ORDER BY id DESC;";

		$res = $connection->doQueryAllObject($sql, "twic", [$id]);

		if($res === false)
		  return false ;

		return $res ;
	}

	//créer un nouveau tweet dans la base et un post qui lui correspond
	// public static function setNewTweet($emetteur, $parent, $texte, $image = NULL) {
	// 	$connection = new dbconnection() ;
	//
	// 	$date = date("Y-m-d H:i:s");
	// 	$post = postTable::setNewPost($texte, $date, $image);
	//
	// 	$sql = "INSERT INTO jabaianb.tweet(emetteur, parent, post, nbvotes) VALUES(:emetteur, :parent, :post, :nbvotes) ;";
	//
	// 	$connection->doExec($sql, [$emetteur, $parent, $post, 0]);
	// }

	//permet de mettre un "j'aime" sur un twic si l'utilisateur ne l'avais pas déjà fait et de l'enveler sinon
	public static function vote($id_twic, $id_user) {
		$connection = new dbconnection();

		$twic = voteTable::updateVote($id_twic, $id_user); //retourne le twic avec son vote modifié
		$sql = "UPDATE jabaianb.tweet SET nbvotes=? WHERE id=? ;"; //il reste plus qu'à le modifier dans la table
		$connection->doExec($sql, [$twic->nbvotes, $id_twic]);
	}

	//renvoie un nombre $nombre de twic aléatoire
	public static function getRandTweets($nombre) {
		$connection = new dbconnection();
		// $sql = "SELECT id from jabaianb.tweet order by id;";
		// $all_id = $connection->doQueryAll($sql); //on prend tous les id de la base
		//
		// if(count($all_id) == 0)
		// 	return $all_id;
		//
		// $array_id = array();
		// foreach ($all_id as $value)
		// 	array_push($array_id, $value['id']); //on les met à la queue dans un array
		// $keys = array_rand($array_id, count($array_id)); //on prend un nombre $nombre de clefs aléatoire dans $array_id
		// $tweets_id = array();
		// foreach ($keys as $value)
		// 	array_push($tweets_id, $array_id[$value]); //on récupère les id des tweets grâce à leurs clefs
		//
		// $tweets = array();
		// foreach ($tweets_id as $value)
		// 	array_push($tweets, twicTable::getTweetById($value)); //enfin on recupère tous les tweets grâce à leurs id
		//
		// return $tweets; //on renvoie le tableau d'objet de tweet aléatoire

		$sql = "SELECT * from jabaianb.tweet;";

		$res = $connection->doQueryAllObject($sql, "twic");
		if($res === false)
			return false ;

		return $res ;

	}
}

?>
