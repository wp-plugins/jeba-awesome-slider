<?php
/*
Plugin Name: Jeba Awesome Slider
Plugin URI: http://prowpexpert.com/jeba-awesome-slider
Description: This is Jeba  Awesome wordpress slider plugin really looking awesome sliding. Everyone can use the slider plugin easily like other wordpress plugin. Here everyone can slide image from post, page or other custom post. Also can use slide from every category. By using [jeba_awesome] shortcode use the slider every where post, page and template.
Author: Md Jahed
Version: 1.0
Author URI: http://prowpexpert.com/
*/
function jebas_awosome_wp_latest_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'jebas_awosome_wp_latest_jquery');

function plugin_function_jeba_silder_awosome() {
    wp_enqueue_style( 'jeba-css', plugins_url( '/js/style.css', __FILE__ ));
}

add_action('init','plugin_function_jeba_silder_awosome');
function plugin_function_jeba_silder_awosomes() {
    wp_enqueue_script( 'jeba-slider-js', plugins_url( '/js/jssor.core.js', __FILE__ ), true); 
	wp_enqueue_script( 'jeba-slider-cute-js', plugins_url( '/js/jssor.utils.js', __FILE__ ), true);
    wp_enqueue_script( 'jeba-slider-another-js', plugins_url( '/js/jssor.slider.js', __FILE__ ), true);
   
    wp_enqueue_script( 'jeba-slider-awosome-js', plugins_url( '/js/main.js', __FILE__ ), true);

}

add_action('wp_footer','plugin_function_jeba_silder_awosomes');

function jebas_slider_shortcode_awosome($atts){
	extract( shortcode_atts( array(
		'category' => '',
		'post_type' => 'jeba-slider-items',
		'count' => '-1',
	), $atts) );
	
    $q = new WP_Query(
        array('posts_per_page' => $count, 'post_type' => $post_type, 'slider_category' => $category)
        );		
		
		$plugins_url = plugins_url();
		
	$list = '  <div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 960px;
        height: 480px; background: #191919; overflow: hidden;">

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(' . plugins_url( 'js/loading.gif' , __FILE__ ) . ') no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 240px; top: 0px; width: 720px; height: 480px; overflow: hidden;">';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$jeba_big_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'jeba_big_img' );
		$jeba_img1 = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'jeba_img1' );
		
		$list .= '
		
		
			 <div>
                <img u="image" src="'.$jeba_big_img[0].'" />
                <img u="thumb" src="'.$jeba_img1[0].'" />
            </div>

		
		';        
	endwhile;
	$list.= '</div>
        
     
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora05l" style="width: 40px; height: 40px; top: 158px; left: 248px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora05r" style="width: 40px; height: 40px; top: 158px; right: 8px">
        </span>
        <!-- Arrow Navigator Skin End -->
        
        <!-- Thumbnail Navigator Skin 02 Begin -->
        <div u="thumbnavigator" class="jssort02" style="position: absolute; width: 240px; height: 480px; left:0px; bottom: 0px;">
        
         
            <div u="slides" style="cursor: move;">
                <div u="prototype" class="p" style="position: absolute; width: 99px; height: 66px; top: 0; left: 0;">
                    <div class=w><thumbnailtemplate style=" width: 100%; height: 100%; border: none;position:absolute; top: 0; left: 0;"></thumbnailtemplate></div>
                    <div class=c>
                    </div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div>
    </div>  ';
	wp_reset_query();
	return $list;
}
add_shortcode('jeba_awesome', 'jebas_slider_shortcode_awosome');



add_action( 'init', 'jeba_silder_custom_post_awosome' );
function jeba_silder_custom_post_awosome() {

	register_post_type( 'jeba-slider-items',
		array(
			'labels' => array(
				'name' => __( 'JebaSliders' ),
				'singular_name' => __( 'JebaSlider' )
			),
			'public' => true,
			'supports' => array('title', 'editor', 'thumbnail'),
			'has_archive' => true,
			'rewrite' => array('slug' => 'jeba-slider'),
		)
	);	
	}


function custom_post_taxonomy_awosome() {

	register_taxonomy(
		'slider_category',
		'jeba-slider-items',   
		array(
			'hierarchical'          => true,
			'label'                         => 'Slider Category',  
			'show_admin_column'             => true,
			'rewrite'                       => array(
				'slug'                  => 'slider-category', 
				'with_front'    => true 
				)
			)
	);


}
add_action( 'init', 'custom_post_taxonomy_awosome'); 

add_theme_support( 'post-thumbnails', array( 'post', 'jeba-slider-items' ) );

add_image_size( 'jeba_big_img', 720, 480, true );
add_image_size( 'jeba_img1', 99, 66, true );
?>