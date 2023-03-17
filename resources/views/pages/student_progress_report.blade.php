
<?php
if( ! $user_ ){
 echo " <script> alert('Invalid Student ID') </script>";
  exit;
}
$user = $user_;
$school = $user->school; 
$domain = $user->portal_url();
$school_logo = $domain."uploaded_files/school_logo/".$school->id.'/'.$school->logo;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @if( $school->logo)
  <link rel="shortcut icon" href="{{ asset('uploaded_files/school_logo/'.auth()->user()->school_id.'/'.$school->logo)}}" type="image/x-icon">
  @else
  <link rel="shortcut icon" href="{{ asset('dist/img/sp360_logo.png')}}" type="image/x-icon">
  @endif
    <title> Termly Progress Report - {{ $school->name }} </title>
    @include('partials.app_css')
</head>

<style>  
    body{zoom:80%; font-size:15px; font-family:verdana; font-weight:550; }
    p{font-size:15px; font-family:verdana; font-weight:550;}
    h5,h6{font-family: verdana; font-weight:550;}
    table{ width:100% !important ;}
    th, td{ padding-left: 10px;}
</style>
<body>
    <br>
    <section class="container-fluid"> <!-- container-fluid -->
        <div class="justify-content-center p-1 d-flex ">
            <button class="btn btn-primary print_docs"><i class="fa fa-print"></i>  Print Result </button>
        </div>

@forelse($student_results as $student)

        <section class="card page-break"> <!-- card -->   
            <section class="card-body"> <!-- card-body -->

                <div class="row"><!-- row Header-->
                    <div class="col-md-4"> <!-- col -->           
                      <div class="justify-content-center d-flex">
                        @if($school->logo)
                        {{ display_image( $school_logo, 'img-100')}}
                        @else
                        <img style="height:100px; width:auto;" class="img-thumbnal"  src="/img/logo.jpg"/>
                        @endif 
                        </div>                
                    </div> <!-- /col -->

                    <div class="col-md-4 text-center"> <!-- col -->
                       <h4 class='text-uppercase'> <b> {{$school->name}} </b> </h4>
                       <h6> {{ $school->motto }} </h6>
                       <h6> {{ $school->address }} </h6>
                       <h6> {{ $school->website }} </h6>
                       <h6> {{ $school->phone }}  </h6>
                    </div> <!-- /col -->

                    <div class="col-md-4"> <!-- col -->   
                       <div class="justify-content-center d-flex">
                        <p>
                           {{ display_image( $student->profile($student->student_id)->photo, 'img-100')}}
                        </p>
                       </div>
                  
                    </div> <!-- /col -->
                </div> <!-- /row header -->

                <div class="dropdown-divider"></div>


                <div class="card"> <!-- card student profile/details section -->
                   <div class="card-body text-capitalize"> <!-- card body -->
                     <div class="row"> <!-- row -->

                         <div class="col-md-4">
                             @if($s = $student->profile($student->student_id))
                             <h6> Name: {{strtolower($s->last_name.' '.$s->first_name.' '.$s->other_name)  }}</h6>
                                @else
                             <h6> Name: </h6>
                             @endif
                             <h6> Class: {{ $student->classes .' ' . $student->arms }} </h6>
                         </div>


                         <div class="col-md-2">
                             @if($s = $student->profile($student->student_id))
                             <h6> Gender: {{ strtolower( $s->gender) }} </h6>
                                @else
                             <h6> Gender: </h6>
                             @endif
                          <h6> No. in Class: {{$student->total_students}} </h6>
                         </div>

                          <div class="col-md-3">
                          <h6>  Term: {{ request()->term }} </h6>
                          
                          <h6> Student ID: {{ $student->student_id }} </h6>
                                           
                         </div>
                         
                         <div class="col-md-3">

                          <h6> Session: {{ request()->sessions }}</h6>
                       
                          <h6> Class Position: <span class="ordinal" id="{{$student->class_position}}"> 
                               {{$student->class_position}} </span></h6>
                        </div>
                                      
                     </div> <!-- row -->
                   </div> <!-- /card-body -->
                </div>  <!--/card  student profile/details section -->

                <h5 class="text-center"> <b> PROGRESS REPORT </b> </h5>
                <p class="text-info text-center">
                   <b> 
                   C.A - Continuous Assessment | C/Av - Class Average | H/score - Highest Score | L/Score - Lowest Score <br>
                   
                  <span>
                   1st C.A - 20.00 | 
                   2nd C.A - 20.00 |  
                   Exam - 60.00  | 
                   Total - 100 
                  </span>
                 
                 </b>
               </p>

                <div class="card card-secondary card-outline"> <!-- card result sheet table -->
                        <div class="table-responsive">
                            <table class="table-striped table-bordered">
                                <thead class='text-capitalize word_no_wrap'>
                                    <tr>
                                        <th> s/n</th>
                                        <th> Subject </th>
                                        <th> 1st C.A </th>
                                        <th> 2nd C.A </th>
                                        <th> Exam </th>
                                        <th> Total </th>
                                        <th> c/av </th>
                                        <th> Grade </th>
                                        <th> Remark </th>
                                        <th> Position </th>
                                        <th> H/Score</th>
                                        <th> L/Score</th>
                                    </tr>
                                </thead>

                                <tbody class='text-capitalize'>

                                  @foreach( $student->get_associated_subject_results($student->student_id) as $result )
                                    <tr style="height:40px;">
                                        <td> {{ $loop->index + 1 }} </td>
                                        <td> {{ strtolower( $result->subjects )}} </td>
                                        <td> @if($r1 = $result->field1) {{number_format( $r1, 2) }} @endif </td>
                                        <td> @if($r2 = $result->field2) {{number_format( $r2, 2) }} @endif </td>
                                        <td> {{ $result->exam_score }}  </td>
                                        <td> {{ $result->total_score }} </td> 
                                        <td> {{ $result->class_average }} </td>
                                        <td> {{ $result->grade }} </td>
                                        <td> {{ strtolower( $result->comment ) }} </td>                       
                                        <td class='ordinal' id='{{ $result->position }}'> {{ $result->position }} </td>
                                        <td> {{ $result->highest_score }} </td>
                                        <td> {{ $result->lowest_score }} </td>
                                    </tr>

                                  @endforeach

                                </tbody>
                            </table>
                        </div>
                </div> <!-- /card result sheet table -->


                <div class="row"> <!-- row (Key gradings)-->   
                  <div class="col-md-12"> <!-- col -->
                      <p class="text-center"> <b><u> KEY GRADES </u></b> </p>
                      <section class="justify-content-center d-flex"> <!-- Key Grades -->
                       @foreach($grades as $grade)
                         <p class="d-inline">
                           {{$grade->grade}} - {{$grade->comment}} <br> {{$grade->min_score.' - '. $grade->max_score . ' %'}}
                         </p> &nbsp;&nbsp;
                        @endforeach     
                      </section> <!--  -->    
                  </div> <!-- /col -->        
               </div>  <!-- /row (key Gradings)-->


              <div class="card card-secondary card-outline"> <!-- Footer section -->

                   <div class="card-body"> <!-- card-body footer section -->
                       <div class="row"> <!-- row -->
                       @if( request()->term == 'third term')
                       <div class="col-md-3"> <!-- col -->
                          <b> Status: </b> @if( $student->average_score > 50 ) Promoted @else Not Promoted @endif
                       </div> <!-- col -->

                       <div class="col-md-2"> <!-- col -->
                          <b> Total Subjects: </b> {{$student->total_subjects}}
                       </div> <!-- col -->
                       @else

                       <div class="col-md-5"> <!-- col -->
                          <b> No. of Subjects taken: </b> {{$student->total_subjects}}
                       </div> <!-- col -->
                       @endif

                       <div class="col-md-4"> <!-- col -->
                         <b> Total Score: </b> {{$student->total_score}}
                       </div> <!-- col -->

                       <!-- col -->
                       <!-- <div class="col-md-3">
                         <b> Average Score:</b>  {{ $student->average_score }}
                       </div>  -->
                       <!-- col -->
                       <hr>

                       <div class="col-md-3"> <!-- col -->
                         <b> Class Teacher's remark: </b>  Satisfactory 
                       </div> <!-- col -->
               
                       <hr>
                       <div class="col-md-9"> <!-- col -->  
                     
                         <b> Principal/Headmaster's Remark:</b> 
                              Satisfactory           
                        <br>  
                              <img src="{{asset('/img/signature.jpg') }}" style='height:40px; width:100px;'> <br>
                              <em> {{ date('d/m/Y') }} </em>
                              <br> <span> <b> Principal/Headmaster's Sign/Date </b> </span>
  
                       </div> <!-- col -->

                   </div> <!-- /row --> 

                 </div> <!-- /card-body footer section -->

               </div> <!-- /footer section  -->  

            </section>
            <!-- /card-body -->
        </section> <!-- /card -->

        @empty
        <br>
        <h6 class="text-center text-danger"><b> Result Not Found! </b> </h6>

    @endforelse

    </section>  <!-- /container-fluid -->
    
    <script>
        $(function(){
           $(window).click( () => { $('.print_docs').show()});
            $('.print_docs').click( () => {
                $('.print_docs').hide();
                window.print();
            });
        });      
    </script>

</body>
</html>



