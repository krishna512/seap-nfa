<?php
$filename = get_post_type();
$archive_folder =  'app/template-parts/archive/';
get_template_part($archive_folder .  'archive', $filename);
