<?php
/**
 * Assets optimization controller
 * Minify and Combine Javascript/CSS files.
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Assets extends CI_Controller {

	protected $js_files_path;
	protected $css_files_path;

	/**
	 * All possible files
	 */
	protected $js_packages = array(
	    'frontend' => array(
            'if.ie.top.js' => array(
                'html5shiv.min.js' => false,
                'respond.min.js' => false
            ),
            'bottom.main.js' => array(
                'jquery-3.1.0.min.js' => false,
                'socket.io.js' => false,
                'bootstrap.min.js' => false,
                'jquery.cookie.min.js' => false,
                'jquery.dataTables.min.js' => false,
                'bootbox.min.js' => false,
                'validation_lib.js' => false,
                'ajax_lib.js' => false,
                'main.js' => false,
            )
        ),
        'backend' => array(
            'if.ie.top.js' => array(
                'html5shiv.min.js' => false,
                'respond.min.js' => false
            ),
            'bottom.main.js' => array(
                'jquery-3.1.0.min.js' => false,
                'socket.io.js' => false,
                'bootstrap.min.js' => false,
                'jquery.cookie.min.js' => false,
                'jquery.dataTables.min.js' => false,
                'bootbox.min.js' => false,
                'ajax_lib.js' => false,
                'validation_lib.js' => false,
                'metisMenu.min.js' => false,
                'slimscroll.min.js' => false,
                'slicknav.min.js' => false,
                'owl.carousel.min.js' => false,
                'plugins.js' => false,
                'scripts.js' => false,
                'admin_main.js' => false,

            )
        ),
	);

	protected $css_packages = array(
		'frontend' => array(
		    'main.css' => array(
                'fontawesome.css' => true,
                'icon.css' => true,
                'bootstrap.min.css' => true,
                'jquery.dataTables.min.css' => true,
                'main.css' => true,
            )
        ),
        'backend' => array(
            'main.css' => array(
                'bootstrap.min.css' => true,
                'jquery.dataTables.min.css' => true,
                'metisMenu.css' => true,
                'styles.css' => true,
                'themify-icons.css' => true,
                'typography.css' => true,
                'default-css.css' => true,
                'admin_style.css' => true,
            )
        ),
	);

	protected $modes = array(
	    'frontend',
        'backend'
    );

	public function __construct() {

		parent::__construct();

		if(ENABLE_ASSETS_CACHING and ASSETS_CACHING_TYPE == 'file') {
            $this->load->driver('cache', 'file');
            $this->cache_object = $this->cache->file;
        }

		if(ENABLE_ASSETS_CACHING and ASSETS_CACHING_TYPE == 'memcached') {
            $this->load->driver('cache', 'memcached');
            $this->cache_object = $this->cache->memcached;
        }

		$this->load->helper('url');
		$this->load->library('cassets');

		$this->js_files_path = FCPATH . 'assets/js/';
		$this->css_files_path = FCPATH . 'assets/css/';

	}

	/**
	 * @return bool
	 */
	public function js() {

        // Fetch arguments from URL.
        // i.e. ../assets/css/frontend/main.css
        // i.e. ../assets/js/backend/main.js
        $mode = $this->uri->segment(3);
        $package = $this->uri->segment(4);

        // Both URL arguments are required
        if(!$mode or !$package) {
            show_404();
            return false;
        }

        // This should be frontend or backend
        if(!in_array($mode, $this->modes)) {
            show_404();
            return false;
        }

		header('Content-Type: application/javascript');
        header('Last-Modified: ' . gmstrftime("%a, %d %b %Y %H:%M:%S GMT", time()));
        header("Cache-Control: public, max-age=7200");
        header("Pragma: cache");
        //header("date: Thu, 11 Jan 2018 08:32:46 GMT");
        //header("expires: Thu, 12 Jan 2018 10:32:46 GMT");
        //header("last-modified: Mon, 13 Nov 2017 20:19:12 GMT");

		$buffer = '';
        $cache_key = $mode . '_' . $package;

		// Try to get content from cache
		if(ENABLE_ASSETS_CACHING) {
			$buffer = $this->cache_object->get($cache_key);
		}

		if($buffer) {
			echo '// From cache' . "\n";
			echo $buffer;
			return true;
		}

		if(!isset($this->js_packages[$mode][$package])) {
			show_404();
			return false;
		}

		$files_to_cc = array();
		foreach($this->js_packages[$mode][$package] as $file => $cc) {

			if(substr($file, 0, 2) == '//' or substr($file, 0, 4) == 'http' or substr($file, 0, 5) == 'https') {
				$files_to_cc[$file] = $cc;
			} else {
				$files_to_cc[$this->js_files_path . $file] = $cc;
			}
		}

		$buffer = $this->cassets->files($files_to_cc);

		if(ENABLE_ASSETS_CACHING) {
            $this->cache_object->save($cache_key, $buffer, 300);
		}

		echo '// Caching now ' . "\n";
		echo $buffer;

	}

	public function css() {

	    // Fetch arguments from URL.
        // i.e. ../assets/css/frontend/main.css
        // i.e. ../assets/js/backend/main.js
	    $mode = $this->uri->segment(3);
		$package = $this->uri->segment(4);

		// Both URL arguments are required
		if(!$mode or !$package) {
			show_404();
			return false;
		}
        
		// This should be frontend or backend
		if(!in_array($mode, $this->modes)) {
            show_404();
            return false;
        }

        header("Content-type: text/css", true);
        header('Last-Modified: ' . gmstrftime("%a, %d %b %Y %H:%M:%S GMT", time() - 20));
        header("Cache-Control: public, max-age=7200");
        header("Pragma: cache");
        //header("date: Thu, 11 Jan 2018 08:32:46 GMT");
        //header("expires: Thu, 12 Jan 2018 10:32:46 GMT");
        //header("last-modified: Mon, 13 Nov 2017 20:19:12 GMT");

		$buffer = '';

		$cache_key = $mode . '_' . $package;

		// Try to get content from cache
		if(ENABLE_ASSETS_CACHING) {
			$buffer = $this->cache_object->get($cache_key);
		}

		if($buffer) {
			echo '// From cache' . "\n";
			echo $buffer;
			return true;
		}

		if(!isset($this->css_packages[$mode][$package])) {
			show_404();
			return false;
		}

		$files_to_cc = array();
		foreach($this->css_packages[$mode][$package] as $file => $cc) {

			if(substr($file, 0, 2) == '//' or substr($file, 0, 4) == 'http' or substr($file, 0, 5) == 'https') {
				$files_to_cc[$file] = $cc;
			} else {
				$files_to_cc[$this->css_files_path . $file] = $cc;
			}
		}

		// Get Compressed content
		$buffer = $this->cassets->files($files_to_cc);

		// Replace ../images to correct path
        $buffer = str_replace('../images/', base_url('assets/images/'), $buffer);
        $buffer = str_replace('../../fonts/', base_url('assets/fonts/'), $buffer);
        $buffer = str_replace('../fonts/', base_url('assets/fonts/'), $buffer);

		if(ENABLE_ASSETS_CACHING) {
			$this->cache_object->save($cache_key, $buffer, 300);
		}

		//echo '// Caching now ' . "\n";
		echo $buffer;
	}
}