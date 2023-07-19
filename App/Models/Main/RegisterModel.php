<?php

namespace App\Models\Main;

class RegisterModel extends \myframework\Model
{

    protected string $tableName='user';

    public function add(){
        /**
         * @var $image \myframework\Http\File
         */
        $image = $this->request->file('image');
        if ($image)
        {
            $rand = rand(1000,10000).time();
            $imageFiled = $image->moveTo($this->root->concat('/public/images'),$rand);
        }
       return $this->db->set('first_name', $this->request->post('first_name'))
            ->set('last_name', $this->request->post('last_name'))
            ->set('user_group_id', 3)
            ->set('email', $this->request->post('email'))
            ->set('password', password_hash($this->request->post('password'), PASSWORD_DEFAULT))
            ->set('status', 'enabled')
            ->set('gender', (strtolower($this->request->post('gender'))=='male'))
            ->set('birthdate', strtotime($this->request->post('birthday')))
            ->set('ip', $this->request->server('REMOTE_ADDR'))
            ->set('created_date', $now = time())
            ->set('code', sha1($now . mt_rand()))
            ->set('image',$imageFiled)
            ->insert('user');
    }
}