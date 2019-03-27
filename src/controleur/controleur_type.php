<?php

    function actionType($twig, $db){
        $form = array();
        $type = new Type($db);
        if(isset($_POST['btSup']))
        {
            $ntype = $_POST['id'];
            $type->delete($ntype);
        }
        if(isset($_POST['btAjout'])){
            $libelle = $_POST['inputLibelle'];
            $exec = $type->insert($libelle);
        }
        $liste = $type->select();
        echo $twig->render('gestionTypes.html.twig', array('form'=>$form,'liste'=>$liste));
    }
    
    function actionModifType($twig,$db){
        $form = array();
        $type = new Type($db);
        $id = $_POST['id']; 
        $unType = $type->selectByID($id);
        if(isset($_POST['btModif'])){
            $libelle = $_POST['inputLibelle'];
            $type->update($id, $libelle);
            header("Location: index.php?page=gestionTypes");
        }
        echo $twig->render('modifTypes.html.twig', array('type'=>$unType));
        
    }