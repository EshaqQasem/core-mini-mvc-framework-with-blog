<?php

namespace myframework\Http;

class File
{
    protected $key;
    protected $name;
    protected int $size;
    protected $type;
    protected $error;

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getName(): mixed
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getType(): mixed
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getError(): mixed
    {
        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getTmpName(): mixed
    {
        return $this->tmpName;
    }
    protected $tmpName;

    /**
     * @param $key
     */
    public function __construct($key,array $file)
    {
        $this->key = $key;
        $this->name = $file['name'];
        $this->size = $file['size'];
        $this->type = $file['type'];
        $this->error = $file['error'];
        $this->tmpName = $file['tmp_name'];
    }

    public function extention(){
        return explode('/',$this->type)[1];
    }

    public function isUpload():bool{
        return is_uploaded_file($this->getTmpName());
    }

    public function moveTo($dir,$name=null){
        if($this->isUpload()){
            $name = is_null($name)? $this->name:$name.'.'.$this->extention();
            if(!is_dir($dir))
                throw new \Exception($dir.' is not found');
            if(!move_uploaded_file($this->tmpName,$dir.'/'. $name))
                throw new \Exception($key.' had error in moving file');
            return $name;
        }else{
            throw new \Exception($this->key.' file is not uploaded');
        }
    }

}