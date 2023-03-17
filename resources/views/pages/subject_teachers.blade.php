@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Subject Teachers </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Subject Teachers</li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


<!-- Start modal -->
<div id="add_new_subject_teacher" class="modal fade "> 
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h6 class="modal-title"> New Subject Teacher </h6>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->

             <form action="{{route('register_new_subject_teacher')}}" method="post" class="">
               @csrf()
             <input type="hidden" name='school_id' value="{{ $user->school_id }}">
        
                  <div class="row">
                  <div class="col-md-6">
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
                             <select required name="classes" class="select_class_ form-control">
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
                             <select required name="arms" class="form-control">
                                   <option value=" " selected> - None - </option>
                                   @foreach( $user->get_school_arms() as $arms )
                                   <option class='text-capitalize' value="{{ $arms->name }}"> {{ $arms->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div> 

                        <div class="col-md-6">
                          <div class="form-group">
                             <label for=""> Subject </label>
                             <select required name="subject" class="subject_options form-control">
                                   <option value=""> - Select Subject- </option>
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
            <h6> Assign subject/class to a Teacher &nbsp;
             <button data-toggle="modal" data-target="#add_new_subject_teacher" class="btn-sm btn-success"> Add New </button> 
            </h6>
        </section>
        <section class="card-body">
            <div class="table-responsive">
                <table class="table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> Name </th>
                            <th> Class </th>
                            <th> Subject </th>
                            <th>  Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $subject_teachers as $subject_teacher )
                        <tr>
                            <td> {{ $subject_teacher->name }} </td>
                            <td> {{ $subject_teacher->classes. ' '. $subject_teacher->arms }} </td>
                            <td> {{ $subject_teacher->subject }} </td>
                            <td> <a href="{{route('remove_subject_teacher', ['u_id' => $subject_teacher->id])}}" class="btn-sm btn btn-danger"> Remove </a>   </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if(! $subject_teachers->count() )
            <p class="text-center text-muted"> You have Not Assigned a Class Teacher Yet ! </p>
            @endif
        </section>
    </div>
</section>

<script>
  $(function(){
    $('.select_class_').on('change', (e) => {
      var klass = e.target.value;
          $.get('/auth0/subject_teachers?get_available_subjects=1&classes='+klass)
           .then( response => {
             var $options ='', 
                 option_field = $('.subject_options');
             if( response.subjects.length ){
              response.subjects.forEach( (value) => {
                 $options+= "<option value='"+value+"'>"+value+"</option>";
                 option_field.html($options);
               });
             }else{
              option_field.html("<option value=''> - No Subject Available - </option>");
             }
           }).catch( err => {
              alert('Network error !');
           });
    });
  });
</script>
@stop

