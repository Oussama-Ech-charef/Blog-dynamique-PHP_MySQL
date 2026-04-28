<?php


class Article {

    private $conn;


    private $table_name  = "posts";


    public function __construct($db){

        $this->conn = $db;
        
    }


     
     

    public function create($title, $content, $id_user, $id_category,$status, $image_url) {

        $query = "INSERT INTO {$this->table_name}
                     (title, content, id_user, id_category, status, image_url)
                     VALUES (:title, :content, :id_user, :id_category, :status, :image_url)";


        $stmt = $this->conn->prepare($query);


            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':id_user', $id_user);
            $stmt->bindParam(':id_category', $id_category);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':image_url', $image_url);


        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    





}