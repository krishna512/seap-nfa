<?php
// Get post data


wp_enqueue_style('lightGallery');
wp_enqueue_script('lightGallery');


$id = get_the_ID();
$posttype = get_post_type() ?: 'stakeholder';
$permalink = get_the_permalink();
                                // var_dump(get_post_meta($id));

// Get ACF fields with proper sanitization
$title_hideshow = get_field('title_hideshow'); // Default to 'show' if not set
$title = esc_html(get_the_title());
$taxonomy = 'stakeholder-category';
$regions = get_field('regions') ?: [];
$website_link = esc_url(get_field('website_link') ?: '');
$stakeholder_categories = get_the_terms($id, $taxonomy) ?: [];
$feature_image = get_field('feature_image') ?: '';
$point_of_contact = esc_html(get_field('point_of_contact') ?: '');
$name_of_individual = esc_html(get_field('name_of_individual') ?: '');
$poc_email = sanitize_email(get_field('poc_email') ?: '');
$about = wp_kses_post(get_field('about') ?: '');
$gallery = get_field('gallery') ?: [];
?>

<div id="<?php echo esc_attr($posttype); ?>-single" class="single-stakeholder">
    <?php echo page_hero_content_stakeholder(); ?>
    <div class="container pt-14 pb-[58px]">
        <div class=" md:space-8">
            <!--  space-y-[60px] wp-block-post-content entry-content -->
            <div class="flex md-lg:justify-between max-md-lg:flex-wrap gap-y-6  gap-x-8">
                <div class="stakeholder-detail basis-[230px]  space-y-4 sm:space-y-5 md-lg:space-y-7">
                    <?php if ($title): ?>
                        <div class="stakeholder-title">
                            <div class="text-n-30 text-sm leading-[1.6] font-bold">Name</div>
                            <?php
                            // Check if ACF is active
                            if (function_exists('get_field')) {
                                $title_hideshow = get_field('title_hideshow'); // Get the ACF select field
                        
                                // Handle array output from title_hideshow
                                $hideshow_value = is_array($title_hideshow) ? $title_hideshow['value'] : $title_hideshow;

                                // Debugging: Uncomment to verify values
                                // echo '<pre>'; var_dump($title_hideshow); var_dump($heading); echo '</pre>';
                        
                                if ($hideshow_value === 'show' && !empty($title)) {
                                    // Display custom heading if 'show' and heading is not empty
                                    echo '<div class="text-sm leading-[1.5] text-n-50">' . esc_html($title) . '</div>';
                                } else {
                                    // Display 'Stakeholders' for 'hide' or any other case
                                    echo '<div class="text-sm leading-[1.5] text-n-50">Stakeholders</div>';
                                }
                            } else {
                                // Fallback if ACF is not available
                                echo '<div class="text-sm leading-[1.5] text-n-50">Stakeholders</div>';
                            }
                            ?>
                        </div>
                    <?php endif; ?>


                    <?php if ($poc_email): ?>
                        <div class="stakeholder-email">
                            <div class="text-n-30 text-sm leading-[1.6] font-bold">Email</div>
                            <div class="text-sm leading-[1.5] text-n-50"><?php echo $poc_email; ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($website_link): ?>
                        <div class="stakeholder-website">
                            <div class="text-n-30 text-sm leading-[1.6] font-bold">Website</div>
                            <a class="text-sm leading-[1.5] text-[#1252B9] underline" href="<?php echo $website_link; ?>"
                                target="_blank" rel="noopener noreferrer"><?php echo $website_link; ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if (have_rows('social_media')): ?>
                        <div class="social-media-container">
                            <div class="text-n-30 text-sm leading-[1.6] font-bold mb-1">Follow us on</div>
                            <div class="flex gap-4">
                                <?php while (have_rows('social_media')):
                                    the_row();
                                    $social_media = esc_html(get_sub_field('social_media') ?: '');
                                    $social_media_link = esc_url(get_sub_field('social_media_link') ?: '');

                                    if ($social_media && $social_media_link): ?>
                                        <div class="social-media-item">
                                            <div class="social-media-link">
                                                <a href="<?php echo $social_media_link; ?>" target="_blank"
                                                    class="<?php echo $social_media; ?>" rel="noopener noreferrer"></a>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endwhile; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                </div>

                <?php if ($about): ?>
                    <div
                        class="stakeholder-about font-base max-md-lg:order-3 text-n-60 leading-[2] basis-[647px]  wp-block-post-content entry-content">
                        <?php echo $about; ?>
                    </div>
                <?php endif; ?>
                <div class="stakeholder-contact basis-[200px] max-md-lg:order-2 space-y-4 sm:space-y-5 md-lg:space-y-7">

                    <?php if ($point_of_contact || $name_of_individual || $poc_email): ?>

                        <?php if ($regions && is_array($regions)): ?>
                            <div class="related-region-list">
                                <div class="text-n-30 text-sm leading-[1.6] font-bold">Region/Countries</div>

                                <?php foreach ($regions as $index => $region_id): ?>

                                    <a class=" text-sm leading-[1.5] text-n-50"
                                        href="<?php echo esc_url(get_the_permalink($region_id)); ?>">
                                        <?php echo esc_html(get_the_title($region_id)); ?>
                                    </a>
                                    <?php if ($index < count($regions) - 1): ?>,
                                    <?php endif; ?>

                                <?php endforeach; ?>

                            </div>
                        <?php endif; ?>

                        <div class="point-of-contact">
                            <div class="text-n-30 text-sm leading-[1.6] font-bold">Point of Contact</div>
                            <div class="text-sm leading-[1.5] text-n-50">
                                <?php if ($point_of_contact): ?>
                                    <div><?php echo $point_of_contact; ?></div>
                                <?php endif; ?>
                                <?php if ($name_of_individual): ?>
                                    <div><?php echo $name_of_individual; ?></div>
                                <?php endif; ?>
                                <?php if ($poc_email): ?>
                                    <div><a href="mailto:<?php echo $poc_email; ?>"><?php echo $poc_email; ?></a></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>




                    <?php if ($stakeholder_categories && is_array($stakeholder_categories)): ?>
                        <div class="stakeholder-categories">
                            <div class="text-n-30 text-sm leading-[1.6] font-bold">Categories</div>
                            <ul>
                                <?php foreach ($stakeholder_categories as $category): ?>
                                    <li class="text-sm leading-[1.5] text-n-50"><?php echo esc_html($category->name); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($gallery && is_array($gallery)): ?>
                <div class="gallery-section divide-y divide-b-30/50">
                    <h3 class="font-semibold tracking-[-0.041em] mb-4">In Action</h3>
                    <div id="lightgallery"
                        class="gallery-images grid grid-cols-[repeat(auto-fill,_minmax(288px,_1fr))] gap-4 pt-6 md:pt-10 ">

                        <?php foreach ($gallery as $image): ?>
                            <?php if (isset($image['sizes']['large'])): ?>
                                <div class="item relative pt-[72.2%] " data-src="<?php echo esc_url($image['sizes']['large']); ?>">
                                    <img class="absolute w-full h-full inset-0 object-cover "
                                        src="<?php echo esc_url($image['sizes']['large']); ?>"
                                        alt="<?php echo esc_attr($image['alt'] ?: 'Gallery image'); ?>" />
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php gutenbergEditorContent(); ?>
    </div>
</div>