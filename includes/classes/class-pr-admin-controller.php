<?php

// PR_Admin_Controller class.

class PR_Admin_Controller {

  // PR_Admin_Controller constructor.

  public function __construct()
  {
		$this->remove_actions();
		$this->remove_filters();
		$this->add_actions();
		$this->add_filters();
  }

	/**
	 * Add WordPress actions.
	 */
  private function add_actions(): void
  {
	add_action('login_enqueue_scripts', [$this, 'ws_enqueue_admin_styles']);
	add_action('admin_enqueue_scripts', [$this, 'ws_enqueue_admin_styles']);
    add_action('admin_head', [$this, 'gb_gutenberg_admin_styles']);
    add_action('wp_before_admin_bar_render', [$this, 'add_admin_bar_button']);
  }

	/**
	 * Add WordPress custom filters.
	 */
	private function add_filters(): void
	{

	}

  	/**
	 * Remove WordPress existing filters.
	 */
	private function remove_filters()
	{

	}

	/**
	 * Remove WordPress existing actions.
	 */
	private function remove_actions()
	{

	}

  /**
	 * Change Gutenberg block editor width.
	 */
  public function gb_gutenberg_admin_styles()
  {
    echo '
      <style>
        /* Main column width */
        .wp-block {
          max-width: 1080px;
        }

        /* Width of "wide" blocks */
        .wp-block[data-align="wide"] {
          max-width: 1400px;
        }

        /* Width of "full-wide" blocks */
        .wp-block[data-align="full"] {
          max-width: none;
        }
      </style>
    ';
  }


  public function ws_enqueue_admin_styles()
  {
	  $manifest      = json_decode(file_get_contents(get_template_directory() . '/package.json', true));
	  $asset_version = $manifest->version;
	  wp_enqueue_style('ws-custom-login-style', get_stylesheet_directory_uri() . '/admin-style.css', [], $asset_version);
  }


	/**
	 * Adds custom admin bar button.
	 */
	public static function add_admin_bar_button()
	{
		get_template_part('template-parts/admin/adminbar');
	}
}
