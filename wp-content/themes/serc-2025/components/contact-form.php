<?php

/**
 * Component: Contact Form
 */
?>

<?php
$fields = [
	[
		["type" => "text", "name" => "first_name", "label" => "First Name"],
		["type" => "text", "name" => "last_name", "label" => "Last Name"],
	],
	[
		["type" => "text", "name" => "organization", "label" => "Organization"],
		["type" => "email", "name" => "email", "label" => "Email"],
	],
	[
		["type" => "select", "name" => "topic", "label" => "Topic", "options" => ["General", "Press", "Partnership", "Other"]],
		["type" => "text", "name" => "subject", "label" => "Subject"],
	],
	[
		["type" => "textarea", "name" => "message", "label" => "Message", "placeholder" => "Add your message here", "hint" => "Maximum 500 characters"],
	]
];
?>

<form action="" method="post" class="flex flex-col gap-4 md:gap-y-6">
	<?php foreach ($fields as $row) : ?>
		<div class="flex flex-col md:flex-row gap-4 md:gap-y-6 md:gap-x-10">
			<?php foreach ($row as $field) : ?>
				<?php if ($field["type"] == "select") : ?>
					<div class="field field-select w-full">
						<?php if (isset($field["label"])) : ?>
							<label class="label" for="<?= $field["name"] ?>"><?= $field["label"] ?></label>
						<?php endif; ?>
						<select name="<?= $field["name"] ?>" id="<?= $field["name"] ?>">
							<?php foreach ($field["options"] as $option) : ?>
								<option value="<?= $option ?>"><?= $option ?></option>
							<?php endforeach; ?>
						</select>
						<?php if (isset($field["hint"])) : ?>
							<div class="hint"><?= $field["hint"] ?></div>
						<?php endif; ?>
					</div>
				<?php elseif ($field["type"] == "email") : ?>
					<div class="field field-text w-full">
						<?php if (isset($field["label"])) : ?>
							<label class="label" for="<?= $field["name"] ?>"><?= $field["label"] ?></label>
						<?php endif; ?>
						<input type="email" name="<?= $field["name"] ?>" id="<?= $field["name"] ?>" placeholder="<?= $field["placeholder"] ?? "" ?>" />
						<?php if (isset($field["hint"])) : ?>
							<div class="hint"><?= $field["hint"] ?></div>
						<?php endif; ?>
					</div>
				<?php elseif ($field["type"] == "textarea") : ?>
					<div class="field field-text w-full">
						<?php if (isset($field["label"])) : ?>
							<label class="label" for="<?= $field["name"] ?>"><?= $field["label"] ?></label>
						<?php endif; ?>
						<textarea name="<?= $field["name"] ?>" id="<?= $field["name"] ?>" rows="6"><?= $field["placeholder"] ?? "" ?></textarea>
						<?php if (isset($field["hint"])) : ?>
							<div class="hint"><?= $field["hint"] ?></div>
						<?php endif; ?>
					</div>
				<?php else : ?>
					<div class="field field-text w-full">
						<?php if (isset($field["label"])) : ?>
							<label class="label" for="<?= $field["name"] ?>"><?= $field["label"] ?></label>
						<?php endif; ?>
						<input type="email" name="<?= $field["name"] ?>" id="<?= $field["name"] ?>" placeholder="<?= $field["placeholder"] ?? "" ?>" />
						<?php if (isset($field["hint"])) : ?>
							<div class="hint"><?= $field["hint"] ?></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
	<div>[I'm not a robot]</div>
	<div>
		<button type="submit" class="btn btn-primary btn-lg">Submit</button>
	</div>
</form>