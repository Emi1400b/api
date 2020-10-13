<?php
    require ('actorBL.php');

    class actorServe {
        private $actorDTO;
        private $actorBL;

        public function __construct(){
            $this->actorDTO = new actorDTO();
            $this->actorBL = new actorBL();
        }

        public function READ($Id) {
            $this->actorDTO = $this->actorBL->Read($Id);
            echo json_encode($this->actorDTO, JSON_PRETTY_PRINT);
        }
    }

    $obj = new actorServe();


    //print_r($_SERVER);
    //método empleado para acceder a una petición
    $variable = $_SERVER['REQUEST_METHOD'];

    switch ($variable) {
        case 'GET':
            {
                //param=para obtener id, que quiero recuperar
                //si el param esta vacío
                if(empty($_GET['param'])) {
                    $obj->READ(0);
                }
                else
                {
                    if(is_numeric ($_GET['param']))
                    {
                        $obj->READ($_GET['param']);
                    }
                    else
                    {
                        $actorDTO = new ActorDTO();
                        $actorDTO->Response = array('CODE'=>"ERROR", 
                                                    'TEXT'=>"EL PARAMETRO DEBERA SER NUMERICO");
                        echo json_encode($actorDTO->Response);
                    }
                }
                 
            break;
            }
        case 'POST':
            {
                parse_str(file_get_contents('php://input'), $_POST);
                print_r($_POST);
                break;
            }
        case 'PUT':
            {
                parse_str(file_get_contents('php://input'), $_PUT);
                print_r($_PUT);
                break;
            }
        default:
            {
                echo ($_GET["param"]);
                break;
            }
    }
?>