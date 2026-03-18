<?php
   $admin_email= 'roadsathi@gmail.com' ;
   $admin_mobile= '9999999999';
    ?>

<link href="{{ asset('admin_assets/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- <link href="{{asset('public/css/custom.css')}}" rel="stylesheet"> -->
<!------ Include the above in your HEAD tag ---------->
<style type="text/css">
	/*.pull-left{
		float: left;
	}

	.pull-right{
		float: right;
	}*/
	body{
	   width:100%!important;
	   font-size:12px;
	   .container{
	   width: 700px;
   }
   .outer_border{
   border:1px solid #999999!important;
   padding:4%!important;
   margin-bottom:2%!important;
   }
   .top_box{
  	 width:47%; padding:0%
   }
   .table_pad{
   padding:0% 2%;
   }
   .border{
   border:1px solid #CCCCCC!important;
   }
   .small_text{
   font-size:10px!important;
   }
   .bg_color1{
   background:#3a5082;
   color: #fff;
   }
   .text_color1{
   color:#3a5082;
   }
   td{
   padding:4px;
   }
</style>

<div class="container">
   <div class="outer_border">
      <div class="row">
        <div class="pull-left top_box  p-4">
            <h2 class="text_color1" style="font-size:30px">
            Road-Sathi </h2>
            Phone : {{ $admin_mobile }}
            Email : {{ $admin_email }}
            Website : {{ config('app.url') }}
        </div>
        <div style="" class="pull-right top_box p-4">
            <h2 style="color:#687cbf;font-weight: bold;font-size:30px; text-align:right; padding-right: 30px;" style="color:#687cbf;font-weight: bold;font-size:30px; text-align:right; padding-right: 30px;" id="invoice">INVOICE</h2>
            <table width="100%" height="70" border="0" class="table_pad">
               <tr>
                  <td > Date</td>
                  <td> <?php $invoice_date = date('jS F Y', strtotime($order->created_at));
                     echo  $invoice_date;
                     ?> </td>
               </tr>
               <tr>
                  <td width="50%">Invoice #</td>
                  <td width="50%">{{$order->order_id}}</td>
               </tr>
               <tr>
                  <td>Customer ID</td>
                  <td>{{$order->id}}</td>
               </tr>
            </table>
        </div>
      </div>
      <div class="row">
         <div class="">
            <table width="100%" border="0">
               <tr>
                  <td colspan="2">
                     <div class="bg_color1" style="text-indent:10px;font-size: 14px;width: 50%;height: 26px;line-height: 24px; ">BILL TO </div>
                     <table width="100%" border="0">
                        <tr>
                           <td width="18%">Name</td>
                           <td width="82%"> {{$order->name}} </td>
                        </tr>
                        <tr>
                           <td>Phone</td>
                           <td>{{$order->mobile_number}}</td>
                        </tr>
                        <tr>
                           <td> Address</td>
                           <td> {{$order->billing_address}},
                           </td>
                        </tr>
                     </table>
                  </td>
               </tr>
               <tr>
                  <td colspan="2"> </td>
               </tr>
            </table>
         </div>
      </div>
      <dd style="clear:both;"></dd>
      <div class="row">
         <table height="82" class=" " style="width:100%;">
            <tr class="bg_color1">
               <td width="70%" height="12" style="padding-left: 10px;">Barcode</td>
               <td width="30%" style="padding-left: 10px;" align="right">AMOUNT</td>
            </tr>
            @php
             	$barcodes = explode(',',$order->barcodes);
            @endphp

            @foreach($barcodes as $barcode)
            <tr class=" ">
               <td> {{ $barcode }} </td>
               <td> Rs. {{ RS_SAFETY_PRICE }} </td>
            </tr>
            @endforeach
            <tr class=" ">
               <td> </td>
               <td> <strong>Total</strong> </td>
               <td align="right">Rs. {{ $order->price }} </td>
            </tr>
         </table>
      </div>
      <div class="row">
         <div style="text-align:center"> If you have any question about this invoice, please contact <br /> {{config('app.name')}}, {{$admin_mobile}}, {{$admin_email}}<br /> <b>Thank You For Your Business!</b> </div>
      </div>
   </div>
</div>
