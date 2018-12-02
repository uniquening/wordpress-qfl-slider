<?php 
	if (!defined('WP_UNINSTALL_PLUGIN')) exit();
	delete_option('qfl_slider_install');
	delete_option('qfl_slider_uninstall');
?>