<?php
/**
 * 本模板为智能表单添加/编辑模式下的头部复用模板
 * 定制开发中，若没有特殊的需求，请加载本模板。
 */
?>
<!-- content start -->
<div class="admin-content am-padding am-padding-top-0">

    <div class="am-cf">
        <div class="am-fl am-cf">
            <a href="<?= base64_decode($_GET['back_url']) ?>" class="am-margin-right-xs am-text-danger"><i class="am-icon-reply"></i>返回</a>
            <strong class="am-text-primary am-text-lg"><?= $title; ?></strong>
        </div>
    </div>
    <hr data-am-widget="divider" style="" class="am-divider am-divider-dashed" />
    <form class="am-form am-form-horizontal" action="<?= $url; ?>" method="post" data-am-validator>
        <ul class="am-list am-list-static am-list-border am-text-sm">
            <li style="background: #F5f6FA;border-left: 4px solid #6d7781;">基础信息</li>
