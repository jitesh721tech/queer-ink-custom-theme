/**
 * Wires the "Select PDF" / "Remove" buttons in the Book PDF meta box
 * (inc/meta-boxes.php) to the native WP media library, restricted to
 * application/pdf.
 */
( function ( $ ) {
    'use strict';

    $( function () {
        var $select   = $( '#qi_book_pdf_select' );
        var $remove   = $( '#qi_book_pdf_remove' );
        var $input    = $( '#qi_book_pdf_id' );
        var $filename = $( '#qi_book_pdf_filename' );
        var frame;

        if ( ! $select.length ) {
            return;
        }

        $select.on( 'click', function ( event ) {
            event.preventDefault();

            if ( frame ) {
                frame.open();
                return;
            }

            frame = wp.media( {
                title: $select.data( 'title' ) || 'Select Book PDF',
                library: { type: 'application/pdf' },
                multiple: false
            } );

            frame.on( 'select', function () {
                var attachment = frame.state().get( 'selection' ).first().toJSON();
                $input.val( attachment.id );
                $filename.text( attachment.filename || attachment.title );
                $remove.show();
            } );

            frame.open();
        } );

        $remove.on( 'click', function ( event ) {
            event.preventDefault();
            $input.val( '' );
            $filename.text( 'No PDF selected.' );
            $remove.hide();
        } );
    } );
} )( jQuery );
