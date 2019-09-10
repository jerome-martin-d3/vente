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
                $dest_dossier="images/";
                
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
        $id = $_POST['inputID'];
        $image = $prod->selectByID($id);
        unlink('/var/www/html/vente/web/images/'.$image["photo"]);
        $prod->delete($id);

        
    }
    
    //pagination
    $limite = 3;
    if(!isset($_GET['nopage'])){
        $inf=0;
        $nopage=0;
    }else{
        $nopage=$_GET['nopage'];
        $inf = $nopage*$limite;
    }
    $r = $prod->selectCount();
    $nb=$r['nb'];
    
    $liste = $prod->selectLimit($inf, $limite);
    $form['nbpages'] = ceil($nb/$limite);
    
    //$liste = $prod->select();
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
        $photo = NULL;
        if(isset($_FILES['inputPhoto'])){
            if(!empty($_FILES['inputPhoto']['name'])){
                $extensions_ok= array('png', 'gif', 'jpg','jpeg');
                $taille_max = 500000;
                $dest_dossier="images/";
                
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
        }else{
            $produitByID = $prod->selectByID($id);
            $photo = $produitByID["photo"];
        }
        $update= $prod->update($id, $designation, $description, $prix, $idType, $photo);
       header("Location: index.php?page=gestionProduits");
    }
        
        $leproduit = $prod->selectByID($id);
        $types = $prod->listeTypes();
        echo $twig->render('modifProduits.html.twig', array('prod'=>$leproduit, 'types'=>$types));
    
}

function actionListeProduitPdf($twig, $db){
    $produit = new Produit($db);
    $liste = $unProduit = $produit->select();
    $html = $twig->render('produit-liste-pdf.html.twig', array('liste'=>$liste));
    try{
        ob_end_clean(); // Permet d'envoyer aucune données avant le fichier PDF
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P','A4','fr'); // Création d'une page format A4 en français orienté en mode portrait
        $html2pdf->writeHTML($html); //Ecrit contenu résultat twig dans la variable html2pdf
        $html2pdf->output('listedesproduits.pdf'); //Extrait la variable html2pdf en pdf sous le nom de listedesproduits.pdf.
    } catch (Html2PdfException $e) {
        echo 'erreur'.$e;
    }
}