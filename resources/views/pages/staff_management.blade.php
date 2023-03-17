@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Staff Management </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Staff Management </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->

@if( $user->active_academic_session() )

<section class="container-fluid"> <!-- container-fluid -->
 
<!-- Start modal -->
<div id="register_student_modal" class="modal fade "> 
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h6 class="modal-title"> Add New Staff </h6>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->

             <form action="{{route('register_staff')}}" method="post" class='register_student_form'>
               @csrf()
             <input type="hidden" name='school_id' value="{{ $user->school_id }}">
             <input type="hidden" name='staff' value="1">

                  <div class="row">
                       <div class="col-md-6">
                          <div class="form-group">
                              <label for=""> Surname </label> 
                              <input placeholder="Surname" required type="text" name='last_name' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                              <label for=""> First name </label>
                              <input placeholder="First name" required type="text" name='first_name' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                              <label for=""> Other name  </label>
                              <input placeholder="Other Names"  type="text" name='other_name' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                             <label for=""> Gender </label>
                             <select required name="gender" class="form-control">
                                   <option value=""> - Select - </option>
                                   <option value="male">  Male </option>
                                   <option value="female"> Femae </option>
                             </select>
                          </div> 
                        </div>  

                        <div class="hide col-md-12">
                          <div class="form-group">
                              <label for=""> Password </label>
                              <input value="password" type="hidden" name='password' class="form-control" >
                          </div>
                        </div>

                      <div class="col-md-12">
                          <div class="form-group">
                              <button type='submit' class="btn-block btn btn-success"> 
                                Submit 
                              </button>
                          </div>
                      </div>

                  </div>
            </form>

         </div> <!--modal body -->

     </div>
    </div>
 </div> 
 <!---/end modal --> 

     
 <section class="card"> <!-- card -->

 <div class="card-header">
     <h6> Manage Staff </h6>
 </div>

     <section class="card-body"> <!-- card-body -->
         
        <!-- Button action-->
          <div class="dropdown">
            <button class="btn-sm btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Actions 
            </button>
               <button data-toggle='modal' data-target='#register_student_modal' class="btn-sm btn btn-outline-success"><i class="fas fa-plus"></i> New Staff </button>    
               
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
                <button onClick="make_staff_admin()" type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-user text-muted"></i> Make Staff Admin
                   </button>

                   <div class="dropdown-divider"></div>
                <button onClick="make_staff_sub_admin()" type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-user text-muted"></i> Make Staff Sub Admin
                   </button>

                   <div class="dropdown-divider"></div>
                <button onClick="make_staff_accountant()"  type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-money text-muted"></i> Make Staff Accountant
                   </button>

                   <div class="dropdown-divider"></div>
                   <button onClick="remove_staff_as_admin()"  type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-ban text-muted"></i> Remove Staff as Admin
                   </button>  

                   <div class="dropdown-divider"></div>
                   <button onClick="remove_staff_as_sub_admin()"  type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-ban text-muted"></i> Remove Staff as Sub Admin
                   </button>  

                   <div class="dropdown-divider"></div>
                   <button onClick="remove_staff_as_accountant()" type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-ban text-muted"></i> Remove Staff as Accountant
                   </button>   

                   <div class="dropdown-divider"></div>      
                   <button onClick="delete_staff()" type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-trash text-muted"></i> Delete Staff
                   </button>
                </div>
           </div>
          <hr>
          <!-- ///Button Action  -->

          <div class="table-responsive"> <!-- Div Table -->
            <table class=" word_no_wrap table table-striped table-hover">
               <thead>
                 <tr>
                   <th> <input type="checkbox" class="checkedAll check_btn"></th>
                   <th> Staff ID </th>
                   <th> Staff name </th>
                   <th> Gender </th>
                   <th> Admin </th>
                   <th> Sub Admin </th>
                   <th> Accountant </th>
                   <th> Registered Date </th>
                   <th> Action </th>
                 </tr>
               </thead>
               <form class='action_url' method="post">
                   @csrf()
               <tbody>
              
                 @foreach($staff_members as $staff)
                 <tr>
                   <td> <input type="checkbox" value="{{$staff->id}}" name="id[]" class='checkSingle check_btn'> </td>
                   <td> {{$staff->id }} </td>
                   <td> {{ $staff->last_name .' '. $staff->first_name .' ' . $staff->other_name }} </td>
                   <td class='text-capitalize'> {{$staff->gender}} </td>
                  
                   <td>
                     @if($staff->admin)
                     <span class="text-success fa fa-check"></span>
                     @else
                     <span class="text-danger fa fa-ban"></span>
                     @endif
                   </td>

                   <td>
                     @if($staff->sub_admin)
                     <span class="text-success fa fa-check"></span>
                     @else
                     <span class="text-danger fa fa-ban"></span>
                     @endif
                   </td>

                   <td>
                     @if($staff->accountant)
                     <span class="text-success fa fa-check"> </span>
                     @else
                     <span class="text-danger fa fa-ban"> </span>
                     @endif
                   </td>

                   <td> {{date('D, M d, Y - h:ia', strtotime($staff->created_at) ) }} </td>
                   <td>
                   <a href="{{ route('staff-password', $staff->id) }}" class="btn btn-primary btn-sm float-left float-left mr-1" ><i class="fa fa-key"></i></a>
                   </td>
                 </tr>
                 @endforeach        
                 
               </tbody>
               </form>
            </table>
          </div> <!-- ///Div Table  -->
         

     </section> <!-- ///card-body -->

 </section> <!-- Card -->

 </section> <!-- //end container-fluid -->


 @else
 <div> 
   <h5 class="text-center text-danger"> Please, Create and Activate an Academic Session before Proceeding... </h5>
 </div>
 @endif


 <script>

   function confirmation(){
     return confirm("Please, Confirm this Activity... ");
   }

   function remove_staff_as_admin(){
     if(this.confirmation()){
       var data = this.data()+'&remove_staff_as_admin=1';
       var url = "/auth0/remove_staff_as_admin";
       $.post(url, data, (res) => {
         if(res.error) return alert(res.error) ;
         window.location.reload();
       });
     }
   }

   function remove_staff_as_sub_admin(){
     if(this.confirmation()){
       var data = this.data()+'&remove_staff_as_sub_admin=1';
       var url = "/auth0/remove_staff_as_sub_admin";
       $.post(url, data, (res) => {
         if(res.error) return alert(res.error) ;
         window.location.reload();
       });
     }
   }

   function make_staff_admin(){
     if( this.confirmation()){
       var data = this.data()+'&make_staff_admin=1';
       var url = "/auth0/make_staff_admin";
       $.post(url, data, (res) => {
         if(res.error) return alert(res.error) ;
         window.location.reload();
        });
     }
   }

   function make_staff_sub_admin(){
     if( this.confirmation()){
       var data = this.data()+'&make_staff_sub_admin=1';
       var url = "/auth0/make_staff_sub_admin";
       $.post(url, data, (res) => {
         if(res.error) return alert(res.error) ;
         window.location.reload();
        });
     }
   }

   function make_staff_accountant(){
    if( this.confirmation()){
      var data = this.data()+'&make_staff_accountant=1';
      var url = "/auth0/make_staff_accountant";
      $.post(url, data, (res) => {
        if(res.error) return alert(res.error) ;
        window.location.reload();
      });
    }
   }

   function remove_staff_as_accountant(){
     if( this.confirmation()){
      var data = this.data()+'&remove_staff_as_accountant=1';
      var url = "/auth0/remove_staff_as_accountant";
      $.post(url, data, (res) => {
        if(res.error) return alert(res.error) ;
        window.location.reload();
       });
     }
   }

   function delete_staff(){
     if( this.confirmation()){
      var data = this.data();
      var url = "/auth0/delete_users";
      $.post(url, data, (res) => {
        window.location.reload();
      });
     }
   }

   function data(){
     return $('.action_url').serialize();
   }
 </script>

@stop




