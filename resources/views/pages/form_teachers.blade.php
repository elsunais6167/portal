@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Form Teachers </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active">Form Teachers</li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


<!-- Start modal -->
<div id="add_new_form_teacher" class="modal fade "> 
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h6 class="modal-title"> New Class Teacher </h6>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->

             <form action="{{route('register_new_form_teacher')}}" method="post" class="">
               @csrf()
             <input type="hidden" name='school_id' value="{{ $user->school_id }}">
        
                  <div class="row">
                  <div class="col-md-12">
                          <div class="form-group">
                             <label for=""> Teacher  </label>
                             <select required name="user_id" class="form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->fetch_all_staff() as $staff )
                                   <?php $name = $staff->last_name. ' '.$staff->first_name; $id = $staff->id; ?>
                                   <option value="{{ $id.'/'.$name}}"> {{ $name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div> 

                        <div class="col-md-6">
                          <div class="form-group">
                             <label for=""> Class </label>
                             <select required name="classes" class="form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_school_classes() as $klas )
                                   <option value="{{ $klas->name }}"> {{ $klas->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                             <label for=""> Arm </label>
                             <select name="arms" class="form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_school_arms() as $arms )
                                   <option class='text-capitalize' value="{{ $arms->name }}"> {{ $arms->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div> 

                        <div class="col-md-12">
                           <div class="justify-content-center d-flex">
                           <div class="form-group">
                              <button type='submit' class="btn btn-success"> 
                                Add Teacher 
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
 <!---/end modal --> 


<section class="container-fluid">
    <div class="card">
        <section class="card-header"> 
            <h6> All Class Teachers &nbsp;
             <button data-toggle="modal" data-target="#add_new_form_teacher" class="btn-sm btn-success"> Add New </button> 
            </h6>
        </section>
        <section class="card-body">
            <div class="table-responsive">
                <table class="table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> Name </th>
                            <th> Class </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $form_teachers as $form_teacher )
                        <tr>
                            <td> {{ $form_teacher->name }} </td>
                            <td> {{ $form_teacher->classes. ' '. $form_teacher->arms }} </td>
                            <td> <a href="{{route('remove_form_teacher', ['u_id' => $form_teacher->id])}}" class="btn-sm btn btn-danger"> Remove </a>   </td>
                        </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(! $form_teachers->count() ) 
            <p class="text-center text-muted"> You have Not assigned a Class Teacher Yet ! </p>
            @endif
        </section>
    </div>
</section>

@stop
