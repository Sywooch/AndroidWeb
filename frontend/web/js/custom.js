//from address_select page
$(function(){
    $('#modelButton').click(function(){
        $('.modal').modal('show')
            .find('#modelContent')
            .load($(this).attr('value'));
    });
});

$(function(){
    $('.modalButtonEdit').click(function(){
        $('.modal').modal('show')
            .find('#modelContent')
            .load($(this).attr('value'));
    });
});

function func(id){
	//alert('but_'+id);
	$('.chk').hide();
	 $('#but_'+id).show();
     $('#addr_'+id).prop("checked", true);

}

//from main page ---search box --
$('#search_box').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    e.preventDefault();
  }
});

$('#srch_btn').click(function(e){
    var text = $('#search_box').val();
    if(text == ''){
        e.preventDefault();
    }
});

$("#hover_search").click(function() {  //use a class, since your ID gets mangled
    //$(this).addClass("active");      //add the class to the clicked element
    $("#search_bar").css({ display: "block" });
  });


$("#close_search").click(function() {  //use a class, since your ID gets mangled
    $("#hover_search").removeClass('active');
  });

window.onload = function () {
    if (! sessionStorage.justOnce) {
        sessionStorage.setItem("justOnce", "true");
        $("#offer_notification").show();
    }
}





