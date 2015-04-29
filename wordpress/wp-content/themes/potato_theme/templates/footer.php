	</div><!-- #content -->

</div><!-- #wrapper -->

<div id="footer" class="page_footer">

</div>

<script src="<?php echo bloginfo('template_directory'); ?>/js/masonry.pkgd.min.js"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/imagesloaded.js"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/classie.js"></script>
<script src="<?php echo bloginfo('template_directory'); ?>/js/AnimOnScroll.js"></script>
<script>
	new AnimOnScroll( document.getElementById('grid'), {
		minDuration : 0.4,
		maxDuration : 0.7,
		viewportFactor : 0.2
	} );
</script>

<?php wp_footer(); ?>
