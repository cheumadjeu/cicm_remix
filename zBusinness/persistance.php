<?php

    class  Persistance{


        public $pdo;
        public $db_name='cicm';
        public $user;
        public $pass;
        public static $_instance;



        public function setUser($user){
            $this->user=$user;
        }

        public function setDb_name($db_name){
            $this->db_name=$db_name;
        }

        public function setPassword($pass){
            $this->pass=$pass;
        }

        public function getUser(){
            return $this->user;
        }

        public function getDb_name(){
            return $this->db_name;
        }

        public function getPassword(){
            return $this->pass;
        }



        public static function getInstance($user,$pass,$db_name){
            if(is_null(self::$_instance)){
                self::$_instance=new Persistance($user,$pass,$db_name);
            }
            return self::$_instance;
        }



        public function   __construct($user,$pass,$db_name){
            try{
                $strConnection='mysql:host=localhost;dbname='.$db_name;
                $this->pdo= new PDO($strConnection,$user,$pass);
                $this->db_name=$db_name;
                $this->user=$user;
                $this->pass=$pass;
                //echo 'connection reussie';
            }
            catch(PDOException $e){
                echo 'connection échouée';
                $msg="ERREUR PDO DANS".$e->getMessage();
                die($msg);
            }

        }








        //attrib est le tableau contenant les different champs de la table et params contient les valeus a inserer

        public function insertBD($attrib,$params,$table){

            $i=0;$a=""; $pt="";
            for($i=0;$i<count($attrib);$i++){
                if($i!=count($attrib)-1){  $a=$a.$attrib[$i].",";  $pt=$pt."?,";  }
                else { $a=$a.$attrib[$i];  $pt=$pt."?";  }

            }
            $query = "INSERT INTO $table($a) VALUES ($pt)" ;
            $ps=$this->pdo->prepare($query);
            //echo "REQUETE D'INSERTION : " . $query;
            //echo "insertion simulée réussie" ;
            $ps->execute($params);

        }




        public function selectBD($table,$list_champs_retourner,$clause)
        {

            $i = 0;
            $list_champ = "";
            $clauseString = "";
            $query = "";
            for ($i = 0; $i < count($list_champs_retourner); $i++) {
                if ($i != count($list_champs_retourner) - 1) $list_champ = $list_champ . $list_champs_retourner[$i] . ",";
                else  $list_champ = $list_champ . $list_champs_retourner[$i];

            }
            if (count($clause) != 0) {
                for ($i = 0; $i < count($clause); $i++) {
                    if ($i != count($clause) - 1) $clauseString = $clauseString . $clause[$i] . "AND";
                    else  $clauseString = $clauseString . $clause[$i];

                }

                $query = "SELECT $list_champ FROM $table WHERE $clauseString";
                
            }
            else $query = "SELECT $list_champ FROM $table";
            echo "REQUETE DE LECTURE : " . $query;
           
            return $query ;
         }


        //le tableau $champs_avec_valeur_a_mettre_a_jour est telque chaque element contient la mis a jour effective exple nom devient tona nom='tona'

        public  function updateBD($table,$champs_avec_valeur_a_mettre_a_jour,$clause){
            
            $i = 0;
            $list_champ = "";
            $clauseString = "";
            $query = "";
            for ($i = 0; $i < count($champs_avec_valeur_a_mettre_a_jour); $i++) {
                if ($i != count($champs_avec_valeur_a_mettre_a_jour) - 1) $list_champ = $list_champ . $champs_avec_valeur_a_mettre_a_jour[$i] . ",";
                else  $list_champ = $list_champ . $champs_avec_valeur_a_mettre_a_jour[$i];

            }
            
            if (count($clause) != 0) {
                for ($i = 0; $i < count($clause); $i++) {
                    if ($i != count($clause) - 1) $clauseString = $clauseString . $clause[$i] . "AND";
                    else  $clauseString = $clauseString . $clause[$i];

                }

                $query ="UPDATE $table SET $list_champ WHERE $clauseString";
                echo "REQUETE D'EDITION : " . $query;
            }

            //echo $list_champ.$clauseString.$query;


            $this->pdo->exec($query);
            //echo'modification simulée effectuée';

        }

        


        //clause clairement specifier exple nom='tona'

        public function deleteBD($table,$clause){
            $clauseString = "";
            $query = "";

            if (count($clause) != 0) {
                for ($i = 0; $i < count($clause); $i++) {
                    if ($i != count($clause) - 1) $clauseString = $clauseString . $clause[$i] . "AND";
                    else  $clauseString = $clauseString . $clause[$i];

                }

                $query ="DELETE FROM $table WHERE $clauseString";
                //echo "REQUETE DE SUPPRESSION : " . $query;
            }
            $this->pdo->exec($query);
            //echo 'suppression simulée effectuée';
        }

    }

    
?>