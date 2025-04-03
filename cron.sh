#!/bin/bash

# 确保使用 bash 运行
if [ -z "$BASH_VERSION" ]; then
    exec bash "$0" "$@"
fi

# 获取当前脚本所在目录
SCRIPT_DIR=$(cd "$(dirname "$0")" && pwd)

# 询问用户 PESCMS-TICKET 目录
read -p "请输入 PESCMS-TICKET 目录 (留空默认使用当前目录: $SCRIPT_DIR): " PROJECT_DIR
PROJECT_DIR=${PROJECT_DIR:-$SCRIPT_DIR}

# 检查目录是否有效
if [ ! -d "$PROJECT_DIR" ]; then
    echo "❌ 目录不存在: $PROJECT_DIR"
    exit 1
fi

# 查找 PHP 可执行文件
PHP_BIN=$(command -v php | tr -d '\r')
if [ -n "$PHP_BIN" ] && [ -x "$PHP_BIN" ]; then
    echo "找到 PHP 可执行文件: $PHP_BIN"
    echo -n "是否使用这个路径？(Y/n): "
    read use_default_php
    use_default_php=${use_default_php,,}  # 转小写
    if [ "$use_default_php" == "n" ]; then
        PHP_BIN=""
    fi
else
    PHP_BIN=""
fi

# 让用户手动输入 PHP 路径（如果未找到或不使用默认路径）
while [ -z "$PHP_BIN" ]; do
    read -p "请输入 PHP 可执行文件路径: " PHP_BIN
    if [ ! -x "$PHP_BIN" ]; then
        echo "❌ 无效的 PHP 路径，请重新输入！"
        PHP_BIN=""
    fi
done

# 询问用户定时执行间隔
while true; do
    read -p "请输入定时任务执行间隔（分钟）: " INTERVAL
    if [[ "$INTERVAL" =~ ^[1-9][0-9]*$ ]]; then
        break
    else
        echo "❌ 输入无效，间隔时间必须是正整数！"
    fi
done

# 定义要执行的命令
CRON_CMD="$PHP_BIN $PROJECT_DIR/Expand/Cli/SendNotice.php"

# 检查是否已经存在相同的 crontab 任务
if crontab -l 2>/dev/null | grep -q "$CRON_CMD"; then
    echo "✅ 定时任务已存在，无需重复添加。"
else
    (crontab -l 2>/dev/null; echo "*/$INTERVAL * * * * $CRON_CMD") | crontab -
    echo "✅ 定时任务已成功添加，每 $INTERVAL 分钟执行一次:"
    echo "*/$INTERVAL * * * * $CRON_CMD"
fi

