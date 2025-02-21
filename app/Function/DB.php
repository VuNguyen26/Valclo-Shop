<?php
class DB {
    public $connect;
    protected $servername = "localhost";
    protected $username = "root";
    protected $password = "";
    protected $dbname = "web_db";

    function __construct() {
        // Kết nối MySQL
        $this->connect = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        // Kiểm tra kết nối
        if ($this->connect->connect_error) {
            die("❌ Connection failed: " . $this->connect->connect_error);
        }

        // Thiết lập bộ mã ký tự
        if (!$this->connect->set_charset("utf8mb4")) {
            die("❌ Error loading character set utf8mb4: " . $this->connect->error);
        }
    }
}
?>
