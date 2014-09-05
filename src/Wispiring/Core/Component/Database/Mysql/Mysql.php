<?php
namespace Wispiring\Core\Component\Database\Mysql;

class Mysql
{
    private $db_host;
    private $db_user;
    private $db_pwd;
    private $db_name;
    private $conn;
    private $charset;
    /**
    构造函数

    */

    public function __construct($db_host, $db_user, $db_pwd, $db_name, $charset)
    {
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pwd  = $db_pwd;
        $this->db_name = $db_name;
        $this->charset = $charset;
        $this->connect();
        $this->selectDb($this->db_name);
    }
    /**链接数据库

    */

    private function connect()
    {
        $this->conn = mysql_connect($this->db_host, $this->db_user, $this->db_pwd);
        mysql_set_charset($this->charset);
    }
    /**选择数据库

    */

    public function selectDb()
    {
        $db = mysql_select_db($this->db_name);
        if (!$db) {
            echo '数据库不存在';
        }
    }
    /**发送SQL语句

    */

    public function query($sql)
    {
        if ($sql == "") {
            echo 'SQL语句错误';
        }
        return mysql_query($sql);

    }
    /**查询所有信息

    */

    public function selectAll($sql)
    {   
        $rs = $this->query($sql);
        if (!$rs) {
            return false;
        }
        while ($row = mysql_fetch_array($rs)) {
            $list[] = $row;
        }
        return $list;
    }
    /**查询单条信息

    */

    public function selectRow($sql)
    {
        $rs = $this->query($sql);
        if (!$rs) {
            return false;
        }
        return mysql_fetch_row($rs);
    }

    public function insert($sql)
    {
        $this->query($sql);
    }

    /**删除操作

    */

    public function delete($table, $condition, $url = '')
    {
        $this->query("DELETE FROM $table WHERE $condition=$url");
    }

    /**析构函数.关闭数据库资源

    */

    public function __destruct()
    {
        mysql_close($this->conn);
    }
}

