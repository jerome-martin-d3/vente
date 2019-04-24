<?php

function actionProduit($twig, $db){
    $form = array();
    $prod = new Produit($db);
    
    if(isset($_POST['btAjoutProd'])){
        $designation = $_POST['inputDesignation'];
        $description = $_POST['description'];
        $prix = $_POST['inputPrix'];
        $idType = $_POST['inputType'];
        $photo = NULL;
        if(isset($_FILES['inputPhoto'])){
            if(!empty($_FILES['inputPhoto']['name'])){
                $extensions_ok= array('png', 'gif', 'jpg','jpeg');
                $taille_max = 500000;
                $dest_dossier="/var/www/html/vente/web/images/";
                
                if( !in_array( substr(strrchr($_FILES['inputPhoto']['name'], '.'), 1), $extensions_ok ) ){
                    echo 'Veuillez sélectionner un fichier de type png, gif ou jpg !';
                }
                else{
                    if( file_exists($_FILES['inputPhoto']['tmp_name'])&& (filesize($_FILES['inputPhoto']['tmp_name'])) >  $taille_max){
                        echo 'Votre fichier doit faire moins de 500Ko !';
                    }else{
                        $photo = basename($_FILES['inputPhoto']['name']);
                        // enlever les accents              
                        $photo=strtr($photo,'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ','AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
                        // remplacer les caractères autres que lettres, chiffres et point par _
                        $photo = preg_replace('/([^.a-z0-9]+)/i', '_', $photo);
                        // copie du fichier
                        move_uploaded_file($_FILES['inputPhoto']['tmp_name'], $dest_dossier.$photo);
                    }
                }
            }
        }
        $exec = $prod->insert($designation, $description, $prix, $idType, $photo);
    }
    if(isset($_POST['btSupProd'])){
        $cocher = $_POST['cocher'];
        $id = $_POST['inputID'];
        $prod->delete($id);
    }
    if(isset($_POST['btSupprimerPlusieurs'])){
        $id = $_POST['inputID'];
        foreach ($cocher as $id){
            $prod->delete($id);
        }
    }
    $liste = $prod->select();
    $types = $prod->listeTypes();
    
    echo $twig->render('gestionProduits.html.twig', array('form'=>$form,'liste'=>$liste, 'types'=>$types));
}
function actionModifProduit($twig, $db){
    $prod = new Produit($db);
    $id = $_POST['id'];
    if(isset($_POST['btModifProduit'])){
        $designation = $_POST['inputDesignation'];
        $description = $_POST['inputDescription'];
        $prix = $_POST['inputPrix'];
        $idType = $_POST['inputType'];
        $update= $prod->update($id, $designation, $description, $prix, $idType);
       header("Location: index.php?page=gestionProduits");
    }
        
        $liste = $prod->selectByID($id);
        $types = $prod->listeTypes();
        echo $twig->render('modifProduits.html.twig', array('liste'=>$liste, 'types'=>$types));
    
}