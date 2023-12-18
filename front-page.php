<?php


get_header();

/* Start the Loop */
while (have_posts()) :
	the_post();
?>

	<h1><?php the_title();?></h1>

	<?php
	$query = new WP_Query(
		[

			'post_type' => 'photos', //type de contenue a recuperer
			'posts_per_page' => 1, //nbrs de post dans la page(pagination)
			'orderby' => 'rand', // post organiser de maniere aleatoire


		]
	);


	while ($query->have_posts()) : $query->the_post();//
	?>
		<p>
		<img src="<?php the_post_thumbnail_url('medium');?>">
		</p>

	<?php endwhile;
	wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle
	?>






	<?php
	$query = new WP_Query(
		[

			'post_type' => 'photos', //type de contenue a recuperer
			'posts_per_page' => 8, //nbrs de post dans la page(pagination)
			'orderby' => 'rand', // post organiser de maniere aleatoire


		]
	);


	while ($query->have_posts()) : $query->the_post(); //
	?>
<a  href="<?php echo(get_permalink())?>">
		<?php the_post_thumbnail('medium') ?>
</a>

	<?php endwhile;
	wp_reset_postdata(); // ! important réinisialise les donéé du post apres la boucle
	?>






<?php
endwhile; // End of the loop.

get_footer();
?>