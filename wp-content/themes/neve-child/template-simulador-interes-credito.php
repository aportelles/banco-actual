<?php
/**
 *
 * Template Name: Simulador Interes de un Crédito
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress/BANMET
 * @subpackage banmet-wp
 * @since 1.0.0
 */

get_header();
?>


<section class="subpage-header">
				<div class="container">
					<div class="site-title clearfix">
						<h2><?php the_title()?></h2>
						
					</div>
					
				</div>
			</section>

<section>
				<div class="container">
					<div class="row">
						<div class="col-md-4 col-sm-4 animate fadeInLeft">
							
							<div class="row">
                                                            <img src=""    alt="">
									<div class="height-20"></div>
								<div class="col-md-6 col-sm-4">
									
								</div>
								<div class="col-md-8 col-sm-8">
									
								</div>
							</div>
							<div class="height-20"></div>
							
                                                         <?php get_template_part( '' ); ?>
							
							<div class="height-50"></div>
						</div>
						<div class="col-md-8 col-sm-4 animate fadeInRight">
                                                       <h3></h3>
						       <?php include('php-credito-interes.php')?>
                                                        
						
							
						</div>
					</div>
				</div>
			</section>

<?php get_footer(); ?>




  







