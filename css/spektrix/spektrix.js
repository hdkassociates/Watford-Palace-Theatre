var close = document.querySelector('#modal_close');
if(close){
    close.addEventListener('click',toggleModal);
}

var merchComponent = document.querySelector('spektrix-merchandise');
if(merchComponent){
    merchComponent.addEventListener('success', function (e) {
        if (e.type="success"){
            setTimeout(function(){toggleModal()},1000);
        }
    })
}

function toggleModal(){
    var container=document.querySelector('#spektrix_container');
    container.classList.toggle('open');
}

var merchModal = document.querySelector('.spektrix_modal--merch');
if (merchModal){
    window.addEventListener('load',()=>{
        setTimeout(function(){toggleModal()},1000);
    });
}