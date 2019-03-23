<?php
class Type{
    private $db;
    private $select;
    private $insert;
    private $delete;
    
    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select ntype, libelle from type order by ntype");
        $this->insert = $db->prepare("insert into type(libelle) values(:libelle)");
        $this->delete = $db->prepare("delete from type where ntype = :ntype ");
        
}

    public function select(){
        $this->select->execute();
        if($this->select->errorCode()!=0){
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
    
    public function insert($libelle){
        $this->insert->execute(array(':libelle'=>$libelle));
        if($this->insert->errorCode()!=0)
        {
            print_r($this->insert->errorInfo());
        }
    }
    
    public function delete($ntype){
        $this->delete->execute(array(':ntype'=>$ntype));
        if($this->delete->errorCode()!=0){
            print_r($this->connect->errorInfo());
        }
    }
}
