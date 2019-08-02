<!DOCTYPE html>
<html lang="en-us">
    <head>
        <?php echo $this->Html->charset() ?>
        <title><?php echo $this->fetch('title') ?></title>
        <meta name="robots" content="noindex">
        <?php echo $this->fetch('meta') ?>

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- #CSS Links -->
        <!-- Basic Styles -->
        <?php echo $this->Html->css(['bootstrap.min', 'font-awesome.min']) ?>

        <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
        <?php
        echo $this->Html->css([
            'smartadmin-production-plugins.min',
            'smartadmin-production.min',
            'smartadmin-skins.min'
        ]);
        ?>

        <?php echo $this->fetch('css') ?>

        <!-- We recommend you use "your_style.css" to override SmartAdmin
             specific styles this will also ensure you retrain your customization with each SmartAdmin update.
        <link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

        <!-- #FAVICONS -->
        <?php echo $this->Html->meta('icon') ?>

        <!-- #GOOGLE FONT -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

        <!-- #APP SCREEN / ICONS -->
        <!-- Specifying a Webpage Icon for Web Clip 
                 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
        <link rel="apple-touch-icon" href="img/splash/sptouch-icon-iphone.png">
        <link rel="apple-touch-icon" sizes="76x76" href="img/splash/touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="120x120" href="img/splash/touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/splash/touch-icon-ipad-retina.png">

        <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">

        <!-- Startup image for web apps -->
        <link rel="apple-touch-startup-image" href="img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        <link rel="apple-touch-startup-image" href="img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="img/splash/iphone.png" media="screen and (max-device-width: 320px)">

    </head>

    <body class="animated fadeInDown">
        <!-- #MAIN PANEL -->
        <div role="main">

            <!-- MAIN CONTENT -->
            <div id="content" class="container">
                <div class="row">
                    <div class="col-xs-12 col-md-offset-3 col-md-6">
                        <?php
                        echo $this->Flash->render();
                        echo $this->fetch('content');
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <!-- END #MAIN PANEL -->

        <!-- #PLUGINS -->
        <!-- Link to Google CDN's jQuery + jQueryUI; fall back to local -->
        <?php echo $this->Html->script(['libs/jquery-3.2.1.min', 'libs/jquery-ui.min']); ?>

        <!-- IMPORTANT: APP CONFIG -->
    <?php echo $this->Html->script('app.config'); ?>

        <!-- JS TOUCH : include this plugin for mobile drag / drop touch events-->
    <?php echo $this->Html->script('plugin/jquery-touch/jquery.ui.touch-punch.min'); ?>

        <!-- BOOTSTRAP JS -->
    <?php echo $this->Html->script('bootstrap/bootstrap.min'); ?>

        <!-- CUSTOM NOTIFICATION -->
    <?php echo $this->Html->script('notification/SmartNotification.min'); ?>

        <!-- JQUERY VALIDATE -->
    <?php echo $this->Html->script('plugin/jquery-validate/jquery.validate.min'); ?>

        <!-- JQUERY UI + Bootstrap Slider -->
    <?php echo $this->Html->script('plugin/bootstrap-slider/bootstrap-slider.min'); ?>

        <!-- browser msie issue fix -->
    <?php echo $this->Html->script('plugin/msie-fix/jquery.mb.browser.min'); ?>

        <!--[if IE 8]>

        <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

        <![endif]-->

        <!-- MAIN APP JS FILE -->
    <?php echo $this->Html->script('app.min'); ?>

        <!-- PAGE RELATED PLUGIN(S) -->


    <?php echo $this->fetch('script'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                pageSetUp();
            });
        </script>
    <?php echo $this->fetch('script1'); ?>
    </body>

</html>
