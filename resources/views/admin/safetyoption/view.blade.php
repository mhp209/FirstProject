<div class="card p-3">

    <div class="container mt-5">
        <h1 class="text-center">Option Details</h1>
        <div class="row">            
            <div class="col-md-6">
                <p><strong>Reason  : </strong>  {{ $SafetyOption->reason_option }}</p>
                <p><strong>Message: </strong>  {{ nl2br($SafetyOption->message) }}</p>
            </div>
        </div>
    </div>

</div>
