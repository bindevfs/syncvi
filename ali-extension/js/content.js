const factor = 3445;
//const apiserve = 'http://localhost:8000';
const apiserve = 'https://syncvi.tk';


function priceProduct(data, factor) {
    var price = data.split('-');
    if (price.length === 1) {
        return parseInt(price[0]).toFixed(2) * factor;
    } else {
        return parseInt(price[0]).toFixed(2) * factor + '-' + parseInt(price[1]).toFixed(2) * factor;
    }
}

/**
 * remove dialog
 */
setTimeout(function() {
    $('.sufei-dialog').css('display', 'none');
}, 500);

/**
 * @param num
 * @returns {string}
 */
function formatNumber(num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1")
}

/**
 *  add view price
 */
setTimeout(function() {
    let price = priceProduct($('.tm-price').text(), factor); // price vnd
    $('.tm-fcs-panel').append("<dl class='tm-price-panel tm-price-cur' id='J_StrPriceModBox'><dt class='tb-metatit' data-spm-anchor-id='a220o.1000855.0.i0.562d5e17CTSVhS'>Giá: </dt><dd><em class='tm-yen'>VND</em> <span class='tm-price-vi' data-spm-anchor-id='a220o.1000855.0.i1.562d5e17CTSVhS'>" + (price) + "</span><div class='staticPromoTip'></div></dd></dl>")
}, 10000);

/**
 * add view pannel cart
 */
$('body').append("<div class='et-menu'> <div class='et-container'> <div class='et-logo'> <a href='#'><img src='https://res.cloudinary.com/dkxyqbs8v/image/upload/v1568703840/logo_fbrcs8.png' width='100px' style='padding: 0px'></a> </div> <div class='et-form-order'> <input type='text' name='note' id='et-note' placeholder='Ghi chú cho sản phẩm'> <button class='et-btn-order' id='btn-add-to-cart'> <strong>Thêm vào giỏ hàng</strong></button> <a href='http://ali33.ga/list-cart' target='_blank' class='et-cart-url'> <img src='https://bucket-blog.s3-us-west-2.amazonaws.com/mycart-md.png' width='20px'> Xem giỏ hàng</a> | <span>Tỉ giá: <strong id='et-exchange-rate'>3445</strong> VNĐ</span> </div> </div> </div>");

/**
 * add view check login
 */
$('body').append("<div id='eto1' class='et-overlay1'> <div id='pou1' class='et-popup animated'> <div class='et-popup-title'> <span>BẠN CHƯA ĐĂNG NHẬP VÀO HỆ THỐNG</span> <button id='et-close' class='et-popup-close'>&times;</button> </div> <div class='et-popup-content'> <span>Bạn cần đăng nhập vào hệ thống để mua hàng</span> <span><a href='http://ali33.ga/login' target='_blank' class='et-login'>Đăng nhập</a></span> </div> </div> </div>")

/**
 * add view check login
 */
$('body').append("<div id='eto2' class='et-overlay2'> <div id='pou2' class='et-popup animated'> <div class='et-popup-title'> <span>THÀNH CÔNG </span> <button id='et-close2' class='et-popup-close'>&times;</button> </div> <div class='et-popup-content'> <span>Sản phẩm được thêm vào giỏ hàng thành công. </span></div> </div> </div>")

/**
 * add view check login
 */
$('body').append("<div id='eto3' class='et-overlay3'> <div id='pou3' class='et-popup animated'> <div class='et-popup-title'> <span>THẤT BẠI </span> <button id='et-close3' class='et-popup-close'>&times;</button> </div> <div class='et-popup-content'> <span>Sản phẩm thêm vào giỏ hàng thất bại.</span>  </div> </div> </div>")

/**
 * show check login
 */
$('#btn-add-to-cart').on({
    click: function() {
        var token = '';
        //token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9mMDkzNzRhZS5uZ3Jvay5pb1wvYXBpXC91c2VyXC9sb2dpbiIsImlhdCI6MTU2NjM2NDYwNywiZXhwIjoxNTY2MzY2NDA3LCJuYmYiOjE1NjYzNjQ2MDcsImp0aSI6IlRkNEk3czZtSFhDNTN0NUgiLCJzdWIiOjEsInBydiI6ImY5MzA3ZWI1ZjI5YzcyYTkwZGJhYWVmMGUyNmYwMjYyZWRlODZmNTUifQ.zkhehO7mOffJnaA7T3Z9C4aMgpWNww8P5GoVJ10tVYI';
        chrome.storage.sync.get(['token_jwt_syncvi'], function(result) {
            console.log('Value currently is ' + result.token_jwt_syncvi);
            token = result.token_jwt_syncvi;
            var arr = [];
            var link = window.location.href;
            var i = 0;
            var pkey = '';
            var check = false;
            for(i = 3; i < link.length; i++)
            {
                if(check === false) {
                    if(link[i] === '=') {
                        if(link[i-1] === 'd' && link[i-2] === 'i') {
                            if(link[i-3] === '&' || link[i-3] === '?') check = true;
                        }
                    }
                } else {
                    if(link[i] === '&') break;
                    if(link[i] > '9' || link[i] < '0') break;
                    pkey += link[i];
                }
            }
            if(pkey === '') {
                //error
                $('.et-popup').removeClass('flipOutX');
                $('.et-popup').addClass('flipInX');

                $('.et-popup').css('display', 'block');
                $('.et-overlay3').addClass('et-overlay');
                return;
            }
            arr.push({
                product_key: pkey,
                resource: window.location.hostname,
                product_name: $('.tb-detail-hd h1').text(),
                quality: parseInt($('.mui-amount-input').val()),
                price: $('.tm-price-vi').text(),
                description: $('.tb-selected span').text(),
                thumbnails: $('#J_ImgBooth').attr('src'),
                product_url : window.location.href,
            });
            $.ajax({
                url: apiserve + '/api/user/addtocart',
                method: 'get',
                data: {'product_key':pkey,
                    'resource': window.location.hostname,
                    'product_name': $('.tb-detail-hd h1').text(),
                    'quality': parseInt($('.mui-amount-input').val()),
                    'price': $('.tm-price-vi').text(),
                    'description': $('.tb-selected span').text(),
                    'thumbnails': $('#J_ImgBooth').attr('src'),
                    'product_url' : window.location.href,
                    'token': token,},
                complete: function(xhr, textStatus) {
                    console.log(xhr.status);
                    console.log(arr);
                    var check = xhr.status;
                    if(check === 200) {
                        $('.et-popup').removeClass('flipOutX');
                        $('.et-popup').addClass('flipInX');

                        $('.et-popup').css('display', 'block');
                        $('.et-overlay2').addClass('et-overlay');
                    } else if(check === 401) {
                        $('.et-popup').removeClass('flipOutX');
                        $('.et-popup').addClass('flipInX');

                        $('.et-popup').css('display', 'block');
                        $('.et-overlay1').addClass('et-overlay');
                    } else {
                        $('.et-popup').removeClass('flipOutX');
                        $('.et-popup').addClass('flipInX');

                        $('.et-popup').css('display', 'block');
                        $('.et-overlay3').addClass('et-overlay');
                    }

                },
                error: function(request, error){
                }
            })
        });

    }
});

/**
 * hide dialog check login
 */
$('#et-close').on({
    click: function() {
        $('.et-popup').removeClass('flipInX');
        $('.et-popup').addClass('flipOutX');

        setTimeout(function() {
            $('.et-overlay1').removeClass('et-overlay');
            $('.et-popup').css('display', 'none');
        }, 1000);
    }
});

/**
 * hide dialog success
 */
$('#et-close2').on({
    click: function() {
        $('.et-popup').removeClass('flipInX');
        $('.et-popup').addClass('flipOutX');

        setTimeout(function() {
            $('.et-overlay2').removeClass('et-overlay');
            $('.et-popup').css('display', 'none');
        }, 1000);
    }
});
/**
 * hide dialog fail
 */
$('#et-close3').on({
    click: function() {
        $('.et-popup').removeClass('flipInX');
        $('.et-popup').addClass('flipOutX');

        setTimeout(function() {
            $('.et-overlay3').removeClass('et-overlay');
            $('.et-popup').css('display', 'none');
        }, 1000);
    }
});
/**
 * change price
 */
$('.tb-prop a').on({
    click: function() {
        setTimeout(function() {
            let price = priceProduct($('.tm-price').text(), factor);
            $('.tm-price-vi').text(formatNumber(price));
        }, 100);
    }
});