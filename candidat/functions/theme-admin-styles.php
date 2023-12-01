<?php


/*------------------------------------*\
		ADD CUSTOM CSS ON ADMIN => used for Carbon fields
\*------------------------------------*/
add_action('admin_head', 'crb_custom_css');

function crb_custom_css() { ?>
  <style>
    li.separator{
    	height: 2px;
    	background-color: #000;
    	margin: 20px 0;
    	padding: 0 15px;
    }

    .carbon-container .carbon-separator{
    	position: relative;
    	background-color: #005eb8;
    	margin-top: 20px;
    }
    .carbon-container .carbon-separator:first-of-type{
    	margin-top: 0;
    }

    body #poststuff .carbon-container .carbon-separator h3{
    	color: #fff;
    	font-size: 18px;
    }

    .nav-menus-php .carbon-container .carbon-separator,
    .appearance_page_menu-options .carbon-container .carbon-separator{
    	margin-top: 50px;
    }

    .nav-menus-php .carbon-container .carbon-separator:before,
    .appearance_page_menu-options .carbon-container .carbon-separator:before{
    	content: '';
    	display: block;
    	position: absolute;
    	top: -50px;
    	left: -2px;
    	width: calc(100% + 4px);
    	height: 50px;
    	background-color: #f1f1f1;
    }

    .nav-menus-php .carbon-container .carbon-separator:after,
    .appearance_page_menu-options .carbon-container .carbon-separator:after{
    	content: '';
    	display: block;
    	position: absolute;
    	top: -50px;
    	left: 0;
    	width: 100%;
    	height: 1px;
    	background-color: #e5e5e5;
    }
  </style>

  <?php
}

?>
