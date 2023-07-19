<?php

namespace myframework;

abstract class Model
{

    protected Application $app;

    protected string $tableName;
    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getById($id){
        return $this->app->db->where('id = ?',[$id])->fetch($this->tableName);
    }

    public function getAll(){
        return  $this->app->db->fetchAll($this->tableName);
    }

    public function delete($id)
    {
        return $this->app->db->where('id = ?',[$id])->delete($this->tableName);
    }

    public function __get($key){
        return $this->app->get($key);
    }
}