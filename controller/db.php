<?php


class DBHelper{
    protected $connection;
    public function __construct($host, $user, $password, $db_name) {
        $this->connection = new mysqli($host, $user, $password, $db_name);
        $this->query("SET NAMES UTF8");
        if( !$this->connection ) {
            throw new Exception('Подключение не выполнено');
        }

        $showTable = "SHOW TABLES LIKE 'images'";
        
        if(!$this->query($showTable)){
			$create = "CREATE TABLE IF NOT EXISTS images (
			`id` int(11) AUTO_INCREMENT PRIMARY KEY,
			`name` varchar(250) DEFAULT NULL,
			`path` varchar(250) DEFAULT NULL
			)
			ENGINE = INNODB DEFAULT CHARACTER SET = utf8 COLLATE = utf8_general_ci;";
			$this->query($create);
		}
    }
    public function query($sql){
        if ( !$this->connection ){
            return false;
        }
        $result = $this->connection->query($sql);
        if ( mysqli_error($this->connection) ){
           throw new Exception(mysqli_error($this->connection));
        }
        if ( is_bool($result) ){
            return $result;
        }
        $data = array();
        while( $row = mysqli_fetch_assoc($result) ){
            $data[] = $row;
        }
        mysqli_free_result($result);
        return $data;
    }
}