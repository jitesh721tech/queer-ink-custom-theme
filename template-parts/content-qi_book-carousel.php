<?php
/**
 * Book card template for the horizontal book-list carousel — shared by
 * the Publishing page's "Our Current List" and the Digital Library's
 * "Featured Books" (both use [qi_latest_books layout="carousel"]), so
 * changes here apply everywhere this carousel is reused.
 *
 * @package Queer_Ink_Theme
 */
?>
<article id="book-carousel-<?php the_ID(); ?>" <?php post_class( 'qi-book-carousel__item' ); ?>>
    <a class="qi-book-carousel__cover-link" href="<?php the_permalink(); ?>">
        <div class="qi-book-carousel__cover">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'medium', array( 'class' => 'qi-book-carousel__cover-img' ) ); ?>
            <?php else : ?>
                <span class="qi-book-carousel__cover-placeholder" aria-hidden="true"></span>
            <?php endif; ?>
        </div>
    </a>
    <div class="qi-book-carousel__body">
        <?php
        $qi_carousel_subjects = get_the_terms( get_the_ID(), 'qi_subject' );
        if ( $qi_carousel_subjects && ! is_wp_error( $qi_carousel_subjects ) ) :
            ?>
            <span class="qi-book-carousel__tag"><?php echo esc_html( $qi_carousel_subjects[0]->name ); ?></span>
        <?php endif; ?>
        <h3 class="qi-book-carousel__title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <?php
        $qi_carousel_authors = get_the_terms( get_the_ID(), 'qi_book_author' );
        if ( $qi_carousel_authors && ! is_wp_error( $qi_carousel_authors ) ) :
            ?>
            <p class="qi-book-carousel__author">
                <?php esc_html_e( 'By:', 'queer-ink-theme' ); ?>
                <?php
                $qi_carousel_author_links = array();
                foreach ( $qi_carousel_authors as $qi_carousel_author ) {
                    $qi_carousel_author_links[] = '<a href="' . esc_url( get_term_link( $qi_carousel_author ) ) . '">' . esc_html( $qi_carousel_author->name ) . '</a>';
                }
                echo wp_kses_post( implode( ', ', $qi_carousel_author_links ) );
                ?>
            </p>
        <?php endif; ?>
    </div>
</article>
