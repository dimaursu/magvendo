<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>
    <meta charset="UTF-8" />
    <title><?php echo MAGV_APP_NAME; ?></title>
    <link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
    <link rel='stylesheet' href='css/print.css' type='text/css' media='print' />
    <link rel="stylesheet" href="js/jquery-ui.css" />
    <script src="js/jquery-1.9.1.js"></script>
    <script src="js/jquery-ui.js"></script>

    <link type="text/css" href="js/jnotify/jquery.jnotify.css" rel="stylesheet" />
    <script type="text/javascript" src="js/jnotify/jquery.jnotify.js"></script>

     <?php if (isset($_GET['p']) && $_GET['p'] == "statistics") : ?>
    <script type="text/javascript" src="js/jqplot/jquery.jqplot.min.js"></script> 
    <link type="text/css" href="js/jqplot/jquery.jqplot.min.css" rel="stylesheet"/>
    <script type="text/javascript" src="js/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
    <script type="text/javascript" src="js/jqplot/plugins/jqplot.canvasAxisLabelRenderer.min.js"></script>
    <script type="text/javascript" src="js/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
    <script type="text/javascript" src="js/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
     <?php endif; ?>

<script>
     <?php if(LSLANG == "ru") : ?>
     jQuery(function($){
	     $.datepicker.regional['ru'] = {
	     closeText: 'Закрыть',
	     prevText: '&#x3c;Пред',
	     nextText: 'След&#x3e;',
	     currentText: 'Сегодня',
	     monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
			  'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
	     monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
			       'Июл','Авг','Сен','Окт','Ноя','Дек'],
	     dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
	     dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
	     dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
	     weekHeader: 'Не',
	     dateFormat: 'dd.mm.yy',
	     firstDay: 1,
	     isRTL: false,
	     showMonthAfterYear: false,
	     yearSuffix: ''};
	     $.datepicker.setDefaults($.datepicker.regional['ru']);
	 });
    <?php endif; ?>

$(function() {
$( ".date" ).datepicker({dateFormat:"dd-mm-yy", showButtonPanel: true});
});

var old_goToToday = $.datepicker._gotoToday
    $.datepicker._gotoToday = function(id) {
    old_goToToday.call(this,id)
    this._selectDate(id)
}

</script>

</head>

<body>

<div id="header">
    <ul class="top-menu">
        <?php $user_data = get_user($_SESSION['magvendo']['user_id']); ?>
        <li><a class="user" href="#"><b><?php if (!empty($user_data['name'])) : ?><?php echo $user_data['name']; ?><?php else : ?><?php echo $user_data['username']; ?><?php endif; ?></b></a></li>
        <li><a class="logout" href="index.php?a=logout"><?php _e('Log out'); ?></a></li> 
    </ul>
    <?php if (isset($_SESSION['magvendo']['magazine_id'])) : ?>
        <?php $magazine = get_magazine($_SESSION['magvendo']['magazine_id']); ?>
    <?php endif; ?>
    <h1><a href="index.php"><?php echo MAGV_APP_NAME; ?></a><?php if(!empty($magazine)) : ?> <span> | <?php echo $magazine['name']; ?></span><?php endif; ?></h1>
</div> <!-- #header -->

<?php require_once 'sider.php'; ?>

<div id="content">
