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
        <!-- Form to edit post -->
        <form method="POST" action="/logic/edit.php" enctype="multipart/form-data">
         <input type="text" hidden value='<?php echo $post['id']?>' name="id">

            <input type="text" placeholder="Blog Title" maxlength="60" required class="form-control my-3 text-center" name="title"
                value='<?php echo $post['title']?>'>

            <textarea name="content" required placeholder="Blog Content" 
            class="form-control my-3" maxlength="450" cols="30" rows="5"><?php echo $post['content']?></textarea>
            <?php 
                if ($post['img']){
                    echo '<h4>Old image:</h4>';
                    echo '<img class="w-25" src="data:image/jpeg;base64,'.base64_encode( $post['img'] ).'"/>';
                    echo '<h4>New image:</h4>';
                    echo '<input class="form-control mb-3" id="formFile" type="file" name="image" 
                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">';
                } else {
                    echo '<input class="form-control mb-3" id="formFile" type="file" name="image" 
                    accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">';
                }
           ?> 

            <button class="btn btn-dark" name="edit_post">Save</button>
        </form>
   </main>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>


</body>
</html>