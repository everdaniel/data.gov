<?php
$args = array( 
                'post_type' => 'post',
                'ignore_sticky_posts' => 1,  
                'tax_query' => array(
    		                        'relation' => 'AND',                    
                	                array(
                	                'taxonomy' => 'post_format',
                	                'field' => 'slug',
                	                'terms' => array( 'post-format-link', 'post-format-status', 'post-format-gallery'),
                	                'operator' => 'NOT IN'
                	                ), 
                	                array(
                	                'taxonomy' => 'featured',
                	                'field' => 'slug',
                	                'terms' => array( 'highlights'),
                	                'operator' => 'IN'
                	                )                	                
                                ),                 
                'posts_per_page' => 1 );
                
if (is_category()) $args['cat'] = get_query_var('cat');
         
$highlight_posts = new WP_Query($args);

if (($highlight_posts->have_posts())):
?>

<section id="highlights" class="wrap wrap-lightblue">
<div class="container">

    <div class="page-header">
      <h1>Highlights</h1>
    </div>


<?php while ($highlight_posts->have_posts()) : $highlight_posts->the_post(); ?>
    <div class="highlight <?php get_category_by_slug( $slug ) ?>">
        <header>
            <?php if(!is_category() && !is_archive()): ?>
                <h5 class="category"><?php $category = get_the_category(); echo $category[0]->cat_name; ?></h5>
            <?php endif; ?>
            
            <h2 class="entry-title"><?php the_title(); ?></h2>
        </header>
        
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="featured-image col-md-4">
                <?php the_post_thumbnail('medium'); ?>
            </div>
        <?php endif; ?>

        <article class="<?php if ( has_post_thumbnail() ) : ?>col-md-8<?php else: ?>no-image<?php endif;?>">
		    <?php the_content(); ?>
		</article>
		
		<?php if(get_post_format() == 'image'): ?>		
            <div class="dataset-link">
                <a class="btn btn-default pull-right" href="<?php the_field('link_to_dataset'); ?>">
                  <span class="glyphicon glyphicon-download"></span> View this Dataset
                </a>
            </div>            
        <?php endif;?>   

    </div><!--/.highlight-->
<?php endwhile; ?>

</div><!--/.container-->
</section><!--/.wrap-lightblue-->

<?php
endif;
wp_reset_postdata();    
?>

