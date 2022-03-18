jQuery(function($){
    var buttons = document.querySelectorAll('.spektrixbooknow');
    buttons.forEach(button=>{
        button.addEventListener('click',(e)=>{
            e.preventDefault();
            $('#spektrix_container').addClass('open');
            $('#spektrix_modal').addClass('processing');
            $.post('/wp-admin/admin-ajax.php',
                {
                    action:'book_now_modal',
                    id:e.currentTarget.id,
                    pid:e.currentTarget.dataset.post,
                },function(data){
                        $('#spektrix_modal').removeClass('processing');
                        $('#spektrix_modal').html(data);
                    } 
            );
            return false;
        })
    })
    var close = document.querySelector('#modal_close');
    close.addEventListener('click',()=>{
        $('#spektrix_modal').removeClass('processing');
        $('#spektrix_container').removeClass('open');
        $('#spektrix_modal').html('');
    })
});
