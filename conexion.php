<?php
    class conexion {
        private $Host = "";
        private $User = "";
        private $Password = "";
        private $DataBase = "";
        private $Connection = "";

        //Metódo contructor = construir
        public function __construct () {
            $this-> Host = "us-cdbr-east-02.cleardb.com";
            $this-> User = "bf11ce3b5f3ba1";
            $this-> Password = "3c54d0e4";
            $this-> DataBase = "heroku_4abfbfa22768ec4";
        }

        public function OpenConnection(){
            //La conexión se realizó correctamente
            try {
                $this-> Connection = new PDO("mysql:host={$this->Host}; dbname={$this->DataBase}", $this->User,$this->Password);
                $this->Connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            //Si existe algún error
            catch(PDOException $e)
            {
                $this->Connection = false;
            }
        }

        public function closeConnection(){
            mysql_close($this->Connetion);
        }

        public function getConnection(){
            return $this->Connection; 
        }
    }

    /* instanciar objeto
    $obj = new conexion();
    $obj-> OpenConnection();
    if($obj-> getConnection())
        echo "Ok"; 
    */
?>