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
            <h6 class="m-0 text-dark get_title_text"> Fee Settings </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Fee Settings  </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


 <section class="container-fluid"> <!-- container-fluid -->
     <!-- 
      store_fee_discount
     -->
     
     <div class="modal fade" id="store_fee_discount_modal">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title"> Set Discount Fee for a student </h6>
              <button title="Close" type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <p> Enter the student's portal ID you wish to give a discount </p>
              <p><b>  NB: </b> <small> Discount Amount is the amount assigned to a student which he/she is not Expected to Pay</small></p>
              <form class="store_fee_discount_form">
                  @csrf()
                <input type="hidden" name='school_id' value='{{$user->school_id}}'>
                <input type="hidden" name='sessions' value='{{$user->active_academic_session()->sessions }}'>
                <input type="hidden" name='term' value='{{$user->active_academic_session()->term }}'>
                <input type="hidden" name='created_by' value="{{$user->last_name.' '.$user->first_name. ' '.$user->other_name .' - '.$user->id}}">
             
               <div class="row"><!-- row -->
                  <div class="col-md-12"> <!-- col -->
                     <div class="form-group">
                       <label for=""> Student ID * </label>
                       <input required id="fee_discount_student_id" type="number" class='form-control' name='student_id' placeholder='Student Portal ID'>
                     </div>
                  </div> <!-- /col -->

                  <div class="col-md-12"> <!-- col -->
                     <div class="form-group">
                       <label for=""> Student Name * </label>
                       <input required id="fee_discount_student_name" type="text" class='attr_loading form-control' readonly name='student_name' placeholder='Enter Student ID first... '>
                     </div>
                  </div> <!-- /col -->

                  <div class="col-md-12"> <!-- col -->
                     <div class="form-group">
                       <label for=""> Class  * </label>
                       <input required id="fee_discount_student_class" type="text" class='attr_loading form-control' readonly name='classes' placeholder='Enter Student ID first... '>
                     </div>
                  </div> <!-- /col -->

                  <div class="col-md-12"> <!-- col -->
                     <div class="form-group">
                       <label for=""> Arm </label>
                       <input required id="fee_discount_student_arm" type="text" class='attr_loading form-control' readonly name='arms' placeholder='Enter Student ID first... '>
                     </div>
                  </div> <!-- /col -->

                        <div class="col-md-12">
                          <div class="form-group">
                              <label for=""> Select Fee Type * </label>
                              <select required name="fee_type" class='fee_type_options form-control'></select>
                          </div>
                        </div>

                         <div class="col-md-12">
                          <div class="form-group">
                              <label for=""> Discount (&#8358;) * </label>
                              <input type="number" step="any" required name="amount" placeholder="Discount Amount" class='form-control'>
                          </div>
                        </div>

                         <div class="col-md-12">
                          <div class="form-group">
                              <label for=""> Narration </label>
                              <input type="text" name="description" placeholder="Reason for the Fee discount..." class='form-control'>
                          </div>
                        </div>                 

                  <div class="col-md-12">
                    <div class="justify-content-center d-flex">
                      <div class="form-group">
                       <button class="btn btn-block btn-success">
                          <i class="hide fa fa-spin fa-spinner store_fee_discount_loader"></i> 
                          Submit
                       </button>
                      </div>
                    </div>
                  </div>
                  
                </div> <!-- /row -->
              </form>
            </div>
            
           </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- / End store_fee_discount -->


 
  <!-- 
      store_fee_allocation_modal 
     -->
     <div id="store_fee_allocation_modal" class="modal fade "> 
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h6 class="modal-title"> Allocate Fee to a class </h6>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->
        <p class="text-center"> Allocate fees to available classes/arms in your school </p>

        <form class='store_fee_allocation_form'>
            @csrf()
            <input type="hidden" name='school_id' value='{{$user->school_id}}'>
            <input type="hidden" name='created_by' value='{{$user->last_name ." ".$user->first_name." ".$user->other_name." - ". $user->id}}'>
            <input type="hidden" name='sessions' value="{{$user->active_academic_session()->sessions}}">
            <input type="hidden" name='term' value="{{$user->active_academic_session()->term}}">
                  <div class="row">

                       <div class="col-md-6">
                       <div class="form-group">
                             <label for=""> Class </label>
                             <select required name="classes" class="form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_school_classes() as $clas )
                                   <option value="{{ $clas->name }}"> {{$clas->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                             <label for=""> Arms </label>
                             <select required name="arms" class="form-control">
                                   <option value=""> - Select - </option>
                                   <option value=" "> None </option>
                                   @foreach( $user->get_school_arms() as $arm )
                                   <option value="{{ $arm->name }}"> {{$arm->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div>

                         <div class="col-md-6">
                          <div class="form-group">
                              <label for=""> Select Fee Type </label>
                              <select required name="fee_type" class='change_fee_option form-control fee_type_options'></select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                              <label for=""> Select Fee Item </label>
                              <select required name="fee_type_item" class='form-control fee_type_item_option'>
                                  <option value=""> - Select Fee Type First - </option>
                              </select>
                          </div>
                        </div>

                         <div class="col-md-6">
                          <div class="form-group">
                              <label for=""> Item Amount (&#8358;)</label>
                              <input type="number" step="any" required name="amount" placeholder="Enter Fee Amount" class='form-control'>
                          </div>
                        </div>

                      <div class="col-md-12">
                         <div class="justify-content-center d-flex">
                         <div class="form-group">
                              <button type='submit' class="btn-block btn btn-sm btn-success"> 
                                  <i class="fa fa-spinner store_fee_allocation_loader hide fa-spin"></i> 
                                   Allocate Fee
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
<!-- /.... End store_fee_allocation_modal -->

     
 <section class="card"> <!-- card -->
 <div class="card-header d-flex">

 <p class="float-left"> Click on <b> Menu </b> to navigate to other sections </p>
               
               <ul class="nav nav-pills ml-auto float-rigth">
                 <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                     <b> Menu  <span class="caret"></span> </b>
                   </a>
                   <div class="dropdown-menu dropdown-menu-right">
                     <button class="dropdown-item" tabindex="-1" href="#tab_1" data-toggle="tab"> Fee Setup </button>
                     <div class="dropdown-divider"></div>
                     <button class="dropdown-item " tabindex="-1" href="#tab_2" data-toggle="tab"> Allocate Fees to Class </button>
                     <div class="dropdown-divider"></div>
                     <button class="dropdown-item " tabindex="-1" href="#tab_3" data-toggle="tab"> Fee Discounts </button>            
                   </div>
                 </li>
               </ul>
 </div>

<section class="card-body"> <!-- card-body  -->
       
     <div class="tab-content"> <!-- tab content -->
                    <section class="active tab-pane" id="tab_1">
                      <p> Enter all Fees Paid in your school </p>

                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist"> <!-- Nav-Tab -->
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#tab1" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true"> Fee Items ( <b> <span class="fee_item_total"></span> </b> ) </a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#tab2" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false"> Fee Category ( <b> <span class="total_fee_type"></span> </b> ) </a>
                  </li>
                </ul> <!-- //Nav-tab -->
                
                <section class="tab-content" id="custom-tabs-three-tabContent"> <!-- TAB-CONTENT -->

                  <section class="tab-pane slide show active" id="tab1" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                     <div class="container mt-3">
                       <p class="text-muted"> Enter the Items of a Fee Type/Category </p>

               <form method="post" id="store_fee_items_form" class="form-horizontal">
                              @csrf()
                    <input type="hidden" name='school_id' value='{{ $user->school_id }}'>

                    <div class="container mt-3"> <!-- Container -->

                    <div class="row"> <!-- row -->

                      <section class="col-md-4"> <!-- col -->
                        <div class="form-group">
                        <label for=""> Fee Category </label>
                        <select required name="fee_type" class='form-control fee_type_options'></select>
                        </select>
                        </div>
                      </section> <!-- //col -->

                      <section class="col-md-4"> <!-- col -->
                      <label for=""> Item Name </label>
                        <div class="form-group">
                          <input placeholder="E.g: I.D Card etc" type="text" name='name' required class="form-control">
                        </div>
                      </section> <!-- //col -->

                      <section class="col-md-4"> <!-- col -->
                      <label for=""> &nbsp; </label>
                        <div class="form-group">
                          <button type="submit" class="btn-block no_fill btn btn-success"> 
                          <i class="fa fa-spin fa-spinner store_fee_item_loader hide"></i>
                            Submit </button>
                        </div>
                      </section> <!-- //col -->

                    </div> <!-- //row -->
                </form>

                    <section class="">
                        <button type="button" class="delete_fee_type_items_btn btn-sm btn btn-outline-danger">
                          <i class="fa fa-trash delete_fee_type_item_trash_icon"></i>
                          <i class="fa fa-spin fa-spinner delete_fee_type_item_loader_icon hide"></i>
                            Remove Items 
                          </button>

                    <form id="fee_item_input_val">
                      @csrf()
                      <div class="table-responsive mt-3">
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th> <input type="checkbox" class="checkedAll3"> </th>
                              <th> Fee Category  </th>
                              <th> Fee Item Name </th>
                            </tr>
                          </thead>
                          <tbody id="fee_type_item_table"></tbody>
                        </table>  
                      </div>
                    </form>
                  </section>
                            
                    </div> <!--/ Container -->

                  </form>


                     </div>
                   </section>
                   <!-- NAV-TAB 1 -->



                   <section class="tab-pane slide" id="tab2" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">

                   <form method="post" id="store_fee_type_form" class="form-horizontal">
                              @csrf()
                    <input type="hidden" name='school_id' value='{{ $user->school_id }}'>

                    <div class="container mt-3"> <!-- Container -->

                            <label for=""> Fee Category </label>
                            <div class="input-group">
                              <div class="custom-file">  
                                 <input required type="text" name='name' placeholder="E.g: School fees, Waec fee, etc" class="form-control">
                              </div>
                                <div class="input-group-append">
                                  <button type='submit' class="btn-block btn btn-success btn-sm">
                                     <i class="fa fa-spin fa-spinner store_fee_type_loader hide"></i> Submit 
                                  </button>
                               </div>
                            </div>

                    </div> <!--/ Container -->

                </form>


                <div class="mt-4">
                    <button onClick="delete_fee_types()" class="btn btn-outline-danger btn-sm"> 
                        <i class="fa fa-trash remove_fee_trash_icon"></i>
                        <i class="fa fa-spin fa-spinner hide remove_fee_loader_icon"></i>
                         Remove Fee 
                    </button>
                </div>
                      <div class='mt-3 table-responsive'> <!-- Table-responsive -->
                      <form class="delete_fee_types_form">
                                  @csrf()
                          <table class="word_no_wrap table table-hover table-striped table-bordered">
                              <thead>
                                  <tr>
                                      <th> <input type="checkbox" class="check_btn checkedAll"> </th>
                                      <th> Fee name </th>
                                  </tr>
                              </thead>      
                                <tbody id='show_fee_types_table'></tbody>       
                          </table>
                          </form>
                      </div> <!-- //Table-responsive -->

                   </section>
                   <!-- NAV-TAB 1 -->
 
                </section> <!--//// Tab-content -->
                
                

  </section> <!-- end tab-pane1 -->

                     <section class="tab-pane" id="tab_2">
                        <p> Allocate Fees to a Class </p>
                       
                      <div>
                          <p class='float-right'> Total: <span class='total_fee_allocation'></span></p>
                      <a data-target="#store_fee_allocation_modal" data-toggle="modal" href="javascript:void(0)" class="btn btn-sm btn-outline-success">
                            <i class="fa fa-plus"></i> Add New 
                        </a> 
                        <a onClick="delete_fee_allocation()" href="javascript:void(0)" class="btn btn-sm btn-outline-danger">
                            <i class="fa fa-trash delete_fee_allocation_trash_icon"></i> 
                            <i class="hide fa fa-spin fa-spinner delete_fee_allocation_loader_icon"></i> 
                            Remove  
                        </a>
                      </div>
                            
                        
                         <div class='table-responsive mt-3 '> <!-- Table-responsive -->
                         <form class="delete_fee_allocation_form">
                             @csrf()
                          <table class=" word_no_wrap table table-striped table-bordered">
                               <thead >
                                   <tr>
                                      <th> <input type="checkbox" class="checkedAll1 check_btn"> </th>
                                      <th> Fee Type</th>
                                      <th> Fee Type Item </th>
                                      <th> Class </th>
                                      <th> Arm </th>
                                      <th> Term </th>      
                                      <th> Session </th>
                                      <th> Amount ( &#8358; ) </th>
                                      <th> Allocated by </th>
                                      <th> Date </th>
                                  </tr>
                               </thead>
                              <tbody id='fee_allocation_table'></tbody>
                          </table>
                        </form>
                      </div> <!-- //Table-responsive -->

                    </section> <!-- end tab-pane2 -->


                     <section class="tab-pane" id="tab_3">
                        
                         <p> Give Fee Discount to a Student </p>
                        
                            <a data-target="#store_fee_discount_modal" data-toggle="modal" href="javascript:void(0)" class="btn-sm btn btn-outline-success">
                              <i class="fa fa-plus"></i> Add New 
                            </a> 

                            <a onClick="delete_fee_discount()" href="javascript:void(0)" class="btn-sm btn btn-outline-danger">
                              <i class="fa fa-trash delete_fee_discount_trash_icon"></i>
                              <i class="fa fa-spin fa-spinner hide delete_fee_discount_loader_icon"></i>
                               Remove
                            </a> 

                         <div class='mt-3 table-responsive'> <!-- Table-responsive -->
                         <form id="delete_fee_discount_form">
                             @csrf()
                          <table class=" table table-striped table-bordered">
                              <thead class="word_no_wrap">
                                  <tr>
                                      <th> <input type="checkbox" class='checkedAll2'> </th>
                                      <th> Student ID </th>
                                      <th> Student Name </th>
                                      <th> Class </th>
                                      <th> Fee Type </th>
                                      <th> Discount (&#8358;)</th>                 
                                      <th> Term </th>
                                      <th> Session </th>    
                                      <th> Description </th>       
                                      <th> Assigned by </th>
                                      <th> Assigned Date </th>
                                  </tr>
                              </thead>
                              <tbody id="fee_discount_table"></tbody>
                          </table>
                        </form>
                      </div> <!-- //Table-responsive -->
                    </section> <!-- end Tab-pane3 -->
 
                 </div> <!-- //Tab content -->
                 
     </section> <!-- /end card-body -->

 </section> <!-- Card -->

 </section> <!-- //end container-fluid -->

 <script src="{{asset('app_scripts/feeSetup.js')}}"></script> 

@stop
