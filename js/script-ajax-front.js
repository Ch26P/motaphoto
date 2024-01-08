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
            $order = document.getElementById("tri").value;
            $page_number = $page_number + 1;
            /*    if (document.getElementById('bloc_photos_pag') !== null) {
                   $currentPage = document.getElementById('bloc_photos_pag').value;
               };
               */
            $elem_select = $("#bloc_photos_pag").html()


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
                format: $format,
                order: $order
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
                    if (r.data.html.trim() === '') {
                        $(".js-load-photos").hide();// Cacher le formulaire
                    }
                    $("#bloc_photos_pag").append(r.data.html);// Et afficher le HTML a la suite
                },
            });



        });
    });


})(jQuery);
/*****************************************************************************************************************/
// script filtres
(function ($) {
    $(document).ready(function () {

        $('.filtre').change(function (e) {

            $format = document.getElementById("format").value;
            $categorie = document.getElementById("categorie").value;
            $order = document.getElementById("tri").value;

            $page_number = 1;
            /*    if (document.getElementById('bloc_photos_pag') !== null) {
               $currentPage = document.getElementById('bloc_photos_pag').value;
           };*/

            $elem_select = $("#bloc_photos_pag").html()
            console.log($elem_select);

            /****************************************************************************** */

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(".essaie-filtre").attr('action');

            // Les données de notre formulaire
            const data = {
                action: $(".essaie-filtre").find('input[name=action]').val(),
                nonce: $(".essaie-filtre").find('input[name=nonce]').val(),
                page: $page_number,
                categorie: $categorie,
                format: $format,
                order: $order
            }

            // Pour vérifier qu'on a bien récupéré les données
            //   console.log(ajaxurl);
            //   console.log(data);

            // Requête Ajax en Jquery

            $.ajax({
                url: ajaxurl,
                type: 'post',
                dataType: "html",
                data: data,

                success: function (response) {
                    //  console.log(response);
                    let rf = JSON.parse(response);//recuper l objet json     ?????parse
                    $("#bloc_photos_pag").html(rf.data.html);// Remplacer le HTML
                    if (rf.data.html.trim() === '') {
                        $(".js-load-photos").hide();// Cacher le formulaire
                    } else {
                        $(".js-load-photos").show();// reactiver le bouton si il est desactivé
                    }

                },
            });



        });



    });


})(jQuery);
