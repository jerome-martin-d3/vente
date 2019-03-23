<?php

function actionProduit($twig, $db){
    $form = array();
    $prod = new Produit($db);
    $liste = $prod->select();
    $types = $prod->listeTypes();
    echo $twig->render('gestionProduits.html.twig', array('form'=>$form,'liste'=>$liste, 'types'=>$types));
}
function ajoutProd($twig, $db){
    $form = array();
    $prod = new Produit($db);
    $designation = $_POST['inputDesignation'];
    $description = $_POST['description'];
    $prix = $_POST['inputPrix'];
    $idType = $_POST['inputType'];
    $exec = $prod->insert($designation, $description, $prix, $idType);
    header("Location: index.php?page=gestionProduits");
}
function supProd($twig, $db){
    $form = array();
    $prod = new Produit($db);
    $id = $_POST['inputID'];
    $prod->delete($id);
    header("Location: index.php?page=gestionProduits");
}