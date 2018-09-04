<script>
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
</script>

<?php 
    if(isset($_POST['create_post'])){
        
        $post_title = escape($_POST['title']);
        $post_author = $_SESSION['username'];
        $post_category_id = $_POST['post_category_id'];
        $post_status = $_POST['post_status'];
        
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];
        $post_date = date('d-m-y');
        
        move_uploaded_file($post_image_temp, "../images/$post_image");
        
        $query = "INSERT INTO posts(post_category_id, post_title, post_author, ";
        $query.= "post_date, post_image, post_content, post_tags,  post_status) ";
        $query.= "VALUES({$post_category_id},'{$post_title}','{$post_author}', now(),'{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
        
        $result = mysqli_query($connection, $query);
        confirm($result);
        header("Location: posts.php");
    }
?>
  

   
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">        
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select name="post_category_id" id="post_category">
            <?php
                $query = "SELECT * FROM categories ";
                $select = mysqli_query($connection, $query);
                
                confirm($select);
                
                while ($row = mysqli_fetch_assoc($select)){
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];
                    
                    echo"<option value='{$cat_id}'>{$cat_title}</option> ";
                }
            ?>
        </select>      
    </div>
<!--
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="author">        
    </div>
-->
    <div class="form-group">
        <label for="status">Status</label>
        <select name="post_status" id="post_status">
            <option value="draft">Draft</option>
            <option value="published">Published</option>
        </select>   
    </div>
    
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image">        
    </div>
    
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">        
    </div>
    <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" id="body" cols="30" rows="10" class="form-control"></textarea> 
    </div>
    <div class="form-group">
        <input class="btn btn-primary" type="submit" name="create_post" value="Add Post">
    </div>  
</form>