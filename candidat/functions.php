<?php

/* Core
-------------------------- */
include get_template_directory() . '/functions/core-clean.php';
include get_template_directory() . '/functions/core-security.php';
include get_template_directory() . '/functions/core-theme-setup.php';

/* Extend
-------------------------- */
include get_template_directory() . '/functions/ext-functions.php';
include get_template_directory() . '/functions/ext-shortcodes.php';
include get_template_directory() . '/functions/ext-pagination.php';
include get_template_directory() . '/functions/ext-admin-filters.php';
include get_template_directory() . '/functions/ext-comments-config.php';
include get_template_directory() . '/functions/ext-function-filter.php';
include get_template_directory() . '/functions/ext-search-customfields.php';

/* Theme Custom
-------------------------- */
include get_template_directory() . '/functions/theme-admin.php';
include get_template_directory() . '/functions/theme-admin-styles.php';
include get_template_directory() . '/functions/theme-admin-scripts.php';
include get_template_directory() . '/functions/theme-polylang-strings.php';



?>
