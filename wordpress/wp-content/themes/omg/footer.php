			<footer class="footer" role="contentinfo">

				<div id="inner-footer" class="wrap cf">

					<div class="social-icons footer-social">
		           			<?php 
					           	if(function_exists('omg_social_icons')) :
					           		echo omg_social_icons(); 
					           	endif;
					        ?>
                	</div> <!-- social-icons-->

					<p class="source-org copyright">
						 &#169; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?> 
						<span><?php if(is_home()): ?>
							- <a href="http://wordpress.org/" target="_blank">Powered by WordPress</a> and <a href="http://wpdevshed.com" target="_blank">WP Dev Shed</a> 
						<?php endif; ?>
						</span>
					</p>

				</div>

			</footer>

		</div>

		<?php wp_footer(); ?>
	</body>

</html> <!-- end of site. what a ride! -->