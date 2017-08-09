/**
	Author : Alain Tona 
	Contributor : Rodrigue Cheumadjeu  
	OBJECT : Gestion du basculement inter onglets
	LIMITE : Devra être surchargé pour fonctionner avec bien plus d'onglets
	DATE   : 14/06/2017 
*/


/** 
	OBJECT : Primitive d'impression d'un flux 
	REQUIRES : PLUGIN jquery.printelement.js
	sListener : Ecouteur d'évènement d'impression
	sFlow : Flux de données à imprimer
*/
function printFlow (sListener , sFlow , cPrintMode , sPageTile) {
	$(sListener).click(function(){
           $(sFlow).printElement({leaveOpen:true, printMode:cPrintMode, pageTitle:sPageTile})

       });
}


