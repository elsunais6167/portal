 <?php
    $user = auth()->user();
 ?>
 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-default"> 
    <!-- Left navbar links -->
    
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="javascript:void(0)"><i class="fas text-warning fa-bars fa-2x"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
      <form class="form-inline ml-3" method="POST" action="{{ route('search_trxn') }}">
        @csrf()
      <div class="input-group input-group-sm">
      <input type="hidden" name="sid" value="{{ $user->school_id }}">
        <input required name="tid" class="form-control form-control-navbar" type="number" placeholder="Enter Transaction ID..." aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search fa-2x"></i>
          </button>
        </div>
      </div>
    </form>
    <!--/// SEARCH FORM -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown text-capitalize">
        <a class="nav-link" data-toggle="dropdown" href="javascript:void(0)">
          <i class="far fa-bell fa-2x"></i>
          <span class="badge badge-danger navbar-badge"> ? </span>
        </a> 
         <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item text-muted dropdown-header"><b> Current Term / Session</b> </span>
          <div class="dropdown-divider"></div>
            <a href="javascript:void(0)" class="dropdown-item">
              <i class='mr-2' class="far fa-calendar"></i>
              @if($active = $user->active_academic_session() )
                <span class="text-muted text-sm">  {{ $active->term .' - '. $active->sessions }} </span>
              @endif
           </a>
       </li>

      <li class="nav-item dropdown user-nav"> 
       <!--  <a class="nav-link"  href="javascript:void(0)" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
        <i class="far fa-user-circle fa-2x"></i></a> -->
        <!-- Dropdown - User Information -->
        <div class=" dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
      
          <a href="#" class="dropdown-item text-muted" >
            <i class="far fa-user-circle fa-sm fa-fw mr-2 text-gray-400"></i>
              My Profile
          </a>

          <a href="#" class="dropdown-item text-muted" >
            <i class="fas fa-home fa-sm fa-fw mr-2 text-gray-400"></i>
             My School
          </a>

          <a href="#" class="dropdown-item text-muted" >
            <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
            Security
          </a>

          <div class="dropdown-divider"></div>
           <a class="dropdown-item text-muted" href="{{route('logout')}}">
            <i class="fas fa-power-off fa-sm fa-fw mr-2 text-gray-400"></i> 
            Logout
           </a>
        </div>
      </li> 
 
    </ul>
  </nav>
  <!-- /.navbar -->
