jQuery(function ($) {
  if (window.acf) {
    window.acf.addAction('render_block_preview/type=seap/stakeholders', stakeholderScript);
  }

  function stakeholderScript(block) {
    let swiperEl = block.find('.stakeholderSwiper')[0];

    var init = new Swiper(swiperEl, {
      slidesPerView: 3,
      centeredSlides: false,
      spaceBetween: 24,
      grabCursor: true,
      loop: true,
    });
  }
});
