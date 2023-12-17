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
						<h1><?php the_title() ?></h1>
						<ul>
							<?php
							//var_dump(get_the_ID());
							//var_dump(get_fields());	
							$list_champs = get_fields()   ?>
							<?php if (get_fields() !== false) : ?>
								<?php foreach ($list_champs as $name => $value) : ?>
									<li>
										<?php echo $name; ?> : <span><?php echo $value; ?></span>
									</li>

								<?php endforeach; ?>
							<?php endif; ?>
							<?php $taxonomy_names = get_post_taxonomies();?>
							<?php foreach ($taxonomy_names as $taxonomy_element) : ?>

								<?php if ((get_the_terms(get_the_ID(), $taxonomy_element)) !== false) : //verifie si une taxonomie a une valeur 
								?>

									<li>
										<span>
											<?php echo $taxonomy_element; ?> : <?php the_terms(get_the_ID(), $taxonomy_element); // affiche la valeur de la taxonomie
																				?>

										</span>
									</li>

							<?php endif;
							endforeach;  ?>
						</ul>
					</div>
					<div class="content_photo_top_image">
						<?php the_post_thumbnail() ?></br>
					</div>
				</div>
				<div class="content_photo_bottom">
					<div class="content_photo_bottom_left">
						<p>Cette photo vous intéresse?</p>
						<button>Contact</button>
					</div>
					<div class="content_photo_bottom_right">
						<div class="content_photo_bottom_right_arrow">
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
						<div class="content_photo_bottom_right_arrow  arrow_right">
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
			</div>
		<?php
			endwhile; // End of the loop. 
		?>
		</div>
</main>
<?php
get_footer();
?>