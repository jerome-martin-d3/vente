<?php

    function actionType($twig, $db){
        $form = array();
        $type = new Type($db);
        $liste = $type->select();
        echo $twig->render('gestionTypes.html.twig', array('form'=>$form,'liste'=>$liste));
    }
    function supType($twig, $db){
        $form = array();
        $type = new Type($db);
        $ntype = $_POST['id'];
        $type->delete($ntype);
        header('Location: index.php?page=gestionTypes');
    }
    function ajoutType($twig, $db){
        $form=array();
        $type = new Type($db);
        $libelle = $_POST['inputLibelle'];
        $exec = $type->insert($libelle);
        //echo $twig->render('gestionTypes.html.twig', array('form'=>$form));
        header("Location: index.php?page=gestionTypes");
    }
