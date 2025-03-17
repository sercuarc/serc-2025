<?php
/* 
 * Admin Pages
 * 
 * Author: Kirk Pettinga (Studio Lekker)
 */

function serc_add_theme_settings_page()
{
	add_menu_page(
		'SERC Admin',     // Page title
		'SERC Admin',     // Menu title
		'manage_options', // Capability (who can access, defaults to Admins)
		'serc-admin', 		// Menu slug
		'serc_admin_page_content', // Callback function
		'dashicons-admin-generic', // Icon (optional)
		50 // Position in menu (lower number = higher placement)
	);
}
add_action('admin_menu', 'serc_add_theme_settings_page');

function serc_admin_page_content()
{
?>
	<div class="wrap">
		<h1>SERC Admin Tools</h1>
		<!-- Tab Navigation -->
		<div class="nav-tab-wrapper">
			<a href="#meilisearch" class="nav-tab nav-tab-active" onclick="changeTab(event, 'meilisearch')">MeiliSearch</a>
		</div>
		<div id="meilisearch" class="tab-content" style="display: block;">
			<div style="background:white; padding: 0.5rem 1rem; margin-top:1rem; max-width:720px; border: 1px solid #2271b1; border-left-width:4px">
				<h2>Sync MeiliSearch Indexes:</h2>
				<p>Use these buttons to manually sync records with MeiliSearch indexes.</p>
				<p><strong>Note:</strong> These buttons only fetch data and <em>schedule</em> it so be synced with MeiliSearch. They do not guarantee the sync will be successful on MeiliSearch's end. If you are experiencing issues, please check the logs under the "Tasks" tab in your MeiliSearch instance dashboard.</p>
			</div>
			<?php
			$resources = [
				'news-events' => 'Sync News/Events (Wordpress)',
				'organizations' => 'Sync Organizations (SERC DB)',
				'pages' => 'Sync Pages (Wordpress)',
				'people' => 'Sync People (Wordpress)',
				'projects' => 'Sync Projects (SERC DB)',
				'publications' => 'Sync Publications (SERC DB)',
				'technical-reports' => 'Sync Technical Reports (SERC DB)',
			];
			?>
			<?php foreach ($resources as $resource => $label) : ?>
				<p>
					<button data-sync="<?php echo $resource; ?>" class="button">
						<?php echo $label; ?>
						<span class="spinner is-active" style="display:none"></span>
					</button>
				</p>
			<?php endforeach; ?>
		</div>

		<script>
			(function() {
				const syncButtons = document.querySelectorAll('button[data-sync]');
				syncButtons.forEach(button => {
					const spinner = button.querySelector('.spinner');
					const message = document.createElement('strong');
					message.style.marginLeft = '10px';

					button.addEventListener('click', () => {
						button.setAttribute('disabled', true);
						spinner.style.display = 'inline-block';
						fetch(`https://kpettinga-syncmeilisearchindex.web.val.run?resource=${button.getAttribute('data-sync')}`)
							.then(response => response.json())
							.then(json => {
								if (json.status === 'success') {
									message.style.color = 'green';
									message.textContent = `Success! ${json.documents} documents scheduled to sync with the "${json.task.indexUid}" index.`;
								} else {
									console.error(json);
									message.style.color = 'red';
									message.textContent = `Response error :( See console log for details.`;
								}
							})
							.catch(error => {
								console.error(error);
								message.style.color = 'red';
								message.textContent = `Fetch error :( See console log for details.`;
							})
							.finally(() => {
								button.removeAttribute('disabled');
								spinner.style.display = 'none';
								button.parentNode.insertBefore(message, button.nextSibling);
								setTimeout(() => message.remove(), 5000);
							});
					});
				});
			})();
		</script>

	</div>
<?php
}
