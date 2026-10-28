<?php
/**
 * 
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Framework
 * @since 1.0.0
 */
$container_class = apply_filters( 'neve_container_class_filter', 'container', 'single-directorio' );

get_header();

$context = class_exists( 'WooCommerce', false ) && ( is_cart() || is_checkout() || is_account_page() ) ? 'woo-page' : 'single-page';
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

<div class="<?php echo esc_attr( $container_class ); ?> single-page-container">
	<div class="row">
		<?php do_action( 'neve_do_sidebar', $context, 'left' ); ?>
		<div class="nv-single-page-wrap col">
							
                                                          <?php
                                                        $cat_id = get_cat_ID ( $current_cat  );  
                                                        $term_custom = get_term_by('name', $current_cat, 'localidad');
                                                        $term_id = $term_custom->term_id;
                                                        $taxonomy_name = 'localidad';
                                                        $slug=$current_cat;
                                                        $args = array( 'post_type'=>'directorio',
                                                                   'post_per_page'=>-1,
                                                                   'cat'=>-$cat_id,
                                                                   'orderby'   => 'meta_value',
                                                                   'order' => 'ASC',
                                                                   'tax_query' => array(
                                                                    array(
                                                                      'taxonomy' => 'localidad',
                                                                      'field' => 'slug',
                                                                      'terms' => $slug,
                                                                    )
                                                                  ) );
                                                    $loop = new WP_Query( $args );
                                                    while ( $loop->have_posts() ) : $loop->the_post(); ?>
                                                         
							
									<div>
										 <div class="separator"></div>
                                                                                 <a href="<?php the_permalink();?>"><img src="" alt=" " title="<?php the_title();?>"></a>
										        <h4><?php the_category();?></h4>
                                                                                        <h3><?php the_title();?></h3>
                                                                                    <?php the_content();?> 
											
										
									</div>
                 
                                                               <?php endwhile;?> 
						      <?php   wp_reset_query();?>
                                                     
							
		</div>
                                <div class="sblocalidad">
                                                       <h4>Municipios</h4>  
                                                       <ul class="left-nav">
                                                                <?php 
                                                                //listado de taxonomias
                                                                $taxonomies = get_terms( 'localidad', array(
                                                                'parent'     => 0,
                                                                'hide_empty' => 1,
                                                                  ) );
                                                                ?>

                                                                <?php $total =count($taxonomies);
                                                                      $pos = 0;$i=1; $post=0;?>
                                                                         <?php 
                                                                           foreach ($taxonomies as $tax):
                                                                            $link=get_term_link($tax, 'localidad'); ?>
                                                                    <li>
                                                                        <a href="<?php echo $link ?>"><?php echo $tax->name?><i class="fa fa-angle-right"></i></a>

                                                                    </li>
                                                                <?php endforeach;?>	                               
                                                                </ul>

                                                    </div>
             
		<?php do_action( 'neve_do_sidebar', $context, 'right' ); ?>
            
             
	</div>
  
      
   
				
</div>			
             

<?php get_footer(); 
