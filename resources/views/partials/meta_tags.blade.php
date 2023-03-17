<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="description" content="school financial management App, finman" />
  <meta name="keywords" content="school financial management App, finman" />
  <meta name="author" content="School Portal 360" />
  <meta name="format-detection" content="telephone=no" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="" />
  <meta name="theme-color" content="#38c172" />
  <?php /*** <meta name="csrf-token" content="{{csrf_token()}}"> ***/ 
  $user = auth()->user();
  $school = $user->school;
  $user ?? '';
  $logo_url = $user->portal_url()."uploaded_files/school_logo/".$school->id.'/'.$school->logo;

  //$logo_url = "/img/".$user->school->logo;
  ?>
  @if( $user->school->logo )
  <link rel="shortcut icon" href="{{$logo_url}}" type="image/x-icon">
  @else
  <link rel="shortcut icon" href="{{asset('dist/img/logo.jpg')}}" type="image/x-icon">
  @endif 