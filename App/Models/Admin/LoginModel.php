<?php

namespace App\Models\Admin;

class LoginModel extends \myframework\Model
{

    protected string $tableName = 'user';


    public function isValidLogin($email,$password):false|\stdClass{
        $ret  = $this->app->db->select('email ,password,code')->where('email = ?',[$email])->fetchAll($this->tableName);
        // if( empty($ret) or ! password_verify($password,$ret[0]->password))
        //     return false;

        return $ret[0];
    }

    public function isCorrectLoginCode($code){
        return $this->app->db->where(' code = ?',[$code])->fetch($this->tableName);
    }
}