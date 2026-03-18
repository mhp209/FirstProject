$('body').on('click', '.view_alert', function () {
    var Id = $(this).data('id');
    $.ajax({
        type: 'GET',
        url: site_url +'admin/view-alert/'+ Id,
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            $('.ModalHeader').html("SMS Alert");
            $('#ModalBody').html(data.page);
            $('#Model').modal('show');
        }
    });
});

$('body').on('click', '.view_emergency', function () {
    var Id = $(this).data('id');
    $.ajax({
        type: 'GET',
        url: site_url +'admin/view-emergency/'+ Id,
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            $('.ModalHeader').html("Emergency Details");
            $('#ModalBody').html(data.page);
            $('#Model').modal('show');
        }
    });
});

$('body').on('click', '.view_vehicle', function () {
    var Id = $(this).data('id');
    $.ajax({
        type: 'GET',
        url: site_url +'admin/view-vehicle/'+ Id,
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            $('.ModalHeader').html("Vehicle Details");
            $('#ModalBody').html(data.page);
            $('#Model').modal('show');
        }
    });
});

$('body').on('click', '.view_insurance_equiry', function () {
    var Id = $(this).data('id');
    $.ajax({
        type: 'GET',
        url: site_url +'admin/view-ins-enquiry/'+ Id,
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            $('.ModalHeader').html("Insurance Enquiry Details");
            $('#ModalBody').html(data.page);
            $('#Model').modal('show');
        }
    });
});


