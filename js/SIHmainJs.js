/**
	Author : Rodrigue Cheumadjeu 
			 Alain Tona
*/

/*@@@@@@@@@@@@@@@@@ Fichier Js contenant la logique fonctionnelle client générique de lapplication @@@@@@@@@@@@@@@@*/

/**
	Fonction d'affichage de la fenêtre modale à isoler et refactoriser
	
*/
function printModalWindow(idModal, title) {
    $(document).on('show.bs.modal', idModal, function(event) {
        var button = $(event.relatedTarget)
        var recipient = button.data('whatever')
        var modal = $(this)
        modal.find('.modal-title').text(title)
        modal.find('.modal-body input').val("")

    })
}


/*Cette fonction ne rend un dialogue que si le statut de la chambre est libre */
function oReservationDialogWithConstraint(oForRooms, oColumn, oIdModal, oDpickerField1, oDpickerField2, dStateBusy, dStateFree, dStateUnav, dHTMLkey, dHTMLdirective) {
    $(document).on('click', oColumn, function() {
        if(oForRooms=="ForChambres"){
            var val = $(this).parent().find(dHTMLkey).attr(dHTMLdirective);
            $(oDpickerField1).datepicker({ inline: true });
            $(oDpickerField2).datepicker({ inline: true });
            if (val == dStateBusy) {
                $('#tCode-chambre').val($(this).text());
                oShowDialog5(oColumn, "#occupe");
            }else
            if (val == dStateFree) {

                $('#oBuffer').val($(this).text());
                //$("table#chambres   tbody tr th").parent().find("input[value="+$().val()+"]").prop("checked","true");
                oShowDialog3(oColumn, oIdModal);

            } else if (val == dStateUnav) {
                $('#sCode-chambre').val($(this).text());
                oShowDialog4(oColumn, "#unavailable");
            }
        }else if(oForRooms=="ForSalles"){
            var val = $(this).parent().find(dHTMLkey).attr(dHTMLdirective);
            $("#datepicker3").datepicker({ inline: true });
            $("#datepicker4").datepicker({ inline: true });
            if (val == dStateBusy) {
                $('#tCode-chambre').val($(this).text());
                oShowDialog5Prim(oColumn, "#occupe");

            } else 
            if (val == dStateFree) {
                $('#oBuffer').val($(this).text());
                //$("table#chambres   tbody tr th").parent().find("input[value="+$().val()+"]").prop("checked","true");
                oShowDialog3Prim(oColumn, oIdModal);

            } else if (val == dStateUnav) {
                $('#sCode-chambre').val($(this).text());
                oShowDialog4Prim(oColumn, "#unavailable");
            }
        }
        

    });
}





/* Doubler le montant d'un service côté client: Reprendre à cette étape */
function oTimesAmount(oQuantite, oCoutUnitaire) {

    var oOriginalQteValue = $(oQuantite).val();
    $(document).on('change', oQuantite, function() {
        var oAmountOfService = $("#trichZone").val() * $(oQuantite).val();
        $(oCoutUnitaire).val(oAmountOfService);
        if ($(oQuantite).val() <= 0) {
            $(oQuantite).val("0");
            $(oCoutUnitaire).val("0");
        }
    });
}



function oExtractFlowForCommands(oListener, oFlowToPrint, oClassToHide, oMessage, oPopup) {
    var $t = $(oFlowToPrint).clone();
    $(oClassToHide).hide();
    printFlow(oListener, oFlowToPrint, oPopup, oMessage);
    //setTimeout(function() {$(oFlowToPrint).html($t);}, 200);

}



function oMisAjourDate(sListener) {
    $(sListener).find('tr').each(function() {
        date1 = new Date($(this).children().eq(2).text());
        date2 = new Date();
        var t = oDateDiff(date1, date2);
        if (!t.day) $(this).children().eq(2).next().text("0 jours ");
        else $(this).children().eq(2).next().text(t.day + "  jours ");
    });
}


function oAddService(oIdService, oRoot) {

    $(document).on('click', oIdService, function() {
        if ($("#field-services").val() != '') {
            var tbodyRoot = $(oRoot).html();
            tbodyConnexe = "<tr id='corps-commande'>";
            tbodyConnexe = tbodyConnexe + "<th scope=row id='service'>" + $("#trichZoneForCode").val() + "</th>";
            tbodyConnexe = tbodyConnexe + "<td scope=row id='service'>" + $("#field-services").val() + "</td>";
            tbodyConnexe = tbodyConnexe + "<td id='quantite'>" + $("#field-quantity").val() + "</td>";
            tbodyConnexe = tbodyConnexe + "<td id='prix'>" + $("#field-uniq-price").val() + "</td>";
            tbodyConnexe = tbodyConnexe + "<td class='text-center cacher'>";
            tbodyConnexe = tbodyConnexe + "<img  title=Modifier width=20 height=20  class='btn-edit-commande'  src='img/modifier.png'/>";
            tbodyConnexe = tbodyConnexe + "<img  width=20 height=20 class='btn-delete-commande' style='margin-left: 15px' src='img/delete.png'/>";
            tbodyConnexe = tbodyConnexe + "</td>";
            tbodyConnexe = tbodyConnexe + "</tr>";
            $("#flowToPrint tbody").html(tbodyConnexe + tbodyRoot);
            oSommeCoutCommande("#cout-commande");
            $("#zQuantity").val($("#zQuantity").val() + $("#field-quantity").val() + "@#@");
            $("#zNom_service").val($("#zNom_service").val() + $("#field-services").val() + "@#@");

            $("#field-services").val("");
            $("#field-uniq-price").val("0");
            $("#field-quantity").val("0");



} else ("Précisez un service SVP !! ");
    });
}

function oSommeCoutCommande(oTotal) {
    var som = 0;
    var _SEUIL_ARTICLES = 70; //Le max d'articles sur une commande
    for (var i = 1; i < _SEUIL_ARTICLES; i++) {
        var tmp = $("#flowToPrint tbody tr:nth-child(" + i + ") td:nth-child(4)").text();
        $("#buffer").val(tmp);
        var atmp = parseInt($("#buffer").val());
        if (atmp) {
            som = som + atmp;
        }
        $(oTotal).html(som);
        
    }
    return som ;
}

//fonction qui calcul la difference de date


function oDateDiff(date1, date2) {
    var diff = {}
    var tmp = date2 - date1;
    tmp = Math.floor(tmp / 1000);
    diff.sec = tmp % 60;
    tmp = Math.floor((tmp - diff.sec) / 60);
    diff.min = tmp % 60;
    tmp = Math.floor((tmp - diff.min) / 60);
    diff.hour = tmp % 24;
    tmp = Math.floor((tmp - diff.hour) / 24);
    diff.day = tmp;
    return diff;
}




// oMisAjourDate('tbody');

//Suppression d'une ligne d'articles dans la commande
function oDeleteRowCommande(oListenerClass) {
    $(document).on('click', oListenerClass, function() {
        $(this).parent().parent().remove();
        $("#cout-commande").css("color", "green");
        oSommeCoutCommande("#cout-commande");
    });
}

//Editer une ligne d'articles dans la commande
function oEditRowCommande(oListenerClass) {
    $(document).on('click', oListenerClass, function() {
        var serviceToEdit = $(this).parent().parent().find('#service').html();
        var quantiteToEdit = $(this).parent().parent().find('#quantite').html();
        var prixToEdit = $(this).parent().parent().find('#prix').html();
        $("#field-services").val(serviceToEdit);
        $("#field-quantity").val(quantiteToEdit);
        $("#field-uniq-price").val(prixToEdit);
        $(this).parent().parent().remove();
        oSommeCoutCommande("#cout-commande");
    });
}



// get La date système
function oGetCurrentDate() {
    var now = new Date();
    var day = now.getDate();
    
    var month = now.getMonth() + 1;
    if(month<10)
        month = "0"+month;
    var year = now.getFullYear();
    realDate = day + "/" + month + "/" + year;
    return realDate;
}

// Présenter un UI dialogue avancé
function oShowDialog(oListener, oScreen, oMode) {

    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Non": function() {
                $(this).dialog("close");
            },
            "Oui": function() {

                var tQuantities = $("#zQuantity").val();
                var tServices = $("#zNom_service").val();

                var qteTAB = oUnParseString(tQuantities);
                var servicesTAB = oUnParseString(tServices);
                // Fabrication du query string
                var params = "";
                var cni_personne = $("#kCNI").val();
                params = "jeton=saveCommande&cni_personne=" + cni_personne;
                var i = 0;
                var size = qteTAB.length;
                var temp = "";
                //alert(size);
                while (i < size - 1) {
                    temp += "&service" + i + "=" + servicesTAB[i] + "&quantite" + i + "=" + qteTAB[i];
                    i++;
                }
                params += "&nb_enreg=" + (size - 1);
                params += temp;
                //alert(params);
                ajaxing_save_commande(params, "POST", "index.php", "warningsSuccess", "warningFailure");
                //var cloneFlowToPrint = $('#flowToPrint').html();
                //alert($("#flowToPrint tbody tr td:nth-child(4)").html());
                var cni_personne = cni_personne ;
                var message_bienvenue = "Bienvenu au centre MAISON CICM";
                var message_queue = "Votre satisfaction est notre priorité";
                var contact = "667876571 / 690876545";
                var site_web ="www.cicm.cm";
                $("#flowToPrint").prepend("<strong> CNI :"+cni_personne+"</strong><br/><strong>"+message_bienvenue+"</strong>");
                $("#flowToPrint").append("<strong>"+message_queue+"</strong><br/><strong>"+contact+"</strong><br/><strong>"+site_web+"</strong>");
                $("#flowToPrint").append("<p>ToTal : <strong>"+oSommeCoutCommande("#cout-commande")+"</strong> FCFA</p>");
                $("#flowToPrint").removeAttr("style");
                $("#flowToPrint tr th:nth-child(5)").remove();
                $("#flowToPrint tbody tr td:nth-child(5)").remove();
                $('#flowToPrint').printElement({ leaveOpen: true, printMode: 'popup', pageTitle: 'Facture CICM' });
                window.location.replace("http://localhost/cicm");  //OK
                $(this).dialog("close");

            }
        }
    });

}


// Présenter un UI dialogue avancé
function oShowDialog1(oListener, oScreen, oMode) {

    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Non": function() {
                $(this).dialog("close");
            },
            "Oui": function() {

                $(this).dialog("close");

            }
        }
    });

}

function oShowDialog10(oListener, oScreen,oColor) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Non": function() {
                $(this).dialog("close");
            },
            "Oui": function() {
                $(this).dialog("close");
                $("#dynamic-calendar tbody td").each(function(){
                    if( $(this).css("background-color") && $(this).css("background-color")==oColor ){
                         $(this).removeAttr("style");
                         $(this).removeAttr("title");

                }
                });
            }
        }
    });
}

function oShowDialog11(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Quitter": function() {
                $(this).dialog("close");
            }
        }
    });
}



// Présenter un UI dialogue avancé
function oShowDialog3(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        width : 1250,
        buttons: {
            "Fermer": function() {
                $(this).dialog("close");
            },
            "Travaux": function() {
                var params = "";
                var code_chambre = $("#oBuffer").val();
                params = "code_chambre=" + code_chambre + "&jeton=indisponibleChambre";
                //alert(params);
                ajaxing_native(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");

            },
            "Réserver": function() {
                var selecteur1=inverseDateCalendar($("#oDatepicker1").val());
                var selecteur2=inverseDateCalendar($("#oDatepicker2").val());
                selecteur1=oDeleteZeroFromDayDate(selecteur1);
                selecteur2=oDeleteZeroFromDayDate(selecteur2);
                if(!zChevaucherDate(selecteur1,selecteur2)) {
                    fillBusySpaces(selecteur1,selecteur2);
                    var params = "";
                    var cni_personne = $("#oCni-personne").val();
                    var date_attribution =inverseDateTrue($("#oDatepicker1").val());
                    var date_liberation = inverseDateTrue($("#oDatepicker2").val());
                    var code_chambre = $("#oBuffer").val();
                    params = "jeton=reserverChambre&cni_personne=" + cni_personne + "&date_attribution=" + date_attribution + "&date_liberation=" + date_liberation + "&code_chambre=" + code_chambre;
                    ajaxing_native(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                    //$(this).dialog("close");
                }    
                else alert("chevauchement de dates , impossible d'effectuer une réservation sur cette plage horaire");
                
            }
        }
    });

}


function oShowDialog3Prim(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Annuler": function() {
                $(this).dialog("close");
            },
            "Travaux": function() {
                var params = "";
                var code_chambre = $("#oBuffer").val();
                params = "code_chambre=" + code_chambre + "&jeton=indisponibleSalle";
                //alert(params);
                ajaxing_native_prim(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");

            },
            "Réserver": function() {
                var params = "";
                var cni_personne = $("#oCni-personne").val();
                var date_attribution =inverseDateTrue($("#datepicker3").val());
                var date_liberation = inverseDateTrue($("#datepicker4").val());
                var code_chambre = $("#oBuffer").val();
                //$(input['type=checkbox']).css("background","yellow");
                params = "jeton=reserverSalle&cni_personne=" + cni_personne + "&date_attribution=" + date_attribution + "&date_liberation=" + date_liberation + "&code_chambre=" + code_chambre;
                ajaxing_native_prim(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                //$(this).dialog("close");

            }
        }
    });

}


function oShowDialog4Prim(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Libérer": function() {
                var params = "";
                var code_chambre = $("#sCode-chambre").val();

                params = "code_chambre=" + code_chambre + "&jeton=libererSalle";
                //alert(params);
                ajaxing_native_prim(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            },
            "quitter": function() {
                $(this).dialog("close");

            }
        }
    });
}



function oShowDialog4(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Libérer": function() {
                var params = "";
                var code_chambre = $("#sCode-chambre").val();

                params = "code_chambre=" + code_chambre + "&jeton=libererChambre";
                //alert(params);
                ajaxing_native(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            },
            "quitter": function() {
                $(this).dialog("close");

            }
        }
    });
}

function oShowDialog5(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Libérer": function() {
                var params = "";
                var code_chambre = $("#tCode-chambre").val();
                params = "code_chambre=" + code_chambre + "&jeton=libererChambre";
                //alert(params);
                ajaxing_native(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            },
            "quitter": function() {
                $(this).dialog("close");

            }
        }
    });
}


function oShowDialog5Prim(oListener, oScreen) {
    $(oScreen).dialog({
        modal: true,
        buttons: {
            "Libérer": function() {
                var params = "";
                var code_chambre = $("#tCode-chambre").val();
                params = "code_chambre=" + code_chambre + "&jeton=libererSalle";
                //alert(params);
                ajaxing_native_prim(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            },
            "quitter": function() {
                $(this).dialog("close");

            }
        }
    });
}



function oNotSubmittingBlankBill() {
    $(document).on('click', "#btn-pay", function() {
        if (!$(this).parent().find("#corps-commande").html()) {
            alert("Commande vide , choisissez au moins un service pour régler !! Merci");
        } else {

            oShowDialog("#btn-pay", "#cniModal", "open");

        }
    });
}


function oLaodUniqprice(oZoneService) {
    $(document).on('blur', oZoneService, function() {
        var params = "";
        var nom_service = $(oZoneService).val();
        params = "nom_service=" + nom_service + "&jeton=chargerPrixUnique";
        //alert(params);
        ajaxing_commands(params, "POST", "index.php", "warningsSuccess", "warningFailure");
    });
}



function viderCommande() {
    $(document).on('click', "#btn-reset", function() {

        $("#corpsCommande").html("");
        $("#zQuantity").val("");
        $("#zNom_service").val("");
    });
}

function viderCommande_brief() {
    $("#corpsCommande").html("");
    $("#zQuantity").val("");
    $("#zNom_service").val("");
}

function oUnParseString(str) {
    var strToArray = new Array();
    strToArray = str.split("@#@");
    return strToArray;
}


function oShowDialog6(oListener, oScreen) {
    $("#id-delete-confirm-dialog").hide();
    $(document).on('click',oListener,function(){
        $("#message-nom-personne").html($(this).attr("name-customer-directive")) ;
        $("#id-delete-personne").val($(this).attr("id-customer-directive"));
        $(oScreen).dialog({
        modal: true,
        height :200,
        buttons: {
            "OUI": function() {
                var params = "";
                var id_customer_directive = $("#id-delete-personne").val();
                params = "cni_personne=" + id_customer_directive + "&jeton=delete_customer";
                
                ajaxing_customers(params, "POST", "fideliser.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            },
            "NON": function() {
                $(this).dialog("close");

            }
        }
    });
    });
    
}


function initUserInfo() {
    //alert($(this).attr("name-customer-directive"));
}



function oShowDialog9(oListener, oScreen) {
    
    $(document).on('click',oListener,function(){
        var nom = $(this).parent().parent().find("nom").text();
        var contact = $(this).parent().parent().find("contact").text();
        var email = $(this).parent().parent().find("email").text();
        var vehicules = $(this).parent().parent().find("vehicules").text();
        var immatriculation = vehicules.split(";")[0];
        var marque = vehicules.split(";")[1];
        var modele = vehicules.split(";")[2];
        $('#cni-client').val($(this).attr("id-customer-directive"));
        $('#nom-client').val(nom);
        $('#contact-client').val(contact);
        $('#email-client').val(email);
        $('#modele-voiture-client').val(modele);
        $('#marque-voiture-client').val(marque);
        $('#immatriculation-voiture-client').val(immatriculation);

        $("logement").attr("oCni-personne-logement-fidelite",$(this).attr("id-customer-directive"));
        $("commandes").attr("oCni-personne-commandes-fidelite",$(this).attr("id-customer-directive"));
        //alert($("commandes").attr("oCni-personne-commandes-fidelite"));
        $(oScreen).dialog({
        modal: true,
        width : 400,
        buttons: {
            "Annuler": function() {
                $(this).dialog("close");

            },
            "Actualiser": function() {
                var nom_client = $('#nom-client').val();
                var cni_client = $('#cni-client').val();
                var contact_client = $('#contact-client').val();
                var genre_client= document.querySelector('input[name=genre-client]:checked').value;
                var email_client = $('#email-client').val();
                var immatriculation_voiture_client = $('#immatriculation-voiture-client').val();
                var modele_voiture_client = $('#modele-voiture-client').val();
                var marque_voiture_client = $('#marque-voiture-client').val();
                var voiture_client = modele_voiture_client + ";" + immatriculation_voiture_client + ";" + marque_voiture_client;
                var params = "" ;
                params += "cni_personne="+cni_client+"&nom_personne="+nom_client+"&contact_personne="+contact_client ;
                params += "&genre_client="+genre_client+"&email_personne="+email_client+"&vehicules="+ voiture_client ;
                params += "&jeton=update_client";
                ajaxing_customers(params,"POST","fideliser.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            }
        }
    });
    });
    
}



function oShowDialog7(oListener, oScreen) {
    $('#nom-client').val("");
    $('#cni-client').val("");
    $('#email-client').val("");
    $('#contact-client').val("");
    $('#immatriculation-voiture-client').val("");
    $('#modele-voiture-client').val("");
    $('#marque-voiture-client').val("");
    
    $(oScreen).dialog({
        modal: true,
        width : 400,
        buttons: {
            
            "Annuler": function() {
                $(this).dialog("close");

            },
            "Fidéliser": function() {
                $("logement").attr("oCni-personne-logement-fidelite",$("#cni-client").val());
                $("commandes").attr("oCni-personne-commandes-fidelite",$("#cni-client").val());
                //alert($("commandes").attr("oCni-personne-commandes-fidelite"));
                var nom_client = $('#nom-client').val();
                var cni_client = $('#cni-client').val();
                var contact_client = $('#contact-client').val();
                var genre_client= document.querySelector('input[name=genre-client]:checked').value;
                var email_client = $('#email-client').val();
                var immatriculation_voiture_client = $('#immatriculation-voiture-client').val();
                var modele_voiture_client = $('#modele-voiture-client').val();
                var marque_voiture_client = $('#marque-voiture-client').val();
                var voiture_client = modele_voiture_client + ";" + immatriculation_voiture_client + ";" + marque_voiture_client;
                var params = "" ;
                params += "cni_personne="+cni_client+"&nom_personne="+nom_client+"&contact_personne="+contact_client ;
                params += "&genre_client="+genre_client+"&email_personne="+email_client+"&vehicules="+ voiture_client ;
                params += "&jeton=save_client";
                ajaxing_save_customers(params,"POST","fideliser.php", "warningsSuccess", "warningFailure");
                $(this).dialog("close");
            }
        }
    });
}




function oFilterCni(oListener){
   $(document).on('keyup',oListener,function(e){
        if(e.keyCode== 13 || e.which == 13) {
            if($(oListener).val()!=""){
                    if($(oListener).val().length==9 || $(oListener).val().length==17){
                        var cni_personne=$(oListener).val();
                        var params ="";
                        params+="cni_personne="+cni_personne+"&jeton=filter_cni";
                    }else if($(oListener).val().length>9 && $(oListener).val().length<17){
                        alert("Longeur de CNI incorrecte");
                        var params ="jeton=read_users";
                    }else if ($(oListener).val().length<9){
                        alert("CNI trop courte");
                        var params ="jeton=read_users";
                    }else  if ($(oListener).val().length>17){
                        alert("CNI trop longue!!");
                        var params ="jeton=read_users";
                    }
                    $("logement").attr("oCni-personne-logement-fidelite",$("#cni-zone").val());
                    $("commandes").attr("oCni-personne-commandes-fidelite",$("#cni-zone").val());
                    //alert($("commandes").attr("oCni-personne-commandes-fidelite"));
            }else{
                alert("Renseignez une CNI svp!");
                var params ="jeton=read_users";
            }
            ajaxing_customers(params,"POST","fideliser.php", "warningsSuccess", "warningFailure");
        }
    });
}

function oFilterName(oListener){
   $(document).on('keyup',oListener,function(e){
        if(e.keyCode== 13 || e.which == 13) {
            
            if($(oListener).val()!=""){
                        var nom_personne=$(oListener).val();
                        var params = "nom_personne="+nom_personne+"&jeton=filter_nom";
                    
                    $("logement").attr("oCni-personne-logement-fidelite",$("#cni-zone").val());
                    $("commandes").attr("oCni-personne-commandes-fidelite",$("#cni-zone").val());
                    //alert($("commandes").attr("oCni-personne-commandes-fidelite"));
            }else{
                alert("Renseignez un nom svp");
                var params ="jeton=read_users";
            }
            ajaxing_customers(params,"POST","fideliser.php", "warningsSuccess", "warningFailure");
        }
    });

}


function enableOrDisableCNIzone (){
    $(document).on('click',"#btn-edit-customer",function(){
        $("#cni-client").attr("readonly","true");
        
    });
    $("#test-fidelite").click(function(){
        $("#cni-client").removeAttr("readonly");
    });
}


function initItemWithCNIForNewCustomer (oListener){
    var params="";
        
    $(document).on('click',oListener,function(){
        $("logement").attr("oCni-personne-logement-fidelite",$("#cni-client").val());
        $("commandes").attr("oCni-personne-commandes-fidelite",$("#cni-client").val());
        // params = "jeton=send_CNI_to_locaux&cni_personne=" +  $("logement").attr("oCni-personne-logement-fidelite");
        // ajaxing_page(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
    });
}


function redirectToCible_1(oListener,oCible){
    $(document).on("click",oListener,function(){
         $(this).parent().parent().find("a").attr("href",oCible+"?jeton=receive_cni_for_logement&cni_personne="+$("logement").attr("oCni-personne-logement-fidelite"));   
    });
    
}

function oCniLockLogement(oListener){
    $(document).on("click",oListener,function(){
        if($("#oCni-personne").val()){
            $("#oCni-personne").attr("readonly","true");
        }else {
            $("#oCni-personne").removeAttr("readonly");
        } 
    });
}


function oCniLockCommandes(oListener){
    $(document).on("click",oListener,function(){
        if($("#kCNI").val()){
            $("#kCNI").attr("readonly","true");
        }else {
            $("#kCNI").removeAttr("readonly");
        } 
    });
}

function redirectToCible_3 (oListener,oCible,oTbodyItemCheck){
    $(document).on("click",oListener,function(){
          var params = "jeton=transmission_chambres_for_commandes&cni_personne="+$("#oCni-personne").val(); 
          params += $(oTbodyItemCheck).map(function(){return "&"+this.name +"="+this.value; }).get().join().replace(/,/g,"");
          
          $(this).parent().parent().find("a").attr("href",oCible+"?"+params);   
    });
}


function startCoutCommande (){
    $(document).load(function(){
        //alert("toto");
        oSommeCoutCommande("#cout-commande");
    });

}

function inverseDateCalendar(oDateStr){
    var jour = oDateStr.split("/")[1] ;
    var mois = oDateStr.split("/")[0]
    var annee = oDateStr.split("/")[2]
    var dateInverseeStr = jour+"-"+ mois +"-"+ annee;
    return dateInverseeStr ; 
}


function inverseDateAnglo(oDateStr){
    var jour = oDateStr.split("/")[2] ;
    var mois = oDateStr.split("/")[1]
    var annee = oDateStr.split("/")[0]
    var dateInverseeStr = jour +"/"+ mois +"/"+ annee ;
    return dateInverseeStr ; 
}

function inverseDate(oDateStr){
    var jour = oDateStr.split("/")[1] ;
    var mois = oDateStr.split("/")[0]
    var annee = oDateStr.split("/")[2]
    var dateInverseeStr = annee +"/"+ mois +"/"+ jour ;
    return dateInverseeStr ; 
}


function inverseDateTrue(oDateStr){
    var jour = oDateStr.split("/")[2] ;
    var mois = oDateStr.split("/")[0]
    var annee = oDateStr.split("/")[1]
    var dateInverseeStr = annee +"/"+ mois +"/"+ jour ;
    return dateInverseeStr ; 
}

function inverseDateReal(oDateStr){
    var jour = oDateStr.split("-")[0] ;
    var mois = oDateStr.split("-")[1]
    var annee = oDateStr.split("-")[2]
    var dateInverseeStr = annee +"/"+ mois +"/"+ jour ;
    return dateInverseeStr ; 
}

function oFilterCommande(){
   var $date_debut=inverseDateTrue($("#date-debut").val());
   var $date_fin=inverseDateTrue($("#date-fin").val());
   var params="date_debut="+$date_debut+"&date_fin="+$date_fin+"&jeton=filter_commande";
   ajaxing_filter_commande(params, "POST", "index.php", "warningsSuccess", "warningFailure");

}

function dateBoxOnCommands (oIDZone){
    $(document).on('focus', oIDZone, function() {
        $(oIDZone).datepicker({ inline: true });
    });
}

function lockCheckBoxInLogements(){
    $("table#chambres   tbody tr th").css("background","#49a");//attr("readonly","true");
    $("table#chambres   tbody tr th  input[type=checkbox]").prop("disabled","true");
}

function isBissextile(annee){
   //var datCur=oGetCurrentDate();
  // var annee=datCur.split('/')[2];
   if(annee%4==0)
        return true;
   else
        return false;     
}

function initDimensionCalendar(annee){
    var isBissextilevalue=isBissextile(annee);
    var dimension=365;
    if(isBissextilevalue)
        dimension=366;
    return dimension;        
}

function initCalendarStructure(otbodyRow ,oAnnee){
    var n=initDimensionCalendar(oAnnee);
    var janvier="";var fevrier="";var mars="";var avril="";var mai="";var juin="";var juillet="";var aout="";
    var septembre="";var octobre="";var novembre="";var decembre="";
    for(var i=1;i<=n;i++){
        
         if(i>=1 && i<=31) janvier += "<td id='"+i+"-01-"+oAnnee+"'>"+i+"</td>";
        
        if(!isBissextile(oAnnee)){
                 if (i>=32 && i<=59)     fevrier += "<td id='"+(i-32+1)+"-02-"+oAnnee+"'>"+(i-32+1)+"</td>";
            else if (i>=60 && i<=90)     mars += "<td id='"+(i-60+1)+"-03-"+oAnnee+"'>"+(i-60+1)+"</td>";
            else if (i>=91 && i<=120)    avril += "<td id='"+(i-91+1)+"-04-"+oAnnee+"'>"+(i-91+1)+"</td>";
            else if (i>=121 && i<=151)   mai += "<td id='"+(i-121+1)+"-05-"+oAnnee+"'>"+(i-121+1)+"</td>";
            else if (i>=152 && i<=181)   juin += "<td id='"+(i-152+1)+"-06-"+oAnnee+"'>"+(i-152+1)+"</td>";
            else if (i>=182 && i<=212)   juillet += "<td id='"+(i-182+1)+"-07-"+oAnnee+"'>"+(i-182+1)+"</td>";
            else if (i>=213 && i<=243)   aout += "<td id='"+(i-213+1)+"-08-"+oAnnee+"'>"+(i-213+1)+"</td>";
            else if (i>=244 && i<=273)   septembre += "<td id='"+(i-244+1)+"-09-"+oAnnee+"'>"+(i-244+1)+"</td>";
            else if (i>=274 && i<=304)   octobre += "<td id='"+(i-274+1)+"-10-"+oAnnee+"'>"+(i-274+1)+"</td>";
            else if (i>=305 && i<=334)   novembre += "<td id='"+(i-305+1)+"-11-"+oAnnee+"'>"+(i-305+1)+"</td>";
            else if (i>=335 && i<=365)   decembre += "<td id='"+(i-335+1)+"-12-"+oAnnee+"'>"+(i-335+1)+"</td>";
        } else{
                 if (i>=32 && i<=60)     fevrier += "<td id='"+(i-32+1)+"-02-"+oAnnee+"'>"+(i-32+1)+"</td>";
            else if (i>=61 && i<=91)     mars += "<td id='"+(i-61+1)+"-03-"+oAnnee+"'>"+(i-61+1)+"</td>";
            else if (i>=92 && i<=121)    avril += "<td id='"+(i-92+1)+"-04-"+oAnnee+"'>"+(i-92+1)+"</td>";
            else if (i>=122 && i<=152)   mai += "<td id='"+(i-122+1)+"-05-"+oAnnee+"'>"+(i-122+1)+"</td>";
            else if (i>=153 && i<=182)   juin += "<td id='"+(i-153+1)+"-06-"+oAnnee+"'>"+(i-153+1)+"</td>";
            else if (i>=183 && i<=213)   juillet += "<td id='"+(i-183+1)+"-07-"+oAnnee+"'>"+(i-183+1)+"</td>";
            else if (i>=214 && i<=244)   aout += "<td id='"+(i-214+1)+"-08-"+oAnnee+"'>"+(i-214+1)+"</td>";
            else if (i>=245 && i<=274)   septembre += "<td id='"+(i-245+1)+"-09-"+oAnnee+"'>"+(i-245+1)+"</td>";
            else if (i>=275 && i<=305)   octobre += "<td id='"+(i-275+1)+"-10-"+oAnnee+"'>"+(i-275+1)+"</td>";
            else if (i>=306 && i<=335)   novembre += "<td id='"+(i-306+1)+"-11-"+oAnnee+"'>"+(i-306+1)+"</td>";
            else if (i>=336 && i<=366)   decembre += "<td id='"+(i-336+1)+"-12-"+oAnnee+"'>"+(i-336+1)+"</td>";

        }
       
       
       
        
    }
     var calendarHeader="<tr><th colspan='33' style='text-align:center'> <input type='button' value='<<' id='btn-date-gauche'> CALENDRIER<span> "+oAnnee+"</span> <input type='button' value='>>' id='btn-date-droite'> </th></tr>";
     $(otbodyRow).html(calendarHeader);
     $(otbodyRow).append("<tr><th month-number=1>janvier</th><td>"+janvier+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=2>fevrier</th><td>"+fevrier+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=3>mars</th><td>"+mars+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=4>avril</th><td>"+avril+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=5>mai</th><td>"+mai+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=6>juin</th><td>"+juin+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=7>juillet</th><td>"+juillet+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=8>aout</th><td>"+aout+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=9>septembre</th><td>"+septembre+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=10>octobre</th><td>"+octobre+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=11>novembre</th><td>"+novembre+"</td></tr>");
     $(otbodyRow).append("<tr><th month-number=12>decembre</th><td>"+decembre+"</td></tr>");
     $(otbodyRow +" td").css("background-color","rgba(0, 0, 0, 0)");
     
}

function oNavigationDate(otbodyRow,oListener){
     $(document).on("click",oListener,function(){
         var res=0;
          var dateActive=$(this).parent().find('span' ).html();
          if(oListener=='#btn-date-droite')   res=parseInt(dateActive)+1;
          else   res=parseInt(dateActive)-1;
          $(this).parent().find('span').html(" "+res);
          dateActive=$(this).parent().find('span').html();
         initCalendarStructure('#dynamic-calendar tbody',dateActive);
    });
  
}



function oDeleteZeroFromDayDate(oDate){
    var jour=oDate.split('-')[0];
    var customJour=parseInt(jour);
    var mois=oDate.split('-')[1];
    var annee=oDate.split('-')[2];
    var customDate=customJour+"-"+mois+"-"+annee;
    return customDate;
}


function oNbreJour(indexMois,oAnnee){
    if(indexMois==1||indexMois==3 || indexMois==5|| indexMois==7|| indexMois==8 || indexMois==10 ||indexMois==12) return 31;
    else if(indexMois==2){
        if(isBissextile(oAnnee)) return 29;
        else return 28;
    }
    else return 30;
}

function fillBusySpaces(oDateDebut,oDateFin){
        var selector; 
        var jourDebut=parseInt(oDateDebut.split("-")[0]);
        var jourFin=parseInt(oDateFin.split("-")[0]);
        var moisDebut=oDateDebut.split("-")[1];
        var moisFin=oDateFin.split("-")[1];
        var currentYear=oDateDebut.split("-")[2];
        var nbreMois=parseInt(moisFin)-parseInt(moisDebut);
        var RGB= generateRandomBValue(333,111);
        var indexDebutJour=0;
        var indexFinJour=0;
        var indexMois=moisDebut;
        if(nbreMois!=0){
            for( indexMois=moisDebut;indexMois<=moisFin;indexMois++){
                
                if(indexMois==moisDebut) {
                     indexDebutJour=jourDebut;
                     indexFinJour=oNbreJour(indexMois,currentYear);
                 }
                else if(indexMois==moisFin){
                    indexDebutJour=1;
                    indexFinJour=jourFin;
                    if(indexMois<10)  indexMois="0"+indexMois;
                 } 
                else{
                    indexDebutJour=1;
                    indexFinJour=oNbreJour(indexMois,currentYear);
                    if(indexMois<10)  indexMois="0"+indexMois;
                  } 
                 for(var i=indexDebutJour;i<=indexFinJour;i++){
                        $("#"+i+"-"+indexMois+"-"+currentYear).css("background-color","#"+RGB+"");
                        $("#"+i+"-"+indexMois+"-"+currentYear).prop("title",$("#oCni-personne").val());
                 }
              }
         }else {
             for(var i=jourDebut;i<=jourFin;i++){
                 selector="#"+i+"-"+indexMois+"-"+currentYear;
                $(selector).css("background-color","#"+RGB+"");
                $(selector).attr("title",$("#oCni-personne").val());
            }
         }
         
}



function generateRandomBValue(min,max){
    return min + Math.floor(Math.random() * max);

}

function zLibererChambre(oListener,oScreen){
    $(document).on("dblclick",oListener,function(){
        var oColor=$(this).css('background-color');
        if(oColor!="rgba(0, 0, 0, 0)"){
             $("#liberer-reservation div").html("CNI du client: "+$(this).attr('title'));
             oShowDialog10(oListener,oScreen,oColor);
        }
         
    });
}

function zInfoReservation(oListener,oScreen){
    $(document).on("click",oListener,function(){
        var oColor=$(this).css('background-color');
        if(oColor!="rgba(0, 0, 0, 0)"){
            $("#info-reservation div").html("CNI du client: "+$(this).attr('title'));
            oShowDialog11(oListener,oScreen);
        }
    });
}

function zChevaucherDate(oDateDebut,oDateFin){
        var jourDebut=parseInt(oDateDebut.split("-")[0]);
        var jourFin=parseInt(oDateFin.split("-")[0]);
        var moisDebut=oDateDebut.split("-")[1];
        var moisFin=oDateFin.split("-")[1];
        var currentYear=oDateDebut.split("-")[2];
        var nbreMois=parseInt(moisFin)-parseInt(moisDebut);
        var indexDebutJour=0;
        var indexFinJour=0;
        var indexMois=moisDebut;
         var e,selector;
        if(nbreMois!=0){
            for( indexMois=moisDebut;indexMois<=moisFin;indexMois++){
                
                if(indexMois==moisDebut) {
                     indexDebutJour=jourDebut;
                     indexFinJour=oNbreJour(indexMois,currentYear);
                 }
                else if(indexMois==moisFin){
                    indexDebutJour=1;
                    indexFinJour=jourFin;
                    if(indexMois<10)  indexMois="0"+indexMois;
                 } 
                else{
                    indexDebutJour=1;
                    indexFinJour=oNbreJour(indexMois,currentYear);
                    if(indexMois<10)  indexMois="0"+indexMois;
                  } 
                  
                 for(var i=indexDebutJour;i<=indexFinJour;i++){
                      selector="#"+i+"-"+indexMois+"-"+currentYear;
                      e=$(selector).css("background-color");
                         if(e!="rgba(0, 0, 0, 0)")  return true;
                 }
              }
         }else {
             for(var i=jourDebut;i<=jourFin;i++){
                 var selector="#"+i+"-"+moisDebut+"-"+currentYear;
                 var e=$(selector).css("background-color");
                if(e!="rgba(0, 0, 0, 0)") return true;
             }
         }
        return false;
}



zLibererChambre("#dynamic-calendar tbody td","#liberer-reservation");
//zInfoReservation("#dynamic-calendar tbody td","#info-reservation");


