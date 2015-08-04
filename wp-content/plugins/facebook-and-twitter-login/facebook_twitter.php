<?php
/**
 * Created by Coral Web Designs.
 * User: Coral
 */

session_start();

class twitter {

    function __construct()
    {
        $key = get_option('twitter_apikey');
        $secret = get_option('twitter_secret');
        $callback = get_option('twitter_callback');

        // Define API details based on user input
        define('CONSUMER_KEY', $key);
        define('CONSUMER_SECRET', $secret);
        define('OAUTH_CALLBACK', $callback);
    }

    public function AuthenticateUser()
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

                return 'Could not connect to Twitter. Refresh the page or try again later.';
        }

    }

    public function CreateUser()
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

    }

    public function SetAccessToken()
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