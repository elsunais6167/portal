$(function(){
    
var trashed_transaction_datatable = function(){

    var url = '/auth/fetch_trashed_transaction';
    $('.trashed_transaction_datatable_table').DataTable({
    destroy:true,
    order:[[0, 'desc']],
    responsive:true,
    pageLength:50,
    processing:true,
    serverSide:true,
    lengthMenu: [ [ 50, 100, 200, -1 ], [ 50, 100, 200, 'All' ] ], 
    //dom: 'Bfrtip',
    ajax: url,
    columns:[
        {data: 'checkbox', name: 'checkbox', className:'no_print', searchable:false, orderable:false },
        {data: 'id', name: 'id'}, 
        {data: 'student_id', name: 'student_id'}, 
        {data: 'student_name', name: 'student_name'},
        {data: 'classes', name: 'classes'}, 
        {data: 'fee_type', name: 'fee_type'}, 
        {data: 'amount_paid', name: 'amount_paid'},  
        {data: 'balance', name: 'balance'},
        {data: 'payment_mode', name: 'payment_mode'},
        {data: 'deleted_by', name: 'deleted_by'},
        {data: 'updated_at', name: 'updated_at'},               
       ],

       drawCallback: () => {
        $('#undo_trashed_transaction').click( (e) => {
              e.preventDefault();
           var data = $('#undo_trashed_transaction_form').serialize();
               if( confirm('Confirm this Activity...') )
               {
                $.post('/auth/undo_trashed_transaction', data, ( res ) => {
                 if(res.error) return alert(res.error);
                 trashed_transaction_datatable();
                });
               }
            });
        }
    });
};

trashed_transaction_datatable();
});