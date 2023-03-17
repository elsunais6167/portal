@extends('layouts.app')
@section('content')

<div class="content-header"> <!-- content-header --> 
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Dashboard </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Dashboard  </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


 <section class="container-fluid"> <!-- container-fluid -->

 <div class="row"> <!-- row -->

 <section class="col-md-4"> <!-- col -->
 <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="fa-2x far fa-bar-chart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-lg"> Total Revenue </span>
                <span class="info-box-number text-lg"> &#8358; {{ number_format($total_revenues, 2) }}</span>
              </div>
              <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
 </section> <!-- //col -->


 <section class="col-md-4"> <!-- col -->
 <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fa-2x fa fa-money"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-lg"> Total Expenditure </span>
                <span class="info-box-number text-lg">  &#8358; {{ number_format($total_expenses, 2 ) }} </span>
              </div>
              <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
 </section> <!-- //col -->


 <section class="col-md-4"> <!-- col -->
 <div class="info-box mb-3 bg-primary">
              <span class="info-box-icon"><i class="fa-2x fa fa-line-chart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-lg"> Net Income </span>
                <span class="info-box-number text-lg"> &#8358; {{ number_format( $net_revenue, 2)}} </span>
              </div>
              <!-- /.info-box-content -->
  </div>
  <!-- /.info-box -->
 </section> <!-- //col -->

</div> <!-- //row -->

</div>

     
 <section class="card card-success card-outline"> <!-- card -->

    <div class="card-header">
                <h3 class="card-title"> Last 5 Transactions </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
          </div>

     <section class="card-body">

         <div class="table-responsive">
         <table class="word_no_wrap table table-striped">
           <thead>
           <tr>
             <th> Trxn ID</th>
             <th> Student ID </th>
             <th> Student Name </th>
             <th> Fee Type </th>
             <th> Amount Due ( &#8358; )</th>
             <th> Amount Paid ( &#8358; ) </th>
             <th> Balance ( &#8358; ) </th>
             <th> Status </th>
             <th> Term </th>
             <th>Session</th>
           </tr>
           </thead>
           <tbody>
             @foreach( $last_5_trxns as $trxn)
             <tr>
               <td class="text-primary"> {{$trxn->id}} </td>
               <td> {{$trxn->student_id}} </td>
               <td> {{$trxn->student_name}} </td>
               <td> {{$trxn->fee_type}} </td>
               <td> {{ number_format( $trxn->amount_due ) }} </td>
               <td> {{ number_format( $trxn->updated_amount )}} </td>
               <td> {{ number_format( $trxn->balance ) }} </td>
               <td> 
                 @if($trxn->balance == 0)
                   <span class="badge text-sm badge-success"> Complete Payment </span>
                   @else
                   <span class="badge text-sm badge-danger"> Incomplete Payment </span>
                   @endif
              </td>
               <td> {{$trxn->term }} </td>
               <td> {{$trxn->sessions}} </td>
              
             </tr>
             @endforeach
           </tbody>
         </table>
         </div>
     </section>
 </section> <!-- Card -->



 <section class="card card-warning card-outline"> <!-- card -->

 <div class="card-header">
                <h3 class="card-title"> Last 5 Expenditures </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
          </div>
 
     <section class="card-body">
  
         <div class="table-responsive">
         <table class=" table table-striped">
           <thead class="word_no_wrap">
           <tr>
             <th> Receiver </th>
             <th> Amount ( &#8358; )</th>
             <th> Description </th>
             <th> Term </th>
             <th> Session</th>
           </tr>
           </thead>
           <tbody>
             @foreach( $last_5_expenses as $expense)
             <tr>
               <td> {{$expense->receiver}} </td>
               <td> {{ number_format( $expense->amount ) }} </td>
               <td> {{$expense->description}} </td>
               <td> {{$expense->term}} </td>
               <td> {{$expense->sessions}} </td>
             </tr>
             @endforeach
           </tbody>
         </table>
         </div>
     </section>
 </section> <!-- Card -->


 <br><br>

 </section> <!-- //end container-fluid -->

@stop
