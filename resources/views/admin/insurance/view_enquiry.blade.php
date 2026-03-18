<div class="card p-3">
    <div class="container">
        <h1 class="text-center">Enquiry Details</h1>
        <div class="">
            <div class="col-md-12">
                <p><strong>Insurance Name: </strong>  {{ $Enquiry->Insurance->name }}</p>
                <p><strong>Name: </strong>  {{ $Enquiry->first_name }} {{ $Enquiry->last_name }}</p>
                <p><strong>Email: </strong>  {{ $Enquiry->email }}</p>
                <p><strong>Mobile: </strong>  {{$Enquiry->mobile_number }}</p>
                <p><strong>Message: </strong>  <?= nl2br($Enquiry->message) ?></p>
            </div>

        </div>
    </div>

</div>
