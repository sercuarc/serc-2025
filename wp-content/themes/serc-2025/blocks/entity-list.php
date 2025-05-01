<?php
$entities = get_field('entity_list_entities');
if (empty($entities)) {
	$entities = [
		[
			'entity_title' => 'Sample Entity',
			'entity_description' => 'Description for this entity.',
			'entity_url' => 'https://sample-entity.com',
			'entity_image' => '<div style="aspect-ratio: 1/1; background-color: #ddd;"></div>',
		],
	];
} else {
	$entities = array_map(function ($entity) {
		$entity['entity_image'] = wp_get_attachment_image($entity['entity_image'], 'small', false, ['class' => 'aspect-square object-contain border border-subtle p-4']);
		return $entity;
	}, $entities);
}
get_template_part('components/entity-list', null, [
	'title' => get_field('entity_list_title') ?: 'Entity List Title',
	'entities' => $entities,
]);
