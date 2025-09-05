jQuery(function ($) {
  let swiper = new Swiper('.stakeholderSwiper', {
    loop: true,
    slidesPerView: 1,
    grabCursor: true,
    spaceBetween: 16,
    freeMode: true,
    allowTouchMove: true,
    loopedSlides: 5, // Number of duplicated slides for seamless loop
    speed: 6500,
    freeModeMomentum: false,
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true,
    },

    breakpoints: {
      640: {
        slidesPerView: 2,
        autoplay: {
          delay: 0,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        allowTouchMove: false,
        pagination: false, // Disable pagination on screens wider than 640px
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 24,
        autoplay: {
          delay: 0,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        pagination: false, // Disable pagination on screens wider than 640px
      },
      1000: {
        slidesPerView: 4,
        spaceBetween: 24,
        autoplay: {
          delay: 0,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        pagination: false, // Disable pagination on screens wider than 640px
      },
      1280: {
        slidesPerView: 5,
        spaceBetween: 24,
        centeredSlides: true,
        autoplay: {
          delay: 0,
          disableOnInteraction: false,
          pauseOnMouseEnter: true,
        },
        pagination: false, // Disable pagination on screens wider than 640px
      },
    },
  });

  const startPlay = () => {
    swiper.autoplay.start();
  };

  const stopPlay = () => {
    swiper.autoplay.stop();
  };

  const sliderElement = document.getElementById('stakeholder-slider');
  let isInView = false;

  let options = {
    root: null, // Use the viewport as the root
    rootMargin: '0px', // No margin
    threshold: 0, // Trigger when any part of the target is visible
  };

  // Callback function when intersection changes
  function handleIntersection(entries, observer) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        element.style.transform = 'translateX(00%)';
        setTimeout(() => {
          startPlay();
        }, 4500);
        setTimeout(() => {
          swiper.params.slidesOffsetBefore = 0;
          swiper.update();
        }, 100);
      } else {
        stopPlay();
      }
    });
  }

  // Create Intersection Observer instance
  let observer = new IntersectionObserver(handleIntersection, options);

  // Get the element by its ID
  let element = document.getElementById('stakeholder-slider');
  element.style.transition = '4.5s linear'; // 0.5s is the duration, and linear is the timing function

  if (window.innerWidth > 640) {
    element.style.transform = 'translateX(30%)';
  }

  element.addEventListener('mouseenter', () => {
    stopPlay();

    const computedStyle = window.getComputedStyle(element);
    currentTransform = computedStyle.transform;
    console.log(currentTransform, 'inside');
    element.style.transition = 'none'; // Disable transition on hover
    element.style.transform = currentTransform; // Apply current transform value
  });

  element.addEventListener('mouseleave', () => {
    console.log('outside');
    element.style.transform = 'translateX(0%)';
    startPlay();
    element.style.transition = '3s linear'; // Restore transition effect after hover
  });

  // Start observing the element
  observer.observe(element);

  stopPlay();
});

//centerMode
