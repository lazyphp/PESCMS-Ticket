<?php
/**
 * 本模板为智能表单添加/编辑模式下的头部复用模板
 * 定制开发中，若没有特殊的需求，请加载本模板。
 */
?>
<!-- content start -->
<div class="admin-content am-padding-xs am-padding-top-0 am-padding-bottom-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
                <div class="am-fl am-cf">
                    <?php if (!empty($_GET['back_url'])): ?>
                        <a href="<?= base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i
                                class="am-icon-reply"></i>返回</a>
                    <?php endif; ?>
                    <strong class="am-text-primary am-text-lg"><?= $title; ?></strong>
                </div>
            </div>
            <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed"/>
            <form class="am-form am-form-horizontal ajax-submit"  action="<?= $url ?? ''; ?>" method="post" data-am-validator>
