<?php
/**
 * 
 * The main template file
 * Template Name: Directorio ATM
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

get_header(); ?>

<section class="subpage-header">
				<div class="container">
                                    <div class="col-md-8">
                                        <div class="site-title clearfix">
						<h2><?php the_title()?></h2>
						
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
<div class="container">
    <div class="row">
                  
                 <div class="col-md-12">
                 
                    <ul class="shop-list clearfix list-unstyled">
                        <?php 
                        //listado de taxonomias
                        $taxonomies = get_terms( 'localidad', array(
                        'parent'     => 0,
                        'hide_empty' => 0,
                          ) );
                        ?>

                        <?php $total =count($taxonomies);
                              $pos = 0;$i=1; $post=0;?>
                                 <?php 
                                   foreach ($taxonomies as $tax):
                                    $link=get_term_link($tax, 'localidad'); ?>
                            <li>
                                <div class="product animate fadeInUp">
                                         <div class="padding">
                                            <p class="button-more">
                                                <a href="<?php echo $link ?>" class="button button-white"><i class="fa fa-long-arrow-right"></i></a>
                                            </p>
                                            <h4><a href="<?php echo $link ?>"><?php echo $tax->name?></a></h4><p><?php echo $tax->description;?></p>
                                        </div>
                                         
                                         



                                </div>
                            </li>
                        <?php endforeach;?>	                               
                        </ul>
                </div>

        </div>
</div>
</section>            
<?php get_footer(); ?>