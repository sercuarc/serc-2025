<?php
$title = $args['title'] ?? "";
$url = $args['url'] ?? "";
$uid = uniqid();
?>

<div data-share="<?php echo $uid; ?>" class="flex items-center gap-4 mt-8">
	<button data-copy title="Copy URL" class="relative p-2 outline-0 hover:bg-[#00000008] text-light-surface-subtle hover:text-light-surface-normal focus:text-light-surface-normal border border-subtle hover:border-normal focus:border-normal transition-all"><?php echo serc_svg('link', 'block size-7') ?><span class="sr-only">Copy link</span></button>
	<a rel="noopener nofollow" target="_blank" href="https://www.addtoany.com/add_to/linkedin?linkurl=<?php echo $url; ?>&amp;linkname=<?php echo $title; ?>&amp;linknote=" title="LinkedIn" class="p-2 outline-0 hover:bg-[#00000008] text-light-surface-subtle hover:text-light-surface-normal focus:text-light-surface-normal border border-subtle hover:border-normal focus:border-normal transition-all"><?php echo serc_svg('linkedin', 'block size-7') ?><span class="sr-only">LinkedIn</span></a>
	<a rel="noopener nofollow" target="_blank" href="https://www.addtoany.com/add_to/facebook?linkurl=<?php echo $url; ?>&amp;linkname=<?php echo $title; ?>&amp;linknote=" title="Facebook" class="p-2 outline-0 hover:bg-[#00000008] text-light-surface-subtle hover:text-light-surface-normal focus:text-light-surface-normal border border-subtle hover:border-normal focus:border-normal transition-all"><?php echo serc_svg('facebook', 'block size-7') ?><span class="sr-only">Facebook</span></a>
</div>

<script type="text/javascript">
	(function() {
		const url = "<?php echo $url; ?>";
		const uid = "<?php echo $uid; ?>";
		const share = document.querySelector('[data-share="' + uid + '"]');
		const copyButton = share.querySelector('[data-copy]');
		if (!navigator.clipboard) {
			console.log('Clipboard API is not available');
			copyButton.style.display = 'none';
			return;
		}
		copyButton.addEventListener('click', function(e) {
			e.preventDefault();
			navigator.clipboard.writeText(url);
			const popupClasslist = [
				'after:content-["URL_Copied!"]',
				'after:text-sm',
				'after:font-medium',
				'after:whitespace-nowrap',
				'after:bg-black',
				'after:text-white',
				'after:rounded',
				'after:px-2',
				'after:py-1',
				'after:absolute',
				'after:bottom-[calc(100%+0.5rem)]',
				'after:left-1/2',
				'after:-translate-x-1/2',
				'after:transition-all',
			];
			const animateFrom = [
				'after:opacity-0',
				'after:translate-y-full',
			]
			const animateTo = [
				'after:opacity-100',
				'after:translate-y-0',
			]
			copyButton.classList.add(...popupClasslist);
			copyButton.classList.add(...animateFrom);
			setTimeout(() => {
				copyButton.classList.remove(...animateFrom);
				copyButton.classList.add(...animateTo);
			}, 100);
			setTimeout(() => {
				copyButton.classList.remove(...animateTo);
				copyButton.classList.add(...animateFrom);
			}, 2000);
			setTimeout(() => {
				copyButton.classList.remove(...popupClasslist);
			}, 2500);
		});
	})();
</script>