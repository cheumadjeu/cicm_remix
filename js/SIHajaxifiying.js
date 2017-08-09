function ajaxing_native(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#corps").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function ajaxing_native_prim(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#corpsSalles").html(data);
            
            //$("table#chambres   tbody tr th").parent().find("input[value="+$("#oBuffer").val()+"]").prop("checked","true");
        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function ajaxing_filter_commande(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#commande-filtrer").html(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function ajaxing_commands(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $("#trichZone").val(data.split("#@#")[0]);
            $("#trichZoneForCode").val(data.split("#@#")[1]);
            $("#field-quantity").val("1");
            $("#field-uniq-price").val(data.split("#@#")[0]);

        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function filtre_statut(oListener, oSearchZone) {
    $(document).on('click', oListener, function() {
        var params = "";
        var search_zone = $(oSearchZone).val();
        params = "jeton=filtrerChambre&search_zone=" + search_zone;
        ajaxing_native(params, "POST", "locaux.php", "warningsSuccess", "warningFailure");
    });

}

function ajaxing_save_commande(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            //alert(data);
            //viderCommande_brief();

        },
        error: function() {
            alert(warningFailure);
        }
    });
}


function ajaxing_customers(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
            $(".utilisateurs").html(data) ;
            
        },
        error: function() {
            alert(warningFailure);
        }
    });
}

function ajaxing_save_customers(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
           $(".utilisateurs").html(data) ;
        },
        error: function() {
            alert(warningFailure);
        }
    });
}



function ajaxing_page(params, method, servlet, warningsSuccess, warningFailure) {
    var param = params;
    $.ajax({
        type: method,
        url: servlet,
        data: param,
        dataType: 'html',
        success: function(data, result, jqXHR) {
         
            alert(data);
        },
        error: function() {
            alert(warningFailure);
        }
    });
}
   