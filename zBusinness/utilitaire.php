<?php   

include "persistance.php";

    
class utilitaire{
   //public  $instance;


    public  function getAttributes($pkService){
        $instance=persistance::getInstance('root','','cicm');
        $champ = array ("*");
        $table = "services" ;
        $clausesChambres = array("services.code_service='$pkService'");
        $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
        $resultSetChambres=$instance->pdo->query($queryChambres);
        $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
        $objStr="";
        if($p=$resultSetChambres->fetch()){
            $objStr=$p->nom_service."#@#".
                    $p->prix_unitaire."#@#".
                    $p->categorie."#@#".
                    $p->statut."#@#".
                    $p->photos."#@#".
                    $p->standing."#@#".
                    $p->quantite_stock."#@#".
                    $p->desription."#@#".
                    $p->beneficiaire."#@#".
                    $p->date_attribution_service."#@#".
                    $p->date_liberation_service."#@#".
                    $p->deliver_service_agent;
        }
       return $objStr;
    }



  

  
}

?>