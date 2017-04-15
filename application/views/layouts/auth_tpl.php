<?php
$title = Setting::first();
$title = $title->site_title;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo $template['title'].' | '.$title; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <?php echo $template['partials']['styles'] ?>
</head>
    <body class="hold-transition login-page">
		<div class="login-box">
        <?php echo $template['body'] ?>
		</div>
        <?php echo $template['partials']['footer'] ?>
    </body>
</html>