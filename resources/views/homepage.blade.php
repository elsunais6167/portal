<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{asset('dist/img/sp360_logo.jpg')}}" sizes='any' type="image/x-icon">
    <title>Homepage </title>
    @include('layouts.header')
</head>
<body>

<section class="container mt-5"> <!-- container -->

<div class='mb-5'> <h2 class="text-muted text-center"> SCHOOL PORTAL </h2> </div>
<div>@include('messages') </div>
@if( request()->has('my_results'))

<section class="">
<h3 class="text-center text-muted pb-3"> VIEW TERMLY RESULT <br> <a href="{{ route('home_page')}}"> <small> Back to Homepage </small> </a> </h3>

<form action="?" method="get" class="mb-5" target="_blank">
  <input type="hidden" value="1" name="my_results">
  <input type="hidden" value="1" name="available_results">
      <section class="row"><!-- row -->
          <section class="col-md-12"> <!-- cols -->
            <div class="form-group">
             <label for=""> Student ID </label>
              <input type="text" name="student_id" required class="form-control" placeholder="Enter your Student ID here...">
            </div>
          </section><!-- //col -->

            <section class="col-md-12">
             <div class="form-group ">
                <button type="submit" class="btn btn-outline-success"> Get Result </button>
              </div>
            </section>

      </section> <!-- //row -->

   </form>

   @if( request()->has('available_results'))
          @if( ! $results->count() )
            <p class="text-center"> No Result found ! </p>
            
          @else

          <div class="table-responsive">
          <table class="table-striped table-bordered">
            <thead>
              <tr>
                <th> Class </th>
                <th> Academic Session</th>
                <th> Action </th>
              </tr>
            </thead>
            <tbody>
              @foreach( $results as $result )
              <tr>
                <td> {{ $result->classes }} {{ $result->arms }} </td>
                <td>  {{ $result->term }} ({{ $result->sessions }}) </td>
                <td>
                  <a href="{{ route('student_progress_report', 
                    [
                      'g_req' => 1,
                      'school_id' => 3,
                      'student_id' => request()->student_id,
                      'classes'=> $result->classes,
                      'arms'=> $result->arms,
                      'sessions'=> $result->sessions,
                      'term'=> $result->term
                    ])
                  }}" 
                    class="btn btn-outline-success"> View</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          </div>
          

          @endif
   @endif

   <hr> 

</section>


@elseif( request()->has('my_payments') )

<section>
<h3 class="text-center text-muted pb-3"> All Payments made <br> 
<a href="{{ route('home_page')}}"> <small> Back to Homepage </small> </a> </h3>

<section class="d">
   <form action="" method="get">
   <input type="hidden" name="my_payments" value="1">
   <input type="hidden" name="all_p" value="1">
      <div class="form-group">
       <label for=""> Student ID </label>
       <input type="text" name="student_id" required class="form-control" placeholder="Enter your Student ID here...">
      </div>

      <div class="form-group ">
         <button type="submit" class="btn btn-outline-success"> View Payments </button>
      </div>
   </form>
</section>

 @if( request()->has('all_p') ) 
 <hr>
<div class="row"><!-- row -->

@forelse( $all_payments as $fee )
   <section class="col-md-12"> <!-- col -->
    <a href="{{route('print_receipt', ['sid' =>$fee->school_id, 
                                       'uid' => $fee->student_id, 
                                       'tid' => $fee->id,
                                       's'=> $fee->sessions, 
                                       't' => $fee->term,
                                       'classes'=> $fee->classes,
                                       'arms' => $fee->arms
                                       ]) }}" 
                                       class="text-muted">
    <div class="info-box mb-3 bg-outline-success">
                 <span class="info-box-icon"><i class="fa-2x fa fa-bank"></i></span>
   
                 <div class="info-box-content">
                   <span class="info-box-text text-lg"> {{ $fee->fee_type }} </span>
                   <span class="info-box-number text-md">  ( {{ $fee->term .' - '. $fee->sessions }} ) </span>
                 </div>
                 <!-- /.info-box-content -->
     </div>
     </a>
     <!-- /.info-box -->
    </section> <!-- //col -->
    @empty
    <section class="col-md-12"> <!-- col -->
      <p class="text-center text-muted"> No Transactions found.... </p>
    </section>
    @endforelse
    </div> <!-- //row -->
    @endif
</section>

@else
<div class="row"><!-- row -->
   
<section class="col-md-6"> <!-- col -->
<a href="?my_results=1" class="text-muted">
 <div class="info-box mb-3 bg-outline-success">
              <span class="info-box-icon"><i class="fa-2x fa fa-book"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-lg"> CHECK RESULT  </span>
                <span class="info-box-number text-md"> Student Progress Report </span>
              </div>
              <!-- /.info-box-content -->
  </div>
  </a>
  <!-- /.info-box -->
 </section> <!-- //col -->

 <section class="col-md-6"> <!-- col -->
 <a href="?my_payments=1" class="text-muted">
 <div class="info-box mb-3 bg-outline-success">
              <span class="info-box-icon"><i class="fa-2x fa fa-bar-chart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-lg"> FEE RECEIPTS </span>
                <span class="info-box-number text-MD"> View Receipts of all your payments </span>
              </div>
              <!-- /.info-box-content -->
  </div>
  </a>
  <!-- /.info-box -->
 </section> <!-- //col -->


 <section class="col-md-12"> <!-- col -->
 <a href="{{ route('login')}}" class="text-muted">
 <div class="info-box mb-3 bg-succss">
              <span class="info-box-icon"><i class="fa-2x far fa-user"></i></span>

              <div class="info-box-content">
                <span class="info-box-text text-lg"> STAFF LOGIN </span>
                <span class="info-box-number text-md"> Login to access your Dashboard </span>
              </div>
              <!-- /.info-box-content -->
  </div>
  </a>
  <!-- /.info-box -->
 </section> <!-- //col -->


</div> <!-- //row -->
@endif

</section> <!-- //container -->

</body>
</html>
