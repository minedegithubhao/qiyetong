<?php

/**
 * 启用文章格式化功能
 * @return void
 */
function qiyetong_post_formats_setup() {
    add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );
}
add_action( 'after_setup_theme', 'qiyetong_post_formats_setup' );

/**
 * 添加feed
 */
add_theme_support( 'automatic-feed-links' );

/**
 * lingfeng_breadcrumbs()函数
 * 功能是输出面包屑导航HTML代码
 */
function lingfeng_breadcrumbs() {
    /* === OPTIONS === */
    $text['home']     = '网站首页'; // text for the 'Home' link
    $text['category'] = '%s'; // text for a category page
    $text['search']   = '"%s"的搜索结果'; // text for a search results page
    $text['tag']      = '%s'; // text for a tag page
    $text['author']   = '%s'; // text for an author page
    $text['404']      = '404错误'; // text for the 404 page

    $show_current   = 1; // 1 - show current post/page/category title in breadcrumbs, 0 - don't show
    $show_on_home   = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
    $show_title     = 1; // 1 - show the title for the links, 0 - don't show
    $delimiter      = ' &raquo; '; // delimiter between crumbs
    $before         = '<span class="current">'; // tag before the current crumb
    $after          = '</span>'; // tag after the current crumb
    /* === END OF OPTIONS === */

    global $post;
    $home_link    = home_url('/');
    $link_before  = '<span typeof="v:Breadcrumb">';
    $link_after   = '</span>';
    $link_attr    = ' rel="v:url" property="v:title"';
    $link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
    $parent_id    = $parent_id_2 = $post->post_parent;
    $frontpage_id = get_option('page_on_front');

    if (is_home() || is_front_page()) {

        if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

    } else {

        echo '<div class="breadcrumbs" xmlns:v="http://rdf.data-vocabulary.org/#">';
        if ($show_home_link == 1) {
            echo '<a href="' . $home_link . '" rel="v:url" property="v:title">' . $text['home'] . '</a>';
            if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo $delimiter;
        }

        if ( is_category() ) {
            $this_cat = get_category(get_query_var('cat'), false);
            if ($this_cat->parent != 0) {
                $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
            }
            if ($show_current == 1) echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

        } elseif ( is_search() ) {
            echo $before . sprintf($text['search'], get_search_query()) . $after;

        } elseif ( is_day() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
            echo $before . get_the_time('d') . $after;

        } elseif ( is_month() ) {
            echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
            echo $before . get_the_time('F') . $after;

        } elseif ( is_year() ) {
            echo $before . get_the_time('Y') . $after;

        } elseif ( is_single() && !is_attachment() ) {
            if ( get_post_type() != 'post' ) {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name);
                if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;
            } else {
                $cat = get_the_category(); $cat = $cat[0];
                $cats = get_category_parents($cat, TRUE, $delimiter);
                if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
                if ($show_current == 1) echo $before . get_the_title() . $after;
            }

        } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;

        } elseif ( is_attachment() ) {
            $parent = get_post($parent_id);
            $cat = get_the_category($parent->ID); $cat = $cat[0];
            if ($cat) {
                $cats = get_category_parents($cat, TRUE, $delimiter);
                $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                echo $cats;
            }
            printf($link, get_permalink($parent), $parent->post_title);
            if ($show_current == 1) echo $delimiter . $before . get_the_title() . $after;

        } elseif ( is_page() && !$parent_id ) {
            if ($show_current == 1) echo $before . get_the_title() . $after;

        } elseif ( is_page() && $parent_id ) {
            if ($parent_id != $frontpage_id) {
                $breadcrumbs = array();
                while ($parent_id) {
                    $page = get_page($parent_id);
                    if ($parent_id != $frontpage_id) {
                        $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                    }
                    $parent_id = $page->post_parent;
                }
                $breadcrumbs = array_reverse($breadcrumbs);
                for ($i = 0; $i < count($breadcrumbs); $i++) {
                    echo $breadcrumbs[$i];
                    if ($i != count($breadcrumbs)-1) echo $delimiter;
                }
            }
            if ($show_current == 1) {
                if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo $delimiter;
                echo $before . get_the_title() . $after;
            }

        } elseif ( is_tag() ) {
            echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

        } elseif ( is_author() ) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . sprintf($text['author'], $userdata->display_name) . $after;

        } elseif ( is_404() ) {
            echo $before . $text['404'] . $after;

        } elseif ( has_post_format() && !is_singular() ) {
            echo get_post_format_string( get_post_format() );
        }

//        if ( get_query_var('paged') ) {
//            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
//            echo __('Page') . ' ' . get_query_var('paged');
//            if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
//        }

        echo '</div><!-- .breadcrumbs -->';

    }
} // end dimox_breadcrumbs()

function lingfeng_pagenavi( $range = 4 ) {
    global $paged,$wp_query;
    if ( !$max_page ) {
        $max_page = $wp_query->max_num_pages;
    }
    if( $max_page >1 ) {
        echo "<div class='fenye'>";
        if( !$paged ){
            $paged = 1;
        }
        if( $paged != 1 ) {
            echo "<a href='".get_pagenum_link(1) ."' class='extend' title='跳转到首页'>首页</a>";
        }
        previous_posts_link('上一页');
        if ( $max_page >$range ) {
            if( $paged <$range ) {
                for( $i = 1; $i <= ($range +1); $i++ ) {
                    echo "<a href='".get_pagenum_link($i) ."'";
                    if($i==$paged) echo " class='current'";echo ">$i</a>";
                }
            }elseif($paged >= ($max_page -ceil(($range/2)))){
                for($i = $max_page -$range;$i <= $max_page;$i++){
                    echo "<a href='".get_pagenum_link($i) ."'";
                    if($i==$paged)echo " class='current'";echo ">$i</a>";
                }
            }elseif($paged >= $range &&$paged <($max_page -ceil(($range/2)))){
                for($i = ($paged -ceil($range/2));$i <= ($paged +ceil(($range/2)));$i++){
                    echo "<a href='".get_pagenum_link($i) ."'";if($i==$paged) echo " class='current'";echo ">$i</a>";
                }
            }
        }else{
            for($i = 1;$i <= $max_page;$i++){
                echo "<a href='".get_pagenum_link($i) ."'";
                if($i==$paged)echo " class='current'";echo ">$i</a>";
            }
        }
        next_posts_link('下一页');
        if($paged != $max_page){
            echo "<a href='".get_pagenum_link($max_page) ."' class='extend' title='跳转到最后一页'>尾页</a>";
        }
        echo '<span>共['.$max_page.']页</span>';
        echo "</div>\n";
    }
}

/**
add_theme_support($features, $arguments)
函数功能：开启缩略图功能
@参数 string $features, 此参数是告诉wordpress你要开启什么功能
@参数 array $arguments, 此参数是告诉wordpress哪些信息类型想要开启缩略图
第二个参数如果不填写，那么文章信息和页面信息都开启缩略图功能。
*/
add_theme_support('post-thumbnails');

/**
 * customize_strimwidth( ) 函数
 * 功能：字符串截取，并去除字符串中的html和php标签
 * @Param string $str			要截取的原始字符串
 * @Param int $len				截取的长度
 * @Param string $suffix		字符串结尾的标识
 * @Return string					处理后的字符串
 */
function customize_strimwidth( $str, $len, $start = 0, $suffix = '……' ) {
    $str = str_replace(array(' ', '　','&nbsp;', '\r\n'), '', strip_tags( $str ));
    if ( $len>mb_strlen( $str ) ) {
        return mb_substr( $str, $start, $len );
    }
    return mb_substr($str, $start, $len) . $suffix;
}
/**
 * setPostViews()函数
 * 功能：设置或更新阅读数量
 * 在内容页(single.php，或page.php )调用此函数
 * @Param object|int $postID   文章的id
 * @Return string $count		  文章阅读数量
 */
function setPostViews( $postID ) {
    $count_key = 'post_views_count';
    $count = get_post_meta( $postID, $count_key, true );
    if( $count=='' ) {
        $count = 0;
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
    } else {
        $count++;
        update_post_meta( $postID, $count_key, $count );
    }
}

/**
 * getPostViews()函数
 * 功能：获取阅读数量
 * 在需要显示浏览次数的位置，调用此函数
 * @Param object|int $postID   文章的id
 * @Return string $count		  文章阅读数量
 */
function getPostViews( $postID ) {
    $count_key = 'post_views_count';
    $count = get_post_meta( $postID, $count_key, true );
    if( $count=='' ) {
        delete_post_meta( $postID, $count_key );
        add_post_meta( $postID, $count_key, '0' );
        return "0";
    }
    return $count;
}

/*
register_nav_menu( $location, $description )
函数功能：开启导航菜单功能
@参数 string $location, 导航菜单的位置
@参数 string $description, 导航菜单的描述
开启多个位置的导航菜单，只需要重复调用此函数即可
*/
register_nav_menu( 'zhudaohang', '网站的顶部导航' );     //注册一个菜单

/**
 * 加载前台脚本和样式表
 * 加载主样式表style.css
 */
add_action('wp_enqueue_scripts', 'lingfeng_scripts');
function lingfeng_scripts() {
    /**
     * wp_enqueue_style( $handle, $src, $deps, $ver, $media );
     * 功能：添加样式表
     * @Param string $handle				【必填】样式表的唯一标识符（名称）
     * @Param string $src						【可选】样式表的所在地址（url）
     * @Param array $deps					【可选】加载本样式之前，必须首先加载的
     * @Param string $ver						【可选】样式表的版本
     * @Param boolen $media				【可选】样式表指定的媒体
     * 例如：wp_enqueue_style( 'lingfeng-style', get_template_directory_uri() );
     * 加载主题中的style.css文件
     */
    wp_enqueue_style( 'lingfeng-style', get_template_directory_uri().'/style.css' );
    wp_enqueue_style( 'bootstrap-style', get_template_directory_uri().'/assets/css/bootstrap.min.css' );
    wp_enqueue_style( 'flaticon-style', get_template_directory_uri().'/assets/css/flaticon.css' );
    wp_enqueue_style( 'fontawesome-style', get_template_directory_uri().'/assets/css/fontawesome-all.css' );
    wp_enqueue_style( 'owl-style', get_template_directory_uri().'/assets/css/owl.carousel.css' );
    wp_enqueue_style( 'animate-style', get_template_directory_uri().'/assets/css/animate.css' );
    wp_enqueue_style( 'video-style', get_template_directory_uri().'/assets/css/video.min.css' );
    wp_enqueue_style( 'style-style', get_template_directory_uri().'/assets/css/style.css' );
    wp_enqueue_style( 'custom.css', get_template_directory_uri().'/assets/css/custom.css' );

    /**
     * wp_register_script( $handle, $src, $deps, $ver, $in_footer )
     * 函数功能：加载js脚本
     * @Param string $handle				【必填】脚本的标识符（名称）
     * @Param string $src						【可选】脚本所在地址（url）
     * @Param array $deps					【可选】加载本脚本之前，必须首先加载的
     * @Param string $ver						【可选】脚本的版本
     * @Param boolen $in_footer			【可选】脚本的位置，是否放在页脚
     * 函数说明，仅仅是注册和备案，并没有真正添加。
     * 真正要添加脚本，用wp_enqueue_script( ) 函数
     * 例如：wp_register_script ('lingfeng-lazyload', get_template_directory_uri().'/js/jquery.lazyload.js');
     * 解释：注册一个名字为'lingfeng-lazyload'的脚本，脚本的地址是主题文件夹下的js/juqery.lazyload.js
     */


    /**
     * wp_enqueue_script( $handle, $src, $deps, $ver, $in_footer )
     * 函数功能：加载js脚本
     * @Param string $handle				【必填】脚本的标识符（名称）
     * @Param string $src						【可选】脚本所在地址（url）
     * @Param array $deps					【可选】加载本脚本之前，必须首先加载的
     * @Param string $ver						【可选】脚本的版本
     * @Param boolen $in_footer			【可选】脚本的位置，是否放在页脚
     * 例如: wp_enqueue_script ('lingfeng-tool', get_template_directory_uri().'/js/tool.js', array( 'jquery', 'lingfeng-lazyload'));
     * 解释：添加名字为‘lingfeng-tool’的脚本，脚本的地址为主题目录下的js/tool.js，而且在加载此脚本之前先要加载名字叫做'jquery'和'lingfeng-lazyload'的脚本
     */
    wp_enqueue_script ('jquery.min.js', get_template_directory_uri().'/assets/js/jquery.min.js');
    wp_enqueue_script ('bootstrap.min.js', get_template_directory_uri().'/assets/js/bootstrap.min.js');
    wp_enqueue_script ('popper.min.js', get_template_directory_uri().'/assets/js/popper.min.js');
    wp_enqueue_script ('owl.carousel.min.js', get_template_directory_uri().'/assets/js/owl.carousel.min.js');
    wp_enqueue_script ('jquery.magnific-popup.min.js', get_template_directory_uri().'/assets/js/jquery.magnific-popup.min.js');
    wp_enqueue_script ('appear.js', get_template_directory_uri().'/assets/js/appear.js');
    wp_enqueue_script ('wow.min.js', get_template_directory_uri().'/assets/js/wow.min.js');
    wp_enqueue_script ('isotope.pkgd.min.js', get_template_directory_uri().'/assets/js/isotope.pkgd.min.js');
    wp_enqueue_script ('masonry.pkgd.min.js', get_template_directory_uri().'/assets/js/masonry.pkgd.min.js');
    wp_enqueue_script ('imagesloaded.pkgd.min.js', get_template_directory_uri().'/assets/js/imagesloaded.pkgd.min.js');
    wp_enqueue_script ('parallax-scroll.js', get_template_directory_uri().'/assets/js/parallax-scroll.js');
    wp_enqueue_script ('jquery.easeScroll.min.js', get_template_directory_uri().'/assets/js/jquery.easeScroll.min.js');
    wp_enqueue_script ('jquery.counterup.min.js', get_template_directory_uri().'/assets/js/jquery.counterup.min.js');
    wp_enqueue_script ('waypoints.min.js', get_template_directory_uri().'/assets/js/waypoints.min.js');
    wp_enqueue_script ('typer-new.js', get_template_directory_uri().'/assets/js/typer-new.js');
    wp_enqueue_script ('script.js', get_template_directory_uri().'/assets/js/script.js');
}




?>