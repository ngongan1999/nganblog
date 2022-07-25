<?php 
    include 'admin/includes/database.php';
    include 'admin/includes/blogs.php';
    include 'admin/includes/tags.php';
    include 'admin/includes/comments.php';
    include 'admin/includes/subscriber.php';
    include 'admin/includes/categories.php';
    include 'admin/includes/users.php';

    $new_category = new category($db);
    $new_blog = new blog($db);
    $new_tag = new tag($db);
    $new_comment = new comment($db);
    $new_user = new user($db);

    $new_user->n_user_id = 2;
    $new_user->read_single();
    
    if (!isset($_GET['id'])) {
        header('Location: index.php');
        exit();
    }

    $new_blog->n_blog_post_id = $_GET['id'];
    $new_blog->read_single();

    if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['subscribe'])!=""){
            $new_subscribe = new subscribe($db);
            $new_subscribe->v_sub_email = $_POST['email'];
            $new_subscribe->d_date_created = date('y-m-d',time());
            $new_subscribe->d_time_created = date('h:i:s',time());
            $new_subscribe->f_sub_status = 1;
            $new_subscribe->create();
        }
    
        if(isset($_POST['submit_comment'])){
            $new_comment->n_blog_comment_parent_id = 0;
            $new_comment->n_blog_post_id = $_GET['id'];
            $new_comment->v_comment_author = $_POST['c_name'];
            $new_comment->v_comment_author_email = $_POST['c_email'];
            $new_comment->v_comment = $_POST['c_message'];
            $new_comment->d_date_created = date('y-m-d',time());
            $new_comment->d_time_created = date('h:i:s',time());
            $new_comment->create();
        }
    
        if(isset($_POST['submit_comment_reply'])){
            $new_comment->n_blog_comment_parent_id = $_POST['blog_comment_id'];
            $new_comment->n_blog_post_id = $_GET['id'];
            $new_comment->v_comment_author = $_POST['c_name_reply'];
            $new_comment->v_comment_author_email = $_POST['c_email_reply'];
            $new_comment->v_comment = $_POST['c_message_reply'];
            $new_comment->d_date_created = date('y-m-d',time());
            $new_comment->d_time_created = date('h:i:s',time());
            $new_comment->create();
            
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>NganBlog - Xem bài viết</title>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="css/swiper.min.css">

    <!-- Styles -->
    <link rel="stylesheet" href="style.css">
</head>
<body onload="hide_form_reply()">
<div class="outer-container">
    
    <?php include 'header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-header flex justify-content-center align-items-center" style="background-image: url('images/blog-bg.jpg')">
                    <h1>The Story</h1>
                </div><!-- .page-header -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .hero-section -->

    <div class="container single-page blog-page">
        <div class="row">
            <div class="col-12">
                <div class="content-wrap">
                    <header class="entry-header">
                        <div class="posted-date">
                            <?php echo $new_blog->d_date_created; ?>
                        </div><!-- .posted-date -->

                        <h2 class="entry-title"><?php echo $new_blog->v_post_title; ?></h2>

                        <div class="tags-links">
                            <?php 
                                $new_tag->n_blog_post_id = $new_blog->n_blog_post_id;
                                $new_tag->read_single();
                                $tag_list = explode(',', $tag->v_tag);
                                foreach($tag_list as $tag_element) {
                                    $tag_element = trim($tag_element);
                            ?>
                            <a href="search.php?q=<?php echo $tag_element; ?>">#<?php echo $tag_element; ?></a>
                            <?php } ?>
                        </div><!-- .tags-links -->
                    </header><!-- .entry-header -->

                    <figure class="featured-image">
                        <img src="images/upload/<?php echo $new_blog->v_main_image_url; ?>" alt="">
                    </figure><!-- .featured-image -->

                    <blockquote class="blockquote-text">
                        <p><?php echo $new_blog->v_post_summary; ?></p>
                    </blockquote><!-- .blockquote-text -->

                    <div class="entry-content"><?php echo $new_blog->v_post_content; ?></div><!-- .entry-content -->

                    <div class="row">
                        <div class="col-12 col-md-6">
                            <figure class="blog-page-half-img">
                                <img src="images/upload/<?php echo $new_blog->v_main_image_url; ?>" alt="">
                            </figure><!-- .blog-page-half-img -->
                        </div><!-- .col -->

                        <div class="col-12 col-md-6">
                            <figure class="blog-page-half-img">
                                <img src="images/upload/<?php echo $new_blog->v_alt_image_url; ?>" alt="">
                            </figure><!-- .blog-page-half-img -->
                        </div><!-- .col -->
                    </div><!-- .row -->

                    <footer class="entry-footer flex flex-column flex-lg-row justify-content-between align-content-start align-lg-items-center">
                        <ul class="post-share flex align-items-center order-3 order-lg-1">
                            <label>Chia sẻ</label>
                            <li><a href="facebook.com"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="youtube.com"><i class="fa fa-youtube"></i></a></li>
                        </ul><!-- .post-share -->
                        
                        <?php
                            $new_comment->n_blog_post_id = $new_blog->n_blog_post_id;
                            $result = $new_comment->read();
                        ?>
                        <div class="comments-count order-1 order-lg-3">
                            <a href="#"><?php echo $result->rowCount(); ?> bình luận</a>
                        </div><!-- .comments-count -->
                    </footer><!-- .entry-footer -->
                </div><!-- .content-wrap -->

                <div class="content-area">
                    <div class="post-comments">
                        <h3 class="comments-title">Bình luận</h3>

                        <ol class="comment-list">
                            <?php 
                                if ($result > 0) {
                                    while ($row = $result->fetch()) {
                            ?>
                            <li class="comment">
                                <div class="comment-body flex justify-content-between">
                                    <figure class="comment-author-avatar">
                                        <img src="images/user-1.jpg" alt="user">
                                    </figure><!-- .comment-author-avatar -->

                                    <div class="comment-wrap">
                                        <div class="comment-author flex flex-wrap align-items-center">
                                            <span class="fn">
                                                <a href="#"><?php echo $row['v_comment_author']; ?></a>
                                            </span><!-- .fn -->

                                            <span class="comment-meta">
                                                <a href="#"><?php echo $row['d_date_created']; ?></a>
                                            </span><!-- .comment-meta -->

                                            <div class="reply">
                                                <a href="#reply">Reply</a>
                                            </div><!-- .reply -->
                                        </div><!-- .comment-author -->

                                        <p><?php echo $row['v_comment']; ?></p>

                                    </div><!-- .comment-wrap -->
                                </div><!-- .comment-body -->
                            </li><!-- .comment -->
                            <ul class="child" style="margin-left: 50px;">
                                <?php 
                                    $new_comment->n_blog_comment_parent_id = $row['n_blog_comment_id'];
                                    $result = $new_comment->read();
                                    if ($new_comment->rowCount() > 0) {
                                        while ($row = $new_comment->fetch()) {
                                ?>
                                <li class="comment">
                                    <div class="comment-body flex justify-content-between">
                                        <figure class="comment-author-avatar">
                                            <img src="images/user-1.jpg" alt="user">
                                        </figure><!-- .comment-author-avatar -->

                                        <div class="comment-wrap">
                                            <div class="comment-author flex flex-wrap align-items-center">
                                                <span class="fn">
                                                    <a href="#"><?php echo $row['v_comment_author']; ?></a>
                                                </span><!-- .fn -->

                                                <span class="comment-meta">
                                                    <a href="#"><?php echo $row['d_date_created']; ?></a>
                                                </span><!-- .comment-meta -->
                                            </div><!-- .comment-author -->

                                            <p><?php echo $row['v_comment']; ?></p>

                                        </div><!-- .comment-wrap -->
                                    </div><!-- .comment-body -->
                                </li><!-- .comment -->
                                <?php } } ?>
                            </ul>
                            <?php } } ?>
                        </ol><!-- .comment-list -->
                    </div><!-- .post-comments -->

                    <div class="comments-form" id="respond">
                        <div class="comment-respond" method="post">
                            <h3 class="comment-reply-title">Để lại bình luận</h3>

                            <form class="comment-form">
                                <input type="text" name="c_name" placeholder="Nhập tên">
                                <input type="email" name="c_email" placeholder="Nhập email">
                                <textarea rows="18" cols="6" name="c_message" placeholder="Nhập lời nhắn"></textarea>
                                <input type="submit" name="submit_comment" value="Gửi bình luận">
                            </form><!-- .comment-form -->
                        </div><!-- .comment-respond -->
                    </div><!-- .comments-form -->

                    <div class="comments-form" id="reply">
                        <div class="comment-respond">
                            <h3 class="comment-reply-title">Trả lời bình luận</h3>

                            <form class="comment-form">
                                <input type="text" name="c_name_reply" placeholder="Nhập tên">
                                <input type="email" name="c_email_reply" placeholder="Nhập email">
                                <textarea rows="18" cols="6" name="c_message_reply" placeholder="Nhập lời nhắn"></textarea>
                                <input type="submit" name="submit_comment_reply" value="Trả lời bình luận">
                            </form><!-- .comment-form -->
                        </div><!-- .comment-respond -->
                    </div><!-- .comments-form -->
                </div><!-- .content-area -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .outer-container -->

<?php include 'footer.php'; ?>

<script type='text/javascript' src='js/jquery.js'></script>
<script type='text/javascript' src='js/swiper.min.js'></script>
<script type='text/javascript' src='js/custom.js'></script>

<script type="text/javascript">
    var blog_comment_id;

    function reply_comment(comment_id){
        blog_comment_id = comment_id;
        document.getElementById("respond").style.display = "none";
        document.getElementById("reply").style.display = "block";
    }

    function hide_form_reply(){
        document.getElementById("reply").style.display = "none";
    }

    function check_respond(){
        if(document.c_form.c_name.value == ""){
            alert("Author name is not empty!");
            document.c_form.c_name.focus();
            return false;
        }
        if(document.c_form.c_email.value == ""){
            alert("Author email is not empty!");
            document.c_form.c_email.focus();
            return false;
        }
        if(document.c_form.c_message.value == ""){
            alert("Author message is not empty!");
            document.c_form.c_message.focus();
            return false;
        }
        return true;     

    }

    function check_reply(){
        
        if(document.c_form_reply.c_name_reply.value == ""){
            alert("Author name is not empty!");
            document.c_form_reply.c_name_reply.focus();
            return false;
        }
        if(document.c_form_reply.c_email_reply.value == ""){
            alert("Author email is not empty!");
            document.c_form_reply.c_email_reply.focus();
            return false;
        }
        if(document.c_form_reply.c_message_reply.value == ""){
            alert("Author message is not empty!");
            document.c_form_reply.c_message_reply.focus();
            return false;
        }
        document.c_form_reply.blog_comment_id.value = blog_comment_id;
        return true; 
    }
</script>

</body>
</html>