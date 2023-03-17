function show_today_date()
{
    setInterval( () => {
         var today     =  new Date();
         var hour      =  today.getHours(),
             minutes   =  today.getMinutes(),
             seconds   =  today.getSeconds(),
             meridean  =  'am';

         if(hour < 10) hour = '0'+hour;
         if(hour >= 12){
             hour = Number(hour) - 12 ;
             if(hour < 10) hour = '0'+hour; 
               meridean = 'pm';
         }         
         if(hour == 0) hour = '12';
         if(minutes < 10) minutes = '0'+minutes;
         if(seconds < 10) seconds = '0'+seconds;
         var time = hour +' : '+ minutes +' : '+ seconds +' '+ meridean; 
         $('.show_today_date').text(time);
     }, 500);
}
show_today_date();

function show_daily_total_transaction_amount()
{
    var total_expected_amount = $('.total_expected_amount'),
        total_amount_received = $('.total_amount_received'),
        total_outstanding_amount = $('.total_outstanding_amount'),
        total_discount_amount = $('.total_discount_amount'),
        total_completed_transactions = $('.total_completed_transactions'),
        total_incompleted_transactions = $('.total_incompleted_transactions'),
        total_transactions = $('.total_transactions'),
        url = '/auth/fetch_daily_total_transaction_amount';

    $.get(url, (res) => {
        total_expected_amount.html( res.total_expected_amount );
        total_amount_received.html( res.total_amount_received );
        total_outstanding_amount.html( res.total_outstanding_amount );
        total_discount_amount.html( res.total_discount_amount );
        total_completed_transactions.html( res.total_completed_transactions);
        total_incompleted_transactions.html( res.total_incompleted_transactions);
        total_transactions.html( res.total_transactions);
    });
}

$( function(){   

    var transaction_datatable = () => {
        
    show_daily_total_transaction_amount();

    var url = '/auth/fetch_fee_revenues';
    $('.transaction_datatable').DataTable({
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
        {data: 'checkbox', name: 'checkbox', className:'no_print excel_rmv', searchable:false, orderable:false },
        {data: 'id', name: 'id'}, 
        {data: 'student_id', name: 'student_id'}, 
        {data: 'student_name', name: 'student_name'},
        {data: 'classes', name: 'classes'}, 
        {data: 'fee_type', name: 'fee_type'}, 
        {data: 'expected_amount', name: 'expected_amount'}, 
        {data: 'discount_amount', name: 'discount_amount'},
        {data: 'amount_due', name: 'amount_due'},
        {data: 'amount_paid', name: 'amount_paid'},  
        {data: 'balance', name: 'balance'},
        {data: 'status', name: 'status'},
        {data: 'payment_mode', name: 'payment_mode'},
        {data: 'received_by', name: 'received_by', className:'no_print'},
        {data: 'description', name: 'description'},
        {data: 'created_at', name: 'created_at'},
        {data: 'print_receipts', name: 'print_receipts', className:'no_print word_no_wrap',},               
       ],

       drawCallback: () => {
        $('#delete_transaction_btn').click( (e) => {
              e.preventDefault();
           var data = $('#delete_transaction_form').serialize();
               if( confirm('Confirm this Activity...') )
               {
                $.post('/auth/delete_transactions', data, ( res ) => { 
                 if(res.error) return alert(res.error);
                 transaction_datatable();
                });
               }
            });
        }
    }); 
};

function fetch_updated_balance_transaction_datatable()
{
    var url = '/auth/fetch_updated_transaction_balance_records';
    $('#updated_balance_transaction_datatable').DataTable({
    destroy:true,
    order:[[0, 'desc']],
    responsive:true,
    pageLength:100,
    processing:true,
    serverSide:true,
    lengthMenu: [ [100, 200, 500, -1 ], [ 100, 200, 500, 'All' ] ], 
   // dom: 'Bfrtip',
    ajax: url,
    columns:[
        {data: 'trxn_id', name: 'trxn_id'}, 
        {data: 'student_id', name: 'student_id'}, 
        {data: 'student_name', name: 'student_name'},
        {data: 'classes', name: 'classes'}, 
        {data: 'fee_type', name: 'fee_type'}, 
        {data: 'amount_due', name: 'amount_due'}, 
        {data: 'initial_amount_paid', name: 'initial_amount_paid'}, 
        {data: 'new_amount_paid', name: 'new_amount_paid'}, 
        {data: 'balance', name: 'balance'}, 
        {data: 'status', name: 'status'},
        {data: 'payment_mode', name: 'payment_mode'},
        {data: 'received_by', name: 'received_by'},
        {data: 'description', name: 'description'},
        {data: 'created_at', name: 'created_at', className:'word_no_wrap'},               
       ],

       drawCallback: () => {
        $('#delete_transaction_btn').click( (e) => {
              e.preventDefault();
           var data = $('#delete_transaction_form').serialize();
               if( confirm('Confirm this Activity...') )
               {
                $.post('/auth/delete_transactions', data, ( res ) => {
                 if(res.error) return alert(res.error);
                 transaction_datatable();
                 fetch_updated_balance_transaction_datatable();     
                });
               }
            });
        }
    }); 
}

$('#update_balance_form').submit( (e) => {
    var loading = $('.update_transaction_section_loader'),
        info = $('.update_transaction_section_info'),
        update_section = $('.update_transaction_section');
        loading.show();
        info.hide();
        update_section.hide();
        
    e.preventDefault();
    $('#update_balance_modal').modal('hide');
    $('#update_transaction_modal').modal('show');
    var data = $('#update_balance_form').serialize();
    $.post('/auth/find_transaction', data, (res)  => {
        loading.fadeOut();
        if(res == '' || res == null ) return info.show();
        $('.trxn_id').text(res.id);
        $('.update_fee_type').text(res.fee_type);
        $('.trxn_id').val(res.id);
        $('.update_student_id').val(res.student_id);
        $('.update_student_name').val(res.student_name);
        $('.update_classes').val(res.classes);
        $('.update_arms').val(res.arms);
        $('.update_term').val(res.term);
        $('.update_sessions').val(res.sessions);
        $('.update_expected_amount').val(res.amount_due);
        $('.update_previous_amount').val(res.updated_amount);
        $('.update_amount_due').val(res.balance);
        update_section.show();
    });
});

$('#submit_transaction_update').submit( function(e) {
    e.preventDefault();
    var btn_loader = $('.update_trxn_loader'),
        update_trxn_btn = $('.update_trxn_btn'),
        data = $('#submit_transaction_update').serialize();
        update_trxn_btn.hide();
        btn_loader.show();

        $.post('/auth/update_transaction', data, function(res){
            update_trxn_btn.show();
            btn_loader.hide();
            if(res.error) return alert(res.error);
            fetch_updated_balance_transaction_datatable();
            transaction_datatable();
            $('#update_transaction_modal').modal('hide');
            $('.form-control').val('');
        });
});

transaction_datatable();
fetch_updated_balance_transaction_datatable();      

    $('#student_id').on('input', () => {
        $('.feeTypeOptions_').val('');
        var student_name =  $('.show_student_name'),
            student_class = $('.show_student_class'),
            student_arm =   $('.show_student_arm'),
            student_id = $('#student_id').val(),
            name = '',
            arm = '',
            url = "/auth/fetch_student_details",
            data = {student_id: student_id},
            loading = $('.attr_loading');
            loading.attr('placeholder', 'Loading...');
            $.get(url, data, (res) => {
                if(res){
                    (res.target_arm) ? arm = res.target_arm : arm = '';
                    name = res.last_name+' '+res.first_name+' '+res.other_name;
                    student_name.val(name);
                    student_class.val(res.target_class);
                    student_arm.val(arm);
                    loading.attr('placeholder', '');
                }
                else{        
                    loading.attr('placeholder', 'Enter Student ID First... ');
                    student_name.val('');
                    student_class.val('');
                    student_arm.val('');
                }
            });
});


$('#store_fee_revenue_form').on('submit', (e) => {
        e.preventDefault();
        if($('.expected_amount').val() == '') return alert('Expected Amount not Detected...');
        var data = $('#store_fee_revenue_form').serialize(),
            url = "/auth/store_fee_revenue",
            submit_btn_ = $('.fee_submit_btn'),
            loader = $('#loader');

            loader.show();
            submit_btn_.prop("disabled", "disabled");
        $.post(url, data, (res) => {
            loader.hide();
            if(res.error) return alert(res.error);
            transaction_datatable(); 
            $('#store_fee_revenue_modal').modal('hide');
            $('.form-control').val('');
            submit_btn_.prop("disabled", "");
        });
});

$('#fee_type_options').on('change', () => {
        var student_name =  $('.show_student_name').val(),
            student_class = $('.show_student_class').val(),
            student_arm =   $('.show_student_arm').val(),
            student_id = $('#student_id').val(),
            fee_type = $('#fee_type_options').val(),
            url = "/auth/fetch_allocated_fee_amount",
            expected_amount = $('.expected_amount'),
            discount_amount = $('.discount_amount'),
            amount_payable = $('.amount_payable'),
            loading = $('.feeTypeOptions_');
            loading.attr('placeholder', 'Loading...'); 

        if( $.trim(student_name) == '' ) return alert( "Please, Enter a Student ID first... " );
        var data = { student_id:student_id, arms:student_arm, classes:student_class, fee_type:fee_type};
        $.get(url, data, (res) => {
            expected_amount.val(res.expected_amount);
            discount_amount.val(res.discount_amount);
            amount_payable.val(res.expected_amount - res.discount_amount)
            loading.attr('placeholder', 'Select Fee Type First...');
        });
});
     
});


