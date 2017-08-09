<?php
/**
 * Created by PhpStorm.
 * User: eric
 * Date: 25/06/2017
 * Time: 21:30
 */


try{
    $strConnection='mysql:host=localhost;dbname=cicm';
    $pdo= new PDO($strConnection,'root','');


}

catch(PDOException $e){
    $msg="ERREUR PDO DANS".$e->getMessage();
    die($msg);

}


?>