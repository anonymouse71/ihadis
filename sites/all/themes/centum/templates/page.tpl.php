<!-- Wrapper Start -->
<div id="wrapper">


<!-- Header
================================================== -->

<!-- 960 Container -->
<div class="container ie-dropdown-fix">

    <!-- Header -->
    <div id="header">

        <!-- Logo -->
        <div class="sixteen columns">
            <?php if ($logo): ?>
                <div id="logo">
                    <a href="<?php print $front_page; ?>"><img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>"/></a>
                    <?php if ($site_slogan): ?>
                        <div id="tagline"><?php print $site_slogan; ?></div>
                    <?php endif; ?>
                    <div class="clear"></div>
                </div>
            <?php endif; ?>
        </div>

    </div>
    <!-- Header / End -->

    <?php if (!empty($navigation)): ?>
    <!-- Navigation -->
    <div class="sixteen columns">

        <div id="navigation">
            <?php if (!empty($navigation)): ?>
                <?php print $navigation; ?>
            <?php endif; ?>

            <?php if (!empty($seach_block_form)): ?>
                <!-- Search Form -->
                <div class="search-form">
                    <?php print $seach_block_form; ?>
                </div>
            <?php endif; ?>

        </div>
        <div class="clear"></div>

    </div>
    <!-- Navigation / End -->
    <?php endif; ?>

</div>
<!-- 960 Container / End -->


<?php if ($breadcrumb): ?>
    <div class="container">

        <div class="sixteen columns">
            <div id="breadcrumb"><?php print $breadcrumb; ?></div>
        </div>
    </div>
<?php endif; ?>


<?php if ($title): ?>
    <!-- // page title -->
    <div class="container">

        <div class="sixteen columns">

            <!-- Page Title -->
            <div id="page-title">
                <h2><?php print $title; ?></h2>

                <div id="bolded-line"></div>
            </div>
            <!-- Page Title / End -->

        </div>
    </div>
    <!-- // end page title -->
<?php endif; ?>


<!-- Content
================================================== -->

<!-- 960 Container -->
<div class="container">
    <?php if (drupal_is_front_page() && !empty($slider)): ?>
        <!-- Flexslider -->
        <div class="sixteen columns">
            <section class="slider">
                <?php print $slider; ?>
            </section>
        </div>
        <!-- Flexslider / End -->
    <?php endif; ?>

</div>
<!-- 960 Container / End -->

<?php if ($page['home_services']): ?>
    <div class="container">
        <?php print render($page['home_services']); ?>
    </div>
<?php endif; ?>


<!-- 960 Container -->
<div class="container">

    <?php if ($page['highlighted']): ?>
        <div class="sixteen columns">
            <?php print render($page['highlighted']); ?>
        </div>
        <div class="clear"></div>
    <?php endif; ?>


    <?php if ($page['sidebar_first']): ?>
        <div class="sidebar four columns" id="sidebar-first">
            <?php print render($page['sidebar_first']); ?>
        </div>
    <?php endif; ?>


    <?php

    $content_class = 'main-content';
    if ($page['sidebar_second'] || $page['sidebar_first']) {
        if ($page['sidebar_first']) {
            $content_class = 'twelve columns';
        } else {
            $content_class = 'twelve columns';
        }
    }
    ?>

    <div id="content" class="<?php print $content_class; ?>">

        <?php if (!$page['sidebar_first'] && !$page['sidebar_second']): ?>

        <div class="container">

            <div class="sixteen columns">
                <?php endif; ?>
                <?php print $messages; ?>

                <div class="clear"></div>

                <?php if (!empty($tabs['#primary']) || !empty($tabs['#secondary'])): ?>
                    <div class="tabs">
                        <?php print render($tabs); ?>
                    </div>
                <?php endif; ?>

                <?php print render($page['help']); ?>

                <?php if ($action_links): ?>
                    <ul class="action-links">
                        <?php print render($action_links); ?>
                    </ul>
                <?php endif; ?>

                <?php if (!$page['sidebar_first'] && !$page['sidebar_second']): ?>
            </div>
        </div>

    <?php endif; ?>

        <?php

        $page_content_class = 'page-content';

        if (!($page['sidebar_second']) && !($page['sidebar_first'])) {
            $path_alias = drupal_get_path_alias();
            if (arg(0) == 'node' && is_numeric(arg(1))) {
                $node = node_load(arg(1));
                if ($node->type == 'page' || $node->type == 'portfolio') {
                    $path_alias = 'node-page';
                }
            }
            $allow_alias = array(
                'portfolio',
                'portfolio/2c',
                'portfolio/3c',
                'portfolio/4c',
                'front-page',
                'node-page',
            );
            if (!in_array($path_alias, $allow_alias)) {
                $page_content_class = 'sixteen columns';
            }
        }
        ?>
        <div class="<?php print $page_content_class; ?>">
            <?php print render($page['content']); ?>
        </div>
        <?php print $feed_icons; ?>
    </div>

    <?php if ($page['sidebar_second']): ?>
        <div class="sidebar four columns" id="sidebar-second">
            <?php print render($page['sidebar_second']); ?>
        </div>
    <?php endif; ?>

</div>
<!-- 960 Container / End -->

</div>
<!-- Wrapper / End -->


<!-- Footer
================================================== -->

<!-- Footer Start -->
<div id="footer">

    <!-- 960 Container -->
    <div class="container">

        <?php if ($page['footer_firstcolumn'] || $page['footer_secondcolumn'] || $page['footer_thirdcolumn'] || $page['footer_fourthcolumn']): ?>
            <!-- 1/4 Columns -->
            <div class="four columns">
                <?php print render($page['footer_firstcolumn']); ?>
            </div>

            <!--  1/4 Columns -->
            <div class="four columns">
                <?php print render($page['footer_secondcolumn']); ?>
            </div>

            <!-- 1/4 Columns -->
            <div class="four columns">
                <?php print render($page['footer_thirdcolumn']); ?>
                <div class="clearfix"></div>
            </div>

            <!-- 1/4 Columns -->
            <div class="four columns">
                <?php print render($page['footer_fourthcolumn']); ?>
            </div>

        <?php endif; ?>

        <!-- Footer / Bottom -->
        <div class="sixteen columns">
            <div id="footer-bottom">
                <?php print theme_get_setting('footer_copyright_message', 'centum'); ?>
                <div id="scroll-top-top"><a href="#"></a></div>
            </div>
        </div>

    </div>
    <!-- 960 Container / End -->

</div>
<!-- Footer / End -->
