<?php
$items = $args['items'] ?? [];
$active_id = $args['active_id'] ?? null;
if (empty($active_id)) {
	$active_item = $items[0];
	var_dump('empty($active_id)');
} else {
	$active_item = array_find($items, function ($item) use ($active_id) {
		return $item['id'] === $active_id;
	});
}
?>

<nav data-tab-menu class="tab-menu">
	<button data-tab-menu-toggle class="tab-menu-toggle">
		<span data-tab-menu-toggle-text><?php echo $active_item['text'] ?></span>
		<?php echo serc_svg("chevron-down", "icon") ?>
	</button>
	<div class="tab-menu-inner">
		<?php foreach ($items as $item) :
			$href = $item['url'] ?? '#' . $item['id'];
		?>
			<a data-tab href="<?php echo $href ?>" class="tab <?php echo $item['id'] === $active_id ? "is-active" : "" ?>"><?php echo $item['text'] ?></a>
		<?php endforeach; ?>
	</div>
</nav>