var page = 2;
var isLoad = [];
$(window).scroll(function() {
    if($(window).scrollTop() + $(window).height()+5 >= $(document).height()) {
        loadMore();
    }
});
$('.ajax-load').on('click', '#load-more', function (e) {
    e.preventDefault();
    loadMore();

});
function loadMore() {

    if (!isLoad[page] && page <= max_page)
    {
        $('.ajax-load').html(loader_html);
        loadMoreData(page);
        if(isLoad[page]) page++;
    }
    else{
        $('.ajax-load').show();
        $('.ajax-load').html("No more records found");
    }
}
function loadMoreData(page){
    var url = new URL(window.location.href);
    var q = url.searchParams.get("q");
    $.ajax(
        {
            url: '?'+ (q ? 'q=' + q + '&' : '' ) + 'page=' + page,
            type: "get",
            async: false,
            beforeSend: function()
            {
                $('.ajax-load').show();
                $('.ajax-load').html(loader_html);
            }
        })
        .done(function(data)
        {
            if(data.html == ""){
                $('.ajax-load').html("No more records found");
                return false;
            }
            if(!isLoad[page]) $("#post-data").append(data.html);
            $('.ajax-load').html('<button class="btn btn-default" id="load-more">Load more</button>');
            isLoad[page] = true;
        })
        .fail(function(jqXHR, ajaxOptions, thrownError)
        {
            alert('Server not responding...');
        });
    return false;
}