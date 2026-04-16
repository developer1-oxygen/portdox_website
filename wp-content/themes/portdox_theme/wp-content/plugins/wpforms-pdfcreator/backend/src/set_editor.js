(function($) {
    "use strict";
    $( document ).ready( function () { 
        var ajax_change_editor = null;
        $("input.touchspin").TouchSpin({
            min: 0,
            max: 1000,
            boostat: 5,
            maxboostedstep: 10,
        });
        //upload IMG
        $('body').on('click', '.upload-editor--image', function(e){
            e.preventDefault();
            var input = $(this).closest(".builder__editor--button-url").find(".image_url");
                var button = $(this),
                    custom_uploader = wp.media({
                title: 'Insert image',
                library : {
                    type : 'image'
                },
                button: {
                    text: 'Use this image' // button label text
                },
                multiple: false // for multiple image selection set to true
            }).on('select', function() { // it also has "open" and "close" events 
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                input.val(attachment.url).change();
                var img = new Image();
                img.src = attachment.url;
                img.onload = function() {
                  var pr_width = $(".wp_builder_pdf_focus").width();
                  if( this.width >  pr_width ){
                        var pe = this.width / pr_width;
                        $(".builder__editor--item-width .text_width").val(pr_width);
                        $(".builder__editor--item-height .text_height").val(this.height/pe).change();
                  }else{
                        $(".builder__editor--item-width .text_width").val(this.width);
                        $(".builder__editor--item-height .text_height").val(this.height).change();
                  }
                } 
            })
            .open();
        });
        //Menu
        $('body').on("click",".pdfbuilder_email_add_menu",function(e){
             e.preventDefault();
             var data =$(".builder__editor--item-menu-hidden").html();
             $(".menu-content-tool>ul").append("<li class='data'>"+data+"</li>"); 
             $('.menu-content-tool .text_background,.menu-content-tool .text_color').wpColorPicker({
                change: function(event, ui){
                    $(".wp_builder_pdf_focus").pdfbuilder_set_type_editor();
                    if( $(".wp_builder_pdf_focus").attr("background_full") == "ok" ){
                        $(".wp_builder_pdf_focus").closest(".builder-row-container").css("background-color",$(".wp_builder_pdf_focus").css("background-color"));
                    }else{
                        $(".wp_builder_pdf_focus").closest(".builder-row-container").css("background-color","transparent");
                    }     
                }
            });  
        })
        //Editor Change
        $('body').on("change",".builder__editor input, .builder__editor select, .builder__editor textarea",function(e){
             e.preventDefault();
             $(".wp_builder_pdf_focus").pdfbuilder_set_type_editor();
                if( $(".wp_builder_pdf_focus").attr("background_full") == "ok" ){
                    $(".wp_builder_pdf_focus").closest(".builder-row-container").css("background-color",$(".wp_builder_pdf_focus").css("background-color"));
                }else{
                    $(".wp_builder_pdf_focus").closest(".builder-row-container").css("background-color","transparent");
                }    
        })
        //align
         $('body').on("click",".builder__editor--align a",function(e){
             e.preventDefault();
             $(".builder__editor--align a").removeClass("active");
             $(this).addClass("active");
             var vl = $(this).data("value");
             $(this).closest(".builder__editor--align").find(".text_align").val(vl).change();
        })
        $("body").on("click",".pdfcreator_code_editor",function(e){
            tinymce.execCommand('mceToggleEditor', false, 'content');
        })
        $("body").on("change",".pdfcreator-image-type-editor",function(e){
            var value = $(this).val();
            if( value == 0 ){
                $(".pdfcreator-image-type-upload").removeClass("hidden");
                $(".pdfcreator-image-type-field").addClass("hidden");
            }else{
                $(".pdfcreator-image-type-upload").addClass("hidden");
                $(".pdfcreator-image-type-field").removeClass("hidden");
            }
        })
         //text
         tinymce.init({
            selector: '.builder__editor--js',
            mode: 'exact',
            font_formats: pdfbuilder_settings.google_font_font_formats,
            height: 'auto',
            menubar: false,
            statusbar: false,
            relative_urls: false,
            remove_script_host: false,
            convert_urls: false,
            plugins: ["link textcolor colorpicker image code_toggle"],
            toolbar:
                [
                    'bold italic underline | fontselect styleselect | link image',
                    'fontsizeselect forecolor backcolor',
                    'shortcodes icons code_toggle'
                ],   
            fontsize_formats: '10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 22px 24px 26px 28px 30px 35px 40px 50px 60px',
            setup:function(ed) {
                ed.addButton('shortcodes', {
                        type: 'listbox',
                        text: 'Shortcodes',
                        onselect: function (e) {
                            ed.insertContent(this.value())
                        },
                        values: pdfbuilder_settings.shortcode,
                    });
                ed.addButton('icons', {
                        onclick: function() {
                            ed.windowManager.open( {
                                title: 'Insert icon',
                                body: [{
                                    type: 'textbox',
                                    name: 'icon',
                                    label: 'Icon'
                                },
                                {
                                    type: 'textbox',
                                    name: 'size',
                                    label: 'Size'
                                },
                                {
                                    type: 'textbox',
                                    name: 'color',
                                    label: 'Color'
                                },
                                ],
                                onsubmit: function( e ) {
                                    ed.insertContent( '&lt;h3&gt;' + e.data.title + '&lt;/h3&gt;');
                                }
                            });
                        }
                    });
                ed.on('keyup paste change', function(e) {
                    $(".builder-elements-content.wp_builder_pdf_focus .text-content-data").html(ed.getContent()); 
                    $(".builder-elements-content.wp_builder_pdf_focus .text-content").html(ed.getContent()); 
                });
                ed.on('change focusout', function(e) {
                    $(".builder-elements-content.wp_builder_pdf_focus .text-content-data").html(ed.getContent()); 
                    var data = {
                        'action': 'pdfbuilder_builder_text',
                        'type': $(".builder-elements-content.wp_builder_pdf_focus").data("type"),
                        'order_id': $(".builder_pdf_woo_testing").val(),
                        'text': ed.getContent(),
                    };
                    if( ajax_change_editor != null){
                        ajax_change_editor.abort();
                    }
                    var element = $(".builder-elements-content.wp_builder_pdf_focus .text-content");
                    ajax_change_editor = $.post(ajaxurl, data, function(response) {
                        element.html(response); 
                    });
                });
            }
        });
         //color
          $('.builder__editor_color').wpColorPicker({
            change: function(event, ui){
                $(".wp_builder_pdf_focus").pdfbuilder_set_type_editor();
                if( $(".wp_builder_pdf_focus").attr("background_full") == "ok" ){
                    $(".wp_builder_pdf_focus").closest(".builder-row-container").css("background-color",$(".wp_builder_pdf_focus").css("background-color"));
                }else{
                    $(".wp_builder_pdf_focus").closest(".builder-row-container").css("background-color","transparent");
                }    
            }
        });
        $.selector_element = function(){
            var button_tab = $('.builder__tab li a');
            button_tab.each(function () {
                var button = $(this);
                if(button.attr('id') == '#tab__editor' ) {
                    $('.builder__tab li a').removeClass('active');
                    button.addClass('active');
                    var tab = $(button.attr('id'));
                    $('.tab__content').hide();
                    tab.show();
                }
            });
            $('.builder__toolbar').remove();
            $(".builder__editor--item").addClass("hidden");
            $("div").removeClass("wp_builder_pdf_focus").removeClass("wp_builder_pdf_show");
        }
        ///Get ----------------------------------------
        $('body').on("click",".email-builder-main-change_backgroud",function(e){ 
            e.preventDefault();
            e.stopPropagation();
            $.selector_element();
            $(".email-builder-main").addClass("wp_builder_pdf_focus wp_builder_pdf_show");
            $(".email-builder-main").pdfbuilder_load_type_editor(true);
        })
        //click out 
        $('body').on("click",".builder__tab,.wp-builder-email-slide,.builder-actions,#builder-header,#titlediv",function(e){
            $("div").removeClass('wp_builder_pdf_show wp_builder_pdf_focus');
            $("div").remove(".builder__toolbar");
            $(".builder__editor--item").addClass('hidden');
        })
        $('body').on("click",".builder-elements-content",function(e){
            e.preventDefault();
            e.stopPropagation();
            $.selector_element();
            var toolbar= $('<div class="builder__toolbar">' +
            '<div class="momongaDragHandle"><i class="emailbuilder-icon icon-menu-1"></i></div>' +
            '<div class="momongaEdit"><i class="emailbuilder-icon icon-pencil"></i></div>' +
            '<div class="momongaDuplicate"><i class="emailbuilder-icon icon-docs"></i></div>' +
            '<div class="momongaDelete"><i class="emailbuilder-icon icon-trash"></i></div>' +
            '</div>');
            $(this).addClass("wp_builder_pdf_focus");
            $(this).closest(".builder-row-container").addClass("wp_builder_pdf_show");
            $(this).append(toolbar.clone());
            $(this).closest(".builder-row-container").append(toolbar);
            $(this).pdfbuilder_load_type_editor();
        })
        $("body").on("click",".momongaEdit",function(e){
            e.preventDefault();
            $(this).closest('.builder__toolbar').parent( ".builder-row-container").find(".builder-row-container-row").click();
        })
        $( '#doaction, #doaction2' ).on( 'click', function( e ) {
                let action = $('select[name="action"]').val();
                if ( action == "pdf_creator" ||  action == "pdf_packing_slip"  ) {
                    e.preventDefault();
                    let template = action;
                    let checked  = [];
                    $('tbody th.check-column input[type="checkbox"]:checked').each(
                        function() {
                            checked.push($(this).val());
                        }
                    );
                    if (!checked.length) {
                        alert('You have to select order(s)!');
                        return;
                    }
                    let order_ids = checked.join(',');
                    if(action == "pdf_packing_slip" ){
                        var url = pdfbuilder_settings.home_url+"/?pdf_preview=preview&id=-1&packing_slip=1&woo_order="+order_ids;
                    }else{
                      var url = pdfbuilder_settings.home_url+"/?pdf_preview=preview&id=-1&woo_order="+order_ids;  
                    }
                    window.open(url,'_blank');
                }
            } );
        $('body').on("click",".builder-row-container-row",function(e){
            e.preventDefault();
            e.stopPropagation();
            $.selector_element();
            var toolbar= $('<div class="builder__toolbar">' +
            '<div class="momongaDragHandle"><i class="emailbuilder-icon icon-menu-1"></i></div>' +
            '<div class="momongaEdit"><i class="emailbuilder-icon icon-pencil"></i></div>' +
            '<div class="momongaDuplicate"><i class="emailbuilder-icon icon-docs"></i></div>' +
            '<div class="momongaDelete"><i class="emailbuilder-icon icon-trash"></i></div>' +
            '</div>');
            $(this).addClass("wp_builder_pdf_focus");
            $(this).closest(".builder-row-container").addClass('wp_builder_pdf_show');
            $(this).closest(".builder-row-container").removeClass('.builder-row-empty');
            $.check_row_empty();
            $(this).closest(".builder-row-container").append(toolbar);
            $(this).pdfbuilder_load_type_editor(true);
        })
        $.check_row_empty = function() {
            $( ".builder-row-container" ).each(function( index ) {
                    $(this ).find(".builder-row").each(function( index ) { 
                        var check = $(this).find('.builder-elements');
                        if( check.length > 0 ){
                            $(this).removeClass('builder-row-empty');
                            $(this).closest('.builder-row-container').removeClass('builder-row-empty');
                        }
                    })
            });
        }
         $("body").on("click",".pdfbuilder-popup-add",function(e){
          e.preventDefault();
          var html = $('<div>').append( $(this).closest(".pdfcreator-logic-item").clone()).html();
          $(".pdfbuilder-popup-layout").append(html);
          $.pdfbuilder_change_logic();
        })
        $("body").on("click",".pdfbuilder-popup-minus",function(e){
          e.preventDefault();
          $(this).closest(".pdfcreator-logic-item").remove();
          $.pdfbuilder_change_logic();
        })  
        $("body").on("click",".manager_condition",function(e){
          e.preventDefault();
          var html ="";
          $("a").removeClass("manager_condition_active");
          $(this).addClass("manager_condition_active");
          var datas = $(".manager_condition_active").closest(".builder__editor--item").find("textarea").val();
          if( datas == ""){
            }else{
                 datas= JSON.parse(decodeURIComponent(datas));
                 var type = datas.type;
                 $("#pdfcreator-logic-type").val(datas.type);
                 $("#pdfcreator-logic-logic").val(datas.logic);
                 $.each(datas.conditional, function( index, data ) {
                 html += $.pdfbuilder_get_logic_html(data);
                });
            }
            $(".pdfbuilder-popup-layout").html(html);
          tb_show("Condition Logic", "#TB_inline?&width=600&height=550&inlineId=pdfbuilder-popup-content");
            return false;
       })
       $('body').on("click",".pdfbuilder_condition_add",function(e){
            e.preventDefault();
            var html = $.pdfbuilder_get_logic_html( {"name":"","rule":"is","value":""});
            $(".pdfbuilder-popup-layout").append(html);
            $.pdfbuilder_change_logic();
         }) 
        $.pdfbuilder_get_logic_html = function(conditional){
            var names = pdfbuilder_settings.shortcode;
            var html ="";
            var name_logic_html = "";
            $.each(names, function( index, names ) {
                var selected_s = "";
                var name = names.value;
                if( name == ""){
                    return true;
                }
                if( conditional.name == name ){
                    selected_s = 'selected';
                }
                name_logic_html += '<option '+selected_s+' value="'+name+'">'+names.text+'</option>';
            });
            var rules ={"is":"is","isnot":"is not","greater_than":"greater than","less_than":"less than","contains":"contains","starts_with": "starts with","ends_with":"ends with"};
            var html = '<div class="pdfcreator-logic-item" >';
                html += '<select class="pdfcreator-logic-name">';
                        html += name_logic_html;
                    html += '</select>';
                    html += '<select class="pdfcreator-logic-rule">';
                    $.each(rules, function( key, rule ) {
                        var selected_s = "";
                        if( conditional.rule == key ){
                            selected_s = 'selected';
                        }
                        html += '<option '+selected_s+' value="'+key+'">'+rule+'</option>';
                    });
                    html += '</select>';
                    html += '<input type="text" class="pdfcreator-logic-value" value="'+conditional.value+'">';
                    html += '<div class="pdfbuilder-popup-layout-settings">';
                        html += '<button class="pdfbuilder-popup-add">+</button>';
                        html += '<button class="pdfbuilder-popup-minus">-</button>';
                    html += '</div>';
                html += '</div>';
                return html;
        }
        $('body').on("change keyup",".pdfbuilder-popup-content select, .pdfbuilder-popup-content input",function(e){
            $.pdfbuilder_change_logic();
         })
         $.pdfbuilder_change_logic = function( ){
            var type = $("#pdfcreator-logic-type").val();
            var logic = $("#pdfcreator-logic-logic").val();
            var conditional = [];
            $(".pdfcreator-logic-item").each(function() {
                var name = $(this).find(".pdfcreator-logic-name").val();
                var rule = $(this).find(".pdfcreator-logic-rule").val();
                var value = $(this).find(".pdfcreator-logic-value").val();
                conditional.push({name: name,rule: rule, value: value});
            });
            if( conditional.length == 0 ){
                var data = "";
            }else{
                var data = {"type":type,"logic":logic,"conditional":conditional};
                 var data = encodeURIComponent(JSON.stringify(data));
            }
            $(".manager_condition_active").closest(".builder__editor--item").find("textarea").val(data).change();
        }
})
})(jQuery);