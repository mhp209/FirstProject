 <form id="address_frm" method="post" action="{{ route('save.address') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
    @if($title == "Update")
    <input type="hidden" name="id" value="{{ $addressData->id }}">
    @endif
    <div class="modal-body">
        <div class="row gy-3">
            <div class="col-lg-12">

            </div>
            <div class="col-lg-6 first-name">
                <label class="justify-content-center align-items-center ">
                    <span class="material-symbols-outlined">
                        person
                    </span>
                </label>
                <input type="text" name="first_name" id="first_name"
                    class="@error('first_name') is-invalid @enderror" placeholder="First name" value="{{ $addressData->first_name }}">
                @error('first_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <!-- <div class="invalid-feedback"> Valid name is required. </div> -->
            </div>

            <div class="col-lg-6 first-name">
                <label class="justify-content-center align-items-center ">
                    <span class="material-symbols-outlined">
                        person
                    </span>
                </label>
                <input type="text" name="last_name" id="last_name"
                    class="@error('last_name') is-invalid @enderror" placeholder="Last name" value="{{ $addressData->last_name }}">
                @error('last_name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                <!-- <div class="invalid-feedback"> Valid name is required. </div> -->
            </div>


            <div class="col-lg-6 mobile-number">
                <label class="justify-content-center align-items-center ">
                    <span class="material-symbols-outlined">
                        phone_iphone
                    </span>
                </label>
                <input type="number" name="mobile_number"
                    class="@error('mobile_number') is-invalid @enderror" id="mobile_number"
                    placeholder="Mobile Number" value="{{ $addressData->mobile_number }}">
                @error('mobile_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-lg-6 email-wrapper">
                <label class="justify-content-center align-items-center ">
                    <span class="material-symbols-outlined">
                        mail
                    </span>
                </label>
                <input type="text" name="email" id="email"
                    class="@error('email') is-invalid @enderror" placeholder="Email" value="{{ $addressData->email }}" >
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-lg-6 address-wrapper">
                <label class="justify-content-center align-items-center ">
                    <span class="material-symbols-outlined">
                        home
                    </span>
                </label>
                <input type="text" name="add1" id="add1" placeholder="Address 1" value="{{ $addressData->add1 }}">
                @error('add1')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-lg-6 address-wrapper">
                <label class="justify-content-center align-items-center ">
                    <span class="material-symbols-outlined">
                        home
                    </span>
                </label>
                <input type="text" name="add2" id="add2" placeholder="Address 2" value="{{ $addressData->add2 }}">
                @error('add2')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-lg-6 mobile-number">
                <label class="justify-content-center align-items-center ">
                    <span class="material-symbols-outlined">
                        pin_drop
                    </span>
                </label>
                <input type="number" min="0" name="pincode" id="pincode"
                    placeholder="Pincode" value="{{ $addressData->pincode }}">
                @error('pincode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-lg-6 address-wrapper">
                <label class="justify-content-center align-items-center ">
                    <span class="material-symbols-outlined">
                        location_city
                    </span>
                </label>
                <input type="text" name="city" id="city" placeholder="City" value="{{ $addressData->city }}">
                @error('city')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-lg-6 state-wrapper">
                <select name="state" id="state" class="">
                    <option value="">Select a State</option>
                    <option {{ ($addressData->state == 'Gujarat')? 'selected' : ''}}>Gujarat</option>
                    <option {{ ($addressData->state == 'Delhi')? 'selected' : ''}}>Delhi</option>
                    <option {{ ($addressData->state == 'Haryana')? 'selected' : ''}}>Haryana</option>
                </select>
                @error('state')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="same-address"
                    name="is_default" value='1' {{ ($addressData->is_default == '1')? 'checked' : ''}}>
                <label class="custom-control-label" for="same-address">Make this my default
                    Address</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="use-address-btn" >{{ $title }} Address</button>
    </div>
</form>


<script>

$("#address_frm").validate({
        errorElement:'div',
        rules: {
            first_name: {
                required: true,
                // noSpaces: true,
            },
            last_name: {
                required: true,
                noSpaces: true,
            },
            email: {
                required: true,
                noSpaces: true,
                email: true,
            },
            add1: {
                required: true,
            },
            mobile_number: {
                required: true,
                noSpaces: true,
                minlength: 10,
                maxlength: 10
            },
            state: {
                required: true,
            },
            city: {
                required: true,
            },
            pincode: {
                required: true,
            },
        },
        messages: {
            first_name: {
                required: "Please Enter Your First Name",
                // noSpaces: "Name should not contain spaces"
            },
            last_name: {
                required: "Please Enter Your Last Name",
                noSpaces: "Name should not contain spaces"
            },
            email: {
                required: "Please Enter Email Address",
                noSpaces: "Name should not contain spaces",
                email: "Please Enter Valid Email Address"
            },
            add1: {
                required: "Please Enter Address",
            },
            mobile_number: {
                required: "Please Enter Mobile Number",
                noSpaces: "Password should not contain spaces",
                minlength: "Your Mobile Number Must be At Least 10 Characters Long",
                maxlength: "Your Mobile Number Must be At Least 10 Characters Long",
            },
            state: {
                required: "Please Select State",
            },
            city: {
                required: "Please Enter City Name",
            },
            pincode: {
                required: "Please Enter Zip Code",
            },
        },
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            // element.closest('.form-control').after(error);
            element.after(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('has-error').removeClass('has-success');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('has-error').addClass('has-success');
            $(element).next('label.error').remove();
        },

        submitHandler: function (form) {
            if($("#address_frm").valid()) {
                form.submit();
            }
        }
    });

</script>
