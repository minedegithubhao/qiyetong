<div class="col-lg-4 col-md-12">
    <div class="site_sidebar">
        <!--							搜索框-->
        <div class="single_widget headline-2">
            <h3 class="widget_title">
                检索
            </h3>
            <div class="search_widget position-relative">
                <form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
                    <label class="screen-reader-text" for="s">标注</label>
                    <input type="text" class="search-input" value="<?php the_search_query(); ?>" name="s" id="s" />
                    <button type="submit" id="searchsubmit" value="搜索" ><i class="fas fa-search"></i></button>
                </form>
            </div>
        </div>

        <!--侧边栏-->
        <?php //获取标签信息
            $my_term = get_term_by('slug', 'redian', 'category');
            $my_term_id = $my_term -> term_id;
            $my_term_link = get_term_link($my_term_id,'category');
            $my_term_name = $my_term -> name;
            $my_term_bieming = $my_term -> slug;
        ?>
        <?php $my_query = new WP_Query(array(
            'cat'           => $my_term_id,
        )) ?>
        <div class="single_widget headline-2">
            <h3 class="widget_title">
                <?php echo $my_term_name ?>
            </h3>
            <div class="latest-blog-widget">
                <?php if( $my_query -> have_posts() ) { ?>
                    <?php while( $my_query -> have_posts() ) { ?>
                        <?php $my_query -> the_post(); ?>
                        <div class="blog-img-content">
                            <div class="blog-img nioimage_hover">
                                <?php the_post_thumbnail( 'thumbnail' ); ?>
                            </div>
                            <div class="blog-text headline-2">
                                <h3> <a href="<?php the_permalink()?>"><?php echo customize_strimwidth(get_the_title(), 20, 0, ''); ?></a></h3>
                                <span class="blog-meta"><i class="fas fa-calendar-alt"></i> <?php the_time('Y-m-d')?></span>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>





