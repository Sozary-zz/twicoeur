<?php
class postTable{
  public static function getPostById($id){
    $connection = new dbconnection() ;
    $sql = "select * from jabaianb.post where id=?;" ;

    $res = $connection->doQueryObject($sql, "post",[$id]);
    if($res === false)
      return false ;

    return $res ;
  }
  //permet de créer un post dans la base de donnée et retourne son id s'il est crée
public static function setNewPost($texte, $date, $image = NULL) {
  $connection = new dbconnection() ;
  $sql = "INSERT INTO jabaianb.post(texte, date, image) VALUES(:texte, :date, :image) ;";

  $res = $connection->doExec($sql, [$texte, $date, $image]);

  if($res === false)
    return false;

  return $connection->getLastInsertId("jabaianb.post");
}
}
