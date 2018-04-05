
$(document).ready(function(){
         $('.modelButton').click(function(){
            $('.modal').modal('show')
                .find('#modelContent1')
                .load($(this).attr('value'));
        });
        $('.modal').on('hidden.bs.modal', function (e) {
            if($('.modal').hasClass('in')) {
            $('body').addClass('modal-open');
            $('.modal-backdrop').remove();
            }else{
                $('.modal-backdrop').remove();
            }    
        });
});
 