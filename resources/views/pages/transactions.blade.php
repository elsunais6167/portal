@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Daily Fee Transactions  </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Transactions  </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->

 <section class="container-fluid"> <!-- container-fluid -->

 
 <!-- Update Transaction modal -->
<div id="update_transaction_modal" class="modal"> 
     <div class="modal-dialog modal-xl">
         <div class="modal-content">
             <div class="modal-header">
                 <h6 class="modal-title"> Update Transaction Record </h6>
                 <button type="button" class="text-danger close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->

             <p class="update_transaction_section_loader text-center">
                 <i class="fa fa-spin fa-spinner text-info fa-2x"></i>
             </p>

             <p class="text-danger text-center update_transaction_section_info hide">
                 Transaction Not Found, Please, ensure the Transaction ID is Correct
             </p>

                 <section class='hide update_transaction_section'>
                     <p class="text-left"> Transaction ID: <span class="trxn_id"></span> </p>
                     <p class="text-left"> Fee Type: <span class="update_fee_type"></span> </p>

<form id="submit_transaction_update">
<div class="row"> <!-- row -->

    @csrf()
<input type="hidden" name="trxn_id" class="trxn_id form-control">

<div class="col-md-4">
     <div class="form-group">
         <label for=""> Student ID </label>
        <input type="text" readonly name="update_student_id" class="update_student_id form-control">
     </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
         <label for=""> Student Name </label>
        <input type="text" readonly name="update_student_name" class="update_student_name form-control">
     </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
         <label for=""> Class </label>
        <input type="text" readonly name="update_classes" class="update_classes form-control">
     </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
         <label for=""> Arm </label>
        <input type="text" readonly name="update_arms" class="update_arms form-control">
     </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
         <label for=""> Term </label>
        <input type="text" readonly name="update_term" class="update_term form-control">
     </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
         <label for=""> Session </label>
        <input type="text" readonly name="update_sessions" class="update_sessions form-control">
     </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
         <label for=""> Expected Amount </label>
        <input type="text" readonly name="update_expected_amount" class="update_expected_amount form-control">
     </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
         <label for=""> Total Previous Amount Paid </label>
        <input type="text" readonly name="update_previous_amount" class="update_previous_amount form-control">
     </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
         <label for=""> Amount Due </label>
        <input type="text" readonly name="update_amount_due" class="update_amount_due form-control">
     </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
         <label for=""> Amount Paid </label>
        <input type="number" step="any" required name="update_amount" placeholder="Amount being Paid..." class="form-control">
     </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
         <label for=""> Payment Mode </label>
         <select required name="update_payment_mode" class='form-control'>
           <option value=""> - Select - </option>
           <option value="Bank Teller"> Bank Teller</option>
           <option value="Bank Transfer"> Bank Transfer </option>
           <option value="Cash Payment"> Cash Payment</option>
           <option value="Online Transfer"> Online Transfer </option>
           <option value="Other"> Other </option>
         </select>
     </div>
   </div>

   <div class="col-md-4">
     <div class="form-group">
         <label for=""> Narration </label>
        <input type="text" name="update_description" placeholder="Leave a Note... " class="form-control">
     </div>
   </div>


 <div class="col-md-12">
     <div class="d-flex justify-content-center">
     <div class="form-group">             
        <button type='submit' class="update_trxn_btn btn btn-warning"> 
            Update Transaction
         </button>  
         
          <button type='button' class="hide update_trxn_loader disabled btn btn-secondary"> 
            <i class="fa fa-spin fa-spinner"></i>
             Processing...
         </button> 
     </div>
     </div>
 </div>

</div> <!-- //row -->

</form>

                 </section>

         </div> <!--modal body -->

     </div>
    </div>
 </div> 
<!-- //end update transaction modal-->


<!-- Update balance modal -->
<div id="update_balance_modal" class="modal"> 
     <div class="modal-dialog modal-sm">
         <div class="modal-content">
             <div class="modal-header">
                 <h6 class="modal-title"> Find Transaction </h6>
                 <button type="button" class="text-danger close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->
<form id="update_balance_form">
    @csrf()
                  <div class="row">
                     <div class="col-md-12">
                          <div class="form-group">
                              <label for=""> Enter Transaction ID </label>
                              <input autofocus type="text" id="transaction_id" placeholder="Enter Transaction ID " required name="id" class="form-control">
                          </div>
                        </div>

                      <div class="col-md-12">
                          <section class="justify-content-center d-flex">
                          <div class="form-group">             
                             <button type='submit' class="btn btn-outline-secondary"> 
                                  Search now
                              </button>             
                          </div>
                          </section>
                      </div>

                  </div>
</form>

         </div> <!--modal body --> 

     </div>
    </div>
 </div> 
<!-- //end update balance modal-->


 
<!-- store_revenues modal -->
     <div id="store_fee_revenue_modal" class="modal"> 
     <div class="modal-dialog modal-xl ">
         <div class="modal-content">
             <div class="modal-header">
                 <h6 class="modal-title"> New Transaction </h6>
                 <button type="button" class="text-danger close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->

        <form id='store_fee_revenue_form'>
            @csrf()
                  <div class="row">

                     <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Student Portal ID </label>
                             <input type="number" autofocus id="student_id" placeholder="Enter Student Portal ID" required name="student_id" class="form-control">
                          </div>
                        </div>

                        <div class="col-md-8">
                          <div class="form-group">
                              <label for=""> Student Name </label>
                             <input type="text" required readonly name="student_name" placeholder="Enter Student Portal ID first... " class="attr_loading show_student_name form-control">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Class </label>
                             <input type="text" required readonly name="classes" placeholder="Enter Student Portal ID first... " class="attr_loading show_student_class form-control">
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Arm </label>
                             <input type="text" readonly name="arms" placeholder="Enter Student Portal ID first... " class="attr_loading show_student_arm form-control">
                          </div>
                        </div>

                         <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Select Fee Type </label>
                              <select required name="fee_type" id="fee_type_options" class='feeTypeOptions_ form-control'>
                                <option value=""> - Select Fee Type - </option>
                                @foreach( $user->get_all_fee_types()  as $fee)
                                <option value="{{$fee->name}}"> {{$fee->name }} </option>
                                @endforeach
                              </select>
                          </div>
                        </div>

                         <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Expected Amount (&#8358;) </label>
                              <input type="number" step="any" required readonly name="expected_amount" placeholder="Select Fee type First..." class='feeTypeOptions_ expected_amount form-control'>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Discount (&#8358;) </label>
                              <input type="number" step="any" readonly name="discount_amount" placeholder="Select Student Portal ID first..." value="0.00" class='feeTypeOptions_ discount_amount form-control'>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Amount Payable (&#8358;) </label>
                              <input type="number" step="any" name="amount_payable" readonly placeholder="Select Student Portal ID first..." value="0.00" class='feeTypeOptions_ amount_payable form-control'>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Amount Paid (&#8358;) </label>
                              <input type="number" step="any" required name="amount_paid" placeholder="Amount being paid... " class='form-control'>
                          </div>
                        </div>

                         <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Payment Mode </label>
                              <select required name="payment_mode" class='form-control'>
                                <option value=""> - Select - </option>
                                <option value="Bank Teller"> Bank Teller</option>
                                <option value="Bank Transfer"> Bank Transfer </option>
                                <option value="Cash Payment">  Cash Payment</option>
                                <option value="Online Transfer"> Online Transfer </option>
                                <option value="Other"> Other </option>
                              </select>
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Narration </label>
                              <input name="description" placeholder="Leave a Note... " class='form-control'>
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                             <div class="d-flex justify-content-center">
                             <button type='submit' class="fee_submit_btn btn btn-success"> 
                                  <i class="fa fa-spinner fa-spin hide" id="loader"></i>
                                  Submit 
                              </button> &nbsp;
                              <button type='reset' class="btn btn-secondary"> 
                                  Refresh 
                              </button>   
                             </div>     
                          </div>
                       </div>

                  </div>
            </form>

         </div> <!--modal body -->

     </div>
    </div>
 </div> 
<!-- //end store_revenues modal-->


     
<section class="card"> <!-- card -->

 <div class="card-header">
     <h6> Today's Transactions </h6>
 </div>

    <section class="card-body"> <!-- card-body -->

        <p class='text-primary'>
            <i class="fa-2x fa fa-clock"></i> {{ date('D, M d, Y') }}  - 
            <span class="show_today_date"></span>
        </p>
        <div class="dropdown-divider"></div>

        <div class="mb-3 row"> <!-- row -->

        <div class="col-md-6">
              <p class=''>
              Total Transactions:
              <span class="badge badge-primary text-sm"> <span class="total_transactions"></span> </span> 
             </p>
             <div class="dropdown-divider"></div>
            </div>

            <?php
           /****
            * 
            <div class="col-md-6">
              <p class=''>
              Total Complete Transactions:
              <span class="badge badge-success text-sm"> <span class="total_completed_transactions"></span></span>
             </p>
             <div class="dropdown-divider"></div>
            </div>


            <div class="col-md-6">
              <p class=''>
              Total Incomplete Transactions:
              <span class="badge badge-danger text-sm"> <span class="total_incompleted_transactions"></span> </span>
             </p>
             <div class="dropdown-divider"></div>
            </div>
 

             <div class="col-md-6">
               <p class=''>
                Total Expected Payments: <b> &#8358; 
                <span class="total_expected_amount"></span> </b>  
               </p>
               <div class="dropdown-divider"></div>
            </div>
    */
          ?>        
           
           <div class="col-md-6">
              <p class=''>
              Total Received Payments: <b> &#8358;  
              <span class="text-success total_amount_received"></span> </b>  
             </p>
             <div class="dropdown-divider"></div>
            </div>

            <div class="col-md-6">
              <p class=''>
              Total Outstanding Payments:  <b> &#8358; 
              <span class="text-danger total_outstanding_amount"></span>  </b> 
             </p>
             <div class="dropdown-divider"></div>
            </div>

            <div class="col-md-6">
              <p class=''>
              Total Fee Discount:  <b> &#8358; 
              <span class="text-info total_discount_amount"></span> </b>  
              </p>
               <div class="dropdown-divider"></div>
            </div>

        </div><!-- //row -->



        <section class="card card-outline card-outline-tabs"> <!-- card -->

          <div class="no_print card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#tab_1" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true"> <b> Today </b></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#tab_2" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false"> <b> Update Balance </b> </a>
                  </li>
                </ul>
              </div>

              <section class="card-body"> <!-- card-body -->
              <div class="tab-content" id="custom-tabs-three-tabContent">
                  
                   <section class="tab-pane fade show active" id="tab_1" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">


                    <!-- Button action-->
          <div class="dropdown no_print">
            <button class="btn-sm btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Actions 
            </button>  

                 <button data-target="#store_fee_revenue_modal" data-toggle="modal" class="btn btn-outline-success btn-sm">
                        <i class="fa fa-plus"></i> Add New
                </button>
               
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                     <div class="dropdown-divider"></div>
                      <button id="delete_transaction_btn" type='button' class="btn-sm dropdown-item">
                        <i class="fa fa-trash text-muted"></i> Delete Transactions
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

         <div class="print_table_div mt-5 table-responsive">
<form id="delete_transaction_form">
    @csrf()
             <table class='exportToCsv table-striped table-hover table-bordered transaction_datatable'>
                 <thead class='word_no_wrap'>
                     <tr>
                         <th><input type="checkbox" class="checkedAll"> </th>
                         <th> Trnx ID </th>
                         <th> Student ID </th>
                         <th> Name </th>
                         <th> Class </th>
                         <th> Fee type </th>
                         <th> Fee Amount (₦) </th>
                         <th> Discount (₦) </th>
                         <th> Amount Due (₦) </th>
                         <th> Amount Paid (₦) </th>
                         <th> Balance </th>
                         <th> Status </th>
                         <th> Payment Mode </th>
                         <th> Received By </th>
                         <th> Narration </th>
                         <th> Date-Time </th>
                         <th> Receipt </th>
                     </tr>
                 </thead>
             </table>
</form>
         </div>
                   </section> <!-- end tab 1 -->


                   <section class="tab-pane fade" id="tab_2" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">

                      <button data-target="#update_balance_modal" data-toggle="modal" class="find_trxn_btn btn btn-outline-info btn-sm">
                        <i class="fa fa-search"></i> Find Transaction
                      </button>  

                      <div class="mt-4 print_table_div table-responsive"> <!-- div table -->
                         <table id="updated_balance_transaction_datatable" class="table-bordered table-hover table-striped">
                             <thead class="word_no_wrap">
                                 <tr>
                                     <th> Trxn Ref ID </th>
                                     <th> Student ID </th>
                                     <th> Student Name </th>
                                     <th> Class </th>
                                     <th> Fee Type </th>
                                     <th> Amount Due </th>
                                     <th> Previous Total Paid</th>
                                     <th> Amount Paid </th>
                                     <th> Balance </th>
                                     <th> Status </th>
                                     <th> Payment Mode </th>
                                     <th> Received By </th>
                                     <th> Narration </th>
                                     <th> Date </th>
                                 </tr>
                             </thead>
                         </table>
                      </div> <!-- //div table -->

                  </section> <!-- end tab 2-->

              </div>
              </section> <!-- //card-body -->

        </section> <!-- //card -->



    </section> <!-- //card-body -->

 </section> <!-- Card -->


 </section> <!-- //end container-fluid -->


 <script src="{{asset('app_scripts/transactions.js')}}"></script>

@stop

