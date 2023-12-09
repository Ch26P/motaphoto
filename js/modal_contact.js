//Modal Contact
jQuery(document).ready(function ($) {
    //Le code ici
    console.log($(' #menu-navigation li:last '));
    console.log($('#modale_contact'));
    $('nav .lien_contact').click(function () {
   //  $('#modale_contact').toggle();
        $('#modale_contact').slideToggle();
    });


});

//Modal menu mobile

jQuery(document).ready(function ($) {
    //Le code ici
    console.log($(' button.mobile_menu '));
    console.log($('.menu-navigation-container'));
   $('button.mobile_menu').click(function () {
   //  $('#modale_contact').toggle();
        $('.burger_menu').slideToggle();
        $(' button.mobile_menu').toggleClass('toggled')
    });/* */
});
