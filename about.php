<?php
    include 'admin/includes/database.php';
    include 'admin/includes/blogs.php';
    include 'admin/includes/categories.php';
    include 'admin/includes/users.php';
    include 'admin/includes/tags.php';
    include 'admin/includes/comments.php';
    include 'admin/includes/subscriber.php';

    $new_category = new category($db);
    $new_blog = new blog($db);
    $new_user = new user($db);
    $new_tag = new tag($db);
    $new_comment = new comment($db);

    $new_user->n_user_id = 2;
    $new_user->read_single();

    $new_blog->n_blog_post_id = 1;
    $new_blog->read_single();

    $new_comment->n_blog_post_id = $new_blog->n_blog_post_id;

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
    <title>NganBlog - Giới thiệu</title>

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
                <div class="page-header flex justify-content-center align-items-center" style="background-image: url('images/about-bg.jpg')">
                    <h1>About Me</h1>
                </div><!-- .page-header -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .hero-section -->

    <div class="container single-page about-page">
        <div class="row">
            <div class="col-12">
                <div class="content-wrap">
                    <header class="entry-header">
                        <div class="posted-date">
                            <?php echo $new_blog->d_date_created; ?>
                        </div><!-- .posted-date -->

                        <h2 class="entry-title"><?php echo $new_blog->v_post_title; ?></h2>
                        
                        <?php 
                            $new_tag->n_blog_post_id = $new_blog->n_blog_post_id;
                            $new_tag->read_single();
                            $tag_list = explode(',', $new_tag->v_tag);
                            foreach($tag_list as $tag_element) {
                                $tag_element = trim($tag_element);
                        ?>
                        <a href="search.php?q=<?php echo $tag_element; ?>">#<?php echo $tag_element; ?></a>
                        <?php } ?>

                    </header><!-- .entry-header -->

                    <figure class="featured-image">
                        <img src="images/upload/<?php $new_blog->v_main_image_url; ?>" alt="">
                    </figure><!-- .featured-image -->

                    <div class="entry-content"><?php echo $new_blog->v_post_content; ?></div><!-- .entry-content -->

                    <figure class="about-second-image">
                        <img src="images/upload/<?php $new_blog->v_alt_image_url; ?>" alt="">
                    </figure>
                </div><!-- .col -->
            </div><!-- .row -->
        </div><!-- .row -->

        <div class="row">
            <div class="col-12">
                <footer class="entry-footer flex flex-column flex-lg-row justify-content-between align-content-start align-lg-items-center">
                    <ul class="post-share flex align-items-center order-3 order-lg-1">
                        <label>Chia sẻ</label>
                        <li><a href="facebook.com"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="youtube.com"><i class="fa fa-youtube"></i></a></li>
                    </ul><!-- .post-share -->

                    <div class="comments-count order-1 order-lg-3">
                        <a href="#"><?php echo $new_comment->read_single_blog_post()->rowCount(); ?> bình luận</a>
                    </div><!-- .comments-count -->
                </footer><!-- .entry-footer -->
            </div><!-- .content-wrap -->
        </div><!-- .col -->
    </div><!-- .container -->
</div><!-- .outer-container -->

<?php include 'footer.php'; ?>

<script type='text/javascript' src='js/jquery.js'></script>
<script type='text/javascript' src='js/swiper.min.js'></script>
<script type='text/javascript' src='js/custom.js'></script>

</body>
</html>