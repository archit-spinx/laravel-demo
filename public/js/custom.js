var page = 1;
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
        page++;
        if ($("input[name='ajaxload']").val() == 0 ) {
            loadMoreData(page);
        }
    } 
});

function loadMoreData(page){
  	$.ajax(
    {
        url: '?page=' + page,
        type: "get",
        beforeSend: function()
        {
            $('.ajax-load').show();
        }
    })
    .done(function(data)
    {
        console.log(data.html);
        if(data.html == ""){
            $("input[name='ajaxload']").val(1);
            $('.ajax-load').html("No more records found");
            return;
        } else {
            $("input[name='ajaxload']").val(0);
        }
        $('.ajax-load').hide();
        $(".products").last().after(data.html);
    })
    .fail(function(jqXHR, ajaxOptions, thrownError)
    {
          alert('server not responding...');
    });
}

$(document).on('ready',function(){
    $('#search').on('keyup',function(){
        $value = $(this).val();
        $.ajax(
        {
            url: '?search=' + $value,
            type: "get",
            beforeSend: function()
            {
                $('.ajax-load').show();
            }
        })
        .done(function(data)
        {
            if(data.html == ""){
                $('.ajax-load').html("No Products found");
                return;
            }
            $('.ajax-load').hide();
            $(".all-products").html(data.html);
            page = 0;
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
              alert('server not responding...');
        });
    });

    $("select[name='filter_by_price']").on("change",function(){
        $val = $(this).find(":selected").val();
        $dataVal = $(this).attr('data-value');
        if ($val != '') {
            $.ajax(
            {
                url: '?filter=' + $dataVal,
                data: {
                    'price' : $val
                },
                type: "get",
                beforeSend: function()
                {
                    $('.ajax-load').show();
                }
            })
            .done(function(data)
            {
                if(data.html == ""){
                    $('.ajax-load').html("No Products found");
                    return;
                }
                $('.ajax-load').hide();
                $(".all-products").html(data.html);
                page = 0;
            })
            .fail(function(jqXHR, ajaxOptions, thrownError)
            {
                  alert('server not responding...');
            });
        }
    });
});