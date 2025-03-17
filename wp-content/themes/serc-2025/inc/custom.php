<?php

/**
 * Theme Customizations
 */

function custom_login_logo()
{
	echo '<style type="text/css">
			.login h1 a {
					background-image: url(' . get_bloginfo('template_directory') . '/images/logo-vert-color.svg);
					background-size: cover;
					width: 270px;
					height: 190px;
			}
	</style>';
}
add_action('login_head', 'custom_login_logo');
