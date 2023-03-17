@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Edit Student </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Edit Student Profile  </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->

 <section class="container-fluid"> <!-- container-fluid -->
     
 <section class="card"> <!-- card -->
  <div class="card-header text-sm d-flex">
   Edit Student Profile
  </div>

     <section class="card-body"> <!-- card-body  -->
     
     <form action="{{ route('update-student', $student->id) }}" method="post" class='register_student_form' enctype='multipart/form-data'>
               @csrf()
               @method('PATCH')
             <input type="hidden" name='school_id' value="{{ $user->school_id }}">
             <input type="hidden" name='student' value="1">
             <input type="hidden" name='target_session' value="{{ $user->active_academic_session()->sessions }}">

                  <div class="row">

                  <section class="col-md-12">
                    <div class="form-group text-center">
                      {{ display_image($student->photo, 'img-150') }}
                    </div>
                  </section>

                       <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Surname </label>
                              <input placeholder="Surname" required type="text" value="{{$student->last_name}}" required name='last_name' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> First name </label>
                              <input placeholder="First name" required type="text" value="{{$student->first_name}}" required name='first_name' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Other name  </label>
                              <input placeholder="Other Names"  type="text" value="{{$student->other_name}}" name='other_name' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                             <label for=""> Gender </label>
                             <select required name="gender" class="form-control">
                                   <option value="{{$student->gender}}"> {{ $student->gender}} </option>
                                   <option value="male">  Male </option>
                                   <option value="female">Femae </option>
                             </select>
                          </div> 
                        </div>  

                         <div class="col-md-4">
                          <div class="form-group">
                             <label for=""> Class </label>
                             <select required name="target_class" class="form-control">
                                   <option value="{{$student->target_class}}"> {{ $student->target_class}} </option>
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
                                   <option value="{{$student->target_arm}}"> {{$student->target_arm}} </option>
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
                                   <option value="{{$student->religion}}" selected>{{$student->religion}}</option>
                                   <option value="Christian">  Christian </option>
                                   <option value="Islam"> Islam</option>
                                   <option value="Hindu"> Hindu</option>
                             </select>
                          </div> 
                        </div>  

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Date of birth </label>
                              <input placeholder="dd/mm/yyyy"  type="date" value="{{$student->dob}}" name='dob' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Guardian/Parent name </label>
                              <input placeholder="Guardian name..."  type="text" name='parent_name' value="{{$student->parent_name}}" class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Guardian/Parent Phone </label>
                              <input placeholder="Guardian phone..."  type="text" value="{{$student->parent_phone_number}}" name='parent_phone_number' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Health Problem </label>
                              <input placeholder="Medical Issues..."  type="text" value="{{$student->health_problem}}" name='health_problem' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="form-group">
                              <label for=""> Address </label>
                              <input placeholder="Address.." value="{{$student->address}}"  type="text" name='address' class="form-control" >
                          </div>
                        </div>

                        <div class="col-md-12">
                          <div class="form-group">
                              <label for=""> Update Passport </label>
                              <input  type="file" name='image' accept="image/*" class="form-control" >
                          </div>
                        </div>

                      <div class="col-md-12">
                          <div class="form-group">
                              <button type='submit' class="btn btn-success"> 
                                Update
                              </button>
                              <button type='button' onclick="window.history.back()" class="btn btn-info"> 
                                Go back
                              </button>
                          </div>
                      </div>

                  </div>
            </form>
 </section> <!-- Card -->

 </section> <!-- //end container-fluid -->

@stop