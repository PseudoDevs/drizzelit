<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <title><?php echo $settings['site_title']; ?></title>

    <base href="<?php echo $settings['site_url'] ?>">

    <!-- Favicon -->
    <link href="<?php echo $settings['site_url'] . $settings['favicon_path']; ?>" rel="shortcut icon" type="image/png">

    <!-- Search engine tags -->
    <meta name="description" content="<?php echo $settings['site_desc']; ?>">
    <meta name="author" content="<?php echo $settings['site_name']; ?>">
    <meta name="keywords" content="<?php echo $settings['site_keywords']; ?>"/>

    <!-- External libraries and fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,300,600,800,900" rel="stylesheet" type="text/css">
    <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
    <link href="assets/css/vegas.min.css?v=<?php echo $settings['version']; ?>" rel="stylesheet">

    <!-- Droppy stylesheet -->
    <link rel="stylesheet" href="assets/themes/<?php echo $settings['theme'] ?>/css/style.css?v=<?php echo rand() . $settings['version']; ?>">

    <?php if(!empty($settings['theme_color'])): ?>
    <!-- Style overwrite -->
    <style>.button.is-info, .upload-block .upload-form .radio-group .radio.selected { background: <?php echo $settings['theme_color'] ?> !important; color: <?php echo (!empty($settings['theme_color_text']) ? $settings['theme_color_text'] : '#fff'); ?> } .close-btn { color: <?php echo (!empty($settings['theme_color']) ? $settings['theme_color'] : '#485fc7'); ?> } .navbar.is-info { background-color: <?php echo (!empty($settings['theme_color']) ? $settings['theme_color'] : '#3e8ed0'); ?> }</style>
    <?php endif; ?>

    <?php
    if(isset($custom_css) && count($custom_css) > 0) {
        foreach ($custom_css as $css) {
            echo '<link href="' . $css . '" rel="stylesheet">';
        }
    }
    ?>

    <!-- Javascript -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
</head>
<body>

<!-- Background -->
<div class="background" id="background"></div>

<!-- Dropzone overlay -->
<div class="drop-overlay" id="drop-overlay"><p><?php echo lang('drop_files_here'); ?></p></div>

<!-- Mobile navbar -->
<nav class="navbar is-info mobile-nav" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="<?php echo $settings['site_url'] ?>">
            <img src="<?php echo $settings['logo_path']; ?>" height="28">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div class="navbar-menu">
        <div class="navbar-start">
            <?php
            if(is_array($custom_tabs) && !empty($custom_tabs)) {
                foreach ($custom_tabs AS $key => $tab) {
                    if(in_array($tab, array('uploads','logout')))
                        continue;

                    echo '<a class="navbar-item" '.($tab['type'] == 'url' ? 'href="'.base_url($tab['url']).'" '. ($tab['new_tab'] ? 'target="_blank"' : '') : '').'data-target="tab-' . $key . '">' . lang($tab['translation']) . '</a>';
                }
            }
            ?>
            <a class="navbar-item" data-target="tab-language">
                <?php echo lang('change_language'); ?>
            </a>
            <a class="navbar-item" data-target="tab-terms">
                <?php echo lang('terms_service'); ?>
            </a>
            <a class="navbar-item" data-target="tab-about">
                <?php echo lang('about_us'); ?>
            </a>
            <?php if($settings['contact_enabled'] == 'true'): ?>
            <a class="navbar-item" data-target="tab-contact">
                <?php echo lang('contact'); ?>
            </a>
            <?php endif; ?>
            <?php if($session->has_userdata('user') && $session->userdata('user') == true): ?>
                <a class="navbar-item" href="<?php echo base_url('login/logout') ?>">
                    <?php echo lang('logout'); ?>
                </a>
            <?php endif; ?>
            <?php if(isset($_SESSION['droppy_premium'])): ?>
                <a class="navbar-item" href="<?php echo base_url('page/premium?action=logout') ?>">
                    <?php echo lang('logout'); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
    </div>
</nav>

<!-- Logo -->
<img src="<?php echo $settings['logo_path']; ?>" class="main-logo">

<!-- Page tabs -->
<div class="tabs is-toggle is-small is-right" id="page-tabs">
    <ul>
        <!--<li>
            <a>
                <span>Go premium</span>
            </a>
        </li>
        <li>
            <a>
                <span>My account</span>
            </a>
        </li>-->

        <?php
        if(is_array($custom_tabs) && !empty($custom_tabs)) {
            foreach ($custom_tabs AS $key => $tab) {
                if(in_array($key, array('uploads','logout')))
                    continue;

                echo '<li><a '.($tab['type'] == 'url' ? 'href="'.base_url($tab['url']).'" '. ($tab['new_tab'] ? 'target="_blank"' : '') : '').'data-target="tab-' . $key . '"><span>' . lang($tab['translation']) . '</span></a></li>';
            }
        }
        ?>
        <li>
            <a data-target="tab-language">
                <span><?php echo lang('change_language'); ?></span>
            </a>
        </li>
        <li>
            <a data-target="tab-terms">
                <span><?php echo lang('terms_service'); ?></span>
            </a>
        </li>
        <li>
            <a data-target="tab-about">
                <span><?php echo lang('about_us'); ?></span>
            </a>
        </li>
        <?php if($settings['contact_enabled'] == 'true'): ?>
        <li>
            <a data-target="tab-contact">
                <span><?php echo lang('contact'); ?></span>
            </a>
        </li>
        <?php endif; ?>
        <?php if($session->has_userdata('user') && $session->userdata('user') == true): ?>
            <li>
                <a href="<?php echo base_url('login/logout') ?>">
                    <span><?php echo lang('logout'); ?></span>
                </a>
            </li>
        <?php endif; ?>
        <?php if(isset($_SESSION['droppy_premium'])): ?>
            <li>
                <a href="<?php echo base_url('page/premium?action=logout') ?>">
                    <span><?php echo lang('logout'); ?></span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</div>
<!-- END Page tabs -->

<div class="tab-window">
    <a href="#" class="close-btn"><i class="lni lni-close"></i></a>
    <hr>
    <div class="tab" id="tab-language">
        <h1><?php echo lang('change_language'); ?></h1>

        <label class="label"><?php echo lang('select_pref_lang'); ?></label>
        <div class="control has-icons-left">
            <div class="select is-rounded is-fullwidth">
                <select onchange="General.changeLanguage()" id="languagePicker">
                    <option disabled selected> -- <?php echo lang('select_language'); ?> -- </option>
                    <?php
                    foreach($language_list as $row)
                    {
                        echo '<option value="' . $row->path . '">' . $row->name . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="icon is-small is-left">
                <i class="lni lni-world"></i>
            </div>
        </div>
        <br>
        <?php
        if($settings['ad_1_enabled'] == 'true') :
            ?>
            <div style="margin-right: auto; margin-left: auto; margin-top: 120px; width: 468px; height: 60px;">
                <?php echo $settings['ad_1_code']; ?>
            </div>
        <?php
        endif;
        ?>
    </div>
    <div class="tab large" id="tab-terms">
        <h1><?php echo lang('terms_service'); ?></h1>

        <p>
            <?php echo $settings['terms_text']; ?>
        </p>
    </div>
    <div class="tab large" id="tab-about">
        <h1><?php echo lang('about_us'); ?></h1>

        <p>
            <?php echo $settings['about_text']; ?>
        </p>
    </div>
    <?php if($settings['contact_enabled'] == 'true'): ?>
    <div class="tab" id="tab-contact">
        <h1><?php echo lang('contact'); ?></h1>
        <form class="contact-form">
            <div class="field">
                <label class="label"><?php echo lang('email'); ?></label>
                <div class="control">
                    <input class="input" type="email" name="contact_email" placeholder="<?php echo lang('contact_email_description'); ?>">
                </div>
            </div>
            <div class="field">
                <label class="label"><?php echo lang('subject'); ?></label>
                <div class="control">
                    <input class="input" type="text" name="contact_subject" placeholder="<?php echo lang('contact_subject_description'); ?>">
                </div>
            </div>
            <div class="field">
                <label class="label"><?php echo lang('message'); ?></label>
                <div class="control">
                    <textarea class="textarea" name="contact_message" placeholder="<?php echo lang('contact_message_description'); ?>"></textarea>
                </div>
            </div>
            <div class="g-recaptcha" data-sitekey="<?php echo $settings['recaptcha_key']; ?>"></div>
            <div class="field is-right">
                <p class="control">
                    <button class="button is-info">
                        <?php echo lang('send'); ?>
                    </button>
                </p>
            </div>
        </form>
    </div>
    <?php
    endif;
    if(is_array($custom_tabs) && !empty($custom_tabs)) {
    foreach ($custom_tabs AS $key => $tab) {
        if ($tab['type'] == 'inline') {
            echo '<div class="tab" id="tab-'.$key.'">';
            require_once APPPATH . 'plugins/' . $tab['plugin'] . '/' . $tab['view'];
            echo '</div>';
        }
        }
    }
    ?>
    <!-- Logo -->
    <img src="<?php echo $settings['logo_path']; ?>" class="tab-logo">
</div>