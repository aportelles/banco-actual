<?php
/**
 * 
 * The template for displaying category
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress/Fashion
 * @subpackage Framework
 * @since 1.0.0
 */

$container_class = apply_filters( 'neve_container_class_filter', 'container', 'single-post' );

get_header();

?>

<?php $current_cat = single_cat_title("", false); ?> 
<section class="subpage-header">
				<div class="container">
				<div class="col-md-8">	
                                    <div class="site-title clearfix">
						<h2><?php  echo $current_cat;?></h2>
						
					</div>
					
				</div>
                                  <div class="col-md-4 animate fadeInRight">
					 <div id="search">
                                                   <?php echo get_search_form(); ?>

                                         </div>
                                  </div>   
                                </div>
                               
</section>

<section class="shop">
				<div class="container archive-container">
                                     <div class="listrow">
                                         <?php global $query_string;                
                                                            $args = array( 'category_name' => $current_cat, 'posts_per_page' => -1, 'post_type' => array('portafolio','page','post') );
                                                            query_posts($args);          
                                                              if (have_posts() ) : ?>
                                                                   <?php while ( have_posts() ) :the_post();
                                                                     $image = get_the_post_thumbnail_url();
                                                                     $categories = get_the_category();
                                                                     $thumbnail_id = get_post_thumbnail_id( $post->ID );
                                                                     $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
                                                                    ?>
                                          <div class="listcolumn">
                                             <div class="inner">
                                                 <a href="<?php the_permalink();?>"><img src="<?php echo $image;?>" alt="<?php echo $alt;?>" title="<?php the_title();?>"></a>
                                                  <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                                           </div>

                                         </div>
                                              <?php endwhile;?> 
                                    <?php   wp_reset_query();?>
                                    <?php endif;?>
					
                                    <div class="col-md-3 animate fadeInRight">
                                            <aside>
                                                    <?php if ( is_active_sidebar( 'page_sidebar' ) ) : ?>

                                                       <?php dynamic_sidebar( 'page_sidebar' ); ?>

                                                  <?php endif; ?> 

                                            </aside>
                                    </div>
                            </div>
                    </div>
            </section>
<?php
get_footer();
                   

