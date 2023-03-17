@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6"> 
            <h6 class="m-0 text-dark get_title_text"> Students Management </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Students Management </li>
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
                 <h6 class="modal-title"> Add New Student </h6>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->
             
             <form action="{{ route('register_student') }}" method="post" class='register_student_form' enctype='multipart/form-data'>
               @csrf()
             <input type="hidden" name='school_id' value="{{ $user->school_id }}">
             <input type="hidden" name='student' value="1">
             <input type="hidden" name='target_session' value="{{ $user->active_academic_session()->sessions }}">

                  <div class="row">
                       <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Surname </label>
                              <input placeholder="Surname" required type="text" name='last_name' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> First name </label>
                              <input placeholder="First name" required type="text" name='first_name' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Other name  </label>
                              <input placeholder="Other Names"  type="text" name='other_name' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                             <label for=""> Gender </label>
                             <select required name="gender" class="form-control">
                                   <option value=""> - Select - </option>
                                   <option value="male">  Male </option>
                                   <option value="female">Female </option>
                             </select>
                          </div> 
                        </div> 

                         <div class="col-md-4">
                          <div class="form-group">
                             <label for=""> Class </label>
                             <select required name="target_class" class="form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_school_classes() as $clas )
                                   <option value="{{ $clas->name }}"> {{$clas->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div> 

                        <div class="col-md-4">
                          <div class="form-group">
                             <label for=""> Arms </label>
                             <select name="target_arm" class="form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_school_arms() as $arm )
                                   <option value="{{ $arm->name }}"> {{$arm->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div>


                        <div class="col-md-4">
                          <div class="form-group">
                             <label for=""> Religion </label>
                             <select required name="religion" class="form-control">
                                   <option value=""> - Select - </option>
                                   <option value="Christian">  Christian </option>
                                   <option value="Islam"> Islam</option>
                                   <option value="Hindu"> Hindu</option>
                             </select>
                          </div> 
                        </div>  

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Date of birth </label>
                              <input placeholder="dd/mm/yyyy"  type="date" name='dob' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Guardian/Parent name </label>
                              <input placeholder="Guardian name..."  type="text" name='parent_name' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Guardian/Parent Phone </label>
                              <input placeholder="Guardian phone..."  type="text" name='parent_phone_number' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Health Problem </label>
                              <input placeholder="Medical Issues..."  type="text" name='health_problem' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Address </label>
                              <input placeholder="Address.."  type="text" name='address' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                              <label for=""> Student Passport </label>
                              <input  type="file" name='image' class="form-control" >
                          </div>
                        </div>

                        <div class="hide col-md-12">
                          <div class="form-group">
                              <label for=""> Password </label>
                              <input value="12345678" type="hidden" name='password' class="form-control" >
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




 <!-- Start class movement modal -->
<div id="move_student_student_modal" class="modal fade "> 
     <div class="modal-dialog modal-md">
         <div class="modal-content">
             <div class="modal-header">
                 <h6 class="modal-title"> Move students to a new class </h6> 
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->
             
             <form action="{{ route('register_student') }}" method="post" class='register_student_form'>
               @csrf()
             <input type="hidden" name='school_id' value="{{ $user->school_id }}">
             <input type="hidden" name='move_students__' value="1">
             <input type="hidden" name="_student_id" class="student_id_">
                  <div class="row">
                    
                         <div class="col-md-12">
                          <div class="form-group">
                             <label for=""> Session </label>
                             <select required name="target_session" class="form-control">
                                   <option value=""> - Select - </option> 
                                   <option value="2020/2021"> 2020/2021 </option>
                                   <option value="2021/2022"> 2021/2022 </option>
                                   <option value="2022/2023"> 2022/2023 </option>
                             </select>
                          </div>
                        </div> 

                        <div class="col-md-12">
                          <div class="form-group">
                             <label for=""> Class </label>
                             <select required name="target_class" class="form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_school_classes() as $clas )
                                   <option value="{{ $clas->name }}"> {{$clas->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div> 

                        <div class="col-md-12">
                          <div class="form-group">
                             <label for=""> Arms </label>
                             <select name="target_arm" class="form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_school_arms() as $arm )
                                   <option value="{{ $arm->name }}"> {{$arm->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div> 

                      <div class="col-md-12">
                          <div class="form-group">
                              <button type='submit' class="btn-block btn btn-success"> 
                                 Move Students
                              </button>
                          </div>
                      </div>

                  </div>
            </form>

         </div> <!--modal body -->

     </div>
    </div>
 </div> 
 <!---/end class movement modal --> 



     
 <section class="card"> <!-- card -->

 <div class="card-header">
     <h6> Manage Students </h6>
 </div>

     <section class="card-body"> <!-- card-body -->
         
        <!-- Button action-->
          <div class="dropdown">
            <button class="btn-sm btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Actions 
            </button>
              <button data-toggle='modal' data-target='#register_student_modal' class="btn-sm btn btn-outline-success btn-rounded">
                 <i class="fas fa-plus"></i> New Student 
              </button>
<section class="float-right">
              <form action="?" class="filter_students_record">
                <select required class="form-control filter_class_record">
                  <option value="">-Filter by class- </option>
                  <option value="all">All students</option>
                  @foreach( $user->get_school_classes() as $klas )
                    <option value="{{ $klas->name }}"> {{ $klas->name }} </option>
                  @endforeach
                </select>
                <select class="form-control filter_arm_record">
                  <option value="">-Select arm- </option>
                  @foreach( $user->get_school_arms() as $arm )
                                   <option value="{{ $arm->name }}"> {{ $arm->name }} </option>
                                   @endforeach
                </select>
                <button class="btn btn-outline-info btn-sm" type="submit"> Search </button>
              </form>
</section>
      
              
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">         
                   <button type='button' class="btn-sm dropdown-item move_students_btn">
                    <i class="fa fa-arrow-right text-muted"></i> Move Students
                   </button>
                   <hr>
                   <!-- <button type='submit' class="btn-sm dropdown-item delete_student_btn">
                    <i class="fa fa-trash text-muted"></i> Delete Students
                   </button> -->
                </div>
           </div>
          <hr>
          <!-- ///Button Action  -->

          <div class="table-responsive"> <!-- Div Table -->
            <table class=" word_no_wrap table table-striped table-hover datatable_">
               <thead>
                 <tr>
                   <th> <input type="checkbox" class="checkedAll check_btn"></th>
                   <th></th>
                   <th> Student ID </th>
                   <th> Student name </th>      
                   <th> Gender </th>
                   <th> Class </th>
                   <th> Session </th>
                   <th> Address </th>
                   <th> Religion</th>
                   <th> Health </th>
                   <th> D.o.B</th>
                   <th> Parent/Guardian </th>
                   <th> Registered Date </th>
                   <th> Action </th>
                 </tr>
               </thead>
               <tbody>
                 @foreach($students as $student)
                 <tr>
                  
                   <td> <input type="checkbox" name="id[]" value="{{ $student->id }}" class='checkSingle check_btn'> </td>
                   <td> {{ display_image($student->photo) }}</td>
                   <td> {{ $student->id}} </td>
                   <td> {{ $student->last_name .' '. $student->first_name .' '. $student->other_name }} </td>
                   <td class='text-capitalize'> {{ $student->gender }} </td>
                   <td class='text-capitalize'> {{ $student->target_class }} {{ $student->target_arm }} </td>
                   <td> {{ $student->target_session }} </td>
                   <td>{{$student->address }}</td>
                   <td>{{ $student->religion }}</td>
                   <td>{{$student->health_problem }}</td>
                   <td>{{$student->dob}}</td>
                   <td>{{$student->parent_name}} <br> {{ $student->parent_phone_number }}</td>
                   <td> {{ date('D, M d, Y - h:ia', strtotime( $student->created_at ) ) }} </td>
                   <td class="p-3"> 
                   <a href="{{ route('student-edit', $student->id) }}" class="btn btn-primary btn-sm float-left float-left mr-1" ><i class="fa fa-edit"></i></a>
                    <form action="{{ route('student-delete', $student->id) }}" method="post">
                      @csrf
                      @method('DELETE')
                      <button onclick="return confirm('Are you sure you want to delete this')" type="submit" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </button>
                    </form>
                  </td>
                 </tr>
                 @endforeach        
                 
               </tbody>
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

   $(function() {
     $('.move_students_btn').on('click', (e) => {
       e.preventDefault();
       var student_id = $('td input:checked').serialize(),
           data = `${student_id}`;
        $('.student_id_').val( decodeURIComponent( student_id ) );
        $('#move_student_student_modal').modal('show');
     });

     $('.filter_students_record').on('submit', (e) => {
        e.preventDefault();
        let class_value = $('.filter_class_record').val();
        let arm_value = $('.filter_arm_record').val();
        if( class_value == 'all') return window.location.href = "?";
        window.location.href = `?filter=1&q=${class_value}&a_=${arm_value}`;
     });
     
   });

 </script>

@stop
