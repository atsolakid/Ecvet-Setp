<?php
/*
Plugin Name: Facebook and Twitter login
Plugin URI: http://www.coralwebdesigns.com/
Version: 1.3
Author: Coral Web Design
Description: A plugin for creating user with their twitter and facebook credentials
*/

session_start();


add_action('init', 'twitter_create');

function twitter_create()
{
    wp_enqueue_script('jquery');
    wp_enqueue_style('fbcss', plugins_url('/assets/css/face.css', __FILE__));
    wp_enqueue_script('connect', plugins_url('/assets/js/new.js', __FILE__));

        // Check if all twitter API credentials are set
    if (get_option('twitter_apikey') !== false && get_option('twitter_secret') !== false && get_option('twitter_callback') !== false && get_option('show_login_cwd')!== false)
    {

        $key = get_option('twitter_apikey');
        $secret = get_option('twitter_secret');
        $callback = get_option('twitter_callback');

            // Define API details based on user input
        define('CONSUMER_KEY', $key);
        define('CONSUMER_SECRET', $secret);
        define('OAUTH_CALLBACK', $callback);

             // If user clicks signin with twitter option
        if ($_GET['twitter'] == 'true' || $_GET['oauth_token'])
        {

            if (!is_user_logged_in())
            {

                        // If access_token is not set, get oauth_token and oauth_secret via authenticating user
                if (!isset($_SESSION['access_token']) && !isset($_REQUEST['oauth_token']))
                {

                    require_once('includes/twitteroauth.php');


                    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

                    $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

                    $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
                    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

                    switch ($connection->http_code)
                    {
                        case 200:
                            $url = $connection->getAuthorizeURL($token);
                            wp_redirect($url);
                            exit;
                            break;

                        default:

                            echo 'Could not connect to Twitter. Refresh the page or try again later.';
                    }

                }
                       // If access_token is set, create user based on their profile details
                if (isset($_SESSION['access_token']))
                {


                    require_once('includes/twitteroauth.php');

                    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['access_token'], $_SESSION['access_secret']);

                    if (!$connection)
                        echo "No connection";

                    $content = $connection->get('account/verify_credentials');

                    $name = $content->name;
                    $userid = $content->screen_name;

                    if (!empty($name) && !empty($userid))
                    {
                        $username = $userid . '_tw';
                        $password = wp_generate_password();
                        $mail = $userid . '_tw' . '@nodomain.com';

                        $user = get_user_by('login', $username);

                            // If user exists dont do anything just login the user
                        if ($user)
                        {
                            $user_check_id = $user->ID;
                            wp_set_auth_cookie($user_check_id);

                            ?>

                            <script>
                                window.close();
                            </script>

                        <?php
                        }
                          // If the user not exists, create the user based on their profile details and suffix _tw to refer and then login the uer
                        else
                        {
                            wp_create_user($username, $password, $mail);
                            $user1 = get_user_by('login', $username);
                            $user_check_id1 = $user1->ID;
                            wp_set_auth_cookie($user_check_id1);

                            ?>

                            <script>
                                window.close();
                            </script>

                        <?php
                        }
                    }
                    else
                    {
                        echo '<h3>Twitter API -- Rate limit exceeded</h3>';
                    }
                }
                    // If oauth_token and oauth_secret has set but not access_token is set
                if (isset($_REQUEST['oauth_token']) && isset($_SESSION['oauth_token']))
                {

                    require_once('includes/twitteroauth.php');

                    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

                    $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

                    $_SESSION['access_token'] = $access_token['oauth_token'];
                    $_SESSION['access_secret'] = $access_token['oauth_token_secret'];

                    unset($_SESSION['oauth_token']);
                    unset($_SESSION['oauth_token_secret']);

                    if (200 == $connection->http_code)
                    {
                        $_SESSION['status'] = 'verified';
                        echo '<script>window.location.reload();</script>';
                    }
                    else
                    {
                        echo "Enter valid API Key and API Secret";
                    }
                }
            }
        }

        add_action('login_form','twitter_login_form');

        function twitter_login_form()
        {
            echo <<<EOT
            <a href="#" onclick="Popup = window.open('?twitter=true','Popup','status=no,width=600,height=300,left=430,top=3'); return false;">
EOT;
            echo '<img src="' . plugins_url('/images/tw.png', __FILE__) . '"></a>';
        }
    }

    add_action('wp_logout', 'logout_session_twitter');

    function logout_session_twitter()
    {
        session_destroy();
    }


}

add_action('init', 'facebook_create');


function facebook_create()
{
    if(!is_user_logged_in())
    {// Check if facebook api key is set
    if (get_option('facebook_api') !== false && get_option('show_login_cwd')!==false)
    {
        $fbapi = get_option('facebook_api');

            // Localize script to pass values from php to javascript
        wp_register_script('for_ajax', plugins_url('/assets/js/new.js', __FILE__));
        $translation_array = array('url_ajax' => get_bloginfo("url") . "/wp-admin/admin-ajax.php", 'user_api' => $fbapi,'homeurl'=>home_url());
        wp_localize_script('for_ajax', 'url', $translation_array);
        wp_enqueue_script('for_ajax', plugins_url('/assets/js/new.js', __FILE__));

            // Display login button in login form of wordpress
        add_action('login_form', function ()
        {

            echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            echo <<<EOT

<div style="display:inline-block">
<fb:login-button scope="public_profile,email" onlogin="checkLoginState();" class="facebook_button">
</fb:login-button>
</div>
<br><br>

<div id="status">
</div>
<div id="fb-root">
</div>

EOT;
        });

        add_action('wp_ajax_nopriv_fb_user_login_cwd', 'fb_user_login_cwd');

        function fb_user_login_cwd()
        {
                // If user email already exists dont do anything just login the user
            if (email_exists($_REQUEST['e']))
            {
                $user = get_user_by('email', $_REQUEST['e']);
                wp_set_auth_cookie($user->ID);
                $_SESSION['fblogin'] = true;
                echo '1';
            }
              // If the user not exists, create user and add _fb suffix to refer and then login the user
            else
            {
                $username = $_REQUEST['u'] . '_fb';
                $password = wp_generate_password();
                wp_create_user($username, $password, $_REQUEST['e']);
                $_SESSION['fblogin'] = true;
                echo '1';
            }
            exit;
        }

        add_action('wp_logout', function ()
        {
            session_destroy();
        });
    }
    }
}

add_action('init',function(){

    add_shortcode('fb_user_login','fb_user_create');
});

function fb_user_create()
{
    if(!is_user_logged_in())
    {
    wp_enqueue_style('for_facebook', plugins_url('/assets/css/face.css', __FILE__));

    if (get_option('facebook_api') !== false)
    {
        $fbapi = get_option('facebook_api');

        // Localize script to pass values from php to javascript
        wp_register_script('for_ajax', plugins_url('/assets/js/new.js', __FILE__));
        $translation_array = array('url_ajax' => get_bloginfo("url") . "/wp-admin/admin-ajax.php", 'user_api' => $fbapi);
        wp_localize_script('for_ajax', 'url', $translation_array);
        wp_enqueue_script('for_ajax', plugins_url('/assets/js/new.js', __FILE__));

        // Display login button
         echo <<<EOT

<div style="display:inline-block">
<fb:login-button scope="public_profile,email" onlogin="checkLoginState();" class="facebook_button">
</fb:login-button>
</div>
<br><br>

<div id="status">
</div>
<div id="fb-root">
</div>

EOT;

        add_action('wp_logout', function ()
        {
            session_destroy();
        });
    }
    }
}


add_action('init',function()
{

    add_shortcode('tw_user_login','twitter_create_user');
});

function twitter_create_user()
{
    if(!is_user_logged_in())
    {

    wp_enqueue_script('jquery');
    wp_enqueue_style('for_facebook', plugins_url('/assets/css/face.css', __FILE__));
    wp_enqueue_script('for_ajax', plugins_url('/assets/js/new.js', __FILE__));

    // Check if all twitter API credentials are set
    if (get_option('twitter_apikey') !== false && get_option('twitter_secret') !== false && get_option('twitter_callback') !== false)
    {

        $key = get_option('twitter_apikey');
        $secret = get_option('twitter_secret');
        $callback = get_option('twitter_callback');

        // Define API details based on user input
        define('CONSUMER_KEY', $key);
        define('CONSUMER_SECRET', $secret);
        define('OAUTH_CALLBACK', $callback);

        // If user clicks signin with twitter option
        if ($_GET['twitter'] == 'true' || $_GET['oauth_token'])
        {


                // If access_token is not set, get oauth_token and oauth_secret via authenticating user
                if (!isset($_SESSION['access_token']) && !isset($_REQUEST['oauth_token']))
                {

                    require_once('includes/twitteroauth.php');


                    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

                    $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

                    $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
                    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

                    switch ($connection->http_code)
                    {
                        case 200:
                            $url = $connection->getAuthorizeURL($token);
                            wp_redirect($url);
                            exit;
                            break;

                        default:

                            echo 'Could not connect to Twitter. Refresh the page or try again later.';
                    }

                }
                // If access_token is set, create user based on their profile details
                if (isset($_SESSION['access_token']))
                {


                    require_once('includes/twitteroauth.php');

                    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['access_token'], $_SESSION['access_secret']);

                    if (!$connection)
                        echo "No connection";

                    $content = $connection->get('account/verify_credentials');

                    $name = $content->name;
                    $userid = $content->screen_name;

                    if (!empty($name) && !empty($userid))
                    {
                        $username = $userid . '_tw';
                        $password = wp_generate_password();
                        $mail = $userid . '_tw' . '@nodomain.com';

                        $user = get_user_by('login', $username);

                        // If user exists dont do anything just login the user
                        if ($user)
                        {
                            $user_check_id = $user->ID;
                            wp_set_auth_cookie($user_check_id);

                            ?>

                            <script>
                                window.close();
                            </script>

                        <?php
                        }
                        // If the user not exists, create the user based on their profile details and suffix _tw to refer and then login the uer
                        else
                        {
                            wp_create_user($username, $password, $mail);
                            $user1 = get_user_by('login', $username);
                            $user_check_id1 = $user1->ID;
                            wp_set_auth_cookie($user_check_id1);

                            ?>

                            <script>
                                window.close();
                            </script>

                        <?php
                        }
                    }
                    else
                    {
                        echo '<h3>Twitter API -- Rate limit exceeded</h3>';
                    }
                }
                // If oauth_token and oauth_secret has set but not access_token is set
                if (isset($_REQUEST['oauth_token']) && isset($_SESSION['oauth_token']))
                {

                    require_once('includes/twitteroauth.php');

                    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

                    $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

                    $_SESSION['access_token'] = $access_token['oauth_token'];
                    $_SESSION['access_secret'] = $access_token['oauth_token_secret'];

                    unset($_SESSION['oauth_token']);
                    unset($_SESSION['oauth_token_secret']);

                    if (200 == $connection->http_code)
                    {
                        $_SESSION['status'] = 'verified';
                        echo '<script>window.location.reload();</script>';
                    }
                    else
                    {
                        echo "Enter valid API Key and API Secret";
                    }
                }

        }

            echo <<<EOT
            <a href="#" onclick="popup1 = window.open('?twitter=true','Popup','status=no,width=600,height=300,left=430,top=3'); return false;">
EOT;
            echo '<img src="' . plugins_url('/images/tw.png', __FILE__) . '"></a>';

    }

    add_action('wp_logout', 'logout_twitter');

    function logout_twitter()
    {
        session_destroy();
    }


}
}

add_action('admin_menu', 'fb_tw_init_settings');

function fb_tw_init_settings()
{
    add_menu_page('Login', 'Facebook and Twitter Login', 'manage_options', 'loginsettings', 'fb_tw_settings', 82);
}

function fb_tw_settings()
{
    if(isset($_POST['twapi']))
    {
    if ($_POST['twapi'])
    {
        $key = $_POST['twitterapiname'];
        $secret = $_POST['twitterapisecret'];
        $oauth = $_POST['twoauth'];

        if (get_option('twitter_apikey') !== false)
        {
            update_option('twitter_apikey', $key);
            update_option('twitter_secret', $secret);
            update_option('twitter_callback', $oauth);
        }
        else
        {
            add_option('twitter_apikey', $key);
            add_option('twitter_secret', $secret);
            add_option('twitter_callback', $oauth);
        }
    }
    }

    if(isset($_POST['fbapi']))
    {
    if ($_POST['fbapi'])
    {
        $api = $_POST['fbapiname'];

        if (get_option('facebook_api') != false)
        {
            update_option('facebook_api', $api);
        }
        else
        {
            add_option('facebook_api', $api);
        }

    }
    }

    if(isset($_POST['clear']))
    {
    if ($_POST['clear'])
    {
        if (get_option('twitter_apikey'))
        {
            delete_option('twitter_apikey');
        }
        if (get_option('twitter_secret'))
        {
            delete_option('twitter_secret');
        }
        if (get_option('twitter_callback'))
        {
            delete_option('twitter_callback');
        }
        if (get_option('facebook_api'))
        {
            delete_option('facebook_api');
        }

    }
    }

    if(isset($_POST['set_options']))
    {
    if($_POST['set_options'])
    {
        $value = $_POST['options'];
        if($value=="yes")
        {
            if(get_option('show_login_cwd')!==false)
            {
                update_option('show_login_cwd','yes');
            }
            else
            {
                add_option('show_login_cwd','yes');
            }
        }
        if($value=="no")
        {
            if(get_option('show_login_cwd')!==false)
            {
                delete_option('show_login_cwd');
            }
        }
    }
    }

    echo '<form action="" method="post">';
    echo '<h2>Enter your Facebook API key</h2><br>';
    echo '<label for="name" id="for_align">API Key </label><input type="text" name="fbapiname" id="fbkey" value="' . get_option('facebook_api') . '" size="55"><br><br><br>';
    echo '<input type="submit" name="fbapi" value="Set" id="fbapikey" class="button-primary">';
    echo '</form>';

    echo '<form action="" method="post">';
    echo '<br><h2>Enter your Twitter API key and API secret</h2><br><br>';
    echo '<label for="name" id="for_align">API Key </label><input type="text" name="twitterapiname" value="' . get_option('twitter_apikey') . '" size="55"><br><br>';
    echo '<label for="name" id="for_align">API Secret</label><input type="text" name="twitterapisecret" value="' . get_option('twitter_secret') . '" size="55"><br><br>';
    echo '<label for="name" id="for_align">OAuth Callback </label><input type="text" name="twoauth" value="' . get_option('twitter_callback') . '" size="55"><br><br><br><br>';
    echo '<input type="submit" name="twapi" value="Set" class="button-primary"><br><br><br><br>';
    echo '</form>';


    echo '<form action="" method="post">';
    echo '<input type="submit" name="clear" value="Clear API Details" class="button-primary">';
    echo '</form>';

?>

    <div style="display:inline-block">
    <form action="" method="post">
    <p>Do you want to display Social Login buttons to be shown in login page?</p><br>
    <input type='radio' name='options' value='yes'<?php if(get_option('show_login_cwd')!==false){ ?> checked <?php  } ?>>Yes<br>
    <input type='radio' name='options' value='no' <?php if(get_option('show_login_cwd')==false){ ?> checked <?php  } ?>>No<br><br>
    <input type="submit" name="set_options" value="Ok" class="button-primary">
    </form>
    </div>

<?php

}




class CWDSocialLoginTW extends WP_Widget {
    function CWDSocialLoginTW() {
        $widget_ops = array(
            'classname' => 'CWDSocialLoginTW',
            'description' => 'This widget allows you to add users via their twitter accounts'
        );

        $this->WP_Widget(
            'CWDSocialLoginTW',
            'Twitter user login',
            $widget_ops
        );
    }

          function widget($args, $instance) { // widget sidebar output
              extract($args, EXTR_SKIP);
              echo $before_widget;        // pre-widget code from theme

              if(!is_user_logged_in())
              {
              wp_enqueue_script('jquery');
              wp_enqueue_style('fb', plugins_url('/assets/css/face.css', __FILE__));
              wp_enqueue_script('fbconnect', plugins_url('/assets/js/new.js', __FILE__));

              // Check if all twitter API credentials are set
              if (get_option('twitter_apikey') !== false && get_option('twitter_secret') !== false && get_option('twitter_callback') !== false)
              {

                  $key = get_option('twitter_apikey');
                  $secret = get_option('twitter_secret');
                  $callback = get_option('twitter_callback');

                  // Define API details based on user input
                  define('CONSUMER_KEY', $key);
                  define('CONSUMER_SECRET', $secret);
                  define('OAUTH_CALLBACK', $callback);

                  // If user clicks signin with twitter option
                  if ($_GET['twitter'] == 'true' || $_GET['oauth_token'])
                  {


                      // If access_token is not set, get oauth_token and oauth_secret via authenticating user
                      if (!isset($_SESSION['access_token']) && !isset($_REQUEST['oauth_token']))
                      {

                          require_once('includes/twitteroauth.php');


                          $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

                          $request_token = $connection->getRequestToken(OAUTH_CALLBACK);

                          $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
                          $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

                          switch ($connection->http_code)
                          {
                              case 200:
                                  $url = $connection->getAuthorizeURL($token);
                                  wp_redirect($url);
                                  exit;
                                  break;

                              default:

                                  echo 'Could not connect to Twitter. Refresh the page or try again later.';
                          }

                      }
                      // If access_token is set, create user based on their profile details
                      if (isset($_SESSION['access_token']))
                      {


                          require_once('includes/twitteroauth.php');

                          $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['access_token'], $_SESSION['access_secret']);

                          if (!$connection)
                              echo "No connection";

                          $content = $connection->get('account/verify_credentials');

                          $name = $content->name;
                          $userid = $content->screen_name;

                          if (!empty($name) && !empty($userid))
                          {
                              $username = $userid . '_tw';
                              $password = wp_generate_password();
                              $mail = $userid . '_tw' . '@nodomain.com';

                              $user = get_user_by('login', $username);

                              // If user exists dont do anything just login the user
                              if ($user)
                              {
                                  $user_check_id = $user->ID;
                                  wp_set_auth_cookie($user_check_id);

                                  ?>

                                  <script>
                                      window.close();
                                  </script>

                              <?php
                              }
                              // If the user not exists, create the user based on their profile details and suffix _tw to refer and then login the uer
                              else
                              {
                                  wp_create_user($username, $password, $mail);
                                  $user1 = get_user_by('login', $username);
                                  $user_check_id1 = $user1->ID;
                                  wp_set_auth_cookie($user_check_id1);

                                  ?>

                                  <script>
                                      window.close();
                                  </script>

                              <?php
                              }
                          }
                          else
                          {
                              echo '<h3>Twitter API -- Rate limit exceeded</h3>';
                          }
                      }
                      // If oauth_token and oauth_secret has set but not access_token is set
                      if (isset($_REQUEST['oauth_token']) && isset($_SESSION['oauth_token']))
                      {

                          require_once('includes/twitteroauth.php');

                          $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

                          $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);

                          $_SESSION['access_token'] = $access_token['oauth_token'];
                          $_SESSION['access_secret'] = $access_token['oauth_token_secret'];

                          unset($_SESSION['oauth_token']);
                          unset($_SESSION['oauth_token_secret']);

                          if (200 == $connection->http_code)
                          {
                              $_SESSION['status'] = 'verified';
                              echo '<script>window.location.reload();</script>';
                          }
                          else
                          {
                              echo "Enter valid API Key and API Secret";
                          }
                      }

                  }

                echo <<<EOT


            <a href="#" onclick="popup1 = window.open('?twitter=true','Popup','status=no,width=600,height=300,left=430,top=3'); return false;">




EOT;
                  echo '<img src="' . plugins_url('/images/tw.png', __FILE__) . '"></a>';

              }
              }
              echo $after_widget; // post-widget code from theme
          }
}

add_action(
    'widgets_init',
    create_function('','return register_widget("CWDSocialLoginTW");')
);




class CWDSocialLoginFB extends WP_Widget {
    function CWDSocialLoginFB() {
        $widget_ops = array(
            'classname' => 'CWDSocialLoginFB',
            'description' => 'This widget allows you to add users via their facebook accounts'
        );

        $this->WP_Widget(
            'CWDSocialLoginFB',
            'Facebook user login',
            $widget_ops
        );
    }

    function widget($args, $instance) { // widget sidebar output
        extract($args, EXTR_SKIP);
        echo $before_widget; // pre-widget code from theme
        if(!is_user_logged_in())
        {

        if (get_option('facebook_api') !== false)
        {
            $fbapi = get_option('facebook_api');

            // Localize script to pass values from php to javascript
            wp_register_script('for_ajax', plugins_url('/assets/js/new.js', __FILE__));
            $translation_array = array('url_ajax' => get_bloginfo("url") . "/wp-admin/admin-ajax.php", 'user_api' => $fbapi);
            wp_localize_script('for_ajax', 'url', $translation_array);
            wp_enqueue_script('for_ajax', plugins_url('/assets/js/new.js', __FILE__));

            // Display login button
            echo <<<EOT

<div style="display:inline-block">
<fb:login-button scope="public_profile,email" onlogin="checkLoginState();" class="facebook_button">
</fb:login-button>
</div>
<br><br>

<div id="status">
</div>
<div id="fb-root">
</div>

EOT;

            add_action('wp_logout', function ()
            {
                session_destroy();
            });
        }

        }
        echo $after_widget; // post-widget code from theme
    }
}

add_action(
    'widgets_init',
    create_function('','return register_widget("CWDSocialLoginfb");')
);

?>

