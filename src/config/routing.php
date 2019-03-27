<?php
function getPage($db){
//0 = tout le monde 1 = administrateur 2 = client
 $lesPages['accueil'] = "actionAccueil;0";
 $lesPages['connexion'] = "actionConnexion;0";
 $lesPages['deconnexion'] = "actionDeconnexion;0";
 $lesPages['apropos'] = "actionApropos;0";
 $lesPages['mentions'] = "actionMentions;0";
 $lesPages['inscription'] =  "actionInscription;0";
 $lesPages['maintenance'] = "actionMaintenance;0";
 $lesPages['gestionTypes'] = "actionType;1";
 $lesPages['modifType'] = "actionModifType;1";
 $lesPages['utilisateur'] = "actionUtilisateur;1";
 $lesPages['gestionProduits'] = "actionProduit;1";
 $lesPages['modifutilisateur'] = "actionModifUtilisateur;1";
 $lesPages['modifProduit'] = "actionModifProduit;1";
 if ($db!=null){
  if(isset($_GET['page'])){
    
    $page = $_GET['page']; }
  else{
    $page = 'accueil';
  }
  if (!isset($lesPages[$page])){
    
    $page = 'accueil'; 
  }
$explose = explode(";",$lesPages[$page]);
$role = $explose[1]; 
if ($role != 0){
    if(isset($_SESSION['login'])){  
      if(isset($_SESSION['role'])){  
         if($role!=$_SESSION['role']){  

            $contenu = 'actionAccueil'; 
         }
         else{
           $contenu = $explose[0]; 
         }
      } 
      else{
        $contenu = 'actionAccueil';   
      }
    }
    else{
      $contenu = 'actionAccueil';  
    }
  }else{
    $contenu = $explose[0];
  }
}
else{
   // Si $db est null
   $contenu = 'actionMaintenance'; 
}
return $contenu; 
}
?>