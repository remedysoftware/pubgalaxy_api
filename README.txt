# PUBGALAXY API #

--------- TECHNOLAGIES --------

------ DATABASE --------------
Every configuration for the DB is in folder app->config-> config.php
Under // DB Params there are 4 constantst hat i define 
	- DB_HOST -> change them to config the DB environment
	- DB_USER -> change them to config the DB environment
	- DB_PASS -> change them to config the DB environment
	- DB_NAME -> change them to config the DB environment
After that there is another constant:
	- CARS_TABLE -> this store the table name, if need to change, change it here.

In the zip file i am sending you cars.sql that you need to import in DB;



------- SOURCE CODE PREPARING -------------
The app will run without any other configs unless you have to change the root folder name ( in my project is pubgalaxy_api ) . If change is needed
you have to open .htaccess that is in folder ->pubgalaxy_api->public-> . htaccess and you need to change LINE 4:
	: LINE 4 ->  RewriteBase /pubgalaxy_api/public - here i am telling the server to route thru /pubgalaxy_api/public -> and if you change the root to kristiyan_task just change 
		     /pubgalaxy_api/ TO ->   /kristiyan_task/


------- HOW TO RUN IT --------------------
Extract files on your server and the urls for the api will be the same as the methods in the Cars.php Controller ( folder: app->controllers). Examples:
	https://__site_name/pugbalaxy_api/cars/create
	https://__site_name/pugbalaxy_api/cars/delete/{car_id}
	https://__site_name/pugbalaxy_api/cars/index
	and etc.

------- PROJECT STRUCUTRE -----------------
  
   #MAIN
   There are 3 base classes that run the app. They are in folder app->libraries :
	-Core.php -> this class gets url params. If we have url like this : cars/index/1 -> it will search for controller with name Cars.php in folder Controller, after that will search for
		     method index in the class and after that will send param 1 to the method. This is the base class that is routing the app. ( its custom made by me )
		     EXAMPLE-> if we have controller with name posts.php and in this controller we have method call show_posts() -> the url will looke like this:
				-> https://_site_name/pubgalaxy_api/posts/show_posts

	-Databese.php -> this class create PDO connection to my DB ( configs are in app->config->config.php ). And i have createad custom functions to help me ( getAll -> fetch everything as
		     object, getSingle()-> fetch 1 row and etc) - ( its also custom made by me ) 
	-Controller.php -> this BASE CONTROLLER is extended by every class/controller in folder app->controller->  . There is only one method in the base controller -> function model()
		     where i send model name as string, search for the existence of the model and return it as new OBJ;

	Everything is included in the boostrap.php. After that this file is included  in public->index.php where i also init the Core -> $core = new Core();

   #API FILES
   The API has 2 main files:
	-Cars.php -> ( folder: app->controllers )this is the controller from where i get the information from REQUESTS - POST/ GET after that i prepare it and send it to the Model - Car.php ( app->models->Car.php)
	-Car.php  -> ( folder: app->models)   that is the model that i connect with my Database.php base class and execute all queries that are needed.




   #API LOGIC 
	- POST /create -> this is method in Cars.php - the main function is to see if there is a POST request to the url, if there is one , the method will prepare POST FIELDS. There are some checks that i run:
		-> if POST field is empty it will set data['error'] + = 1.
		-> after fields check, i store the data in data = array(); and send them to the controller that i have initialization in the Cars.php constructor ;
		-> after we send information, the model ( car.php-> method: createCar ) will add to all data array values htmlspecialhars and strip_tags to ensure security and after that will make db->query INSERT to insert data in DB;
		-> if everything is fine it will return TRUE, and the controller will send http_response_code = 200


	- POST / update -> this method in Cars.php will check first if there is an POST REQUEST send to the url. IF there is one checks for $_POST['id'] to be set ( this is the id of the car that i need to update ).
			   After that i call model function checkIdExists to see if ID exists in DB. If everything is fine i make a foreach of the fields from the post ( i do this, couze i dont need to set every field in the post request to update, sometimes i need
		           to update only one field , so i createad a base logic for this ). After the POST FIELDS FOREACH the function will compare fields from the post with the fields from the DB structure. The fields from the DB is custom model function getCarsStructureMysql()
			   If the fields name from POST exists and are the same as the fields names in DB STRUCTURE then set an array with all the keys( fields) and values ( values from post) and send them to the model method -> updateCar($fields, $car_id) and the method
			   will do the update
	
	- GET /delete   -> this is method in Cars.php that will get parameter from url ( parameter = car ID /  pubgalaxy_api/cars/delete/{car_ID} ) and will send it to the model method->deleteCar ( this method will not delete the row , it will update it to delete = 1 and will not show it )

	- GET /index    -> this is method in Cars.php that if there is GET request will call model method -> showCars and will retrive everything from table cars WHERE `deleted` = 0

	- GET / single  -> this is method in Cars.php that will return single car row by ID from the URL

	- GET /indexPage -> this is method in Cars.php and it will get parameter from the url ( parameter = page ). After this will create $limit and $ofset and will send it to the model method->showCarsPagination($limit,$offset) it will make query with limit and offset to
			   show everything that is deleted = 0 with limit $limit an offset $offset
	- GET /sortCarsBy -> this is method in Cars.php that will get the parameter from the url ( parameter = $sortKey ) . The sort key is field name from DB structure that we want to sort by. I use the same logic as /update, check if the $sortKey is an existing field name in DB,
			   if it exists i send it to model->method->showCarsSort() and do the queries.

	# i have also 2 helpers function the model 
		-checkIDexists - checking the ID of the row exists
		-getCarStructureMYSQL -> get the table structure 

	
    #THINGS MISSINGS 
	The only thing that i didnt do is the AUTH.

----- ENDING -------
In the zip file i will include -sourceode ( folders ) , cars.sql ( db ) and all of my POSTMAN REQUESTS as JSON.
Need only to change POSTMAN URLS ( http:// [ pubgalaxy.remedysoftware.eu ] to-> http:// [ your_site_name / server ]  , because i used mine ( http://pubgalaxy.remedysoftware.eu/pubgalaxy_api/cars/create , 'pubgalaxy.remedysoftware.eu' -> this is my working host that i am using from 2 years )









    
   

