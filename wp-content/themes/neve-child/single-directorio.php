<?php
/**
 * The template for displaying all  Bank Offices and ATM.
 *
 * @package Neve Child
 * @since   1.0.0
 */
$container_class = apply_filters( 'neve_container_class_filter', 'container', 'single-directorio' );

get_header();

$context = class_exists( 'WooCommerce', false ) && ( is_cart() || is_checkout() || is_account_page() ) ? 'woo-page' : 'single-page';
?>
<section class="subpage-header">
				<div class="container">
					<div class="site-title clearfix">
						<h2><?php the_title()?></h2>
						
					</div>
					
				</div>
</section>
<div class="<?php echo esc_attr( $container_class ); ?> single-page-container">
	<div class="row">
		<?php do_action( 'neve_do_sidebar', $context, 'left' ); ?>
		<div class="nv-single-page-wrap col">
                    
			<?php
			/**
			 * Executes actions before the page header.
			 *
			 * @since 2.4.0
			 */
			do_action( 'neve_before_page_header' );

			/**
			 * Executes the rendering function for the page header.
			 *
			 * @param string $context The displaying location context.
			 *
			 * @since 1.0.7
			 */
			do_action( 'neve_page_header', $context );

			/**
			 * Executes actions before the page content.
			 *
			 * @param string $context The displaying location context.
			 *
			 * @since 1.0.7
			 */
			do_action( 'neve_before_content', $context );
                       
                                              while ( have_posts() ) :
                                               the_post();
                                               $categories = get_the_category();?>
                                          <p><strong>Categoría:</strong> 
                                                    
                                                      
                                                       <?php $last = end($categories);
                                                           foreach( $categories as $category ):
                                                               if ($last != $category): ?>
                                                            <?php echo $category->name;?> ,&nbsp;
                                                              <?php else: ?>
                                                             <?php echo $category->name;?> 
                                                              <?php endif; ?>
                                                           <?php endforeach;?>
                                                        </p>
							<br>
							
							
                                                        

						
                                            <?php endwhile;
                                                  wp_reset_query();

			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content', 'page' );
				}
			} else {
				get_template_part( 'template-parts/content', 'none' );
			}

			/**
			 * Executes actions after the page content.
			 *
			 * @param string $context The displaying location context.
			 *
			 * @since 1.0.7
			 */
			do_action( 'neve_after_content', $context );
			?>
		</div>
            <div class="sblocalidad">
               <h5>Municipios</h5>  
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
<?php get_footer(); ?>










