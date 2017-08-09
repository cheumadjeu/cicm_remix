<?php

include "../zBusinness/persistance.php" ;

$instance=persistance::getInstance('root','','cicm');
$champ = array ("cni_personne","nom_personne","photo");
 $table = "personne" ;
 $nom=$_POST['nom'];
 $clausesSalles = array("'$nom'=personne.nom_personne ");
 $query = $instance->selectBD($table,$champ,$clausesSalles);
 $resultSetProfile=$instance->pdo->query($query);
 $resultSetProfile->setFetchMode(PDO::FETCH_OBJ);

 while($p=$resultSetProfile->fetch()){
     ?>
    <img src="../img/<?php  echo $p->photo  ?>"  width="50px" height="50px" style="border-radius: 5em;margin-bottom:20px;margin-left:50%;" /> </br>
    <span style="color: blue;margin-left:40%"> CNI  :  </span><?php echo  $p->cni_personne ; ?>   <br/>
    <span style="color: blue;margin-left:40%"> nom  :  </span><?php echo  $p->nom_personne ; ?>
     
<?php
    
 }
 






?>