<div class="card p-3">
    <div class="container">
        @if ($Enquiry->hire_name === 'hire_cab')
        <h1 class="text-center">Cab Enquiry Details</h1>
        @else
        <h1 class="text-center">Bus Enquiry Details</h1>
        @endif
        <div class="">
            <div class="col-md-12">
                <p><strong>Name: </strong> {{ $Enquiry->first_name }} {{ $Enquiry->last_name }}</p>
                <p><strong>Email: </strong> {{ $Enquiry->email }}</p>
                <p><strong>Mobile: </strong> {{$Enquiry->mobile_number }}</p>
                <p><strong>Trip Type: </strong> {{$Enquiry->trip_type }}</p>
                <p><strong>Vehicle Type: </strong> {{$Enquiry->type_vehicle }}</p>
                <p><strong>Pick Up City: </strong> {{$Enquiry->pickup_city }}</p>
                <p><strong>Destination City: </strong> {{$Enquiry->dest_city }}</p>
            </div>

        </div>
    </div>

</div>
