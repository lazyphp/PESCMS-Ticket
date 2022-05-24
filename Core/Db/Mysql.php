<?php

/**
 * 版权所有 2021 PESCMS (https://www.pescms.com)
 * 完整版权和软件许可协议请阅读源码根目录下的LICENSE文件。
 *
 * For the full copyright and license information, please view
 * the file LICENSE that was distributed with this source code.
 */

namespace Core\Db;

use \PDO,
    Core\Func\CoreFunc as CoreFunc;

/**
 * PES Mysql类
 * @author LuoBoss
 * @version 1.0
 */
class Mysql {

    public $dbh, $getLastSql, $getLastInsert, $prefix, $errorInfo = array(), $param = array();
    private $defaultDb, $tableName, $field = '*', $where = '', $join = array(), $order = '',
        $group = '', $limit = '', $lock = '', $transaction = false;

    public function __construct() {
        try {
            $config = CoreFunc::loadConfig();
            $configParam = array('DB_TYPE', 'DB_HOST', 'DB_NAME', 'DB_PORT', 'DB_USER', 'DB_PWD', 'DB_PREFIX');
            foreach ($configParam as $value) {
                $useConfig[$value] = !empty($config[GROUP][$value]) ? $config[GROUP][$value] : $config[$value];
            }

            $this->defaultDb = $useConfig['DB_NAME'];

            $dns = "{$useConfig['DB_TYPE']}:host={$useConfig['DB_HOST']};dbname={$useConfig['DB_NAME']};port={$useConfig['DB_PORT']}";
            $this->prefix = $useConfig['DB_PREFIX'];

            $this->dbh = new \PDO($dns, $useConfig['DB_USER'], $useConfig['DB_PWD']);
            $this->dbh->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->dbh->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
            $this->dbh->exec('SET NAMES utf8mb4');
        } catch (\PDOException $e) {
            if (DEBUG == true) {
                die("Error!: {$e->getMessage()} <br/>");
            } else {
                die("Error!: DB ERROR <br/>");
            }
        }
    }

    /**
     * 设置表名
     * @param str $name 表名称
     * @return \Core\Db\Mysql 返回变量
     */
    public function tableName($name, $database = '', $dbPrefix = '') {
        if (empty($database)) {
            $database = $this->defaultDb;
        }
        if (empty($dbPrefix)) {
            $dbPrefix = $this->prefix;
        }
        $this->tableName = "`$database`.{$dbPrefix}{$name}";
        return $this;
    }

    /**
     * 设置显示字段
     * @param str $name 字段名
     * @return \Core\Db\Mysql 返回变量
     */
    public function field($name) {
        if (empty($name)) {
            $this->field = '*';
        } else {
            $this->field = $name;
        }
        return $this;
    }

    /**
     * 设置条件
     * @param str $condition 条件
     * @return \Core\Db\Mysql 返回变量
     */
    public function where($condition) {
        if (empty($condition)) {
            $this->where = '';
        } else {
            $this->where = ' WHERE ' . $condition;
        }
        return $this;
    }

    /**
     * 设置左联表
     * @param str $condition 条件
     * @return \Core\Db\Mysql 返回变量
     */
    public function join($condition) {
        if (empty($condition)) {
            $this->join = array();
        } else {
            $this->join[] = ' LEFT JOIN ' . $condition;
        }

        return $this;
    }

    /**
     * 设置排序
     * @param str $condition 条件
     * @return \Core\Db\Mysql 返回变量
     */
    public function order($condition) {
        if (empty($condition)) {
            $this->order = '';
        } else {
            $this->order = ' ORDER BY ' . $condition;
        }
        return $this;
    }

    /**
     * 设置组合
     * @param str $condition 条件
     * @return \Core\Db\Mysql 返回变量
     */
    public function group($condition) {
        if (empty($condition)) {
            $this->group = '';
        } else {
            $this->group = ' GROUP BY ' . $condition;
        }
        return $this;
    }

    /**
     * 设置限制
     * @param str $condition 条件
     * @return \Core\Db\Mysql 返回变量
     */
    public function limit($condition) {
        if (empty($condition)) {
            $this->limit = '';
        } else {
            $this->limit = ' LIMIT ' . $condition;
        }
        return $this;
    }

    /**
     * 是否设锁
     * @param $condition
     * @return $this
     */
    public function lock($condition) {
        if (empty($condition)) {
            $this->lock = '';
        } else {
            $this->lock = " {$condition}";
        }
        return $this;
    }

    /**
     * 单条数据查找
     * @param array $param 查询参数(一维数组)
     * @param str $fieldType 字段类型
     * @return array 返回一维数组结果
     */
    public function find($param = '', $fieldType = '') {
        $this->dealParam($param, $fieldType);

        $limit = ' LIMIT 1 ';
        $this->join = empty($this->join) ? array('') : $this->join;
        $this->getLastSql = 'SELECT ' . $this->field . ' FROM ' . $this->tableName . implode('', $this->join) . $this->where . $this->group . $this->order . $limit. $this->lock;
        $sth = $this->PDOBindArray();
        $result = $sth->fetch();
        $sth->closeCursor();

        $this->emptyParam();
        return $result;
    }

    /**
     * 数据查找
     * @param array $param 查询参数(一维数组)
     * @param str $fieldType 字段类型
     * @return array 返回二维数组结果
     */
    public function select($param = '', $fieldType = '') {
        $this->dealParam($param, $fieldType);
        $this->join = empty($this->join) ? array('') : $this->join;
        $this->getLastSql = 'SELECT ' . $this->field . ' FROM ' . $this->tableName . implode('', $this->join) . $this->where . $this->group . $this->order . $this->limit. $this->lock;
        $sth = $this->PDOBindArray();
        $result = $sth->fetchALL();
        $sth->closeCursor();

        $this->emptyParam();
        return $result;
    }

    /**
     * 单例数据插入
     * @param array $param 插入参数(一维数组)
     * @param str $fieldType 字段类型
     * @return str 返回最后插入的ID
     */
    public function insert($param = [], $fieldType = '') {

        $param = $this->tableFieldParam($param);

        $this->dealParam($param, $fieldType);
        foreach ($this->param as $key => $value) {
            $field[] = "`{$key}`";
            $namedPlaceholders[] = ':' . $key;
        }
        $this->getLastSql = 'INSERT INTO ' . $this->tableName . ' (' . implode(',', $field) . ' ) VALUES (' . implode(',', $namedPlaceholders) . ' )';
        $sth = $this->PDOBindArray();
        $this->emptyParam();
        if ($this->dbh->lastInsertId() === false) {
            return false;
        } else {
            $this->getLastInsert = $this->dbh->lastInsertId();
            return $this->dbh->lastInsertId();
        }
    }


    /**
     * 获取对应表的缺省字段，仅在严格模式下运行。
     * @param array $param 插入参数(一维数组)
     * @return array 返回处理好的字段默认值
     */
    private function tableFieldParam($param) {
        if($this->checkSqlTransTable() == false){
            return $param;
        }

        $sth = $this->dbh->prepare("DESC {$this->tableName}");
        $sth->execute();
        $fields = $sth->fetchAll();

        $newParam = [];
        foreach ($fields as $field) {
            $newParam[$field['Field']] = !empty($param[$field['Field']]) ? $param[$field['Field']] : $this->handleFiledType($field['Type'], $field['Default'], $field['Null']);
        }

        return $newParam;
    }

    /**
     * 处理字段类型
     * @param $type 传递的字段类型
     * @param $defualt 字段预设的默认值
     * @param $isNULL 判断是否设置为NULL,是则直接返回NULL
     * @return false|int|string 返回相应符合的数据格式
     */
    private function handleFiledType($type, $defualt, $isNULL) {

        if(strtoupper($isNULL) == 'YES'){
            return NULL;
        }

        $type = str_replace(['unsigned zerofill', 'binary', 'unsigned', 'on update current_timestamp', 'UNSIGNED ZEROFILL', 'BINARY', 'UNSIGNED', 'ON UPDATE CURRENT_TIMESTAMP'], '', $type);

        $type = trim(preg_replace('/[\(\),\d+]/', '', $type));
        switch (strtolower($type)) {
            case 'tinyint':
            case 'smallint':
            case 'mediumint':
            case 'int':
            case 'bigint':
            case 'decimal':
            case 'float':
            case 'double':
            case 'time':
            case 'year':
                $value = is_numeric($defualt) ? $defualt : 0;
                break;
            case 'tinytext':
            case 'text':
            case 'mediumtext':
            case 'longtext':
                $value = '';
                break;
            case 'date':
            case 'datetime':
            case 'timestamp':
                $value = empty($defualt) ? date('Y-m-d H:i:s') : $defualt;
                break;
            case 'char':
            case 'varchar':
            default:
                $value = empty($defualt) ? '' : $defualt;
        }
        return $value;

    }

    /**
     * 检查当前环境MYSQL的数据SQL MODEL。
     * @return bool 严格模式则返回TRUE 反之 FALSE
     */
    private function checkSqlTransTable(){
        $sqlModel = CoreFunc::loadConfig('SQL_MODEL', true);
        if(empty($sqlModel)){
            $configFile = CONFIG_PATH.'config.php';

            if(!is_file($configFile)){
                $this->returnError([
                    'msg' => '验证SQL MODEL时，获取程序配置文件失败',
                    'string' => '验证SQL MODEL时，获取程序配置文件失败'
                ]);
            }

            $sql = "SELECT @@sql_mode AS model";
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
            $model = $sth->fetch();
            //添加2个严格模式的判断
            if (strpos(strtoupper($model['model']), 'STRICT_TRANS_TABLES') !== false || strpos(strtoupper($model['model']), 'STRICT_ALL_TABLES') !== false) {
                $sqlModel = 'STRICT_TRANS_TABLES';
            }else{
                $sqlModel = 'EASY_TRANS_TABLES';
            }

            $config = file($configFile);

            $f = fopen($configFile, 'w+');
            foreach ($config as $line => $value){
                fwrite($f, $value);
                if($line == '8'){
                    fwrite($f, "'SQL_MODEL' => '{$sqlModel}',\n");
                }
            }
            fclose($f);
        }

        return $sqlModel == 'STRICT_TRANS_TABLES' ? true : false;
    }


    /**
     * 数据保存
     * @param array $param 插入参数(一维数组)
     * @param str $fieldType 字段类型
     * @return str 返回影响行数
     */
    public function update($param = '', $fieldType = '') {
        $noset = $param['noset'];
        unset($param['noset']);
        foreach ($param as $key => $value) {
            $content[] = "`{$key}` = :{$key}";
        }

        if (!empty($noset)) {
            $param = array_merge($param, $noset);
        }

        $param = $this->updateFieldCover($param);
        $this->dealParam($param, $fieldType);

        $this->getLastSql = 'UPDATE ' . $this->tableName . ' SET ' . implode(',', $content) . $this->where;
        $sth = $this->PDOBindArray();
        $result = $sth->rowCount();
        $this->emptyParam();
        if ($result >= 0) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 对执行更新的参数进行一次缺省值转行
     * @param $param
     * @return mixed
     */
    private function updateFieldCover($param){
        if($this->checkSqlTransTable() == false){
            return $param;
        }
        $sth = $this->dbh->prepare("DESC {$this->tableName}");
        $sth->execute();
        $fields = $sth->fetchAll();

        foreach ($fields as $fieldItem) {
            if(isset($param[$fieldItem['Field']]) && empty($param[$fieldItem['Field']]) && !is_numeric($param[$fieldItem['Field']]) ){
                $param[$fieldItem['Field']] = $this->handleFiledType($fieldItem['Type'], $fieldItem['Default'], $fieldItem['Null']);
            }
        }

        return $param;
    }

    /**
     * 删除单条数据
     * @param array $param 插入参数(一维数组)
     * @param str $fieldType 字段类型
     * @return str 返回影响行数
     */
    public function delete($param = '', $fieldType = '') {
        $this->dealParam($param, $fieldType);
        $this->getLastSql = 'DELETE FROM ' . $this->tableName . $this->where;
        $sth = $this->PDOBindArray();
        $result = $sth->rowCount();
        $this->emptyParam();

        if ($result >= 0) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 执行查询SQL语句
     * @param str $sql SQL语句
     * @param array $param 插入参数(二维数组)
     * @param str $fieldType 字段类型
     * @return str 返回一维数组
     */
    public function fetch($sql, $param = '', $fieldType = '') {
        $this->dealParam($param, $fieldType);
        $this->getLastSql = $sql;
        $sth = $this->PDOBindArray();
        $result = $sth->fetch();
        $this->emptyParam();
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 执行查询SQL语句
     * @param str $sql SQL语句
     * @param array $param 插入参数(二维数组)
     * @param str $fieldType 字段类型
     * @return str 返回二维数组
     */
    public function getAll($sql, $param = '', $fieldType = '') {
        $this->dealParam($param, $fieldType);
        $this->getLastSql = $sql;
        $sth = $this->PDOBindArray();
        $result = $sth->fetchALL();
        $this->emptyParam();
        if (!empty($result)) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * 执行插入/更新/删除SQL语句
     * @param str $sql SQL语句
     * @param array $param 插入参数(二维数组)
     * @param str $fieldType 字段类型
     * @return str 返回影响行数
     */
    public function query($sql, $param = '', $fieldType = '') {
        $this->dealParam($param, $fieldType);
        $this->getLastSql = $sql;
        $sth = $this->PDOBindArray();
        $statistics = $sth->rowCount();
        $this->emptyParam();
        $lastInsertId = $this->getLastInsert  = $this->dbh->lastInsertId();
        if (!empty($lastInsertId)) {
            return $lastInsertId;
        } elseif ($statistics >= 0) {
            return $statistics;
        } else {
            return false;
        }
    }

    /**
     * 用于执行数据库操作
     * @param array $param 插入参数(二维数组)
     * @param str $fieldType 字段类型
     * @return str 返回影响行数
     */
    public function alter($sql, $param = '', $fieldType = '') {
        $this->dealParam($param, $fieldType);
        $this->getLastSql = $sql;
        $sth = $this->PDOBindArray();
        if ($sth === false) {
            return false;
        } else {
            return $sth;
        }
    }

    /**
     * 处理一维参数
     * @param type $param 参数
     * @param type $fieldType 字段类型
     * @return boolean 返回一个数组变量
     */
    private function dealParam($param = '', $fieldType = '') {
        //分析参数绑定
        if (is_array($param)) {
            $array = $param;
        } elseif (empty($param)) {
            return true;
        } else {
            $this->returnError([
                'msg' => '参数绑定只能为数组',
                'string' => '参数绑定只能为数组'
            ]);
        }
        //分析字段设置
        if (is_string($fieldType)) {
            $fieldTypeArray = explode(',', $fieldType);
        } else {
            $this->returnError([
                'msg' => '字段类型只能为字符串',
                'string' => '字段类型只能为字符串'
            ]);
        }

        if (empty($fieldType)) {
            foreach ($array as $key => $value) {
                $this->param[$key]['value'] = $value;
                $this->param[$key]['fieldType'] = 2;
            }
            return $this->param;
        }

        $arrayLength = count($array);
        if ($arrayLength != count($fieldTypeArray)) {
            $this->returnError([
                'msg' => '参数绑定与字段设置长度不一致',
                'string' => '参数绑定与字段设置长度不一致'
            ]);
        }

        $i = 0;
        foreach ($array as $key => $value) {
            $this->param[$key]['value'] = $value;
            $this->param[$key]['fieldType'] = $fieldTypeArray[$i];
            $i++;
        }
        return $this->param;
    }

    /**
     * 对SQL进行预处理
     * @return type 返回PDO预处理的对象
     */
    public function PDOBindArray() {
        try {
            $sth = $this->dbh->prepare($this->getLastSql);
            if (!empty($this->param)) {
                foreach ($this->param as $key => $value) {
                    $sth->bindValue(':' . $key, $value['value'], $value['fieldType']);
                }
            }
            $sth->execute();
            return $sth;
        } catch (\PDOException $e) {
            $this->returnError([
                'msg' => $e->getMessage(),
                'string' => $e->getTraceAsString()
            ]);
        }
    }

    /**
     * 返回错误信息
     * @param $data
     */
    private function returnError($data){
        $this->errorInfo['message'] = $data['msg'];
        $this->errorInfo['string'] = $data['string'];
        \Core\Abnormal\Error::errorSql();
    }

    /**
     * 清空绑定的参数
     */
    public function emptyParam() {
        if (DEBUG == TRUE) {
            if (!empty($this->param)) {
                foreach ($this->param as $key => $value) {
                    $placeholder[] = ":{$key}";
                    $paramValue[] = "'{$value['value']}'";
                }
                $this->getLastSql = str_replace($placeholder, $paramValue, $this->getLastSql);
            }
        }
        $this->field = '*';
        $this->where = '';
        $this->join = array();
        $this->order = '';
        $this->group = '';
        $this->limit = '';
        $this->param = array();
    }

    /**
     * 暴露PDO的exec执行方法 | 本方法不推荐使用。
     * @param $sql 要执行的SQL语句
     * @return int
     */
    public function exec($sql){
        return $this->dbh->exec($sql);
    }

    /**
     * 启动事务
     */
    public function transaction() {
        $this->transaction = true;
        return $this->dbh->beginTransaction();
    }

    /**
     * 事务回滚
     */
    public function rollBack() {
        if($this->transaction === true){
            return $this->dbh->rollBack();
        }
    }

    /**
     * 提交事务
     */
    public function commit() {
        return $this->dbh->commit();
    }

}
