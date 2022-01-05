var page = 1;
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
        page++;
        loadMoreData(page);
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
        if(data.html == " "){
            $('.ajax-load').html("No more records found");
            return;
        }
        $('.ajax-load').hide();
        $(".products").last().after(data.html);
    })
    .fail(function(jqXHR, ajaxOptions, thrownError)
    {
          alert('server not responding...');
    });
}

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
        if(data.html == " "){
            $('.ajax-load').html("No more records found");
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
