<?php

namespace my_project\models\users;
use my_project\models\ActiveRecordEntity;

class User extends ActiveRecordEntity
{
    protected $nickname, $email, $isConfirmed, $role, $passwordHash, $authToken, $createdAt; 

    
    public function getNickName():string{
        return $this->nickname;
    }

    protected static function getTableName(): string 
    {
        return 'users';
    }
}
?>