@auth
<!DOCTYPE html>
<html lang="en">

@if(auth()->user()->staff)

<?php 
$user = auth()->user();
$school = $user->school; 
$term = request()->term;
$sessions = request()->sessions;
$class = request()->classes;
$arm = request()->arms;
$school_id = $user->school_id;
$view_progress_report = route("student_progress_report", ["term" => $term, 'sessions' => $sessions, 'arms'=> $arm, 'school_id' => $school_id, 'classes' => $class] ); 

$domain = "/";
$school_logo = $domain."uploaded_files/school_logo/".$school->id.'/'.$school->logo;
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{$school_logo}}" type="image/x-icon"> 
    <title> Class Broadsheet - {!! auth()->user()->school->name !!} </title>
    @include('partials.app_css')
</head>

<style>

body{zoom:75%; font-size: 15px; font-weight: 550;}
     thead tr th div, .vertical{
         writing-mode: vertical-rl;
         text-orientation: sideways-right;
         transform: rotate(180deg) !important;
         text-align:center;
         height:auto;
         width:100%;
         display: block; 
     }
     .hide{display:none;}
     .img_logo_style{
	max-height:100px !important; 
	max-width:100px !important; 
	opacity:.9;
}
.bg_img{
    background:url({{$school_logo}});
    background-repeat: no-repeat;
    background-position:center;
    display: auto;
        opacity:0.9;
}

</style>

<body>
    <section class=" container mt-4">
        <h5 class="text-center">
            @if($user->school->logo)
            <img class='img_logo_style' src="{{$school_logo}}">
            @endif
            <br>
            <span class="text-uppercase"> <b> {!! $user->school->name !!} </b> </span>
   </h5>
    <h6 class='text-center text-uppercase'> {{ request()->term }} REPORT SHEET ({{ request()->sessions }} ACADEMIC SESSION) </h6>
    <h6 class='text-center text-uppercase'> Summary Scores and Positions for <b> {{ request()->classes}} {{ request()->arms }} </b> </h6>
               <div class="justify-content-center d-flex">
                   <a href="{{url()->previous()}}" class="toggle_docs btn btn-outline-secondary"> <i class="fa fa-arrow-left"></i> Go back </a> &nbsp;
                   <button class="btn btn-outline-info toggle_docs print_docs"> <i class="fa fa-print"></i> Print Broad sheet </button> &nbsp;
                  
                   <a href="{{ $view_progress_report }}" target="_blank" class="toggle_docs btn btn-outline-success"> <i class="fa fa-list-alt"></i> View Progress Report </a>
                  
               </div>
    </section>


    <section class='mt-5 mb-5 container-fluid'>
       @if($students->count())

       <table style='width:100% !important; height:100%;' class='tabl table-striped table-bordered table-hover table-condensed'>
            <thead class='word_no_rap'>
                <tr>
                    <th> S/N </th>
                    <th> Names </th> 
                    <th class='remarks'> <div class="vertical"> Class </div> </th>             
                    @foreach($subjects as $subject)
                    <th class=' text-capitalize text-center word_no_wrap'> <div class="vertical"> {{ $subject }} </div> </th>
                    @endforeach
                    <th class='text-capitalize text-center'> <div class="vertical"> Total </div> </th>
                    <!-- <th class='text-capitalize text-center'> <div class="vertical"> Average score </div> </th> -->
                    <th class='text-capitalize text-center'> <div class="vertical"> Position </div> </th>
                </tr>
            </thead>
            <tbody>
            @foreach( $students as $student )
                <tr>          
                    <td> {{ $loop->index + 1 }} </td>          
                    <td>
                    @if( $s = $student->profile($student->student_id ) )
                         {{ ucwords( strtolower( $s->last_name.' '.$s->first_name.' '.$s->other_name ) )  }}
                    @endif
                   </td>
                   <td class='remarks text-capitalize'> {{$student->classes}} {{$student->arms}} </td>
                   @foreach($subjects as $subject)
                    <td class='text-capitalize'> {{$student->get_subject_score($subject, $student->student_id)}} </td>
                    @endforeach
                    <td> {{$student->total_score}} </td>
                    <!-- <td> {{$student->average_score}} </td> -->
                    <td> {{$student->class_position}} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <h5 class="text-center text-danger"> This Class has No Result yet... </h5>
        @endif
   
    </section>

    <script>
        $(function(){

           $(window).click( () => { 
               $('.toggle_docs').show();
                $('.remarks').show(); 
            });

            $('.print_docs').click( () => {
                $('.toggle_docs').hide();
                $('.remarks').hide();
                window.print();
            });
            /****
             * Save comments for admin 
             */
            $('.save_btn').click( (e) => {
                e.preventDefault();
                var $update_broad_sheet_result_comment_url = "/zytwshn3y88w832bd7-glsgvg151816nmjklyp";
                var id = e.target.id;
                var spinner = $('#btn_spinner-'+id),
                    success_info = $('#success_info-'+id);
                    failed_info = $('#failed_info-'+id);
                    spinner.show();
                var form_data = $('#save_comments_form-'+id).serialize();
                $.post($update_broad_sheet_result_comment_url, form_data, (res) => {
                    res.error ? failed_info.show() : success_info.show();
                    spinner.hide();
                });
            });

            
        });
    </script>
</body>

@else

<script> window.location.href = '/logout' </script>" 

@endif

</html>

@endauth
