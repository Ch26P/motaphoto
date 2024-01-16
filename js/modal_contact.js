// ouverture Modal Contact au menu
jQuery(document).ready(function ($) {

    var referenceValue = jQuery("#description ul li:first span").html();

    console.log($("#ref"));
    console.log($(' #menu-navigation li:last '));
    console.log($('.modale_contact'));
    $('nav .lien_contact').click(function () {
        $('.modale_contact').slideToggle();

        $('#ref').val(referenceValue);

    });

    console.log("bonjour" + referenceValue);
    console.log($("#ref"));
    console.log($(' #menu-navigation li:last '));
    console.log($('.modale_contact'));
    var referenceValue = jQuery("#description ul li:first span").html();//récuper la valeur pour la reference
    $('.content_photo_medium_left button').click(function () {
        $('.modale_contact').slideToggle();

        $('#ref').val(referenceValue);//ajout valeur pour ref du formulaire contact
    });

    //fermeture modal contact

    console.log($('.modale_contact_bloc'));
    $(".modale_contact_fond").click(function () {
        $('.modale_contact').slideToggle();
    });

    //Modal menu mobile

    console.log($(' button.mobile_menu '));
    console.log($('.menu-navigation-container'));
    $('button.mobile_menu').click(function () {
        //  $('#modale_contact').toggle();
        $('.burger_menu').slideToggle();
        $(' button.mobile_menu').toggleClass('toggled');
       if ( $(".site_header").hasClass("full")==true) {
        $(".site_header").removeClass("full");
      } else {
       $(".site_header").addClass("full")
    }
    });
});

