/**
 * Queer Ink Theme main JavaScript.
 *
 * @package Queer_Ink_Theme
 */

(function () {
    'use strict';

    document.documentElement.classList.remove( 'no-js' );
    document.documentElement.classList.add( 'js' );

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

    document.querySelectorAll( '[data-nav-select]' ).forEach( function ( select ) {
        select.addEventListener( 'change', function () {
            if ( select.value ) {
                window.location = select.value;
            }
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
})();
