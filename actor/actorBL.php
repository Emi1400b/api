<?php
    require ('../DTO/actorDTO.php');
    require ('../conexion.php');

    class actorBL {
        private $conn;
        
        //Esta definiendo un metodo
        //Esta creando un objeto de la clase conexión
        //Hace referencia a la línea 9 de coneexion.php
        public function __construct() {
            $this -> conn = new conexion(); 
        }

        public function create($actorDTO) {

            //objeto de tipo conexion
            //Invocación de método
            $this -> conn -> OpenConnection();

            //de tipo PDO->apunta al mismo lugar de la clase conexión
            $connsql = $this -> conn -> getConnection();
            $lastInsertId = 0;
            
            try{


                //Validar la conexión(Inserción)
                if($connsql) {

                    //Empezar transacción
                    $connsql -> beginTransaction();

                    //Realiza el insert/ sentencia SQL
                    $sqlStatment = $connsql -> prepare(
                        "INSERT INTO actor VALUES(
                            default,
                            :first_name,
                            :last_name,
                            current_date
                        )"
                    );

                    //Asigna los valores, haciendo uso de los parametros de la clase DTO
                    $sqlStatment -> bindParam(':first_name', $actorDTO->Nombre);
                    $sqlStatment -> bindParam(':last_name', $actorDTO->Apellidos);
                   
                    //Ejecutar
                    $sqlStatment -> execute();


                    $lastInsertId = $connsql -> lastInsertId();
                    
                    //commit = para realizar la transacción
                    $connsql -> commit();
                }


            } catch(PDOException $e) {
                //Cancela la transacción o se sale
                $connsql -> rollBack();
                //echo $e;
            }
            //Devuelve si algo sale mal =0 y si no el id
            return $lastInsertId;
        }


        public function Read($Id) {
            $this->conn->OpenConnection();
            $connsql = $this->conn->getConnection();
            $arrayActor = new ArrayObject();
            $SQLQuery = "SELECT * FROM actor";
            $actorDTO = new actorDTO();
            //Si el id no lleva valor se regresan todos
            //pero si se envia id es mayor a 0 se regresa especificamente lo de ese id
            if($Id > 0)
                $SQLQuery = "SELECT * FROM actor WHERE actor_id = {$Id}";
            
            try {
                    if($connsql) {
                        foreach($connsql->query($SQLQuery) as $row)
                        {
                            $actorDTO = new actorDTO();
                            $actorDTO->Id = $row['actor_id'];
                            $actorDTO -> Nombre = $row['first_name'];
                            $actorDTO -> Apellidos = $row['last_name'];
                            $arrayActor->append($actorDTO);
                        }
                    }
            } catch(PDOException $e) {
                //En caso de que falle
            }
            return $arrayActor;
        }

        public function Update($actorDTO) {
            $this->conn->OpenConnection();
            $connsql = $this->conn->getConnection();
            
            try {
                    if($connsql) {
                        $connsql->beginTransaction();
                        $sqlStatment = $connsql->prepare(
                            "UPDATE actor SET 
                                first_name = :first_name,
                                last_name = :last_name,
                                last_update = current_timestamp
                            WHERE actor_id = :id"
                        );
                        $sqlStatment->bindParam(':id', $actorDTO->id);
                        $sqlStatment->bindParam(':first_name', $actorDTO->Nombre);
                        $sqlStatment->bindParam(':last_name', $actorDTO->Apellidos);
                        $sqlStatment->execute();
                        $lastInsertId=$connsql->lastInsertId();
                    
                        $connsql->commit();
                    }
            } catch(PDOException $e) {
                $connsql->rollBack();
                //echo $e;
            }
        }

        public function Delete($Id) {
            $this->conn->OpenConnection();
            $connsql = $this->conn->getConnection();
            
            try {
                    if($connsql) {
                        $connsql->beginTransaction();
                        $sqlStatment = $connsql->prepare(
                            "DELETE FROM actor 
                             WHERE actor_id = {$Id}"
                        );
                        $sqlStatment->bindParam(':id', $Id);
                        $sqlStatment->execute();
                    
                        $connsql->commit();
                    }
            } catch(PDOException $e) {
                $connsql->rollBack();
            }
        }
    }

  
    //Se instancia el obj de la clase DTO
    $actorDTO = new actorDTO();
    //Se instancia el obj de la clase BL
    $actorBL = new actorBL();
    //El objeto va a acceder a una propiedad que se genero al crear una instancia de un obj.
    //En este caso es en la clase DTO.
    //Se asignan valores 
    $actorDTO->id = 201;
    $actorDTO->Nombre = 'Evelyn';
    $actorDTO->Apellidos = 'Baz';
  
    //llamar al metodo create, pasarle el objeto de tipo actorDTO y validar la insercción
    //$actorBL->create($actorDTO);
    //print_r($actorBL->Read(201)); //Para obtener datos de ese id
    //$actorBL->Update($actorDTO); //Actualizar un dato
    $actorBL->Delete(201); //Eliminar dato
?>