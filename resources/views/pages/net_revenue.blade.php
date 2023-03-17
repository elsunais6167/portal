@extends('layouts.app')
@section('content')

<div class="content-header"> <!-- content-header -->
      <div class="container-fluid"> <!-- .container-fluid -->
        <div class="row mb-2">

          <div class="col-sm-6">
            <h6 class="m-0 text-dark get_title_text"> Net Income Report </h6>
          </div><!-- /.col -->

          <div class="col-sm-6 d-none d-sm-inline-block">
            <ol class="breadcrumb float-sm-right">
               <li class="breadcrumb-item"><a onclick="go_back()" href="javascript:void(0)"> <i class="fa fa-arrow-left"></i> Go back </a></li>
              <li class="breadcrumb-item active"> Net Income </li>
            </ol>
          </div><!-- /.col -->

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
</div> <!-- /content-header -->


 <section class="container-fluid"> <!-- container-fluid -->
     
 <section class="card"> <!-- card -->
 <div class="card-header">
     <h6> Net Income Report </h6>
 </div>
     <section class="card-body">

                <!-- Button action-->
        <div class="dropdown no_print">
            <button class="btn-sm btn btn-outline-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              Export
            </button>  
               
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton"> 
    
                      <div class="dropdown-divider"></div>
                      <button onClick="print_docs()" type='button' class=" btn-sm dropdown-item">
                        <i class="fa fa-print text-muted"></i> Print Record
                      </button>

                      <div class="dropdown-divider"></div>
                      <button onClick="exportToCSV()" type='button' class="btn-sm dropdown-item">
                        <i class="fa fa-file-csv text-muted"></i> Export to CSV
                      </button>
                      <div class="dropdown-divider"></div>

                </div> <!-- //Drop-down menu -->

           </div> 
        
          <!-- ///Button Action  -->
       
       <div class="mt-3 print_table_div table-responsive"> <!-- TABLE DIV-->
           <table class="text-capitalize  exportToCsv table table-striped word_no_wrap net_revenue_datatable">
               <thead>
                   <tr>
                       <th class="no_print"> # </th>
                       <th> Term </th>
                       <th> Session </th>
                       <th> Total Revenue (&#8358;) </th>
                       <th> Total Expenditure (&#8358;) </th>
                       <th> Net Income (&#8358;) </th>
                   </tr>
               </thead>
               <tbody>
                   @foreach( $net_incomes as $net )
                   <tr>
                       <td class="no_print"> {{$loop->index + 1}} </td>
                       <td> {{  $net->term }} </td>
                       <td> {!! $net->sessions !!} </td>
                       <td> {!! number_format( $net->total_revenue, 2 ) !!} </td>
                       <td> {{  number_format( $net->total_expenses, 2) }} </td>
                       <td> {{  number_format( $net->net_revenue , 2) }} </td>
                   </tr> 
                   @endforeach
               </tbody>

           </table>
       </div> <!-- //TABLE DIV -->
     </section>
 </section> <!-- CARD -->

 </section> <!-- //end container-fluid -->

 <script>
     $(function(){ $('.net_revenue_datatable').DataTable(); });
 </script>
@stop