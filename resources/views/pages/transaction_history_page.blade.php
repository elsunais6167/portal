@extends('layouts.app')
@section('content')

<?php 
     $user = auth()->user(); 
     $current = $user->active_academic_session();
?>

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Transaction History </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Transaction History </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


<!-- search  modal -->
<div id="search_modal" class="modal"> 
     <div class="modal-dialog modal-sm">
         <div class="modal-content">
             <div class="modal-header">
                 <h6 class="modal-title"> Search Records  </h6>
                 <button type="button" class="text-danger close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->

        <form id='search_records_form'>
                  <div class="row">   

                        <div class="col-md-12">
                          <div class="form-group">
                             <label for=""> Session </label>
                             <select required name="sessions" class="session_search form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_all_sessions() as $session )
                                   <option value="{{ $session->name }}"> {{ $session->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div> 
                       
                        <div class="col-md-12">
                          <div class="form-group">
                             <label for=""> Term </label>
                             <select name="term" class="term_search form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_all_terms() as $term )
                                   <option class='text-capitalize' value="{{ $term->name }}"> {{ $term->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                             <label for=""> Fee Type </label>
                             <select name="fee_type" class="fee_type_search form-control">
                                   <option value=""> All </option>
                                   @foreach( $user->get_all_fee_types() as $fee )
                                   <option class='text-capitalize' value="{{ $fee->name }}"> {{ $fee->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div> 

                        <div class="col-md-12">
                          <div class="form-group">
                             <label for=""> Transaction Type </label>
                             <select name="transaction_type" class="transaction_type_search form-control">
                                   <option value=""> - Select - </option>
                                   <option value="debtors"> Debtors </option>
                                   <option value="complete_payments"> Complete Payments </option>
                             </select>
                          </div>
                        </div> 

                        <div class="col-md-12">
                          <section class="justify-content-center d-flex">
                          <div class="form-group">
                              <button type='submit' id="search_query_btn" class="btn btn-outline-warning"> Search Records </button>
                          </div>
                          </section>
                        </div>

                  </div>
            </form>

         </div> <!--modal body -->

     </div>
    </div>
 </div> 
<!-- //end search records modal-->




 <section class="container-fluid"> <!-- container-fluid -->
     
 <section class="card"> <!-- card -->
 <div class="card-header">
     <h6> Transaction History Report </h6>
 </div>
     <section class="card-body">

                    <!-- Button action-->
                    <div class="dropdown no_print mb-4 ">
            <button class="btn-sm btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Actions 
            </button>  
               
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                   
                <div class="dropdown-divider"></div>
                     <button id="delete_transaction_btn" type='button' class="btn-sm dropdown-item">
                        <i class="fa fa-trash text-muted"></i> Delete Transactions
                      </button>

                      <div class="dropdown-divider"></div>
                      <button type='button' data-toggle="modal" data-target="#search_modal" class="btn-sm dropdown-item">
                        <i class="fa fa-search text-muted"></i> Search Records 
                      </button>

                      <div class="dropdown-divider"></div>
                      <button onClick="print_docs()" type='button' class=" btn-sm dropdown-item">
                        <i class="fa fa-print text-muted"></i> Print Record
                      </button>

                      <div class="dropdown-divider"></div>
                      <button onClick="exportToCSV()" type='button' class="btn-sm dropdown-item">
                        <i class="fa fa-file-csv text-muted"></i> Export to CSV
                      </button>
                      <div class="dropdown-divider"></div>

                </div> <!-- //Drop-down menu -->

           </div>        
          <!-- ///Button Action  -->


<!-- Transaction History Total Record Amount -->
         
<section class="row"><!-- row -->
<?php
/***
 * 
 * <div class="col-lg-3 trxn_history_amount_col">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3> <sup style="font-size: 20px"> ₦ </sup> <span id="total_expected_amount"></span> </h3>

                <p> Total Expected Payment </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
 */
?>

<div class="col-lg-4 trxn_history_amount_col">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
               <h3> <sup style="font-size: 20px"> ₦ </sup> <span id="total_received_amount"></span> </h3>

                <p> Total Received Payment </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          

          <div class="col-lg-4 trxn_history_amount_col">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><sup style="font-size: 20px"> ₦ </sup> <span id="total_discount"></span></h3>

                <p> Total Discount </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->



          <div class="col-lg-4 trxn_history_amount_col">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
               <h3> <sup style="font-size: 20px"> ₦ </sup> <span id="total_outstanding_payment"></span> </h3>

                <p> Total Outstanding Payment </p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->

</section><!-- //row -->

<!-- Transaction History Total Record Amount -->


       <div class="print_table_div mt-3 table-responsive"> <!-- div-table -->
       <form id="delete_transaction_form">
       @csrf()
          <table class='exportToCsv table-bordered table-striped table-hover transaction_history_datatable'>
                <thead class='word_no_wrap'>
                     <tr>
                         <th> <input type="checkbox" class='checkedAll'> </th>
                         <th> Trnx ID </th>
                         <th> Student ID </th>
                         <th> Name </th>
                         <th> Class </th>
                         <th> Term </th>
                         <th> Session </th>
                         <th> Fee type </th>
                         <th> Fee Amount (₦) </th>
                         <th> Discount (₦) </th>
                         <th> Amount Paid (₦) </th>
                         <th> Balance (₦) </th>
                         <th> Payment Mode </th>
                         <th> Narration </th>
                         <th> Trxn Date </th>
                         <th> Accountant </th>
                         <th> No. Of Payments </th>
                         <th> Receipt </th>          
                     </tr>
                </thead> 
          </table>
</form>

       </div> 
       <!-- //div-table -->

     </section>
 </section> <!-- Card -->

 </section> <!-- //end container-fluid -->

 <script src="{{asset('app_scripts/transaction_history.js')}}"></script>
@stop