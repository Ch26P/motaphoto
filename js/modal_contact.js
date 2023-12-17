//Modal Contact
jQuery(document).ready(function ($) {
  //  console.log($(referenceValue));
    console.log( $("#ref"));
    console.log($(' #menu-navigation li:last '));
    console.log($('.modale_contact'));
    $('nav .lien_contact').click(function () {
        $('.modale_contact').slideToggle();

    });
});
//**ajout valeur ref formulaire contact */

  jQuery(document).ready(function($){
    var referenceValue = $( "#description ul li:first span" ).html();
  //  console.log(referenceValue);
    $("#ref").val(referenceValue);
  });

//fermeture modal contact
jQuery(document).ready(function ($) {       //A Finir
                                             //controler la fermeture 
 
    //   console.log($(' .modale_contact_bloc '));
    console.log($('.modale_contact_bloc'));//
    $('.modale_contact_bloc').click(function () {
        $('.modale_contact').slideToggle();
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
    });
});
