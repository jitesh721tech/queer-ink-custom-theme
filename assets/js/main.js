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

    // ---------------- Homepage: feature strip zoom-in entrance ----------------
    // The 4-icon "feature strip" section (2nd section on the homepage) zooms
    // in from a slightly larger scale with a fade as it enters the viewport.
    // One-shot: the observer disconnects after the first trigger so it never
    // replays on scroll-back. See assets/css/feature-strip.css for the actual
    // animation (`is-in-view` class); prefers-reduced-motion is handled there.
    var featureStrip = document.querySelector( '.feature-strip' );

    if ( featureStrip ) {
        var prefersReducedMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

        if ( ! prefersReducedMotion && 'IntersectionObserver' in window ) {
            var featureStripObserver = new IntersectionObserver( function ( entries, observer ) {
                entries.forEach( function ( entry ) {
                    if ( entry.isIntersecting ) {
                        featureStrip.classList.add( 'is-in-view' );
                        observer.unobserve( entry.target );
                    }
                } );
            }, { threshold: 0.2 } );

            featureStripObserver.observe( featureStrip );
        } else {
            featureStrip.classList.add( 'is-in-view' );
        }
    }

    // ---------------- Site-wide scroll reveal: zoom / left-reveal / mask ----------------
    // Same one-shot IntersectionObserver pattern as the feature-strip block
    // above, generalized to the additional sections/elements from the
    // entrance-animation spec. See assets/css/animations.css for the actual
    // keyframes (`is-in-view` per element); reduced motion is handled there
    // too and mirrored here so unsupported browsers reveal instantly either way.
    var qiPrefersReducedMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

    function qiInitScrollReveal( selectors ) {
        var elements = [];
        selectors.forEach( function ( selector ) {
            document.querySelectorAll( selector ).forEach( function ( el ) {
                elements.push( el );
            } );
        } );

        if ( ! elements.length ) {
            return;
        }

        if ( qiPrefersReducedMotion || ! ( 'IntersectionObserver' in window ) ) {
            elements.forEach( function ( el ) {
                el.classList.add( 'is-in-view' );
            } );
            return;
        }

        var observer = new IntersectionObserver( function ( entries, obs ) {
            entries.forEach( function ( entry ) {
                if ( entry.isIntersecting ) {
                    entry.target.classList.add( 'is-in-view' );
                    obs.unobserve( entry.target );
                }
            } );
        }, { threshold: 0.15 } );

        elements.forEach( function ( el ) {
            observer.observe( el );
        } );
    }

    // Animation 1 — zoom + fade, whole section as one unit.
    qiInitScrollReveal( [
        '.channel-band',
        '.qi-archives-band',
        '.qi-pathway-band',
        '.qi-cta-band',
        '.qi-why-archive',
        '.qi-model',
        '.qi-dl-pillars',
        '.qi-reading-room',
        '.qi-dl-tagline',
        '.qi-journal-cta',
        '.qi-about-info-row',
        '.qi-connect-form',
        '.qi-connect-info',
        '.qi-connect-together',
    ] );

    // Animation 2 — left-to-right reveal, Publishing "Beyond the Book /
    // From Book to Archive / Why Queer Ink?" cards (staggered via CSS nth-child).
    qiInitScrollReveal( [ '.qi-info-columns' ] );

    // Animation 3 — bottom-to-top mask reveal, About page.
    qiInitScrollReveal( [
        '.qi-about-wwd__intro p',
        '.qi-about-wwd__grid',
        '.qi-about-why__quote',
        '.qi-about-founder__card',
        '.qi-about-founder__more',
    ] );

    // Animation 4 — hero zoom + fade, left content + right visual
    // (staggered via CSS animation-delay). '.hero' is the homepage-only
    // hero; '.qi-pub-hero' is the shared hero group reused by Publishing,
    // Archiving, Digital Library, QI Journal, About and Connect.
    qiInitScrollReveal( [ '.hero', '.qi-pub-hero' ] );

    // ---------------- Sitemap: smart Back button ----------------
    // The Sitemap page's .qi-page-back link is reachable from every page
    // (footer), so unlike the other .qi-page-back usages (Subjects, Our
    // Principles, About QI Journal — untouched, no data attribute) it
    // can't hard-code a single "parent" page. Its href already points to
    // Home as a safe fallback for direct visits/new tabs/no-JS; here we
    // prefer real browser history when there is somewhere to go back to.
    var smartBackLink = document.querySelector( '[data-qi-smart-back]' );

    if ( smartBackLink ) {
        smartBackLink.addEventListener( 'click', function ( event ) {
            if ( window.history.length > 1 ) {
                event.preventDefault();
                window.history.back();
            }
        } );
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
        var searchForm = document.querySelector( '[data-qi-journal-search]' );
        var searchInput = searchForm ? searchForm.querySelector( 'input[type="search"]' ) : null;

        var qiFilters = { section: '', topic: '', search: '' };
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
            body.set( 'search', qiFilters.search );

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

        // Searches Articles only — qi_load_articles (inc/ajax.php) hardcodes
        // post_type=qi_article, so this can never surface Books, Pages,
        // Timelines or Collections. Combines with whatever section/topic
        // filter is already active instead of resetting it.
        if ( searchForm && searchInput ) {
            searchForm.addEventListener( 'submit', function ( event ) {
                event.preventDefault();
                qiFilters.search = searchInput.value.trim();
                fetchArticles();
            } );
        }
    }

    // ---------------- Connect form: client-side validation ----------------
    // Same 3 rules as the server-side check in
    // queer_ink_handle_contact_form_submission() (inc/shortcodes.php) —
    // the server re-checks everything regardless, so this only ever
    // saves a visitor a round trip and gives a clearer message than the
    // browser's own generic one; it never replaces the server check.
    //
    // Uses the native Constraint Validation API (setCustomValidity)
    // rather than a submit handler: name/tel already get a pattern=""
    // attribute and email a type="email" one (inc/shortcodes.php), so
    // the browser already blocks submission on a mismatch and shows its
    // own bubble UI — this only swaps that bubble's text for our
    // clearer wording. Empty *required* fields are untouched here
    // (validity.patternMismatch/typeMismatch are false for an empty
    // value), so the browser's existing native "required" message and
    // behavior keeps working exactly as before.
    var qiValidateMessages = {
        name: 'Please enter a valid name (letters only).',
        email: 'Please enter a valid email address.',
        tel: 'Please enter a valid mobile number (10-12 digits only).',
    };

    document.querySelectorAll( '[data-qi-validate]' ).forEach( function ( field ) {
        var message = qiValidateMessages[ field.getAttribute( 'data-qi-validate' ) ];
        if ( ! message ) {
            return;
        }

        var updateValidity = function () {
            var invalidFormat = field.validity.patternMismatch || field.validity.typeMismatch;
            field.setCustomValidity( invalidFormat ? message : '' );
        };

        field.addEventListener( 'input', updateValidity );
        field.addEventListener( 'invalid', updateValidity );
    } );
})();
