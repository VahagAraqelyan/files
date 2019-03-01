<?php
/**
 * Codeigniter Library to Compress And Combine CSS/JS files
 *
 * - Remove comments
 * - Remove more than one whitespaces
 * - Remove tabs, new lines
 * - Combine files
 *
 * @category   library
 * @package    framework
 * @subpackage library
 * @copyright  Copyright (c) 2016 tokernel Development team
 * @version    1.0.0
 */

/* Restrict direct access to this file */
defined('BASEPATH') OR exit('No direct script access allowed');

class Cassets {

	/**
	 * File extensions allowed to compress
	 *
	 * @access protected
	 * @var array
	 */
	protected $file_types = array('js', 'css');

	/**
	 * Compress javascript content
	 *
	 * @access public
	 * @param string $buffer
	 * @return string
	 */
	public function javascript($buffer) {

        /* Temporary replace HTTP:// and HTTPS:// with other chars */
        $buffer = str_replace('http://', 'http:@@', $buffer);
        $buffer = str_replace('https://', 'http:^^', $buffer);

		/* remove comments */
		$buffer = preg_replace("/((?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:\/\/.*))/", '', $buffer);

        /* Restore HTTP:// and HTTPS:// */
        $buffer = str_replace('http:@@', 'http://', $buffer);
        $buffer = str_replace('http:^^', 'https://', $buffer);

		/* remove tabs, spaces, new lines, etc. */
		$buffer = str_replace(array("\r\n","\r","\t","\n",'  ','    ','     '), '', $buffer);

		/* remove other spaces before/after ) */
		$buffer = preg_replace(array('(( )+\))','(\)( )+)'), ')', $buffer);

		$buffer = trim($buffer);
		$buffer = rtrim($buffer, ';') . ';';

		return $buffer;

	} // End func javascript

	/**
	 * Compress css content
	 *
	 * @access public
	 * @param string $buffer
	 * @return string
	 */
	public function css($buffer) {

		/* remove comments */
		$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

		/* remove tabs, spaces, new lines, etc. */
		$buffer = str_replace(array("\r\n","\r","\n","\t",'  ','    ','     '), '', $buffer);

		/* remove other spaces before/after ; */
		$buffer = preg_replace(array('(( )+{)','({( )+)'), '{', $buffer);
		$buffer = preg_replace(array('(( )+})','(}( )+)','(;( )*})'), '}', $buffer);
		$buffer = preg_replace(array('(;( )+)','(( )+;)'), ';', $buffer);

		return $buffer;

	} // End func css

	/**
	 * Compress file
	 * Type will detected automatically
	 * Compress and save file if destination file set.
	 * Return compressed file content if destination file not set.
	 *
	 * @access public
	 * @param string $source_file
	 * @param mixed $destination_file
	 * @return mixed
	 */
	public function file($source_file, $destination_file = NULL) {

		// Detect type
		$type = pathinfo($source_file, PATHINFO_EXTENSION);

		if($type != 'css') {
			if(strpos($source_file, '.css') !== false) {
				$type = 'css';
			}
		}

		// Check if type allowed
		if(!in_array($type, $this->file_types)) {
			//trigger_error('Invalid file type: ' . $type, E_USER_ERROR);
		}

		// If file located on remote server
		if(substr($source_file, 0, 2) == '//' or substr($source_file, 0, 4) == 'http' or substr($source_file, 0, 5) == 'https') {
			$content = $this->get_remote_file_content($source_file);
		// Load from disk
		} else {

            // Check file
            if(!is_readable($source_file) or !is_file($source_file)) {
                trigger_error("File: " . $source_file . " doesn't exists!", E_USER_ERROR);
            }

			$content = file_get_contents($source_file);
		}

		// Compress by type
		if($type == 'js') {
			$content = $this->javascript($content);
		}

		if($type == 'css') {
			$content = $this->css($content);
		}

		// Save to file if specified
		if(!is_null($destination_file)) {
			file_put_contents($destination_file, $content);
			return true;
		}

		// Return content
		return $content;

	} // End func file

	/**
	 * Build combined files content from batch.
	 * Save combined content to destination file if specified.
	 * Return combined content if destination file not specified.
	 *
	 * $source_files associative array should be defined as:
	 *
	 * array(
	 *     'filename1.js' => true // means compress, than combine
	 *     'filename1.js' => false // means just combine the file without compression
	 * )
	 *
	 * @access public
	 * @param array $source_files
	 * @param mixed $destination_file = NULL
	 * @return mixed
	 */
	public function files($source_files, $destination_file = NULL) {

		// Check if array not empty
		if(empty($source_files)) {
			trigger_error("Empty files list!", E_USER_ERROR);
		}

		$content = '';

		// Build/combine content with all files
		foreach($source_files as $file => $do_compress) {

			if($do_compress == true) {
				$content .= $this->file($file) . "\n";
			} else {
				// If file located on remote server
				if(substr($file, 0, 2) == '//' or substr($file, 0, 4) == 'http' or substr($file, 0, 5) == 'https') {
					$content .= $this->get_remote_file_content($file) . "\n";
				} else {
					$content .= file_get_contents($file) . "\n";
				}
			}

		} // End foreach

		// Return content, if destination file not specified
		if(is_null($destination_file)) {
			return $content;
		}

		// Save file
		file_put_contents($destination_file, $content);

		// Return file name
		return $destination_file;

	} // End func files

	/**
	 * Get file content from remote server
	 * This method is experimental
	 *
	 * @param string $url
	 * @return mixed
	 */
	public function get_remote_file_content($url) {

		$ch = curl_init();
		$timeout = 5;

		$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
		curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);

		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);

		return $data;

	} // End func get_remote_file

} // End class compress_lib

// End of file
?>
