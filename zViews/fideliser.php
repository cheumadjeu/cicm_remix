<?php include "../zBusinness/persistance.php" ?>
<?php $instance=persistance::getInstance('root','','cicm');  ?>
<?php 

     if (isset($_POST['jeton'])){
        if ($_POST['jeton']=="delete_customer"){
            $cni_personne = $_POST['cni_personne'];
            $clause = array("cni_personne=$cni_personne");
            try {
                $instance->deleteBD("personne",$clause) ;
               
            } catch (Exception $e) {
                echo "Echec de suppression du client" ;
            }
            include "readUser.php" ;
        }elseif($_POST['jeton']=="save_client"){
                $oTable="personne";
                $nom_client = $_POST['nom_personne'];
                $cni_client = $_POST['cni_personne'];
                $contact_client = $_POST['contact_personne'];
                $genre_client= $_POST['genre_client'];
                $email_client = $_POST['email_personne'];
                $voiture_client = $_POST['vehicules'];
                if($nom_client && $cni_client && $contact_client){
                    $oFields = array("cni_personne","nom_personne","sexe","photo","vehicules","contact","login","password","don","email","categorie");
                    $oValeurs = array($cni_client,$nom_client,$genre_client,"zz.png",$voiture_client,$contact_client,"","","",$email_client,"customer");
                    $instance->insertBD($oFields,$oValeurs,$oTable);
                }else echo "Des champs sont requis !!" ;
                include "readUser.php" ;
        }elseif($_POST['jeton']=="filter_cni"){
            $cni_personne=$_POST['cni_personne'];
            $champ = array ("cni_personne","nom_personne","sexe","photo","vehicules","contact","login","don","email");
            $table = "personne" ;
            $clauses = array("cni_personne='$cni_personne' "," personne.categorie='customer'");
            $query= $instance->selectBD($table,$champ,$clauses);  
            $resultSet=$instance->pdo->query($query);
            $resultSet->setFetchMode(PDO::FETCH_OBJ);
            while($p=$resultSet->fetch()){  
                ?>
                <tr>
                <td><img src="../img/<?php  echo $p->photo  ?>"  width="35px" height="35px" style="border-radius: 3em"></td>
                    <td><u><?php echo $p->nom_personne ?></u></td>
                    <td><?php echo $p->contact ?></td> 
                    <td><?php echo $p->email ?></td>
                <td><?php  echo $p->vehicules ?></td>
                    <td>
                    <img  title="éditer ses informations" width=20 height=20   id="btn-edit-customer"  name-customer-directive=<?php echo $p->nom_personne ?> id-customer-directive=<?php echo $p->cni_personne ?>  src='../img/modifier.png'/>&nbsp;&nbsp;&nbsp;
                    <img  title="supprimer ce client" width=20 height=20 id="btn-delete-customer"      name-customer-directive=<?php echo $p->nom_personne ?> id-customer-directive=<?php echo $p->cni_personne ?>  src='../img/trash.png'/>
                </td>
                
            </tr>
            <?php
            }
        }elseif($_POST['jeton']=="filter_nom"){
            $nom_personne=$_POST['nom_personne'];
            $champ = array ("cni_personne","nom_personne","sexe","photo","vehicules","contact","login","don","email");
            $table = "personne" ;
            $clauses = array("nom_personne LIKE '%$nom_personne%' "," personne.categorie='customer'");
            $query= $instance->selectBD($table,$champ,$clauses);  
            $resultSet=$instance->pdo->query($query);
            $resultSet->setFetchMode(PDO::FETCH_OBJ);
            while($p=$resultSet->fetch()){  
                ?>
                <tr>
                <td><img src="../img/<?php  echo $p->photo  ?>"  width="35px" height="35px" style="border-radius: 3em"></td>
                    <td><u><?php echo $p->nom_personne ?></u></td>
                    <td><?php echo $p->contact ?></td> 
                    <td><?php echo $p->email ?></td>
                <td><?php  echo $p->vehicules ?></td>
                    <td>
                    <img  title="éditer ses informations" width=20 height=20   id="btn-edit-customer"  name-customer-directive=<?php echo $p->nom_personne ?> id-customer-directive=<?php echo $p->cni_personne ?>  src='../img/modifier.png'/>&nbsp;&nbsp;&nbsp;
                    <img  title="supprimer ce client" width=20 height=20 id="btn-delete-customer"      name-customer-directive=<?php echo $p->nom_personne ?> id-customer-directive=<?php echo $p->cni_personne ?>  src='../img/trash.png'/>
                </td>
                
            </tr>
            <?php
            }
        }elseif($_POST['jeton']=="read_users"){
            include "readUser.php" ;
        }elseif($_POST['jeton']=="update_client"){
            $nom_client = $_POST['nom_personne'];
            $cni_client = $_POST['cni_personne'];
            $contact_client = $_POST['contact_personne'];
            $genre_client= $_POST['genre_client'];
            $email_client = $_POST['email_personne'];
            $vehicules = $_POST['vehicules'];
            $table = "personne" ;
            $champsWithValues = array("cni_personne='$cni_client'","nom_personne='$nom_client'","contact='$contact_client'","email='$email_client'","sexe='$genre_client'","vehicules='$vehicules'");
            $clause = array("personne.cni_personne='$cni_client'");
            $instance->updateBD($table,$champsWithValues,$clause);
            include "readUser.php" ;
        }
     }
             
    else{
        ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="../css/custom.css" />
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="../js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../js/SIHajaxifiying.js"></script> 
    <script type="text/javascript" src="../js/ajax.js"></script> 
    <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
    <link  rel="stylesheet" href="../css/jquery-ui.css" />
    

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

<div class="afficher"></div>

<div class="container spacer">

<!--debut entete CNI-->
    
    <div style="margin-top: 1em; margin-left: 75%;" class="row">
        <div class="col-xs-4" id="pic-logement-parent">
            <a href="locaux.php" class="bleu">
               <logement ><img id="pic-logement" style="margin-left: 20px;" src="../img/house.png" /><br/>
                 Logements</logement><br/>
            </a>
        </div>
        <div style="margin-left: 1em" class="col-xs-4" id="pic-commande-parent">
            <a href="../index.php" class="bleu">
                <commandes><img id="pic-commande" style="margin-left: 22px;" src="../img/buy.png" /><br/>
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



    <div style="margin-bottom: 2em;" class="row">
        <div  class="form-group " style="margin-left: 10em;">
            <input title="Appuyer sur entrée pour valider" id="cni-zone" style="width: 16em; margin-right:0.6em;"  value="" type="text"  PLACEHOLDER="rechercher par CNI" >
            <input title="Appuyer sur entrée pour valider" id="name-zone" style="width: 16em; margin-right:1em;"  value="" type="text"  PLACEHOLDER="rechercher par nom" >
        
        </div>

        <div>
            <button id="test-fidelite" onclick=oShowDialog7("#test-fidelite","#dialogue-enrollement") type="button" class="btn btn-primary btn-sm">Nouveau client</button>
        </div>

        
    </div>
    <!--Fin bloc de cni   -->

    <!--Bloc Table-->
    <div class="row">
            <div class="col-lg-12" id="zBox">
                <table  class="table table-bordered table-striped">
                    <thead class="bg-warning">
                    <tr style="color: #ffffff" >
                        <th style="text-align:center">X</th>
                        <th >Noms</th>
                        
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Véhicule</th>
                        <th>Actions</th>

                    </tr>
                    </thead>
                    <tbody class="utilisateurs" >
                       

                   
                    </tbody>
                </table>
            </div>


            
        </div>
    <!--Fin Bloc Table-->

<!--bloc de pagination -->
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
    </nav>
  <!--fin bloc pagination -->

</div>
            <div id="dialogue-enrollement" title="Informations du client">
            <div class="results" style="color:red;">  </div>

                <form method="post" class="formulaire" enctype="multipart/form-data" >
                <div class="resultat"></div>
                
                    <div class="form-group row ">
                        <label class="col-2 col-form-label" >CNI</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" value="" PLACEHOLDER="CNI" id="cni-client" required >
                        </div>
                    </div>

                    <div class="form-group row ">
                        <label  class="col-2 col-form-label">Noms</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text" value="" id="nom-client"  PLACEHOLDER="noms et prenoms" required  >
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Contact</label>
                        <div class="col-sm-10">
                            <input type="tel" class="form-control" id="contact-client" placeholder="677742456" required >
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="email-client" placeholder="Email" >
                        </div>
                    </div>
                     <div>
                        <label>Genre :</label>   
                        <input style="margin-right: 6px;" value="M" type="radio" class="spacerRight genre" aria-label="" name="genre-client" checked >Masculin
                        <input style="margin-left: 10px;" value="F" type="radio" aria-label=""  name="genre-client" class=" genre"> Féminin
                     </div>
                     <div class="row">
                        <fieldset class="form-control">
                            <legend class="form-control bg-warning">Véhicules</legend>    
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Immatriculation</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="immatriculation-voiture-client" >
                            </div>
                            <label for="inputEmail3" class="col-sm-2 col-form-label ">Modèle</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="modele-voiture-client">
                            </div>
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Marque</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="marque-voiture-client" >
                            </div>
                        </fieldset>
                     </div>
                   
                </form>
            </div>
            



<!--  modal pour afficher les info d'une cni qui existe  -->


<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <span class="modal-title" style="color: #333;" id="exampleModalLabel">Informations</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body info" >
                          
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-primary" data-dismiss="modal"  >ok</button>
            </div>            
        </div>
    </div>
</div>




<!--fin de la modal qui affiche les infos d'une existing cni-->


<script type="text/javascript" src="../js/SIHmainJs.js"></script>
<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Fidelisation du client ')
        modal.find('.modal-body input').val("")
    })

      $('#infoModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var recipient = button.data('whatever') // Extract info from data-* attributes
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find('.modal-title').text('Fidelisation du client ')
        modal.find('.modal-body input').val("")
    })

  
 
</script>

<!--Bar Footer Bar  css assurer par la classe Footer-->
<nav class="navbar navbar-light footer" style="background: rgba(100,200,100,0.4)" >
    <a class="navbar-brand" href="#">
        <sub  class="signer"> powered by SIHOUSE  </sub>
    </a>
</nav>
<!--Fin Footer bar -->




 
<div id="id-delete-confirm-dialog" title="CICM SYSTEM">
    <input type="hidden" id="id-delete-personne" />
    Voulez vous vraiment supprimer le client  <span id="message-nom-personne"></span>
</div>

<script>
    $("#dialogue-enrollement").hide();
    oShowDialog6("#btn-delete-customer","#id-delete-confirm-dialog");
    oShowDialog9("#btn-edit-customer","#dialogue-enrollement");
    oFilterCni("#cni-zone");
    oFilterName("#name-zone");
    enableOrDisableCNIzone ();
    initItemWithCNIForNewCustomer("#cni-client");
    redirectToCible_1("logement","locaux.php");
    redirectToCible_1("commandes","../index.php");

   
</script>
</body>
</html>

<?php

} 

?>
