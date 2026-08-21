/**
 * "Popular" column checkboxes on the Articles → Topics term list —
 * toggles qi_popular_article_topics via AJAX and enforces the 5-topic
 * cap client-side (server also enforces it; see inc/admin-taxonomy-fields.php).
 *
 * @package Queer_Ink_Theme
 */
( function ( $ ) {
	'use strict';

	if ( 'undefined' === typeof qiPopularTopics ) {
		return;
	}

	function checkboxes() {
		return $( '.qi-popular-topic-toggle' );
	}

	function refreshDisabledState() {
		var checkedCount = checkboxes().filter( ':checked' ).length;
		checkboxes().each( function () {
			var $box = $( this );
			if ( ! $box.is( ':checked' ) ) {
				$box.prop( 'disabled', checkedCount >= qiPopularTopics.max );
			}
		} );
	}

	$( document ).on( 'change', '.qi-popular-topic-toggle', function () {
		var $box = $( this );
		var termId = $box.data( 'term-id' );
		var selected = $box.is( ':checked' );

		$box.prop( 'disabled', true );

		$.post( qiPopularTopics.ajaxUrl, {
			action: 'qi_toggle_popular_topic',
			nonce: qiPopularTopics.nonce,
			term_id: termId,
			selected: selected ? 1 : 0,
		} )
			.done( function ( response ) {
				if ( ! response.success ) {
					$box.prop( 'checked', ! selected );
					window.alert( ( response.data && response.data.message ) || qiPopularTopics.i18n.max );
				}
			} )
			.fail( function () {
				$box.prop( 'checked', ! selected );
			} )
			.always( function () {
				$box.prop( 'disabled', false );
				refreshDisabledState();
			} );
	} );

	$( refreshDisabledState );
} )( jQuery );
