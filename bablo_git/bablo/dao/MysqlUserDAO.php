<?php
namespace bablo\dao;

use bablo\dao\MysqlConnection;
use bablo\dao\UserDAO;
use bablo\model\User;
use bablo\util\MySQL;
class MysqlUserDAO implements UserDAO {
    public function find($id) {
        $stmt = MySQL::$db->prepare("SELECT id, email, name, password from user where id=:id");
        $stmt->bindParam('id', $id);
        $stmt->execute();
        while ($user = $stmt->fetchObject('\bablo\model\User')) {
            return $user;
        }
        return null;
    }

    public function findByNameAndPass($name, $pass) {
        $stmt = MySQL::$db->prepare("SELECT id, email, name, password from user where email=:email and password=password(:pass)");
        $stmt->bindParam('email', $name);
        $stmt->bindParam('pass', $pass);
        $stmt->execute();
        while ($user = $stmt->fetchObject('\bablo\model\User')) {
            return $user;
        }
        return null;
    }

    public function save(User $user) {
        
    }

//put your code here
}
