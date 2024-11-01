<?php defined('ABSPATH') or exit; ?>
<?php
$youtu_setting = get_option('youtu_setting');
$youtu_setting = unserialize($youtu_setting);
if(!empty($youtu_setting)) {
	$secretid = $youtu_setting['secretid'];
	$secretkey = $youtu_setting['secretkey'];
	$appid = $youtu_setting['appid'];
	$bucket = $youtu_setting['bucket'];
	$domain = $youtu_setting['domain'];
	if(empty($domain)) 
		$domain = $bucket . '-' . $appid . '.image.myqcloud.com';
	$baseurl = 'http://' . $domain . '/';
}
//SecretId
define('YOUTU_SECRETID', $secretid);
//SecretKey
define('YOUTU_SECRETKEY', $secretkey);
//AppID
define('YOUTU_APPID', $appid);
//Bucket
define('YOUTU_BUCKET', $bucket);
//BaseUrl
define('YOUTU_BASEURL', $baseurl);
//ImgTable
define('YOUTU_IMGTABLE', 'youtu');
//LogTable
define('YOUTU_LOGTABLE', 'youtulog');
?>