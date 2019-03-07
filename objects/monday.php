<?php 

class Monday{

    //database connection and table name.
    private $conn;
    private $table_name = "Monday";

    // object properties.
    public $id;
    public $reps;
    public $exercise;
    public $price;
    public $category_id;
    public $category_name;
    public $created;

    // constructo with $db as database connection.
    public function __construct($db){
        $this->conn = $db;
    }

    //read products.
    function read(){

        //select all query.
        $query = "SELECT reps, exercise FROM ".$this->table_name;
        
        //prepare query statement.
        $stmt = $this->conn->prepare($query);

        //execute query statement.
        $stmt->execute();
        return $stmt;
    }

    // create product
    function create(){
    
        // query to insert record
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    reps=:reps, exercise=:exercise, created=:created";
    
        // prepare query
        $stmt = $this->conn->prepare($query);
    
        // sanitize
        $this->reps=htmlspecialchars(strip_tags($this->reps));
        $this->exercise=htmlspecialchars(strip_tags($this->exercise));
        $this->created=htmlspecialchars(strip_tags($this->created));
    
        // bind values
        $stmt->bindParam(":reps", $this->reps);
        $stmt->bindParam(":exercise", $this->exercise);
        $stmt->bindParam(":created", $this->created);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
    
        return false;
        
    }

    // used when filling up the update product form.
    function readOne(){

        // query to read single record.
        $query = "SELECT
        reps, exercise FROM ". $this->table_name." WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        //bind id of product to be updated.
        $stmt->bindParam(1,$this->id);

        //execute query.
        $stmt->execute();

        //get retrieved row.
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // set values to object properties.
        $this->reps = $row['reps'];
        $this->exercise = $row["exercise"];
    }

    //update the product
    function update(){
        // update query
        $query = "UPDATE ".$this->table_name."
        SET 
            reps = :reps,
            exercise = :exercise,
        WHERE
            id = :id";

        //prepare query statement.
        $stmt = $this->conn->prepare($query);

        //sanitize.
        $this->reps = htmlspecialchars(strip_tags($this->reps));
        $this->exercise = htmlspecialchars(strip_tags($this->exercise));
        $this->id = htmlspecialchars(strip_tags($this->id));

        //bind new values.
        $stmt->bindParam(':reps', $this->reps);
        $stmt->bindParam(':exercise', $this->exercise);
        $stmt->bindParam(':id', $this->id);

        // execute query.
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function delete(){
        
        //delte query.
        $query = "DELETE FROM ".$this->table_name." WHERE id = ?";
        var_dump($this->id);
        //prepare query.
        $stmt = $this->conn->prepare($query);

        //sanitize.
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete.
        $stmt->bindParam(1, $this->id);

        //execute query.
        if($stmt->execute()){
            return true;
        } 

        return false;
    }

}
