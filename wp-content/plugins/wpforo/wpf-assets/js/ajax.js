jQuery.ajaxSetup({
    url: wpf_ajax_obj.url,
    data:{
        referer: window.location.origin + window.location.pathname
    }
});

function wpforo_post_url_fixer(hash) {
    var postid = 0;
    var match = hash.match(/^#post-(\d+)$/);
    if ( match && (postid = match[1]) ) {
        if (!jQuery(hash).length) {
            jQuery.ajax({
                type: 'POST',
                data: {
                    postid: postid,
                    action: 'wpforo_post_url_fixer'
                }
            }).done(function (response) {
                if( /^https?:\/\/[^\r\n\t\s\0'"]+$/.test(response) ){
                    window.location.assign(response);
                }
            });
        }
    }
}

jQuery(document).ready(function ($) {
	var wpforo_wrap = $('#wpforo-wrap');

    //location hash ajax redirect fix
    wpforo_post_url_fixer(window.location.hash);
    window.onhashchange = function(){
        wpforo_post_url_fixer(window.location.hash);
    };

//	Like
    wpforo_wrap.on('click', '.wpforo-like', function () {
        wpforo_load_show();
        var postid = $(this).data('postid'),
            that = $(this);
        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data: {
                postid: postid,
                likestatus: 1,
                action: 'wpforo_like_ajax'
            }
        }).done(function (response) {
            try {
                response = $.parseJSON(response);
            } catch (e) {
                console.log(e);
            }
            if (response.stat === 1) {
                that.find('.wpforo-like-ico').removeClass('far').addClass('fas');
                that.find('.wpforo-like-txt').text(' ' + wpforo_phrase('Unlike'));
                that.parents('.wpforo-post').find('.bleft').html(response.likers);
                that.removeClass('wpforo-like').addClass('wpforo-unlike');
                if( that.children(".wpf-like-icon").is("[wpf-tooltip]") ) {
                    that.children(".wpf-like-icon").attr("wpf-tooltip", wpforo_phrase('Unlike') );
                }else{
                    that.find('.wpforo-like-ico').removeClass('fa-thumbs-up').addClass('fa-thumbs-down');
                }
                var like_count;
                like_count = that.children(".wpf-like-count").text();
                like_count = parseInt(like_count) + 1;
                that.children(".wpf-like-count").text(like_count);
            }
            wpforo_load_hide();
            wpforo_notice_show(response.notice);
        });
    });
// unlike
    wpforo_wrap.on('click', '.wpforo-unlike', function () {
        wpforo_load_show();
        var postid = $(this).data('postid'),
            that = $(this);
        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data: {
                postid: postid,
                likestatus: 0,
                action: 'wpforo_like_ajax'
            }
        }).done(function (response) {
            try {
                response = $.parseJSON(response);
            } catch (e) {
                console.log(e);
            }
            if (response.stat === 1) {
                that.find('.wpforo-like-ico').removeClass('fas').addClass('far');
                that.find('.wpforo-like-txt').text(' ' + wpforo_phrase('Like'));
                that.parents('.wpforo-post').find('.bleft').html(response.likers);
                that.removeClass('wpforo-unlike').addClass('wpforo-like');
                if( that.children(".wpf-like-icon").is("[wpf-tooltip]") ) {
                    that.children(".wpf-like-icon").attr("wpf-tooltip", wpforo_phrase('Like') );
                }else{
                    that.find('.wpforo-like-ico').removeClass('fa-thumbs-down').addClass('fa-thumbs-up');
                }
                var like_count;
                like_count = that.children(".wpf-like-count").text();
                like_count = parseInt(like_count) - 1;
                that.children(".wpf-like-count").text(like_count);
            }
            wpforo_load_hide();
            wpforo_notice_show(response.notice);
        });
    });


//	Vote
    wpforo_wrap.on('click', '.wpforo-voteup', function () {
        wpforo_load_show();
        var type = $(this).data('type'),
            postid = $(this).data('postid'),
            that = $(this);
        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data: {
                itemtype: type,
                postid: postid,
                votestatus: 'up',
                action: 'wpforo_vote_ajax'
            }
        }).done(function (response) {
            try {
                response = $.parseJSON(response);
            } catch (e) {
                console.log(e);
            }
            if (response.stat === 1) {
                var wpfvote_num = that.parents('.post-wrap').find('.wpfvote-num'),
                    count = wpfvote_num.text();
                wpfvote_num.text(++count).fadeIn();
            }
            wpforo_load_hide();
            wpforo_notice_show(response.notice);
        });
    });

    wpforo_wrap.on('click', '.wpforo-votedown', function () {
        wpforo_load_show();
        var type = $(this).data('type'),
            postid = $(this).data('postid'),
            that = $(this);
        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data: {
                itemtype: type,
                postid: postid,
                votestatus: 'down',
                action: 'wpforo_vote_ajax'
            }
        }).done(function (response) {
            try {
                response = $.parseJSON(response);
            } catch (e) {
                console.log(e);
            }
            if (response.stat === 1) {
                var wpfvote_num = that.parents('.post-wrap').find('.wpfvote-num'),
                    count = wpfvote_num.text();
                wpfvote_num.text(--count).fadeIn();
            }
            wpforo_load_hide();
            wpforo_notice_show(response.notice);
        });
    });


//	Answer
    wpforo_wrap.on('click', '.wpf-toggle-answer', function () {
        wpforo_load_show();
        var postid = $(this).data('postid'),
            that = $(this);
        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data: {
                postid: postid,
                answerstatus: 0,
                action: 'wpforo_answer_ajax'
            }
        }).done(function (response) {
            try {
                response = $.parseJSON(response);
            } catch (e) {
                console.log(e);
            }
            if (response.stat === 1) {
                that.removeClass('wpf-toggle-answer').addClass('wpf-toggle-not-answer');
                setTimeout(function () {
                    window.location.reload();
                }, 300);
            }
            wpforo_load_hide();
            wpforo_notice_show(response.notice);
        });
    });

    wpforo_wrap.on('click', '.wpf-toggle-not-answer', function () {
        wpforo_load_show();
        var postid = $(this).data('postid'),
            that = $(this);
        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data: {
                postid: postid,
                answerstatus: 1,
                action: 'wpforo_answer_ajax'
            }
        }).done(function (response) {
            try {
                response = $.parseJSON(response);
            } catch (e) {
                console.log(e);
            }
            if (response.stat === 1) {
                that.removeClass('wpf-toggle-not-answer').addClass('wpf-toggle-answer');
                setTimeout(function () {
                    window.location.reload();
                }, 300);
            }
            wpforo_load_hide();
            wpforo_notice_show(response.notice);
        });
    });


//	Quote
    wpforo_wrap.on('click', '.wpforo-quote', function () {
        wpforo_load_show();

        $('#wpf-form-wrapper').show();

        var main_form = $('form.wpforo-main-form[data-textareaid]');

        var that = $(this);

        var postid = $(this).data('postid');
        $("#wpf_postparentid").val( postid );
        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data: {
                postid: postid,
                action: 'wpforo_quote_ajax'
            }
        }).done(function (response) {
            var phrase = wpforo_phrase('Reply with quote');
            phrase = phrase.charAt(0).toUpperCase() + phrase.slice(1);
            $("#wpf-reply-form-title").html(phrase);

            $(".wpf-topic-sbs").show();
            $("#wpf-topic-sbs").prop("disabled", false);

            var wpf_formaction = $("#wpf_formaction"),
                wpf_formtopicid = $("#wpf_formtopicid"),
                wpf_formbutton = $("#wpf_formbutton"),
                wpf_title = $("#wpf_title"),
                wpf_body = $(".wpforoeditor textarea.wpeditor");

            $('input[name=wpfaction]', main_form).val('wpforo_post_save');
            wpf_formaction.attr('name', 'post[action]');
            wpf_formtopicid.attr('name', 'post[topicid]');
            wpf_formbutton.attr('name', 'post[save]');
            wpf_formbutton.val(wpforo_phrase('Save'));
            wpf_title.attr('name', 'post[title]');
            wpf_body.attr('name', 'post[body]');
            wpf_formaction.val( 'add' );
            $( "#wpf_formpostid" ).val( '' );
            var reply_title = wpf_title.data('title');
            if( !reply_title ) reply_title = '';
            wpf_title.val(wpforo_phrase('re') + ": " + reply_title.replace(wpforo_phrase('re') + ": ", "").replace(wpforo_phrase('answer to') + ": ", ""));

            wpforo_editor.set_content( response, wpforo_editor.get_main() );

            $('html, body').animate({scrollTop: $("#wpf-form-wrapper").offset().top}, 1000);
            wpforo_load_hide();
        });
    });

//	Report
    wpforo_wrap.on('click', '.wpforo-report', function(){
        wpforo_load_show();
        var postid = $(this).data('postid');
		$('#wpf_reportpostid').attr('value', postid);
		
		var dialog;
		var w = jQuery(window).width();
	    var h = jQuery(window).height();
	    var dialogWidth = 600;
	    var dialogHeight = 250;
	    H = ( dialogHeight < h ) ? dialogHeight : (h-40);
	    W = ( dialogWidth < w ) ? dialogWidth : (w-20);
		
		dialog = jQuery( "#wpf_reportdialog" ).dialog({
			create: function(event, ui) {
		        jQuery(event.target).parent().css('position', 'fixed');
		    },
			autoOpen: false,
		    height: H,
		    width: W,
		    modal: true,
			dialogClass:'wpforo-dialog wpforo-dialog-report'
		});
		
		dialog.dialog( "open" );
        wpforo_load_hide();
	});

    $("#wpf_reportdialog").on('click', '#wpf_sendreport', function () {
        wpforo_load_show();
        var postid = $('#wpf_reportpostid').attr('value');
        var messagecontent = $('#wpf_reportmessagecontent').attr('value');

        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data: {
                postid: postid,
                reportmsg: messagecontent,
                action: 'wpforo_report_ajax'
            }
        }).done(function (response) {
            try {
                response = $.parseJSON(response);
            } catch (e) {
                console.log(e);
            }
            $("#wpf_reportdialog").dialog('close');
            wpforo_load_hide();
            wpforo_notice_show(response);
        });
    });
	
	
//	Sticky
    wpforo_wrap.on('click', '.wpforo-sticky', function () {
        wpforo_load_show();
        var topicid = $(this).data('topicid'),
            that = $(this);

        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data: {
                topicid: topicid,
                status: 'sticky',
                action: 'wpforo_sticky_ajax'
            }
        }).done(function (response) {
            try {
                response = $.parseJSON(response);
            } catch (e) {
                console.log(e);
            }
            if (response.stat === 1) {
                that.find('.wpforo-sticky-txt').text(' ' + wpforo_phrase('Unsticky'));
                that.removeClass('wpforo-sticky').addClass('wpforo-unsticky');
                if( that.is("[wpf-tooltip]") ) {
                    that.attr("wpf-tooltip", wpforo_phrase('Unsticky') );
                }
            }
            wpforo_load_hide();
            wpforo_notice_show(response.notice);
        });
    });


    wpforo_wrap.on('click', '.wpforo-unsticky', function () {
        wpforo_load_show();
        var topicid = $(this).data('topicid'),
            that = $(this);

        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data: {
                topicid: topicid,
                status: 'unsticky',
                action: 'wpforo_sticky_ajax'
            }
        }).done(function (response) {
            try {
                response = $.parseJSON(response);
            } catch (e) {
                console.log(e);
            }
            if (response.stat === 1) {
                that.find('.wpforo-sticky-txt').text(' ' + wpforo_phrase('Sticky'));
                that.removeClass('wpforo-unsticky').addClass('wpforo-sticky');
                if( that.is("[wpf-tooltip]") ) {
                    that.attr("wpf-tooltip", wpforo_phrase('Sticky') );
                }
            }
            wpforo_load_hide();
            wpforo_notice_show(response.notice);
        });
    });

//	Approve
    wpforo_wrap.on('click','.wpforo-approve', function(){
        wpforo_load_show();
        var status_value = 'approve';
        var postid_value = $(this).attr('id'),
            that = $(this);
        var postid = postid_value.replace("wpfapprove", "");

        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data:{
                postid: postid,
                status: status_value,
                action: 'wpforo_approve_ajax'
            }
        }).done(function(response){
            if(response !== 0){
                $("#" + postid_value).removeClass('wpforo-approve').addClass('wpforo-unapprove');
                $("#approveicon" + postid).removeClass('fa-check').addClass('fa-exclamation-circle');
                $("#wpforo-wrap #post-" + postid + " .wpf-mod-message").hide();
                $("#wpforo-wrap .wpf-status-title").hide();
                $("#approvetext" + postid).text( ' ' + wpforo_phrase('Unapprove') );
                if( that.is("[wpf-tooltip]") ) {
                    that.attr("wpf-tooltip", wpforo_phrase('Unapprove') );
                }
            }
            wpforo_load_hide();
            window.location.reload();
        });
    });

//	Unapprove
    wpforo_wrap.on('click','.wpforo-unapprove', function(){
        wpforo_load_show();
        var status_value = 'unapprove';
        var postid_value = $(this).attr('id'),
            that = $(this);
        var postid = postid_value.replace("wpfapprove", "");

        $.ajax({
            type: 'POST',
            url: wpf_ajax_obj.url,
            data:{
                postid: postid,
                status: status_value,
                action: 'wpforo_approve_ajax'
            }
        }).done(function(response){
            if(response != 0){
                $("#" + postid_value).removeClass('wpforo-unapprove').addClass('wpforo-approve');
                $("#approveicon" + postid).removeClass('fa-exclamation-circle').addClass('fa-check');
                $('#wpforo-wrap #post-' + postid + ' .wpf-mod-message').visible();
                $('#wpforo-wrap .wpf-status-title').visible();
                $("#approvetext" + postid).text( ' ' + wpforo_phrase('Approve') );
                if( that.is("[wpf-tooltip]") ) {
                    that.attr("wpf-tooltip", wpforo_phrase('Approve') );
                }
            }
            wpforo_load_hide();
            window.location.reload();
        });
    });


//	Private
	wpforo_wrap.on('click','.wpforo-private', function(){
        wpforo_load_show();
		var status_value = 'private';
		var postid_value = $(this).attr('id'),
            that = $(this);
		var postid = postid_value.replace("wpfprivate", "");
		
	   $.ajax({
	   		type: 'POST',
	   		url: wpf_ajax_obj.url,
	   		data:{
	   			postid: postid,
	   			status: status_value,
	   			action: 'wpforo_private_ajax'
	   		}
	   	}).done(function(response){
	   		if(response != 0){
		   		$("#" + postid_value).removeClass('wpforo-private').addClass('wpforo-public');
				$("#privateicon" + postid).removeClass('fa-eye-slash').addClass('fa-eye');
		   		$("#privatetext" + postid).text( ' ' + wpforo_phrase('Public') );
                if( that.is("[wpf-tooltip]") ) {
                    that.attr("wpf-tooltip", wpforo_phrase('Public') );
                }
		   	}
	   		wpforo_load_hide();
	   	});
	});
	
	wpforo_wrap.on('click','.wpforo-public', function(){
        wpforo_load_show();
		var status_value = 'public';
		var postid_value = $(this).attr('id'),
            that = $(this);
		var postid = postid_value.replace("wpfprivate", "");
		
	   $.ajax({
	   		type: 'POST',
	   		url: wpf_ajax_obj.url,
	   		data:{
	   			postid: postid,
	   			status: status_value,
	   			action: 'wpforo_private_ajax'
	   		}
	   	}).done(function(response){
	   		if(response != 0){
		   		$("#" + postid_value).removeClass('wpforo-public').addClass('wpforo-private');
				$("#privateicon" + postid).removeClass('fa-eye').addClass('fa-eye-slash');
		   		$("#privatetext" + postid).text( ' ' + wpforo_phrase('Private') );
                if( that.is("[wpf-tooltip]") ) {
                    that.attr("wpf-tooltip", wpforo_phrase('Private') );
                }
		   	}
	   		wpforo_load_hide();
	   	});
	});
	
//	Solved
	wpforo_wrap.on('click','.wpforo-solved', function(){
        wpforo_load_show();
		var status_value = 'solved';
		var postid_value = $(this).attr('id'),
            that = $(this);
		var postid = postid_value.replace("wpfsolved", "");
		
	   $.ajax({
	   		type: 'POST',
	   		url: wpf_ajax_obj.url,
	   		data:{
	   			postid: postid,
	   			status: status_value,
	   			action: 'wpforo_solved_ajax'
	   		}
	   	}).done(function(response){
	   		if(response != 0){
		   		$("#" + postid_value).removeClass('wpforo-solved').addClass('wpforo-unsolved');
		   		$("#solvedtext" + postid).text( ' ' + wpforo_phrase('Unsolved') );
                if( that.is("[wpf-tooltip]") ) {
                    that.attr("wpf-tooltip", wpforo_phrase('Unsolved') );
                }
		   	}
	   		wpforo_load_hide();
	   	});
	});
	
	wpforo_wrap.on('click','.wpforo-unsolved', function(){
        wpforo_load_show();
		var status_value = 'unsolved';
		var postid_value = $(this).attr('id'),
            that = $(this);
		var postid = postid_value.replace("wpfsolved", "");
		
	   $.ajax({
	   		type: 'POST',
	   		url: wpf_ajax_obj.url,
	   		data:{
	   			postid: postid,
	   			status: status_value,
	   			action: 'wpforo_solved_ajax'
	   		}
	   	}).done(function(response){
	   		if(response != 0){
		   		$("#" + postid_value).removeClass('wpforo-unsolved').addClass('wpforo-solved');
		   		$("#solvedtext" + postid).text( ' ' + wpforo_phrase('Solved') );
                if( that.is("[wpf-tooltip]") ) {
                    that.attr("wpf-tooltip", wpforo_phrase('Solved') );
                }
		   	}
	   		wpforo_load_hide();
	   	});
	});
	
	
//	Close
	wpforo_wrap.on('click','.wpforo-close', function(){
        wpforo_load_show();
		var status_value = 'close';
		var postid_value = $(this).attr('id'),
            that = $(this);
		var postid = postid_value.replace("wpfclose", "");
	   $.ajax({
	   		type: 'POST',
	   		url: wpf_ajax_obj.url,
	   		data:{
	   			postid: postid,
	   			status: status_value,
	   			action: 'wpforo_close_ajax'
	   		}
	   	}).done(function(response){
	   		if(response != 0){
		   		$("#" + postid_value).removeClass('wpforo-close').addClass('wpforo-open');
		   		$("#closeicon" + postid).removeClass('fa-lock').addClass('fa-unlock');
		   		$("#closetext" + postid).text( ' ' + wpforo_phrase('Open') );
                if( that.is("[wpf-tooltip]") ) {
                    that.attr("wpf-tooltip", wpforo_phrase('Open') );
                }
		   		$("#wpf-form-wrapper").remove();
		   		$(".wpforo-reply").remove();
		   		$(".wpforo-quote").remove();
		   		$(".wpforo-edit").remove();
		   		$(".wpf-answer-button").remove();
		   		$(".wpf-add-comment-button").remove();
			}
	   		wpforo_load_hide();
	   	});
	});
	
	wpforo_wrap.on('click','.wpforo-open', function(){
        wpforo_load_show();
		var status_value = 'closed';
		var postid_value = $(this).attr('id'),
            that = $(this);
		var postid = postid_value.replace("wpfclose", "");
	   $.ajax({
	   		type: 'POST',
	   		url: wpf_ajax_obj.url,
	   		data:{
	   			postid: postid,
	   			status: status_value,
	   			action: 'wpforo_close_ajax'
	   		}
	   	}).done(function(response){
	   		if(response != 0){
		   		/*$("#" + postid_value).removeClass('wpforo-open').addClass('wpforo-close');
		   		$("#closeicon" + postid).removeClass('fa-unlock').addClass('fa-lock');
		   		$("#closetext" + postid).text( ' ' + wpforo_phrase('Close') );*/
                if( that.is("[wpf-tooltip]") ) {
                    that.attr("wpf-tooltip", wpforo_phrase('Close') );
                }
		   		window.location.assign(response);
		   	}
	   		wpforo_load_hide();
	   		
	   	});
	});
	
	
//	Edit
	wpforo_wrap.on('click','.wpforo-edit', function(){
        wpforo_load_show();

        $('#wpf-form-wrapper').show();

        var main_form = $('form.wpforo-main-form[data-textareaid]');

		var phrase = wpforo_phrase('Edit post');
		phrase = phrase.charAt(0).toUpperCase() + phrase.slice(1);
		$("#wpf-reply-form-title").html( phrase );
		var postid_value = $(this).attr('id');
		var is_topic = postid_value.indexOf("topic");
		
		if(is_topic == -1){
			var postid = postid_value.replace("wpfedit", "");
		}else{
			var postid = postid_value.replace("wpfedittopicpid", "");
		}
	   $.ajax({
	   		type: 'POST',
	   		url: wpf_ajax_obj.url,
	   		data: {
	   			postid: postid,
	   			action: 'wpforo_edit_ajax'
	   		}
	   	}).done(function(response){
	   		if(response != 0){
		   		try{
					response = $.parseJSON(response);
				}catch(e){
					console.log(e);
				}

		   		$( ".wpf-topic-sbs" ).hide();
		   		$( "#wpf-topic-sbs" ).prop("disabled", true);
		   		$( "#wpf_formaction" ).val( 'edit' );
		   		$( "#wpf_formpostid" ).val( postid );
				$( "#wpf_formbutton" ).val( wpforo_phrase('Update') );
		   		if(is_topic == -1){
                    $( ".wpf-topic-tags" ).hide();
		   			$( "#wpf_title").val( response.post_title );
		   			$('input[name=wpfaction]', main_form).val('wpforo_post_save');
					$( "#wpf_formaction" ).attr('name', 'post[action]');
					$( "#wpf_formbutton" ).attr('name', 'post[save]');
					$( "#wpf_formtopicid" ).attr('name', 'post[topicid]');
					$( "#wpf_title" ).attr('name', 'post[title]');
					$(".wpforoeditor textarea.wpeditor").attr('name', 'post[body]');
					if( $( "#wpf_user_name" ).length ) { $( "#wpf_user_name" ).attr('name', 'post[name]'); }
					if( $( "#wpf_user_email" ).length ) { $( "#wpf_user_email" ).attr('name', 'post[email]'); }
				}else{
					$( "#wpf_title").val( response.topic_title );
                    $( "#wpf_tags" ).val( response.topic_tags );
                    $( ".wpf-topic-tags" ).show();
                    $('input[name=wpfaction]', main_form).val('wpforo_topic_save');
					$( "#wpf_formaction" ).attr('name', 'topic[action]');
					$( "#wpf_formbutton" ).attr('name', 'topic[save]');
					$( "#wpf_formtopicid" ).attr('name', 'topic[topicid]');
					$( "#wpf_title" ).attr('name', 'topic[title]');
                    $(".wpforoeditor textarea.wpeditor").attr('name', 'topic[body]');
                    $( "#wpf_tags" ).attr('name', 'topic[tags]');
					if( $( "#wpf_user_name" ).length ) { $( "#wpf_user_name" ).attr('name', 'topic[name]'); }
					if( $( "#wpf_user_email" ).length ) { $( "#wpf_user_email" ).attr('name', 'topic[email]'); }
				}

                wpforo_editor.set_content( response.body, wpforo_editor.get_main() );

                $( 'html, body' ).animate({scrollTop: $("#wpf-form-wrapper").offset().top}, 1000);
			}
			
   			wpforo_load_hide();
   			
	   	});
	});
	
	
//	Delete
	wpforo_wrap.on('click', '.wpforo-delete', function(){
        wpforo_load_show();
		
		var ok = confirm(wpforo_ucwords( wpforo_phrase('are you sure you want to delete?') ));
		
		if (ok){
			var postid_value = $(this).attr('id');
			var is_topic = postid_value.indexOf("topic");

            var postid, status_value;
			if(is_topic === -1){
				postid = postid_value.replace("wpfreplydelete", "");
				status_value = 'reply';
			}else{
				postid = postid_value.replace("wpftopicdelete", "");
				status_value = 'topic';
			}
			
			var forumid = $("input[type='hidden']#wpf_parent").val();
			
		  	$.ajax({
		   		type: 'POST',
		   		url: wpf_ajax_obj.url,
		   		data:{
		   			forumid: forumid,
		   			postid: postid,
		   			status: status_value,
		   			action: 'wpforo_delete_ajax'
		   		}
		   	}).done(function(response){
		   		try{
					response = $.parseJSON(response);
				} catch (e) {
					console.log(e);
				}
		   		if( response.stat === 1 ){
					if(is_topic === -1){
					    var to_be_removed = $('#post-' + response.postid);
					    if( to_be_removed.hasClass('wpf-answer-wrap') ){
                            var qa_item_wrap = to_be_removed.parents('.wpforo-qa-item-wrap');
                            if( qa_item_wrap.length ) to_be_removed = qa_item_wrap;
                        }
                        to_be_removed.remove().delay(200);
                        $('#wpf-post-replies-'+response.postid).remove().delay(100);
                        $('#wpf-ttgg-'+response.root+' .wpf-post-replies-count').text( response.root_count );
					}else{
						window.location.assign(response.location);	
					}
					wpforo_load_hide();
				}else{
					wpforo_load_hide();
				}
				
				wpforo_notice_show(response.notice);
		   	});
		}else{
			wpforo_load_hide();
		}
	});
	
	
//	Subscribe
	wpforo_wrap.on('click','.wpf-subscribe-forum, .wpf-subscribe-topic', function(){
        wpforo_load_show();
		var type = '';
		var status = 'subscribe';
		var clases = $(this).attr('class');
		
		if( clases.indexOf("wpf-subscribe-forum") > -1 ){
	    	type = 'forum';
		}
		if( clases.indexOf("wpf-subscribe-topic") > -1 ){
			type = 'topic';
		}
		
		var postid_value = $(this).attr('id');
		var itemid = postid_value.replace("wpfsubscribe-", "");
		
	   $.ajax({
	   		type: 'POST',
	   		url: wpf_ajax_obj.url,
	   		data: {
	   			itemid: itemid,
	   			type: type,
	   			status: status,
	   			action: 'wpforo_subscribe_ajax'
	   		}
	   	}).done(function(response){
	   		try{
			   	response = $.parseJSON(response);
			   } catch (e) {
			   	console.log(e);
			   }
	   		if( response.stat == 1 ){
	   			$("#wpfsubscribe-" + itemid).removeClass('wpf-subscribe-' + type).addClass('wpf-unsubscribe-' + type);
	   			$("#wpfsubscribe-" + itemid).text( ' ' + wpforo_phrase('Unsubscribe') );
	   			wpforo_load_hide();
			}else{
				wpforo_load_hide();
			}
			
			wpforo_notice_show(response.notice);
	   	});
	   	
	});
	
	wpforo_wrap.on('click','.wpf-unsubscribe-forum, .wpf-unsubscribe-topic', function(){
        wpforo_load_show();
		var type = '';
		var button_phrase = '';
		var status = 'unsubscribe';
		var clases = $(this).attr('class');
		if( clases.indexOf("wpf-unsubscribe-forum") > -1 ){
	    	type = 'forum';
	    	button_phrase = wpforo_ucwords( wpforo_phrase('Subscribe for new topics') );
		}
		if( clases.indexOf("wpf-unsubscribe-topic") > -1 ){
			type = 'topic';
			button_phrase = wpforo_ucwords( wpforo_phrase('Subscribe for new replies') );
		}
		var postid_value = $(this).attr('id');
		var itemid = postid_value.replace("wpfsubscribe-", "");
		
	   $.ajax({
	   		type: 'POST',
	   		url: wpf_ajax_obj.url,
	   		data: {
	   			itemid: itemid,
	   			type: type,
	   			status: status,
	   			action: 'wpforo_subscribe_ajax'
	   		}
	   	}).done(function(response){
	   		try{
			   	response = $.parseJSON(response);
			   } catch (e) {
			   	console.log(e);
			   }
	   		if( response.stat == 1 ){
	   			$("#wpfsubscribe-" + itemid).removeClass('wpf-unsubscribe-' + type).addClass('wpf-subscribe-' + type);
		   		$("#wpfsubscribe-" + itemid).text( ' ' + button_phrase );
		   		wpforo_load_hide();
			}else{
				wpforo_load_hide();
			}
			
			wpforo_notice_show(response.notice);
	   	});
	});

	wpforo_wrap.on('click', '.wpforo-tools', function () {
	    var tools = $('#wpf_moderation_tools');
	    if( tools.is(':visible') ){
            tools.slideUp(250, 'linear');
        }else{
            wpforo_load_show();
            tools.find('.wpf-tool-tabs .wpf-tool-tab').removeClass('wpf-tt-active');
            tools.find('.wpf-tool-tabs .wpf-tool-tab:first-child').addClass('wpf-tt-active');
			wpforo_topic_tools_tab_load();
        }
    });

	wpforo_wrap.on('click', '#wpf_moderation_tools .wpf-tool-tabs .wpf-tool-tab:not(.wpf-tt-active)', function () {
        $("#wpf-msg-box").hide();
        $(this).siblings('.wpf-tool-tab').removeClass('wpf-tt-active');
        if( !$(this).hasClass('wpf-tt-active') ) $(this).addClass('wpf-tt-active');
		wpforo_topic_tools_tab_load();
    });

    wpforo_topic_tools_tab_load();

    wpforo_wrap.on('click', '.wpf-load-threads a.wpf-threads-filter', function () {
        var wrap = $(this).parents('div.wpfl-4');
        var topics_list = $('.wpf-thread-list', wrap);
        topics_list.data('paged', 0);
        topics_list.data('filter', $(this).data('filter'));
        $('.wpf-more-topics > a', wrap).click();
        $(this).siblings('a.wpf-threads-filter').removeClass('wpf-active');
        $(this).addClass('wpf-active');
    });

    wpforo_wrap.on('change', '.wpf-topic-form-forumid', function () {
        var form_wrap = $(this).parents('.wpf-topic-form-extra-wrap');
        $('.wpf-topic-form-ajax-wrap', form_wrap).html('<i class="fas fa-spinner fa-spin wpf-icon-spinner"></i>');
        $('.wpf-topic-form-no-selected-forum', form_wrap).hide();

        var forumid = parseInt( $(this).val() );
        if( forumid ){
            $.ajax({
                type: 'POST',
                data: {
                    forumid: forumid,
                    action: 'wpforo_topic_portable_form'
                }
            }).done(function (response) {
                if( response ){
                    $('.wpf-topic-form-ajax-wrap', form_wrap).html(response);
                    $('.wpf-topic-create', form_wrap).show();
                    var form = $('form', form_wrap);
                    if( form.length ){
                        var textareaid = form.data('textareaid');
                        if( textareaid ){
                            wpforo_tinymce_initializeIt( '#' + textareaid, true );
                            $('input.wpf-subject', form_wrap).focus();
                        }
                    }

                    wpforo_trigger_custom_event(document, 'wpforo_topic_portable_form');
                }
            })
        }
    });

    wpforo_wrap.on('click', '.wpf-more-topics > a', function () {
        var $this = $(this);
        var wrap = $this.parents('div.wpfl-4');
        var topics_list = $('.wpf-thread-list', wrap);
        var filter = topics_list.data('filter');
        var forumid = topics_list.data('forumid');
        var paged = topics_list.data('paged');
        var append = paged !== 0;
        topics_list.data('paged', ++paged);

        var load_msg = wpforo_phrase('Loading Topics');

        wpforo_load_show(load_msg);

        var i = $('.wpf-load-threads a.wpf-threads-filter[data-filter="' + filter + '"] i', wrap);
        var i_class = i.attr('class');
        var i_spin_class = 'fas fa-circle-notch fa-spin';
        var i_toggle_class = i_class + ' ' + i_spin_class;

        var i2 = $('i', $this);
        var i2_class = i2.attr('class');
        var i2_toggle_class = i2_class + ' ' + i_spin_class;

        $("#wpf-msg-box").hide();

        i.toggleClass(i_toggle_class);
        if(append) i2.toggleClass(i2_toggle_class);

        $.ajax({
            type: 'POST',
            data: {
                forumid: forumid,
                filter: filter,
                paged: paged,
                action: 'wpforo_layout4_loadmore'
            }
        }).done(function (response) {
            try {
                response = JSON.parse(response);
            } catch (e) {
                console.log(e);
            }

            if (response.stat === 1) {
                if (append) {
                    topics_list.append(response.output_html);
                } else {
                    topics_list.html(response.output_html);
                    $this.show();
                }
            } else {
                if (!append) {
                    topics_list.html( '<span class="wpf-no-thread">' + wpforo_phrase('No threads found') + '</span>' );
                }
            }

            if (response.no_more) {
                $this.hide();
            }

            i.toggleClass(i_toggle_class);
            if(append) i2.toggleClass(i2_toggle_class);
            wpforo_load_hide();
        });
    });

    wpforo_wrap.on('click', '.wpforo-qa-show-rest-comments', function () {
        wpforo_load_show();
        var $this = $(this);
        var wrap = $this.parents('.wpforo-qa-item-wrap');
        var root_wrap = wrap.children('.post-wrap');
        var comments_list = $('.wpforo-qa-comments', wrap);
        var parentid = root_wrap.data('postid');

        $.ajax({
            type: 'POST',
            data: {
                parentid: parentid,
                action: 'wpforo_qa_comment_loadrest'
            }
        }).done(function (response) {
            try {
                response = JSON.parse(response);
            } catch (e) {
                console.log(e);
            }

            if (response.stat === 1) {
                comments_list.append(response.output_html);
                $this.remove();
                wpforo_load_hide();
            }
        });
    });

    wpforo_wrap.on('click', 'form[data-textareaid] .wpforo_post_preview:not(.wpf-disabled)', function(){
        var $this = $(this);
        var ico = $('.wpf-rev-preview-ico', $this);
        var form = $this.closest('form[data-textareaid]');

        //$('.wpforo_save_revision', form).click();

        var textareaid = form.data('textareaid');
        var postid = $( 'input#wpf_formpostid', form ).val();
        var body = wpforo_editor.get_content('raw');
        var body_info = wpforo_editor.get_stats();

        if( textareaid && body_info.has_content){
            wpforo_load_show();
            ico.toggleClass('fa-eye fa-circle-notch fa-spin');
            $.ajax({
                type: 'POST',
                data: {
                    textareaid: textareaid,
                    postid: postid,
                    body: body,
                    action: 'wpforo_post_preview'
                }
            }).done(function (response) {
                if( response ) {
                    $('.wpforo-revisions-action-buttons .wpforo-revision-action-button', form).removeClass('wpf-rev-button-active');
                    $this.addClass('wpf-rev-button-active');
                    $('.wpforo-revisions-preview-wrap', form).html(response);
                }
            }).always(function(){
                wpforo_load_hide();
                ico.toggleClass('fa-eye fa-circle-notch fa-spin');
            });
        }

    });

    wpforo_wrap.on('click', 'form[data-textareaid] .wpforo_save_revision', function () {
        if( $(this).is(':visible') ){
            var ico = $('.wpf-rev-save-ico', $(this));
            var form = $(this).closest('form[data-textareaid]');
            var textareaid = form.data('textareaid');
            var postid = $( 'input#wpf_formpostid', form ).val();
            var body = wpforo_editor.get_content('raw');
            var body_info = wpforo_editor.get_stats();
            if( textareaid && body_info.has_content && $.active === 0 ){
                wpforo_load_show('Saving Draft');
                ico.toggleClass('fa-save fa-circle-notch fa-spin');
                $.ajax({
                    type: 'POST',
                    data: {
                        textareaid: textareaid,
                        postid: postid,
                        body: body,
                        action: 'wpforo_save_revision'
                    }
                }).done(function (response) {
                    try{
                        response = JSON.parse(response);

                        if( parseInt( response.revisionid ) ) {
                            wpforo_deactivate_revision_action_buttons(form);
                            $('.wpf-rev-history-count', form).text(response.revisions_count);
                            if( response.revisionhtml && $('.wpforo_revisions_history', form).hasClass('wpf-rev-button-active') ){
                                var revisions_preview_wrap = $('.wpforo-revisions-preview-wrap', form);
                                revisions_preview_wrap.prepend(response.revisionhtml);
                                var wpforo_revision = $('.wpforo-revision', revisions_preview_wrap);
                                if( wpforo_revision.length >= wpforo.revision_options.max_drafts_per_page ){
                                    wpforo_revision.each(function (i) {
                                        if( i >= wpforo.revision_options.max_drafts_per_page ) $(this).remove();
                                    });
                                }
                            }
                        }
                    }catch (e) {
                        console.log(e);
                    }
                }).always(function(){
                    wpforo_load_hide();
                    ico.toggleClass('fa-save fa-circle-notch fa-spin');
                });
            }
        }
    });

    wpforo_wrap.on('click', 'form[data-textareaid] .wpforo_revisions_history', function(){
        var $this = $(this);
        var ico = $('.wpf-rev-ico', $this);
        var form = $this.closest('form[data-textareaid]');
        var textareaid = form.data('textareaid');
        var postid = $( 'input#wpf_formpostid', form ).val();

        if( textareaid && $.active === 0 ){
            wpforo_load_show();
            ico.toggleClass('fa-history fa-circle-notch fa-spin');
            $.ajax({
                type: 'POST',
                data: {
                    textareaid: textareaid,
                    postid: postid,
                    action: 'wpforo_get_revisions_history'
                }
            }).done(function (response) {
                try{
                    response = JSON.parse(response);

                    if( parseInt( response.revisions_count ) ) {
                        $('.wpf-rev-history-count', form).text(response.revisions_count);
                        $('.wpforo-revisions-action-buttons .wpforo-revision-action-button', form).removeClass('wpf-rev-button-active');
                        $this.addClass('wpf-rev-button-active');
                        $('.wpforo-revisions-preview-wrap', form).html(response.revisionhtml);
                    }
                }catch (e) {
                    console.log(e);
                }
            }).always(function(){
                wpforo_load_hide();
                ico.toggleClass('fa-history fa-circle-notch fa-spin');
            });
        }
    });

    wpforo_wrap.on('click', 'form[data-textareaid] .wpforo-revision-action-restore', function(){
        var ico = $('.wpf-rev-ico', $(this));
        var form = $(this).closest('form[data-textareaid]');
        var rev_wrap = $(this).closest('.wpforo-revision[data-revisionid]');
        if( rev_wrap.length && $.active === 0 ){
            wpforo_load_show('Restore Revision');
            ico.toggleClass('fa-history fa-circle-notch fa-spin');

            var revisionid = rev_wrap.data('revisionid');
            $.ajax({
                type: 'POST',
                data: {
                    revisionid: revisionid,
                    action: 'wpforo_get_revision'
                }
            }).done(function (response) {
               if( response ){
                   try {
                       response = JSON.parse(response);
                       if( response.revisionid ){
                           wpforo_editor.set_content(response.body);
                           $('html, body').animate({ scrollTop: form.offset().top }, 500);
                       }
                   } catch (e) {
                       console.log(e);
                   }
               }
            }).always(function(){
                wpforo_load_hide();
                ico.toggleClass('fa-history fa-circle-notch fa-spin');
            });
        }
    });

    wpforo_wrap.on('click', 'form[data-textareaid] .wpforo-revision-action-delete', function(){
        var ico = $('.wpf-rev-ico', $(this));
        var form = $(this).closest('form[data-textareaid]');
        var rev_wrap = $(this).closest('.wpforo-revision[data-revisionid]');
        if( rev_wrap.length && $.active === 0 ){
            wpforo_load_show('Deleting Revision');
            ico.toggleClass('fa-trash fa-circle-notch fa-spin');

            var revisionid = rev_wrap.data('revisionid');
            $.ajax({
                type: 'POST',
                data: {
                    revisionid: revisionid,
                    action: 'wpforo_delete_revision'
                }
            }).done(function (response) {
               if( parseInt(response) ){
                   rev_wrap.fadeOut(500, function(){
                       rev_wrap.remove();
                       var rev_history_count = $('.wpf-rev-history-count', form);
                       rev_history_count.text( parseInt( rev_history_count.text() ) - 1 );
                   });
               }
            }).always(function(){
                wpforo_load_hide();
                ico.toggleClass('fa-trash fa-circle-notch fa-spin');
            });
        }
    });

    function wpforo_activate_revision_action_buttons(form){
        var rev_saved = $('.wpforo_revision_saved', form);
        if( rev_saved.is(':visible') ){
            rev_saved.fadeOut(1000, function(){
                var save_revision = $('.wpforo_save_revision', form);
                save_revision.show();

                if( parseInt(wpforo.revision_options.is_draft_on) && parseInt(wpforo.revision_options.auto_draft_interval) && !save_revision.data('auto_draft') ){
                    setInterval(function(){
                        save_revision.click();
                    }, wpforo.revision_options.auto_draft_interval);
                    save_revision.data('auto_draft', true);
                }
            });
        }
    }

    function wpforo_deactivate_revision_action_buttons(form){
        $('.wpforo_revision_saved', form).show();
        $('.wpforo_save_revision', form).hide();
    }

    function wpforo_content_changed(){
        var form = $('form[data-textareaid="'+ wpforo_editor.active_textareaid +'"]');
        if( wpforo_editor.get_stats().has_content ){
            wpforo_activate_revision_action_buttons(form);
            $('.wpforo_post_preview', form).removeClass('wpf-disabled');
        }else{
            wpforo_deactivate_revision_action_buttons(form);
            $('.wpforo_post_preview', form).addClass('wpf-disabled');
        }
    }

    function wpforo_content_ctrl_s(){
        $('form[data-textareaid="'+ wpforo_editor.active_textareaid +'"] .wpforo_save_revision').click();
    }

    wpforo_wrap.on('change input propertychange', 'form[data-textareaid] textarea', function () {
        wpforo_trigger_custom_event(document,'wpforo_textarea_content_changed');
    });

    document.addEventListener('wpforo_tinymce_content_changed', wpforo_content_changed);
    document.addEventListener('wpforo_textarea_content_changed', wpforo_content_changed);
    document.addEventListener('wpforo_tinymce_ctrl_s', wpforo_content_ctrl_s);
    document.addEventListener('wpforo_textarea_ctrl_s', wpforo_content_ctrl_s);

    wpforo_tags_suggest();
    document.addEventListener('wpforo_topic_portable_form', wpforo_tags_suggest);

});

function wpforo_ucwords (str) {
    return (str + '').replace(/^([a-z])|\s+([a-z])/, function ($1) {
        return $1.toUpperCase();
    });
}

function wpforo_topic_tools_tab_load() {
    var active_tab = jQuery('#wpf_moderation_tools').find('.wpf-tool-tab.wpf-tt-active');
    if( active_tab.length ){
        var active_tab_id = active_tab.attr('id');
        if( active_tab_id ){
            jQuery("#wpf-msg-box").hide();
            jQuery('#wpf_tool_tab_content_wrap').html('<i class="fas fa-spinner fa-spin wpf-icon-spinner"></i>');
            jQuery.ajax({
                type: 'POST',
                data: {
                    active_tab_id: active_tab_id,
                    action: 'wpforo_active_tab_content_ajax'
                }
            }).done(function(response){
                if( response ){
                    jQuery('#wpf_tool_tab_content_wrap').html(response);
                    jQuery('#wpf_moderation_tools').slideDown(400, 'linear');
                }
                wpforo_load_hide();
            });
        }
    }
}

function wpforo_tags_suggest(){
    var wpf_tags = jQuery('#wpf_tags');
    wpf_tags.suggest(
        window.ajaxurl + "?action=wpforo_tag_search",
        {   multiple:true,
            multipleSep: ",",
            resultsClass: 'wpf_ac_results',
            selectClass: 'wpf_ac_over',
            matchClass: 'wpf_ac_match',
            onSelect: function() {}
        }
    );
    jQuery('.wpf_ac_results').blur(function() {
        wpf_tags.removeClass( 'wpf-ac-loading' );
    });
    wpf_tags.blur(function() {
        jQuery(this).removeClass( 'wpf-ac-loading' );
    });
    wpf_tags.keydown(
        function ( e ) {
            var loading; clearTimeout(loading);
            var tags = wpf_tags.val();
            if( tags.length >= 1 ){
                switch(e.keyCode) {
                    case 38:  // up
                    case 40:  // down
                    case 8:   // backspace
                    case 9:   // tab
                    case 13:  // return
                    case 27:  // escape
                    case 32:  // space
                    case 188: // comma
                        jQuery(this).removeClass( 'wpf-ac-loading' ); break;
                    default:
                        jQuery(this).addClass( 'wpf-ac-loading' );
                }
            }
            loading = setTimeout(function() { wpf_tags.removeClass( 'wpf-ac-loading' ); }, 1000);
        }
    );
}


/*
function wpforo_bell( wpf_alerts ){
    var wpf_alerts = parseInt(wpf_alerts);
    if( wpf_alerts > 0 ){
        var wpforo_bell = '';
        var wpforo_notification_phrase =  wpforo_phrase('You have a new notification');
        if( wpf_alerts > 1 ) wpforo_notification_phrase = wpforo_phrase('You have new notifications');
        wpforo_bell = '<div class="wpf-bell" wpf-tooltip="' + wpforo_notification_phrase + '" wpf-tooltip-size="middle"><i class="fas fa-bell"></i><span class="wpf-alerts-count">' + wpf_alerts + '</span></div>';
        jQuery('.wpf-alerts').addClass('wpf-new');
    } else {
        wpforo_bell = '<div class="wpf-bell"><i class="far fa-bell"></i></div>';
        jQuery('.wpf-alerts').removeClass('wpf-new');
    }
    jQuery('.wpf-alerts').html(wpforo_bell);
}

function wpforo_check_notifications( wpforo_check_interval ) {
    jQuery.ajax({
        type: 'POST',
        url: wpf_ajax_obj.url,
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
        url: wpf_ajax_obj.url,
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
                    jQuery('#wpf-bar-notifications .wpf-notification-actions').show();
                } else {
                    jQuery('#wpf-bar-notifications .wpf-notification-actions').hide();
                }
                jQuery('#wpf-bar-notifications .wpf-notification-content').html( wpf_notifications );
                wpforo_bell( wpf_alerts );
            }
        },
        error: function () {
            clearTimeout(wpforo_check_notifications_timeout);
        }
    });
}
*/