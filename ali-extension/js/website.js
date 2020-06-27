//console.log("web");
var token = localStorage.getItem('token_jwt');
var link = window.location.href;
var check = link.indexOf('login');
var hasToken = false;
var firstTime = true;
setInterval(function () {
    token = localStorage.getItem('token_jwt');
    if(token !== null && !hasToken) {
        chrome.storage.sync.set({'token_jwt_syncvi': token}, function() {
            console.log('Value is set to ' + token);
        });
        hasToken = true;
    } else if(token === null && (hasToken || firstTime)) {
        chrome.storage.sync.set({'token_jwt_syncvi': ''}, function() {
            console.log('Value is set to ' + token);
        });
        hasToken = false;
        firstTime = false;
    }

}, 2000);

/*
if(check === -1) {
    if(localStorage.getItem('login_before_syncvi') === '1') {
        token = localStorage.getItem('token_jwt');
        if(token !== null) {
            chrome.storage.sync.set({'token_jwt_syncvi': token}, function() {

            });
        } else {
            chrome.storage.sync.set({'token_jwt_syncvi': ''}, function() {
                //console.log('Value is set to ' + token);
            });
        }
        localStorage.setItem('login_before_syncvi', '0');
    }
} else {
    localStorage.setItem('login_before_syncvi', '1');
    token = localStorage.getItem('token_jwt');
    if(token === null) {
        chrome.storage.sync.set({'token_jwt_syncvi': ''}, function() {
            //console.log('Value is set to ' + token);
        });
    }
}*/
