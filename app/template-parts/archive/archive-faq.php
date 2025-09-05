<?php
$posttype = get_post_type();
$faq_category = get_terms(['taxonomy' => 'faq-category']);
$get_faq_page_information = get_seap_faq_page_information();
echo page_hero_content();
?>
<div id="<?php echo $posttype; ?>-archive" class="faq how-to-use">
    <div class="container mt-[60px] mb-24">
        <?php seap_search_box(['class' => 'faq-search mb-[60px]']); ?>
        <p class="text-n-40 text-sm sm:text-base md:text-lg text-center">
            <?php echo $get_faq_page_information['search_description']; ?>
        </p>
        <div class="mt-8 md:mt-[77px] mb-[120px] max-w-[1015px] mx-auto grid">
            <div class="flex flex-col md:flex-row gap-x-16 pb-[60px]">
                <?php
                if ($faq_category) {
                ?>
                    <aside id="sidebar" class="aside faq-category basis-[25%]">
                        <ul class="max-md:flex items-center sm:max-md:justify-center mx-auto max-md:gap-2 max-md:overflow-x-auto">
                            <li class="max-md:shrink-0 max-md:mb-3 max-md:text-sm">
                                <a data-filter="all" href="#" class="active py-3 block">
                                    <?php echo __('All Guides', 'seap'); ?>
                                </a>
                            </li>
                            <?php
                            foreach ($faq_category as $key => $category) {
                            ?>
                                <li class="max-md:shrink-0 max-md:mb-3">
                                    <a data-filter="<?php echo $category->slug; ?>" href="#" class="py-3 block">
                                        <?php echo $category->name; ?>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </aside>
                <?php
                }
                ?>
                <div class="faq-content w-full">
                    <?php
                    if (have_posts()) {
                        while (have_posts()) {
                            the_post();
                            $id = get_the_ID();
                            $category = get_the_terms($id, 'faq-category');
                            $class_name = '';
                            if ($category) {
                                foreach ($category as $key => $value) {
                                    $class_name .= " " . $value->slug;
                                }
                            }
                            $faq_video = (get_field('faq_video')) ?: '';
                            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $faq_video, $match);
                            if ($match) {
                                $youtube_id = $match[1];
                                $embedUrl = "https://www.youtube.com/embed/" . $youtube_id;
                            }
                            // $image = get_template_directory_uri() . './assets/images/stakeholders-bg.jpg';
                            $oEmbed = get_field('faq_video');
                            $image = ($oEmbed) ? acf_youtube_thumbnail($oEmbed) : get_the_post_thumbnail($id, 'large');
                    ?>
                            <div class="each-faq <?php echo $class_name; ?> ">
                                <div class="faq-question gap-3 py-6 text-base md:text-2xl text-n-60 font-semibold flex cursor-pointer">
                                    <span class="left-arrow text-[10px] flex items-center">
                                        <?php echo useSVG('faq-left-arrow'); ?>
                                    </span>
                                    <?php echo get_the_title(); ?>
                                </div>
                                <div class=" faq-answer max-h-0 overflow-hidden">
                                    <?php the_content(); ?>
                                    <?php
                                    if ($faq_video) {
                                    ?>
                                        <div class="faq-video">
                                            <div class="iframe-holder relative overflow-hidden pt-[54%]">
                                                <iframe loading="lazy" frameborder="0" allowfullscreen="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" title="<?php echo $title; ?>" width="640" height="360" src="<?php echo ($embedUrl); ?>" class=" absolute w-full h-full top-0 object-cover"></iframe>
                                            </div>
                                            <!-- For pop-up video -->
                                            <!-- <div data-src="< ?php echo $embedUrl; ?>"
                                                class=" relative pt-[62%] video-thumbnail-image group cursor-pointer ">
                                                < ?php echo $image; ?>
                                            <div class=" video-play-btn text-[64px]">
                                                < ?php echo useSVG('play-btn'); ?>
                                            </div>
                                             </div> -->
                                            <!-- <div class="fixed z-50 w-full h-full popup-video invisible">
                                                <div class="container z-[50] max-w-[1018px] popup-wrapper relative">
                                                    <div class="iframe-holder relative overflow-hidden pt-[54%]">
                                                        <iframe loading="lazy" frameborder="0" allowfullscreen=""
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                            title="< ?php echo $title; ?>" width="640" height="360"
                                                            src="< ?php echo ($embedUrl); ?>"
                                                            class=" absolute w-full h-full top-0 object-cover"></iframe>
                                                    </div>
                                                    <div
                                                        class="absolute video-close text-sx right-[7px] top-[-9px] cursor-pointer   bg-white rounded-full leading-[0]">
                                                        < ?php echo useSVG('close'); ?>
                                                    </div>
                                                </div>
                                                <div id="pop-up__overlay"> </div>
                                            </div> -->
                                            <!-- end pop-up video -->
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                    <div class="each-faq search-empty" style="display: none;">
                        <p class="flex justify-center py-6 text-center">No results found matching your search keyword.
                            Please
                            consider
                            trying different keywords.</p>
                    </div>
                </div>
            </div>
            <div class="contact-detail pt-[20px] md:pt-[60px] max-w-[601px] mx-auto">
                <div class="grid gap-3 justify-items-center text-n-40 mb-10">
                    <h3>
                        <?php echo $get_faq_page_information['contact_block_header']; ?>
                    </h3>
                    <p class="sm:text-lg">
                        <?php echo $get_faq_page_information['contact_block_body']; ?>
                    </p>
                </div>
                <?php
                $contact_info = get_seap_contact_information();
                if ($contact_info) {
                ?>
                    <div class="contact-info flex flex-col sm:flex-row justify-center gap-5 ">
                        <!-- grid sm:grid-cols-2 gap-5 -->
                        <?php if ($contact_info['phone_number_1'] || $contact_info['phone_number_2']) { ?>
                            <div class="phone-detail grid justify-items-center flex-1 shrink-0 sm:basis-1/2">
                                <div class="icon mb-3">
                                    <?php echo useSVG('phone-primary'); ?>
                                </div>
                                <ul class="text-sm text-n-40 font-bold">
                                    <li>
                                        <a href="tel:<?php echo ($contact_info['phone_number_1']) ?: ''; ?>">
                                            <?php echo ($contact_info['phone_number_1']) ?: ''; ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="tel:<?php echo ($contact_info['phone_number_2']) ?: ''; ?>">
                                            <?php echo ($contact_info['phone_number_2']) ?: ''; ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        <?php } ?>
                        <div class="grid justify-items-center email-detail sm:basis-1/2">
                            <span class="icon mb-3">
                                <?php echo useSVG('email'); ?>
                            </span>
                            <div class="text-sm font-bold text-n-40">
                                <a href="mailto:<?php echo $contact_info['email_address']; ?>">
                                    <?php echo $contact_info['email_address']; ?>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>