<?php

namespace myframework\Data;

use myframework\Application;
use PDO;
use PDOException;
use PDOStatement;

class DataBase
{

    private Application $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->connect();
    }

    public string $dataBaseName;
    private string $serverName;
    private string $dbType;
    private string $username;
    private string $password;
    private PDO $pdoObj;
    private bool $connected=false;

    private static ?DataBase $instance = null;


    private $tableName;

    private $values = [];

    private $bindings = [];

    private $wheres = [];

    private $selects = [];

    private int $lastId;

    private $whereSql ='';

    private ?int $limit=null;

    private  $offset;

    private $joins=[];

    private  $orderBy;
    /**
     * @param $dataBaseName
     */


    public static function getInstance():DataBase{
        if( is_null(static::$instance) ){
            static::$instance = new DataBase();
        }
        return static::$instance;
    }

    private function connect()
    {
        try {
            $config = $this->app->root->concat('config.php');
            $config = require $config;
            extract($config);
            $connectionString = "mysql:host=$server;dbname=$dbname";
            $this->pdoObj = new PDO($connectionString, $dbuser, $dbpassword);
            $this->pdoObj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connected = true;
        }catch (PDOException $exp){
            die($exp->getMessage());
        }

    }

    public function connectionObj(){
        return $this->pdoObj;
    }

    public function isConnected():bool{
        return true;
    }

    public function table($tableName){
        $this->tableName = $tableName;
        return $this;
    }

    public function from($tableName){
        $this->tableName = $tableName;
        return $this;
    }

    public function select(){
        
        $tmp=func_get_args();
        foreach($tmp as $sel)
        $this->selects[] = $sel;
        /*if(count($this->selects)==1 && is_array($this->selects[0])){
            $this->selects[] = $this->selects[0];
        }*/
        return $this;
    }

    public function join($join){

        $this->joins[] = 'inner join ' .$join;
        return $this;
    }

    public function rightJoin($join){

        $this->joins[] = 'right join ' .$join;
        return $this;
    }

    public function leftJoin($join){

        $this->joins[] = 'left join ' .$join;
        return $this;
    }

    public function limit($limit){
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset){
    $this->offset = $offset;
    return $this;
}

    public function orderBy($column,$type='DESC'){
        $this->orderBy = $column.' '.$type;
        return $this;
    }

    public function fetch($tableName = null)
    {
        return $this->preFetch($tableName)->fetch(PDO::FETCH_OBJ);
    }

    public function fetchAll($tableName = null)
    {
        return $this->preFetch($tableName)->fetchAll(PDO::FETCH_OBJ);
    }

    private function preFetch($tableName = null){

        $this->tableName = $tableName ?? $this->tableName;
        $sql = 'select ';
        if(count($this->selects)>0){
            $sql.= implode(',',$this->selects);
        }else{
            $sql.= ' * ';
        }
        $sql.= ' from '.$this->tableName.' ';
        foreach($this->joins as $join){
            $sql.=$join.' ';
        }
        
        $sql.=$this->prepareWhere();

        if($this->limit)
            $sql.=' limit '.$this->limit;
        if($this->offset)
            $sql.=' offset '.$this->offset;
        if($this->orderBy)
            $sql.=' order by '.$this->orderBy;

        return $this->query($sql,$this->bindings);
    }

    public function set($key,$value = null){
        if( is_array($key) ){
            $this->values = array_merge($this->values,$key);
        }else{
            $this->values[$key] = $value;
        }
        return $this;
    }

    public function insert($tableName = null):int|bool{
        $this->tableName = $tableName ?? $this->tableName;
        $sql ='INSERT INTO '.$this->tableName. ' SET ';
        $sql.= $this->prepareBindings();
        if( $this->query($sql,$this->bindings) === false )
        {
            return false;
        }
        $this->lastId = $this->pdoObj->lastInsertId();
        return $this->lastId;
    }

    public function update($tableName = null):bool {
        $this->tableName = $tableName ?? $this->tableName;
        $sql ='UPDATE '.$this->tableName. ' SET ';
        $sql.= $this->prepareBindings();
        $sql.= $this->prepareWhere();

        return !( ($this->query($sql, $this->bindings) === false) );
    }

    public function delete($tableName = null):bool {
        $this->tableName = $tableName ?? $this->tableName;
        $sql ='DELETE from '.$this->tableName;
        $sql.= $this->prepareBindings();
        $sql.= $this->prepareWhere();

        return !( ($this->query($sql, $this->bindings) === false) );
    }

    public function where($sql,$bindings=[])
    {
        /* if(is_array($key)){
             $this->wheres = array_merge($this->wheres,$key);
         }else{
             $this->wheres[$key] = $value;
         }*/
        $this->whereSql =' where '. $sql;
        $this->wheres= $bindings;
        return $this;
    }

    protected function prepareBindings(){
        $sql = '';
        foreach ($this->values as $column => $value){
            $sql.= ' `'.$column.'` =  ? ,';
            $this->bindings [] = $value;
        }

        $sql = rtrim($sql,',');
        return $sql;
    }

    public function query($sql,$bindings = []):bool | PDOStatement
    {

        //print_r($this->bindings);
        /*if(count($bindings)==1 && is_array($bindings[0])){
            $bindings = $bindings[0];
        }*/

        try {
            $query = $this->pdoObj->prepare($sql);
            foreach ($bindings as $key => $value)
            {
                $query->bindValue($key + 1, $value);
            }
            $query->execute();
            $this->reset();
            return $query;
        } catch (PDOException $exception) {
            echo $sql.'<br>'.$exception->getMessage();
            $this->reset();
            //die($exception->getMessage());
            return false;
        }




    }

    private function prepareWhere()
    {
        $sql =$this->whereSql;/*
        if(count($this->wheres)>0){
            $sql .= ' WHERE ';
            foreach ($this->wheres as $key=>$value){
                $sql.= ' `'.$key.'` = ? ';
                $this->bindings[] = $value;
            }
            $sql = rtrim($sql,'AND');
        }*/
        $this->bindings = array_merge($this->bindings,$this->wheres);
        return $sql;
    }

    public function reset(){
        $this->tableName = '';
        $this->whereSql ='';
        $this->bindings =[];
        $this->selects = [];
        $this->values = [];
        $this->offset=0;
        $this->limit=0;
        $this->orderBy='';
        $this->wheres = [];
        $this->joins=[];
    }


}