<?php
class Produit{
    private $db;
    private $select;
    private $listeTypes;
    private $delete;
    private $insert;
    private $selectByID;
    private $update;
    //pagination
    private $selectLimit;
    private $selectCount;
    
    public function __construct($db){
        $this->db = $db;
        $this->select = $db->prepare("select id, designation, description, prix, libelle, photo from produit, type where idType = ntype");
        $this->delete = $db->prepare("DELETE FROM produit WHERE id = :id");
        $this->listeTypes = $db->prepare("SELECT * FROM type");
        $this->insert = $db->prepare("INSERT INTO produit(designation, description, prix, idType, photo) values(:designation, :description, :prix, :idType, :photo)");
        $this->selectByID = $db->prepare("SELECT id, designation, description, prix, libelle, idType, photo from produit, type where idType = ntype AND id = :id");
        $this->update = $db->prepare("UPDATE produit set designation = :designation, description = :description, prix = :prix, idType = :idType, photo = :photo WHERE id = :id");
        $this->selectLimit = $db->prepare("SELECT id, desgination, description, prix, idType from produit order by designation limit :inf,:limite");
        $this->selectCount = $db->prepare("SELECT `count(id)` as nb FROM produit");
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
    public function insert($designation, $description, $prix, $idType, $photo){
        $this->insert->execute(array(':designation'=>$designation, ':description'=>$description, ':prix'=>$prix,':idType'=>$idType, ':photo'=>$photo));
        if($this->insert->errorCode()!=0)
        {
            print_r($this->insert->errorInfo());
        }
    }
    public function selectByID($id){
        $this->selectByID->execute(array(':id'=>$id));
        if($this->selectByID->errorCode()!=0){
            print_r($this->selectByID->errorInfo());
        }
        return $this->selectByID->fetch();
    }
    
    public function update($id, $designation, $description, $prix, $idType, $photo){
        $this->update->execute(array(':id'=>$id, ':designation'=>$designation, ':description'=>$description, ':prix'=>$prix, ':idType'=>$idType, ':photo'=>$photo));
        if($this->update->errorCode()!=0){
            print_r($this->update->errorInfo());
        }
    }
    public function selectLimit($inf, $limite){
        $this->selectLimit->bindParam(':inf', $inf, PDO::PARAM_INT);
        $this->selectLimit->bindParam(':limite', $limite, PDO::PARAM_INT);
        $this->selectLimit->execute();
        if($this->selectLimit->errorCode()!=0){
           print_r($this->selectLimit->errorInfo());
        }
        return $this->selectLimit->fetchAll();
    }
    public function selectCount(){
        $this->selectCount()->execute();
        if($this->selectCount->errorCode()!=0){
            print_r($this->selectCount->errorInfo());
        }
        return $this->selectCount->fetch();
    }
}
