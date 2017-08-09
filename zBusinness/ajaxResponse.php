<?php
    $champ = array ("ordre","code_service","standing","prix_unitaire","statut","date_attribution_service","date_liberation_service","nom_personne","beneficiaire");
    $table = "services,personne" ;
    $clausesChambres = array("services.beneficiaire=personne.cni_personne "," services.categorie='chambre'");
    $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
    $resultSetChambres=$instance->pdo->query($queryChambres);
    $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
    while($p=$resultSetChambres->fetch()){
        if ($p->statut=="libre"){
            echo "<tr>" ;
                echo"<th scope='row'>".$p->ordre."</th>" ;
                echo"<td><u>".$p->code_service."</u></td>" ;
                echo"<td>".$p->standing."</td>" ;
                echo"<td>".$p->prix_unitaire."</td>" ;
                echo"<td><b><span status-shortcode='free' style='color:green'>Libre</span></b></td>" ;
                echo"<td>".$p->date_attribution_service."</td>" ;
                echo"<td>".$p->date_liberation_service."</td>" ;
                echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
            echo "</tr>" ;
        } else if ($p->statut=="occupee"){
                echo "<tr>" ;
                echo"<th scope='row'>".$p->ordre."</th>" ;
                echo"<td ><u>".$p->code_service."</u></td>" ;
                echo"<td>".$p->standing."</td>" ;
                echo"<td>".$p->prix_unitaire."</td>" ;
                echo"<td><span status-shortcode='busy' style='color:red'>Occupé</span></td>";
                echo"<td>".$p->date_attribution_service."</td>" ;
                echo"<td>".$p->date_liberation_service."</td>" ;
                echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
            echo "</tr>" ; 
        }else if ($p->statut=="indisponible"){
            echo "<tr>" ;
                echo"<th scope='row'>".$p->ordre."</th>" ;
                echo"<td ><u>".$p->code_service."</u></td>" ;
                echo"<td>".$p->standing."</td>" ;
                echo"<td>".$p->prix_unitaire."</td>" ;
                echo"<td><span status-shortcode='unavailable' style='color:#039'>Indisponible</span></td>" ;
                echo"<td>".$p->date_attribution_service."</td>" ;
                echo"<td>".$p->date_liberation_service."</td>" ;
                echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
            echo "</tr>" ;
        }
    }
?>