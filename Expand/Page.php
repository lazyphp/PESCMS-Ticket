<?php

/**
 * 版权所有 2022 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Expand;

/**
 * 分页类
 */
class Page extends PageCommon {

    public $firstRow = '0'; //起始行
    public $listRows = '10'; //显示行数
    public $rollPage = '5'; //分页数
    //public $url = '';//分页地址
    public $totalPages = ''; //总页数
    public $totalRow = ''; //总记录
    public $nowPage = '';
    /**
     * 设置分页样式，除了total不会带a链接，其他所有标签都会带上a链接
     * 可用变量：
     * {total} => 合计页数,
     * {first} => 第一页,
     * {pre} => 上一页,
     * {current} => 当前页,
     * {next} => 下一页,
     * {last} => 最后一页
     * @var string
     */
    //
    public $style = [];

    /**
     * 国际化，语言包
     * 可用变量：
     * first => 第一页,
     * pre => 上一页,
     * next => 下一页,
     * last => 最后一页
     * @var array
     */
    public $LANG = [];

    public function __construct() {
        $this->total();
    }

    public function total($total = 0) {
        $this->totalRow = $total;
        $this->totalPages = ceil($this->totalRow / $this->listRows);
    }

    public function handle() {
        $page = empty($_GET['page']) ? '1' : (int)$_GET['page'];
        if ($page > $this->totalPages && $this->totalPages > 0) {//用户页数大于翻页书时，则显示最后一页数据
            $page = $this->totalPages;
        }
        $this->nowPage = $page;
        $this->firstRow = $this->listRows * ($this->nowPage - 1);
    }

    public function show() {
        //分页缺省值
        $this->style = array_merge([
            'total' => '<li><a>总计<b>{total}</b>个记录</a></li>',
            'first' => '<li>{first}</li>',
            'pre' => '<li>{pre}</li>',
            'pagenumber' => '<li>{pagenumber}</li>',
            'current' => '<li class="am-active">{current}</li>',
            'next' => '<li>{next}</li>',
            'last' => '<li>{last}</li>'
        ], $this->style);

        $this->LANG = array_merge([
            'first' => '首页',
            'pre' => '上一页',
            'next' => '下一页',
            'last' => '尾页'
        ], $this->LANG);

        $nowCoolPage = ceil($this->nowPage / $this->rollPage);
        $upRow = $this->nowPage - 1;
        $downRow = $this->nowPage + 1;

        $url = "";

        $url .= !empty($this->totalPages) ? str_replace('{total}', $this->totalRow, $this->style['total']) : '';

        if (!empty($upRow)) {
            $url .= str_replace('{first}', '<a href="' . $this->urlLinkStr('1') . '">'.$this->LANG['first'].'</a>', $this->style['first']);
            $url .= str_replace('{pre}', '<a href="' . $this->urlLinkStr($upRow) . '">'.$this->LANG['pre'].'</a>', $this->style['pre']);
        }

        $interval = ceil($this->rollPage / 2);
        for ($i = $this->nowPage - $interval; $i < $this->nowPage; $i++) {
            if ($i > 0) {
                $url .= str_replace('{pagenumber}', '<a href="' . $this->urlLinkStr($i) . '">' . $i . '</a>', $this->style['pagenumber']);
            }
        }

        $url .= str_replace('{current}', '<a href="javascript:;">' . $this->nowPage . '</a>', $this->style['current']);

        for ($i = $this->nowPage + 1; $i < $this->nowPage + $interval + 1; $i++) {
            if ($i <= $this->totalPages) {
                $url .= str_replace('{pagenumber}', '<a href="' . $this->urlLinkStr($i) . '">' . $i . '</a>', $this->style['pagenumber']);
            }
        }

        if ($downRow <= $this->totalPages) {
            $url .= str_replace('{next}', '<a href="' . $this->urlLinkStr($downRow) . '">'.$this->LANG['next'].'</a>', $this->style['next']);
        }

        if ($this->totalPages > 1 && $this->nowPage < $this->totalPages) {
            $url .= str_replace('{last}', '<a href="' . $this->urlLinkStr($this->totalPages) . '">'.$this->LANG['last'].'</a>', $this->style['last']);
        }

        return $url;
    }

}
