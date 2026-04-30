<?php

class Article
{
    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getHomePost()
    {
        $query = "select p.*, c.name as cat_name
        from posts p 
        join categories c on p.category_id = c.id
        where p.status = 'published'
        order by p.created_at desc
        limit 5";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readAllposts()
    {
        $query = "select p.*, c.name AS cat_name
                  from posts p
                  join categories c ON p.category_id = c.id
                  where p.status = 'published'
                  order BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   


    public function detaiById($id) {
        $query = "SELECT p.*, c.name AS cat_name
                  FROM posts p 
                  JOIN categories c ON p.category_id = c.id
                  WHERE p.id = :id AND p.status = 'published'
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function emailExists($email) {
        $query = "select id from users where email = :email";
        $stmt = $this->conn->prepare($query);
        
        $stmt->execute([
            ':email' => $email
            ]
        );
        return $stmt->rowCount() > 0;

    }


    public function createUser($name, $email, $password) {
        $query = "insert into users (name, email, password, role) 
                            values (:name, :email, :password, 'user')";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => $password
        ]);
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':email' => $email
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    

    public function getAllAdmin() {
        $query = "SELECT p.*, c.name AS cat_name 
                  FROM posts p 
                  JOIN categories c ON p.category_id = c.id 
                  ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



     public function getAllCategories() {
        $query = "SELECT * FROM categories ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($title, $category_id, $image, $description, $content, $status) {
        $query = "INSERT INTO posts (title, category_id, image, description, content, status) 
                  VALUES (:title, :category_id, :image, :description, :content, :status)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':status', $status);
        
        return $stmt->execute();
    }

        public function delete($id) {
        $query = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id
        ]);
    }


    public function getByIdAdmin($id) {
        $query = "select * from posts where id = :id ";
        $stmt = $this->conn->prepare($query);
         $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function update($id, $title, $category_id, $image, $description, $content, $status) {
        $query = "update posts
                set title = :title,
                    category_id = :category_id,
                    image = :image, 
                    description = :description,
                    content = :content,
                    status = :status
                where id = :id";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':id' => $id,
            ':title' => $title,
            ':category_id' =>$category_id,
            ':image' => $image,
            ':description' => $description,
            ':content' => $content,
            ':status' => $status
        ]);
        
    }





}