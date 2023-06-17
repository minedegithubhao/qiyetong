<?php get_header() ?>
<?php setPostViews(get_the_ID()); ?>
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

<!-- Start of Blog details section
	============================================= -->
    <?php if( have_posts() ) : while( have_posts() ) : the_post(); ?>
	<section id="blog_details" class="blog_news_post_section blog_details_area">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12">
					<div class="blog_details_content headline-2">
						<div class="blog_details_text headline-2">
<!--							<span class="s_blog_tag">Business</span>-->
							<h2><?php the_title() ?></h2>
							<div class="blog-meta ul-li">
								<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><i class="far fa-user"></i><?php the_author(); ?></a>
                                <a><i class="fas fa-calendar-alt"></i> <?php the_time('Y-m-d')?></a>
								<a><i class="fa fa-eye"></i> <?php echo getPostViews(get_the_ID()) ?> 浏览</a>
							</div>
							<?php the_content(); ?>
						</div>
						<div class="blog_details_extra_text">
							<div class="next_prev_post relative-position  clearfix">
                                <?php if(get_previous_post()->ID != null) :?>
								<div class="nio_prev_post text-left float-left headline-2">
                                    <a href="<?php the_permalink(get_previous_post()->ID) ?>">
                                        <span class="fa fa-angle-double-left"></span><span><i>上一篇</i></span>
                                    </a>
								</div>
                                <?php endif;?>
                                <?php if(get_next_post()->ID != null) :?>
								<div class="nio_prev_post text-right float-right headline-2">
									<a href="<?php the_permalink(get_next_post()->ID) ?>" class="hover_no">
                                        <span><i class="hover_remove">下一篇</i></span><span class="fa fa-angle-double-right hover_remove"></span>
									</a>
								</div>
                                <?php endif;?>
							</div>
						</div>
					</div>
				</div>
				<!-- blog details content -->
				<?php get_sidebar() ?>
				<!-- /sidebar -->
			</div>
		</div>
	</section>
    <?php endwhile; ?>
    <?php endif; ?>
<!-- End of Blog details section
	============================================= -->		

<?php get_footer() ?>

