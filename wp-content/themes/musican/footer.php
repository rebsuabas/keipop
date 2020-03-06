<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Musican
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

        <div class="container text-center">
            <?php get_template_part( 'template-parts/footer/site', 'info' ); ?>
        </div>

	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
