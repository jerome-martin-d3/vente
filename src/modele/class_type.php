<?php
class Type{
    private $db;
    private $select;
    private $insert;
    private $delete;
    private $selectByID;
    private $update;
    
    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select ntype, libelle from type order by ntype");
        $this->insert = $db->prepare("insert into type(libelle) values(:libelle)");
        $this->delete = $db->prepare("delete from type where ntype = :ntype ");
        $this->selectByID = $db->prepare("select ntype, libelle from type where ntype = :id");
        $this->update = $db->prepare("UPDATE type set libelle = :libelle where ntype = :id");
        
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
        if($this->insert->errorCoEcrande()!=0)
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
    public function selectByID($id){
        $this->selectByID->execute(array(':id'=>$id));
        if($this->selectByID->errorCode()!=0){
            print_r($this->selectByID->errorInfo());
        }
        return $this->selectByID->fetch();
    }
    public function update($id, $libelle){
        $this->update->execute(array(':libelle'=>$libelle, ':id'=>$id));
        if($this->update->errorCode()!=0){
            print_r($this->update->errorInfo());
        }
    }
}
