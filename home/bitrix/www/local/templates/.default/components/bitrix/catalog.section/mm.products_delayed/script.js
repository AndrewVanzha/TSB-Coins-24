


// ---------------------------  //
// ИЗМЕНЕНИЕ КОЛ-ВА ТОВАРА     //
// -------------------------- //
if(typeof validCountVal != 'function'){
    function validCountVal(val){
        if ( (val <= 0) || ( isNaN(val) ) ){
            return 1;
        } else if( (val > 999) ){
            return 999;
        } else {
            return val;
        };
    }
}

if(typeof changeCountProduct != 'function'){
    function changeCountProduct(el, arJSParams){
        var count_val_old = $(el).val();
        count_val = validCountVal(count_val_old);
        $("#cart_"+arJSParams['ID']).attr("onclick","addToCartProduct("+arJSParams['ID']+","+count_val+");");
        $("#cartMobile_"+arJSParams['ID']).attr("onclick","addToCartProduct("+arJSParams['ID']+","+count_val+");");

        if (count_val_old != count_val) {
            $(el).val(count_val);
        }

        return false;
    }
}

if(typeof countMinusProduct != 'function'){
    function countMinusProduct(el, arJSParams){
        var currentInput = $(el).next();
        var currentValue = parseInt( $(el).next().val() );

        $(el).next().val( validCountVal(currentValue) );
        if ( $(el).next().val() == 1 ) return false;
        $(el).next().val( +$(el).next().val() - 1 );

        changeCountProduct(currentInput,arJSParams);

        return false;
    }
}

if(typeof countPlusProduct != 'function'){
    function countPlusProduct(el, arJSParams){
        var currentInput = $(el).prev();
        var currentValue = parseInt( $(el).prev().val() );

        $(el).prev().val( validCountVal(currentValue) );
        if ( $(el).prev().val() == 999 ) return false;
        $(el).prev().val( +$(el).prev().val() + 1 );

        changeCountProduct(currentInput,arJSParams);

        return false;
    }
}




document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('.render-options .render-options__button').forEach(button => {
        button.addEventListener('click', changeRender);
    })


    const showMoreButton = document.querySelector('#show_more');
    showMoreButton?.addEventListener('click', showMore);

    const inlineGalleries = document.querySelectorAll('.catalog-coins__coin-item .images__line-galery');

    inlineGalleries.forEach(inlineGallery => initInlineGallery(inlineGallery));

});



