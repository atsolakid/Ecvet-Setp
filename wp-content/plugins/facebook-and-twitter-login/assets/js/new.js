
function statusChangeCallback(response) {

    if (response.status === 'connected') {
        // Logged into your app and Facebook.
        runAPI();

    }
    else if (response.status === 'not_authorized')
    {
        // The person is logged into Facebook, but not your app.
        // Do something here
    }
    else
    {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        //Do something here
    }
}


// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.


function checkLoginState()
{
    FB.getLoginStatus(function (response)
    {
        statusChangeCallback(response);
    });
}

window.fbAsyncInit = function ()
{
    FB.init({
        appId: url.user_api,//u_apikey.user_api,
        cookie: true,  // enable cookies to allow the server to access
        // the session
        xfbml: true,  // parse social plugins on this page
        version: 'v2.0' // use version 2.0
    });

    // Now that we've initialized the JavaScript SDK, we call
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function (response)
    {
        statusChangeCallback(response);
    });

};

(function (d, s, id)
{
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));



function runAPI() {

    FB.api('/me', function (response)
    {

        jQuery.ajax({
            type: 'POST',
            url: url.url_ajax + '?action=fb_user_login_cwd',
            data: {u: response.name, e: response.email},

            success: function (data) {
                if(data == 1)
                {
                    window.location.href = url.homeurl;
                }

            }
        });
    });
}

var timer = setInterval(function ()
{
    window.close();
    if(typeof Popup!= 'undefined')
    {
        if (Popup.closed)
        {
            clearInterval(timer);
            window.location.href = url.homeurl;
        }
    }
}, 1000);

var timer1 = setInterval(function ()
{
    window.close();
    if(typeof popup1!= 'undefined')
    {
        if (popup1.closed)
        {
            clearInterval(timer);
            window.location.href = url.homeurl;
        }
    }
}, 1000);



