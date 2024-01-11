<?php

get_header(); ?>
<main>
	<div class="container">
		<?php
		if (have_posts())
			while (have_posts()) :
				the_post();
		?>
			<div class="content_photo">
				<div class="content_photo_top">
					<div id="description" class="content_photo_top_description">
						<h1><?php the_title(); ?></h1>
						<ul>
							<?php
							//var_dump(get_the_ID());
							//var_dump(get_fields());	
							$list_champs = get_fields();   ?>
							<?php if (get_fields() !== false) : ?>
								<?php foreach ($list_champs as $name => $value) : ?>
									<?php if ($name === "référence") : ?>
										<li>
											<?php echo $name; ?> : <span><?php echo $value; ?></span>
										</li>
									<?php else : ?>
										<li>
											<?php echo $name; ?> : <?php echo $value; ?>
										</li>
									<?php endif; ?>
								<?php endforeach; ?>
							<?php endif; ?>


							<?php $taxonomy_names = get_post_taxonomies(); ?>
							<?php foreach ($taxonomy_names as $taxonomy_element) : ?>

								<?php if ((get_the_terms(get_the_ID(), $taxonomy_element)) !== false) : //verifie si une taxonomie a une valeur 
								?>

									<li>
										<?php echo $taxonomy_element; ?> : <?php the_terms(get_the_ID(), $taxonomy_element); // affiche la valeur de la taxonomie
																			?>
									</li>

							<?php endif;
							endforeach;  ?>
						</ul>
					</div>
					<div class="content_photo_top_image">
						<?php the_post_thumbnail('large') ?></br>
					</div>
				</div>
				<div class="content_photo_medium">
					<div class="content_photo_medium_left">
						<p>Cette photo vous intéresse?</p>
						<button id="btn-contact">Contact</button>
					</div>
					<div class="content_photo_medium_right">
						<div class="content_photo_medium_right_arrow">
							<?php if (get_previous_post()) : ?>
								<?php
								echo (get_the_post_thumbnail(get_previous_post()->ID, 'thumbnail'));
								echo (previous_post_link( //affiche un lien vers la page précédente 
									$format = ' %link',
									$link = '<img class="arrows" src ="' . get_stylesheet_directory_uri() . ' /assets/images/arrow_left.png ">', //inserer une fleche de pagination
								));
								?>
							<?php endif; ?>

						</div>
						<div class="content_photo_medium_right_arrow  arrow_right">
							<?php
							$Post_suivant = get_next_post();
							//var_dump($Post_suivant);
							?>
							<?php
							if (get_next_post()) : //verifie si le post suivant exist
							?>
							<?php
								echo (get_the_post_thumbnail(get_next_post()->ID, 'thumbnail'));
								echo (next_post_link( //affiche un lien vers la page suivante
									$format = ' %link',
									$link = '<img class="arrows" src ="' . get_stylesheet_directory_uri() . ' /assets/images/arrow_right.png ">', //inserer une fleche de pagination

								));
							endif; ?>
						</div>

					</div>
				</div>
				<div class="content_photo_bottom">

					<p> VOUS AIMEREZ AUSSI </p>
					<div class="content_photo_bottom_partner">
						<?php

						$categorie_article = array_map(function ($term) {    //fait la meme chose 
							return $term->term_id;                      //que foreach
						}, get_the_terms(get_post(), 'categorie'));      //pour recuprer la valeur d une categorie

						$query = new WP_Query(
							[
								'post__not_in' => [get_the_ID()], //ignorer le post en ligne
								'post_type' => 'photos', //type de contenue a recuperer
								'posts_per_page' => 2, //nbrs de post dans la page(pagination)
								'orderby' => 'rand', // post organiser de maniere aleatoire
								'tax_query' => [
									[                //associé les taxonomie avec des tableaux

										'taxonomy' => 'categorie', //
										'terms' => $categorie_article,
										//	var_dump(get_the_terms(get_the_ID(), get_post_taxonomies())),
									]
								]

							]
						);

						/*	 foreach ((get_terms('categorie')) as $terms) : ?>

						<?php endforeach; 
							*/

						while ($query->have_posts()) : $query->the_post(); //

							$terms = get_terms('categorie');
						?>
					<div id="<?php echo (get_the_ID()) ?>" class="box">
						<a href="<?php echo (get_permalink()) ?>" class="Icon Icon_eye">
							<img src="<?php echo get_template_directory_uri() . '/assets/images/Icon_eye.png' ?>" alt="">
						</a>

						<img src="<?php echo get_template_directory_uri() . '/assets/images/Icon_fullscreen.png' ?>" class="Icon Icon_fullscreen" alt="">

						<img src="<?php the_post_thumbnail_url('galerie'); ?>" alt="" class="img_photo">

						<h3 class="info-tittle"><?php the_title(); ?></h3>
						<h3 class="info-taxo"><?php the_terms(get_the_ID(),"categorie") ?></h3>
					</div>
							<?php //var_dump(get_the_terms(get_post() , 'categorie'));


							?>
					</div>



				<?php endwhile;
						wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle
				?>
				</div>
				<div class="content_photo_bottom_button">
					<a href="<?php echo (home_url()); ?>">toute les photos</a>
				</div>
			</div>
	</div>
<?php endwhile; // End of the loop. 
?>


</div>
</main>
<?php
get_footer();
?>