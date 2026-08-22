/**
 * Queer Ink Theme main JavaScript.
 *
 * @package Queer_Ink_Theme
 */

(function () {
    'use strict';

    document.documentElement.classList.remove( 'no-js' );
    document.documentElement.classList.add( 'js' );

    var siteHeader = document.querySelector( '.site-header' );

    if ( siteHeader ) {
        var updateHeaderScrolled = function () {
            siteHeader.classList.toggle( 'is-scrolled', window.scrollY > 4 );
        };

        updateHeaderScrolled();
        window.addEventListener( 'scroll', updateHeaderScrolled, { passive: true } );
    }

    var toggle = document.querySelector( '.menu-toggle' );
    var nav = document.querySelector( '.primary-navigation' );

    if ( ! toggle || ! nav ) {
        return;
    }

    function closeMenu() {
        nav.classList.remove( 'is-open' );
        toggle.setAttribute( 'aria-expanded', 'false' );
    }

    function toggleMenu() {
        var isOpen = nav.classList.toggle( 'is-open' );
        toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
    }

    toggle.addEventListener( 'click', toggleMenu );

    nav.querySelectorAll( '.primary-menu a' ).forEach( function ( link ) {
        link.addEventListener( 'click', closeMenu );
    } );

    document.addEventListener( 'keydown', function ( event ) {
        if ( event.key === 'Escape' ) {
            closeMenu();
        }
    } );

    document.addEventListener( 'click', function ( event ) {
        if ( nav.classList.contains( 'is-open' ) && ! nav.contains( event.target ) ) {
            closeMenu();
        }
    } );

    document.querySelectorAll( '[data-scroll-prev], [data-scroll-next]' ).forEach( function ( button ) {
        var scroller = button.parentElement.querySelector( '[data-scroller]' );

        if ( ! scroller ) {
            return;
        }

        button.addEventListener( 'click', function () {
            var amount = scroller.clientWidth * 0.8;
            scroller.scrollBy( {
                left: button.hasAttribute( 'data-scroll-prev' ) ? -amount : amount,
                behavior: 'smooth',
            } );
        } );
    } );

    var searchToggle = document.querySelector( '.header-search' );
    var searchPanel = document.querySelector( '.header-search-panel' );

    if ( searchToggle && searchPanel ) {
        var searchInput = searchPanel.querySelector( 'input[type="search"]' );

        var closeSearch = function () {
            searchPanel.hidden = true;
            searchToggle.setAttribute( 'aria-expanded', 'false' );
        };

        var openSearch = function () {
            searchPanel.hidden = false;

            var toggleRect = searchToggle.getBoundingClientRect();
            var panelWidth = searchPanel.offsetWidth;
            var spaceRight = window.innerWidth - toggleRect.right;

            if ( spaceRight >= panelWidth + 24 ) {
                searchPanel.classList.add( 'header-search-panel--right' );
            } else {
                searchPanel.classList.remove( 'header-search-panel--right' );
            }

            searchToggle.setAttribute( 'aria-expanded', 'true' );
            if ( searchInput ) {
                searchInput.focus();
            }
        };

        searchToggle.addEventListener( 'click', function ( event ) {
            event.stopPropagation();
            if ( searchPanel.hidden ) {
                openSearch();
            } else {
                closeSearch();
            }
        } );

        document.addEventListener( 'keydown', function ( event ) {
            if ( event.key === 'Escape' && ! searchPanel.hidden ) {
                closeSearch();
                searchToggle.focus();
            }
        } );

        document.addEventListener( 'click', function ( event ) {
            if ( ! searchPanel.hidden && ! searchPanel.contains( event.target ) && event.target !== searchToggle ) {
                closeSearch();
            }
        } );
    }

    // ---------------- QI Journal: category/topic filtering ----------------
    // Section tabs, popular-topics links and the topic dropdown share one
    // AJAX action (qi_load_articles, see inc/ajax.php) so the visitor never
    // leaves /qi-journal/ and cards always render through the same
    // content-qi_article.php partial as the first page. "View All Articles"
    // (replacing the old Load More button) is a plain link to /journal/,
    // so it needs no JS.
    var journalGrid = document.querySelector( '.qi-journal-main .publishing-grid--current-list' );

    if ( journalGrid && window.qiJournalAjax ) {
        var sectionTabs = document.querySelectorAll( '.qi-section-tab[data-filter-section]' );
        var topicLinks = document.querySelectorAll( '.qi-topics-list a[data-filter-topic]' );
        var topicSelect = document.querySelector( '.qi-topics-select[data-nav-select]' );

        var qiFilters = { section: '', topic: '' };
        var qiBusy = false;

        var setActiveTab = function ( sectionSlug ) {
            sectionTabs.forEach( function ( tab ) {
                tab.classList.toggle( 'is-active', tab.getAttribute( 'data-filter-section' ) === sectionSlug );
            } );
        };

        var fetchArticles = function () {
            if ( qiBusy ) {
                return;
            }
            qiBusy = true;

            journalGrid.setAttribute( 'aria-busy', 'true' );
            journalGrid.style.opacity = '0.5';

            var body = new URLSearchParams();
            body.set( 'action', 'qi_load_articles' );
            body.set( 'nonce', window.qiJournalAjax.nonce );
            body.set( 'paged', '1' );
            body.set( 'section', qiFilters.section );
            body.set( 'topic', qiFilters.topic );

            fetch( window.qiJournalAjax.url, {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: body.toString(),
            } )
                .then( function ( response ) {
                    return response.json();
                } )
                .then( function ( response ) {
                    if ( ! response || ! response.success ) {
                        throw new Error( 'qi_load_articles failed' );
                    }

                    var data = response.data;
                    journalGrid.innerHTML = data.html;

                    if ( ! data.found ) {
                        journalGrid.innerHTML = '<p class="publishing-empty">No articles found.</p>';
                    }
                } )
                .catch( function () {
                    // Filters fail silently — the grid just keeps its
                    // previous results rather than showing a stray message.
                } )
                .finally( function () {
                    qiBusy = false;
                    journalGrid.removeAttribute( 'aria-busy' );
                    journalGrid.style.opacity = '';
                } );
        };

        sectionTabs.forEach( function ( tab ) {
            tab.addEventListener( 'click', function ( event ) {
                event.preventDefault();
                qiFilters.section = tab.getAttribute( 'data-filter-section' ) || '';
                qiFilters.topic = '';
                if ( topicSelect ) {
                    topicSelect.value = '';
                }
                setActiveTab( qiFilters.section );
                fetchArticles();
            } );
        } );

        topicLinks.forEach( function ( link ) {
            link.addEventListener( 'click', function ( event ) {
                event.preventDefault();
                qiFilters.topic = link.getAttribute( 'data-filter-topic' ) || '';
                qiFilters.section = '';
                setActiveTab( '' );
                if ( topicSelect ) {
                    topicSelect.value = link.getAttribute( 'href' );
                }
                fetchArticles();
            } );
        } );

        if ( topicSelect ) {
            topicSelect.addEventListener( 'change', function () {
                var selectedOption = topicSelect.options[ topicSelect.selectedIndex ];
                qiFilters.topic = selectedOption ? ( selectedOption.getAttribute( 'data-filter-topic' ) || '' ) : '';
                qiFilters.section = '';
                setActiveTab( '' );
                fetchArticles();
            } );
        }
    }
})();
