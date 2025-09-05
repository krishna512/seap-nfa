jQuery(function ($) {
  /** Write code */
  /**
   * =================================================
   * Header Scroll
   * =================================================
   */
  $(function () {
    const mainHeader = $('.header');
    let scrolling = false;
    let previousTop = 0;

    function scrollTrigger() {
      const scrollTop = $(window).scrollTop();

      mainHeader.toggleClass('scrolled', scrollTop > 5);

      checkSimpleNavigation(scrollTop);
    }

    function checkSimpleNavigation(currentTop) {
      const scrollDelta = 1;
      const scrollOffset = 0;
      const isScrollingUp = currentTop < previousTop;

      if (currentTop === 0 || isScrollingUp) {
        mainHeader.removeClass('is-hidden');
      } else if (currentTop - previousTop > scrollDelta && currentTop > scrollOffset) {
        mainHeader.addClass('is-hidden');
      }

      previousTop = currentTop;
    }

    function autoHideHeader() {
      const currentTop = $(window).scrollTop();
      checkSimpleNavigation(currentTop);
      scrolling = false;
    }

    $(window).on('load scroll', function () {
      scrollTrigger();
      if (!scrolling) {
        scrolling = true;
        !window.requestAnimationFrame ? setTimeout(autoHideHeader, 0) : requestAnimationFrame(autoHideHeader);
      }
    });
  });

  /**
   * =================================================
   * Hamburger-menu
   * =================================================
   */
  $('#hamburger').on('click', function (e) {
    e.stopPropagation();

    $(this).toggleClass('open');
    $('.hamburger-content').toggleClass('open');
    $('.hamburger-menu').toggleClass('active');
    $('body').toggleClass('no-scroll');
    $('#overlay').toggleClass('overlay');
    $('#hamburger-overlay').toggleClass('hamburger-overlay');

    $(document).on('keydown.closeNav', function (e) {
      if (e.keyCode === 27) {
        closeNav();
      }
    });
  });

  $('#overlay, #hamburger-overlay').on('click', function () {
    closeNav();
  });

  $(document).on('click,closeNav', function (e) {
    if (!$(e.target).closest('.hamburger-content, #hamburger').length > 0) {
      closeNav();
    }
  });

  function closeNav() {
    $('#hamburger').removeClass('open');
    $('.hamburger-content').removeClass('open');
    $('body').removeClass('no-scroll');
    $('#overlay').removeClass('overlay');
    $('#hamburger-overlay').removeClass('hamburger-overlay');
    $('.hamburger-menu').removeClass('active');
    $(document).off('closeNav');
  }

  // // Add class on Nav li item

  // $('.hamburger-menu__item:has(.hamburger-menu__sub-menu)').each(function () {
  //   $(this).addClass('menu-item-has-children');
  // });

  /**
   * =================================================
   * Nav  content toggle
   * =================================================
   */

  $('.hamburger-main-title .menu-item-has-children:has(.seap-child-hamburger-menu) > .nav-title-wrapper').on(
    'click',
    function () {
      $(this).toggleClass('active');
      $(this).siblings().slideToggle();
    }
  );

  $(window).on('resize', function (e) {
    if ($(window).width() > 1024) {
      if (!$(e.target).closest('.hamburger-content, #hamburger').length > 0) {
        closeNav();
      }
      closeNav();
    }
  });

  /**
   * =================================================
   * Nav content toggle
   * =================================================
   */

  $(
    '.hamburger-menu__wrapper > .menu-item-has-children, .hamburger-menu__wrapper .sub-menu .menu-item-has-children'
  ).on('click', function () {
    $(this).toggleClass('active');
    $(this).children().next().slideToggle();
  });

  $(window).on('resize', function (e) {
    if ($(window).width() > 1024) {
      if (!$(e.target).closest('.hamburger-content, #hamburger').length > 0) {
        closeNav();
      }
      closeNav();
    }
  });

  /**
   * =================================================
   * check the bottom touch
   * =================================================
   */

  function adjustDownloadContentPosition() {
    const $content = $('.footer-dropdown-btn .download-wrapper .download-content');
    if (!$content.length) return;

    $content.removeClass('upward-dropdown');

    let contentBottom = $content.offset().top + $content.outerHeight();
    let windowBottom = $(window).scrollTop() + $(window).height();

    if (contentBottom > windowBottom) {
      $content.addClass('upward-dropdown');
    }
  }

  // Initial load and on resize
  $(window).on('load resize', adjustDownloadContentPosition);

  // After dropdown opens
  $(document).on('click', '.footer-dropdown-btn', function () {
    setTimeout(adjustDownloadContentPosition, 50);
  });

  /**
   * =================================================
   * dropdown download button hover
   * =================================================
   */

  $(function () {
    let hoverTimeout;

    $('.download-wrapper').hover(
      function () {
        // Hover in
        const $this = $(this);
        clearTimeout(hoverTimeout);
        hoverTimeout = setTimeout(() => {
          $this.addClass('active');
          $this.find('.download-content').addClass('open');
        }, 300);
      },
      function () {
        // Hover out
        const $this = $(this);
        clearTimeout(hoverTimeout);
        hoverTimeout = setTimeout(() => {
          $this.removeClass('active');
          $this.find('.download-content').removeClass('open');
        }, 300);
      }
    );
  });

  //   $(function () {
  //   $('.download-btn-toggle, .download-content').hover(
  //     function () {
  //       $('.download-btn-toggle').addClass('active');
  //       $('.download-content').addClass('open');
  //     },
  //     function () {
  //       setTimeout(function () {
  //         if (!$('.download-btn-toggle:hover').length && !$('.download-content:hover').length) {
  //           $('.download-btn-toggle').removeClass('active');
  //           $('.download-content').removeClass('open');
  //         }
  //       }, 200);
  //     }
  //   );
  // });

  /**
   * =================================================
   * Search Modal
   * =================================================
   */

  $('body').on('click', '.search__icon, #search__overlay, .close-btn', () => {
    $('.search__modal, #search__overlay').toggleClass('open-search-modal');
    // $('#search__overlay').toggleClass('search-modal__overlay');
    $('body').toggleClass('overflow-hidden');

    let $parent = $('.search__modal input.search-input').parent();
    $parent.css('visibility', 'visible');

    // Focus on the input field
    $('.search__modal input.search-input').focus().addClass('red');
  });

  /**
   * =================================================
   * Add focus on search input field when load a page
   * =================================================
   */

  window.onload = function () {
    let $parent = $('.search-result input.search-input').parent();
    $parent.css('visibility', 'visible');
    $('.search-result  .search-input').focus().addClass('check');
  };

  /**
   * =================================================
   * Region Panel
   * =================================================
   */
  function openRegionPanel() {
    if ($(window).width() <= 1200) {
      $('.region-panel').not(this).removeClass('open').children().next().slideUp();
      $(this).toggleClass('open').children().next().slideToggle();
    }
  }

  $('.region-panel').on('click', function (event) {
    openRegionPanel.call(this);
    event.stopPropagation();
  });

  function closeAllRegions() {
    if ($(window).width() > 1200) {
      $('.region-panel').removeClass('open').children().next().slideDown();
    } else {
      $('.region-panel').removeClass('open').children().next().slideUp();
    }
  }

  closeAllRegions();

  $(window).on('resize', function () {
    closeAllRegions();
  });

  $(document).on('click touchstart', function (event) {
    if (!$(event.target).closest('.region-panel').length) {
      closeAllRegions();
    }
  });

  /**
   * =================================================
   * FAQ Accordion
   * =================================================
  //  */

  // function openRegionPanel() {
  //   if ($(window).width() <= 1024) {
  //     $(this).toggleClass('open');
  //     $(this).children().next().slideToggle();
  //   }
  // }

  // $('.region-panel')
  //   .on('mouseenter', function () {
  //     openRegionPanel.call(this);
  //   })
  //   .on('mouseleave', function () {
  //     if ($(window).width() <= 1024) {
  //       $(this).removeClass('open').children().next().slideUp();
  //     }
  //   });

  // function closeAllRegions() {
  //   if ($(window).width() > 1024) {
  //     $('.region-panel').removeClass('open').children().next().slideDown();
  //   } else {
  //     $('.region-panel').removeClass('open').children().next().slideUp();
  //   }
  // }

  // closeAllRegions();

  $(document).ready(function () {
    $('.faq-question').on('click', function () {
      const panel = $(this).next();

      if (panel.css('max-height') !== '0px') {
        panel.css('margin-bottom', '');
        panel.css('max-height', '0');
        $(this).removeClass('active');
      } else {
        // $('.faq-question').not(this).removeClass('active').next().css({
        //   'margin-bottom': '',
        //   'max-height': '0',
        // });

        panel.css('margin-bottom', '24px');
        panel.css('max-height', panel.prop('scrollHeight') + 'px');
        $(this).addClass('active');
      }
    });
  });

  /**
   * =================================================
   * popUp Modal for region and countires
   * =================================================
   */

  $('body').on('click', '.btn-open, #pop-up__overlay, .video-close', () => {
    $('.popup-wrapper, #pop-up__overlay').toggleClass('show');
    $('body').toggleClass('overflow-hidden');
  });

  // /**
  //  * =================================================
  //  * popUp Modal
  //  * =================================================
  //  */

  // $('body').on('click', '.video-thumbnail-image, #pop-up__overlay, .video-close', () => {
  //   $('.popup-video, #pop-up__overlay').toggleClass('show');

  //   // $('#search__overlay').toggleClass('search-modal__overlay');
  //   $('body').toggleClass('overflow-hidden');
  // });
  /**
   * =================================================
   * check submenu position
   * =================================================
  //  */

  // // Assuming nav-sub-menu is the class of your submenu elements
  // let subMenus = $('.navbar-menu .navbar-menu--submenu');

  // subMenus.each(function () {
  //   // Get the right offset of the submenu
  //   var subMenuRightOffset = $(this).offset().left + $(this).outerWidth();

  //   // Get the screen width
  //   var screenWidth = $(window).width();

  //   // Check if submenu touches the end of the screen width
  //   if (subMenuRightOffset >= screenWidth) {
  //     console.log('Submenu touches the end of the screen width');
  //   } else {
  //     console.log('doesnot touch');
  //   }
  // });

  // // Function to check submenu position
  // function checkSubMenuPosition() {
  //   let subMenus = $('.navbar-menu .navbar-menu--submenu');

  //   subMenus.each(function () {
  //     let subMenuRightOffset = $(this).offset().left + $(this).outerWidth();

  //     let screenWidth = $(window).width();

  //     subMenuRightOffset >= screenWidth ? $(this).addClass('right-aligned') : $(this).removeClass('right-aligned');
  //   });
  // }

  // // Initial check on page load
  // checkSubMenuPosition();

  // // Check on window resize
  // $(window).resize(function () {
  //   checkSubMenuPosition();
  // });

  // Function to check submenu position

  function checkSubMenuPosition() {
    $('.navbar-menu .navbar-menu--submenu').each(function () {
      let subMenuRightOffset = $(this).offset().left + $(this).outerWidth();
      let screenWidth = $(window).width();
      let buffer = 15; // Adjust this value as needed

      // Check if the submenu's right edge is near the right edge of the screen
      if (subMenuRightOffset >= screenWidth - buffer) {
        $(this).addClass('right-aligned');
      } else {
        $(this).removeClass('right-aligned');
      }
    });
  }

  // Initial check on page load
  checkSubMenuPosition();

  // Check on window resize
  $(window).resize(function () {
    checkSubMenuPosition();
  });

  /**
   * =================================================
   * Change active scroll tab 
   * =================================================
  //  */

  $(window).scroll(function () {
    let scrollPosition = $(window).scrollTop();

    $('.secondary-menu_region ul li').each(function () {
      let currentTab = $(this);
      let targetLink = currentTab.find('a');

      if (targetLink.length === 0) {
        return;
      }

      let targetId = targetLink.attr('href');
      let targetElement = $(targetId);

      if (targetElement.length === 0) {
        return;
      }

      let targetOffset = targetElement.offset().top;

      if (scrollPosition + 50 >= targetOffset) {
        $('.secondary-menu_region ul li').removeClass('active');
        currentTab.addClass('active');
      }
    });
  });

  $('.seap-menu > li').hover(
    function () {
      // Close other open submenus immediately
      $('.seap-menu > li').not(this).removeClass('hover-active').find('.seap-child-menu').stop(true, true).slideUp(300);

      // Open the hovered submenu
      $(this).addClass('hover-active').find('.seap-child-menu').stop(true, true).delay(100).slideDown(300);
    },
    function () {
      // Optional: If you want to close submenu on mouseleave
      $(this).removeClass('hover-active').find('.seap-child-menu').stop(true, true).delay(100).slideUp(300);
    }
  );

  // knsdknd

  $(document).ready(function () {
    let hoverTimeout;

    function updateHasChildState() {
      const anyHoveredWithChild =
        $('.seap-menu > .nav-menu-item').filter(function () {
          return $(this).is(':hover') && $(this).find('.seap-child-menu').length > 0;
        }).length > 0;

      const childMenuHovered = $('.seap-child-menu:hover').length > 0;

      if (anyHoveredWithChild || childMenuHovered) {
        $('.seap-menu').addClass('has-child');
      } else {
        $('.seap-menu').removeClass('has-child');
      }
    }

    $('.seap-menu > .nav-menu-item').hover(
      function () {
        clearTimeout(hoverTimeout);
        updateHasChildState();
      },
      function () {
        clearTimeout(hoverTimeout);
        hoverTimeout = setTimeout(updateHasChildState, 300);
      }
    );

    $('.seap-child-menu').hover(
      function () {
        clearTimeout(hoverTimeout);
        updateHasChildState();
      },
      function () {
        hoverTimeout = setTimeout(updateHasChildState, 300);
      }
    );
  });

  // ?sdpndn

  // dsks
  $(document).ready(function () {
    $('.seap-menu > .nav-menu-item').each(function () {
      const $menuBlock = $(this);
      let removeTimeout;

      const $leftMenuItems = $menuBlock.find('.seap-child-left .nav-menu-item');
      const $rightMenuItems = $menuBlock.find('.seap-child-right .nav-menu-item');
      const $indicator = $menuBlock.find('.seap-child-left .indicator');

      function moveIndicatorTo(menuId) {
        const $target = $leftMenuItems.filter(`[menu-item="${menuId}"]`);
        if ($target.length && $indicator.length) {
          const offsetTop = $target.position().top;
          $indicator.css('top', offsetTop + 'px');
        }
      }

      function openRightItem(menuId) {
        $rightMenuItems.removeClass('open');
        $rightMenuItems.filter(`[menu-item="${menuId}"]`).addClass('open');
      }

      function openLeftItem(menuId) {
        $leftMenuItems.removeClass('open');
        $leftMenuItems.filter(`[menu-item="${menuId}"]`).addClass('open');
      }

      function syncIndicatorFromRight() {
        const $openRight = $rightMenuItems.filter('.open');
        if ($openRight.length) {
          const menuId = $openRight.attr('menu-item');
          moveIndicatorTo(menuId);
        }
      }

      // Cancel timeout on mouse enter
      $leftMenuItems.on('mouseenter', () => clearTimeout(removeTimeout));
      $rightMenuItems.on('mouseenter', () => clearTimeout(removeTimeout));

      // LEFT MENU hover
      $leftMenuItems.hover(
        function () {
          clearTimeout(removeTimeout);
          const menuId = $(this).attr('menu-item');
          openLeftItem(menuId);
          openRightItem(menuId);
          moveIndicatorTo(menuId);
        },
        function () {
          removeTimeout = setTimeout(() => {
            // If no right child hovered inside THIS block
            if ($menuBlock.find('.seap-child-right .nav-menu-item:hover').length === 0) {
              $rightMenuItems.removeClass('open').first().addClass('open');
              $leftMenuItems.removeClass('open').first().addClass('open');
              syncIndicatorFromRight();
            }
          }, 600);
        }
      );

      // RIGHT MENU hover
      $rightMenuItems.hover(
        function () {
          clearTimeout(removeTimeout);
          const menuId = $(this).attr('menu-item');
          openRightItem(menuId);
          openLeftItem(menuId);
          moveIndicatorTo(menuId);
        },
        function () {
          removeTimeout = setTimeout(() => {
            // If no left child hovered inside THIS block
            if ($menuBlock.find('.seap-child-left .nav-menu-item:hover').length === 0) {
              $rightMenuItems.removeClass('open').first().addClass('open');
              $leftMenuItems.removeClass('open').first().addClass('open');
              syncIndicatorFromRight();
            }
          }, 600);
        }
      );

      // Initial position
      syncIndicatorFromRight();
    });
  });

  /**
   * =================================================
   * place this placeholder ath bottom of the code
   *
   * @if no bugs this code will appear in console
   * =================================================
   */
  console.log('App Loaded Successfully.');
});

document.addEventListener('DOMContentLoaded', function () {
  const lightGalleryElement = document.getElementById('lightgallery');
  if (lightGalleryElement) {
    lightGallery(lightGalleryElement, {
      selector: '.item',
      thumbnail: true,
      zoom: true,
      actualSize: false,
      fullScreen: true,
    });
  }
});

// document.addEventListener('DOMContentLoaded', function () {
//   const secondaryMenu = document.querySelector('.secondary-menu_region');

//   const openMenu = (event) => {
//     event.stopPropagation();
//     secondaryMenu.classList.remove('hide');
//   };

//   const closeMenu = (event) => {
//     event.stopPropagation();
//     secondaryMenu.classList.add('hide');
//   };

//   document.addEventListener('click', (event) => closeMenu(event));

//   secondaryMenu.addEventListener('click', (event) => openMenu(event));

//   const hashPath = window.location.hash;
//   const overviewLink = document.querySelector('#overview-item');
//   console.log(hashPath);
//   if (hashPath === '#region-single') {
//     console.log('herw', overviewLink);
//     overviewLink.classList.add('active');
//   }
// });
