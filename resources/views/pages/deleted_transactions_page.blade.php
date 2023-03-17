@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); 
if( ! $user->admin):
  echo redirect()->route('logout') ; 
  exit('Access Denied...');
endif; 
?>

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Deleted Transaction Records </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"><i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Deleted Transaction Records </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


 <section class="container-fluid"> <!-- container-fluid -->
     
 <section class="card"> <!-- card -->
 <div class="card-header">
     <h6> Deleted Transaction Records </h6>
 </div>

     <section class="card-body">

     
                <!-- Button action-->
                <div class="dropdown no_print">
            <button class="btn-sm btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Actions
            </button>  
               
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 

                  <div class="dropdown-divider"></div>
                   <button id="undo_trashed_transaction" class='btn-sm dropdown-item'> 
                        <i class="fa fa-undo"></i> Undo Delete
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


      <div class="print_table_div table-responsive mt-3"> <!-- Div Table -->

<form id="undo_trashed_transaction_form">
  @csrf()
         <table class=" exportToCsv table-striped table-bordered trashed_transaction_datatable_table"> <!-- Table -->
              <thead class='word_no_wrap'>
                <tr>
                  <th> <input type="checkbox" class="check_btn checkedAll"> </th>
                  <th> Trxn ID </th>
                  <th> Student ID </th>
                  <th> Student Name </th>
                  <th> Class </th>
                  <th> Fee Type </th>
                  <th> Amount Paid </th>
                  <th> Balance </th>
                  <th> Payment Mode </th>
                  <th> Deleted By </th>
                  <th> Date </th>
                </tr>
              </thead>
         </table> <!-- //Table -->
</form>

       </div> <!-- //Div table -->

     </section>

 </section> <!-- Card -->

 </section> <!-- //end container-fluid -->
 <script src="{{asset('app_scripts/trashed_transactions.js')}}"></script>
@stop