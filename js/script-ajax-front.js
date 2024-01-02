


(function ($) {
    $(document).ready(function () {
        $('.js-load-photos').click(function (e) {

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
             const ajaxurl = $(this).data('ajaxurl');

             // Les données de notre formulaire
            const data = {
                action: $(this).data('action'),
                nonce: $(this).data('nonce'),
            }



                        // Pour vérifier qu'on a bien récupéré les données
                        console.log(ajaxurl);
                        console.log(data);
            


                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data:data,
                            success: function (response) {
                   console.log(response);
                               // Vérifie s'il y a plus de posts à charger
                             /*  if (response.trim() === '') {
                                  $('#load-more-button').hide();
                               }*/
                            },
                         });


                        // Requête Ajax en JS natif via Fetch
         /*   fetch(ajaxurl, {
                method: 'POST',
                headers: {
                    // 'X-Requested-With': 'XMLHttpRequest',
                   'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache',//
                },
                body : new URLSearchParams(data),
            })
                .then(response => {
                     console.log(response);
                    response.json();
                   
                })

                .then(body => {
                    console.log('essai :' + body);

                    // En cas d'erreur
                    if (!body.success) {
                          console.log('erreur ');
                     //   alert(response.data);
                     //   return;
                    }

                    // Et en cas de réussite
               //     $(this).hide(); // Cacher le formulaire
             //       $('.comments').html(body.data); // Et afficher le HTML
                    console.log('ok ');
                })*/
            console.log("2"+ajaxurl);
            console.log( data);
        });

    });


})(jQuery);
