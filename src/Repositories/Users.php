<?php 
namespace AstroApp\Web\Prot\Priv\Reprositories;

use AstroApp\Web\Prot\Priv\Entities;

class Users{

  public static function get($_emailOfUserToGet){
    return new User();
  }

  public static function insert(\Entities\User $_userToInsert){
    //save item to db
  }

  public static function update(\Entities\User $_userToUpdate){
    //save item to db
  }
}
