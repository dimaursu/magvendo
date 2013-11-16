<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta charset="UTF-8" />
    <title>MgSales</title>
    <link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
    <link rel='stylesheet' href='css/print.css' type='text/css' media='print' />
    <link rel="stylesheet" href="js/jquery-ui.css" />
    <script src="js/jquery-1.9.1.js"></script>
    <script src="js/jquery-ui.js"></script>

    <link type="text/css" href="js/jnotify/jquery.jnotify.css" rel="stylesheet" />
    <script type="text/javascript" src="js/jnotify/jquery.jnotify.js"></script>


<script>
$(function() {
$( ".date" ).datepicker({dateFormat:"dd-mm-yy", showButtonPanel: true});
});
</script>

</head>

<body>

<div id="header">
    <ul class="top-menu">
        <?php $user_data = get_user($_SESSION['user_id']); ?>
        <li><a class="user" href="#"><b><?php if (!empty($user_data['name'])) : ?><?php echo $user_data['name']; ?><?php else : ?><?php echo $user_data['username']; ?><?php endif; ?></b></a></li>
        <li><a class="logout" href="index.php?a=logout"><?php _e('Log out'); ?></a></li> 
    </ul>
    <?php if (isset($_SESSION['magazine_id'])) : ?>
        <?php $magazine = get_magazine($_SESSION['magazine_id']); ?>
    <?php endif; ?>
    <h1><a href="index.php">Mag Sales</a><?php if(!empty($magazine)) : ?> <span> | <?php echo $magazine['name']; ?></span><?php endif; ?></h1>
</div> <!-- #header -->

<?php require_once 'sider.php'; ?>

<div id="content">
