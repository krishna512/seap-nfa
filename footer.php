<?php

/**
 * The template for displaying the footer.
 *
 * Contains the body & html closing tags.
 *
 * @package seap
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
$contact_info = get_seap_contact_information();
$footer_info = get_seap_footer_information();

?>

<div class="relative pt-[13%] footer-design">
    <img src="<?php echo get_template_directory_uri() .
        '/assets/images/bg-img.png'; ?>" alt="Footer design"
        class="absolute inset-0 object-cover object-top w-full h-full">
</div>
<footer class="relative bg-b-40">
    <img src="<?php echo get_template_directory_uri() .
        '/assets/images/footer-background.png'; ?>" alt="Footer Background Image" srcset="" loading="lazy"
        class="absolute bottom-0 z-0 sm:h-full opacity-50 left-1/2 footer-image mix-blend-color-burn max-sm:object-contain">
    <div class="relative">
        <div class="container">
            <div class="flex justify-between flex-wrap py-10 gap-8">
                <div class="max-w-[428px]">
                    <div class="text-4xl">
                        <?php echo useSVG('logo-white') ?>
                    </div>
                    <div class="mt-2">
                        <p class="display-small text-bg sm:text-[36px] sm:leading-none">
                            <?php
                            echo $footer_info['footer_header'];
                            ?>
                        </p>
                    </div>
                    <div class="footer-dropdown-btn">
                        <?php
                        if ($footer_info['footer_button_type'] == 'single') {
                            if ($footer_info['footer_button_label']) {
                                ?>
                        <div class="">
                            <a href="<?php echo $footer_info['footer_button_link']; ?>"
                                class="button-white grid text-sm" download>
                                <div> <?php echo $footer_info['footer_button_label']; ?> </div>
                            </a>
                        </div>
                        <?php
                            }
                        } elseif ($footer_info['footer_button_type'] == 'expand_drop_down') {
                            echo explore_drop_down_buttons($footer_info['explore_drop_down_buttons'], 'dropdown-btn-white');
                        } else {
                        }
                        ?>
                    </div>
                </div>
                <div class="flex flex-col gap-8">
                    <?php if ($footer_info['quick_links']) { ?>
                    <div class="text-n-0 ">
                        <p class="label-small">Quick Links</p>
                        <div class="caption-regular">
                            <?php
                                foreach ($footer_info['quick_links'] as $key => $quick_links) {
                                    ?>
                            <div class="flex items-center mt-2">
                                <a href="<?php echo $quick_links['link']; ?>" class="hover:underline duration-200 ease">
                                    <?php echo $quick_links['label']; ?>
                                </a>
                            </div>
                            <?php
                                }
                                ?>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="text-n-0">
                        <p class="label-small">Contact Us:</p>
                        <div class="caption-regular">
                            <?php if ($contact_info['phone_number_1'] || $contact_info['phone_number_2']) { ?>
                            <div class="flex items-center mt-3 sm:mt-4 gap-x-3">
                                <p class="text-lg">
                                    <?php echo useSVG('phone'); ?>
                                </p>
                                <p>Phone:
                                    <?php
                                        echo '<a href="tel:' . $contact_info['phone_number_1'] . '">' . $contact_info['phone_number_1'] . '</a>';

                                        if ($contact_info['phone_number_2']) {
                                            echo ', <a href="tel:' . $contact_info['phone_number_2'] . '">' . $contact_info['phone_number_2'] . '</a>';
                                        }
                                        ?>

                                </p>
                            </div>
                            <?php } ?>
                            <div class="flex items-center mt-2 sm:mt-4 gap-x-3">
                                <p class="text-lg">
                                    <?php echo useSVG('mail'); ?>
                                </p>
                                <p>Email:
                                    <a
                                        href="mailto:<?php echo ($contact_info['email_address']) ?: 'email_address@gmail.org.np'; ?>">
                                        <?php echo ($contact_info['email_address']) ?: 'email_address@gmail.org.np'; ?>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 sm:pt-3 line-container pb-7 sm:pb-14 container">
            <div class="flex flex-wrap gap-2 justify-center sm:justify-between  text-bg">
                <div>
                    <p class="caption-regular opacity-80 leading-[2]">©
                        <?php echo date('Y') . ' ' . $footer_info['copyright']; ?>
                    </p>
                </div>
                <div class="flex gap-x-4">
                    <p class="caption-regular opacity-80 leading-[2]">
                        <?php
                        if ($footer_info['terms_and_conditions_link']) {
                            ?>
                        <a href="<?php echo $footer_info['terms_and_conditions_link']; ?>">Terms & Conditions</a>
                        <?php
                        } else {
                            echo "Terms & Conditions";
                        }
                        ?>
                    </p>
                    <p class="caption-regular opacity-80 leading-[2]">
                        <?php
                        if ($footer_info['privacy_policy_link']) {
                            ?>
                        <a href="<?php echo $footer_info['privacy_policy_link']; ?>">Privacy Policy</a>
                        <?php
                        } else {
                            echo "Privacy Policy";
                        }
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

</footer>

<?php wp_footer(); ?>

</body>

</html>