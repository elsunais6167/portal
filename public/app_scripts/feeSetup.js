this.fetch_fee_type_items();
this.fetch_fee_type();
this.fetch_fee_allocation();
this.fetch_fee_discount();

function confirmation()
{
    return confirm('Please, Confirm this Activity... ');
}

function resetForm()
{
    $('.form-control').val('');
}

function fetch_fee_type(){
     var table_value = "",
         tbody = $('#show_fee_types_table'),
         url = "/auth/fetch_fee_types",
         total = $('.total_fee_type'),
         fee_type_options = $('.fee_type_options'),
         options = '<option value=""> - Select Fee Type - </option>';

         $.get(url, (res) => {
            if(res.length){
                res.forEach( (val) => {
                table_value+= "<tr>"+
                              "<td><input type='checkbox' class='checkSingle check_btn' name='id[]' value='"+val.id+"'> </td>" +
                              "<td>"+ val.name+"</td></tr>";
                options += "<option value='"+val.name+"'> "+val.name+"</option>" ;
                total.html( res.length );
                tbody.html( table_value );
                fee_type_options.html( options ); 
             });
            }
            else{
                total.html( res.length );
                tbody.html('');
            }
        });
}

function fetch_fee_allocation(){
     var table_value = "",
         tbody = $('#fee_allocation_table'),
         url = "/auth/fetch_fee_allocation",
         total = $('.total_fee_allocation'),
         arm = '';

         $.get(url, (resp) => {
           if(resp.length){
              resp.forEach( (val) => {
                (val.arms == null) ? arm = '' : arm = val.arms;
                table_value+= "<tr>"+
                              "<td><input type='checkbox' class='checkSingle1 check_btn' name='id[]' value='"+val.id+"'> </td>"
                              +"<td>"+ val.fee_type +"</td>"
                              +"<td>"+ val.fee_type_item +"</td>"
                              +"<td>"+ val.classes +"</td>"
                              +"<td>"+ arm +"</td>"
                              +"<td class='text-capitalize'>"+ val.term +"</td>"
                              +"<td>"+ val.sessions +"</td>"
                              +"<td>"+ val.amount +"</td>"
                              +"<td>"+ val.created_by +"</td>"
                              +"<td>"+ val.created_at +"</td></tr>";
                total.html( resp.length );
                tbody.html( table_value );
             });
            }
           else{
               tbody.html('');
               total.html( resp.length );
            }
         });
}

function fetch_fee_type_items(){
    var table_value = "",
        tbody = $('#fee_type_item_table'),
        url = "/auth/fetch_fee_item",
        total = $('.fee_item_total');

        $.get(url, (resp) => {
            if(resp.length){
                resp.forEach( (val) => {
                table_value += "<tr>"+
                              "<td><input type='checkbox' class='checkSingle3 check_btn#fee_item_input_val' name='id[]' value='"+val.id+"'></td>"
                              +"<td>"+ val.fee_type +"</td>"
                              +"<td>"+ val.name +"</td></tr>";
                total.html( resp.length );
                tbody.html( table_value );
            });
           }
           else{
               tbody.html('');
               total.html( resp.length );
            }
        });
}

function fetch_fee_discount(){
    var table_value = "",
         tbody = $('#fee_discount_table'),
         url = "/auth/fetch_fee_discount",
         total = $('.total_fee_discount'),
         arm = '';

         $.get(url, (resp) => {
           if(resp.length){
              resp.forEach( (val) => {
                (val.arms == null) ? arm = '' : arm = val.arms;
                table_value+= "<tr>"+
                              "<td><input type='checkbox' class='checkSingle2 check_btn' name='id[]' value='"+val.id+"'> </td>"
                              +"<td>"+ val.student_id +"</td>"
                              +"<td>"+ val.student_name +"</td>"
                              +"<td class='text-capitalize'>"+ val.classes +' '+ arm +"</td>"
                              +"<td>"+ val.fee_type +"</td>"
                              +"<td>"+ val.amount +"</td>"
                              +"<td class='text-capitalize'>"+ val.term +"</td>"
                              +"<td>"+ val.sessions +"</td>"
                              +"<td>"+ val.description +"</td>"
                              +"<td>"+ val.created_by +"</td>"
                              +"<td>"+ val.created_at +"</td></tr>";
                total.html( resp.length );
                tbody.html( table_value );
             });
           }else{
               tbody.html('');
               total.html( resp.length );
           }
         });
}

function delete_fee_types(){
    if( confirm(" Deleting this Fees will delete associated Fee Items under this Fee Category...") ){
        var data = $('.delete_fee_types_form').serialize(),
            url = "/auth/delete_fee_types",
            trash_icon =  $('.remove_fee_trash_icon'),
            loader_icon = $('.remove_fee_loader_icon');
            trash_icon.hide();
            loader_icon.show();
            $.post(url, data, (res) => {
                if(res.error) return alert(res.error);
                fetch_fee_type();
                fetch_fee_type_items();
                loader_icon.hide();
                trash_icon.show();                  
            });
    }
}

function delete_fee_allocation(){
    if( this.confirmation() ){
        var data = $('.delete_fee_allocation_form').serialize(),
            url = "/auth/delete_fee_allocation",
            trash_icon =  $('.delete_fee_allocation_trash_icon'),
            loader_icon = $('.delete_fee_allocation_loader_icon');
            trash_icon.hide();
            loader_icon.show();
            $.post(url, data, (res) => {
                if(res.error) return alert( res.error );
                fetch_fee_allocation();
                loader_icon.hide();
                trash_icon.show();
            });
    }
} 

function delete_fee_discount(){
    if( this.confirmation() ){
        var data = $('#delete_fee_discount_form').serialize(),
            url = "/auth/delete_fee_discount",
            trash_icon =  $('.delete_fee_discount_trash_icon'),
            loader_icon = $('.delete_fee_discount_loader_icon');
            trash_icon.hide();
            loader_icon.show();
            $.post(url, data, (res) => {
                if( res.error ) return alert( res.error );
                fetch_fee_discount();
                loader_icon.hide();
                trash_icon.show();
            });
    }
} 

$( function(){  
    $('.delete_fee_type_items_btn').click( () => {
        if( confirmation() ){
            var data = $('#fee_item_input_val').serialize(),
                url = "/auth/delete_fee_items",
                trash_icon =  $('.delete_fee_type_item_trash_icon'),
                loader_icon = $('.delete_fee_type_item_loader_icon');
                trash_icon.hide();
                loader_icon.show(); 
                $.post(url, data, (res) => {
                    if(res.error) return alert(res.error);
                    fetch_fee_type_items();
                    loader_icon.hide();
                    trash_icon.show();
                });
        }
    });

    $('.change_fee_option').on('change', () => {
        var select = $('.fee_type_item_option'),
            value = $('.change_fee_option').val(),
            options = '<option value=""> - Select - </option>';
            $.get('/auth/get_fee_type_item_options?fee_type='+value, function(res){
                if( res.length ){
                    res.forEach( function(val){
                        options += "<option value=' "+val.name+"'>"+ val.name+ "</option>";
                    });
                }
                select.html(options);
            });
    });
    
    $('#fee_discount_student_id').on('input', () => {
        var student_name = $('#fee_discount_student_name'),
            student_class = $('#fee_discount_student_class'),
            student_arm = $('#fee_discount_student_arm'),
            student_id = $('#fee_discount_student_id').val(),
            name = '',
            arm = '',
            url = "/auth/fetch_student_details",
            data = {student_id: student_id},
            loading = $('.attr_loading');
            loading.attr('placeholder', 'Loading...');
            $.get(url, data, (res) => {
                if(res){
                    (res.target_arm)? arm = res.target_arm : arm = '';
                    name = res.last_name+' '+res.first_name+' '+res.other_name;
                    student_name.val(name);
                    student_class.val(res.target_class);
                    student_arm.val(arm);
                    loading.attr('placeholder', '');
                }else{        
                    loading.attr('placeholder', 'Enter Student ID First... ');
                    student_name.val('');
                    student_class.val('');
                    student_arm.val('');
                }
            });
    });

    $('#store_fee_type_form').submit( (e) => {
        e.preventDefault();
     var loader = $('.store_fee_type_loader'),
         data = $('#store_fee_type_form').serialize(),
         url = "/auth/store_fee_type";  
         loader.show();
         $.post(url, data, (res) => {
             loader.hide();
             if(res.error) return alert(res.error);
              fetch_fee_type();
              resetForm();
         });    
    });

    $('#store_fee_items_form').submit( (e) => {
        e.preventDefault();
     var loader = $('.store_fee_item_loader'),
         data = $('#store_fee_items_form').serialize(),
         url = "/auth/store_fee_item";  
         loader.show();
         $.post( url, data, (res) => {
            loader.hide();
            if(res.error) return alert(res.error);
            fetch_fee_type();
            fetch_fee_type_items();
            resetForm();
         });    
    }); 

    $('.store_fee_allocation_form').submit( (e) => {
        e.preventDefault();
     var loader = $('.store_fee_allocation_loader'),
         data   = $('.store_fee_allocation_form').serialize(),
         url = "/auth/store_fee_allocation";  
         loader.show();
         $.post(url, data, (res) => {
             loader.hide();
             if(res.error) return alert(res.error);
             fetch_fee_allocation();
             $('#store_fee_allocation_modal').modal('hide');
             resetForm();
         });    
    });


    $('.store_fee_discount_form').submit( (e) => {
        e.preventDefault();
     var loader = $('.store_fee_discount_loader'),
         data   = $('.store_fee_discount_form').serialize(),
         url = "/auth/store_fee_discount";  
         loader.show();
         if($.trim( $('#fee_discount_student_name').val() ) == null) return alert('Please, Ensure Student ID is correctly Inserted...');
         $.post(url, data, (res) => {
             loader.hide();
             if(res.error) return alert(res.error);
             fetch_fee_discount();
             $('#store_fee_discount_modal').modal('hide');
             resetForm();
         });    
    });

});