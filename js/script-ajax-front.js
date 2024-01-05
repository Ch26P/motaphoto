// Gestion de l'affichage des photos supplémentaires en page d'accueil
// en fonction de la valeur des filtres

/**
 * Variables récupérées / renvoyées
 *
 * nonce : jeton de sécurité
 * ajaxurl : adresse URL de la fonction Ajax dans WP
 *

 *
 */


(function ($) {
    $(document).ready(function () {
        $page_number = 1;//initialiser une variable pour la page demander
      
      
     //   console.log($page_number);
        $('.js-load-photos').click(function (e) {
            /************************************************************** */
            $format = document.getElementById("format").value;
            $categorie = document.getElementById("categorie").value;
            console.log($format);
            console.log($categorie);
            
            
            $page_number = $page_number + 1;
       /*    if (document.getElementById('bloc_photos_pag') !== null) {
                $currentPage = document.getElementById('bloc_photos_pag').value;
            };
*/
            $elem_select = $("#bloc_photos_pag").html()
        //  console.log( $elem_select);

            /****************************************************************************** */

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(this).data('ajaxurl');

            // Les données de notre formulaire
            const data = {
                action: $(this).data('action'),
                nonce: $(this).data('nonce'),
                page: $page_number,
              categorie: $categorie,
              format : $format
            }

            // Pour vérifier qu'on a bien récupéré les données
        //    console.log(ajaxurl);
         //   console.log(data);

            // Requête Ajax en Jquery

            $.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: "html",
                data: data,
             
                success: function (response) {

                let r = JSON.parse(response);//recuper l objet json     ?????parse

                    // Vérifie s'il y a encor des posts à charger
                      if( r.data.html.trim() === '') {
                         $(".js-load-photos").hide();// Cacher le formulaire
                      }
                     // $(this).hide(); 
                     // $("#bloc_photos_pag").html($elem_select + response); // Et afficher le HTML
                      $("#bloc_photos_pag").append(r.data.html);
                },
            });



        });

    });


})(jQuery);
