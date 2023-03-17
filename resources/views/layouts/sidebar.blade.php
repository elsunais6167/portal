<?php 
 $user       = auth()->user(); 
 $logo_url   = $user->portal_url()."uploaded_files/school_logo/".$user->school_id.'/'.$user->school->logo;
 $user_img   = $user->portal_url()."uploaded_files/passports/".$user->school_id.'/'.$user->photo;
 $portal_url = $user->portal_url();
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
    <a href="#" class="brand-link">
        @if($user->school->logo)
         <img src="{{$logo_url}}" class="brand-image img-circle elevation-2" style="opacity: .8; width:30px; height:30px;">
         @else
         <img src="/img/logo.jpg" class="brand-image img-circle elevation-2" style="opacity: .8; width:30px; height:30px;">
        @endif
      <span style="font-size:13px;" class="brand-text font-weight-light" id="school_name"> {{$user->school->name}} </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
    
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
       
        <div class="image">
        @if( $user->photo )
          <img src="{{ $user_img }}" class="img-circle elevation-2 sidebar_img_style" alt="">
           @else 
          <i class='text-info fa-3x fa fa-user-circle'></i>
        @endif
        </div>
       
        <div class="info">
          <a style="font-size:13px;" href="#" class="d-block"> {{ $user->last_name. ' '. $user->first_name }} </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">   
        
        @if( $user->admin || $user->sub_admin )
        <li class="nav-header"> DASHBOARD </li>

        <li class="nav-item">
            <a href="{{ route('dashboard') }}#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <!-- <span class="right badge badge-danger">New</span> -->
              </p>
            </a>
          </li>

          <!-- <li class="nav-item">
            <a href="{{$portal_url}}" class="nav-link">
              <i class="nav-icon fas fa-globe"></i>
              <p>
                Back to Portal
              </p>
            </a>
          </li>  -->
          
          <li class="nav-header"> SETTINGS </li>

          <li class="nav-item">
            <a href="{{route('settings')}}#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Academic Settings
              </p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="{{route('show_subject_settings_page')}}#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Subject Settings
              </p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="{{route('show_class_arm_settings_page')}}#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Class / Arm Settings 
              </p>
            </a>
          </li> 

          <li class="nav-item">
            <a href="{{route('show_grade_settings_page')}}#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Grade Settings
              </p>
            </a>
          </li> 

          @if( $user->admin || $user->sub_admin)
          <li class="text-uppercase nav-header"> RECORDS </li>

          <li class="nav-item">
            <a href="{{route('students_management')}}#" class="nav-link">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>
                Students Management
              </p>
            </a>
          </li> 

          @if( $user->admin)
          <li class="nav-item">
            <a href="{{route('staff_management')}}#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Staff Management
              </p>
            </a>
          </li>
          @endif

          <li class="nav-item">
            <a href="{{route('subject_teachers')}}#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Subject Teachers
              </p>
            </a>
          </li>
         
          <li class="nav-item">
            <a href="{{route('form_teachers')}}#" class="nav-link">
              <i class="nav-icon fas fa-user-plus"></i>
              <p>
                Class Teachers
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('view_result_page')}}#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                View Results
              </p>
            </a>
          </li>
          @endif
          @endif

          <li class="text-uppercase nav-header"> MODULES </li>
          <li class="nav-item">
            <a href="{{route('my_form_class')}}#" class="nav-link">
              <i class="nav-icon fas fa-laptop"></i>
              <p>
                My Class
              </p>
            </a>
          </li>
        
          @if( $user->accountant )
          <li class="nav-header"> TRANSACTIONS </li>

          <li class="nav-item nav_collapse">
            <a href="{{route('transactions')}}#" class="nav-link">
              <i class="nav-icon fa fa-bar-chart"></i>
              <p> Daily Transactions </p>
            </a>
          </li>

          <li class="nav-item nav_collapse">
            <a href="{{route('expenditures')}}#" class="nav-link">
              <i class="nav-icon fa fa-money"></i>
              <p> Expenditures </p>
            </a>
          </li>

          <li class="nav-item nav_collapse">
            <a href="{{route('transaction_history')}}#" class="nav-link">
              <i class="nav-icon fa fa-database"></i>
              <p> Transaction History </p>
            </a>
          </li>

          <li class="nav-item nav_collapse">
            <a href="{{route('net_revenue')}}#" class="nav-link"> 
              <i class="nav-icon fa fa-line-chart"></i>
              <p> Net Income Report </p>
            </a>
          </li>

        @if( $user->admin )
          <li class="nav-item nav_collapse">
            <a href="{{route('fee_setup')}}#" class="nav-link">
              <i class="nav-icon fa fa-th"></i>
              <p> Fee Setup </p>
            </a>
          </li>

          <!-- <li class="nav-item nav_collapse">
            <a href="{{route('invoice')}}#" class="nav-link">
              <i class="nav-icon fa fa-edit"></i>
              <p> Invoice </p>
            </a>
          </li>

          <li class="nav-item nav_collapse">
            <a href="{{route('inventory')}}#" class="nav-link">
              <i class="nav-icon fa fa-database"></i>
              <p> Inventory </p>
            </a>
          </li> -->

          <li class="nav-item nav_collapse">
            <a href="{{route('deleted_transactions')}}#" class="nav-link">
              <i class="nav-icon fa fa-trash"></i>
              <p> Trash </p>
            </a>
          </li>
        @endif

        @endif

          <li class="nav-item nav_collapse">
            <a href="{{route('change_password_page')}}#" class="nav-link">
              <i class="nav-icon fa fa-key"></i>
              <p> Change Password </p>
            </a>
          </li>

          <li class="nav-item nav_collapse">
            <a href="{{route('logout')}}#" class="nav-link">
              <i class="nav-icon fa fa-power-off "></i>
              <p> Logout </p>
            </a>
          </li>

        </ul>
      </nav>
      <br><br> <br> <br><br>
      
    <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

