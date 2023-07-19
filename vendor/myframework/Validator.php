<?php

namespace myframework;

class Validator
{

    protected Application $app;

    protected array $errors = [];
    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    protected function value($key):mixed{
        return $this->app->request->request($key);
    }

    public function required($name,$customErrorMessage = null):Validator{
        $value = $this->value($name);
        if(is_null($value) or trim($value) === ''){
            $message = $customErrorMessage?? $name.' is Required';
            $this->addError($name,$message);
        }
        return $this;
    }

    public function select($name,$customErrorMessage = null):Validator{
        $value = $this->value($name);
        if(is_null($value) or empty($value)){
            $message = $customErrorMessage?? $name.' must be selected';
            $this->addError($name,$message);
        }
        return $this;
    }

    public function deter($name,string|array $needle, $customErrorMessage = null):Validator{
        if($this->hasError($name))
            return $this;

        $value = $this->value($name);
        $contain=false;

        if(is_string($needle)) {
            $contain = str_contains($value,$needle);
            $deters = $needle;
        }else {

            foreach ($needle as $str)
                if (str_contains($value, $str)) {
                    $contain = true;
                    $deters = implode(' ',$needle);
                    break;
                }
        }

        if($contain){
            $message = $customErrorMessage?? $name.' must not contain '.$deters;
            $this->addError($name,$message);
        }
        return $this;
    }

    public function email($name,$customErrorMessage = null):Validator{
        if($this->hasError($name))
            return $this;

        $value = $this->value($name);
         if(!filter_var($value,FILTER_VALIDATE_EMAIL)){
             $message = $customErrorMessage?? $name.' is not valid email ';
             $this->addError($name,$message);
         }
        return $this;
    }

    public function numerical($name,$customErrorMessage = null):Validator{
        if($this->hasError($name))
            return $this;

        $value = $this->value($name);
        if(!filter_var($value,FILTER_VALIDATE_INT)){
            $message = $customErrorMessage?? $name.' must be numeric ';
            $this->addError($name,$message);
        }
        return $this;
    }

    public function requiredFile($name,$customErrorMessage = null):Validator{
        if($this->hasError($name))
            return $this;

         if(!$this->app->request->hasFile($name)) {
            $message = $customErrorMessage?? 'you have to choose file';
            $this->addError($name,$message);
        }
        return $this;
    }

    public function maxFileSize($name,$maxSize,$customErrorMessage = null):Validator{
        if($this->hasError($name))
            return $this;

        if($this->app->request->file($name)->getSize() > $maxSize) {
            $message = $customErrorMessage?? $name.' file size must be less than '.$maxSize;
            $this->addError($name,$message);
        }
        return $this;
    }

    public function image($name,$customErrorMessage = null):Validator{
        if($this->hasError($name))
            return $this;

         $type = $this->app->request->file($name)->getType();
         if(explode('/',$type)[0] != 'image') {
            $message = $customErrorMessage?? $name.' file must an image';
            $this->addError($name,$message);
        }
        return $this;
    }

    public function minLen($name,$minlen,$customErrorMessage = null):Validator{
        if($this->hasError($name))
            return $this;

        $value = $this->value($name);
        if(strlen($value)<$minlen){
            $message = $customErrorMessage?? $name.' should be at least '.$minlen.' digits';
            $this->addError($name,$message);
        }
        return $this;
    }

    public function maxLen($name,$maxlen,$customErrorMessage = null):Validator{
        if($this->hasError($name))
            return $this;

        $value = $this->value($name);
        if(strlen($value)> $maxlen){
            $message = $customErrorMessage?? $name.' should be less than '.$maxlen.' digits';
            $this->addError($name,$message);
        }
        return $this;
    }

    public function match($name ,$otherInputName,$customErrorMessage = null):Validator{
        if($this->hasError($name) or $this->hasError($otherInputName) )
            return $this;

        $value = $this->value($name);
        $value2 = $this->value($otherInputName);
        if($value != $value2){
            $message = $customErrorMessage?? $otherInputName.' is not match '.$name;
            $this->addError($otherInputName,$message);
        }

        return $this;
    }

    public function unique($name,array $tableInfo ,$customErrorMessage = null):Validator{
        if($this->hasError($name))
            return $this;

        $value = $this->value($name);
        list($table,$column) = $tableInfo;
        $row = $this->app->db->from($table)->select($column)->where("$column = ? ",[$value])->fetch();
        if($row){
            $message = $customErrorMessage?? $name.'  ' .'already exist';
            $this->addError($name,$message);
        }
        return $this;
    }

    public function getErrors():array{
        $errors =  $this->errors;
        $this->errors = [];
        return $errors;
    }

    public function validate():bool{
        return empty($this->errors);
    }

    private function addError($name ,mixed $message)
    {
        if(!array_key_exists($name,$this->errors))
        $this->errors[$name] = $message;
    }

    private function hasError($name)
    {
        return array_key_exists($name,$this->errors);
    }


}