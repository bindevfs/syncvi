chrome.storage.sync.get(['token_jwt_syncvi'], function(result) {
    console.log('Value currently is ' + result.token_jwt_syncvi);
    if(result.token_jwt_syncvi === '' || result.token_jwt_syncvi === null) {
        $('#logined').hide();
        $('#notlogin').show();
    } else {
        $('#logined').show();
        $('#notlogin').hide();
    }
});