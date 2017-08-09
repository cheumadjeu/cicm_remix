/**
 * Created by eric on 25/06/2017.
 */

$(document).ready(function() {

    LireUser();
    $('.formulaire').submit(function() {
        var photo = $('#photo').val();
        var nom = $('.nom').val();
        var cni = $('.cni').val();
        var contact = $('.contact').val();
        var sexe = $('.sexe').val();
        var matr = $('.matr').val();
        var modele = $('.modele').val();
        var marque = $('.marque').val();
        var email = $('.email').val();
        var login = $('.login').val();
        var voiture = modele + " " + matr + " " + marque;
        //alert(login + photo);
        $.post('send.php', { login: login, photo: photo, nom: nom, cni: cni, contact: contact, voiture: voiture, sexe: sexe, email: email }, function(donnees) {
            $('.resultat').html(donnees);
            $('.nom').val("");
            $('.cni').val("");
            $('.contact').val("");
            $('.sexe').val("");
            $('.matr').val("");
            $('.modele').val("");
            $('.marque').val("");
            $('.email').val("");
            LireUser();
        });

        return false;

    });

    function LireUser() {
        $.post('readUser.php', function(data) {
            $('.utilisateurs').html(data);
        });
    }
    //  setInterval(LireUser,1000);




});