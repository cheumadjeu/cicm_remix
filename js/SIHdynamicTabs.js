/**
	Author : Rodrigue Cheumadjeu 
	OBJECT : Gestion du basculement inter onglets
	LIMITE : Devra être surchargé pour fonctionner avec bien plus d'onglets
	DATE   : 14/06/2017 
*/

/** 
	oSetLightning METHOD : Active un onglet
	listener1 : Ecouteur permettant d'activer l'onglet courant
	listener2 : Ecouteur permettant de désactiver l'onglet courant
*/
	function oSetLightning(listener1,listener2){
        $(listener1).removeClass("nav-link").addClass("nav-link active") ;
        $(listener2).removeClass("nav-link active").addClass("nav-link") ;
                        
    }

/**
	oNavigation METHOD : Mets en surbrillance le contenu de l'onglet sélectionné
	listener1 : Ecouteur de l'onglet courant à afficher
	listener1 : Ecouteur de l'onglet à masquer
*/
    function  oNavigation (listener1,listener2,link1,link2){
      $(listener1).click(function(){
            $(link1).show();
            $(link2).hide();
           
            oSetLightning(listener1,listener2);
        });
    }
 

    
