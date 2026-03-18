<div class="row">

    <input type="hidden" id="form_type" value="{{ $form_type }}">

    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="first_name" class="form-label">First Name <span class="text text-danger">*</span></label>
            <input type="text" name="first_name"
            class="form-control @error('first_name') is-invalid @enderror" id="first_name" value="{{ $adminObj->first_name ? $adminObj->first_name : old('first_name') }}"
            placeholder="Enter Your First Name">
            @error('first_name')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="last_name" class="form-label">Last Name <span class="text text-danger">*</span></label>
            <input type="text" name="last_name"
            class="form-control @error('last_name') is-invalid @enderror" id="last_name"
            value="{{ $adminObj->last_name ? $adminObj->last_name : old('last_name') }}"
            placeholder="Please Enter Your Last Name">
            @error('last_name')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="email" class="form-label">Email Address <span class="text text-danger">*</span></label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $adminObj->email ? $adminObj->email : old('email') }}" placeholder="Enter Your Email" autocomplete="email">
            @error('email')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-4 mb-3">
        <div class="form-group" id="password-toggle">
            <label for="password" class="form-label">Password  @if($form_type =='add') <span class="text text-danger">*</span> @endif</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror password" name="password" placeholder="Enter Your Password" autocomplete="new-password" />
            <!-- <i class="fas fa-eye-slash" id="togglePassword"></i> -->
            @error('password')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="mobile_number" class="form-label">Mobile Number</label>
            <input type="number" name="mobile_number"
            class="form-control @error('mobile_number') is-invalid @enderror" id="mobile_number"
            value="{{ $adminObj->mobile_number ? $adminObj->mobile_number : old('mobile_number') }}"
            placeholder="Enter Your Mobile Number (eg:1234567890)">
            @error('mobile_number')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="whats_no" class="form-label">Whatsapp Number</label>
            <input type="number" name="whats_no"
            class="form-control @error('whats_no') is-invalid @enderror" id="whats_no"
            value="{{ $adminObj->whats_no ? $adminObj->whats_no : old('whats_no') }}"
            placeholder="Enter Your Whatsapp Number (eg:1234567890)">
            @error('whats_no')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="form-group">
            <label for="role" class="form-label">Role</label>
            <select class="form-control @error('role') is-invalid @enderror" name="role" id="role">
                <option value="">Select User Role</option>
                @foreach (getRoles() as $getRole)
                    @if (!empty($getRole))
                        <option value="{{ $getRole->alias }}" {{ $getRole->alias == $adminObj->role ?  'selected' : ''  }}>{{ $getRole->name }}</option>
                    @endif
                @endforeach
            </select>
            @error('role')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="form-group">
            <a href="{{ route('users.index') }}" class="btn btn-danger mt-2">Cancel</a>
            <button class="btn btn-primary mr-1 mt-2">
                <i class="ri-user-add-fill me-1"></i> Submit
            </button>
        </div>
    </div>
</div>
