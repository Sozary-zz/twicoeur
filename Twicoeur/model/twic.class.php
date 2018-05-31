<?php

class twic extends basemodel {
  public function getPost(){
		$id_post = $this->post; //renvoie l'id du post contenu dans le tweet

		return postTable::getPostById($id_post); //renvoie un objet post grâce à son id
	}

	public function getParent(){
		$id_user = $this->parent;
		return utilisateurTable::getUserById($id_user); //renvoie l'utilisateur parent du twic
	}

	public function getEmetteur(){
		$id_user = $this->emetteur;
		return utilisateurTable::getUserById($id_user); //renvoie l'utilisateur emetteur du twic
	}

	public function getLikes(){
		return $this->nbvotes;
	}
}
