(function($) {
    "use strict";
    $( document ).ready( function () {
        $.fn.pdfbuilder_row_droppable = function () { 
            $(this).draggable({
              helper: function () {
                    var type = $(this).data("type");
                    var html = $.pdfbuilder_load_type(type);
                    html.find(".builder-row").addClass("builder-row-empty");
                    html.find(".builder-row").pdfbuilder_element_sortable();
                    return html.removeAttr('style').css({width: 'auto',height: 'auto'});
                },
              start: function (e, ui) {
                  ui.helper.addClass('pdfbuilderemail-temp');
              },
              stop: function (e, ui) {
                 ui.helper.removeClass('pdfbuilderemail-temp');
              },
              cursorAt: {left: 40, top: 15},
              connectToSortable: ".builder__list",
              revert : 0,
            });
        }
        $.fn.pdfbuilder_row_sortable = function () {
            $(this).sortable({
              revert: "invalid",
              connectWith: '.builder-row-tool',  
              placeholder: 'builder-row-insert',
              start: function (ev, ui) {
                  ui.helper.addClass('wpbuider-email-dragging');
              },
              stop: function (ev, ui) {  
                  ui.item.removeClass('wpbuider-email-dragging');
              },
              handle: ".momongaDragHandle",
              revert : 0,
            });
        }
        $.fn.pdfbuilder_element_droppable = function () { 
            $(this).draggable({
              helper: function () {
                    var type = $(this).data("type");
                    $( this ).removeClass('builder-row-empty');
                    var html = $.pdfbuilder_load_type(type);
                    return html.removeAttr('style').css({width: 'auto',height: 'auto'});
                },
              cursor: "move",
              cursorAt: {left: 40, top: 15},
              start: function (e, ui) {
                  ui.helper.addClass('pdfbuilderemail-temp');
              },
              stop: function (e, ui) {
                 ui.helper.removeClass('pdfbuilderemail-temp');
              },
              connectToSortable: ".builder-row",
              revert : 0,
            });
        }
        $.fn.pdfbuilder_element_sortable = function () { 
            $(this).sortable({
              connectWith: '.builder-row',
              revert: "invalid",
              placeholder: 'builder-row-insert',
              column: '',
              tolerance: "pointer",
              handle: ".momongaDragHandle",
              revert : 0,
              start: function (ev, ui) {
                    ui.helper.addClass('wpbuider-email-dragging');
                    this.column = ui.helper.closest('.builder-row');
                },
              stop: function (ev, ui) { 
                ui.item.removeClass('wpbuider-email-dragging');
                if (ui.item.closest(".builder-row").find('.builder-elements').length) {
                    ui.item.closest(".builder-row").removeClass('builder-row-empty');
                }
                if (!(this.column.find('.builder-elements').length)) {
                    this.column.addClass('builder-row-empty');
                }
              },
            });
        }

        $( ".builder-row-tool li" ).pdfbuilder_row_droppable();
        $( ".builder__list--js" ).pdfbuilder_row_sortable();
        $( ".momongaPresets li>div" ).pdfbuilder_element_droppable();
        $( ".builder-row" ).pdfbuilder_element_sortable();        
    })
})(jQuery);