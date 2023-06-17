<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Page 1</title>
    <meta name="author" content="企业通">
    <meta name="description" content="企业通 企业门户">
    <meta name="keywords" content="企业通 企业门户">
    <!-- Mobile Specific Meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php wp_head(); ?>
</head>

<body>
<div id="preloader"></div>

<!--    回到顶部按钮-->
<div class="up">
    <a href="#" class="scrollup text-center"><i class="fas fa-chevron-up"></i></a>
</div>
<!--    修改鼠标样式-->
<!--	<div id="cursor">-->
<!--		<div class="it-cursor cursor_outer"></div>-->
<!--		<div class="it-cursor cursor_inner"></div>-->
<!--	</div>-->

<!-- Start of header section
	============================================= -->
<header id="it-header" class="it-header-area header-style-one header-style-four">
    <!-- /header Top -->
    <div class="header-main-menu clearfix">
        <div class="brand-logo float-left">
            <a href="<?php bloginfo('url'); ?>"><img src="<?php echo get_template_directory_uri().'/assets/img/logo/qiyetong_logo-xiao.png'?>" alt=""></a>
        </div>
        <div class="it-menu-itemlist float-right">
            <nav class="main-navigation ul-li">
                <?php

                /*
                wp_nav_menu( $args )
                @参数 array $args, 传递此参数时用array(成员参数名=>成员参数值)
                特别说明：
                调用导航菜单时，可以直接复制以下代码。然后根据需要删除成员参数
                */
                wp_nav_menu( array(
                    'theme_location'     		=> 'zhudaohang',	//[保留] 定义菜单的名称/别名
                    'menu' 					=> '',				//[可删]
                    'container' 				=> '',			//[可删] 容器，菜单使用什么包裹，一般都是div
                    'container_class' 		=> '',				//[可删] 容器，calss，
                    'container_id' 			=> '',				//[可删] 容器，id
                    'menu_class' 				=> 'zhudaohang',			//[可删] 菜单的clase，菜单一般都是<ul>
                    'menu_id' 				=> '',				//[可删] 菜单的id
                    'echo'					=> true,			//[可删]
                    'fallback_cb'				=> 'wp_page_menu',	//[可删]
                    'before'					=> '',				//[可删] 链接标记前面的文本，一般不用
                    'after'					=> '',				//[可删] 链接标记后面的文本，一般不用
                    'link_before'				=> '',				//[可删] 链接文本前面的文本，一般不用
                    'link_after'				=> '',				//[可删] 链接文本后面的文本，一般不用
                    'items_wrap'				=> '<ul id="%1$s" class="%2$s">%3$s</ul>',	//[可删]
                    'depth'					=> -1,				//[可删] 深度，显示几级菜单，0-默认，有多少显示多少，-1-部分层级
                    'walker'					=> ''				//[可删]
                ) );
                ?>
            </nav>
        </div>
    </div>
</header>