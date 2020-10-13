<?php
    class conexion {
        private $Host = "";
        private $User = "";
        private $Password = "";
        private $DataBase = "";
        private $Connection = "";

        //Metódo contructor = construir
        public function __construct () {
            $this-> Host = "localhost";
            $this-> User = "root";
            $this-> Password = "";
            $this-> DataBase = "sakila";
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