<div class="bg-dark-main text-white pt-12 pb-10">
	<div class="container max-w-[88rem]">
		<div class="grid grid-cols-1 md:grid-cols-2 gap-8 xl:ml-[calc(276px+7.5rem)]">
			<div>
				<p class="text-h4">Sign Up For Our Newsletter</p>
				<p class="body-base mt-2">Stay up to date with the latest news &amp; research at SERC.</p>
			</div>
			<form data-newsletter-signup action="<?php echo EMAIL_NEWSLETTER_ENDPOINT; ?>" target="_blank" ref="noreferrer noopener" class="transition-all flex flex-col lg:flex-row lg:items-center gap-4 lg:gap-1">
				<div data-onsubmit="hide" class="field field-text field-text-sm w-full">
					<input type="hidden" name="plaintext_preferred" value="False" class="hidden" />
					<input type="email" name="email" placeholder="Your email Address" class="shadow-[inset_0px_0px_0px_1px_#ffffff]" />
				</div>
				<button data-onsubmit="hide" type="submit" class="btn btn-primary w-full focus:outline-white lg:max-w-28">Sign Up</button>
				<div data-onsuccess="show" class="w-full" style="display: none;">
					<p class="text-h4 bg-dark-secondary p-4">Thank you for signing up!</p>
				</div>
				<div data-onerror="show" class="w-full" style="display: none;">
					<p class="text-h4 bg-dark-secondary p-4">There was an error with the request. Please try again.</p>
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {
		const forms = document.querySelectorAll('[data-newsletter-signup]');
		forms.forEach(function(form) {
			const showOnSuccess = form.querySelectorAll('[data-onsuccess="show"]');
			const showOnError = form.querySelectorAll('[data-onerror="show"]');
			const hideOnSubmit = form.querySelectorAll('[data-onsubmit="hide"]');
			const submitButton = form.querySelector('button[type="submit"]');
			form.addEventListener('submit', async function(event) {
				event.preventDefault();
				form.style.opacity = 0.5;
				form.style.pointerEvents = 'none';
				submitButton.innerHTML = 'Sending...';
				const formData = new FormData(form);
				const actionUrl = form.getAttribute('action');
				const res = await fetch(actionUrl, {
					method: 'POST',
					body: formData,
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					}
				})
				form.style.opacity = 1;
				form.style.pointerEvents = 'auto';
				hideOnSubmit.forEach(function(el) {
					el.style.display = 'none';
				});
				if (res.ok) {
					showOnSuccess.forEach(function(el) {
						el.style.display = 'block';
					});
				} else {
					showOnError.forEach(function(el) {
						el.style.display = 'block';
					});
				}
			});
		});
	});
</script>