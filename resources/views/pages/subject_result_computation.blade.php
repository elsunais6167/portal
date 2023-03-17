@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> student Computation </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> student Computation </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->



<!-- modal -->
<div class="modal fade" id="edit_subject_modal">
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
                        <button type="button" class="btn btn-warning edit_subject_btn"> Continue <i class="fa fa-arrow-right"></i> </button>
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
        <div class="card-header lead"> {{ request()->subject }} Computation </div>

    <section class="card-body">
      <p class="text-uppercase "> Term: <span class="term_">{{ request()->term }} </span> </p>
      <p class="text-uppercase "> Session: <span class="sessions_">{{ request()->sessions }} </span> </p>
      <p class="text-uppercase "> Class: <span class="classes_">{{ request()->classes }} </span> </p>
      <p class="text-uppercase "> Arm: <span class="arms_">{{ request()->arms }} </span> </p>
      <hr>

      <div class="table-responsive">
          <table class="text-uppercase table-hover table-striped table-bordered">
            <thead class="word_no_wrap">
            <tr>
              <th> Names </th>
              <th> 1st C.A </th>
              <th> 2nd C.A </th>
              <th> Exam </th>
              <th> Total </th>
              <th> Action </th>
            </tr>
            </thead>
            <tbody>
            @foreach( $students as $student )
        <form action="{{route('store_students_result')}}" class="submit_form_ submit_form_{{ $student->id }}" id="{{ $student->id }}" method="post">
          @csrf()
           <input type="hidden" name="subjects" value="{{request()->subject}}">
           <input type="hidden" name="school_id" value="{{$user->school_id}}">
           <input type="hidden" name="classes" value="{{ request()->classes }}">
           <input type="hidden" name="arms" value="{{ request()->arms }}">
           <input type="hidden" name="term" value="{{ request()->term }}">
           <input type="hidden" name="sessions" value="{{ request()->sessions }}">
           <input type="hidden" name="student_id" value="{{ $student->id }}">
              <tr>
               <td> {{ $student->last_name .' '. $student->first_name . ' ' .$student->other_name  }} </td>
               <td> <input name="field1" required type="number" step="any" class="form-control input_  form_width ca1_{{$student->id}}" id="{{$student->id}}" placeholder="1st C.A"> </td>
               <td> <input name="field2" type="number" step="any" class="form-control  input_  form_width ca2_{{$student->id}}" id="{{$student->id}}" placeholder="2nd C.A">  </td>
               <td> <input name="exam_score" type="number" required step="any" class="form-control input_ form_width exam_{{$student->id}}" id="{{$student->id}}" placeholder="Exam"> </td>
               <td> <input name="total_score" type="number" required step="any" readonly class="form-control input_ form_width total_score_{{$student->id}}" id="{{$student->id}}" placeholder="Total">  </td>
               <td> 
                   <i class="fa hide fa-check-circle text-success" id="success_{{$student->id}}"></i>
                   <i class="fa hide fa-close text-danger" id="failed_{{$student->id}}"></i>
                   <i class="fa hide fa-spin fa-spinner text-muted" id="processing_{{$student->id}}"></i>
                   <button type="submit" class="btn-sm btn btn-outline-success" id="btn__{{$student->id}}"> Save </button>
               </td>
              </tr>
              </form>
            @endforeach
            </tbody>
          </table>
      </div>
    </section>

    <section class="card-footer">
     <center>
      <button type="button" data-toggle="modal" data-target="#edit_subject_modal" class="btn-warning btn"> Edit Result </button> &nbsp;
      <a href="{{ route('class_broadsheet',[
                                            'classes'=> request()->classes,
                                            'arms'=> request()->arms,
                                            'term'=> request()->term,
                                            'sessions'=> request()->sessions, 
                                            ]) }}" class="btn-success btn"> View Result </a>
     </center>
    </section>

    </div>
</section>

<script>

$(function() {
   $(".edit_subject_btn").on('click', () => {
     var subject = $('#selected_subject').val(),
         term = $(".term_").text(),
         sessions_ = $(".sessions_").text(),
         classes = $(".classes_").text(),
         arms = $(".arms_").text(),
         url = "/auth0/subject-result?subject="+subject+"&classes="+classes+"&arms="+arms+"&term="+term+"&sessions="+sessions_ ;
         window.location.href = url;
    });


    $(".submit_form_").on('submit', (e) => {
      e.preventDefault();
      var form_id = e.target.id, 
          url = e.target.action;
      var btn = $('#btn__'+form_id),
          success_ = $("#success_"+form_id),
          failed_ = $("#failed_"+form_id),
          processing_ = $("#processing_"+form_id),
          data = $('.submit_form_'+form_id).serialize();
          processing_.show();
          btn.hide();
          failed_.hide();
          success_.hide();
          if($('.total_score_'+form_id).val() > 100 ){
              btn.show();
              processing_.hide();
              return alert( "Total Scores can't be more than 100 ");
          }
          $.post(url, data, ( response ) => {
            if( response.error) alert(response.error );
            success_.show();
            processing_.hide();
          })
          .catch((err) => {
            btn.show();
            failed.show();
            processing_.hide();
          });
    });

    $('.input_').on('input', (e) => {
      var id_ = e.target.id;
      var ca_1 = $(".ca1_"+id_).val(),
          ca_2 = $(".ca2_"+id_).val(),
          exam_ = $(".exam_"+id_).val(),
          total_score = Number(ca_1) + Number(ca_2) + Number(exam_);
          $(".total_score_"+id_).val(total_score);
    });
});

</script>


@stop   
