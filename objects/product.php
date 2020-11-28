<?php
class Product{
    private $conn;
    private $table_name = "products";
    public $id;
    public $name;
    public $price;
    public $description;
    public $category_id;
    public $timestamp;
  
    public function __construct($db){
        $this->conn = $db;
    }
  
    public function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    name=:name, price=:price, description=:description, category_id=:category_id, created=:created";
  
        $stmt = $this->conn->prepare($query);
        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->price=htmlspecialchars(strip_tags($this->price));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->category_id=htmlspecialchars(strip_tags($this->category_id));
        $this->timestamp = date('Y-m-d H:i:s');
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":created", $this->timestamp);
  
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
  
    }
    public function readAll($from_record_num, $records_per_page){
  
        $query = "SELECT
                    id, name, description, price, category_id
                FROM
                    " . $this->table_name . "
                ORDER BY
                    name ASC
                LIMIT
                    {$from_record_num}, {$records_per_page}";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        return $stmt;
    }
    // used for paging products
    public function countAll(){
      
        $query = "SELECT id FROM " . $this->table_name . "";
      
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
      
        $num = $stmt->rowCount();
      
        return $num;
    }
}
?>