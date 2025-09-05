<?php
$id = '' . $block['id'];
$className = 'compare-country';

if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

/**
 * =================================================
 * Get acf field values
 * =================================================
 */
$title = (get_field('title')) ?: __('Compare countries', 'seap');
$description = (get_field('description')) ?: __('Choose a theme to discover in-depth comparison between countries', 'seap');

/**
 * =================================================
 * HTML output of the chart block
 * =================================================
 */
?>


<section id="<?php echo $id; ?>" class="<?php echo esc_attr($className); ?> home-compare-countries overflow-hidden">
    <div class="container pt-20 md:py-28 grid sm:grid-cols-2 gap-y-5 gap-x-12 relative">

        <div class="pr-7">
            <div class="max-sm:max-w-[300px] inline-flex flex-col lg:flex-row gap-3 sm:gap-5 lg:items-end">
                <div class="title flex-1 w-fit">
                    <h2 class="font-semibold text-b-40 leading-none">
                        <?php echo $title; ?>
                    </h2>
                </div>
                <div class="description paragraph-small leading-[1.6] lg:w-full flex-shrink-0">
                    <p class="max-w-[256px]"> <?php echo $description; ?></p>
                </div>
            </div>
        </div>
        <div class="compare-category">
            <ul class="grid compare-category__wrapper">
                <li class="text-sm sm:text-xl item">
                    <a href="/compare-countries?theme=laws" class="py-4 px-2 flex justify-between items-center">
                        <div class="compare-title font-bold text-n-60">
                            <span class="item-icon text-[#aeaaa8]">
                                <?php echo useSvg('law'); ?>
                            </span>
                            <span> Laws </span>
                        </div>
                        <div class="compare-btn sm:invisible sm:opacity-0">
                            <span class="btn"> Compare </span>
                        </div>
                    </a>
                </li>
                <li class="text-sm sm:text-xl item">
                    <a href="/compare-countries?theme=population" class="py-4 px-2 flex justify-between items-center">
                        <div class="compare-title font-bold text-n-60">
                            <span class="item-icon text-[#aeaaa8]">
                                <?php echo useSvg('population'); ?>
                            </span>
                            <span> Population </span>
                        </div>

                        <div class="compare-btn sm:invisible sm:opacity-0">
                            <span class="btn">Compare</span>
                        </div>
                    </a>
                </li>
                <li class="text-sm sm:text-xl item">
                    <a href="/compare-countries?theme=causes-of-statelessness"
                        class="py-4 px-2 flex justify-between items-center">
                        <div class="compare-title font-bold text-n-60">
                            <span class="item-icon text-[#aeaaa8]">
                                <?php echo useSvg('cause'); ?>
                            </span>
                            <span> Causes of statelessness </span>
                        </div>
                        <div class="compare-btn sm:invisible sm:opacity-0">
                            <span class="btn"> Compare </span>
                        </div>
                    </a>
                </li>
            </ul>

        </div>
        <div
            class="max-sm:mt-1 stakeholder-map relative max-sm:pt-[52%] sm:absolute sm:bottom-0 sm:left-9 w-full h-full sm:w-[55%] sm:h-[55%]">
            <img src="<?php echo get_template_directory_uri() .
                '/assets/images/home-compare-countries-update.svg'; ?>" alt="home-compare-countries"
                id="stakeholder-map__image" class="stakeholder-map__img absolute inset-0 w-full h-full  object-contain"
                loading="lazy">
        </div>

    </div>
</section>