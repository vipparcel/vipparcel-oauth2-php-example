<?php
session_start();
require_once '_api_request.php';
$c = require_once '_config.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>VIPparcel OAuth Example</title>
    <link type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container">
    <div class="header">
        <nav>
            <div class="pull-right">
                Welcome, <b>Sam Jones</b>. (Session: <?php echo session_id(); ?>)
            </div>
        </nav>
        <h3 class="text-muted">Your Project</h3>
    </div>

    <div class="jumbotron">
        <?php if ( ! API_Request::is_auth()) { ?>
            <p>Sam, would you like to use the vipparcel's services now? </p>
            <!-- Sign In with VIPparcel -->
            <!-- https://vipparcel.com/oauth/authorize?redirect_uri=http://website.com/path/get/token/&client_id=__application_id__&response_type=code&scope=_access_list_&state=__optional__ -->
            <a href="<?php echo $c['provider'] ?>/oauth/authorize?<?php echo http_build_query(array('redirect_uri' => $c['script_url'].'/get_token.php', 'client_id' => $c['client_id'], 'response_type' => 'code', 'scope' => 'read:account_personal,admin:shipping_label', 'state' => session_id())); ?>" class="btn btn-lg btn-primary">Yes, i do</a>
        <?php } else { ?>

            <h3>VIPparcel logged in user #<?php echo API_Request::user_id(); ?> <a href="<?php echo $c['script_url'].'/logout.php'?>" class="btn btn-default">Logout</a></h3>

            <hr>
            <h4>API Response</h4>
            <h5>Personal Info</h5>
            <pre><?php print_r(API_Request::personal_info()); ?></pre>
            <h5>Label</h5>
            <pre><?php print_r(API_Request::label()); ?></pre>
            <h5>Finance (check no access)</h5>
            <pre><?php print_r(API_Request::balance()); ?></pre>
        <?php } ?>
    </div>

</div>
</body>
</html>