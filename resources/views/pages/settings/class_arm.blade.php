@extends('layouts.app')
@section('content')
<?php $user = auth()->user(); ?>
<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Class/Arm Settings </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Class/Arm Settings </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


<section class="content">

    <div class="card">

     <section class="card-header lead"> Class/Arm Settings </section>
     <div class="card-body">

     <div class="row"> <!-- row -->


     <section class="col-md-6"> <!-- col 1 -->
              <form action="{{ route('store_arm') }}" method="post">
              <input type="hidden" name="school_id" value="{{ $user->school_id }}">
              @csrf()
                  <div class="row">
                    <div class="col-md-8">
                      <input type="text" name="name" required class="form-control" placeholder="Enter Sub-class/Arm... ">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-outline-success"> Submit </button>
                    </div>
                  </div>
              </form>


              <div class="table-responsive mt-3">
                   <table class=" text-uppercase table-striped table-bordered">
                           <thead>
                             <tr>
                               <th> Arm / Sub-Class </th>
                               <th> Action </th>
                             </tr>
                           </thead>
                           <tbody>
                           @foreach( $arms as $arm )
                             <tr>
                               <td> {{ $arm->name}} </td>
                               <td> <a href="{{ route('delete_arm_', ['ref_id' => $arm->id]) }}" class="btn btn-sm btn-outline-danger"> Remove </a> </td>
                             </tr>
                             @endforeach
                           </tbody>
                   </table>
              </div>

          </section> <!-- //col 1 -->



          <section class="mt-5 col-md-6"> <!-- col 2 -->
          <hr>
              <form action="{{ route('store_class') }}" method="post">
              <input type="hidden" name="school_id" value="{{ $user->school_id }}">
              @csrf()
                  <div class="row">
                    <div class="col-md-8">
                      <input type="text" name="name" required class="form-control" placeholder="Enter Class... ">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-outline-success"> Submit </button>
                    </div>
                  </div>
              </form>

              <div class="table-responsive mt-3">
                   <table class=" text-uppercase table-striped table-bordered">
                           <thead>
                             <tr>
                               <th> Class</th>
                               <th> Action </th>
                             </tr>
                           </thead>
                           <tbody>
                           @foreach( $classes as $class_ )
                             <tr>
                               <td> {{ $class_->name}} </td>
                               <td> <a href="{{ route('delete_class_', ['ref_id' => $class_->id]) }}" class="btn btn-sm btn-outline-danger"> Remove </a> </td>
                             </tr>
                             @endforeach
                           </tbody>
                   </table>
              </div>
              

          </section> <!-- //col 2 -->



      </div><!-- //row -->

     
     </div>
     </div>
<br><br>
</section>


@stop
