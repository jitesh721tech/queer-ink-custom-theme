<?php
/**
 * Footer template.
 *
 * @package Queer_Ink_Theme
 */
?>
<footer class="site-footer" role="contentinfo">
    <div class="site-footer-inner">

        <div class="footer-branding">
            <?php if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <a class="footer-logo-link" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <img class="footer-logo" src="<?php echo esc_url( get_theme_file_uri( 'assets/images/logo/queer_ink_logo.jpeg' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" width="174" height="58" />
                </a>
            <?php endif; ?>
        </div>

        <div class="footer-copy">
            <p>Queer Ink is a publishing house, archive, digital library and public knowledge institution working at the intersection of publishing and archives.</p>
        </div>

        <div class="footer-links-grid">
            <div class="footer-links-column">
                <h3>Explore</h3>
                <ul>
                    <li><a href="#">Publishing</a></li>
                    <li><a href="#">Archiving</a></li>
                    <li><a href="#">Digital Library</a></li>
                    <li><a href="#">QI Journal</a></li>
                </ul>
            </div>
            <div class="footer-links-column">
                <h3>About</h3>
                <ul>
                    <li><a href="#">Our Story</a></li>
                    <li><a href="#">Our Approach</a></li>
                    <li><a href="#">The Team</a></li>
                    <li><a href="#">Careers</a></li>
                </ul>
            </div>
            <div class="footer-links-column">
                <h3>Connect</h3>
                <ul>
                    <li><a href="#">Get In Touch</a></li>
                    <li><a href="#">Collaborate</a></li>
                    <li><a href="#">Internship</a></li>
                    <li><a href="#">Press &amp; Media</a></li>
                </ul>
            </div>
            <div class="footer-links-column">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms Of Use</a></li>
                    <li><a href="#">Accessibility</a></li>
                    <li><a href="<?php echo esc_url( home_url( '/sitemap/' ) ); ?>">Sitemap</a></li>
                </ul>
            </div>
            <div class="footer-links-column footer-social-column">
                <h3>Find Us</h3>
                <div class="footer-social-icons">
                    <a class="footer-social-icon" href="#" aria-label="Instagram">
                        <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/social/instagram.png' ) ); ?>" alt="Instagram" />
                    </a>
                    <a class="footer-social-icon" href="#" aria-label="Facebook">
                        <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/social/facebook.png' ) ); ?>" alt="Facebook" />
                    </a>
                    <a class="footer-social-icon" href="#" aria-label="Twitter">
                        <img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/social/twitter.png' ) ); ?>" alt="Twitter" />
                    </a>
                </div>
            </div>
        </div>

    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
