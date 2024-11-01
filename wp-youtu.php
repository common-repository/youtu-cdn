<?php
/*
Plugin Name: YouTu-CDN
Plugin URI: http://www.xmgo.cc/YouTu-CDN/
Description: WordPress腾讯万象优图图床插件
Version: 1.1.0
Author: All-Right
Author URI: http://www.xmgo.cc/
*/
?>
<?php defined('ABSPATH') or exit; ?>
<?php
define("wp_youtu_version", "1.10");
function youtu_table_install() {
	global $wpdb;
	
	$admin_dir = str_replace(home_url() . '/', '', admin_url());
	require_once(ABSPATH . $admin_dir . '/includes/upgrade.php');
	$table_img = $wpdb->prefix . YOUTU_IMGTABLE;
	if($wpdb->get_var("show tables like $table_img") != $table_img) {
		$sql_img = 'CREATE TABLE IF NOT EXISTS `' . $table_img . '` (
			`ID` bigint(20) UNSIGNED NULL AUTO_INCREMENT,
			`img_id` varchar(255) NOT NULL,
			`url` varchar(255) NOT NULL,
			UNIQUE KEY `id` (`ID`)
			) CHARSET=utf8;';
		dbDelta($sql_img);
	}
	$table_log = $wpdb->prefix . YOUTU_LOGTABLE;
	if($wpdb->get_var("show tables like $table_log") != $table_log) {
		$sql_log = 'CREATE TABLE IF NOT EXISTS `' . $table_log . '` (
			`ID` bigint(20) UNSIGNED NULL AUTO_INCREMENT,
			`datetime` datetime DEFAULT "0000-00-00 00:00:00" NOT NULL,
			`log` longtext NOT NULL,
			UNIQUE KEY `id` (`ID`)
			) CHARSET=utf8;';
		dbDelta($sql_log);
	}
}
register_activation_hook(__FILE__, 'youtu_table_install');
register_deactivation_hook( __FILE__, 'youtu_delete_sync_cron' );
register_uninstall_hook( __FILE__, 'youtu_delete_sync_cron' );

function youtu_menu() {
	add_menu_page( 'YouTu-CDN', 'YouTu-CDN', 'administrator', 'YouTu-CDN', 'wp_youtu_control', 'dashicons-format-gallery');
	add_submenu_page( 'YouTu-CDN', '接口设置', '接口设置', 'administrator', 'YouTu-CDN', 'wp_youtu_control');
	add_submenu_page( 'YouTu-CDN', '图片管理', '图片管理', 'administrator', 'youtu-manage', 'wp_youtu_manage');
	add_submenu_page( 'YouTu-CDN', '优图直传', '优图直传', 'administrator', 'youtu-other', 'wp_youtu_other');
	add_submenu_page( 'YouTu-CDN', '操作日志', '操作日志', 'administrator', 'youtu-log', 'wp_youtu_log');
}
add_action('admin_menu', 'youtu_menu');

function youtu_settings_link($action_links, $plugin_file) {
	if($plugin_file == plugin_basename(__FILE__) ){
		$youtu_settings_link = '<a href="' . admin_url('admin.php?page=YouTu-CDN') . '">设置</a>';
		array_unshift($action_links, $youtu_settings_link);
	}
	return $action_links;
}
add_filter('plugin_action_links', 'youtu_settings_link', 10, 2);

require 'inc/functions.php';
require 'inc/setting.php';
require 'inc/manage.php';
require 'inc/other.php';
require 'inc/log.php';
?>