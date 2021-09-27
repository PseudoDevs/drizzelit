<div class="upload-block">
    <div class="upload-block-inner">
        <div class="upload-block-content start-top active" id="download">
            <?php if(isset($data) && is_array($data)): ?>
                <?php if($data['status'] == 'ready'): ?>
                    <div id="download-form">
                        <form action="handler/download" method="post">
                            <input type="hidden" name="action" id="action" value="download">
                            <input type="hidden" name="download_id" id="download_id" value="<?php echo $upload_id; ?>">
                            <input type="hidden" name="private_id" id="private_id" value="<?php echo $unique_id; ?>">
                            <input type="hidden" name="url" value="<?php echo urlencode(current_url()) ?>">

                            <div class="top">
                                <img src="assets/themes/<?php echo $settings['theme'] ?>/img/icons/download.png" class="block-icon sm">

                                <h1><?php echo lang('download_is_ready') ?></h1>
                                <?php if($data['time_expire'] > $data['time']): ?><p class="expire"><?php echo lang('download_will_be_deleted') ?> <?php echo date("Y-m-d", $data['time_expire']); ?></p><?php endif; ?>
                            </div>

                            <?php if($data['password'] != 'EMPTY' && !empty($data['password'])) : ?>
                                <div class="password-block">
                                    <h1><i class="lni lni-lock-alt"></i></h1>
                                    <p><?php echo lang('fill_password') ?></p>
                                    <div class="field">
                                        <div class="control">
                                            <input class="input" type="password" name="password" placeholder="<?php echo lang('password') ?>" autocomplete="no" autofill="no">
                                        </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="upload-message"><?php echo $data['message']; ?></div>
                                <div class="selected-files active" id="selected-files">
                                    <div class="bottom">
                                        <div class="stats">
                                    <span><b id="stats-total"><?php echo $data['count']; ?></b><br>
                                        <?php echo lang('files') ?></span>
                                            <span><b id="stats-selected"><?php echo (($data['size'] < 1048576)? round($data['size'] / 1024, 2) . ' KB' : round($data['size'] / 1048576, 2) . ' MB'); ?></b><br>
                                        <?php echo lang('total_size') ?></span>
                                        </div>
                                    </div>
                                    <ul>
                                        <?php
                                        foreach($files as $file) {
                                            echo '<li><span class="name">'.$file['file'].'</span><span class="size">'.(($file['size'] < 1048576)? round($file['size'] / 1024, 2) . ' KB' : round($file['size'] / 1048576, 2) . ' MB').'</span></li>';
                                        }
                                        ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <div class="button-block">
                                <button class="button is-info is-rounded" type="submit"><?php echo lang('download') ?></button>
                            </div>
                        </form>
                    </div>
                    <div id="download-started">
                        <div class="top">
                            <img src="assets/themes/<?php echo $settings['theme'] ?>/img/icons/download-started.png" class="block-icon sm">

                            <h1><?php echo lang('download_started') ?></h1>
                        </div>
                        <div class="button-block">
                            <button class="button is-info is-rounded" onclick="window.location.href = siteUrl;"><?php echo lang('ok') ?></button>
                        </div>
                    </div>
                <?php elseif($data['status'] == 'processing'): ?>
                    <lord-icon
                            src="assets/themes/<?php echo $settings['theme'] ?>/uetqnvvg.json"
                            trigger="loop"
                            colors="primary:<?php echo (!empty($settings['theme_color']) ? $settings['theme_color'] : '#3e8ed0'); ?>,secondary:<?php echo (!empty($settings['theme_color']) ? $settings['theme_color'] : '#3e8ed0'); ?>"
                            style="width:100%;height:250px">
                    </lord-icon>
                    <span class="description"><?php echo lang('upload_processing'); ?></span>

                    <div class="button-block">
                        <button class="button is-info is-rounded" onclick="location.reload();"><?php echo lang('refresh') ?></button>
                    </div>
                <?php else: ?>
                    <img src="assets/themes/<?php echo $settings['theme'] ?>/img/icons/upload-not-found.png" class="block-icon">

                    <span class="description"><?php echo lang('upload_not_found'); ?></span>

                    <div class="button-block">
                        <button class="button is-info is-rounded" onclick="window.location.href = siteUrl;"><?php echo lang('ok') ?></button>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <img src="assets/themes/<?php echo $settings['theme'] ?>/img/icons/upload-not-found.png" class="block-icon">

                <span class="description"><?php echo lang('upload_not_found'); ?></span>

                <div class="button-block">
                    <button class="button is-info is-rounded" onclick="window.location.href = siteUrl;"><?php echo lang('ok') ?></button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="upload-block-tooltip">
        <div class="content error">
            <img src="assets/themes/<?php echo $settings['theme'] ?>/img/icons/error-icon-white.png">
            <p></p>
        </div>
        <div class="content help">
            <img src="assets/themes/<?php echo $settings['theme'] ?>/img/icons/question.png">
            <p></p>
        </div>
    </div>
</div>

<?php
if(isset($_GET['error'])) {
    echo '<script>$(document).ready(function() { General.errorMsg("'.lang($_GET['error']).'"); setTimeout(function() { General.clearError(); }, 3000) });</script>';
}
?>