<?php
$id = '' . $block['id'];
$className = '';

if (!empty($block['className'])) {
    $className .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
    $className .= ' align' . $block['align'];
}

$section_title = get_field('section_title');
$background_image = ($background_image = get_field('background_image')) ? $background_image : '';
$cta_buttons = (get_field('cta_buttons')) ?: [];

$styles = "#{$id}.layout-3-column{
    background: url('{$background_image}'),lightgray 0px -569.005px / 100% 294.477% no-repeat;background-size: cover;
    background-repeat: no-repeat;
    // background-blend-mode: hard-light, normal;
    background-position: center bottom 55%;
    background-blend-mode: luminosity;

    &::before {
        content: '';
        width: 100%;
        height: 100%;
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(48, 57, 120, 0) 0%, #161b40 100%, #1c224d 100%);
        z-index: 10;
      }

}";
?>


<section id="<?php echo $id; ?>" class="layout-3-column<?php echo esc_attr($className); ?> relative why-seap-section ">
    <style id='<?php echo $id; ?>-styles-inline-css' type='text/css'>
        <?php echo $styles;
        ?>
    </style>
    <div class="section relative pt-[62px] sm:pt-[157px] pb-8 sm:pb-12  text-white">
        <div class="container relative z-20">
            <div class="wrapper-section pb-12 sm:pb-20">
                <?php if ($section_title) { ?>
                    <div class="section_title mb-12 sm:mb-20 md:mb-[114px]">
                        <h2 class="max-sm:text-center">
                            <?php echo $section_title; ?>
                        </h2>
                    </div>
                <?php } ?>

                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
                    <?php
                    if (have_rows('columns')) {
                        while (have_rows('columns')) {
                            the_row();
                            $title = get_sub_field('title');
                            $content = get_sub_field('content');
                    ?>
                            <div class="item">
                                <h3 class="mb-1 max-sm:text-xl max-sm:leading-none sm:mb-4 leading-none tracking-[-1.312px]">
                                    <?php echo $title; ?>
                                </h3>
                                <div class="text-bg opacity-90">
                                    <?php echo $content; ?>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <?php
            if ($cta_buttons) {
                foreach ($cta_buttons as $button) {
                    if (empty($button['label'])) {
                        continue;
                    }
                    $options = array(
                        'class' => 'about-report-btn',
                        'text' => $button['label'],
                        'url' => ($button['link']) ?: '#',
                    );
                    echo text_button($options);
                }
                // $options = array(
                //     'class' => 'about-report-btn',
                //     'text' => 'About the report',
                //     'url' => home_url('/about-seap-report/'),
                // );
                // echo text_button($options);
            }


            ?>
            <?php ?>
        </div>
    </div>
</section>