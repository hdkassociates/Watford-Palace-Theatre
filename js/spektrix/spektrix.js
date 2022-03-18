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

var seeMore = document.querySelector('#see_more');
if(seeMore){
    var bookingBlock = document.querySelector('#booking_block');
    var bookingItem = document.querySelectorAll('.spektrix_booking--event');
    var itemHeight = bookingItem[0].offsetHeight + parseInt(getComputedStyle(bookingItem[0]).getPropertyValue("margin-bottom"));
    bookingBlock.style.maxHeight=`${itemHeight * 5}px`;
    seeMore.addEventListener('click',(e)=>{
        e.preventDefault();
        if(!seeMore.classList.contains('open')){
            bookingBlock.style.maxHeight=`${itemHeight * bookingItem.length}px`;
            seeMore.classList.add('open');
            console.log(seeMore.firstChild);
            seeMore.innerHTML = 'See Less';
        }
        else{
            seeMore.classList.remove('open');
            bookingBlock.style.maxHeight=`${itemHeight * 5}px`;
            seeMore.innerHTML = 'See More Dates';
        }

    });
}