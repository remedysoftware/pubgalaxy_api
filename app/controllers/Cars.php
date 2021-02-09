<?php


  class Cars extends Controller {
    public function __construct(){
        # set model
        $this->carModel = $this->model('Car');
        // echo __DIR__;
    }   
    // create car row
    public function create(){
        // create new entry in db - cars
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            # get data and check if POST is empty, if empty return data['error] + = 1
            $data = array();
            $data['manufacturer'] = !empty($_POST['manufacturer']) ? $_POST['manufacturer'] : $data['error'] += 1;
            $data['model']        = !empty($_POST['model']) ? $_POST['model'] : $data['error'] += 1;
            $data['model_year']   = !empty($_POST['model_year']) ? $_POST['model_year'] : $data['error'] += 1;
            $data['engine']       = !empty($_POST['engine']) ? $_POST['engine'] : $data['error'] += 1;
            $data['fuel_type']    = !empty($_POST['fuel_type']) ? $_POST['fuel_type'] : $data['error'] += 1;

            //custom check 
            if( isset($_POST['hybrid']) ){
                $data['hybrid'] = $_POST['hybrid'];
            }else{
                $data['error']  += 1;
            }
            if( isset($_POST['four_by_four']) ){
                $data['four_by_four'] = $_POST['four_by_four'];
            }else{
                $data['error']  += 1;
            }
            if( isset($_POST['auto_gearbox']) ){
                $data['auto_gearbox'] = $_POST['auto_gearbox'];
            }else{
                $data['error']  += 1;
            }

            // print_r($data);
            $createNewCar = $this->carModel->createCar($data);

            if($createNewCar){
                http_response_code(200);
                echo json_encode(
                    array("message" => "Your record was created successfully.")
                );
            }else{
                http_response_code(404);
                echo json_encode(
                    array("message" => "Something gone wrong.Please check your inputs")
                );
            }

        }
    }
    // update car
    public function update(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            # get CARS TABLE FIELDS
            $tableCarsGetFields = $this->carModel->getCarStructureMYSQL();

            // update  car fields if there is field in the POST REQUEST

            # check if id is set in the post request
            if ( isset($_POST['id'])){
                $car_id = $_POST['id'];

                # unset car id from POST REQ
                unset($_POST['id']);
                # check if car with this id exists
                $checkCarRowExists = $this->carModel->checkIDexists($car_id);

                # if car id exists proceed
                if ( $checkCarRowExists ){
                    # fields array from the post request
                    $fieldsWithValuesFromPOST  = array();
                    // get fields from POST REQUESTS     
                    foreach($_POST as $field => $value){
                        
                        // check if value is empty do not send it to post model for update
                        # hardcored -> TO DO -> get better logic 
                        if ( '' != $value ){

                            $fieldsWithValuesFromPOST[$field] = htmlspecialchars(strip_tags($value));
                        }
                    }
                    // # check if fields that are set in POST REQUEST  exists in MYSQL TABLE               

                    # array that will hold fields that exists from POST REQ in DB table  -- if exists set key and values
                    $allowedFields = array();

                    for ($i = 0; $i<= count($tableCarsGetFields); $i++){

                        $tableCarsGetFields[$i]->Field;
                        # check if fields set in the post match fields that exists in the table
                        if ( array_key_exists($tableCarsGetFields[$i]->Field, $fieldsWithValuesFromPOST)){
                            // if there is a match set new array with fields and values and proceed -> send data to model and update car 
                            $allowedFields[$tableCarsGetFields[$i]->Field] = $fieldsWithValuesFromPOST[$tableCarsGetFields[$i]->Field];
                        }
                    }

                    // send Fields With Values to model to update
                    $updateCars = $this->carModel->updateCar($allowedFields, $car_id);

                    if ( $updateCars ){
                        http_response_code(200);
                        echo json_encode(
                            array("message" => "Your record was updated successfully.")
                        );
                    }else{
                        http_response_code(404);
                        echo json_encode(
                            array("message" => "ERROR  UPDATING ROW")
                        );
                    }

                }
            }else{
                http_response_code(404);
                echo json_encode(
                    array("message" => "Something gone wrong.Please check your inputs")
                );
            }

        }


    }
    // delete car function -- update row deleted = 1;
    public function delete($car_id){
        //
            if ( isset($car_id) AND $car_id != 0 ){

                $data['car_id'] = $car_id;
                $deleteCar = $this->carModel->deleteCar($data);

                if($deleteCar){
                    http_response_code(200);
                    echo json_encode(
                        array("message" => "Your record was deleted successfully.")
                    );
                }else{
                    http_response_code(404);
                    echo json_encode(
                        array("message" => "Something gone wrong!")
                    );
                }

            }else{
                http_response_code(404);
                echo json_encode(
                    array("message" => "Something gone wrong!")
                );
            }
    }

    // show all cars with fields
    public function index(){
        # show all cars with fields
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $getCars = $this->carModel->showCars();

            // check if success = true
            if ($getCars['success']){
                http_response_code(200);
                echo json_encode(
                    array("result" => $getCars['data'])
                );
            }else{
                http_response_code(404);
                echo json_encode(
                    array("message" => "Something gone wrong!")
                );
            }

        }
    }

    // show single
    public function single($car_id){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            $carID = $car_id;

            if ( $carID > 0 ){
                $carID = htmlspecialchars(strip_tags($carID));
                
                $showSingle = $this->carModel->showSingle($carID);

                if ( $showSingle ){
                    if ($showSingle['success']){
                        http_response_code(200);
                        echo json_encode(
                            array("result" => $showSingle['data'])
                        );
                    }else{
                        http_response_code(404);
                        echo json_encode(
                            array("message" => "Something gone wrong!")
                        );
                    }
                }

            }
        }
    }

    public function indexPage($page){

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            // pagination logic

            # set  config $limit and offset for $query

            if ( $page >= 1){

                $limit = 5;
                $pageNum = $page;
                if ( $pageNum == 1 AND $pageNum != 0 ){
                    $offset = 0;
                }else{
                    $offset  = ($pageNum * $limit) - $limit;

                }

                $showCarsPagination = $this->carModel->showCarsPagination($limit, $offset);

                // check if success = true
                if ($showCarsPagination['success']){
                    http_response_code(200);
                    echo json_encode(
                        array("result" => $showCarsPagination['data'])
                    );
                }else{
                    http_response_code(404);
                    echo json_encode(
                        array("message" => "Page is not found! Page is empty!")
                    );
                }

            }else{
                // if there is no page show everything
                $getCars = $this->carModel->showCars();

                // check if success = true
                if ($getCars['success']){
                    http_response_code(200);
                    echo json_encode(
                        array("result" => $getCars['data'])
                    );
                }else{
                    http_response_code(404);
                    echo json_encode(
                        array("message" => "Something gone wrong!")
                    );
                }
            }




        }
    }

    // show SORTED CARS - it can sort by fields 

    public function sortCarsBy($sortKey){
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        
            // echo $sortKey;
            # to lowercase
            $sortField = strtolower($sortKey);

            //# check if sort key exists in db strucutre fields

            $keyExists = false;
            # table fields
            $tableCarsGetFields = $this->carModel->getCarStructureMYSQL();

            for ($i = 0; $i<= count($tableCarsGetFields); $i++){

                if ( $tableCarsGetFields[$i]->Field == $sortField ){
                    # set key exists = true
                    $keyExists =true;
                }
            }
            # if key exists in db structure
            if ( $keyExists ){
                # send key to model
                $showSortByKey = $this->carModel->showCarsSort($sortField);
                 // check if success = true
                 if ($showSortByKey['success']){
                    http_response_code(200);
                    echo json_encode(
                        array("result" => $showSortByKey['data'])
                    );
                 }

            }else{


            }
        
        }
    }

  }
