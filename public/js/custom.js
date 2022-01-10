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

function filterForm(){
    $.ajax(
    {
        url: '?filter=1',
        type: "get",
        data: $("form[name='filter']").serialize(),
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

    $("select[name='price']").on("change",function(e){
        e.preventDefault();
        filterForm();
    });

    $("select[name='category']").on("change",function(e){
        e.preventDefault();
        filterForm();
    });

    $(".product-delete").on("click",function(e){
        e.preventDefault();
        var $id = $(this).attr('data-id');
        var settings = {
          "url": "http://127.0.0.1:8000/api/product/delete/"+$id,
          "method": "DELETE",
          "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
          console.log(response);
          alert(response.message);

        }).fail(function() {
            console.log('Product Couldn\'t be deleted!!')
        });
    });

    $(".add-product").on("click",function(e){
        e.preventDefault();
        var settings = {
          "url": "http://127.0.0.1:8000/api/product/create/",
          "data": $('form').serialize(),
          "method": "POST",
          "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
          console.log(response);
          alert(response.message);
        }).fail(function() {
            console.log('Product Couldn\'t be Created!!')
        });
    });

    $(".update-product").on("click",function(e){
        e.preventDefault();
        var $id = $("input[name='product_id']").val();
        var settings = {
          "url": "http://127.0.0.1:8000/api/product/update/"+$id,
          "data": $('form').serialize(),
          "method": "POST",
          "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
          console.log(response);
          alert(response.message);
        }).fail(function() {
            console.log('Product Couldn\'t be Updated!!')
        });
    });
});