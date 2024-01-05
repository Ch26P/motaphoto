<?php
get_header();

/* Start the Loop */
while (have_posts()) :
	the_post();
?>
	<div>
		<h1><?php the_title(); ?></h1>

		<?php
		$custom_logo_id = get_theme_mod('custom_logo');
		$custom_logo_url = wp_get_attachment_image_url($custom_logo_id, 'complet'); ?>
		<a href="<?php echo (home_url()); ?>"><?php echo '<img src="' . esc_url($custom_logo_url) . '" alt="logo" class="img_logo">'; ?></a>

		<?php
		$query = new WP_Query(
			[
				'post_type' => 'photos', //type de contenue a recuperer
				'posts_per_page' => 1, //nbrs de post dans la page(pagination)
				'orderby' => 'rand', // post organiser de maniere aleatoire

			]
		);
		while ($query->have_posts()) : $query->the_post(); //
		?>
			<p>
				<img src="<?php the_post_thumbnail_url('medium'); ?>">
			</p>

		<?php endwhile;
		wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle
		?>
	</div>
	<!------------------------------------------------------------------------------------>
	<div>
		<!-----filtres----->


		<?php //var_dump(get_object_taxonomies('photos')); 

		// var_dump(get_terms('categorie')); 
		?>
		<?php foreach (get_object_taxonomies('photos') as $catego) : ?>
			<select name=<?php echo ($catego) ?> id="<?php echo ($catego) ?>" class="filtre">
				<option value=""><?php echo $catego; ?></option>

				<?php foreach ((get_terms($catego)) as $terms) : ?>

					<option value="<?php echo $terms->name; ?>"><?php echo $terms->name; ?></option>

				<?php endforeach; ?>
			</select>
		<?php endforeach; ?>
		<?php // endif; 
		?>


	</div>
	<!-------------------------------------------------------------------------------------------------------------->
	<div id="bloc_photos_pag">
		<?php

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

		$query = new WP_Query(
			[
				'post_status' => 'publish', //selement les posts publié
				'post_type' => 'photos', //type de contenue a recuperer
				'posts_per_page' => 8, //nbrs de post dans la page(pagination)
				'paged' => $paged,



				//	'orderby' => 'rand', // posts organiser de maniere aleatoire
				//	'nopaging'=>'true',
			]
		);


		while ($query->have_posts()) : $query->the_post(); //
		?>
			<article id="<?php echo (get_the_ID()) ?>" class="">
				<a href="<?php echo (get_permalink()) ?>">
					<?php the_post_thumbnail('medium') ?>
				</a>
			</article>
		<?php endwhile;

		//	 var_dump($ids);
		wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle

		?>
	</div>
	<div>
		<button class="js-load-photos" data-nonce="<?php echo wp_create_nonce('load_more_pictures'); ?>" data-action="load_more_pictures" data-ajaxurl="<?php echo admin_url('admin-ajax.php') ?>">charger plus
		</button>
		<?php
		//	 var_dump($query);	
		// var_dump($query->post("id"));

		/*	var_dump($paged);
		 var_dump($query->max_num_pages);
		  var_dump($query->queried_object_id);
		  */ ?>
		<?php wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle
		?>
	</div>
<?php endwhile; // End of the loop.
?>

<?php get_footer();
?>