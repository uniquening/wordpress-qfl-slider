<?php 
/*
Plugin Name: AA前方录轮插图插件
Description: 可以给主题页面提供特定的轮播图插件
Author: Unqiue Ning
Version: 1.0.0
*/

// set timezone
date_default_timezone_set("Asia/Shanghai");

//triggered when  plugin is enabled;
register_activation_hook(__FILE__, 'qfl_slider_install');
function qfl_slider_install() {
	update_option('qfl_slider_install', '轮播图插件已安装！');

}
//triggered when  plugin is disabled;
register_deactivation_hook(__FILE__, 'qfl_slider_uninstall');
function qfl_slider_uninstall() {
	update_option('qfl_slider_uninstall', 'yes');
}

//in theme loading css file;
add_action('wp_enqueue_scripts', 'qfl_enqueue_style');
function qfl_enqueue_style() {
	wp_enqueue_style('fontawesomecss', plugins_url('css/font-awesome.min.css', __FILE__), false);	
	wp_enqueue_style('swipercss', plugins_url('css/swiper.min.css', __FILE__), false);
}

//in theme loading js file;
add_action('wp_enqueue_scripts', 'qfl_enqueue_script');
function qfl_enqueue_script() {
	wp_enqueue_script('swiperjs', plugins_url('js/swiper.min.js', __FILE__), array(), false, true);
}

add_action('admin_menu', 'qfl_create_slider_menu');
function qfl_create_slider_menu() {
	add_menu_page(
		'轮播图设置首页',
		'轮播图',
		'manage_options',
		'qfl_slider_setting', 
		'qfl_slider_settings_page'
	);
}
update_option('imagesrc', '55');
function qfl_slider_settings_page() {
	global $wpdb;
	$num = 1;
	if (!empty($_POST) && check_admin_referer('qfl_slider_nonce')) {
		// $imagesrc = array();
		// $imagelink = array();
		// array_push($imagesrc, $_POST['imagesrc' . count($imagesrc) ]; 
		// update_option('imagesrc', $_POST['imagesrc']);

		update_option('num', $_POST['num']);
		$num = get_option('num');

	}
	?>

		<div class="wrap">
			<h1>轮播图</h1>
            <form action="" method="post">
            	<h2>设置轮播图片数量</h2>

            	<span>
                    <label for="num">图片数量：</label>
                    <input type="text" name="num" value="<?php echo $num; ?>" />
                </span>
				<h2>设置轮播图片参数</h2>
                
            	<?php for ($i = 1; $i <= $num; $i++) { ?>
            	<?php
            		$imagesrckey = 'imagesrc' . $i;
            		$imagelinkey = 'imagelinkey' . $i;
        			update_option($imagesrckey, $_POST[$imagesrckey]);
        			update_option($imagelinkey, $_POST[$imagelinkey]);
					$imagesrc = get_option($imagesrckey);
					$imagelink = get_option($imagelinkey);
				?>
            	<p>
	                <span>
	                    <label style="font-weight: 800"><?php echo $i; ?></label>
	                </span>
	                <span>
	                    <label for="<?php echo $imagesrckey; ?>" >图片链接地址：</label>
	                    <input type="text" name="<?php echo $imagesrckey; ?>" value="<?php echo $imagesrc; ?>" style="width:20rem" />
	                </span>
	                <span>
	                    <label for="<?php echo $imagelinkey; ?>">图片跳转链接：</label>
	                    <input type="text" name="<?php echo $imagelinkey; ?>" value="<?php echo $imagelink; ?>" style="width:20rem" />
	                </span>
                </p>
                <?php } ?>
                <p><input type="submit" name="submit" value="保存设置"></p>
                <?php wp_nonce_field('qfl_slider_nonce');// 输出一个验证信息?>
            </form>
            <h4 style="color:#000;"><span style="font-weight: bolder;color:red;">设置方法：</span>请先输入轮播图数量，保存设置，然后再输入每个图片的地址和跳转链接，再保存设置。</h4>
		</div>
	<?php
}

?>