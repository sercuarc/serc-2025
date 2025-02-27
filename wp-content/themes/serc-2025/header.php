<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body class="m-4">

	<nav class="bg-gray-200 p-4 mb-8">
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="/2025">Archive</a></li>
			<li><a href="/sample-page">Sample Page</a></li>
			<li>
				<form action="/">
					<input type="text" name="s" placeholder="Search" />
					<button type="submit" style="display: none">Submit</button>
				</form>
			</li>
		</ul>
	</nav>