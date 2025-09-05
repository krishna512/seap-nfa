jQuery(function ($) {
  /**
   * =========================================================
   * Make HTTP Object with javascript
   * https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest
   * =========================================================
   */

  function make_XMLHttpRequest() {
    try {
      return new XMLHttpRequest();
    } catch (error) {}
    try {
      return new ActiveXObject('Msxml2.XMLHTTP');
    } catch (error) {}
    try {
      return new ActiveXObject('Microsoft.XMLHTTP');
    } catch (error) {}

    throw new Error('Could not create HTTP request object.');
  }

  /**
   *
   * @param {*} filtr_area_id
   * @param {*} include_script
   * @returns
   */
  function get_XMLHttpRequest_Data(filtr_area_id = '', submission_link = '', include_chart_script = '', callback) {
    filtr_area_id = filtr_area_id ? filtr_area_id : '#filter-area';
    submission_link = submission_link ? submission_link : filter_form.attr('data-url') + '/?' + filter_form.serialize();
    var filter_area = $(filtr_area_id);
    filter_area.css('opacity', '0.6');
    filter_area.addClass('filter-area-loading');
    var failed_data = "<p class='failed-to-load'>Fail on loading data try again.</p>";
    var request = make_XMLHttpRequest();
    request.open('POST', submission_link, true);
    request.send(null);
    request.onreadystatechange = function () {
      if (request.readyState === XMLHttpRequest.DONE) {
        request.filter_area = false;
        if (request.status === 200) {
          var htmlDoc = $(request.responseText);
          var html_data = htmlDoc.find(filtr_area_id).html();
          if (html_data) {
            filter_area.html(html_data);
            if (include_chart_script) {
              get_include_chart_script(htmlDoc.prev());
            }
            window.history.replaceState('', 'url', submission_link);
            request.filter_area = true;
          } else {
            filter_area.html(failed_data);
          }
        } else {
          filter_area.html(failed_data);
        }
        filter_area.css('opacity', '1');
        filter_area.removeClass('filter-area-loading');
        if (callback) callback(request);
      }
    };
  }

  /**
   *
   * @param {*} prev_data
   */
  function get_include_chart_script(prev_data) {
    var apex_chart_js_data = '';
    prev_data.each(function (index, value) {
      var outerHTML = value.outerHTML;
      if (outerHTML.match('apex-chart-js-after')) {
        apex_chart_js_data = outerHTML;
      }
    });

    if (apex_chart_js_data) {
      if (document.getElementById('apex-chart-js-after')) {
        document.getElementById('apex-chart-js-after').remove();
      }
      $('body').append(apex_chart_js_data);
    }
  }

  /**
   * ============================================
   * Initialization variable
   * ============================================
   */
  var filter_form = $('form.filter-form');

  // don't include default form search filter in defined page id
  if (
    !document.getElementById('faq-archive') &&
    !document.getElementById('glossary-search-box') &&
    !document.getElementById('stakeholder-archive')
  ) {
    filter_form.on('submit', function (e) {
      e.preventDefault();
      var req = get_XMLHttpRequest_Data();
    });
  }

  /**
   * ============================================
   * Pagination filter
   * ============================================
   */
  $(document).on('click', '.pagination a', function (e) {
    e.stopPropagation();
    get_XMLHttpRequest_Data('', $(this).attr('href'), '', function (request) {
      if (request.filter_area) {
        $('html, body').animate(
          {
            scrollTop: $('#filter-area').offset().top - 250,
          },
          1000
        );
      }
    });
    return false;
  });

  /**
   * ============================================
   * News Archive Page START
   * ============================================
   */
  // if (document.getElementById('news-archive')) {
  // search_input.on("keypress", function (e) {
  //     if (e.keyCode == '13') {
  //         console.log('search_input enterr');
  //         return false;
  //     }
  // });
  // }

  /**
   * ============================================
   * Compare countries Page START
   * ============================================
   */
  if (document.getElementById('compare-countries')) {
    $('#compare-country-2').select2({
      templateSelection: format_template_countries,
      templateResult: format_template_countries,
    });
    $('#compare-country-1').select2({
      templateSelection: format_template_countries,
      templateResult: format_template_countries,
    });

    $('.secondary-menu_compare-countries .filter-theme').on('click', function (e) {
      e.stopPropagation();
      $('.secondary-menu_compare-countries .filter-theme').each(function () {
        $(this).removeClass('active');
      });
      $(this).addClass('active');
      $('.compare-countries .filter-form input[name="theme"]').attr('value', $(this).attr('theme-data'));
      compare_countries();
    });

    $('.filter-form .search-country').on('change', function (e) {
      e.preventDefault();
      compare_countries();
    });

    function compare_countries() {
      var country_1 = $('#compare-country-1').val();
      var country_2 = $('#compare-country-2').val();
      var error_data = '';
      var error_show = false;
      if (!country_1) {
        error_data = 'Please select first country.';
      } else if (!country_2) {
        error_data = 'Please select second country.';
      } else if (country_1 === country_2) {
        error_data = 'Both country cannot be same.';
        error_show = true;
      }
      if (error_data) {
        $('.form-validation').remove();
        if (error_show) {
          $('.secondary-menu_compare-countries').append('<p class="form-validation">' + error_data + '</p>');
        }
        $('#filter-area').html('');
        return false;
      }
      get_XMLHttpRequest_Data('', '', true);
      $('.form-validation').remove();
      return false;
    }
  }

  /**
   * ============================================
   * FAQ Page START
   * ============================================
   */
  if (document.getElementById('faq-archive')) {
    $('.faq-category li a').on('click', function (e) {
      e.stopPropagation();
      $('.faq-category li a').each(function () {
        $(this).removeClass('active');
      });
      $(this).addClass('active');
      var data_filter = $(this).attr('data-filter');
      $('.faq-content .each-faq ').each(function () {
        if ($(this).hasClass(data_filter) || data_filter === 'all') {
          $(this).show();
        } else {
          $(this).hide();
        }
      });
      $('#search_input').val('');
      $('.faq-content .search-empty').hide();
      return false;
    });
    filter_form.on('submit', function (e) {
      e.stopPropagation();
      faq_search();
      return false;
    });
    function faq_search() {
      var searchedText = $('#search_input').val().toLowerCase();
      var search_count = 0;
      $('.faq-question').each(function () {
        var text = $(this).text().toLowerCase();
        if (text.includes(searchedText)) {
          $(this).parent().show();
          search_count++;
        } else {
          $(this).parent().hide();
        }
      });
      if (search_count === 0) {
        $('.faq-content .search-empty').show();
      } else {
        $('.faq-content .search-empty').hide();
      }
    }
  }

  /**
   * ============================================
   * Region Page START
   * ============================================
   */
  if (document.getElementById('region-single')) {
    var hash = window.location.hash ? window.location.hash : '#overview';
    var compare_link = $('.compare-countris-btn').attr('href');
    if (hash) {
      hash = hash.replace('#', '');
      $('.secondary-menu_region .' + hash).addClass('active');
      if (compare_link && hash != 'overview') {
        compare_link = compare_link + '&theme=' + hash;
        $('.compare-countris-btn').attr('href', compare_link);
      }
    }
    $('.secondary-menu_region li').on('click', function () {
      $('.secondary-menu_region li').each(function () {
        $(this).removeClass('active');
      });
      $(this).addClass('active');
      compare_link = $('.compare-countris-btn').attr('href');
      if (compare_link) {
        compare_link = new URL(compare_link);
        compare_link.searchParams.set('theme', $(this).attr('theme-data'));
        compare_link = compare_link.href;
        $('.compare-countris-btn').attr('href', compare_link);
      }
    });
  }

  /**
   * ============================================
   * glossary-search-box
   * ============================================
   */
  if (document.getElementById('glossary-search-box')) {
    filter_form.on('submit', function (e) {
      e.stopPropagation();
      var submission_link = '/glossary/?' + filter_form.serialize();
      window.history.replaceState('', 'url', submission_link);
      return false;
    });
  }

  /**
   * ============================================
   * select2 dropdown format template
   * ============================================
   */
  function format_template_countries(state) {
    if (!state.id) {
      return state.text;
    }
    var flag_src = $(state.element).attr('flag_src');
    var $state = $(
      '<span><img src="' + flag_src + '" class="img-flag" /><span class="value-text">' + state.text + '</span></span>'
    );
    return $state;
  }
  function formatResult_Country(state, container) {
    if (!state.id) {
      return state.text;
    }
    var show = $(state.element).attr('show');
    if (show == 1 || show == '1') {
      var flag_src = $(state.element).attr('flag_src');
      var $state = $(
        '<span><img src="' + flag_src + '" class="img-flag" /><span class="value-text">' + state.text + '</span></span>'
      );
      return $state;
    }
    $(container).hide();
    return $('<span class="hide-list"></span>');
  }

  if ($('#search-drop-down').length) {
    $('#search-drop-down').select2();
  }

  if ($('#select-country').length) {
    $('#select-country').select2({
      templateSelection: format_template_countries,
      templateResult: formatResult_Country,
    });
  }
  if ($('#search-category').length) {
    $('#search-category').select2();
  }
  if ($('#search-submission').length) {
    $('#search-submission').select2();
  }
  /**
   * ============================================
   * stakeholder archive country search
   * ============================================
   */
  if (document.getElementById('stakeholder-archive')) {
    $('#search-stakeholder-regions').select2();
    // hide or show country list base on region
    $('#search-stakeholder-regions').on('change', function (e) {
      var stakeholder_regions_val = $('#search-stakeholder-regions option[value="' + $(this).val() + '"]');
      var value_id = stakeholder_regions_val.attr('value_id');
      var country_option = $('#select-country option');
      if (country_option.length) {
        for (let index = 0; index < country_option.length; index++) {
          const element = country_option[index];
          if (index === 0 || value_id == '-1') {
            element.setAttribute('show', '1');
          } else if (element.getAttribute('link-id') == value_id) {
            element.setAttribute('show', '1');
          } else {
            element.setAttribute('show', '0');
          }
        }
        $('#select-country').select2({
          templateSelection: format_template_countries,
          templateResult: formatResult_Country,
        });
        $('.search-stakeholder-countries #select-country').val('').trigger('change');
      }
    });
    //
    $(document).on('change', ' #search-category , #select-country ', function () {
      $('.stakeholder-search form').trigger('submit');
    });
    $('.stakeholder-search form').on('submit', function (e) {
      e.preventDefault();
      var search_input = $('#search_input').val();
      var select_country = $('#select-country').val();
      var search_category = $('#search-category').val();
      var search_stakeholder_regions = $('#search-stakeholder-regions').val();
      var submission_link =
        '/stakeholder/?search=' +
        search_input +
        '&category=' +
        search_category +
        '&regions=' +
        search_stakeholder_regions +
        '&country=' +
        select_country;
      get_XMLHttpRequest_Data('', submission_link);
    });
  }

  /**
   * ============================================
   * report archive country search
   * ============================================
   */
  if (document.getElementById('report-archive')) {
    $(document).on('change', ' #search-submission , #select-country ', function () {
      $('.report-search .report-filter-form').trigger('submit');
    });

    $('.report-search .report-filter-form').on('submit', function (e) {
      e.preventDefault();
      var search_input = $('#search_input').val();
      var search_submission = $('#search-submission').val();
      var select_country = $('#select-country').val();

      var submission_link =
        $(this).attr('data-url') +
        '/?search=' +
        search_input +
        '&submission=' +
        search_submission +
        '&country=' +
        select_country;
      get_XMLHttpRequest_Data('', submission_link);
    });
  }

  /**
   * ============================================
   * END
   * ============================================
   */
});
