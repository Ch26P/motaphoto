(function ($) {
    $('#bloc_photos_pag').hover(function () {

        $('.box').hover(function () {
            var hover_id = $(this).attr('id');
            // $hover_id = document.getElementById("format").hover().value;

            console.log(hover_id);

            /****************************************************************************** */
            /*
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
    */
                // Requête Ajax en Jquery
    
                $.ajax({
                    url: ajaxurl,
                    type: 'post',
                    dataType: "html",
                    data: data,
    
                    success: function (response) {
                        //  console.log(response);
                        let box = JSON.parse(response);//recuper l objet json     ?????parse
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
    


}
)(jQuery);