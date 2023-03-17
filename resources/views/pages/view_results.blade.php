@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> View Students Results </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Students Results </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->

<section class="content">
    <div class="card">
        <section class="card-header lead"> Classes with available results</section>
        <div class="card-body">
            <section class='table-responsive'>
                <table class='table table-bordered text-uppercase'>
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Class </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach( $results as $index => $result )
                        <tr>
                            <td> {{ $index + 1 }}  </td>
                            <td> {{ $result->classes . ' ' .$result->arms }} </td>
                            <td>
                                <a href="{{ route('class_broadsheet', [
                                                                     'classes' => $result->classes,
                                                                     'arms' => $result->arms,
                                                                     'term' => $current->term,
                                                                     'sessions' => $current->sessions
                                                                   ])}}" 
                                                                   class="btn btn-outline-success btn-sm"> 
                                                                   View Broadsheet 
                                </a>
                                {{-- <a href="{{ route('student_progress_report', [
                                                                     'classes' => $result->classes,
                                                                     'arms' => $result->arms,
                                                                     'term' => $current->term,
                                                                     'sessions' => $current->sessions,
                                                                     'school_id' => $user->school->id,
                                                                     'print_docs' => 1
                                                                   ])}}" 
                                                                   class="btn btn-outline-success btn-sm"> 
                                                                   Print Report
                                </a> --}}
                                <a href="{{ route('student_progress_report', [
                                                                     'classes' => $result->classes,
                                                                     'arms' => $result->arms,
                                                                     'term' => $current->term,
                                                                     'sessions' => $current->sessions,
                                                                     'school_id' => $user->school->id,
                                                                   ])}}" 
                                                                   class="btn btn-outline-info btn-sm"> 
                                                                   View Progress Report
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        </div>
    </div>
    
</section>

@stop