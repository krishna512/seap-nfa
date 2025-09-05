<?php
$id = '' . $block['id'];
$className = '';

if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= 'home-regions align' . $block['align'];
}

$background_image = (get_field('background_image')) ?: '';
$sub_regions = (get_field('sub_regions')) ?: [];

$styles = "#{$id}.home-regions{
    background: url('{$background_image}'), lightgray 0px -247px / 100% 192.575%;
    background-repeat: no-repeat;
    background-size: cover;
    // background-position: center;
}";
?>
<section id="<?php echo $id; ?>" class="<?php echo esc_attr($className); ?>">
    <style id='<?php echo $id; ?>-styles-inline-css' type='text/css'>
        <?php echo $styles;
        ?>
    </style>
    <div class="flex flex-col xl:flex-row bg-center  min-h-[532px]  bg-cover h-full">
        <!-- home-accordion-container -->
        <?php
        if (count($sub_regions) > 0) {
            foreach ($sub_regions as $key => $sub_region_id) {
                $region_color = (get_field('sub_region_color', $sub_region_id)) ? get_field('sub_region_color', $sub_region_id) : '';
                list($r, $g, $b) = sscanf($region_color, "#%02x%02x%02x");
                ?>
                <div class="region-panel home-accordion  relative overflow-hidden group py-9 sm:py-16 pl-[72px] xl:hover:pl-10 xl:flex-shrink px-10 flex flex-col xl:flex-row  bg-blend-lighten transition-all duration-[0.6s] ease-in-out cursor-pointer "
                    style="background: linear-gradient(0deg, rgba(0, 0, 0, 0.20) 0%, rgba(0, 0, 0, 0.20) 100%), linear-gradient(0deg, rgba(0, 0, 0, 0.20) 0%, rgba(0, 0, 0, 0.20) 100%), rgba(<?php echo "{$r}, {$g}, {$b}"; ?>, 0.80);">
                    <h2 class="text-[#fff]  relative max-xl:text-center">
                        <?php echo get_the_title($sub_region_id); ?>
                    </h2>
                    <div class="relative xl:max-w-0  xl:group-hover:max-w-[1100px] group-hover:w-auto overflow-x-hidden xl:w-0">
                        <div
                            class="inner-content min-[1366px]:justify-between gap-x-5 h-full flex  max-xl:mt-8 xl:pl-10 xl:border-solid xl:border-0 xl:border-l xl:flex-shrink xl:min-w-[465px] min-[1366px]:min-w-[500px]  lg:border-[#fff] lg:ml-5 items-end transition-all duration-[0.4s] ease-in-out">
                            <?php echo get_sub_region_countries($sub_region_id, 7); ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo 'No data selected.';
        } ?>
    </div>
</section>