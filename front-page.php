<?php
get_header();

/* Start the Loop */
while (have_posts()) :
	the_post();
?>
	<main>
		<section id=hero>

			<div id=title_hero>
				<h1>Photographe event</h1>
			</div>
			<?php
			$query = new WP_Query(
				[
					'post_type' => 'photos', //type de contenue a recuperer
					'posts_per_page' => 1, //nbrs de post dans la page(pagination)
					'orderby' => 'rand', // post organiser de maniere aleatoire

				]
			);
			while ($query->have_posts()) : $query->the_post(); 
			?>

				<img src="<?php the_post_thumbnail_url('hero'); ?>" class="img_hero">


			<?php endwhile;
			wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle
			?>
		</section>

		<section id=bloc_filtres_photos>

			<?php //creation formulaire pour filtrer les photo ?>
			

			<form action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" class="essaie-filtre">
				<input type="hidden" name="nonce" value="<?php echo wp_create_nonce(' filtre_pictures'); ?>">
				<input type="hidden" name="action" value="filtre_pictures">


				<div class="bloc_filtres_select f_taxo">
					<?php foreach (get_object_taxonomies('photos') as $catego) : ?>
						<div class=f_taxo_i>
						<select name=<?php echo ($catego) ?> id="<?php echo ($catego) ?>" class="filtre filtre_<?php echo ($catego) ?>" onfocus="this.size=6;" onblur="this.size=0;" onchange="this.size=6; this.blur()">
							<option value=""><?php echo $catego; ?></option>

							<?php foreach ((get_terms($catego)) as $terms) : ?>

								<option value="<?php echo $terms->name; ?>"><?php echo $terms->name; ?></option>

							<?php endforeach; ?>
						</select>
						</div>
					<?php endforeach; ?>
					<?php  ?>
				</div>
				<div class="bloc_filtres_select f_date">
					<select name=ordre_tri id="tri" class="filtre"  onfocus="this.size=3;" onblur="this.size=0;" onchange="this.size=6; this.blur()">
						<option value="">Trier</option>
						<option value="ASC">Les plus récentes</option>
						<option value="DESC">Les plus anciennes</option>
					</select>
				</div>
			</form>
		</section>
		<section id="bloc_photo">

			<div id="bloc_photos_pag">
				<?php

				$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

				$query = new WP_Query(
					[
						'post_status' => 'publish', //selement les posts publié
						'post_type' => 'photos', //type de contenue a recuperer
						'posts_per_page' => 8, //nbrs de post dans la page(pagination)
						'paged' => $paged,
					]
				);


				while ($query->have_posts()) : $query->the_post(); 

				?>

					<div id="<?php echo (get_the_ID()) ?>" class="box">
						<a href="<?php echo (get_permalink()) ?>" class="Icon Icon_eye">
							<img src="<?php echo get_template_directory_uri() . '/assets/images/Icon_eye.png' ?>" alt="">
						</a>
						<img src="<?php echo get_template_directory_uri() . '/assets/images/Icon_fullscreen.png' ?>" class="Icon Icon_fullscreen" alt="">

						<img src="<?php the_post_thumbnail_url('galerie'); ?>" alt="" class="img_photo">

						<h3 class="info-tittle"><?php the_title(); ?></h3>
						<h3 class="info-taxo"><?php the_terms(get_the_ID(), "categorie") ?></h3>
						<?php //var_dump(get_the_terms(get_the_ID(),"categorie"));
						//echo($tax_term);
						?>
					</div>
				<?php endwhile;
				wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle
				?>
			</div>
			<div id=bloc_button_more_photos>
				<button class="js-load-photos" data-nonce="<?php echo wp_create_nonce('load_more_pictures'); ?>" data-action="load_more_pictures" data-ajaxurl="<?php echo admin_url('admin-ajax.php') ?>">charger plus
				</button>

				<?php wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle
				?>
			</div>
			<div id="id_view_image_body"></div>
			<div id="id_view_image"></div>
		</section>
	</main>
<?php endwhile; // End of the loop.
?>

<?php get_footer();
?>