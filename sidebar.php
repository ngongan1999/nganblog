<div class="col-12 col-lg-3">
    <div class="sidebar">
        <div class="about-me">
            <h2>Thanh Ngân</h2>

            <p><?php echo $new_user->v_message; ?></p>
        </div><!-- .about-me -->

        <div class="recent-posts">
            <?php 
                $result = $new_blog->read_recent_blog();
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch()) {
            ?>
            <div class="recent-post-wrap">
                <figure>
                    <img src="images/upload/<?php echo $row['v_main_image_url']; ?>" alt="">
                </figure>

                <header class="entry-header">
                    <div class="posted-date">
                        <?php echo $row['d_date_created']; ?>
                    </div><!-- .entry-header -->

                    <h3><a href="blog.php?id=<?php echo $row['n_blog_post_id']; ?>"><?php echo $row['v_post_title']; ?></a></h3>

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
            </div><!-- .recent-post-wrap -->
            <?php } } ?>

        </div><!-- .recent-posts -->

        <div class="tags-list">
            <?php 
                $result = $new_tag->read();
                if ($result->rowCount() > 0) {
                    while ($row = $result->fetch()) {
                        $tag_list = explode(',', $row['v_tag']);
                        foreach($tag_list as $tag_element) {
                            $tag_element = trim($tag_element);
            ?>
            <a href="search.php?q=<?php echo $tag_element; ?>">#<?php echo $tag_element; ?></a>
            <?php } } } ?>
        </div><!-- .tags-list -->
    </div><!-- .sidebar -->
</div><!-- .col -->