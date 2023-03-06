<?php
    include  (__DIR__.'/logic/db.class.php');
    $db = new DATEBASE();
    $post = $db->editPost(strval($_GET['id']));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <title>Blog</title>
</head>
<body>
    <?php
        include  (__DIR__.'/header.php');
    ?>
   <main class="container my-5">

            <section class="post p-md-5 px-lg-5 mx-lg-5 rounded-lg text-center overflow-hidden">
                <h1>
                    <?php echo $post['title'];?>
                </h1>
                <?php 
                    if ($post['img']){
                        echo '<img class="w-100" src="data:image/jpeg;base64,'.base64_encode( $post['img'] ).'"/>';
                    }
                ?>
                <p class='w-75 text-start'>
                    <?php echo $post['content'];?>
                </p>

                <div class="d-flex flex-row mt-2 justify-content-end align-items-end">
                    <a href="edit.php?id=<?php echo $post['id']?>" class="btn btn-dark btn-sm mx-3" name="edit">Edit</a>
                    <form method="POST" action="/logic/del.php">
                        <input type="text" hidden value='<?php echo $post['id']?>' name="id">
                        <button class="btn btn-danger btn-sm ml-2" name="delete">
                            Delete
                        </button>
                    </form>
                </div>

            </section>

   </main>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>
</html>