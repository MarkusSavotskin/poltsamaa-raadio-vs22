<?php

if (!defined('ABSPATH')) {
	exit;
}

// CONFIG

include('includes/configure.php');

// ACF

if (class_exists('ACF')) :
	require_once 'includes/acf/acf-gutenberg-blocks.php';
	require_once 'includes/acf/acf-controller.php';
endif;

// CLASSES

require_once('includes/classes/class-pr-post-types-controller.php');
require_once('includes/classes/class-pr-admin-controller.php');

// THEME SETUP

class ThemeSetup
{

	// ThemeSetup constructor.

	public function __construct()
	{
		$this->remove_actions();
		$this->remove_filters();
		$this->add_actions();
		$this->add_filters();
		$this->register_post_types();

		new PR_Admin_Controller();
		new PR_Post_Types_Controller();

		if (class_exists('ACF')) :
			new Acf_Controller();
			new Acf_Gutenberg_Blocks();
		endif;
	}

	// Add WordPress actions.

	private function add_actions()
	{
		add_filter('wp_nav_menu_objects', [$this, 'megamenu_menu_item_classes'], 10, 2);
		add_action('widgets_init', [$this, 'theme_widgets_sidebar_register']);
		add_action('after_setup_theme', [$this, 'theme_setup']);
		add_action('wp_enqueue_scripts', [$this, 'ws_theme_enqueue_scripts_and_styles']);
		add_action('admin_enqueue_scripts', [$this, 'ws_admin_enqueue_scripts_and_styles']);
		add_action('template_redirect', [$this, 'empty_employees_redirect_to_archive']);
		add_filter('body_class', [$this, 'add_background_image_to_body']);

		// 'saade' post type columns
		add_filter('manage_saade_posts_columns', [$this, 'pr_show_posts_columns']);
		add_action('manage_saade_posts_custom_column', [$this, 'pr_show_posts_columns_content'], 10, 2);
		add_filter('manage_edit-saade_sortable_columns', [$this, 'pr_sortable_show_posts_columns']);
		// 'osa' post type columns
		add_filter('manage_osa_posts_columns', [$this, 'pr_episode_posts_columns']);
		add_action('manage_osa_posts_custom_column', [$this, 'pr_episode_posts_columns_content'], 10, 2);
		add_filter('manage_edit-osa_sortable_columns', [$this, 'pr_sortable_episode_posts_columns']);
		// 'saatekava' post type columns
		add_filter('manage_saatekava_posts_columns', [$this, 'pr_schedule_posts_columns']);
		add_action('manage_saatekava_posts_custom_column', [$this, 'pr_schedule_posts_columns_content'], 10, 2);
		add_filter('manage_edit-saatekava_sortable_columns', [$this, 'pr_sortable_schedule_posts_columns']);
		// 'toetaja' post type columns
		add_filter('manage_toetaja_posts_columns', [$this, 'pr_supporter_posts_columns']);
		add_action('manage_toetaja_posts_custom_column', [$this, 'pr_supporter_posts_columns_content'], 10, 2);
		add_filter('manage_edit-toetaja_sortable_columns', [$this, 'pr_sortable_supporter_posts_columns']);
		// 'toimetuse-liige' post type columns
		add_filter('manage_toimetuse-liige_posts_columns', [$this, 'pr_member_posts_columns']);
		add_action('manage_toimetuse-liige_posts_custom_column', [$this, 'pr_member_posts_columns_content'], 10, 2);
		add_filter('manage_edit-toimetuse-liige_sortable_columns', [$this, 'pr_sortable_member_posts_columns']);
	}

	// CPT 'saade' columns
	function pr_show_posts_columns($columns)
	{
		$columns = array(
			'cb' => $columns['cb'],
			'image' => __('Pilt', 'raadio'),
			'title' => __('Pealkiri', 'raadio'),
			'episode_count' => __('Osade arv', 'raadio'),
			'category' => __('Kategooria', 'raadio'),
		);

		return $columns;
	}

	function pr_show_posts_columns_content($column, $post_id)
	{
		switch ($column) {
			case 'image':
				if (has_post_thumbnail($post_id)) {
					echo '<img width="150px" height="100%" src="' . esc_url(get_the_post_thumbnail_url($post_id)) . '">';
				} else {
					echo '-';
				}
				break;

			case 'episode_count':
				$args = array(
					'post_type' => 'osa',
					'meta_query' => array(
						array(
							'key' => 'episode_parent',
							'value' => '"' . $post_id . '"',
							'compare' => 'LIKE',
						),
					),
					'posts_per_page' => -1,
				);
				$episode_query = new WP_Query($args);

				$episode_count = $episode_query->post_count;
				echo $episode_count;
				break;

			case 'category':
				$terms = get_the_terms($post_id, 'kategooria');

				if ($terms && !is_wp_error($terms)) {
					$term_names = array();

					foreach ($terms as $term) {
						$term_names[] = $term->name;
					}

					echo implode(', ', $term_names);
				} else {
					echo '-';
				}
				break;
		}
	}

	function pr_sortable_show_posts_columns($columns)
	{
		$columns['show'] = __('Saade', 'raadio');
		$columns['season'] = __('Hooaeg', 'raadio');
		$columns['air_date'] = __('Eetrikuupäev', 'raadio');
		return $columns;
	}

	// CPT 'osa' columns
	function pr_episode_posts_columns($columns)
	{
		$columns = array(
			'cb' => $columns['cb'],
			'image' => __('Pilt', 'raadio'),
			'title' => __('Pealkiri', 'raadio'),
			'show' => __('Saade', 'raadio'),
			'season' => __('Hooaeg', 'raadio'),
			'source' => __('Allikas', 'raadio'),
			'air_date' => __('Eetrikuupäev', 'raadio'),
		);

		return $columns;
	}

	function pr_episode_posts_columns_content($column, $post_id)
	{
		switch ($column) {
			case 'image':
				if (has_post_thumbnail($post_id)) {
					echo '<img width="150px" height="100%" src="' . esc_url(get_the_post_thumbnail_url($post_id)) . '">';
				} else {
					echo '-';
				}
				break;

			case 'show':
				$parent_id = get_field('episode_parent', $post_id);
				if ($parent_id) {
					echo get_the_title($parent_id[0]);
				} else {
					echo '-';
				}
				break;

			case 'season':
				$terms = get_the_terms($post_id, 'hooaeg');

				if ($terms && !is_wp_error($terms)) {
					$term_names = array();

					foreach ($terms as $term) {
						$term_names[] = $term->name;
					}

					echo implode(', ', $term_names);
				} else {
					echo '-';
				}
				break;

			case 'source':
				$source = get_field('episode_link', $post_id);
				if ($source) {
					echo $source;
				} else {
					echo '-';
				}
				break;

			case 'air_date':
				$air_date = get_field('episode_air_date', $post_id);
				if ($air_date) {
					echo date($air_date);
				} else {
					echo '-';
				}
				break;
		}
	}
	
	function pr_sortable_episode_posts_columns($columns)
	{
		$columns['show'] = __('Saade', 'raadio');
		$columns['season'] = __('Hooaeg', 'raadio');
		$columns['air_date'] = __('Eetrikuupäev', 'raadio');
		return $columns;
	}

	// CPT 'saatekava' columns
	function pr_schedule_posts_columns($columns)
	{
		$columns = array(
			'cb' => $columns['cb'],
			'title' => __('Pealkiri', 'raadio'),
			'schedule_date' => __('Kuupäev', 'raadio'),
		);

		return $columns;
	}

	function pr_schedule_posts_columns_content($column, $post_id)
	{
		switch ($column) {
			
			case 'schedule_date':
				$date = get_field('schedule_date', $post_id);
				if ($date) {
					echo date($date);
				} else {
					echo '-';
				}
				break;
		}
	}

	function pr_sortable_schedule_posts_columns($columns)
	{
		$columns['schedule_date'] = __('Kuupäev', 'raadio');
		return $columns;
	}

	// CPT 'toetaja' columns
	function pr_supporter_posts_columns($columns)
	{
		$columns = array(
			'cb' => $columns['cb'],
			'image' => __('Pilt', 'raadio'),
			'title' => __('Pealkiri', 'raadio'),
			'supporter_type' => __('Toetaja tüüp', 'raadio'),
			'supporter_company_link' => __('Link', 'raadio'),
		);

		return $columns;
	}

	function pr_supporter_posts_columns_content($column, $post_id)
	{
		switch ($column) {
			case 'image':
				$logo = get_field('supporter_company_logo', $post_id);
				if ($logo) {
					echo '<img width="150px" height="100%" src="' . esc_url($logo) . '">';
				} else {
					echo '-';
				}
				break;

			case 'supporter_type':
				$supporter_type = get_field('supporter_type', $post_id);
				if ($supporter_type) {
					echo __('Ettevõte', 'raadio');
				} else {
					echo __('Eraisik', 'raadio');
				}
				break;

			case 'supporter_company_link':
				$supporter_company_link = get_field('supporter_company_link', $post_id);
				if ($supporter_company_link) {
					echo esc_url($supporter_company_link);
				} else {
					echo ('-');
				}
				break;
		}
	}

	function pr_sortable_supporter_posts_columns($columns)
	{
		$columns['supporter_type'] = __('Toetaja tüüp', 'raadio');
		return $columns;
	}
	// CPT 'toimetuse-liige' columns
	function pr_member_posts_columns($columns)
	{
		$columns = array(
			'cb' => $columns['cb'],
			'image' => __('Pilt', 'raadio'),
			'title' => __('Pealkiri', 'raadio'),
			'member_role' => __('Liikme roll', 'raadio'),
			'member_type' => __('Liikme tüüp', 'raadio'),
		);

		return $columns;
	}

	function pr_member_posts_columns_content($column, $post_id)
	{
		switch ($column) {
			case 'image':
				if (has_post_thumbnail($post_id)) {
					echo '<img width="150px" height="100%" src="' . esc_url(get_the_post_thumbnail_url($post_id)) . '">';
				} else {
					echo '-';
				}
				break;

			case 'member_type':
				$member_type = get_field('member_type', $post_id);
				if ($member_type) {
					echo __('Juhatus', 'raadio');
				} else {
					echo __('Saatejuht', 'raadio');
				}
				break;

			case 'member_role':
				$member_role = get_field('member_role', $post_id);
				if ($member_role) {
					echo $member_role;
				} else {
					echo ('-');
				}
				break;
		}
	}

	function pr_sortable_member_posts_columns($columns)
	{
		$columns['member_type'] = __('Liikme tüüp', 'raadio');
		return $columns;
	}

	function add_background_image_to_body($classes) {
    $classes[] = 'page--background';
    return $classes;
}

	// Remove WordPress existing filters.

	private function remove_filters()
	{
	}

	// Remove WordPress existing actions.

	private function remove_actions()
	{
	}

	// Add WordPress custom filters.

	private function add_filters()
	{
		add_filter('wpseo_breadcrumb_separator', [$this, 'filter_wpseo_breadcrumb_separator'], 10, 1);
		add_filter('wpcf7_autop_or_not', '__return_false');
	}

	// Register custom post types.

	private function register_post_types()
	{
	}

	// Register a WordPress sidebar.

	public function theme_widgets_sidebar_register()
	{
		register_sidebar(
			[
				'name'          => __('Sidebar one'),
				'id'            => 'sidebar_one',
				'description'   => __('Widgets in this area can be called out with Wordpress modules.'),
				'before_widget' => '<div id="%1$s" class="site-content__sidebar__widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="site-content__sidebar__widget__title">',
				'after_title'   => '</h3>',
			]
		);
	}

	// Setup various WordPress theme variables

	public function theme_setup()
	{

		// Make theme available for translation.
		load_theme_textdomain('text_domain', get_template_directory() . '/languages');

		// Create custom theme image sizes
		add_image_size('theme_image', 400, 400, true);

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		// Let WordPress manage the document title.
		add_theme_support('title-tag');

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support('post-thumbnails');

		// Switch default core markup for search form, comment form, and comments.
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			]
		);

		// Register custom navigation menus
		register_nav_menus(
			[
				'header_menu'   => esc_html__('Header menu', 'raadio'),
				'footer_menu' 	=> esc_html__('Footer menu', 'raadio'),
			]
		);
	}

	// Custom Yoast breadcrumbs separator.

	public static function filter_wpseo_breadcrumb_separator($this_options_breadcrumbs_sep)
	{
		return '<span class="breadcrumbs__separator"><i data-feather="chevron-right"></i></span>';
	}

	// Enable megamenu for header most top menu items via ACF.

	public static function megamenu_menu_item_classes($items, $args)
	{
		if ($args->theme_location === 'header_menu') {
			// Add the class only to the top-level menu item
			foreach ($items as &$item) {
				$depth = $item->menu_item_parent;

				$enable_megamenu = get_field('enable_megamenu', $item->ID);

				if ($depth == '0') {
					if ($enable_megamenu && $item->ID) {
						$item->classes[] = 'menu-item-megamenu menu-item-depth-' . $depth;
					}
				}
			}
		}

		return $items;
	}

	// Redirect empty employees page to its archive.

	function empty_employees_redirect_to_archive()
	{
		$post_type = 'tootaja';

		if (is_singular($post_type)) {
			global $post;

			if (empty($post->post_content)) {
				$archive_url = get_post_type_archive_link($post_type);
				wp_redirect($archive_url);
				exit;
			}
		}
	}

	/**
	 * Generate img tag with various attributes.
	 *
	 * @param int|bool $image_id Image ID to generate img tag of.
	 * @param array    $args Various arguments.
	 *
	 * @return string
	 */
	public static function generate_img_html($image_id = false, $args = [])
	{
		if (!$image_id) {
			return '';
		}

		$default_args = [
			'size'             => 'large',
			'disable_lazyload' => false,
			'for_swiper'       => false,
			'classes'          => [],
			'alt'              => '',
			'title'            => '',
		];

		$options = wp_parse_args($args, $default_args);

		$img_html = '<img ';

		if ($options['disable_lazyload']) {
			$img_html .= 'src="' . esc_url(wp_get_attachment_image_url($image_id, $options['size'])) . '" ';
			$img_html .= 'class="' . esc_attr(implode(' ', $options['classes'])) . '" ';
			$img_html .= 'srcset="' . esc_attr(wp_get_attachment_image_srcset($image_id, $options['size'])) . '" ';
			$img_html .= 'sizes="' . esc_attr(wp_get_attachment_image_sizes($image_id, $options['size'])) . '"';
		} else {
			$img_html .= 'data-src="' . esc_url(wp_get_attachment_image_url($image_id, $options['size'])) . '" ';
			$img_html .= 'data-srcset="' . esc_attr(wp_get_attachment_image_srcset($image_id, $options['size'])) . '" ';
			$img_html .= 'data-sizes="' . esc_attr(wp_get_attachment_image_sizes($image_id, $options['size'])) . '"';

			if ($options['for_swiper']) {
				$img_html .= 'class="swiper-lazy ' . esc_attr(implode(' ', $options['classes'])) . '" ';
			} else {
				$img_html .= 'class="js-lazyload-image ' . esc_attr(implode(' ', $options['classes'])) . '" ';
				$img_html .= 'src="' . esc_url(wp_get_attachment_image_url($image_id, 'thumbnail')) . '" ';
			}
		}

		$img_html .= 'alt="' . $options['alt'] . '"';
		$img_html .= 'title="' . $options['title'] . '"';
		$img_html .= '/>';

		return $img_html;
	}

	public function ws_admin_enqueue_scripts_and_styles()
	{
		$manifest      = json_decode(file_get_contents(get_template_directory() . '/package.json', true));
		$asset_version = $manifest->version;
		wp_enqueue_script('admin-ws-custom-js', get_template_directory_uri() . '/assets/dist/js/admin.bundle.min.js', array('jquery'), $asset_version, true);
	}


	/** Enqueues theme stylesheet and Javascript files.
	 */
	public function ws_theme_enqueue_scripts_and_styles()
	{
		$manifest      = json_decode(file_get_contents(get_template_directory() . '/package.json', true));
		$asset_version = $manifest->version;
		wp_enqueue_style('ws-main-stylesheet', get_stylesheet_uri(), [], $asset_version);
		wp_enqueue_script('ws-custom-js', get_template_directory_uri() . '/assets/dist/js/bundle.min.js', array('jquery'), $asset_version, true);
	}
}

new ThemeSetup();
