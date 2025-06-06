<!DOCTYPE html>
<html lang="en" <?php post_class(); ?>>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400..700;1,14..32,400..700&family=Oswald:wght@400..600&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>

<body class="group/body text-dark-main overflow-x-hidden <?php if (is_admin_bar_showing()) : ?>pt-[35px] lg:pt-[70px]<?php else : ?>pt-[80px] lg:pt-[103px]<?php endif; ?>" style="-webkit-font-smoothing: antialiased;">

	<?php get_template_part('components/navigation'); ?>