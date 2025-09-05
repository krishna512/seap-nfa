<section class="pt-24 min-h-screen flex items-center justify-center">
    <div class="container flex items-center justify-center overflow-hidden flex-col">
        <h1 class="text-6xl">
            Oops!
        </h1>
        <p class="pt-2">Page Not Found</p>

        <p class="pt-10 max-w-[600px] w-full text-center leading-[2] text-sm">We are very sorry for inconvenience. It
            looks
            like
            you're trying
            to access a
            page that either has
            been deleted or never even existed.</p>

        <div class="text-[140px] md:text-[300px] leading-[0] mt-10 relative">
            <div>
                <?php echo useSvg('404'); ?>
            </div>
            <div class="absolute left-[-150px] md:left-[90px] top-[-110px] md:top-[-245px] animate-bouncing -z-10">
                <?php echo useSvg('404-particles'); ?>
            </div>
        </div>
        <a href="/" class="mt-4 button-primary">Back to Home</a>
    </div>
</section>