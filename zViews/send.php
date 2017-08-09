<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 25/06/2017
 * Time: 19:29
 */
require_once("conn.php");


    if(isset($_POST['cni'])&&!empty($_POST['cni'])) {
        $nom=$_POST['nom'];
        $sexe=$_POST['sexe'];
        // $nomphoto=$_FILES['photo']['name'];
        // $fichierTempo=$_FILES['photo']['tmp_name'];
        // move_uploaded_file($fichierTempo,'../img/'.$_FILES['photo']['name']);
       
        /* $sexe=$_POST['sexe'];
         $email1=$_POST['don'];
         $matr=$_POST['matr'];
         $modele=$_POST['modele'];
         $cni=$_POST['cni'];
         $cni=$_POST['cni'];
         $cni=$_POST['cni'];*/

       $ps= $pdo->prepare("INSERT INTO personne(cni_personne,nom_personne,sexe,photo,vehicules,contact,login,password,don,email,categorie) VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $params = array($_POST['cni'],$_POST['nom'],$sexe,'zz.png', $_POST['voiture'],$_POST['contact'],'', "", "",$_POST['email'],'customer');
        $ps->execute($params);

        echo "<span> valider!!!!</span>";
    }
else{
    echo"<span>veuillez saisir la cni </span>";
}



?>