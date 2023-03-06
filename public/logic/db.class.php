<?php
    class DATEBASE{

        public function connect( $host = 'project_db',
         $port = '3306', 
         $dbname = 'blog_data', 
         $username = 'root', 
         $password = 'secret'){
            try{
                $connection = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$dbname,
                    $username,$password);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);


                $sq = 'SHOW TABLES FROM ' . $dbname. ' LIKE "posts"';
                $stm = $connection->prepare($sq);
                $stm->execute();
                if ($stm==0){
                    $connection->query("CREATE TABLE posts(
                        id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(60) NOT NULL,
                        content VARCHAR(500) NOT NULL,
                        img LONGBLOB,
                        created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
                        updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
                    );");
                }
                return $connection;
            } catch(PDOException $e){
                return  "<h3 class='container bg-dark p-3 text-center text-warning rounded-lg mt-5'>Database Error:".
                $e->getMessage()."<h3>";

            }
        }

        public function getPost() {
            $sql = "SELECT * FROM posts";
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute();
        
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($result as &$post) {
                ?>

                <a class="card m-3 py-3 overflow-hidden" style="width: 30rem;" href="view.php?id=<?= $post['id'] ?>">
                <?php 
                    if ($post['img']){
                        echo '<img class="card-img-top" src="data:image/jpeg;base64,'.base64_encode( $post['img'] ).'"/>';
                    }
                ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= $post['title']?></h5>
                        <p class="card-text"><?= (strlen($post['content'])<50) ? 
                                mb_substr($post['content'], 0, 50, 'UTF-8') :  
                                mb_substr($post['content'], 0, 50, 'UTF-8')."..."?></p>
                        <p class="card-text"><small class="text-muted"><?= $post['created_at'] ?></small></p>
                    </div>
                </a>
            <?php
            }
          }
        
        public function addPost($title, $content, $img) {
        $sql = "INSERT INTO posts (title, content, img) VALUES (?, ?, ?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$title, $content, $img]);
        }
    
        public function editPost($id) {
        $sql = "SELECT * FROM posts WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
    
        return $result;
        }
    
        public function updatePost($id, $title, $content, $img) {
        $sql = "UPDATE posts SET title = ?, content = ?, img = ?, updated_at = ? WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $updated = date("Y-m-d H:i:s");
        $stmt->execute([$title, $content, $img, $updated, $id]);
        }
    
        public function delPost($id) {
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$id]);
        }
        
    }

?>