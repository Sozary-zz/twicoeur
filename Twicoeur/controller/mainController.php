<?php
/*
 * Controler
 */

class mainController
{

	public static function helloWorld($request,$context)
	{
			if(!empty($context->getSessionAttribute('id'))){
				$context->mavariable="hello world";
				return context::SUCCESS;
			}

			return context::ERROR;
	}

	public static function changePass($request,$context){
			if(!empty($context->getSessionAttribute('id'))){
		return context::SUCCESS;
	}
	return context::ERROR;
	}
	public static function changeAvatar($request,$context){
			if(!empty($context->getSessionAttribute('id'))){
		return context::SUCCESS;
	}
	return context::ERROR;
	}

	public static function updateAvatar($request,$context){
			if(!empty($context->getSessionAttribute('id'))){
		if(isset($request['pic'])){
			if($request['pic'] != "NULL"){
				$new_pic = htmlspecialchars($request['pic']);
				$context->setSessionAttribute('avatar',	$context->getSessionAttribute('url').$new_pic);

				utilisateurTable::updateUserAvatar($context->getSessionAttribute('num'),	$context->getSessionAttribute('avatar'));
				$context->redirect('?action=changeInfo');
				return context::SUCCESS;
			}
		}}

		return context::ERROR;
	}

	public static function updatedPass($request,$context){
	if(!empty($context->getSessionAttribute('id'))){
			$res = utilisateurTable::updateUserPass($context->getSessionAttribute('num'),$request['current-pass'],$request['new-pass-1']);

			if($res == false)
				return context::ERROR;

			$context->redirect('?action=showAccount&id='.$context->getSessionAttribute('num'));
			return context::SUCCESS;
		}
		return context::ERROR;
	}

	public static function updateStatus($request,$context){
			if(!empty($context->getSessionAttribute('id'))){
				if(isset($request['status-content'])){
					utilisateurTable::setUserStatut($context->getSessionAttribute('num'),$request['status-content']);
					$context->setSessionAttribute('statut',$request['status-content']);
					return context::SUCCESS;
				}
			}
		return context::ERROR;
	}

	public static function showAccount($request,$context){
			if(isset($request['id']) &&!empty($context->getSessionAttribute('id'))){
				$res = utilisateurTable::getUserById($request['id']);

				if(empty($res)){
					$context->msg=["alert alert-dismissible alert-danger","Utilisateur","Utilisateur inconnu"];
					return context::ERROR;
				}

				$context->num = $res->id;
				$context->id=$res->identifiant;
				$context->fname=$res->prenom;
				$context->lname=$res->nom;
				$context->avatar=$res->avatar;
				$context->statut=$res->statut;
				$context->bday=$res->date_de_naissance;

				$context->allUsers = utilisateurTable::getUsers();
				$context->twicsList= twicTable::getTweetsPostedBy($res->id);


				$allPosts = array();
				for($i=0;$i<count($context->twicsList);$i++)
					array_push($allPosts,postTable::getPostById($context->twicsList[$i]->post));

				return context::SUCCESS;
			}
			return context::ERROR;
	}
	public static function changeInfo($request,$context){
		if(!empty($context->getSessionAttribute('id'))){
			return context::SUCCESS;
		}
			return context::ERROR;
	}
	public static function updatedInfo($request,$context){
			if(!empty($context->getSessionAttribute('id'))){
			$context->setSessionAttribute('fname',htmlspecialchars($request['fname']));
			$context->setSessionAttribute('lname',htmlspecialchars($request['lname']));
			$context->setSessionAttribute('id',htmlspecialchars($request['identifiant']));
			utilisateurTable::setUserInfo($context->getSessionAttribute('num'),htmlspecialchars($request['fname']),htmlspecialchars($request['lname']),htmlspecialchars($request['identifiant']));
			$context->redirect('?action=showAccount&id='.$context->getSessionAttribute('num'));

			return context::SUCCESS;}
			return context::ERROR;

	}
	public static function voteTwic($request,$context){
		if(isset($request['id']) && !empty($context->getSessionAttribute('id'))){
				twicTable::vote($request['id'],$context->getSessionAttribute('num'));
				echo twicTable::getTweetById($request['id'])->nbvotes;

				return context::NONE;
		}
	}
	public static function flux($request,$context){
		if(!empty($context->getSessionAttribute('id'))){

				$context->twicsList = twicTable::getLimUsers(5,0);
				return context::SUCCESS;
		}
		return context::ERROR;
	}

	public static function infFlux($request,$context){
		if( isset($request['offset']) && !empty($context->getSessionAttribute('id'))){
				$res =  twicTable::getLimUsers(5,$request['offset']);
				for($i=0;$i<count($res);$i++){
						$res[$i]=$res[$i]->getAll();

						$parent= utilisateurTable::getUserById($res[$i]['parent']);
						$res[$i]['parent_pic'] = htmlspecialchars($parent->avatar);
						$res[$i]['parent_pic']=$res[$i]['parent_pic'] ==""?"https://pedago02a.univ-avignon.fr/~uapv1602171/squelette/images/avatar/user.svg":$res[$i]['parent_pic'];
						$res[$i]['parent_name'] = htmlspecialchars($parent->identifiant);

						$emetteur= utilisateurTable::getUserById($res[$i]['emetteur']);
						$res[$i]['emetteur_pic'] = htmlspecialchars($parent->avatar);
						$res[$i]['emetteur_pic']= 	$res[$i]['emetteur_pic'] ==""?"https://pedago02a.univ-avignon.fr/~uapv1602171/squelette/images/avatar/user.svg":	$res[$i]['emetteur_pic'];
						$res[$i]['emetteur_name'] = htmlspecialchars($parent->identifiant);

						$post = postTable::getPostById($res[$i]['post']);
						$res[$i]['post_pic'] = htmlspecialchars($post->image);
					  $res[$i]['post_text'] = $post->texte;
					  $res[$i]['post_date'] = $post->date;

						$res[$i]['voted']= voteTable::getVoteByUserAndTweet($context->getSessionAttribute('num'),$res[$i]['id'])?"true":"false";
						$res[$i]['shared']= twicTable::alreadySharedTwic($context->getSessionAttribute('num'),$res[$i]['post'])?"true":"false";
					  $res[$i]['self_shared'] = $res[$i]['parent'] == $context->getSessionAttribute('num')? "true":"false";
				}

				if(count($res)!=0)
				echo json_encode($res);
				else
				echo json_encode("");
				return context::NONE;
		}
		return context::ERROR;
	}

	public static function newPost($request,$context){
			if(!empty($context->getSessionAttribute('id'))){
		if(isset($request['twic-content'],$request['twic-pic'])){
			$postData['texte'] = htmlspecialchars($request['twic-content']);
			$postData['image'] = htmlspecialchars($request['twic-pic']);
			$postData['date'] = date("Y-m-d H:i:s");

			$post = new post($postData);

			$postId= $post->save();

			$twicData['emetteur'] = $context->getSessionAttribute('num');
			$twicData['parent'] = $context->getSessionAttribute('num');
			$twicData['post'] = $postId;
			$twicData['nbVotes'] = 0;

			$twic = new twic($twicData);
			$twicId= $twic->save();

			$context->newTwic = $twic;
			$context->newTwicId= $twicId;
			return context::SUCCESS;
		}}
		return context::ERROR;
	}

	public static function disconnect($request,$context){
			if(!empty($context->getSessionAttribute('id'))){
		$context->setSessionAttribute('id',null);
		$context->redirect('?action=welcome');
		return context::SUCCESS;}
		return context::ERROR;
	}

	public static function welcome($request,$context){
	if(!empty($context->getSessionAttribute('id')))
			$context->redirect('?action=account');
		return context::SUCCESS;
	}

	public static function account($request,$context){
		if(empty($context->getSessionAttribute('id'))){
				$context->redirect('?action=welcome');
				return context::SUCCESS;
		}
		$context->redirect('?action=showAccount&id='.$context->getSessionAttribute('num'));

		return context::SUCCESS;
	}

	public static function index($request,$context)
	{
		return context::SUCCESS;
	}

	public static function superTest($request,$context){
		foreach ($request as $key=>$value)
    	if($key!="action")
				$context->$key=$value;

		return context::SUCCESS;
	}

	public static function shareTwic($request,$context){
		if(isset($request['id']) && !empty($context->getSessionAttribute('id'))){
				$twic = twicTable::getTweetById($request['id']);

				$twicData['emetteur'] = $context->getSessionAttribute('num');
				$twicData['parent'] = $twic->parent;
				$twicData['post'] = $twic->post;
				$twicData['nbVotes'] = 0;

				$newTwic = new twic($twicData);
				$newTwic->save();


				return context::NONE;
		}
	}

	public static function login($request,$context){
		if(isset($request['id'],$request['pass'])){
			$context->id = htmlspecialchars($request['id']);
			$context->pass = htmlspecialchars($request['pass']);

			$res = utilisateurTable::getUserByLoginAndPass(htmlspecialchars($request['id']),htmlspecialchars($request['pass']));

			if(empty($res)){
				$context->msg=["alert alert-dismissible alert-danger","Connection","Mauvaise combinaison mot de passe/identifiant"];
				return context::ERROR;
			}
			$full_url = $_SERVER['REQUEST_URI'];
			$short_url = "";

			for($i=0;$full_url[$i]!='?';$i++)
				$short_url.=$full_url[$i];
			for($i=strlen($short_url)-1;$short_url[$i]!='/';$i--)
				$short_url = substr($short_url,0,-1);

			$context->setSessionAttribute('url','https://pedago02a.univ-avignon.fr'.$short_url);
			$context->setSessionAttribute('num',$res->id);
			$context->setSessionAttribute('id',$res->identifiant);
			$context->setSessionAttribute('fname',$res->prenom);
			$context->setSessionAttribute('lname',$res->nom);
			$context->setSessionAttribute('avatar',$res->avatar);
			$context->setSessionAttribute('statut',$res->statut);
			$context->setSessionAttribute('bday',$res->date_de_naissance);

			$context->redirect('?action=account');

		}

		return context::SUCCESS;
	}

}
