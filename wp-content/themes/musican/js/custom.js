(function($) {

    "use strict";

    /* Nav mobile */
    $('.nav-form li.menu-item-has-children > span.arrow').click(function(){
        $(this).next('ul.sub-menu').slideToggle( 500 );
        $(this).toggleClass('active');
        return false;
    });
    
    $('.mobile-menu').click(function (e) {
        e.preventDefault(); // prevent the default action
        e.stopPropagation(); // stop the click from bubbling

        $('.nav-form').toggleClass('open');
        // click body one click for close menu
        $(document).on('click', function closeMenu (e){
            if ( $('.nav-form').has(e.target).length === 0){
                $('.nav-form').removeClass('open');
            } else {
                $(document).on('click', closeMenu);
            }
        });

    });
    

})(jQuery);


(function() {
    var settings = window._wpmejsSettings || {};

    settings.features = settings.features || mejs.MepDefaults.features;

    settings.features.push( 'musican_class' );

    MediaElementPlayer.prototype.buildmusican_class = function(player, controls, layers, media) {
        if ( ! player.isVideo ) {
            var container = player.container[0] || player.container;

            container.style.height = '';
            container.style.width = '';
            player.options.setDimensions = false;
        }

        if ( jQuery( '#' + player.id ).parents('#top-playlist-section').length ) {
            player.container.addClass( 'musican-mejs-container musican-mejs-top-playlist-container' );

            jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').addClass('displaynone');

            var volume_slider = controls[0].children[5];

            if ( jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').length > 0) {
                var playlist_button =
                jQuery('<div class="mejs-button mejs-playlist-button mejs-toggle-playlist">' +
                    '<button type="button" aria-controls="mep_0" title="Toggle Playlist"></button>' +
                '</div>')

                // append it to the toolbar
                .appendTo( jQuery( '#' + player.id ) )

                // add a click toggle event
                .click(function() {
                    jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').slideToggle();
                    jQuery( this ).toggleClass('is-open')
                });

                // Add next button after volume slider
                var next_button =
                jQuery('<div class="mejs-button mejs-next-button mejs-next">' +
                    '<button type="button" aria-controls="' + player.id
                    + '" title="Next Track"></button>' +
                '</div>')

                // insert after volume slider
                .insertAfter(volume_slider)

                // add a click toggle event
                .click(function() {
                    jQuery( '#' + player.id ).parent().find( '.wp-playlist-next').trigger('click');
                });
            }

            // Add play button after volume slider
            var play_button = jQuery(controls[0].children[0]).insertAfter( volume_slider );

            if ( jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').length > 0) {

                // Add next button after volume slider
                var previous_button =
                jQuery('<div class="mejs-button mejs-previous-button mejs-previous">' +
                    '<button type="button" aria-controls="' + player.id
                    + '" title="Previous Track"></button>' +
                '</div>')

                // insert after volume slider
                .insertAfter(volume_slider)

                // add a click toggle event
                .click(function() {
                    jQuery( '#' + player.id ).parent().find(' .wp-playlist-prev').trigger('click');
                });
            }
        } else {
            player.container.addClass( 'musican-mejs-container' );
            if ( jQuery( '#' + player.id ).parent().children('.wp-playlist-tracks').length > 0) {
                var play_button = controls[0].children[0];

                // Add next button after volume slider
                var next_button =
                jQuery('<div class="mejs-button mejs-next-button mejs-next">' +
                    '<button type="button" aria-controls="' + player.id
                    + '" title="Next Track"></button>' +
                '</div>')

                // insert after volume slider
                .insertAfter(play_button)

                // add a click toggle event
                .click(function() {
                    jQuery( '#' + player.id ).parent().find( '.wp-playlist-next').trigger('click');
                });

                // Add prev button after volume slider
                var previous_button =
                jQuery('<div class="mejs-button mejs-previous-button mejs-previous">' +
                    '<button type="button" aria-controls="' + player.id
                    + '" title="Previous Track"></button>' +
                '</div>')

                // insert after volume slider
                .insertBefore( play_button )

                // add a click toggle event
                .click(function() {
                    jQuery( '#' + player.id ).parent().find( '.wp-playlist-prev').trigger('click');
                });
            }
        }
    }
})(jQuery);