<!DOCTYPE html>
<html lang="en">
<head>
    @include('partials.meta_tags')
    <title> Dashboard </title>
    @include('layouts.header')
    <link rel="stylesheet" type="text/css" href="{{asset('login/css/custom.css')}}"> 
</head>
<script>
     //== Prevent DataTables from showing error alert message  ==========////// 
     $(function(){
      $('.print_docs').on('click', () => {  window.print();  });
          $.fn.DataTable.ext.errMode = 'throw';
          $('.datatable_').DataTable();
        });
</script>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <section class="wrapper">
        @include('layouts.navbar')
        @include('layouts.sidebar') 

         <section class='content-wrapper'>
           @include('messages')
           @yield('content')
         </section>

         <aside class="control-sidebar control-sidebar-dark">
         <!-- Control sidebar content goes here -->
         </aside>   
    </section>
    @include('layouts.footer')
</body>

</html>

