<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wp_rig
 */

namespace WP_Rig\WP_Rig;

?>

</div><footer id="colophon" class="site-footer">
		<?php get_template_part( 'template-parts/footer/info' ); ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<div id="search-modal" class="search-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-labelledby="search-modal-title">
	<div class="search-modal__backdrop" data-action="close-search-modal"></div>
	<div class="search-modal__panel">
		<button type="button" class="search-modal__close" data-action="close-search-modal" aria-label="Close search dialog">&times;</button>
		<div class="search-modal__content">
			<h2 id="search-modal-title" class="search-modal__title">Search</h2>
			<form role="search" method="get" class="search-modal__form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="screen-reader-text" for="search-modal-input">Search</label>
				<input type="search" id="search-modal-input" name="s" class="search-modal__input" placeholder="Search…" value="" />
				<button type="submit" class="search-modal__submit">Search</button>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
(function() {
	var modal = document.getElementById('search-modal');
	if (!modal) {
		return;
	}

	var openLinks = document.querySelectorAll('a[href="#search-modal"]');
	var closeButtons = modal.querySelectorAll('[data-action="close-search-modal"]');
	var input = modal.querySelector('#search-modal-input');

	function openModal(event) {
		event.preventDefault();
		modal.classList.add('is-open');
		modal.setAttribute('aria-hidden', 'false');
		document.body.classList.add('search-modal-open');
		if (input) {
			window.setTimeout(function() {
				input.focus();
			}, 50);
		}
	}

	function closeModal(event) {
		if (event) {
			event.preventDefault();
		}
		modal.classList.remove('is-open');
		modal.setAttribute('aria-hidden', 'true');
		document.body.classList.remove('search-modal-open');
	}

	openLinks.forEach(function(link) {
		link.addEventListener('click', openModal);
	});

	closeButtons.forEach(function(button) {
		button.addEventListener('click', closeModal);
	});

	modal.addEventListener('click', function(event) {
		if (event.target === modal || event.target.dataset.action === 'close-search-modal') {
			closeModal(event);
		}
	});

	document.addEventListener('keydown', function(event) {
		if (event.key === 'Escape' && modal.classList.contains('is-open')) {
			closeModal(event);
		}
	});
})();
</script>

<?php wp_footer(); ?>

</body>
</html>
