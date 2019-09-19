<?php namespace AstroApp.Reprositories

  class Users{

    public static function get(String $_emailOfUserToGet){
      return new User();
    }

    public static function insert(User $_userToInsert){
      //save item to db
    }

    public static function update(User $_userToUpdate){
      //save item to db
    }
  }
?>
