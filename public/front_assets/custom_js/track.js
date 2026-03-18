$('.sendbtn').hide();
$('.message_status').on('click', function() {
    var id = $(this).data('id');
    var url = site_url + 'safety-message/' + id;
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            $('#reason').html(response.message);
            $('#message-container').html(response.message);
            $('.send_msg').attr('data-message_id', id);
            $('.sendbtn').show();
        },
        error: function(response) {
            // console.error(response);
            // location.reload();
        }
    });
});
$('.send_msg_old').on('click', function() {
    var phone_no = $(this).data('phone_no');
    var message_id = $('.send_msg').attr('data-message_id');

    var url = site_url + 'send-message';
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
            'phone_no': phone_no,
            'message_id': message_id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            // console.log(response);
            // $('#message-container').html(response.message);
            // $('.sendbtn').show();
            $('#title').html(response.safety_option);
            $('#whatsupMassage').html(response.whatsupMassage);
            $('.modal').modal('show');
        },
        error: function(response) {
            console.error(response);
            // location.reload();
        }
    });
});
$('.send_msg').on('click', function() {
    var message_key = $(this).attr('data-id');
    var vehicle_no = $('.send_msg').attr('data-vehicle_no');
    // var owner_name = $('.send_msg').attr('data-owner_name');

    var url = site_url + 'send-sms';
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: {
            'message_key': message_key,
            'vehicle_no': vehicle_no,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function(response) {
            // console.log(response);
            // $('#message-container').html(response.message);
            // $('.sendbtn').show();
            $('#title').html(response.safety_option);
            $('#whatsupMassage').html(response.whatsupMassage);
            $('.modal').modal('show');
        },
        error: function(response) {
            console.error(response);
            // location.reload();
        }
    });
});

jQuery(window).bind("load", function() {
    var footerHeight = 0,
        footerTop = 0,
        $footer = $("#footer");
    positionFooter();

    function positionFooter() {
        footerHeight = $footer.height();
        // console.log(footerHeight);
        footerTop = ($(window).height() - (footerHeight * 2)) + "px";
        // console.log(footerTop);
        if (($(document.body).height() + footerHeight) < $(window).height()) {
            // console.log(111);
            // alert(111);
            $footer.css({
                    position: "absolute",
                    width: "100%"
                })
                .animate({
                    top: footerTop
                })
        } else {
            $footer.css({
                position: "static"
            })
        }
    }

});
