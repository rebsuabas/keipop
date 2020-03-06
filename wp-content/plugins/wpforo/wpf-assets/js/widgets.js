jQuery(document).ready(function ($) {

    var wpforo_wrap = $('#wpforo-wrap');
    var wpforo_widget_wrap = $('.wpforo-widget-wrap');

    wpforo_wrap.on('click', '.wpf-alerts', function () {
        var notifications = $('.wpforo-subtop').find('.wpf-notifications');
        if( notifications.is(':visible') ){
            notifications.slideUp(250, 'linear');
        }else{
            wpforo_load_show();
            wpforo_load_notifications();
            notifications.slideDown(250, 'linear');
            wpforo_load_hide();
        }
    });

    wpforo_widget_wrap.on('click', '.wpf-widget-alerts', function () {
        var notifications = $('.wpf-widget-alerts').parents('.wpf-prof-wrap').find('.wpf-notifications');
        if( notifications.is(':visible') ){
            notifications.slideUp(250, 'linear');
        }else{
            wpforo_load_notifications();
            notifications.slideDown(250, 'linear');
        }
    });

});

function wpforo_bell( wpf_alerts ){
    var wpf_alerts = parseInt(wpf_alerts);
    if( wpf_alerts > 0 ){
        var wpforo_bell = '';
        var wpf_tooltip = '';
        if (jQuery.isFunction(window.wpforo_phrase)) {
            var wpforo_notification_phrase =  wpforo_phrase('You have a new notification');
            if( wpf_alerts > 1 ) wpforo_notification_phrase = wpforo_phrase('You have new notifications');
            wpf_tooltip = 'wpf-tooltip="' + wpforo_notification_phrase + '" wpf-tooltip-size="middle"';
        }
        wpforo_bell = '<div class="wpf-bell" ' + wpf_tooltip + '><i class="fas fa-bell"></i> <span class="wpf-alerts-count">' + wpf_alerts + '</span></div>';
        jQuery('.wpf-alerts').addClass('wpf-new');
        jQuery('.wpf-widget-alerts').addClass('wpf-new');
    } else {
        wpforo_bell = '<div class="wpf-bell"><i class="far fa-bell"></i></div>';
        jQuery('.wpf-alerts').removeClass('wpf-new');
        jQuery('.wpf-widget-alerts').removeClass('wpf-new');
    }
    jQuery('.wpf-alerts').html(wpforo_bell);
    jQuery('.wpf-widget-alerts').html(wpforo_bell);
}

function wpforo_check_notifications( wpforo_check_interval ) {
    jQuery.ajax({
        type: 'POST',
        url: wpf_widget_ajax_obj.url,
        data:{
            getdata: 0,
            action: 'wpforo_notifications'
        },
        success: function( wpf_alerts ) {
            wpforo_bell( wpf_alerts );
        },
        complete: function() {
            var wpforo_check_notifications_timeout = setTimeout(wpforo_check_notifications, wpforo_check_interval, wpforo_check_interval);
        },
        error: function () {
            clearTimeout(wpforo_check_notifications_timeout);
        }
    });
}

function wpforo_load_notifications() {
    jQuery.ajax({
        type: 'POST',
        url: wpf_widget_ajax_obj.url,
        data:{
            getdata: 1,
            action: 'wpforo_notifications'
        },
        success: function(data) {
            data = jQuery.parseJSON(data);
            if(typeof data == 'object' ){
                var wpf_alerts = parseInt(data.alerts);
                var wpf_notifications = data.notifications;
                if( wpf_alerts > 0 ){
                    jQuery('.wpf-notifications .wpf-notification-actions').show();
                } else {
                    jQuery('.wpf-notifications .wpf-notification-actions').hide();
                }
                jQuery('.wpf-notifications .wpf-notification-content').html( wpf_notifications );
                wpforo_bell( wpf_alerts );
            }
        },
        error: function () {
            clearTimeout(wpforo_check_notifications_timeout);
        }
    });
}