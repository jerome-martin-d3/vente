<?php
class Produit{
    private $db;
    private $select;
    private $listeTypes;
    private $delete;
    private $insert;
    
    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select id, designation, description, prix, libelle from produit, type where idType = ntype");
        $this->delete = $db->prepare("DELETE FROM produit WHERE id = :id");
        $this->listeTypes = $db->prepare("SELECT * FROM type");
        $this->insert = $db->prepare("INSERT INTO produit(designation, description, prix, idType) values(:designation, :description, :prix, :idType)");
    }
    public function select(){
        $this->select->execute();
        if($this->select->errorCode()!=0)
        {
            print_r($this->select->errorInfo());
        }
        return $this->select->fetchAll();
    }
    public function delete($id){
        $this->delete->execute(array(':id'=>$id));
        if($this->delete->errorCode()!=0)
        {
            print_r($this->delete->errorInfo());
        }
    }
    public function listeTypes(){
        $this->listeTypes->execute();
        if($this->listeTypes->errorCode()!=0){
            print_r($this->listeTypes->errorInfo());
        }
        return $this->listeTypes->fetchAll();
    }
    public function insert($designation, $description, $prix, $idType){
        $this->insert->execute(array(':designation'=>$designation, ':description'=>$description, ':prix'=>$prix, ':idType'=>$idType));
        if($this->insert->errorCode()!=0)
        {
            print_r($this->insert->errorInfo());
        }
    }
}
