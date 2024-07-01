<?php
if (defined('PES_CORE') == false) {
    header('HTTP/1.1 404 Not Found');
    exit;
}
return [
    'search_placeholder' => [
        'field_name'         => "search_placeholder",
        'field_display_name' => "输入框提示文字",
        'field_type'         => "text",
        'field_option'       => [],
        'field_explain'      => "",
        'field_default'      => "",
        'field_required'     => 0,
    ],
];