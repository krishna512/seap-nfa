jQuery(function ($) {
  // admin post list page
  var data_colname_Regions_check = setInterval(function () {
    var column_regions = document.querySelectorAll('td[data-colname="Regions"]');
    if (!column_regions.length) {
      column_regions = document.querySelectorAll('td[data-colname="Select country"]');
    }
    if (!column_regions.length) {
      column_regions = document.querySelectorAll('td[data-colname="Region"]');
    }
    if (column_regions) {
      column_regions.forEach(function (element) {
        if (element.firstElementChild) {
          element.innerHTML = element.firstElementChild.outerHTML;
        }
      });
      clearInterval(data_colname_Regions_check);
    }
  }, 1000);

  setTimeout(function () {
    clearInterval(data_colname_Regions_check);
  }, 20000);

  // ACF
  // https://www.advancedcustomfields.com/resources/javascript-api/
  if (typeof acf !== 'undefined') {
    // select ajax load
    acf.add_filter('select2_ajax_data', function (data, args, $input, field, instance) {
      const dataset = field[0] ? field[0].dataset : null;
      //
      if (dataset.name === 'regions' && dataset.type === 'post_object') {
        // Find the current repeater/flexible content row
        const $acfRow = field.closest('tr.acf-row');
        // Find the related 'type' field in the same row
        const $relatedField = acf.findFields({
          name: 'type',
          parent: $acfRow[0],
          limit: 1,
        });
        const selected_region_type = $relatedField.find('select').val();
        if (selected_region_type) {
          data.selected_region_type = selected_region_type;
        }
      }

      return data;
    });

    // select change event
    new acf.Model({
      events: {
        'change select[id="acf-field_683812eed1e04"]': 'change_seap_type',
      },
      change_seap_type: function (e, $el) {
        var region_value = $('select#acf-field_660bcc790973c');
        var type_value = $('select#acf-field_683812eed1e04');
        if (type_value.val() && region_value.length) {
          region_value.val(null).trigger('change');
        }
      },
    });
  }

  /**
   * END
   */
});
