<?php

$GET_search = (isset($_GET['s'])) ? $_GET['s'] : '';
?>
<div class="search-archive container pt-24 sm:pt-32 pb-7">
    <div class="mx-auto max-w-[808px]">
        <div class="grid gap-5 sm:gap-7 mb-5 sm:mb-9">
            <h3>Search Results</h3>
            <div class="search relative">
                <div class="search__wrapper">
                    <div class="search-result">
                        <div class="w-full h-full relative">
                            <div class="relative pointer-events-auto">
                                <form role="search" id="search-form" action="<?php echo home_url(); ?>" method="get"
                                    class="search-form w-full pointer-events-auto relative">
                                    <div class=" search__form--wrapper flex bg-n-50 rounded overflow-hidden relative">
                                        <input type="search"
                                            class="search-input border border-n-20 w-full bg-white pl-9 pr-4 text-n-30 text-sm "
                                            placeholder="Search..." aria-label="search nico" name="s" id="search-input"
                                            value="<?php echo $GET_search; ?>">
                                        <button
                                            class="shrink-0 cursor-pointer search-button -ml-1 py-2 px-4 sm:py-3 sm:px-6 md:py-4 md:sm:px-10 rounded-e bg-b-40 hover:bg-b-50 border border-b-40 overflow-hidden transition-all ease">
                                            <span class="text-sm text-white"> Search </span>
                                            <button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-sm text-n-40 font-bold">
                <?php
                if (have_posts()) {
                    seap_search_count_info();
                    ?>
                <?php } ?>
            </div>
        </div>


        <div class="search-contain">
            <div id="filter-area">
                <?php
                if (have_posts()) {
                    ?>
                    <div class="search-result mb-14 grid gap-4 sm:gap-6">
                        <?php
                        while (have_posts()) {
                            the_post();
                            $id = get_the_ID();
                            ?>
                            <div class="search-item border-b border-n-10 pb-4 sm:pb-6">
                                <div class="text-xs text-n-30 font-bold">
                                    <?php echo get_post_type_object(get_post_type())->label; ?>
                                </div>
                                <div class="text-xl font-bold text-n-60">
                                    <a href="<?php echo get_the_permalink(); ?>">
                                        <?php echo get_the_title(); ?>
                                    </a>
                                </div>

                                <?php
                                if ($get_region_location = get_region_location()) {
                                    ?>
                                    <div class="search-item__country flex text-xs gap-x-[6px]">
                                        <span class="text-b-40">
                                            <?php echo useSVG('global'); ?>
                                        </span>
                                        <span class="">
                                            <?php echo $get_region_location; ?>
                                        </span>
                                    </div>

                                    <?php
                                }

                                ?>
                                <?php if (excerpt()) { ?>
                                    <div class="pt-3 text-sm text-n-40">
                                        <?php echo excerpt(); ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    ?>
                    <div class="no-result grid gap-8 sm:gap-12 md:gap-14 justify-items-center ">
                        <div class="max-w-[496px] text-center">
                            <h5 class="leading-[1.33] max-sm:mb-3">There are no results for this search.</h5>
                            <p class="text-n-50 max-sm:text-sm">

                                No results found matching your search keyword. Please consider trying different keywords or
                                need further assistance, please contact at info@nationalityforall.org.
                            </p>
                        </div>

                        <?php $options = array(
                            'text' => 'Back to Home',
                            'url' => home_url('home'),
                        );
                        echo primary_button($options);
                        ?>

                    </div>
                    <?php
                }
                echo main_query_pagination();
                ?>
            </div>
        </div>
    </div>
</div>