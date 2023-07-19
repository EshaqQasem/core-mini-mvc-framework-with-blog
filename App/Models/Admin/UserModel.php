<?php

namespace App\Models\Admin;

use myframework\File;

class UserModel extends \myframework\Model
{

    protected string $tableName='user';

    public function getAll(){
        return $this->db->from('user u')->join('user_group  ug on u.user_group_id = ug.id ')
        ->select('u.id ,u.first_name,u.last_name,u.image,u.email,u.status,u.created_date, ug.name as "group" ')->fetchAll();
    }
    public function add()
    {
        /**
         * @var $image \myframework\Http\File
         */
        $image = $this->request->file('image');
        if ($image)
        {
            $rand = rand(1000,10000).time();
            $imageFiled = $image->moveTo($this->root->concat('/public/images'),$rand);
        }
        $this->db->set('first_name', $this->request->post('first_name'))
            ->set('last_name', $this->request->post('last_name'))
            ->set('user_group_id', $this->request->post('users_group_id'))
            ->set('email', $this->request->post('email'))
            ->set('password', password_hash($this->request->post('password'), PASSWORD_DEFAULT))
            ->set('status', $this->request->post('status'))
            ->set('gender', (strtolower($this->request->post('gender'))=='male'))
            ->set('birthdate', strtotime($this->request->post('birthday')))
            ->set('ip', $this->request->server('REMOTE_ADDR'))
            ->set('created_date', $now = time())
            ->set('code', sha1($now . mt_rand()))
            ->set('image',$imageFiled)
            ->insert('user');
    }

    public function hasAccess($userId,$route){
        $userGroupId = $this->getById($userId)->user_group_id;
        $res = $this->db->select('id')
            ->where("user_group_id =$userGroupId  and route = ?",[$route])
            ->fetch('user_group_permission');
        return !($res === false);
    }


}