<?php

namespace App\Models\Admin;

use http\Env\Response;
use myframework\Http\Request;

class PostModel extends \myframework\Model
{

    protected string $tableName='post';

    public function add(){
        /**
         * @var $request Request
         */
        $request = $this->request;
        $data=[];
        $data['user_id'] = $this->load->controller('Admin/Login')->isLogged()->id;
        $data['category_id'] = $request->post('category_id');
        $data['title'] = $request->post('title');
        $data['details'] = $request->post('details');
        $data['status'] = $request->post('status');
        $tags = explode(',',$request->post('tags'));
        //$data['relateds'] = $request->post('category_id');
        $image = $request->file('image');

        $rand = rand(1000,10000).time();
        $data['image'] = $image->moveTo('public/images/posts',$rand);
        $data['created'] = time();
        $this->db->set($data)->insert($this->tableName);
    }

    public function getLatestPosts($count = 10){
        return $this->fullPostInfo()
            ->limit($count)
            ->orderBy('created')
            ->fetchAll();
    }

    public function fullPostInfo(){
       return $this->db->from('post p')
        ->select('p.*, concat(u.first_name,concat(" ",u.last_name)) as "userName" ,c.name as "categoryName" ')
        ->select(' (select count(com.*) from comment com where p.id = com.post_id) as "commentCount" ' )
        ->leftJoin('user u on u.id = p.user_id ')
        ->leftJoin('category c on c.id = p.category_id');
    }
}