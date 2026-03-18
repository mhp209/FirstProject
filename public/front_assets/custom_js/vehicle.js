$(document).ready(function() {

    $(window).keydown(function(event){
        if(event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });

    var selectedImages = [];
    GetModels();

    $.validator.addMethod("maxImages", function (value, element, params) {
        var allowedparam = params - imageCount;
        return this.optional(element) || element.files.length <= allowedparam;
    }, function(params, element) {
        var allowedparam = params - imageCount;
        return "You can only upload up to " + allowedparam + " images.";
    });

        // $("#vehicle_table").DataTable({
        //     paging: true,
        //     responsive : true,
        //     ordering : false,
        //     columnDefs: [{
        //       orderable: false,
        //       targets: "no-sort"
        //     }]
        // });

    // $("#barcode-error1").hide();
    $('#barcode').on('change', function() {
        var barcode = $(this).val();
        $("#barcode-error1").hide();
        if(barcode == ''){
            $('.chechout-btn').prop("disabled", false);
        }else{

            id = $("input[name='id']").val();
            pdata = {'id': id,'barcode' : barcode};

            $.ajax({
                url: site_url+'check-barcode',
                method: "POST",
                data: pdata,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if(data.exists){
                        $("#barcode-error1").html(data.msg);
                        $("#barcode-error1").show();
                        $(".chechout-btn"). attr("disabled", true);
                        return false;
                    }else{
                        $('.chechout-btn').prop("disabled", false);
                    }
                }
            });

        }
        // console.log(barcode);

    });

    $("#add_vehicle_frm").validate({
        errorElement:'div',
        rules: {
            owner_name: {
                required: true
            },
            barcode: {
                required: true,
            },
            vehicle_no: {
                required: true
            },
            brand: {
                required: true
            },
            model: {
                required: true
            },
            mobile_number: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10
            },
            emergency_number: {
                required: true,
                digits: true
            },
            vehicle_type: {
                required: true
            },
            emergency_name1: {
                required: true
            },
            relation_emg1: {
                required: true
            },
            emergency_number1: {
                required: true,
                minlength: 10,
                maxlength: 10
            },
            emergency_number2: {
                minlength: 10,
                maxlength: 10
            },
            "image[]": {
                maxImages : 3
            },
        },
        messages: {
            owner_name: {
                required: "Please enter your owner name"
            },
            barcode: {
                required: "Please enter barcode",
            },
            vehicle_no: {
                required: "Please enter your vehicle no"
            },
            brand: {
                required: "Please select brand"
            },
            model: {
                required: "Please select model"
            },
            mobile_number: {
                required: "Please enter your mobile number",
                digits: "Please enter 10 digit number",
                minlength: "Mobile number is invalid",
                maxlength: "Mobile number is invalid",
            },
            vehicle_type: {
                required: "Please select vehicle type"
            },
            emergency_name1: {
                required: "This field is required."
            },
            relation_emg1: {
                required: "This field is required."
            },
            emergency_number1: {
                required: "This field is required.",
                minlength: "Mobile number is invalid",
                maxlength: "Mobile number is invalid",
            },
            emergency_number2: {
                minlength: "Mobile number is invalid",
                maxlength: "Mobile number is invalid",
            },
            // 'vehicle_documents[]': {
            //     extension: 'pdf|doc|docx|jpg|jpeg|png', // Add the allowed file extensions
            // }
        },
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback text-start');
            element.after(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('has-error').removeClass('has-success');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('has-error').addClass('has-success');
        },

        submitHandler: function (form) {
            if ($("#barcode-error").is(":visible")) {
                form.preventDefault();
                alert("Barcode already exists. Please fix the issue before submitting.");
            }
            if($("#add_vehicle_frm").valid()) {
                form.submit();
            }
        }
    });


    // $('form button').on("click",function(e){
    //     e.preventDefault();
    // });



    $('#image').on('change', function() {
        var imagePreviewContainer = $('.image-preview-container');

        var allowedparam = 3 - imageCount;
        // console.log(allowedparam);
        // console.log(this.files.length);

        $('.image-preview.temp').remove();

        if(this.files.length <= allowedparam){
            $.each(this.files, function(index, file) {
                if (file.type.match('image.*')) {
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var imagePreview = $('<div class="image-preview temp"></div>');
                        var img = $('<img>').attr('src', e.target.result);
                        var deleteButton = $('<button class="delete-button">X</button>');

                        deleteButton.on('click', function() {
                            // Remove the image from the selectedImages array
                            var indexToRemove = selectedImages.indexOf(file);
                            if (indexToRemove !== -1) {
                                selectedImages.splice(indexToRemove, 1);
                                // console.log(selectedImages);
                            }
                            // Remove the image preview
                            imagePreview.remove();
                        });

                        imagePreview.append(img);
                        // imagePreview.append(deleteButton);
                        imagePreviewContainer.append(imagePreview);

                        // Add the selected image to the array
                        selectedImages.push(file);
                        // console.log(selectedImages);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });

    $('#brand').on('change', function () {
        GetModels();
        $("#other_model_name").addClass('hide');
    });

    $('#model').on('change', function () {
        var val = $(this).val();
        if(val == 'other'){
            $("#other_model_name").removeClass('hide');
            $('.chechout-btn').prop("disabled", true);
        }else{
            $("#other_model_name").addClass('hide');
            $('#model_name').val("");
            $("#model-error").hide();
        }
    });

    // $('#model_name').on('change', function() {
    $('#model_name').on('keyup', function () {
        var model_name = $(this).val();
        if(model_name == ''){
            $('.chechout-btn').prop("disabled", true);
            $("#model-error").html('Please enter model name');
            $("#model-error").hide();
        }else{
            id = $("#brand").val();
            pdata = {'brand_id': id, 'name' : model_name};
            // console.log(pdata);
            $.ajax({
                url: site_url+'check-model',
                method: "POST",
                data: pdata,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if(data.exists){
                        $("#model-error").html(data.msg);
                        $("#model-error").show();
                        $(".chechout-btn"). attr("disabled", true);
                        return false;
                    }else{
                        $("#model-error").hide();
                        $('.chechout-btn').prop("disabled", false);
                    }
                }
            });
        }
        // console.log(barcode);

    });


    // $('#SubmitFrm').on('click', function(event) {

    //     event.preventDefault();

    //     var formData = new FormData();
    //     var formArray = $('#add_vehicle_frm').serializeArray();

    //     $.each(formArray, function(i, field) {
    //         formData.append(field.name, field.value);
    //     });

    //     for (var i = 0; i < selectedImages.length; i++) {
    //         formData.append('image[]', selectedImages[i]);
    //     }

    //     var fileInput = $('#vehicle_documents')[0];
    //     for (var i = 0; i < fileInput.files.length; i++) {
    //         formData.append('vehicle_documents[]', fileInput.files[i]);
    //     }
    //     // console.log(routeUrl);return false;
    //     $.ajax({
    //         url: actionUrl,
    //         type: 'POST',
    //         data: formData,
    //         cache: false,
    //         contentType: false,
    //         processData: false,
    //         success: function(response) {
    //             // window.location.href = vehiclelistUrl;
    //             console.log(response);
    //             console.log(response.redirect);
    //             window.location.href = response.redirect;
    //         },
    //         error: function(xhr) {
    //             if (xhr.status === 422) {
    //                 var errors = xhr.responseJSON.errors;
    //                 $.each(errors, function (key, value) {
    //                     var errorSpan = $("<span></span>").addClass("invalid-feedback").attr("role", "alert");
    //                     errorSpan.html("<strong>" + value + "</strong>");
    //                     $("#" + key).addClass("is-invalid");
    //                     $("#" + key).parent().append(errorSpan);
    //                 });

    //             } else {
    //                 // Handle other errors
    //             }
    //         }
    //     });
    //     event.preventDefault();
    // });

    $('body').on('click', '.delete', function () {
        var vehicleId = $(this).data('id');
        if(confirm("Are you sure you want to remove this vehicle?") == true){
              $.ajax({
                  type: 'DELETE',
                  url: site_url +'del-vehicle/'+ vehicleId,
                  headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function(data) {
                    location.href = location.href
                  }
              });
        }
     });

    $(document).on('click', '.img-delete-button', function(e) {
        e.preventDefault();
        var imageId = $(this).prev().data('id');
        var name = $(this).prev().data('name');
        var self = this;
        $.ajax({
            type: 'POST',
            url:  site_url + 'del-vehicle-img',
            data : {'id' : imageId , 'name' : name},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $(self).closest('.image-preview').remove();
                imageCount = imageCount - 1 ;
                alert(response.message);
            },
            error: function(error) {
                console.error('Error: ', error);
            }
        });
    });

});

function GetModels(){

    var brandId =  $('#brand').find(":selected").val();
    var modelSelect = $('#model');
    modelSelect.empty().append('<option value="">Select a Model</option>');

    if (brandId) {
        $.ajax({
            type: 'POST',
            url: site_url + 'getModels',
            data : { 'brand_id' : brandId},
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (data) {
                $.each(data, function (key, model) {
                    modelSelect.append('<option value="' + model.id + '">' + model.name + '</option>');
                });
                modelSelect.append('<option value="other">Other</option>');
                if(model_id){
                    $('select[name^="model"] option[value=' + model_id + ']').attr("selected", "selected");
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    }
}


    // $(document).ready(function() {
    //     $('#image').on('change', function() {
    //         var selectedImages = [];

    //         $.each(this.files, function(index, file) {
    //             if (file.type.match('image.*')) {
    //                 var reader = new FileReader();

    //                 reader.onload = function(e) {
    //                     var imagePreview = $('<div class="image-preview"></div>');
    //                     var img = $('<img>').attr('src', e.target.result);
    //                     var deleteButton = $('<button class="delete-button">X</button>');

    //                     deleteButton.on('click', function() {
    //                         imagePreview.remove();
    //                     });

    //                     imagePreview.append(img);
    //                     imagePreview.append(deleteButton);
    //                     $('.image-preview-container').append(imagePreview);

    //                     selectedImages.push(file);
    //                 };

    //                 reader.readAsDataURL(file);
    //             }
    //         });
    //     });
    // });

// Vehicle Info Page js
