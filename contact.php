<?php
    include 'admin/includes/database.php';
    include 'admin/includes/blogs.php';
    include 'admin/includes/categories.php';
    include 'admin/includes/subscriber.php';
    include 'admin/includes/users.php';
    include 'admin/includes/tags.php';

    $new_category = new category($db);
    $new_blog = new blog($db);
    $new_user = new user($db);
    $new_tag = new tag($db);

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
    
        if(isset($_POST['submit_contact'])){
            $new_contact->v_fullname = $_POST['c_name'];
            $new_contact->v_email = $_POST['c_email'];
            $new_contact->v_phone = $_POST['c_phone'];        
            $new_contact->v_message = $_POST['c_message'];
            $new_contact->d_date_created = date('y-m-d',time());
            $new_contact->d_time_created = date('h:i:s',time());
            $new_contact->f_contact_status = 1;
            $new_contact->create();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>NganBlog - Liên hệ</title>

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
                <div class="page-header flex justify-content-center align-items-center" style="background-image: url('images/contact-bg.jpg')">
                    <h1>Contact</h1>
                </div><!-- .page-header -->
            </div><!-- .col -->
        </div><!-- .row -->
    </div><!-- .hero-section -->

    <div class="container single-page contact-page">
        <div class="row">
            <div class="col-12 col-lg-9">
                <div class="content-wrap">
                    <header class="entry-header">
                        <h2 class="entry-title">Hãy liên hệ với chúng tôi</h2>
                    </header><!-- .entry-header -->

                    <div class="entry-content">
                        <p>chúng tôi mong muốn nhận được góp ý hoặc nhận xét của bạn.</p>
                    </div><!-- .entry-content -->

                    <div class="contact-page-social">
                        <ul class="flex align-items-center">
                            <li><a href="facebook.com"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="youtube.com"><i class="fa fa-youtube"></i></a></li>
                        </ul>
                    </div><!-- .header-bar-social -->

                    <form class="contact-form">
                        <input type="text" name="c_name" placeholder="Nhập tên">
                        <input type="text" name="c_phone" placeholder="Nhập số điện thoại">
                        <input type="email" name="c_email" placeholder="Nhập email">
                        <textarea rows="18" cols="6" name="c_message" placeholder="Nhập lời nhắn"></textarea>
                        <input type="submit" name="submit_contact" value="Gửi đánh giá">
                    </form><!-- .contact-form -->
                </div><!-- .content-wrap -->
            </div><!-- .col -->

            <?php include 'sidebar.php'; ?>
            
        </div><!-- .row -->
    </div><!-- .container -->
</div><!-- .outer-container -->

<?php include 'footer.php'; ?>

<script type='text/javascript' src='js/jquery.js'></script>
<script type='text/javascript' src='js/swiper.min.js'></script>
<script type='text/javascript' src='js/custom.js'></script>

</body>
</html>