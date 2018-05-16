<?php
/**
 * 模板为智能表单列表的页眉
 * 若没有特殊的需求，请加载本模板
 */
?>
<!-- content start -->
<div class=" am-padding-xs am-padding-top-0">
    <div class="am-panel am-panel-default">
        <div class="am-panel-bd">
            <div class="am-cf">
        <div class="am-fl am-cf">
            <?php if (!empty($_GET['back_url'])): ?>
                <a href="<?= base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i
                        class="am-icon-reply"></i>返回</a>
            <?php endif; ?>
            <strong class="am-text-primary am-text-lg"><a href="<?= $label->url(GROUP .'-' . MODULE . '-' . ACTION); ?>"><?= $title; ?></a>
            </strong> /
            <small>列表</small>
        </div>
    </div>
