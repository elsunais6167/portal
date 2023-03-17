
$( function(){
    
    $("#search_records_form").submit( (e) => {
        e.preventDefault();
        var term = $('.term_search').val(),
            sessions = $('.session_search').val(),
            fee_type = $('.fee_type_search').val(),
            transaction_type = $('.transaction_type_search').val();
            transaction_history_datatable(term, sessions, fee_type, transaction_type);
    });

    function show_transaction_history_total_amounts(term, sessions, fee_type, transaction_type)
    {
        var total_expected_amount = $('#total_expected_amount'),
        total_received_amount = $('#total_received_amount'),
        total_outstanding_payment = $('#total_outstanding_payment'),
        total_discount = $('#total_discount'),
        url = '/auth/fetch_transaction_history_total_amounts?term='+term+'&sessions='+sessions+'&fee_type='+fee_type+'&transaction_type='+transaction_type;

       $.get(url, (res) => {
        total_expected_amount.html( res.total_expected_amount );
        total_received_amount.html( res.total_amount_received );
        total_outstanding_payment.html( res.total_outstanding_payment );
        total_discount.html( res.total_discount_amount );
       });
    }

    var transaction_history_datatable = (term='', sessions='', fee_type='', transaction_type='') => {
        
    show_transaction_history_total_amounts(term, sessions, fee_type, transaction_type);
    var url = '/auth/fetch_transaction_history?term='+term+'&sessions='+sessions+'&fee_type='+fee_type+'&transaction_type='+transaction_type;
    $('.transaction_history_datatable').DataTable({
    destroy:true,
    order:[[0, 'desc']],
    responsive:true,
    pageLength:100,
    processing:true,
    serverSide:true,
    lengthMenu: [ [ 100, 200, 500, -1 ], [ 100, 200, 500, 'All' ] ], 
    //dom: 'Bfrtip',
    ajax: url,
    columns:[
        {data: 'checkbox', name: 'checkbox', searchable:false, orderable:false ,  className:'no_print'},
        {data: 'id', name: 'id'}, 
        {data: 'student_id', name: 'student_id' , }, 
        {data: 'student_name', name: 'student_name'},
        {data: 'classes', name: 'classes'}, 
        {data: 'term', name: 'term', className:'text-capitalize'},
        {data: 'sessions', name: 'sessions'},
        {data: 'fee_type', name: 'fee_type'}, 
        {data: 'expected_amount', name: 'expected_amount'}, 
        {data: 'discount_amount', name: 'discount_amount'},
        {data: 'amount_paid', name: 'amount_paid'},  
        {data: 'balance', name: 'balance'}, 
        {data: 'payment_mode', name: 'payment_mode'},
        {data: 'description', name: 'description'},
        {data: 'created_at', name: 'created_at'},
        {data: 'received_by', name: 'received_by',  className:'no_print'}, 
        {data: 'sub_payments', name: 'sub_payments',  className:' word_no_wrap' },  
        {data: 'print_receipts', name: 'print_receipts',  className:'no_print word_no_wrap' },      
       ],

       drawCallback: () => {
        $('#delete_transaction_btn').click( (e) => {
              e.preventDefault();
           var data = $('#delete_transaction_form').serialize();
               if( confirm('Confirm this Activity...') )
               {
                $.post('/auth/delete_transactions', data, ( res ) => {
                    transaction_history_datatable();
                    if(res.error) return alert(res.error);
                    alert(" Transaction Deleted Succesfully... ");
                });
               }
            });
        }
    }); 
    $('#search_modal').modal('hide');
};

transaction_history_datatable();

});