/**
 * Queer Ink Theme main JavaScript.
 *
 * @package Queer_Ink_Theme
 */

(function () {
    'use strict';

    // ---------------- Entrance animations: progressive enhancement ----------------
    // Every entrance animation works by hiding content with `.js .selector
    // { opacity: 0 }` in CSS (see feature-strip.css / animations.css) until
    // JS adds `is-in-view`. On a slow/loaded host (seen in production on
    // TasteWP, not reproducible on localhost) this used to fail two ways:
    //
    //   1. `.js` was added to <html> *unconditionally*, as the very first
    //      thing this file did — so CSS started hiding every section
    //      immediately, before a single IntersectionObserver had actually
    //      been attached. Any error, slow script evaluation, or the
    //      browser simply not getting around to running the observer setup
    //      in time left content sitting at opacity:0 with nothing ever
    //      going to reveal it.
    //   2. The one safety net that existed (qiForceRevealAll(), below) only
    //      ran a fixed delay *after* the "load" event — which slow/ad- or
    //      tracker-heavy hosting can delay far longer than a visitor will
    //      wait, or which can be blocked from firing at all by a single
    //      slow third-party resource.
    //
    // Fixed by flipping the guarantee around: `.js` (the class every hide
    // rule in CSS is scoped under) is now added only at the very end of the
    // try block below, *after* every observer has been attached — see that
    // line for the full reasoning. Content is visible by default and JS is
    // never required for it to be visible; JS only ever adds a temporary,
    // already-covered-by-a-real-observer hidden state, never the other way
    // around. The two extra safety nets below (an immediate, "load"-
    // independent timer, and a bfcache/"pageshow" handler) then guarantee
    // that even a successfully-hidden section can't stay that way forever
    // if its own observer never fires (e.g. throttled/backgrounded tabs) or
    // the page is restored from cache mid-animation.
    var qiRevealSelectors = [
        '.feature-strip',
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
        '.qi-info-columns',
        '.qi-about-wwd__intro p',
        '.qi-about-wwd__grid',
        '.qi-about-why__quote',
        '.qi-about-founder__card',
        '.qi-about-founder__more',
        '.hero',
        '.qi-pub-hero',
    ];

    // Unconditional — every matching element gets `is-in-view` regardless
    // of scroll position. Reserved for the truly-last-resort cases below
    // (bfcache restore, a setup error) where something has gone wrong
    // enough that showing content out of its normal scroll-triggered order
    // is clearly better than leaving it hidden.
    function qiForceRevealAll() {
        qiRevealSelectors.forEach( function ( selector ) {
            document.querySelectorAll( selector ).forEach( function ( el ) {
                el.classList.add( 'is-in-view' );
            } );
        } );
    }

    function qiIsInViewport( el ) {
        var rect = el.getBoundingClientRect();
        return rect.bottom > 0 && rect.right > 0 &&
            rect.top < ( window.innerHeight || document.documentElement.clientHeight ) &&
            rect.left < ( window.innerWidth || document.documentElement.clientWidth );
    }

    // Reveals only elements that are *currently on screen* and still
    // hidden — unlike qiForceRevealAll() above, this never spoils the
    // scroll-triggered animation for a section further down the page the
    // visitor hasn't scrolled to yet (an earlier version of this fix used
    // a single blanket timeout instead, which — verified against a real
    // page load — reveals every section, seen or not, the moment it fires,
    // defeating the animation for anyone who takes a few seconds to start
    // scrolling). Only ever *adds* the class, so it's always safe to call
    // repeatedly.
    function qiRevealVisibleStuck() {
        qiRevealSelectors.forEach( function ( selector ) {
            document.querySelectorAll( selector ).forEach( function ( el ) {
                if ( ! el.classList.contains( 'is-in-view' ) && qiIsInViewport( el ) ) {
                    el.classList.add( 'is-in-view' );
                }
            } );
        } );
    }

    // Catches the residual failure this fix's move of `.js` to only load
    // after every observer is attached (see the try block below) doesn't:
    // an observer that *is* attached but whose callback never arrives for
    // some element (e.g. background-tab timer/observer throttling). Counts
    // from script execution, not "load" (which waits for every image/font/
    // third-party script and can be delayed far longer on slow hosting, or
    // blocked entirely by one hanging request) — an early check plus a
    // later one covers both "was already visible when JS ran" and "still
    // hadn't been revealed a few seconds in". A throttled scroll listener
    // then keeps checking for as long as the visitor keeps scrolling, so a
    // section whose own observer never fires still reveals itself the
    // moment it's actually scrolled into view, instead of only being
    // caught by one fixed-time check.
    setTimeout( qiRevealVisibleStuck, 1200 );
    setTimeout( qiRevealVisibleStuck, 4000 );

    var qiScrollCheckPending = false;
    window.addEventListener( 'scroll', function () {
        if ( qiScrollCheckPending ) {
            return;
        }
        qiScrollCheckPending = true;
        ( window.requestAnimationFrame || window.setTimeout )( function () {
            qiScrollCheckPending = false;
            qiRevealVisibleStuck();
        } );
    }, { passive: true } );

    // A back-forward-cache restore (visitor taps the browser's Back
    // button) does not re-run this script, but does fire "pageshow" with
    // event.persisted true — force a reveal so a page frozen mid-animation
    // before being cached can never come back from the cache still
    // showing hidden sections. Unlike the checks above, this one really
    // does reveal everything unconditionally: a bfcache restore drops the
    // visitor back exactly where they were, including anywhere they'd
    // already scrolled past, so there's no "hasn't seen it yet" case to
    // preserve here the way there is on a fresh page load.
    window.addEventListener( 'pageshow', function ( event ) {
        if ( event.persisted ) {
            qiForceRevealAll();
        }
    } );

    try {
        var siteHeader = document.querySelector( '.site-header' );

        if ( siteHeader ) {
            var updateHeaderScrolled = function () {
                siteHeader.classList.toggle( 'is-scrolled', window.scrollY > 4 );
            };

            updateHeaderScrolled();
            window.addEventListener( 'scroll', updateHeaderScrolled, { passive: true } );
        }
    } catch ( headerError ) {
        // Non-visibility-critical — no forced reveal needed here.
    }

    try {
        // ---------------- Homepage: feature strip zoom-in entrance ----------------
        // The 4-icon "feature strip" section (2nd section on the homepage) zooms
        // in from a slightly larger scale with a fade as it enters the viewport.
        // One-shot: the observer disconnects after the first trigger so it never
        // replays on scroll-back. See assets/css/feature-strip.css for the actual
        // animation (`is-in-view` class); prefers-reduced-motion is handled there.
        var featureStrip = document.querySelector( '.feature-strip' );

        if ( featureStrip ) {
            var prefersReducedMotion = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

            if ( qiIsInViewport( featureStrip ) ) {
                featureStrip.classList.add( 'is-in-view' );
            } else if ( ! prefersReducedMotion && 'IntersectionObserver' in window ) {
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

        var qiInitScrollReveal = function ( selectors ) {
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
                if ( qiIsInViewport( el ) ) {
                    el.classList.add( 'is-in-view' );
                } else {
                    observer.observe( el );
                }
            } );
        };

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

        // Only now — every observer above is already attached (or its
        // synchronous no-observer-needed fallback already ran) — do we let
        // the `.js`-scoped hide rules in animations.css/feature-strip.css
        // start hiding anything. If any statement above throws, execution
        // never reaches this line, `.js` is never added, and every section
        // simply stays at its plain, visible-by-default state instead of
        // being left hidden with nothing left to reveal it.
        document.documentElement.classList.remove( 'no-js' );
        document.documentElement.classList.add( 'js' );
    } catch ( animationError ) {
        // `.js` was never reached above, so nothing was hidden — this is
        // defense-in-depth only, in case any earlier line partially ran.
        qiForceRevealAll();
    }

    try {
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
    } catch ( backButtonError ) {
        // Non-visibility-critical.
    }

    try {
        // ---------------- About: mobile founder "Read More" ----------------
        // Mobile only (see about.css) — .qi-about-founder__desc is clamped to
        // ~3 lines and .qi-about-founder__more stays hidden until expanded.
        // Desktop/tablet never render the button (about.css hides it), so
        // this is a no-op there even though the listener is always attached.
        var founderToggle = document.querySelector( '.qi-about-founder__toggle' );
        var founderSection = founderToggle ? founderToggle.closest( '.qi-about-founder' ) : null;

        if ( founderToggle && founderSection ) {
            founderToggle.addEventListener( 'click', function () {
                var isExpanded = founderSection.classList.toggle( 'is-expanded' );
                founderToggle.setAttribute( 'aria-expanded', isExpanded ? 'true' : 'false' );
                founderToggle.textContent = isExpanded ? 'Read Less' : 'Read More';
            } );
        }
    } catch ( founderToggleError ) {
        // Non-visibility-critical.
    }

    try {
        var toggle = document.querySelector( '.menu-toggle' );
        var nav = document.querySelector( '.primary-navigation' );

        if ( toggle && nav ) {
            var closeMenu = function () {
                nav.classList.remove( 'is-open' );
                toggle.setAttribute( 'aria-expanded', 'false' );
            };

            var toggleMenu = function () {
                var isOpen = nav.classList.toggle( 'is-open' );
                toggle.setAttribute( 'aria-expanded', isOpen ? 'true' : 'false' );
            };

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
        }
    } catch ( menuError ) {
        // Non-visibility-critical.
    }

    try {
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
    } catch ( scrollButtonError ) {
        // Non-visibility-critical.
    }

    try {
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
    } catch ( searchError ) {
        // Non-visibility-critical.
    }

    try {
        // ---------------- QI Journal: category/topic filtering ----------------
        // Section tabs, popular-topics links and the topic dropdown share one
        // AJAX action (qi_load_articles, see inc/ajax.php) so the visitor never
        // leaves /qi-journal/ and cards always render through the same
        // content-qi_article.php partial as the first page. "View All Articles"
        // stays in sync with whichever category is active: each tab already
        // carries its own real term-archive href (queer_ink_article_sections_
        // shortcode, inc/shortcodes.php) — including "Latest", which links to
        // the plain /journal/ archive — so copying the active tab's href onto
        // this link is enough to make it open that category (and only that
        // category) with no new PHP/taxonomy data needed. It's also hidden
        // whenever the current filter has 6 or fewer matches (data.has_more,
        // already computed server-side from the same query), since there's
        // nothing more to see beyond the cards already showing.
        var journalGrid = document.querySelector( '.qi-journal-main .publishing-grid--current-list' );
        var qiViewAllWrap = document.querySelector( '.qi-journal-load-more' );
        var qiViewAllLink = qiViewAllWrap ? qiViewAllWrap.querySelector( 'a' ) : null;

        if ( journalGrid && window.qiJournalAjax ) {
            var sectionTabs = document.querySelectorAll( '.qi-section-tab[data-filter-section]' );
            var topicLinks = document.querySelectorAll( '.qi-topics-list a[data-filter-topic]' );
            var topicSelect = document.querySelector( '.qi-topics-select[data-nav-select]' );
            var searchForm = document.querySelector( '[data-qi-journal-search]' );
            var journalSearchInput = searchForm ? searchForm.querySelector( 'input[type="search"]' ) : null;

            var qiFilters = { section: '', topic: '', search: '' };
            var qiBusy = false;

            var setActiveTab = function ( sectionSlug ) {
                sectionTabs.forEach( function ( tab ) {
                    var isActive = tab.getAttribute( 'data-filter-section' ) === sectionSlug;
                    tab.classList.toggle( 'is-active', isActive );
                    if ( isActive && qiViewAllLink ) {
                        qiViewAllLink.setAttribute( 'href', tab.getAttribute( 'href' ) );
                    }
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

                        if ( qiViewAllWrap ) {
                            qiViewAllWrap.hidden = ! data.has_more;
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
            if ( searchForm && journalSearchInput ) {
                searchForm.addEventListener( 'submit', function ( event ) {
                    event.preventDefault();
                    qiFilters.search = journalSearchInput.value.trim();
                    fetchArticles();
                } );
            }
        }
    } catch ( journalError ) {
        // Non-visibility-critical.
    }

    try {
        // ---------------- Connect form: client-side validation ----------------
        // Mirrors the server-side checks in
        // queer_ink_handle_contact_form_submission() (inc/shortcodes.php) —
        // the server re-checks everything regardless, so this only ever
        // saves a visitor a round trip and gives a clearer message than the
        // browser's own generic one; it never replaces the server check.
        //
        // Uses the native Constraint Validation API (setCustomValidity)
        // rather than a submit handler: name still gets a pattern="" and
        // email a type="email" one (inc/shortcodes.php), so the browser
        // already blocks submission on a mismatch and shows its own bubble
        // UI — this only swaps that bubble's text for our clearer wording.
        // Empty *required* fields are untouched here
        // (validity.patternMismatch/typeMismatch are false for an empty
        // value), so the browser's existing native "required" message and
        // behavior keeps working exactly as before. Mobile Number no
        // longer has a single fixed pattern (its valid length depends on
        // the paired country-code <select>), so it's excluded from this
        // message map and handled by the real-time digit filter below
        // instead, which never lets an out-of-range value be typed in the
        // first place.
        var qiValidateMessages = {
            name: 'Please enter a valid name (letters only).',
            email: 'Please enter a valid email address.',
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

        // Your Name: block digits/symbols as they're typed (not just flag
        // them on submit) — same allowed set as the server (letters,
        // spaces, apostrophes, hyphens, periods).
        document.querySelectorAll( 'input[data-qi-validate="name"]' ).forEach( function ( field ) {
            field.addEventListener( 'input', function () {
                var cleaned = field.value.replace( /[^A-Za-zÀ-ÖØ-öø-ÿ\s'.-]/g, '' );
                if ( cleaned !== field.value ) {
                    field.value = cleaned;
                }
            } );
        } );

        // Mobile Number: the paired country-code <select> decides how many
        // digits are valid (qiContactCountryDigits is localized from the
        // same list the server validates against —
        // queer_ink_contact_country_codes(), inc/shortcodes.php via
        // functions.php) — non-digits are stripped and the value is
        // truncated to that country's length on every keystroke, so more
        // digits than the selected country allows can never be entered.
        document.querySelectorAll( '[data-qi-tel-input]' ).forEach( function ( field ) {
            var wrapper       = field.closest( '.qi-connect-form__tel' );
            var countrySelect = wrapper ? wrapper.querySelector( '[data-qi-country-select]' ) : null;
            var digitLengths  = window.qiContactCountryDigits || {};

            var maxDigitsFor = function () {
                if ( countrySelect && digitLengths[ countrySelect.value ] ) {
                    return digitLengths[ countrySelect.value ];
                }
                return 15; // Fallback cap only if the list ever fails to load.
            };

            var enforce = function () {
                var max        = maxDigitsFor();
                field.maxLength = max;
                var digitsOnly = field.value.replace( /\D/g, '' ).slice( 0, max );
                if ( digitsOnly !== field.value ) {
                    field.value = digitsOnly;
                }
            };

            enforce();
            field.addEventListener( 'input', enforce );
            if ( countrySelect ) {
                countrySelect.addEventListener( 'change', enforce );
            }
        } );

        // Mobile Number country code: show just the dialing code (e.g. "+91")
        // once the <select> is closed, on every viewport — a native <select>
        // always mirrors its selected <option>'s own text in the closed box,
        // so the only way to show something different there than in the open
        // list is to rewrite that option's actual text (not a CSS overlay)
        // right before/after it's shown. Same option list and value either
        // way, so validation/submission (queer_ink_contact_country_codes(),
        // inc/shortcodes.php) is untouched.
        document.querySelectorAll( '[data-qi-country-select]' ).forEach( function ( select ) {
            Array.prototype.forEach.call( select.options, function ( option ) {
                option.dataset.qiFullLabel = option.textContent;
            } );

            var showFullLabels = function () {
                Array.prototype.forEach.call( select.options, function ( option ) {
                    option.textContent = option.dataset.qiFullLabel;
                } );
            };

            var showCodeOnly = function () {
                var selected = select.options[ select.selectedIndex ];
                if ( selected && selected.getAttribute( 'data-code' ) ) {
                    selected.textContent = selected.getAttribute( 'data-code' );
                }
            };

            showCodeOnly();

            select.addEventListener( 'mousedown', showFullLabels );
            select.addEventListener( 'focus', showFullLabels );
            select.addEventListener( 'change', function () {
                showFullLabels();
                showCodeOnly();
            } );
            select.addEventListener( 'blur', showCodeOnly );
        } );
    } catch ( formValidationError ) {
        // Non-visibility-critical.
    }

    try {
        // ---------------- Connect form: success popup ----------------
        // Server-rendered only on ?qi_contact=success
        // (queer_ink_contact_form_shortcode(), inc/shortcodes.php) — this
        // just wires its close button and an auto-dismiss timer, and
        // tidies the URL so a manual page refresh doesn't keep re-showing
        // the same popup.
        var qiPopup = document.querySelector( '[data-qi-popup]' );

        if ( qiPopup ) {
            // Re-parented to <body> — as rendered, it sits inside
            // .qi-connect-form, which the scroll-entrance animation
            // (animations.css) gives a `transform` once revealed. Even an
            // identity transform makes an element the containing block
            // for any position:fixed descendant, so left in place this
            // popup would anchor to that card's box instead of the actual
            // viewport corner.
            document.body.appendChild( qiPopup );

            var qiDismissPopup = function () {
                if ( qiPopup.parentNode ) {
                    qiPopup.parentNode.removeChild( qiPopup );
                }
            };

            var qiPopupClose = qiPopup.querySelector( '.qi-connect-popup__close' );
            if ( qiPopupClose ) {
                qiPopupClose.addEventListener( 'click', qiDismissPopup );
            }

            setTimeout( qiDismissPopup, 6000 );

            if ( window.history && window.history.replaceState && window.URLSearchParams ) {
                var qiParams = new URLSearchParams( window.location.search );
                qiParams.delete( 'qi_contact' );
                var qiQueryString = qiParams.toString();
                var qiCleanUrl    = window.location.pathname + ( qiQueryString ? '?' + qiQueryString : '' ) + '#contact-form';
                window.history.replaceState( null, '', qiCleanUrl );
            }
        }
    } catch ( popupError ) {
        // Non-visibility-critical.
    }
})();
