<?php


  class Car {
    private $db;

    public function __construct(){
        # set db conn
            $this->db = new Database;
    }

    // insert new car in DB
    public function createCar($data){
            # check for data errors, if there are 0 proceed
            if($data['error'] == 0 ){
                $manufacturer = htmlspecialchars(strip_tags($data['manufacturer']));
                $model = htmlspecialchars(strip_tags($data['model']));
                $model_year = htmlspecialchars(strip_tags($data['model_year']));
                $engine = htmlspecialchars(strip_tags($data['engine']));
                $fuel_type = htmlspecialchars(strip_tags($data['fuel_type']));
                $hybrid = htmlspecialchars(strip_tags($data['hybrid']));
                $four_by_four = htmlspecialchars(strip_tags($data['four_by_four']));
                $auto_gearbox = htmlspecialchars(strip_tags($data['auto_gearbox']));

                
                $this->db->query('INSERT INTO '. CARS_TABLE .'(manufacturer, model, model_year, engine, fuel_type, hybrid, four_by_four, auto_gearbox) VALUES(:manufacturer, :model, :model_year, :engine, :fuel_type, :hybrid, :four_by_four, :auto_gearbox)');
                
                $this->db->bind(':manufacturer', $manufacturer, PDO::PARAM_STR);
                $this->db->bind(':model', $model, PDO::PARAM_STR);
                $this->db->bind(':model_year', $model_year, PDO::PARAM_STR);
                $this->db->bind(':engine', $engine, PDO::PARAM_STR);
                $this->db->bind(':fuel_type', $fuel_type, PDO::PARAM_STR);
                $this->db->bind(':hybrid', $hybrid, PDO::PARAM_STR);
                $this->db->bind(':four_by_four', $four_by_four, PDO::PARAM_STR);
                $this->db->bind(':auto_gearbox', $auto_gearbox, PDO::PARAM_STR);

                # execute
                if($this->db->execute()){
                    return true;
                } else {
                    return false;
                }
                
            }else{
                return false;
            }

    }

    
    // update cars
    public function updateCar($data, $car_id){

        // prepare data send from the POST REQ

        # get fields with values from data 

        // print_r($data);
        # make array that will hold the query for update with fields and values
        $updateFieldsWithValueArray = array();
        foreach ($data as $key => $value){
            // $updateFieldsArray[$key] = $key;
            $updateFieldsWithValueArray[$key] =  $key . ' = "' . $value . '"';
        }

        # explode fields with values from array to string so we can make the query
        $queryString = implode(',', $updateFieldsWithValueArray);
        
        // echo $queryString;exit;
        # make query and update
        $this->db->query(' UPDATE ' . CARS_TABLE . ' SET ' . $queryString . ' WHERE id = :car_id');
        $this->db->bind(':car_id', $car_id);

        if ( $this->db->execute() ){
            return true;
        }else{
            return false;
        }
        
        
        
    }

    // delete car function -- update row deleted = 1;
    public function deleteCar($data){
        //
        if($data['error'] == 0){

            $car_id = htmlspecialchars(strip_tags($data['car_id']));

            // check if car id exists
            # TO DO -> check if row exists
            // $this->db->query('SELECT `id` FROM '. CARS_TABLE . '');
           $this->db->query('UPDATE ' . CARS_TABLE . ' SET deleted = 1 WHERE id = :car_id');
            
           $this->db->bind(':car_id', $car_id);

            # execute
            if($this->db->execute()){
                if ( $this->db->rowCount() >= 1 ){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }else{

            return false;
        }
        
    }

    // show all cars with fields
    public function showCars(){
        
        $this->db->query('SELECT * FROM '. CARS_TABLE . ' WHERE `deleted` = 0');

        $result = $this->db->getAll();

        if ( !empty($result) ){

            return array(
                'success' => true,
                'data'    => $result
            );

        }else{

            return false;

        }
    }

    public function showSingle($car_id){

        $this->db->query('SELECT * FROM '. CARS_TABLE . ' WHERE  id= :car_id');
        $this->db->bind(':car_id', $car_id);

        $result = $this->db->getSingle();

        if ( !empty($result) ){

            return array(
                'success' => true,
                'data'    => $result
            );

        }else{

            return false;

        }
    }

    // show cars pagination and sorting
    public function showCarsPagination($limit, $offset){

        echo $offset;

        $this->db->query('SELECT * FROM '. CARS_TABLE . ' WHERE `deleted` = 0 LIMIT '. $limit . ' OFFSET ' .$offset );
        $result = $this->db->getAll();

        if ( !empty($result) ){
            return array(
                'success' => true,
                'data'    => $result
            );

        }else{
            return false;
        }

    }

    public function showCarsSort($sortKey){

        $this->db->query('SELECT * FROM '. CARS_TABLE . ' WHERE `deleted` = 0 ORDER BY ' . $sortKey . ' DESC');
        $result = $this->db->getAll();

        if ( !empty( $result ) ){
            return array(
                'success' => true,
                'data'    => $result
            );
        }else{
            return false;
        }

    }
    
    // #HELPERS FUNCTIONS
    
    // check if id of car exists
    public function checkIDexists($car_id){
        $this->db->query('SELECT `id` FROM ' . CARS_TABLE . ' WHERE `id` = ' .$car_id);
        $this->db->getSingle();

        if( $this->db->rowCount() >= 1){
            return true;
        }else{
            return false;
        }
    }

    // get cars table structure 
    public function getCarStructureMYSQL(){
        $this->db->query('DESCRIBE '. CARS_TABLE);
        $result = $this->db->getAll();

        return $result;

    }

}