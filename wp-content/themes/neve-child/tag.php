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

get_header();
?>

<?php $current_tag = single_tag_title("", false); ?>


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

get_header();
?>

<?php $current_tag = single_tag_title("", false); ?>


<section class="subpage-header">
				<div class="container">
					<div class="">
						<h2>Listado de Publicaciones  que contienen la palabra: &nbsp;<?php  echo $current_tag;?></h2>
						
					</div>
					
				</div>
			</section>

<section class="shop">
				<div class="container">
					<div class="row">
						<div class="col-md-9">
							<ul class="shop-list clearfix list-unstyled">
                                                          <?php global $query_string;                
                                                            $args = array( 'tag' => $current_tag, 'posts_per_page' => -1);
                                                            query_posts($args);          
                                                              if (have_posts() ) : ?>
                                                                   <?php while ( have_posts() ) :the_post();
                                                                     $image = get_the_post_thumbnail_url();
                                                                     $categories = get_the_category();
                                                                     $thumbnail_id = get_post_thumbnail_id( $post->ID );
                                                                     $alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
                                                                    ?>
								<li>
									<div class="product animate fadeInUp">
										<div class="product-thumb">
											<a href="<?php the_permalink();?>"><img src="<?php echo $image;?>" alt="<?php echo $alt;?>" title="<?php the_title();?>"></a>
										</div>
										<div class="product-description clearfix">
                                                                                    <h3><strong><a href="<?php the_permalink();?>"><?php the_title();?></a></strong></h3>
                                                                                        <p><?php excerpt(25) ;?>
											
										</div>
									</div>
								</li>
                                                               <?php endwhile;?> 
						      <?php   wp_reset_query();?>
                                                      <?php endif;?>
							</ul>
						</div>
						<div class="col-md-3 animate fadeInRight">
							<aside>
								
								<div class="sidebar-widget">
									<h4>Product Categories</h4>
									<ul class="categories">
										<li><a href="#."><i class="fa fa-angle-right"></i>T-shirt</a></li>
										<li><a href="#."><i class="fa fa-angle-right"></i>Shose</a></li>
										<li><a href="#."><i class="fa fa-angle-right"></i>Winter Cap</a></li>
										<li><a href="#."><i class="fa fa-angle-right"></i>Men Suite</a></li>
										<li><a href="#."><i class="fa fa-angle-right"></i>Women Rings</a></li>
									</ul>
								</div>
								<div class="sidebar-widget">
									<h4>Top Products</h4>
									<div class="top-products clearfix">
										<a href="#."><img src="images/shop/top-products-1.jpg" alt=""></a>
										<div class="top-products-detail">
											<h4><a href="#.">Woo Ninja</a></h4>
											<p>£55.00</p>
											<div class="ratings">
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star-half-o"></i>
											</div>
										</div>
									</div>
									<div class="top-products clearfix">
										<a href="#."><img src="images/shop/top-products-2.jpg" alt=""></a>
										<div class="top-products-detail">
											<h4><a href="#.">Woo Ninja</a></h4>
											<p>£55.00</p>
											<div class="ratings">
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star-half-o"></i>
											</div>
										</div>
									</div>
									<div class="top-products clearfix">
										<a href="#."><img src="images/shop/top-products-3.jpg" alt=""></a>
										<div class="top-products-detail">
											<h4><a href="#.">Woo Ninja</a></h4>
											<p>£55.00</p>
											<div class="ratings">
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star"></i>
												<i class="fa fa-star-half-o"></i>
											</div>
										</div>
									</div>
								</div>
							</aside>
						</div>
					</div>
				</div>
			</section>





  

<?php get_footer(); ?>

