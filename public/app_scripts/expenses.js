$( function(){

    function show_total_expenditure_transaction_amount(today, term, sessions)
    {
      var  total_expenditures = $('.total_expenditures'),
           total_expenditures_amount =  $('.total_expenditures_amount')
           url = "/auth/fetch_total_expenditure_amount?today="+today+"&term="+term+"&sessions="+sessions ;

       $.get(url, (res) => {
         total_expenditures.html( res.total );
         total_expenditures_amount.html( res.total_amount );
       });
    } 

    function fetch_expenses_data(today=1, term='', sessions=''){
               var url = "/auth/fetch_all_expenditures?today="+today+"&term="+term+"&sessions="+sessions ;
               show_total_expenditure_transaction_amount( today, term, sessions );

           $('.expenses_datatable').DataTable({
           destroy:true,
           order:[[0,'desc']], 
           responsive:true,
           pageLength:100,
           processing:true,
           serverSide:true,
           lengthMenu: [ [100, 200, 500, -1 ], [ 100, 200, 500, 'All' ] ], 
           //dom: 'Bfrtip',
           ajax: url,
           columns:[
               {data: 'checkbox', name: 'checkbox',className:'no_print', searchable:false, orderable:false }, 
               {data: 'receiver', name: 'receiver'}, 
               {data: 'amount', name: 'amount'},
               {data: 'description', name: 'description'}, 
               {data: 'term', name: 'term', className:'text-capitalize'}, 
               {data: 'sessions', name: 'sessions'}, 
               {data: 'created_by', name: 'created_by'},
               {data: 'created_at', name: 'created_at'},             
             ],

             drawCallback: () => {
                   $('.delete_expenses_btn').click( () => {
                      var data = $('#delete_expenses_form').serialize();
                          if( confirm('Confirm this Activity...') )
                          {
                           $.post('/auth/delete_expenditures', data, res => {
                            if(res.error) return alert(res.error);
                            var query = get_search_query();
                            fetch_expenses_data(query.today, query.term, query.sessions);
                          });
                          }
                   });
             }
           }); 
    }

    function get_search_query()
    {
      var today = $('.today_record_value').val(),
          term  = $('.search_term').val(),
          sessions = $('.search_sessions').val(),
          query = {today:today, term:term, sessions:sessions} ;
          return query;
    }

    $('#search_today_record_btn').click( () => {
         $('.today_record_value').val(1);
          var query = get_search_query();
          fetch_expenses_data(1, query.term, query.sessions );
          $('#search_record_modal').modal('hide');
    });

    $('#search_records_form').submit( e => {
      e.preventDefault();
      $('.today_record_value').val(0);
      var query = get_search_query();
      fetch_expenses_data(0, query.term, query.sessions );
      $('#search_record_modal').modal('hide');
    });

    fetch_expenses_data();

     $('#store_expenses_form').submit( (e) => {
       e.preventDefault();
       var data = $('#store_expenses_form').serialize(),
           url = "/auth/store_expenses",
           loader = $('#loader');
           loader.show();
           $.post(url, data, (res) => {
             loader.hide();
             if(res.error) return alert(res.error);
             fetch_expenses_data();
             $('#store_expenses_modal').modal('hide')
           });
     });

  });