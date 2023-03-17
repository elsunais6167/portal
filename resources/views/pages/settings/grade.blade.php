@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>
<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Grade Settings </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Grade Settings </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->



<!-- modal -->
<div class="modal" id="modal_box_">
        <div class="modal-dialog modal-xl">
        <form action="{{route('store_grade') }}" method="post">
        @csrf()
        <input type="hidden" name="school_id" value="{{ $user->school_id }}">
          <div class="modal-content">
            <div class="modal-header">
              <h6 class='text-capitalize'> <b class="modal-title"> Grade Format  </b></h6>
              <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"> &times; </span>
              </button>
            </div> 
            
            <div class="modal-body"><!-- modal-body -->   
                 <section class='row'>

                     <div class="col-md-4"> <!-- col -->
                     <label for=""> Enter Grade </label>
                     <input type="text" name="grade" required placeholder="A+" class="form-control">
                     </div> <!-- //col -->

                     <div class="col-md-4"> <!-- col -->
                     <label for=""> From (Minimum Score) </label>
                     <input type="number" step="any" required name="min_score" placeholder="0.00" class="form-control">
                     </div> <!-- //col -->

                     <div class="col-md-4"> <!-- col -->
                     <label for=""> To (Maximum Score) </label>
                     <input type="number" step="any" required name="max_score" placeholder="0.00" class="form-control">
                     </div> <!-- //col -->

                     <div class="col-md-12"> <!-- col -->
                     <label for=""> Comment/Remark </label>
                     <input type="text" name="comment" required placeholder="Comment here... " class="form-control">
                     </div> <!-- //col -->

                 </section>
            </div> <!-- ///modal-body -->

            <section class="modal-footer">      
                  <button type="submit" class="btn btn-outline-success"> Submit </button>       
            </section>

          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
<!-- / modal -->


<section class="content"> <!-- Content -->

   <div class="card">
        <section class="card-header lead"> Grading System </section>
        <div class="card-body">
             <button data-toggle="modal" data-target="#modal_box_" class='btn btn-sm btn-outline-success'><i class="fa fa-plus"></i> Add new </button>
        
        <section class="mt-4">
             <div class="table-responsive">
               <table class="table-striped table-bordered">
                  <thead class="word_no_wrap">
                    <tr>
                      <th> Grade </th>
                      <th> From (Min. Score )</th>
                      <th> To (Max. Score ) </th>
                      <th> Comment </th>
                      <th> Action </th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach( $grades as $grade )
                    <tr>
                      <td> {{ $grade->grade }} </td>
                      <td>{{ $grade->min_score}} </td>
                      <td> {{ $grade->max_score }} </td>
                      <td> {{ $grade->comment }} </td>
                      <th> <a href="{{ route('delete_grade', ['ref_id' => $grade->id ]) }}" class="btn btn-xs btn-outline-danger"> Delete </a> </th>
                    </tr>
                  @endforeach
                  </tbody>
               </table>
             </div>
             @if( ! count($grades) )
             <p class="text-center"> No Grades entered yet... </p>
             @endif
        </section>

        </div>
   </div>

</section> <!-- //=== Content -->


@stop

