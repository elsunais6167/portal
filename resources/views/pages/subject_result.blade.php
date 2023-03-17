@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?> 
<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Subject Result </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Subject Result </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


<div class="modal" id="edit_result_modal">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class="modal-title"> EDIT RESULT </h6>
              <button title="Close" type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <p class="text-uppercase">Subject: {{ request()->subject }} </p>
              <form action="{{ route('update_subject_result') }}" method="post">
                  @csrf()
                <input type="hidden" name='school_id' value='{{$user->school_id}}'>
                <input type="hidden" name='sessions' value='{{ request()->sessions }}'>
                <input type="hidden" name='term' value='{{ request()->term }}'>
                <input type="hidden" name='classes' value='{{ request()->classes }}'>
                <input type="hidden" name='arms' value='{{ request()->arms }}'> 
                <input type="hidden" name='student_id' id="student_id"> 
                <input type="hidden" name='subjects' value="{{ request()->subject}}"> 
               <div class="row"><!-- row -->
                  <div class="col-md-12"> <!-- col -->
                     <div class="form-group">
                       <label for=""> 1ST C.A* </label>
                       <input required id="field1_" type="number" step="any" class='input_ form-control' name='field1' placeholder='0.00'>
                     </div>
                  </div> <!-- /col -->

                  <div class="col-md-12"> <!-- col -->
                     <div class="form-group">
                       <label for=""> 2ND C.A </label>
                       <input id="field2_" type="number" step="any" class='input_ form-control' name='field2' placeholder='0.00'>
                     </div>
                  </div> <!-- /col -->

                  <div class="col-md-12"> <!-- col -->
                     <div class="form-group">
                       <label for=""> Exam * </label>
                       <input required id="exam_score" type="number" step="any" class=' input_ form-control' name='exam_score' placeholder='0.00'>
                     </div>
                  </div> <!-- /col -->

                  <div class="col-md-12"> <!-- col -->
                     <div class="form-group">
                       <label for=""> Total * </label>
                       <input required id="total_score" type="number" step="any" class=' form-control' readonly name='total_score' placeholder='0.00'>
                     </div>
                  </div> <!-- /col -->            

                  <div class="col-md-12">
                    <div class="justify-content-center d-flex">
                      <div class="form-group">
                       <button type="submit" class="btn btn-block btn-outline-success">
                          <i class="hide fa fa-spin fa-spinner"></i> 
                          Update
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




<section class="content"> <!-- content -->
     <div class="card">
       <div class="card-header lead text-capitalize"> {{ request()->classes . ' '. request()->arms . ' - '. request()->subject }} Result </div>
       <section class="card-body">
           <div class="table-responsive">
             <table class="text-capitalize table-striped table-hover table-boredere">
               <thead class="word_no_wrap">
                <tr> 
                <th> # </th>
                 <th> Student ID</th>
                 <th> Name </th>
                 <th> 1st CA </th>
                 <th> 2nd CA </th>
                 <th> Exam </th>
                 <th> Total </th>
                 <th> Grade </th>
                 <th> Comment </th>
                 <th> Position </th>
                 <th> Action </th>
                </tr>
               </thead>
               <tbody>
                 @foreach( $results ?? [] as $index => $result)
                 <tr>
                   <td> {{ $index + 1}} </td>
                   <td> {{ $result->student_id}} </td>
                   <td> {{ $result->student_name( $result->student_id) }} </td>
                   <td> {{ $result->field1 }} </td>
                   <td> {{ $result->field2 }} </td>
                   <td> {{ $result->exam_score }} </td>
                   <td> {{ $result->total_score}} </td>
                   <td> {{ $result->grade}} </td>
                   <td> {{ $result->comment }} </td>
                   <td> {{ $result->position }} </td>
                   <td>
                    @if( current_user()->is_sub_admin() )
                     <button type="button" id="{{ $result->field1.'/'.$result->field2.'/'.$result->exam_score.'/'.$result->total_score.'/'.$result->student_id }}" class="btn btn-sm btn-outline-primary edit_btn__" > Edit </button> &nbsp;
                     <a href="{{ route('delete_subject_result', ['ref_id' => $result->id ] ) }}" class="btn btn-sm btn-outline-danger"> Delete </a>
                     @endif
                   </td>
                 </tr>
                 @endforeach
               </tbody>
             </table>
           </div>
           @if( ! count($results ?? [] ) )
           <p class="text-center"> No Result was Found... </p> 
           @endif  
       </section>
     </div>    
</section> <!-- //content -->

<script>
  $(".edit_btn__").click( (e) => {
    var data = e.target.id,
        field1 = data.split('/')[0],
        field2 = data.split('/')[1],
        exam_score = data.split('/')[2],
        total = data.split('/')[3];
        student_id = data.split('/')[4];
        
        $('#field1_').val( Number( field1) );
        $('#field2_').val( Number(  field2 ) );
        $('#exam_score').val( Number( exam_score ) );
        $('#total_score').val( Number( total ) );
        $('#student_id').val( Number( student_id ) );

        $('#edit_result_modal').modal('show');
  });

  $('.input_').on('input', (e) => {
      var ca_1 = $("#field1_").val(),
          ca_2 = $("#field2_").val(),
          exam_ = $("#exam_score").val(),
          total_score = Number(ca_1) + Number(ca_2) + Number(exam_);
          $("#total_score").val(total_score);
    });
</script>

@stop

