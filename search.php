<?php get_header() ?>

<!-- Start of breadcurmb section
	============================================= -->
<section id="breadcurmb" class="breadcurmb-section position-relative" data-background="<?php echo get_template_directory_uri().'/assets/img/banner/brbg.jpg'?>">
    <div class="background_overlay"></div>
    <div class="container">
        <div class="breadcurmb-content headline-2">
            <h2>新闻</h2>
            <div class="bread breadcrumb_item ul-li">
                <div class="location">当前位置：</div>
                <div class="breadcrumbs"><?php lingfeng_breadcrumbs() ?></div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</section>
<!-- End of breadcurmb section
	============================================= -->

<!-- Start of blog feed section
	============================================= -->
<section id="blog_feed" class="blog_feed_section">
    <div class="container">
        <div class="news_feed_section">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="news_post">
                        <?php if( have_posts()  ) : while( have_posts() ) : the_post(); ?>
                            <!--                            带视频-->
                            <?php if(metadata_exists('post', get_the_ID(),'vedio_url')) : ?>
                                <div class="news_post_item">
                                    <div class="news_img  position-relative">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail( 'full' ); ?>
                                        <?php else: ?>
                                            //显示默认图片
                                        <?php endif; ?>
                                        <div class="video_play_btn text-center">
                                            <a class="block-display video_box" href="<?php echo get_post_meta(get_the_ID(), 'vedio_url', true) ?>">
                                                <i class="fas fa-play"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="news_text_area headline-2-2 pera-content">
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>
                                        <div class="blog_meta ul-li">
                                            <ul>
                                                <li><i class="fas fa-eye"></i> <?php echo getPostViews(get_the_ID()) ?> 阅读</li>
                                                <li><i class="fas fa-comments"></i> <?php comments_popup_link(0,1,'%') ?> 评论</li>
                                                <li><i class="fas fa-calendar-alt"></i> <?php the_time('Y-m-d')?></li>
                                            </ul>
                                        </div>
                                        <p><?php echo customize_strimwidth(get_the_content(), 200); ?></p>
                                        <div class="author_meta">
                                            <div class="author_img float-left">
                                                <img src="<?php echo get_template_directory_uri().'/assets/img/blog/bpa1.jpg'?>" alt="">
                                                <span><?php the_author()?></span>
                                            </div>
                                            <div class="news_more float-right" >
                                                <a href="<?php the_permalink(); ?>" class="fa"><i>阅读全文</i>  &#xf101;</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php else : ?>
                                <!--                                不带视频-->
                                <div class="news_post_item">
                                    <div class="news_img">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php the_post_thumbnail( 'full' ); ?>
                                        <?php else: ?>
                                            //显示默认图片
                                        <?php endif; ?>
                                    </div>
                                    <div class="news_text_area headline-2-2 pera-content">
                                        <!--									<span class="post_cat"><a href="#">Business</a></span>-->
                                        <h3><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></h3>
                                        <div class="blog_meta ul-li">
                                            <ul>
                                                <li><i class="fas fa-eye"></i> <?php echo getPostViews(get_the_ID()) ?> 阅读</li>
                                                <li><i class="fas fa-comments"></i> <?php comments_popup_link(0,1,'%') ?> 评论</li>
                                                <li><i class="fas fa-calendar-alt"></i> <?php the_time('Y-m-d')?></li>
                                            </ul>
                                        </div>
                                        <p><?php echo customize_strimwidth(get_the_content(), 200); ?></p>
                                        <div class="author_meta">
                                            <div class="author_img float-left">
                                                <img src="<?php echo get_template_directory_uri().'/assets/img/blog/bpa1.jpg'?>" alt="">
                                                <span><?php the_author()?></span>
                                            </div>
                                            <div class="news_more float-right" >
                                                <a href="<?php the_permalink(); ?>" class="fa"><i>阅读全文</i>  &#xf101;</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                    <?php lingfeng_pagenavi() ?>
                </div>
                <!-- /blog post -->
                <?php get_sidebar()?>
            </div>
        </div>
    </div>
</section>
<!-- End of blog feed section
	============================================= -->
<?php get_footer() ?>
