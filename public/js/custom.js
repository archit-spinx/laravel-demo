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
    if($('#preloader').length === 0){
        jQuery(".loaderm").prepend('<div id="preloader"></div>');
    }
    $.ajax(
    {
        url: '/search-products',
        type: "post",
        data: $("form[name='filter']").serialize(),
        beforeSend: function()
        {   
            
            $('.ajax-load').show();
        }
    })
    .done(function(data)
    {
        jQuery("#preloader").remove();    
        if(data == ""){
            $('.ajax-load').html("No Products found");
            return;
        }else {
            $('.ajax-load').hide();
            $(".all-products").html(data);
            var productCount = $('#totalcount').val();
            if (typeof productCount != 'undefined' && productCount != 'na' && productCount != '') {
                if (productCount <= '6') {
                    $('#hidden_page').val('1');    
                }
                if (productCount == '0') {
                    $('.all-products').html("No Product found");
                }
            }
        }
        // page = 0;
    })
    .fail(function(jqXHR, ajaxOptions, thrownError)
    {
          alert('server not responding...');
    });
}

$(document).ajaxComplete(function () {
    $("#pagination a").on("click",function(e){
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        $('li').removeClass('active');
        $(this).parent().addClass('active');
        filterForm();
    });
});

var imagebase64 = "";  
function encodeImageFileAsURL(element){
    var file = element.files[0];  
    var reader = new FileReader();  
    reader.onloadend = function() {  
        imagebase64 = reader.result;  
        $("#image").val(imagebase64);
        $("#product_image").attr("src",imagebase64);
    }  
    reader.readAsDataURL(file); 
}

$(document).ready(function () {
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
            console.log("above search " + data.html);
            page = 0;
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
              alert('server not responding...');
        });
    });

    $('#side-search').on('keyup',function(e){
        var time_out_id=0;
        var min_length=3;
        var value = $(this).val();
        if (typeof value != 'undefined' && value != 'na' && value != '') {
            if (value.length >= min_length) {
            if(time_out_id != 0) clearTimeout(time_out_id);

                time_out_id = setTimeout(function(){
                    e.preventDefault();
                    filterForm();
                }, 250);
            }
        } else {
            if (value == '') {
                e.preventDefault();
                filterForm();
            }
        }

    });

    $("select[name='price']").on("change",function(e){
        e.preventDefault();
        filterForm();
    });

    $("select[name='category']").on("change",function(e){
        e.preventDefault();
        filterForm();
    });

    /*
    $(".product-delete").on("click",function(e){
        e.preventDefault();
        var parent = $(this).parents('.products');
        var $id = $(this).attr('data-id');
        var settings = {
          "url": "http://127.0.0.1:8000/api/product/delete/"+$id,
          "method": "DELETE",
          "timeout": 0,
        };

        $.ajax(settings).done(function (response) {
            console.log(response);
            if(response.success == true){
                parent.remove();
                alert(response.message);
            } else {
                alert(response.message);
            }
        }).fail(function() {
            console.log('Product Couldn\'t be deleted!!')
        });
    });

    $(".add-product").on("click",function(e){
        e.preventDefault();
        var form = $('#insert_form')[0];
        var formdata = new FormData(form);
        var settings = {
            "enctype": 'multipart/form-data',
            "method": "POST",
            "url": "http://127.0.0.1:8000/api/product/create",
            "data": formdata,
            "timeout": 0,
            "processData": false,
            "contentType": false,
            "cache": false,
        };

        $.ajax(settings).done(function (response) {
          console.log(response);
          alert(response.message);
          window.location.href = 'http://127.0.0.1:8000/products';
        }).fail(function() {
            console.log('Product Couldn\'t be Created!!')
        });
    });

    $(".update-product").on("click",function(e){
        e.preventDefault();
        var $id = $("input[name='product_id']").val();
        var form = $('#update_form')[0];
        var formdata = new FormData(form);
        formdata.delete('prod_image');
        var settings = {
            "enctype": 'multipart/form-data',
            "method": "POST",
            "url": "http://127.0.0.1:8000/api/product/update/"+$id,
            "data": formdata,
            "timeout": 0,
            "processData": false,
            "contentType": false,
            "cache": false,
        };

        $.ajax(settings).done(function (response) {
          console.log(response);
          alert(response.message);
          window.location.href = '/products';
        }).fail(function() {
            console.log('Product Couldn\'t be Updated!!')
        });
    });
    */
    $(".back-product").on("click",function(e){
        window.location.href = '/products';
    });
});