<?php
    class DATEBASE{
        private $connection;
        private $query;
        private $query_closed = TRUE;
        public $query_count = 0;

        public function __construct( $host = 'project_db',
         $port = '3306', 
         $dbname = 'blog_data', 
         $username = 'root', 
         $password = 'secret'){
            try{
                $this->connection = new PDO('mysql:host='.$host.';port='.$port.';dbname='.$dbname,
                    $username,$password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

                if ($this->existsTable($dbname,'Posts')){
                    $this->connection->query("CREATE TABLE Posts(
                        id INT(4) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(60) NOT NULL,
                        content VARCHAR(500) NOT NULL,
                        img LONGBLOB,
                        created_at TIMESTAMP NOT NULL DEFAULT current_timestamp(),
                        updated_at TIMESTAMP NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
                    );");
                }

            } catch(PDOException $e){
                echo "<h3 class='container bg-dark p-3 text-center text-warning rounded-lg mt-5'>Database Error:".
                $e->getMessage()."<h3>";
            }
        }

        public function query($query) {
            if (!$this->query_closed) {
                $this->query->close();
            }
            if ($this->query = $this->connection->prepare($query)) {
                if (func_num_args() > 1) {
                    $x = func_get_args();
                    $args = array_slice($x, 1);
                    $types = '';
                    $args_ref = array();
                    foreach ($args as $k => &$arg) {
                        if (is_array($args[$k])) {
                            foreach ($args[$k] as $j => &$a) {
                                $types .= $this->_gettype($args[$k][$j]);
                                $args_ref[] = &$a;
                            }
                        } else {
                            $types .= $this->_gettype($args[$k]);
                            $args_ref[] = &$arg;
                        }
                    }
                    array_unshift($args_ref, $types);
                    call_user_func_array(array($this->query, 'bind_param'), $args_ref);
                }
                $this->query->execute();
                $this->query_closed = FALSE;
                $this->query_count++;
            }
            return $this;
        }

        
        public function fetchAll($callback = null) {
            $params = array();
            $row = array();
            $meta = $this->query;
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            call_user_func_array(array($this->query, 'bind_result'), $params);
            $result = array();
            while ($this->query->fetch()) {
                $r = array();
                foreach ($row as $key => $val) {
                    $r[$key] = $val;
                }
                if ($callback != null && is_callable($callback)) {
                    $value = call_user_func($callback, $r);
                    if ($value == 'break') break;
                } else {
                    $result[] = $r;
                }
            }
            $this->query->close();
            $this->query_closed = TRUE;
            return $result;
        }

        public function fetchArray() {
            $params = array();
            $row = array();
            $meta = $this->query->result_metadata();
            while ($field = $meta->fetch_field()) {
                $params[] = &$row[$field->name];
            }
            call_user_func_array(array($this->query, 'bind_result'), $params);
            $result = array();
            while ($this->query->fetch()) {
                foreach ($row as $key => $val) {
                    $result[$key] = $val;
                }
            }
            $this->query->close();
            $this->query_closed = TRUE;
            return $result;
        }

        public function addPost($title, $content, $img){
            try{
                $this ->query("INSERT INTO Posts (title, content, img)
                                    VALUES ($title, $content, $img)");
                echo "New record created successfully";
            } catch(PDOException $e){
                echo "<h3 class='container bg-dark p-3 text-center text-warning rounded-lg mt-5'>Database Error:".
                $e->getMessage()."<h3>";
            }
        }
        
        private function existsTable($dbname,$table){
            $sql = 'SHOW TABLES FROM ' . $dbname. ' LIKE "'. $table .'"';
            if ($this ->query('SHOW TABLES FROM ' . $dbname. ' LIKE "'. $table .'"')->fetchArray()==0){
                return true; 
            }
            else{
             return false; 
     
            }
        }
        
        public function listPost () {
            $res = $this ->query("SELECT COUNT(*) FROM `posts`");

            if ($res -> fetchColumn() > 0) {
                while ($resArticle = $res->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                        <div class="col-12 col-lg-4 d-flex justify-content-center">
                            <div class="card text-white bg-dark mt-5" style="width: 18rem;">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $resArticle['title']?></h5>
                                    <p class="card-text"><?= mb_substr($resArticle['text'], 0, 50, 'UTF-8')?>...</p>
                                    <a href="view.php?id_article=<?= $resArticle['id'] ?>" class="btn btn-light">Read More <span class="text-danger">&rarr;</span></a>
                                </div>
                            </div>
                        </div>
                    <?php
                }
            } else {
                echo "Нет статей";
            }
        }

        public function close() {
            return $this->connection->close();
        }
        private function _gettype($var) {
            if (is_string($var)) return 's';
            if (is_float($var)) return 'd';
            if (is_int($var)) return 'i';
            return 'b';
        }
    }
    

    // // Get data to display on index page
    // $query = $connection->query( "SELECT * FROM blog_data");

    // // Create a new post
    // if(isset($_REQUEST['new_post'])){
    //     $title = $_REQUEST['title'];
    //     $content = $_REQUEST['content'];

    //     $sql = "INSERT INTO blog_data(title, content) VALUES('$title', '$content')";
    //     $connection->query( $sql);

    //     echo $sql;

    //     header("Location: index.php?info=added");
    //     exit();
    // }

    // // Get post data based on id
    // if(isset($_REQUEST['id'])){
    //     $id = $_REQUEST['id'];
    //     $sql = "SELECT * FROM blog_data WHERE id = $id";
    //     $query = $connection->query( $sql);
    // }

    // // Delete a post
    // if(isset($_REQUEST['delete'])){
    //     $id = $_REQUEST['id'];

    //     $sql = "DELETE FROM blog_data WHERE id = $id";
    //     $connection->query( $sql);

    //     header("Location: index.php");
    //     exit();
    // }

    // // Update a post
    // if(isset($_REQUEST['update'])){
    //     $id = $_REQUEST['id'];
    //     $title = $_REQUEST['title'];
    //     $content = $_REQUEST['content'];

    //     $sql = "UPDATE blog_data SET title = '$title', content = '$content' WHERE id = $id";
    //     $connection->query( $sql);

    //     header("Location: index.php");
    //     exit();
    // }

?>