<?php

namespace App\Models\Admin;

use myframework\Application;
use myframework\Model;

class CategoryModel extends Model
{

    protected string $tableName = 'category';

    protected array $categories = [];



    public function __construct($app)
    {
        parent::__construct($app);
        $this->loadAll();
    }


    public function add($name,$parentId=0,$status=1):bool{
        return $this->app->db->set(['name'=>$name,'parent_id'=>$parentId])->insert($this->tableName);
    }

    public function update($id,$name,$parentId,$status){
        return $this->app->db
            ->set(['name'=>$name,'parent_id'=>$parentId])
            ->where('id = ?',[$id])
            ->update($this->tableName);
    }

    public function getAll(){
        return $this->db->from('category c ')
        ->select('c.* ,(select count(p.id) from post p where p.category_id=c.id) as "postsCount" ')
        ->fetchAll();
    }
    private function loadAll()
    {
        $this->categories = $this->getAll();
    }

    /**
     * @return  array $categories
     */
    public function getCategories( ): array
    {
        if(empty($this->categories))
            $this->loadAll();
        return $this->categories ;
    }

}