
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js ')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.min.js ')}}"></script>
<!-- Toastr -->
<script src="{{asset('plugins/toastr/toastr.min.js ')}}"></script>
<!-- App scripts -->
<script src="{{asset('dist/js/adminlte.min.js ')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>

<script>
$(window).click(function(){
    var body = $('body');
    if(body.hasClass('sidebar-open')){
        $('aside').click(function(){
           body.removeClass('sidebar-open').addClass('sidebar-collapse');
        });  
    }
});
  
</script>
