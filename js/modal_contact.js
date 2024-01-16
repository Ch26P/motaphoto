// ouverture Modal Contact au menu
jQuery(document).ready(function ($) {

    var referenceValue = jQuery("#description ul li:first span").html();

    //  console.log($(referenceValue));
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


/************************************************************************************************************ */
    //fermeture modal contact
    //A Finir controler la fermeture 

    //   console.log($(' .modale_contact_bloc '));
    console.log($('.modale_contact_bloc'));//
    $(".modale_contact_fond").click(function () {
        $('.modale_contact').slideToggle();
    });
/*********************************************************************************************************** */
    //Modal menu mobile


    //Le code ici
    console.log($(' button.mobile_menu '));
    console.log($('.menu-navigation-container'));
    $('button.mobile_menu').click(function () {
        //  $('#modale_contact').toggle();
        $('.burger_menu').slideToggle();
        $(' button.mobile_menu').toggleClass('toggled')
       // $('nav').toggleclass('toggled')
       if ( $(".site_header").hasClass("full")==true) {
        $(".site_header").removeClass("full");
       // a = 0;
      } else {
       $(".site_header").addClass("full")
    }
    });
});

/*



(function ($) {
    $(document).ready(function () {
        $('.js-load-photos').click(function (e) {

            const ajaxurl = $(this).data('ajaxurl');

            const data = {
                action: $(this).data('action'),
                nonce: $(this).data('nonce'),

                post_type: $(this).data('type'),
                //  postid: $(this).data('postid'),//
            }
            //  console.log( post_type);
            console.log(ajaxurl);
            console.log(data);
            console.log($_POST);
        });

    })

})(jQuery);
*/