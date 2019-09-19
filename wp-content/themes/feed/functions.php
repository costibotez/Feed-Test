<?php
/**
 * Feed functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Feed
 */

if ( ! function_exists( 'feed_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function feed_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on Feed, use a find and replace
		 * to change 'feed' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'feed', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'feed' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'feed_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;
add_action( 'after_setup_theme', 'feed_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function feed_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'feed_content_width', 640 );
}
add_action( 'after_setup_theme', 'feed_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function feed_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'feed' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'feed' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'feed_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function feed_scripts() {
	wp_enqueue_style( 'feed-style', get_stylesheet_uri() );

	wp_enqueue_script( 'feed-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20151215', true );

	wp_enqueue_script( 'feed-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20151215', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'feed_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Register population custom post type
 * @return [type] [description]
 */
function population_custom_post_type() {

	$the_type = 'city';
	$single = 'City';
	$plural = 'Cities';

	$labels = array(
	    'name' => _x($plural, 'post type general name'),
	    'singular_name' => _x($single, 'post type singular name'),
	    'add_new' => _x('Add New', $single),
	    'add_new_item' => __('Add New '. $single),
	    'edit_item' => __('Edit '.$single),
	    'new_item' => __('New '.$single),
	    'view_item' => __('View '.$single),
	    'search_items' => __('Search '.$plural),
	    'not_found' =>  __('No '.$plural.' found'),
	    'not_found_in_trash' => __('No '.$plural.' found in Trash'),
	    'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'supports' => array('title','editor','thumbnail','custom-fields','author', 'comments')
	);

	register_post_type($the_type, $args);
}
add_action('init', 'population_custom_post_type');

// Include City Manager
require_once( get_stylesheet_directory() . '/includes/cities_manager.php' );

add_shortcode('list_cities', 'list_cities_cb');
/**
 * Callback for listing cities
 * @return HTML
 */
function list_cities_cb($atts) {
	$city_args = array(
		'post_type'	 	=> 'city',
		'posts_per_page'=> -1,
		'post_status'	=> array('publish'),
		'order'			=> 'ASC'
	);
	$query = new WP_Query($city_args);

	ob_start();
	if ($query->have_posts()) : ?>
		<div class="cities-container">
		<?php while( $query->have_posts() ) : ?>
			<?php $query->the_post(); ?>
			<div class="city">
				<p><strong><?php the_title(); ?></strong>  Population <?=get_field('population');?></p>
				<div class="photo">
					<img src="" alt="<?php the_title(); ?>"/>
				</div>
			</div>
		<?php endwhile; ?>
		</div>
	<?php endif;

	return ob_get_clean();
}

