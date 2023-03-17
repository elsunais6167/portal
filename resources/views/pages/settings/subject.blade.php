@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>
<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Subject Settings </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Subject Settings </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


<section class="content"> <!-- Content -->

   <div class="card">
        <section class="card-header lead"> Subject Settings </section>
        <div class="card-body">
        
        <form action="{{ route('store_subject') }}" method="post">
        <input type="hidden" name="school_id" value="{{ $user->school_id }}">
        @csrf()
        <section class="row">
          <div class="col-md-4">
           <input type="text" class="form-control" name="name" placeholder="Subject name... " required>
          </div>

          <div class="col-md-4">
          <select required class="form-control text-capitalize" name="classes">
            <option value=""> - Select Class - </option>
            @foreach( $user->get_school_classes() as $klas )
            <option value="{{ $klas->name }}"> {{ $klas->name}} </option>
            @endforeach
          </select>
          </div>

          <div class="col-md-4">
          <button type="submit" class="btn btn-outline-success"> Save Subject </button>
          </div>
        </section>
        </form>

         <section class="mt-4">
         <p class=""> Total: {{ count( $subjects ) }} </p>
             <div class="table-responsive">
               <table class="text-uppercase table-striped table-bordered">
                  <thead class="word_no_wrap">
                    <tr>
                      <th> Subject Name </th>
                      <th> Class </th>
                      <th> Action </th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach( $subjects as $subject )
                    <tr>
                      <td> {{ $subject->name }} </td>
                      <td> {{ $subject->classes }} </td>
                      <td> <a href="{{ route('delete_subject', ['ref_id' => $subject->id ]) }}" class="btn btn-outline-danger"> Remove </a> </td>
                    </tr>
                  @endforeach
                  </tbody>
               </table>
             </div>
            @if( ! count( $subjects ) )
              <p class="text-center"> No Subjects entered yet... </p>
            @endif
        </section>

        </div>
   </div>

</section> <!-- //=== Content -->


@stop

