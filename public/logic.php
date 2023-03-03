<?php
    class DATEBASE{
        private $host = 'project_db';
        private $port = '3306';
        private $dbname = 'blog_data';
        private $username = 'root';
        private $password = 'secret';
        private $conn;

        public function __construct(){
            try{
                $this->conn = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname,
                    $this -> username,$this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if ($this->existsTable('Posts')){
                    $this->conn->exec("CREATE TABLE Posts(
                        id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(60) NOT NULL,
                        content VARCHAR(500) NOT NULL,
                        img LONGBLOB,
                        created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
                        updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
                    )");
                }

            } catch(PDOException $e){
                echo "<h3 class='container bg-dark p-3 text-center text-warning rounded-lg mt-5'>Database Error:".
                $e->getMessage()."<h3>";
            }
        }

        public function addPost($title, $content, $img){

            $sql = "INSERT INTO Posts (title, content, img)
                        VALUES ($title, $content, $img)";
            try{
                $this -> conn->exec($sql);
                echo "New record created successfully";
            } catch(PDOException $e){
                echo "<h3 class='container bg-dark p-3 text-center text-warning rounded-lg mt-5'>Database Error:".
                $e->getMessage()."<h3>";
            }
        }

        private function existsTable($table){

        $sql = 'SHOW TABLES FROM ' . $this->dbname. ' LIKE "'. $table .'"';
            if (count($this->conn->exec($sql))==1){
                return true; 
            }
            else{
             return false; 
     
            }
          

        echo $databaseTables;
        if ($databaseTables) {

            if (count($databaseTables) == 1) {
                return true; 
            } else {
                return false; 
            }
        }
    }
    }
    

    // // Get data to display on index page
    // $query = $conn->query( "SELECT * FROM blog_data");

    // // Create a new post
    // if(isset($_REQUEST['new_post'])){
    //     $title = $_REQUEST['title'];
    //     $content = $_REQUEST['content'];

    //     $sql = "INSERT INTO blog_data(title, content) VALUES('$title', '$content')";
    //     $conn->query( $sql);

    //     echo $sql;

    //     header("Location: index.php?info=added");
    //     exit();
    // }

    // // Get post data based on id
    // if(isset($_REQUEST['id'])){
    //     $id = $_REQUEST['id'];
    //     $sql = "SELECT * FROM blog_data WHERE id = $id";
    //     $query = $conn->query( $sql);
    // }

    // // Delete a post
    // if(isset($_REQUEST['delete'])){
    //     $id = $_REQUEST['id'];

    //     $sql = "DELETE FROM blog_data WHERE id = $id";
    //     $conn->query( $sql);

    //     header("Location: index.php");
    //     exit();
    // }

    // // Update a post
    // if(isset($_REQUEST['update'])){
    //     $id = $_REQUEST['id'];
    //     $title = $_REQUEST['title'];
    //     $content = $_REQUEST['content'];

    //     $sql = "UPDATE blog_data SET title = '$title', content = '$content' WHERE id = $id";
    //     $conn->query( $sql);

    //     header("Location: index.php");
    //     exit();
    // }

?>