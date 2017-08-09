<?php include "../zBusinness/utilitaire.php" ?>
<?php require_once ("../zBusinness/persistance.php") ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php $utilitaire=new utilitaire();  ?>
<?php 

     if (isset($_POST['jeton'])){
           if($_POST['jeton']=="reserverChambre"){
                  $a = $_POST['cni_personne'] ;$b = $_POST['date_attribution'] ;$c = $_POST['date_liberation'] ;
                  $d = $_POST['code_chambre'] ; $oTable = "services";

                //   $aFields = array("beneficiaire='$a'","date_attribution_service='$b'","date_liberation_service='$c'","statut='libre'");
                //   $aClauses = array("code_service='$d'");
                //   $instance->updateBD($oTable,$aFields,$aClauses);

                  $oFields = array(
                                    //"ordre",
                                    "code_service",
                                    "nom_service",
                                    "prix_unitaire",
                                    "categorie",
                                    "statut",
                                    "photos",
                                    "standing",
                                    "quantite_stock",
                                    "desription",
                                    "beneficiaire",
                                    "date_attribution_service",
                                    "date_liberation_service",
                                    "deliver_service_agent"
                                    );
                  $oValues=array(
                                //"145",
                                "$d",
                                explode("#@#",$utilitaire->getAttributes($d))[0],
                                explode("#@#",$utilitaire->getAttributes($d))[1],
                                explode("#@#",$utilitaire->getAttributes($d))[2],
                                explode("#@#",$utilitaire->getAttributes($d))[3],
                                explode("#@#",$utilitaire->getAttributes($d))[4],
                                explode("#@#",$utilitaire->getAttributes($d))[5],
                                explode("#@#",$utilitaire->getAttributes($d))[6],
                                "autre",
                                "$a",
                                "$b",
                                "$c",
                                explode("#@#",$utilitaire->getAttributes($d))[11]
                                );
                  $instance->insertBD($oFields,$oValues,$oTable);

                  
                  //Fabriquer la reponse ajax html
                  $champ = array (" code_service","standing","prix_unitaire","statut","date_attribution_service","date_liberation_service","nom_personne","beneficiaire");
                    $table = "services,personne" ;
                    $clausesChambres = array("services.beneficiaire=personne.cni_personne "," services.categorie='chambre' "," services.desription='pivot'");
                    $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
                    $resultSetChambres=$instance->pdo->query($queryChambres);
                    $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
                    $i=0;
                    while($p=$resultSetChambres->fetch()){
                        if ($p->statut=="libre"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><b><span status-shortcode='free' style='color:green'>Attribuable</span></b></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        } else if ($p->statut=="occupee"){
                                echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='busy' style='color:red'>Occupé</span></td>";
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ; 
                        }else if ($p->statut=="indisponible"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='unavailable' style='color:#039'>Indisponible</span></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        }
                        $i++;
                    }
                }else if ($_POST['jeton']=="reserverSalle"){

                    $a = $_POST['cni_personne'] ;$b = $_POST['date_attribution'] ;$c = $_POST['date_liberation'] ;
                  $d = $_POST['code_chambre'] ; $oTable = "services";
                  $oFields = array("beneficiaire='$a'","date_attribution_service='$b'","date_liberation_service='$c'","statut='libre'");
                  $oClauses = array("code_service='$d'");
                  $instance->updateBD($oTable,$oFields,$oClauses);
                  //Fabriquer la reponse ajax html
                  $champ = array ("ordre","code_service","standing","prix_unitaire","statut","date_attribution_service","date_liberation_service","nom_personne","beneficiaire");
                    $table = "services,personne" ;
                    $clausesChambres = array("services.beneficiaire=personne.cni_personne "," services.categorie='salle'");
                    $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
                    $resultSetChambres=$instance->pdo->query($queryChambres);
                    $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
                    $i=0;
                    while($p=$resultSetChambres->fetch()){
                        if ($p->statut=="libre"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                                echo"<td><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><b><span status-shortcode='free' style='color:green'>Attribuable</span></b></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        } else if ($p->statut=="occupee"){
                                echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='busy' style='color:red'>Occupé</span></td>";
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ; 
                        }else if ($p->statut=="indisponible"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='unavailable' style='color:#039'>Indisponible</span></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        }
                        $i++;
                    }

                }else if ($_POST['jeton']=="sendCniTolocaux"){

                       echo $_POST['cni_personne'];

                }else if ($_POST['jeton']=="libererChambre"){
                    $code_chambre = $_POST['code_chambre'] ;
                    $oFields = array("beneficiaire='111409890'","date_attribution_service=''","date_liberation_service=''","statut='libre'");
                    $oClauses = array("code_service='$code_chambre'");
                    $instance->updateBD("services",$oFields,$oClauses);
                    $champ = array ("ordre","code_service","standing","prix_unitaire","statut","date_attribution_service","date_liberation_service","nom_personne","beneficiaire");
                    $table = "services,personne" ;
                    $clausesChambres = array("services.beneficiaire=personne.cni_personne "," services.categorie='chambre'");
                    $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
                    $resultSetChambres=$instance->pdo->query($queryChambres);
                    $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
                    $i=0;
                    while($p=$resultSetChambres->fetch()){
                        if ($p->statut=="libre"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><b><span status-shortcode='free' style='color:green'>Attribuable</span></b></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        } else if ($p->statut=="occupee"){
                                echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='busy' style='color:red'>Occupé</span></td>";
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ; 
                        }else if ($p->statut=="indisponible"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='unavailable' style='color:#039'>Indisponible</span></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        }
                        $i++;
                    }
                }else if ($_POST['jeton']=="libererSalle"){
                    $code_chambre = $_POST['code_chambre'] ;
                    $oFields = array("beneficiaire='111409890'","date_attribution_service=''","date_liberation_service=''","statut='libre'");
                    $oClauses = array("code_service='$code_chambre'");
                    $instance->updateBD("services",$oFields,$oClauses);
                    $champ = array ("ordre","code_service","standing","prix_unitaire","statut","date_attribution_service","date_liberation_service","nom_personne","beneficiaire");
                    $table = "services,personne" ;
                    $clausesChambres = array("services.beneficiaire=personne.cni_personne "," services.categorie='salle'");
                    $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
                    $resultSetChambres=$instance->pdo->query($queryChambres);
                    $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
                    $i=0;
                    while($p=$resultSetChambres->fetch()){
                        if ($p->statut=="libre"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                                echo"<td><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><b><span status-shortcode='free' style='color:green'>Attribuable</span></b></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        } else if ($p->statut=="occupee"){
                                echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='busy' style='color:red'>Occupé</span></td>";
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ; 
                        }else if ($p->statut=="indisponible"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='unavailable' style='color:#039'>Indisponible</span></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        }
                        $i++;
                    }
                }  else if ($_POST['jeton']=="indisponibleChambre"){
                    $code_chambre = $_POST['code_chambre'] ;
                    $oFields = array("beneficiaire='111409890'","date_attribution_service=''","date_liberation_service=''","statut='indisponible'");
                    $oClauses = array("code_service='$code_chambre'");
                    $instance->updateBD("services",$oFields,$oClauses);
                    $champ = array ("ordre","code_service","standing","prix_unitaire","statut","date_attribution_service","date_liberation_service","nom_personne","beneficiaire");
                    $table = "services,personne" ;
                    $clausesChambres = array("services.beneficiaire=personne.cni_personne "," services.categorie='chambre'");
                    $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
                    $resultSetChambres=$instance->pdo->query($queryChambres);
                    $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
                    $i=0;
                    while($p=$resultSetChambres->fetch()){
                        if ($p->statut=="libre"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><b><span status-shortcode='free' style='color:green'>Attribuable</span></b></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        } else if ($p->statut=="occupee"){
                                echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='busy' style='color:red'>Occupé</span></td>";
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ; 
                        }else if ($p->statut=="indisponible"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='unavailable' style='color:#039'>Indisponible</span></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        }
                        $i++;
                    }
                }else if ($_POST['jeton']=="indisponibleSalle"){
                    $code_chambre = $_POST['code_chambre'] ;
                    $oFields = array("beneficiaire='111409890'","date_attribution_service=''","date_liberation_service=''","statut='indisponible'");
                    $oClauses = array("code_service='$code_chambre'");
                    $instance->updateBD("services",$oFields,$oClauses);
                    $champ = array ("ordre","code_service","standing","prix_unitaire","statut","date_attribution_service","date_liberation_service","nom_personne","beneficiaire");
                    $table = "services,personne" ;
                    $clausesChambres = array("services.beneficiaire=personne.cni_personne "," services.categorie='salle'");
                    $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
                    $resultSetChambres=$instance->pdo->query($queryChambres);
                    $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
                    $i=0;
                    while($p=$resultSetChambres->fetch()){
                        if ($p->statut=="libre"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                                echo"<td><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><b><span status-shortcode='free' style='color:green'>Attribuable</span></b></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        } else if ($p->statut=="occupee"){
                                echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='busy' style='color:red'>Occupé</span></td>";
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ; 
                        }else if ($p->statut=="indisponible"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='unavailable' style='color:#039'>Indisponible</span></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        }
                        $i++;
                    }
                } else if ($_POST['jeton']=="filtrerChambre"){ 
                    $statut = $_POST['search_zone'] ;
                    $champ = array ("ordre","code_service","standing","prix_unitaire","statut","date_attribution_service","date_liberation_service","nom_personne","beneficiaire");
                    $table = "services,personne" ;
                    $clausesChambres = array("services.beneficiaire=personne.cni_personne "," services.categorie='chambre'"," services.statut='$statut'");
                    $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
                    $resultSetChambres=$instance->pdo->query($queryChambres);
                    $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
                    $i=0;
                    while($p=$resultSetChambres->fetch()){
                        if ($p->statut=="libre"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><b><span status-shortcode='free' style='color:green'>Attribuable</span></b></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        } else if ($p->statut=="occupee"){
                                echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='busy' style='color:red'>Occupé</span></td>";
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ; 
                        }else if ($p->statut=="indisponible"){
                            echo "<tr>" ;
                                echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                                echo"<td ><u>".$p->code_service."</u></td>" ;
                                echo"<td>".$p->standing."</td>" ;
                                echo"<td>".$p->prix_unitaire."</td>" ;
                                echo"<td><span status-shortcode='unavailable' style='color:#039'>Indisponible</span></td>" ;
                                // echo"<td>".$p->date_attribution_service."</td>" ;
                                // echo"<td>".$p->date_liberation_service."</td>" ;
                                // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                            echo "</tr>" ;
                        }
                        $i++;
                    }
                }

        }
        else {
 ?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link  rel="stylesheet" href="../css/custom.css" />
    <link  rel="stylesheet" href="../css/bootstrap.min.css" />
    <link  rel="stylesheet" href="../css/jquery-ui.css" />
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="../js/SIHajaxifiying.js"></script>  
    
</head>


<body>
   
  <!--Bar entete -->
  <nav class="navbar navbar-light bg-info ">
      <a class="navbar-brand col-xs-6 col-sm-3" href="#">
          <img style="margin-left: 5em"  src="../img/logo.png" width="55" height="55" alt="">
          <span style="color: #333;">Maison C.I.C.M </span>
         
          <span  style="margin-left:700px"> &nbsp;&nbsp;&nbsp;Bonjour Admin&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;<img src="../img/pic-lock.png" width="40px" height="40px"/</span>
          
      </a>
  </nav>
  <!-- Fin Bar entete -->
  <!-- Fin Bar entete -->
  <!--debut entete CNI-->
  <div class="container spacer">
      <div style="margin-top: 1em; margin-left: 75%;" class="row">
          <div class="col-xs-4" id="pic-logement-parent">
              <a href="locaux.php" class="bleu">
                  <img id="pic-logement" style="margin-left: 20px;" src="../img/house.png" /><br/>
                  <logement>Logements</logement><br/>  
              </a>
          </div>
          <div style="margin-left: 1em" class="col-xs-4" id="pic-commande-parent">
              <a href="../index.php" class="bleu">
              <!--<a href="#" class="bleu">-->
              <commandes>
                  <img id="pic-commande" style="margin-left: 22px;" src="../img/buy.png" /><br/>
                Commandes</commandes><br/>
              </a>
          </div>
          <div style="margin-left: 1em" class="col-xs-4" id="pic-fidelite-parent">
              <a href="fideliser.php" class="bleu">
                  <img id="pic-fidelite" style="margin-left: 22px;" src="../img/user.png" /><br/>
                  <fidelites>Fidélités</fidelites><br/>
              </a>
          </div>
      </div>
    <!-- Test -->


    
    <div  class="row">
          <div class="col-lg-4">
          </div>
          <div  class="input-group col-lg-4">
             
              <input  list="taxonomy-filter"    id="search-zone" class="form-control" type="text"  PLACEHOLDER="Effectuer un filtre" >
               <datalist id="taxonomy-filter">
                    <option>indisponible</option>
                    <option>libre</option>
                    
              </datalist>
          
              <button  type="button" id="btn-search" class="btn btn-primary btn-xs input-group-addon bg-warning">ok</button>
          
          </div>
          <div class="col-lg-4">
          </div>
          
          
      </div>
    <div class="row" >
    	
    	

    	<div class="col-lg-12" style="height:343px;overflow: auto">
    		<ul class="nav nav-tabs">

          <li class="nav-item " >
            <a class="nav-link active"  id="link1Listener">Chambres</a>
          </li>
        
          <li class="nav-item">
            <a class="nav-link" id="link2Listener">Salles</a>
          </li>
     </ul>
    
    <?php 
        
        $champ = array ("code_service","standing","prix_unitaire","statut","date_attribution_service","date_liberation_service","nom_personne","beneficiaire");
        $table = "services,personne" ;
        $clausesChambres = array("services.beneficiaire=personne.cni_personne "," services.categorie='chambre'"," services.desription='pivot'");
        $clausesSalles   = array("services.beneficiaire=personne.cni_personne "," services.categorie='salle'"," services.desription='pivot'");
        $queryChambres = $instance->selectBD($table,$champ,$clausesChambres);
        
        $querySalles = $instance->selectBD($table,$champ,$clausesSalles);
        $resultSetChambres=$instance->pdo->query($queryChambres);
        $resultSetSalles=$instance->pdo->query($querySalles);
        $resultSetChambres->setFetchMode(PDO::FETCH_OBJ);
        $resultSetSalles->setFetchMode(PDO::FETCH_OBJ);
     ?>
     <?php 
       
        
    ?>

    <div id="link1">
      <table id="chambres" class="table table-bordered table-striped">
        <thead class="bg-info">
          <tr>
            <th>#</th>
            <th >Code Chambre</th>
            <th>Standing</th>
            <th>Prix</th>
            <th>Statut</th>
            
          </tr>
        </thead>
        <tbody id="corps">
          
        <?php
            $i=0;
            while($p=$resultSetChambres->fetch()){
              if ($p->statut=="libre"){
                  echo "<tr>" ;
                    echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                    echo"<td><u>".$p->code_service."</u></td>" ;
                    echo"<td>".$p->standing."</td>" ;
                    echo"<td>".$p->prix_unitaire."</td>" ;
                    echo"<td><b><span status-shortcode='free' style='color:green'>Attribuable</span></b></td>" ;
                    // echo"<td>".$p->date_attribution_service."</td>" ;
                    // echo"<td>".$p->date_liberation_service."</td>" ;
                    // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                  echo "</tr>" ;
              } else if ($p->statut=="occupee"){
                    $vingt = 20 ;
                    $val = "d/m/".$vingt."y" ;
                    if ($p->date_liberation_service == date($val)){
                        $oFields = array("beneficiaire='111409890'","date_attribution_service=''","date_liberation_service=''","statut='libre'");
                        $oClauses = array("code_service='$p->code_service'");
                        $oTable = "services";
                        $instance->updateBD($oTable,$oFields,$oClauses);
                    }
                    echo "<tr>" ;
                    echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                    echo"<td ><u>".$p->code_service."</u></td>" ;
                    echo"<td>".$p->standing."</td>" ;
                    echo"<td>".$p->prix_unitaire."</td>" ;
                    echo"<td><span status-shortcode='busy' style='color:red'>Occupé</span></td>";
                    // echo"<td>".$p->date_attribution_service."</td>" ;
                    // echo"<td>".$p->date_liberation_service."</td>" ;
                    // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                  echo "</tr>" ; 
              }else if ($p->statut=="indisponible"){
                   echo "<tr>" ;
                    echo"<th scope=row><input type=checkbox name=idChambre".$i." value=".$p->code_service."></th>" ;
                    echo"<td ><u>".$p->code_service."</u></td>" ;
                    echo"<td>".$p->standing."</td>" ;
                    echo"<td>".$p->prix_unitaire."</td>" ;
                    echo"<td><span status-shortcode='unavailable' style='color:#039'>Indisponible</span></td>" ;
                    // echo"<td>".$p->date_attribution_service."</td>" ;
                    // echo"<td>".$p->date_liberation_service."</td>" ;
                    // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                  echo "</tr>" ;
              }
              $i++;
            }

        ?>

        </tbody>
      </table>


    </div>

    <div id="link2">
      <table id="salles" class="table table-bordered table-striped">
        <thead class="bg-info">
          <tr>
            <th>#	</th> 	
            <th>Code Salle</th>
            <th>Standing</th>
            <th>Prix</th>
            <th>Statut</th>
            
          </tr>
        </thead>
        <tbody  id="corpsSalles">
          <?php
            $i=0;
            while($p=$resultSetSalles->fetch()){
              if ($p->statut=="libre"){
                  echo "<tr>" ;
                    echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                    echo"<td ><u>".$p->code_service."</u></td>" ;
                    echo"<td>".$p->standing."</td>" ;
                    echo"<td>".$p->prix_unitaire."</td>" ;
                    echo"<td><b><span status-shortcode='free' style='color:green'>Attribuable</span></b></td>" ;
                    // echo"<td>".$p->date_attribution_service."</td>" ;
                    // echo"<td>".$p->date_liberation_service."</td>" ;
                    // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                  echo "</tr>" ;
              } else if ($p->statut=="occupee"){
                    echo "<tr>" ;
                    echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                    echo"<td ><u>".$p->code_service."</u></td>" ;
                    echo"<td>".$p->standing."</td>" ;
                    echo"<td>".$p->prix_unitaire."</td>" ;
                    echo"<td><span status-shortcode='busy' style='color:red'>Occupé</span></td>";
                    // echo"<td>".$p->date_attribution_service."</td>" ;
                    // echo"<td>".$p->date_liberation_service."</td>" ;
                    // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                  echo "</tr>" ; 
              }else if ($p->statut=="indisponible"){
                   echo "<tr>" ;
                    echo"<th scope=row><input type=checkbox name=idSalle".$i." value=".$p->code_service."></th>" ;
                    echo"<td ><u>".$p->code_service."</u></td>" ;
                    echo"<td>".$p->standing."</td>" ;
                    echo"<td>".$p->prix_unitaire."</td>" ;
                    echo"<td><span status-shortcode='unavailable' style='color:#039'>Indisponible</span></td>" ;
                    // echo"<td>".$p->date_attribution_service."</td>" ;
                    // echo"<td>".$p->date_liberation_service."</td>" ;
                    // echo"<td title=".$p->beneficiaire.">".$p->nom_personne."</td>" ;
                  echo "</tr>" ;
              }
              $i++;
            }

        ?>
          
        </tbody>
      </table>
 </div> 
    </div>
    	</div>

    	

    </div>
    <!--bloc de pagination 
      <nav style="margin-left: 60em;">
          <ul class="pagination">
              <li>
                  <a href="#" aria-label="Previous">
                      <span  aria-hidden="true">&laquo;</span>
                  </a>
              </li>
              <li class="paginer"><a href="#">1</a></li>
              <li class="paginer"><a href="#">2</a></li>
              <li class="paginer"><a href="#">3</a></li>
              <li class="paginer"><a href="#">4</a></li>
              <li class="paginer"><a href="#">5</a></li>
              <li>
                  <a  href="#" aria-label="Next">
                      <span aria-hidden="true">&raquo;</span>
                  </a>
              </li>
          </ul>
      </nav>-->
    <!--fin bloc pagination -->


  <!--Fin Footer bar -->
        
        <form  id="oModal-chambres" title="reserver une chambre" >
              <div class="row">        
                <!--<div  class="col-lg-4">
                    <center>
                        <br/>
                        <img src="../img/room1.jpg" width="100%" height="70%" /><br/><br/>
                        <strong>Description </strong>: Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellat perferendis eos 
                    </center>
                </div>-->
                <div  class="col-lg-4">          
                           <input type='hidden' id='oBuffer'/>
                          <fieldset style="border:1px solid #ddd; padding:1em">
                            
                          <div class="form-group">
                              <label class="col-form-label">Confirmez votre CNI</label>
                              <div>
                                  
                                  <input value="<?php if(isset($_GET["jeton"]) && $_GET["jeton"]=="receive_cni_for_logement") echo $_GET["cni_personne"] ; else echo "";  ?>" id="oCni-personne" class="form-control" type="text"  PLACEHOLDER="000000000" >
                              </div>
                          </div>
                          
                          <div class="form-group">
                              <label class="col-form-label">Date d'occupation</label>
                              <div>
                                  <input class="form-control" id="oDatepicker1" type="text"  PLACEHOLDER="jj/mm/aaaa" >
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-form-label">Date de libération</label>
                              <div>
                                  <input class="form-control" id="oDatepicker2" type="text"  PLACEHOLDER="jj/mm/aaaa" >
                              </div>
                          </div>
                         <fieldset> 
                 </div>
                 <div class="col-lg-4">
                    <table id="dynamic-calendar" border="1">
                        <tbody>
                            
                        </tbody>
                    </table>
                 </div>
                </div>
                   </form>
                  
            

    
                  <div id="oModal-salles" title="Reserver une salle">
                      <form>
                          <div class="form-group">
                              <label class="col-form-label">Confirmez votre CNI</label>
                              <div>
                                  <input value="<?php if(isset($_GET["jeton"]) && $_GET["jeton"]=="receive_cni_for_logement") echo $_GET["cni_personne"] ; else echo "156728295";  ?>" id="oCni-personne" class="form-control" type="text"  PLACEHOLDER="000000000" >
                              </div>
                          </div>
                          
                          
                          <div class="form-group">
                              <label class="col-form-label">Date d'occupation</label>
                              <div>
                                  <input class="form-control" id="datepicker3" type="text" value="" PLACEHOLDER="jj/mm/aaaa" >
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-form-label">Date de libération</label>
                              <div>
                                  <input class="form-control" id="datepicker4" type="text" value="" PLACEHOLDER="jj/mm/aaaa" >
                              </div>
                          </div>
                           
                      </form>
                  </div>
                 
             
                <div id="unavailable" title="CICM SYSTEM">
                    <input type="hidden" id='sCode-chambre'/>
                    Espace indisponible 
                        
                </div>

                <div id="occupe"  title="CICM SYSTEM">
                    <input type="hidden" id='tCode-chambre'/>
                    Espace occupée 
                        
                </div>

                <div id="liberer-reservation"  title="CICM SYSTEM">
                     <div >
                     </div>
                     <hr/>
                    Libérer cette reservation !!
                </div>
                <script>
                    $("#reserver-chambre").click(function(){
                         $("#oModal-chambres").hide();
                    });
                     $("#unavID").click(function(){
                         $("#unavailable").hide();
                    });
                     $("#busyID").click(function(){
                         $("#occupe").hide();
                    });
                  </script>

  

    <script type="text/javascript" src="../js/SIHdynamicTabs.js"></script>
    <script type="text/javascript">
        $(function(){
            // Cache par défaut tous les onglets de la page à l'exception du premier
            $("#link1").show(); $("#link2").hide();$('#oModal-chambres').hide();   $('#oModal-salles').hide();    
            $("#occupe").hide(); $("#unavailable").hide();
            // Mets en surbrillance l'onglet courant et désactive les autres 
            oNavigation ("#link2Listener","#link1Listener","#link2","#link1") ;
            oNavigation ("#link1Listener","#link2Listener","#link1","#link2") ;
            oReservationDialogWithConstraint("ForChambres","table#chambres   tbody tr td:nth-child(2)",'#oModal-chambres',"#oDatepicker1","#oDatepicker2","busy","free","unavailable", "span","status-shortcode");
            oReservationDialogWithConstraint("ForSalles","table#salles   tbody tr td:nth-child(2)",'#oModal-salles',"#oDatepicker3","#oDatepicker4","busy","free","unavailable", "span","status-shortcode");
            
            filtre_statut("#btn-search","#search-zone") ; 
            oCniLockLogement("tbody tr td:nth-child(2)");
            redirectToCible_3("commandes","../index.php","tbody#corps input:checked,tbody#corpsSalles input:checked");
            //oLiberationDateSystem();
            //lockCheckBoxInLogements();
            initCalendarStructure('#dynamic-calendar tbody',oGetCurrentDate().split('/')[2]);
            oNavigationDate('#dynamic-calendar tbody',"#btn-date-droite");
            oNavigationDate('#dynamic-calendar tbody',"#btn-date-gauche");
            
            
          
            });
    </script>
    <script type="text/javascript" src="../js/SIHmainJs.js"></script>
  
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
 
 
  <!--Bar Footer Bar  css assurer par la classe Footer-->
  <nav id="footer" class="navbar navbar-light footer" style="background: rgba(100,200,100,0.4)" >
      <a class="navbar-brand" href="#">
          <sub  class="signer"> powered by SIHOUSE  </sub>
      </a>
  </nav>  
  
  

  </body>
  

  
</html>
<?php 
        }
?>

