jQuery(document).ready(function ($) {
    //Le code ici
    console.log($(' #menu-navigation li:last '));
    console.log($('#modale_contact'));
    $('#menu-navigation li:last').click(function () {
   //  $('#modale_contact').toggle();
        $('#modale_contact').slideToggle();
    });
});

