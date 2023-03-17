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
            <h6 class="m-0 text-dark get_title_text"> Expenditure Reports</h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Manage Expenditures </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


<section class="container-fluid"> <!-- container-fluid -->

<!-- search  modal -->
<div id="search_record_modal" class="modal"> 
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
                             <select required name="sessions" class="search_sessions form-control">
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
                             <select required name="term" class="search_term form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_all_terms() as $term )
                                   <option class='text-capitalize' value="{{ $term->name }}"> {{ $term->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div> 

                        <div class="col-md-12">
                          <section class="justify-content-center d-flex">
                          <div class="form-group">
                              <button type='submit' id="query_record_btn" class="btn btn-outline-warning"> Search Records </button>
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


 
<!-- store-expenses modal -->
<div id="store_expenses_modal" class="modal"> 
     <div class="modal-dialog modal-xl ">
         <div class="modal-content">
             <div class="modal-header">
                 <h6 class="modal-title"> Record Expenditures </h6>
                 <button type="button" class="text-danger close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->

        <form id='store_expenses_form'>
            @csrf()
            <input type="hidden" name="school_id" value="{{ $user->school_id }}">
            <input type="hidden" name="created_by" value="{{$user->last_name.' '.$user->first_name.' '.$user->other_name.' - '.$user->id}}">
            <input type="hidden" name='term' value="{{ $current->term }}">
            <input type="hidden" name='sessions' value="{{ $current->sessions }}">
                  <div class="row">   

                         <div class="col-md-6">
                          <div class="form-group">
                              <label for=""> Receiver </label>
                              <input type="text" required name="receiver" placeholder="Who are you paying?... " class='form-control'>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                              <label for=""> Amount (&#8358;) </label>
                              <input type="number" step="any" required name="amount" placeholder="Total Amount Spent... " class='form-control'>
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                              <label for=""> Description  </label>
                              <textarea name="description" required placeholder="Description... " class='form-control'></textarea>
                          </div>
                        </div>

                      <div class="col-md-12">
                          <div class="form-group">
                             <div class="d-flex justify-content-center">
                             <button type='submit' class="btn btn-success"> 
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
<!-- //end store-expenses modal-->



     
 <section class="card"> <!-- card -->

 <div class="card-header">
     <h6> All Expenditures </h6>
 </div>

     <section class="card-body"> <!-- card-body -->
  
        <!-- Button action-->
        <div class="no_print dropdown mb-3">
            <button class="btn-sm btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Actions 
            </button>
          
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                <button type='button' data-toggle='modal' data-target='#store_expenses_modal' class='dropdown-item btn-sm '>
                  <i class="text-muted fa fa-plus"></i> Add new 
                </button>  
                <div class="dropdown-divider"></div>   

                <button type="button" class="delete_expenses_btn btn-sm dropdown-item">
                    <i class="fa fa-trash text-muted"></i> Delete Records
                </button>

                 <div class="dropdown-divider"></div>   
                 
                <button type='button' data-toggle='modal' data-target='#search_record_modal' class=" btn-sm dropdown-item">
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

                </div>
           </div>
          
          <!-- ///Button Action  -->

       <div class='mb-5'>
         <p> Total: <span class="badge badge-info text-sm"> <span class="total_expenditures"></span> </span> </p>
         <p> Total Expenditure: <b> &#8358; <span class="total_expenditures_amount"></span> </b>  </p>
       </div>

       <div class="table-responsive">
         <form id="delete_expenses_form">
           @csrf()
         <table class=" exportToCsv table table-hover table-striped expenses_datatable">
           <thead class='word_no_wrap'>
             <tr>
               <th><input type="checkbox" class="check_btn checkedAll"> </th>
               <th> Receiver </th>
               <th> Amount (&#8358;) </th>
               <th> Description </th>
               <th> Term </th>
               <th> Session </th>
               <th> Created By </th>
               <th> Date </th>
             </tr>
           </thead>
         </table>
</form>
       </div>
     </section> <!-- //card-body -->

 </section> <!-- Card -->

 </section> <!-- //end container-fluid -->
 <script src="{{asset('app_scripts/expenses.js')}}"></script>

@stop

