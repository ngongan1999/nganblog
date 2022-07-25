<?php 
    include 'admin/includes/database.php';
    include 'admin/includes/blogs.php';
    include 'admin/includes/tags.php';
    include 'admin/includes/comments.php';
    include 'admin/includes/categories.php';
    include 'admin/includes/users.php';
    include 'admin/includes/subscriber.php';

    $new_category = new category($db);
    $new_blog = new blog($db);
    $new_tag = new tag($db);
    $new_comment = new comment($db);
    $new_user = new user($db);

    $new_user->n_user_id = 2;
    $new_user->read_single();
    
    if ($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['subscribe'])!=""){
            $new_subscribe = new subscribe($db);
            $new_subscribe->v_sub_email = $_POST['email'];
            $new_subscribe->d_date_created = date('y-m-d',time());
            $new_subscribe->d_time_created = date('h:i:s',time());
            $new_subscribe->f_sub_status = 1;
            $new_subscribe->create();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>NganBlog - Trang chủ</title>

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
<body>
<div class="outer-container">
    <?php include 'header.php'; ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="swiper-container hero-slider">
                    
                    <div class="swiper-wrapper">
                    <?php 
                        $result = $new_blog->read_home_page_place();
                        if ($result->rowCount() > 0) {
                            while($row = $result->fetch()) {
                    ?>
                        <div class="swiper-slide">
                            <div class="hero-content flex justify-content-center align-items-center flex-column">
                                <img src="images/upload/<?php echo $row['v_main_image_url']; ?>" alt="">
                            </div><!-- .hero-content -->
                        </div><!-- .swiper-slide -->
                    <?php } } ?>
                    </div><!-- .swiper-wrapper -->

                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>

                    <!-- Add Arrows -->
                    <div class="swiper-button-next flex justify-content-center align-items-center">
                        <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 44"><path d="M27,22L27,22L5,44l-2.1-2.1L22.8,22L2.9,2.1L5,0L27,22L27,22z"></path></svg></span>
                    </div>
                    <div class="swiper-button-prev flex justify-content-center align-items-center">
                        <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27 44"><path d="M0,22L22,0l2.1,2.1L4.2,22l19.9,19.9L22,44L0,22L0,22L0,22z"></path></svg></span>
                    </div>
                </div><!-- .swiper-container -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .hero-section -->

    <div class="container single-page">
        <div class="row">
            <div class="col-12 col-lg-9">
                <?php 
                    $result = $new_blog->read();
                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch()) {
                ?>
                <div class="content-wrap">
                    <header class="entry-header">
                        <div class="posted-date">
                            <?php echo $row['d_date_created']; ?>
                        </div><!-- .posted-date -->

                        <h2 class="entry-title"><?php echo $row['v_post_title']; ?></h2>
                        
                        <div class="tags-links">
                            <?php 
                                $new_tag->n_blog_post_id = $row['n_blog_post_id'];
                                $new_tag->read_single();
                                $tag_list = explode(',', $new_tag->v_tag);
                                foreach($tag_list as $tag_element) {
                                    $tag_element = trim($tag_element);
                            ?>
                            <a href="search.php?q=<?php echo $tag_element; ?>">#<?php echo $tag_element; ?></a>
                            <?php } ?>
                        </div><!-- .tags-links -->
                    </header><!-- .entry-header -->

                    <figure class="featured-image">
                        <img src="images/upload/<?php echo $row['v_main_image_url']; ?>" alt="">
                    </figure><!-- .featured-image -->

                    <div class="entry-content">
                        <p><?php echo $row['v_post_summary']; ?></p>
                    </div><!-- .entry-content -->

                    <footer class="entry-footer flex flex-column flex-lg-row justify-content-between align-content-start align-lg-items-center">
                        <ul class="post-share flex align-items-center order-3 order-lg-1">
                            <label>Chia sẻ</label>
                            <li><a href="facebook.com"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="youtube.com"><i class="fa fa-youtube"></i></a></li>
                        </ul><!-- .post-share -->

                        <a class="read-more order-2" href="blog.php?id=<?php $row['n_blog_post_id']; ?>">Xem bài viết</a>

                        <div class="comments-count order-1 order-lg-3">
                            <?php
                                $new_comment->n_blog_post_id = $row['n_blog_post_id'];
                                $comment_result = $new_comment->read_single_blog_post();
                            ?>
                            <a href="#"><?php echo $comment_result->rowCount(); ?></a> bình luận</a>
                        </div><!-- .comments-count -->
                    </footer><!-- .entry-footer -->
                </div><!-- .content-wrap -->
                <?php } } ?>
            </div><!-- .col -->

            <?php include 'sidebar.php'; ?>
            
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .outer-container -->

<?php include 'footer.php'; ?>

<script type='text/javascript' src='js/jquery.js'></script>
<script type='text/javascript' src='js/swiper.min.js'></script>
<script type='text/javascript' src='js/custom.js'></script>