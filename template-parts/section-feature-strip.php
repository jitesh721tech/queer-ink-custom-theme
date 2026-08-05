<?php
/**
 * Feature strip section template part.
 *
 * @package Queer_Ink_Theme
 */

$feature_items = array(
    array(
        'icon'        => 'archive',
        'title'       => esc_html__( 'Publishing', 'queer-ink-theme' ),
        'description' => esc_html__( 'Latest essays, books, and limited editions from queer archives.', 'queer-ink-theme' ),
        'url'         => esc_url( home_url( '/publishing' ) ),
        'label'       => esc_html__( 'Learn more', 'queer-ink-theme' ),
    ),
    array(
        'icon'        => 'library',
        'title'       => esc_html__( 'Archiving', 'queer-ink-theme' ),
        'description' => esc_html__( 'Curated collections documenting protest, care, and community labor.', 'queer-ink-theme' ),
        'url'         => esc_url( home_url( '/archiving' ) ),
        'label'       => esc_html__( 'Learn more', 'queer-ink-theme' ),
    ),
    array(
        'icon'        => 'digital',
        'title'       => esc_html__( 'Digital Library', 'queer-ink-theme' ),
        'description' => esc_html__( 'Access searchable records, scanned media, and editorial essays.', 'queer-ink-theme' ),
        'url'         => esc_url( home_url( '/digital-library' ) ),
        'label'       => esc_html__( 'Explore library', 'queer-ink-theme' ),
    ),
    array(
        'icon'        => 'journal',
        'title'       => esc_html__( 'QI Journal', 'queer-ink-theme' ),
        'description' => esc_html__( 'A living archive of commentary, research, and queer cultural criticism.', 'queer-ink-theme' ),
        'url'         => esc_url( home_url( '/journal' ) ),
        'label'       => esc_html__( 'Read journal', 'queer-ink-theme' ),
    ),
);
?>

<section class="feature-strip">
    <div class="feature-strip__inner">
        <div class="feature-strip__grid">
            <?php foreach ( $feature_items as $item ) : ?>
                <article class="feature-card" aria-label="<?php echo esc_attr( $item['title'] ); ?>">
                    <div class="feature-card__media">
                        <?php
                        // Map logical icon slugs to actual image filenames when needed
                        $raster_map = array(
                            'archive' => 'assets/images/sections/publishing.png',
                            'library' => 'assets/images/sections/archiving.png',
                            'digital' => 'assets/images/sections/digital_library.png',
                            'journal' => 'assets/images/sections/qi_journal.png',
                        );

                        $mapped = '';
                        if ( isset( $raster_map[ $item['icon'] ] ) ) {
                            $mapped = $raster_map[ $item['icon'] ];
                        }

                        if ( $mapped && file_exists( get_theme_file_path( $mapped ) ) ) : ?>
                            <img class="feature-card__media-img" src="<?php echo esc_url( get_theme_file_uri( $mapped ) ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?> image" />
                        <?php else :
                            $raster_path = 'assets/images/sections/' . $item['icon'] . '.png';
                            if ( file_exists( get_theme_file_path( $raster_path ) ) ) : ?>
                                <img class="feature-card__media-img" src="<?php echo esc_url( get_theme_file_uri( $raster_path ) ); ?>" alt="<?php echo esc_attr( $item['title'] ); ?> image" />
                            <?php else :
                                $icon_filename = 'assets/icons/' . $item['icon'] . '.svg';
                                if ( file_exists( get_theme_file_path( $icon_filename ) ) ) : ?>
                                    <img class="feature-card__media-img" src="<?php echo esc_url( get_theme_file_uri( $icon_filename ) ); ?>" alt="" aria-hidden="true" />
                                <?php else : ?>
                                    <span class="feature-card__icon-label feature-card__icon-label--<?php echo esc_attr( $item['icon'] ); ?>"></span>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="feature-card__body">
                        <h3 class="feature-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
                        <p class="feature-card__text"><?php echo esc_html( $item['description'] ); ?></p>
                        <a class="feature-card__link" href="<?php echo esc_url( $item['url'] ); ?>"><?php echo esc_html( $item['label'] ); ?> <span aria-hidden="true">→</span></a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
