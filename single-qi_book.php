<?php
/**
 * Single view for the qi_book CPT — full detail page (cover, authors,
 * subjects/language, description, PDF download) instead of the compact
 * card partial single.php falls back to for post types without their
 * own single-{post_type}.php.
 *
 * @package Queer_Ink_Theme
 */

get_header();

while ( have_posts() ) :
    the_post();

    $qi_book_authors  = get_the_terms( get_the_ID(), 'qi_book_author' );
    $qi_book_subjects = get_the_terms( get_the_ID(), 'qi_subject' );
    $qi_book_language = get_the_terms( get_the_ID(), 'qi_language' );
    $qi_book_pdf_id   = absint( get_post_meta( get_the_ID(), '_qi_book_pdf_id', true ) );
    $qi_book_pdf_url  = $qi_book_pdf_id ? wp_get_attachment_url( $qi_book_pdf_id ) : '';
    ?>

    <main id="site-content" class="site-content container" role="main">
        <article id="book-<?php the_ID(); ?>" <?php post_class( 'qi-single-book' ); ?>>
            <p class="qi-single-book__back qi-single-book__back--top">
                <a href="<?php echo esc_url( home_url( '/books/' ) ); ?>">&larr; <?php esc_html_e( 'Back to Books', 'queer-ink-theme' ); ?></a>
            </p>
            <div class="qi-single-book__layout">
                <div class="qi-single-book__cover">
                    <?php if ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'medium_large', array( 'class' => 'qi-single-book__cover-img' ) ); ?>
                    <?php else : ?>
                        <span class="qi-single-book__cover-placeholder" aria-hidden="true"></span>
                    <?php endif; ?>

                    <?php if ( $qi_book_pdf_url ) : ?>
                        <a class="button button--primary qi-single-book__download" href="<?php echo esc_url( $qi_book_pdf_url ); ?>" target="_blank" rel="noopener">
                            <?php esc_html_e( 'Download PDF', 'queer-ink-theme' ); ?>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="qi-single-book__body">
                    <header class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>

                        <?php if ( $qi_book_authors && ! is_wp_error( $qi_book_authors ) ) : ?>
                            <p class="qi-single-book__authors">
                                <?php esc_html_e( 'By', 'queer-ink-theme' ); ?>
                                <?php
                                $qi_book_author_links = array();
                                foreach ( $qi_book_authors as $qi_book_author ) {
                                    $qi_book_author_links[] = '<a href="' . esc_url( get_term_link( $qi_book_author ) ) . '">' . esc_html( $qi_book_author->name ) . '</a>';
                                }
                                echo wp_kses_post( implode( ', ', $qi_book_author_links ) );
                                ?>
                            </p>
                        <?php endif; ?>

                        <?php if ( ( $qi_book_subjects && ! is_wp_error( $qi_book_subjects ) ) || ( $qi_book_language && ! is_wp_error( $qi_book_language ) ) ) : ?>
                            <p class="qi-single-book__meta">
                                <?php if ( $qi_book_subjects && ! is_wp_error( $qi_book_subjects ) ) : ?>
                                    <?php foreach ( $qi_book_subjects as $qi_book_subject ) : ?>
                                        <a class="qi-single-book__tag" href="<?php echo esc_url( get_term_link( $qi_book_subject ) ); ?>"><?php echo esc_html( $qi_book_subject->name ); ?></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if ( $qi_book_language && ! is_wp_error( $qi_book_language ) ) : ?>
                                    <?php foreach ( $qi_book_language as $qi_book_lang ) : ?>
                                        <a class="qi-single-book__tag qi-single-book__tag--language" href="<?php echo esc_url( get_term_link( $qi_book_lang ) ); ?>"><?php echo esc_html( $qi_book_lang->name ); ?></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </p>
                        <?php endif; ?>
                    </header>

                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </article>
    </main>

    <?php
endwhile;

get_footer();
