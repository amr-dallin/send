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
        <?php echo $this->Html->css(['bootstrap.min', 'font-awesome.min']); ?>

        <!-- SmartAdmin Styles : Caution! DO NOT change the order -->
        <?php echo $this->Html->css(['smartadmin-production-plugins.min', 'smartadmin-production.min', 'smartadmin-skins.min']); ?>

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

        <!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        
        <link rel="apple-touch-icon" href="/img/touch-icon-iphone.png" type="image/png">
		<link rel="apple-touch-icon" href="/img/touch-icon-ipad.png" type="image/png" sizes="76x76">
		<link rel="apple-touch-icon" href="/img/touch-icon-iphone-retina.png" type="image/png" sizes="120x120">
		<link rel="apple-touch-icon" href="/img/touch-icon-ipad-retina.png" type="image/png" sizes="152x152">
		
		<link rel="icon" href="/img/favicon-16x16.png" type="image/png" sizes="16x16">  
		<link rel="icon" href="/img/favicon-32x32.png" type="image/png" sizes="32x32">  

    </head>

    <!--

    TABLE OF CONTENTS.
    
    Use search to find needed section.
    
    ===================================================================
    
    |  01. #CSS Links                |  all CSS links and file paths  |
    |  02. #FAVICONS                 |  Favicon links and file paths  |
    |  03. #GOOGLE FONT              |  Google font link              |
    |  04. #APP SCREEN / ICONS       |  app icons, screen backdrops   |
    |  05. #BODY                     |  body tag                      |
    |  06. #HEADER                   |  header tag                    |
    |  07. #PROJECTS                 |  project lists                 |
    |  08. #TOGGLE LAYOUT BUTTONS    |  layout buttons and actions    |
    |  09. #MOBILE                   |  mobile view dropdown          |
    |  10. #SEARCH                   |  search field                  |
    |  11. #NAVIGATION               |  left panel & navigation       |
    |  12. #MAIN PANEL               |  main panel                    |
    |  13. #MAIN CONTENT             |  content holder                |
    |  14. #PAGE FOOTER              |  page footer                   |
    |  15. #SHORTCUT AREA            |  dropdown shortcuts area       |
    |  16. #PLUGINS                  |  all scripts and plugins       |
    
    ===================================================================
    
    -->

    <!-- #BODY -->
    <!-- Possible Classes

            * 'smart-style-{SKIN#}'
            * 'smart-rtl'         - Switch theme mode to RTL
            * 'menu-on-top'       - Switch to top navigation (no DOM change required)
            * 'no-menu'			  - Hides the menu completely
            * 'hidden-menu'       - Hides the main menu but still accessable by hovering over left edge
            * 'fixed-header'      - Fixes the header
            * 'fixed-navigation'  - Fixes the main menu
            * 'fixed-ribbon'      - Fixes breadcrumb
            * 'fixed-page-footer' - Fixes footer
            * 'container'         - boxed layout mode (non-responsive: will not work with fixed-navigation & fixed-ribbon)
    -->
    <body class="">

        <!-- #HEADER -->
        <?php echo $this->element('header'); ?>
        <!-- END HEADER -->

        <!-- #NAVIGATION -->
        <!-- Left panel : Navigation area -->
        <!-- Note: This width of the aside area can be adjusted through LESS/SASS variables -->
        <?php echo $this->fetch('navigation'); ?>
        <!-- END NAVIGATION -->

        <!-- #MAIN PANEL -->
        <div id="main" role="main">

            <!-- RIBBON -->
            <?php echo $this->fetch('ribbon'); ?>
            <!-- END RIBBON -->


            <!-- #MAIN CONTENT -->
            <div id="content">
                <?php echo $this->Flash->render(); ?>
                <?php echo $this->fetch('title-heading'); ?>
                <?php echo $this->fetch('content'); ?>
            </div>

            <!-- END #MAIN CONTENT -->

        </div>
        <!-- END #MAIN PANEL -->

        <!-- #PAGE FOOTER -->
        <?php echo $this->element('footer'); ?>
        <!-- END FOOTER -->

        <!-- #SHORTCUT AREA : With large tiles (activated via clicking user name tag)
                Note: These tiles are completely responsive, you can add as many as you like -->
        <?php echo $this->element('shortcut'); ?>
        <!-- END SHORTCUT AREA -->

        <!--================================================== -->

        <!-- PACE LOADER - turn this on if you want ajax loading to show (caution: uses lots of memory on iDevices)
        <script data-pace-options='{ "restartOnRequestAfter": true }' src="js/plugin/pace/pace.min.js"></script>-->


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

        <!-- JARVIS WIDGETS -->
    <?php echo $this->Html->script('smartwidgets/jarvis.widget.min'); ?>

        <!-- EASY PIE CHARTS -->
    <?php echo $this->Html->script('plugin/easy-pie-chart/jquery.easy-pie-chart.min'); ?>

        <!-- SPARKLINES -->
    <?php echo $this->Html->script('plugin/sparkline/jquery.sparkline.min'); ?>

        <!-- JQUERY VALIDATE -->
    <?php echo $this->Html->script('plugin/jquery-validate/jquery.validate.min'); ?>

        <!-- JQUERY MASKED INPUT -->
    <?php echo $this->Html->script('plugin/masked-input/jquery.maskedinput.min'); ?>

        <!-- JQUERY SELECT2 INPUT -->
    <?php echo $this->Html->script('plugin/select2/select2.min'); ?>

        <!-- JQUERY UI + Bootstrap Slider -->
    <?php echo $this->Html->script('plugin/bootstrap-slider/bootstrap-slider.min'); ?>

        <!-- browser msie issue fix -->
    <?php echo $this->Html->script('plugin/msie-fix/jquery.mb.browser.min'); ?>

        <!-- FastClick: For mobile devices -->
    <?php echo $this->Html->script('plugin/fastclick/fastclick.min'); ?>

    <?php echo $this->Html->script(['plugin/DataTables/datatables.min']); ?>

        <!--[if IE 8]>

        <h1>Your browser is out of date, please update your browser by going to www.microsoft.com/download</h1>

        <![endif]-->

        <!-- MAIN APP JS FILE -->
    <?php echo $this->Html->script('app.min'); ?>

        <!-- ENHANCEMENT PLUGINS : NOT A REQUIREMENT -->
        <!-- Voice command : plugin -->
    <?php echo $this->Html->script('speech/voicecommand.min'); ?>

        <!-- PAGE RELATED PLUGIN(S) -->


    <?php echo $this->fetch('script'); ?>
        <script type="text/javascript">
            $(document).ready(function () {
                pageSetUp();
            });
        </script>
    <?php echo $this->fetch('script1'); ?>
    <?php echo $this->fetch('script-code'); ?>
    </body>

</html>
