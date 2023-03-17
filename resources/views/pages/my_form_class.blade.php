@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); 
  $active = $user->active_academic_session();
?>
<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> My Class </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> My Class </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


<!-- modal -->
<div class="modal fade" id="subject_modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class='text-capitalize'> <b class="modal-title"> Select Subject </b></h6>
              <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"> &times; </span>
              </button>
            </div> 
            
            <div class="modal-body"><!-- modal-body -->       
               <div class="row">
                   <div class="col-md-12">         
                       <section class="form-group">
                            <select required style="width:100%;" class='form-control' id="selected_subject">
                              <option value=""> - Select Subject - </option>
                              @foreach( $subjects as $subject )
                              <option class="text-capitalize" value="{{$subject->name}}"> {{ $subject->name }}</option>
                              @endforeach
                           </select> 
                       </section>
                   </div>

                   <div class="col-md-12">
                    <div class="justify-content-center d-flex">
                        <button type="button" class="btn btn-warning select_subject_btn_"> Continue <i class="fa fa-arrow-right"></i> </button>
                    </div>
                   </div>
               </div>
            </div> <!-- ///modal-body -->

          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
<!-- / modal -->

<section class="content">
    <div class="card">
      <section class="card-header lead"> My Class (es) </section>
      <div class="card-body">
        <p class="text-muted"> Available Classes </p>
        <section class="table-responsive">
          <table class='table-striped table-bordered table-hover word_no_wrap'>
            <thead>
              <tr>
                <th> Class </th>
                <th> Action </th>
              </tr>
            </thead>
            <tbody>
              @foreach($my_form_classes as $my_class )
              <tr>
                <td class="text-uppercase"> {{ $my_class->classes . ' ' . $my_class->arms }} </td>
                <td> 
                  <a href="{{ route('compute_result', ['classes' => $my_class->classes, 'arms' => $my_class->arms, 'sessions' => $active->sessions, 'term' => $active->term, 'select_students' => 1] ) }}" class="btn-sm btn btn-primary"> Compute Result </a> &nbsp;
                  <a href="{{ route('class_broadsheet', ['classes' => $my_class->classes, 'arms' => $my_class->arms, 'sessions' => $active->sessions, 'term' => $active->term ] ) }}" class="btn btn-sm btn-success"> View Result </a> &nbsp;
                  <a href="{{ route('subject_result', ['classes' => $my_class->classes, 'arms' => $my_class->arms, 'sessions' => $active->sessions, 'term' => $active->term ] ) }}" class="btn btn-sm btn-warning view_subject_result_"> View Subject Result </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </section> <!-- //table-responsive -->
        
        <hr>

        <p class="text-muted"> Available Subject Class </p>
        <section class="table-responsive">
          <table class='table-striped table-bordered table-hover word_no_wrap'>
            <thead>
              <tr>
                <th> Class </th>
                <th> Subject </th>
                <th> Action </th>
              </tr>
            </thead>
            <tbody>
              @foreach($subject_teacher_classes as $subject_class )
              <tr>
                <td class="text-uppercase"> {{ $subject_class->classes . ' ' . $subject_class->arms }} </td>
                <td> {{ $subject_class->subject }} </td>
                <td> 
                  <a href="{{ route('compute_subject_result', ['classes' => $subject_class->classes,  
                                                               'arms' => $subject_class->arms, 
                                                               'sessions' => $active->sessions, 
                                                               'term' => $active->term,
                                                               'subject' => $subject_class->subject  
                                                              ]) }}" class="btn-sm btn btn-warning"> Select </a> &nbsp;
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </section> <!-- //table-responsive -->

      </div>
    </div>
</section> 

<script>
$(function() {
   $(".view_subject_result_").on('click', (e) => {
      var url = e.target.href;
      e.preventDefault();
      $("#subject_modal").modal('show');
      
      $('.select_subject_btn_').on('click', () => {
        var subject = encodeURIComponent( $('#selected_subject').val() );
            if(subject == '' ) return alert(" Please Select a Subject... ");
            window.location.href = url+"&subject="+subject;
      });
   });
});
</script>

@stop

