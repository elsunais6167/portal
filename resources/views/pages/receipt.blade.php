<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $school->name }} - Payment Receipt </title>
    @include('partials.app_css')
</head>
<style>
    body{
        zoom:85%;
    }
</style>
<body>

<?php 
$domain = "https://app.schoolportal360.com.ng/";
$logo_url = $domain."uploaded_files/school_logo/".$school->id.'/'.$school->logo;
$sub_fees = $receipt->fee_transaction_balance;
?>

<section class="mt-3 container-fluid card ">
    <section class="card-body">
<h6> Receipt Transaction ID: {{$receipt->id }} </h6>

@if($school->logo)
<div class="mt-3 d-flex justify-content-center">
    <img src="{{$logo_url}}" style="height:100px; width:auto;" alt="" class="img-thumbnl"> 
</div>
@else
<div class="mt-3 d-flex justify-content-center">
    <img src="/img/logo.jpg" style="height:100px; width:auto;" alt="" class="img-thumbnl"> 
</div>
@endif
<h5 class="mt-2 text-center"> <b> {{ $school->name }} 
    <br> {{ $school->address }}
    </b>
</h5>

<section class='mt-3'>
    <section class="">

    <div class="card">
        <div class="card-body">
            
            <table class="text-capitalize table-striped table-bordered">
                <tbody>
                    <tr>
                        <th> Portal ID </th>
                        <td> {{ $receipt->student_id }} </td>
                    </tr>
                    <tr>
                        <th> Name </th>
                        <td> {{ $receipt->student_name }} </td>
                    </tr>
                    <tr>
                        <th> Class </th>
                        <td> {{ $receipt->classes }} {{ $receipt->arms }} </td>
                    </tr>
                    <tr>
                        <th> Academic Session </th>
                        <td> {{ $receipt->term }} - {{ $receipt->sessions }} </td>
                    </tr>

                    <tr>
                        <th> Fee Type </th>
                        <td> {{ $receipt->fee_type }} </td>
                    </tr>

                    <tr>
                        <th> Total Amount Paid </th>
                        <td> ₦ {{ $receipt->get_total_fee_amount_paid($receipt->id, $receipt->amount_paid ) }} </td>
                    </tr>

                    <tr>
                        <th> Balance </th>
                        <td> ₦ {{ number_format( $receipt->balance ) }} </td>
                    </tr>
                   
                    <tr>
                        <th> Transaction Status </th>
                        <td> @if( $receipt->balance == 0 ) Paid @else Incomplete Payment  @endif </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>


   <section class="container "> <!-- container -->
   <div class="card ml-5 mr-5"> <!-- card -->
       
        <div class="card-body">
            <!-- Table  -->
            <div class="table-responsive">
                <table class="table-striped">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Fee Item </th>
                            <th> Amount </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $receipt->get_associated_fee_type_items( $receipt->fee_type ) as $fee_item )
                        <tr>
                            <td>   {{ $loop->index + 1 }} </td>
                            <td>   {{ $fee_item->fee_type_item }} </td>
                            <td> ₦ {{ number_format( $fee_item->amount) }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th></th>
                            <th> Total = ₦ {{ number_format( $receipt->get_associated_fee_type_items_total_amount( $receipt->fee_type ) ) }} </th>
                        </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </div><!-- //card -->

</section><!-- //container -->



<section class="container-fluid">
        <h6 class='mt-4'> <b> Payment Transaction </b> </h6> 
            <table class="table-bordered table-striped">
                <thead>
                    <tr>
                        <th> Discount </th>
                        <th> Amount Paid </th>
                        <th> Payment Mode </th>
                        <th> Date </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> ₦ {{ $receipt->discount_amount }} </td>
                        <td> ₦ {{ number_format( $receipt->amount_paid ) }} </td>
                        <td>   {{ $receipt->payment_mode }} </td>
                        <td>   {{ $receipt->created_at }} </td>
                    </tr>
                </tbody>
            </table>
 </section>


@if($sub_fees->count() )
            <h6 class='mt-5'> <b> Sub-Payment Transaction </b> </h6>
            <table class="table-bordered table-striped">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> Previous Amount Paid </th>
                        <th> Amount Paid </th>
                        <th> Payment Mode </th>
                        <th> Date </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach( $sub_fees as $sub_fee )
                    <tr>
                        <td> {{ $loop->index + 1 }} </td>
                        <td> ₦ {{ number_format( $sub_fee->initial_amount_paid ) }} </td>
                        <td> ₦ {{ number_format( $sub_fee->new_amount_paid ) }} </td>
                        <td> {{ $sub_fee->payment_mode}} </td>
                        <td> {{ $sub_fee->created_at}} </td>                   
                    </tr>
                    @endforeach
                </tbody>
            </table>
    @endif
    
    <p class="text-center">
        <button class='btn no_print btn-outline-primary' onClick="print_docs()"> <i class="fa fa-print"></i> Print Receipt </button>
    </p>

    </section> <!-- //card-body -->
</section>
<!-- //card -->

    </section> <!-- //card-body -->
</section> <!-- //card -->

<script>
window.addEventListener('click', function(){
    $('.no_print').show();
  });

  function print_docs()
  {
    $('.no_print').hide();
    window.print();
  }

</script>

</body>
</html> 

