function go_back(){ window.history.back(); }

  $( function() {
    var text = $('.get_title_text').text(), 
        school_name = $('#school_name').text();
        document.title =  text + " - "+school_name;

        $(".checkedAll").click(function () {
                if (this.checked) {
                    $(".checkSingle").each(function () {
                        this.checked = true;
                    });
                } else {
                    $(".checkSingle").each(function () {
                        this.checked = false;
                    });
                }
        });

        $(".checkedAll1").click(function () {
                if (this.checked) {
                    $(".checkSingle1").each(function () {
                        this.checked = true;
                    });
                } else {
                    $(".checkSingle1").each(function () {
                        this.checked = false;
                    });
                }
        });

        $(".checkedAll2").click(function () {
                if (this.checked) {
                    $(".checkSingle2").each(function () {
                        this.checked = true;
                    });
                } else {
                    $(".checkSingle2").each(function () {
                        this.checked = false;
                    });
                }
        });

        $(".checkedAll3").click(function () {
            if (this.checked) {
                $(".checkSingle3").each(function () {
                    this.checked = true;
                });
            } else {
                $(".checkSingle3").each(function () {
                    this.checked = false;
                });
            }
        });

        $('.alert').delay(5000).fadeOut();   
  });


  function exportToCSV()
  {
        $('.excel_rmv').hide();
        $(".exportToCsv").tableToCSV();
  }

  window.addEventListener('click', function(){
    $('.no_print').show();
    $('.print_table_div').addClass('table-responsive');
    $('.trxn_history_amount_col').removeClass('col-md-3').addClass('col-lg-3');
  });

  function print_docs()
  {
    $('.no_print').hide();
    $('.excel_rmv').show();
    $('.trxn_history_amount_col').removeClass('col-lg-3').addClass('col-md-3');
    $('.print_table_div').removeClass('table-responsive');
    window.print();
  }
  
//jquery for csv export ..
jQuery.fn.tableToCSV = function() {
    
    var clean_text = function(text){
        text = text.replace(/"/g, '""');
        return '"'+text+'"';
    };
    
    $(this).each(function(){
            var table = $(this);
            var caption = document.title;
            var title = [];
            var rows = [];

            $(this).find('tr').each(function(){
                var data = [];
                $(this).find('th').each(function(){
                    var text = clean_text($(this).text());
                    title.push(text);
                    });
                $(this).find('td').each(function(){
                    var text = clean_text($(this).text());
                    data.push(text);
                    });
                data = data.join(",");
                rows.push(data);
                });
            title = title.join(",");
            rows = rows.join("\n");

            var csv = title + rows;
            var uri = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
            var download_link = document.createElement('a');
            download_link.href = uri;
            var ts = new Date().getTime();
            if(caption==""){
                download_link.download = ts+".csv";
            } else {
                download_link.download = caption+"-"+ts+".csv";
            }
            document.body.appendChild(download_link);
            download_link.click();
            document.body.removeChild(download_link);
    });
    
};
       
