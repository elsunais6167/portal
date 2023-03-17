@extends('layouts.app')
@section('content')

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Change Password Staff </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Change Password Staff </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->

 <section class="container-fluid"> <!-- container-fluid -->
     
 <section class="card"> <!-- card -->
  <div class="card-header text-sm d-flex">
    Change Password
  </div>

     <section class="card-body"> <!-- card-body  -->
     
      <form method="POST" action="{{ route('change-staff-password', $staff->id) }}">
            @csrf
            @method('PATCH')
        <div class="col-md-6">
          <div class="form-group">
              <label for=""> New Password  </label>
              <input placeholder="New Password"  type="text" name='new_password' class="form-control" required>
          </div>
        </div>

        <div class="form-group">
                <button class="btn btn-primary" type="submit">
                    Update
                </button>
            </div>
      </form>
 </section> <!-- Card -->

 </section> <!-- //end container-fluid -->

@stop