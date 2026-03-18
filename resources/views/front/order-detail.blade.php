@extends('front.layout.master')


@section('css')

<style type="text/css">
  
  body{
    background:#eee;
  }
  .card {
      box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);
  }
  .card {
      position: relative;
      display: flex;
      flex-direction: column;
      min-width: 0;
      word-wrap: break-word;
      background-color: #fff;
      background-clip: border-box;
      border: 0 solid rgba(0,0,0,.125);
      border-radius: 1rem;
  }
  .text-reset {
      --bs-text-opacity: 1;
      color: inherit!important;
  }
  a {
      color: #5465ff;
      text-decoration: none;   
  }

</style>

@endsection

@section('content')

<div class="container-fluid">
  <div class="container">
    <!-- Title -->
    <div class="d-flex justify-content-between align-items-center py-3">
      <h2 class="h5 mb-0"><a href="#" class="text-muted"></a> Order #{{ $orderdata->order_id }}</h2>
    </div>

    <!-- Main content -->
    <div class="row">
      <div class="col-lg-8">
        <!-- Details -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="mb-3 d-flex justify-content-between">
              <div>
                <span class="me-3">{{ $orderdata->created_at->format('d-m-Y') }}</span>
              </div>
              <div class="d-flex">
                <a class="btn btn-link p-0 me-3 d-none d-lg-block btn-icon-text" href="{{ url('admin/order/invoice', $orderdata->id ) }}"><i class="bi bi-download"></i> <span class="text">Invoice</span></a>
                <div class="dropdown">
                  <button class="btn btn-link p-0 text-muted" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-three-dots-vertical"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-pencil"></i> Edit</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-printer"></i> Print</a></li>
                  </ul>
                </div>
              </div>
            </div>
            <table class="table table-borderless">
              <tbody>
                @php
                  $barcodes = explode(',', $orderdata->barcodes);
                @endphp

                @foreach($barcodes as $barcode)
                  <tr>
                    <td>
                      <div class="d-flex mb-2">
                        <div class="flex-shrink-0">
                          <img src="https://www.bootdey.com/image/280x280/87CEFA/000000" alt="" width="35" class="img-fluid">
                        </div>
                        <div class="flex-lg-grow-1 ms-3">
                          <h6 class="small mb-0"><a href="#" class="text-reset">{{ $barcode }}</a></h6>
                        </div>
                      </div>
                    </td>
                    <td>1</td>
                    <td class="text-end">$500</td>
                  </tr>
                @endforeach   
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2">Subtotal</td>
                  <td class="text-end">${{ $orderdata->price }}</td>
                </tr>
                <tr>
                  <td colspan="2">Shipping</td>
                  <td class="text-end">$0.00</td>
                </tr>
                <!-- <tr>
                  <td colspan="2">Discount (Code: NEWYEAR)</td>
                  <td class="text-danger text-end">-$10.00</td>
                </tr> -->
                <tr class="fw-bold">
                  <td colspan="2">TOTAL</td>
                  <td class="text-end">${{ $orderdata->price }} </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>
        <!-- Payment -->
        <div class="card mb-4">
          <div class="card-body">
            <div class="row">
              <div class="col-lg-6">
                <h3 class="h6">Payment Method</h3>
                <p>{{ $orderdata->payment_method }} - {{ $orderdata->transaction_id }} <br>
                Total: ${{ $orderdata->price }} <span class="badge bg-success rounded-pill">{{ $orderdata->financial_status }}</span></p>
              </div>
              <div class="col-lg-6">
                <h3 class="h6">Billing address</h3>
                <address>
                  <strong> {{ $orderdata->name }}</strong><br>
                  {{ $orderdata->billing_address }}<br>
                  <abbr title="Phone">P:</abbr> {{ $orderdata->mobile_number }}
                </address>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <!-- Customer Notes -->
        <div class="card mb-4">
          <div class="card-body">
            <h3 class="h6">Customer Notes</h3>
            <!-- <p>Sed enim, faucibus litora velit vestibulum habitasse. Cras lobortis cum sem aliquet mauris rutrum. Sollicitudin. Morbi, sem tellus vestibulum porttitor.</p> -->
          </div>
        </div>
        <div class="card mb-4">
          <!-- Shipping information -->
          <div class="card-body">
            <h3 class="h6">Shipping Information</h3>            
            <h3 class="h6">Address</h3>
            <address>
              <strong> {{ $orderdata->name }}</strong>
              <br><p>{{ $orderdata->billing_address }}</p><br>
              <abbr title="Phone">P:</abbr> {{ $orderdata->mobile_number }}
            </address>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
