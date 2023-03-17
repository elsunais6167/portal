@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Academic Session Set-up </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Academic Session  </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->

 <section class="container-fluid"> <!-- container-fluid -->

<!-- Start modal -->
<div id="register_academic_session_modal" class="modal fade "> 
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h6 class="modal-title"> New Academic Session </h6>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
             </div> 
             <div class="modal-body"><!--modal body-->

             <form action="{{route('register_academic_session')}}" method="post" class='register_academic_session_form'>
               @csrf()
             <input type="hidden" name='school_id' value="{{ $user->school_id }}">
        
                  <div class="row">

                         <div class="col-md-6">
                          <div class="form-group">
                             <label for=""> Session </label>
                             <select required name="sessions" class="form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_all_sessions() as $session )
                                   <option value="{{ $session->name }}"> {{ $session->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div> 

                        <div class="col-md-6">
                          <div class="form-group">
                             <label for=""> Term </label>
                             <select required name="term" class="form-control">
                                   <option value=""> - Select - </option>
                                   @foreach( $user->get_all_terms() as $term )
                                   <option class='text-capitalize' value="{{ $term->name }}"> {{ $term->name }} </option>
                                   @endforeach
                             </select>
                          </div>
                        </div> 

                        <div class="col-md-12">
                           <div class="justify-content-center d-flex">
                           <div class="form-group">
                              <button type='submit' class="btn btn-success"> 
                                Create 
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


     
 <section class="card"> <!-- card -->
 <div class="card-header text-sm d-flex">
              <b> NB: </b> This Portal uses your Last Updated Active Academic session to function Properly
<!-- 
 <p class="float-left"> Click on <b> Menu </b> to navigate to other sections </p>
               
               <ul class="nav nav-pills ml-auto float-rigth">
                 <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">
                     <b> Menu  <span class="caret"></span> </b>
                   </a>
                   <div class="dropdown-menu dropdown-menu-right">
                     <button class="dropdown-item" tabindex="-1" href="#tab_1" data-toggle="tab"> Academic Session settings </button>
                     <div class="dropdown-divider"></div>
                     <button class="dropdown-item " tabindex="-1" href="#tab_2" data-toggle="tab"> Class settings </button>
                     <div class="dropdown-divider"></div>
                     <button class="dropdown-item " tabindex="-1" href="#tab_3" data-toggle="tab"> Arm / Sub Class Settings </button>  
                   </div>
                 </li>
               </ul> -->

 </div>

     <section class="card-body"> <!-- card-body  -->
     
      <section class="tab-content"> <!-- START TAB-CONTENT -->

      <div class="active tab-pane" id="tab_1"> <!-- START TAB 1 -->
        
          <!-- Button action-->
          <div class="dropdown">
            <button class="btn-sm btn btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Actions 
            </button>
               <button data-toggle='modal' data-target='#register_academic_session_modal' class="btn-sm btn btn-outline-success"><i class="fas fa-plus"></i> New Session </button>
              
              
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">    

                   <button onClick="activate_academic_session()" type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-check text-muted"></i> Activate Academic Session
                   </button>
                   <div class="dropdown-divider"></div>

                   <button onClick="de_activate_academic_session()" type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-ban text-muted"></i> De-activate Academic Session
                   </button>
                   <div class="dropdown-divider"></div>


                   <button onClick="publish_result()" type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-edit text-muted"></i> Publish Result
                   </button>
                   <div class="dropdown-divider"></div>


                   <button onClick="undo_published_result()" type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-ban text-muted"></i> Undo Published Result
                   </button>
                   <div class="dropdown-divider"></div>

                   <button onClick="delete_academic_session()" type='button' class="btn-sm dropdown-item">
                    <i class="fa fa-trash text-muted"></i> Delete Academic Session
                   </button>
                   <div class="dropdown-divider"></div>

                </div>
           </div>
          <hr>
          <!-- ///Button Action  -->

         <section class="table-responsive">
             <table class=" word_no_wrap table table-hover table-striped">
                 <thead>
                     <tr>
                         <th> <input type="checkbox" class="checkedAll check_btn"> </th>
                         <th> Academic Session</th>
                         <th> Sesssion Status </th>
                         <th> Result status </th>
                         <th> Last Updated </th>
                     </tr>
                 </thead>

                 <tbody>
                 <form class='academic_session_form' method="post">
                     @csrf()
                     @foreach($academic_sessions as $academic )
                     <tr>
                         <td> <input type="checkbox" name='id[]' value="{{ $academic->id }}" class="checkSingle check_btn"> </td>
                         <td class='text-capitalize'> {{$academic->term }} ({{$academic->sessions }} ) </td>
                         <td> 
                             @if($academic->active)
                             <span class="badge text-xs badge-success"> ACTIVE </span>
                             @else
                             <span class="badge text-xs badge-danger"> IN-ACTIVE  </span>
                             @endif
                         </td>
                         <td> 
                            @if($academic->result_published)
                            <span class="badge text-xs badge-success"> PUBLISHED </span>
                            @else
                            <span class="badge text-xs badge-danger"> NOT PUBLISHED </span>
                            @endif
                        </td>
                         <td> {{date('D, M d, Y - h:ia', strtotime($academic->updated_at) ) }} </td>
                     </tr>
                     @endforeach
                   </form>
                 </tbody>

             </table>
         </section>
     </div> <!-- End TAB 1 -->

     <div class="tab-pane" id="tab_2"> <!-- START TAB 2 -->
     <p> Register all Classes in your School </p>
                          <form action="{{route('register_classes')}}" method="post" class="form-horizontal">
                              @csrf()
                            <input type="hidden" name='school_id' value='{{ $user->school_id }}'>

                    <div class="container"> <!-- Container -->
                            <label for=""> Class title </label>
                            <div class="input-group">
                              <div class="custom-file">  
                                 <input required type="text" name='name' placeholder="E.g: SSS 3 " class="form-control">
                              </div>
                                <div class="input-group-append">
                                  <button type='submit' class="btn-block btn btn-success btn-sm"> Submit </button>
                               </div>
                            </div>
                    </div> <!--/ Container -->
             </form>

             <div class="mt-3">
                 <button type="button" onClick="delete_class()" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Remove Class </button>
             </div>
             
             <section class="mt-3 table-responsive">

                 <table class=" word_no_wrap table table-hover table-striped table-condensed">
                     <thead>
                         <tr>
                             <th><input type="checkbox" class="check_btn checkedAll1"> </th>
                             <th> Class Title </th>
                         </tr>
                     </thead>
                     <tbody>
                         <form class="class_data_form">
                             @csrf()
                         @foreach($academic_classes as $clas )
                         <tr>
                             <td> <input type="checkbox" name="id[]" value="{{$clas->id}}" class="check_btn checkSingle1"> </td>
                             <td> {{ $clas->name }} </td>
                         </tr>
                         @endforeach
                         </form>
                     </tbody>
                 </table>

             </section>

     </div> <!-- End TAB 2 -->



     <div class="tab-pane" id="tab_3"> <!-- START TAB 3 -->
      
     <p> Register all Arms in your School </p>
                          <form action="{{route('register_arms')}}" method="post" class="form-horizontal">
                              @csrf()
                            <input type="hidden" name='school_id' value='{{ $user->school_id }}'>

                    <div class="container"> <!-- Container -->
                            <label for=""> Arm title </label>
                            <div class="input-group">
                              <div class="custom-file">  
                                 <input required type="text" name='name' placeholder="E.g: Alpha " class="form-control">
                              </div>
                                <div class="input-group-append">
                                  <button type='submit' class="btn-block btn btn-success btn-sm"> Submit </button>
                               </div>
                            </div>
                    </div> <!--/ Container -->
             </form>

             <div class="mt-3">
                 <button type="button" onClick="delete_arms()" class="btn btn-sm btn-outline-danger"><i class="fa fa-trash"></i> Remove Arm </button>
             </div>
             
             <section class="mt-3 table-responsive">

                 <table class=" word_no_wrap table table-hover table-striped table-condensed">
                     <thead>
                         <tr>
                             <th><input type="checkbox" class="check_btn checkedAll2"> </th>
                             <th> Arm Title </th>
                         </tr>
                     </thead>
                     <tbody>
                         <form class="arm_data_form">
                             @csrf()
                         @foreach($academic_arms as $arm )
                         <tr>
                             <td> <input type="checkbox" name="id[]" value="{{$arm->id}}" class="check_btn checkSingle2"> </td>
                             <td> {{ $arm->name }} </td>
                         </tr>
                         @endforeach
                         </form>
                     </tbody>
                 </table>

             </section>

     </div> <!-- End TAB 3 -->


      </section> <!-- //END TAB-CONTENT -->

     </section> <!-- /end card-body -->

 </section> <!-- Card -->

 </section> <!-- //end container-fluid -->



 <script>

     function data(){
             return $('.academic_session_form').serialize();
           }
    function confirmation(){
             return confirm("Please, Confirm this Activity... ");
           }

   function activate_academic_session(){
        if(this.confirmation()){
             var data = this.data()+'&activate_academic_session=1';
             var url = "/auth0/activate_academic_session";
             $.post(url, data, (res) => {
             if(res.error) return alert(res.error) ;
                window.location.reload();
            });
        }
    }

    function de_activate_academic_session(){
        if(this.confirmation()){
             var data = this.data()+'&de_activate_academic_session=1';
             var url = "/auth0/de_activate_academic_session";
             $.post(url, data, (res) => {
             if(res.error) return alert(res.error) ;
                window.location.reload();
            });
        }
    }

    function delete_academic_session(){
        if(this.confirmation()){
             var data = this.data()+'&delete_academic_session=1';
             var url = "/auth0/delete_academic_session";
             $.post(url, data, (res) => {
             if(res.error) return alert(res.error) ;
                window.location.reload();
            });
        }
    }

    function undo_published_result(){
        if(this.confirmation()){
             var data = this.data()+'&undo_published_result=1';
             var url = "/auth0/undo_published_result";
             $.post(url, data, (res) => {
             if(res.error) return alert(res.error) ;
                window.location.reload();
            });
        }
    }

    function publish_result(){
        if(this.confirmation()){
             var data = this.data()+'&publish_result=1';
             var url = "/auth0/publish_result";
             $.post(url, data, (res) => {
             if(res.error) return alert(res.error) ;
                window.location.reload();
            });
        }
    }

    function delete_class(){
        if(this.confirmation()){
             var data = this.class_data()+'&delete_class=1';
             var url = "/auth0/delete_class";
             $.post(url, data, (res) => {
             if(res.error) return alert(res.error) ;
                window.location.reload();
            });
        }
    }

    function delete_arms(){
        if(this.confirmation()){
             var data = this.arm_data()+'&delete_arms=1';
             var url = "/auth0/delete_arms";
             $.post(url, data, (res) => {
             if(res.error) return alert(res.error) ;
                window.location.reload();
            });
        }
    }

    function class_data(){
        return $('.class_data_form').serialize();
    }

    function arm_data(){
        return $('.arm_data_form').serialize();
    }

 </script>

@stop