<footer class="sit-footer">
    <div class="outer-container">
        <div class="container-fluid">
            <div class="row footer-recent-posts">
                <?php
                    $result = $new_blog->read_recent_blog();
                    if ($result->rowCount() > 0) {
                        while ($row = $result->fetch()) {
                ?>
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="footer-post-wrap flex justify-content-between">
                        <figure>
                            <a href="blog.php?<?php echo $row['n_blog_post_id']; ?>"><img src="images/upload/<?php echo $row['v_main_image_url']; ?>" alt=""></a>
                        </figure>

                        <div class="footer-post-cont flex flex-column justify-content-between">
                            <header class="entry-header">
                                <div class="posted-date">
                                    <?php echo $row['d_date_created']; ?>
                                </div><!-- .entry-header -->

                                <h3><a href="blog.php?<?php echo $row['n_blog_post_id']; ?>"><?php echo $row['v_post_title']; ?></a></h3>

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

                            <footer class="entry-footer">
                                <a class="read-more" href="blog.php?<?php echo $row['n_blog_post_id']; ?>">Xem bài viết</a>
                            </footer><!-- .entry-footer -->
                        </div><!-- .footer-post-cont -->
                    </div><!-- .footer-post-wrap -->
                </div><!-- .col -->
                <?php } } ?>
            </div><!-- .row -->
        </div><!-- .container-fluid -->
    </div><!-- .outer-container -->

    <div class="container-fluid" id="category">
        <div class="row">
            <div class="footer-instagram flex flex-wrap flex-lg-nowrap">
                <?php
                    $result = $new_category->read();
                    if ($result->rowCount() > 0) {
                        $i = 1;
                        while ($row = $result->fetch()) {
                ?>
                <figure>
                    <a href="category.php?id=<?php echo $row['n_category_id']; ?>"><img src="images/a<?php echo $i; ?>.jpg" alt=""><span class="text-center"><?php echo $row['v_category_title']; ?></span></a>
                </figure>
                <?php 
                            $i++;
                            if ($i > 7) {
                                $i = 1;
                            }
                        } 
                    } 
                ?>
            </div>
        </div><!-- .row -->
    </div><!-- .container -->

    <div class="footer-bar">
        <div class="outer-container">
            <div class="container-fluid">
                <div class="row justify-content-between">
                    <div class="col-12 col-md-6">
                        <div class="footer-copyright">

                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            <p>Bản quyền &copy; 2022</p>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        </div><!-- .footer-copyright -->
                    </div><!-- .col-xl-4 -->

                    <div class="col-12 col-md-6">
                        <div class="footer-social">
                            <ul class="flex justify-content-center justify-content-md-end align-items-center">
                                <li><a href="facebook.com"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="youtube.com"><i class="fa fa-youtube"></i></a></li>
                            </ul>
                        </div><!-- .footer-social -->
                    </div><!-- .col-xl-4 -->
                </div><!-- .row -->
            </div><!-- .container-fluid -->
        </div><!-- .outer-container -->
    </div><!-- .footer-bar -->
</footer><!-- .sit-footer -->