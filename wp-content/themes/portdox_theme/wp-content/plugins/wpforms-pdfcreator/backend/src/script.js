(function($) {
    "use strict";
    $( document ).ready( function () {
       var pdfbuilder_builder_main = {
            json_to_builder: function(){
                var data_json = $(".data_email").val();
                var datas = {};
                var html="";
                if( data_json =="" || typeof data_json === "undefined"){
                   return;
                }
                datas = JSON.parse(data_json);
                console.log(datas);
                $(".builder__list").html("");
                $(".email-builder-main").css(datas["container"]);
                for (let index_row in datas['rows'] ) {
                    var row_style = datas['rows'][index_row].style;
                    var row_columns = datas['rows'][index_row].columns;
                    var row_type = datas['rows'][index_row].type;
                    var row_attr = datas['rows'][index_row].attr;
                    var row_condition = datas['rows'][index_row].condition;
                    var row = $('<div class="builder-row-container builder__item"></div>');
                    var inner_row = $('<div data-type="'+row_type+'" class="builder-row-container-row builder-row-container-'+row_type+'"></div>');
                     inner_row.css(row_style);
                     inner_row.attr(row_attr);
                     inner_row.attr("data-condition",row_condition);
                     inner_row.appendTo(row);
                     var i = 0;
                   for (let index_column in row_columns ) {
                      i++;
                       switch(row_type) {
                          case "row3":
                              if( i == 1){
                                var column = $('<div class="builder-row bd-row-2 builder-row-empty"></div>');  
                              }else{
                                var column = $('<div class="builder-row builder-row-empty"></div>');
                              }
                          break;
                          case "row4":
                              if( i != 1){
                                var column = $('<div class="builder-row bd-row-2 builder-row-empty"></div>');  
                              }else{
                                var column = $('<div class="builder-row builder-row-empty"></div>');
                              }
                              break;
                          default:
                              var column = $('<div class="builder-row builder-row-empty"></div>');
                        }
                       var elements = row_columns[index_column].elements;
                       for (let index_element in elements ) { 
                            column.removeClass('builder-row-empty');
                            var element_type = elements[index_element].type;
                            var element=$.pdfbuilder_load_type(element_type,elements[index_element]);
                            element.appendTo(column);
                       } 
                       column.appendTo(row.find(".builder-row-container-row"));
                   }
                   row.find(".builder-row").pdfbuilder_element_sortable();             
                   row.appendTo(".builder__list--js");                
                }
            },
            builder_to_json: function(){ 
                var datas = {}; 
                var container = $(".email-builder-main");
                datas['container'] = {
                    "font-size": $(".email-builder-main").css("font-size"),
                    "color": $.email_builder_cover_color($(".email-builder-main").css("color")),
                    "font-family": $(".email-builder-main").css("font-family").replaceAll('"',""),
                    'background-color': $.email_builder_cover_color($(".email-builder-main").css("background-color")),
                    'padding-top': $(".email-builder-main").css("padding-top"),
                    'padding-bottom': $(".email-builder-main").css("padding-bottom"),
                    'padding-left': $(".email-builder-main").css("padding-left"),
                    'padding-right': $(".email-builder-main").css("padding-right"),
                    'background-image': $(".email-builder-main").css("background-image"),
                    "background-position": "top left",
                    "background-repeat": "no-repeat",
                    "background-size": "100%",
                };
                container.css(datas["container"]);
                datas["rows"] = {};
                $(".builder-row-container-row").each(function(index,row){
                    var type = $(row).data("type");
                    var style_row = {};
                    var list_css = $.pdfbuilder_style(type);
                    $.each( list_css, function( key, value ) {
                        var css = $(row).css(value);
                        if( value.indexOf("color") >= 0 ){
                           style_row[value] = $.email_builder_cover_color(css);    
                        }else if( value == "background-image"){
                            style_row[value] = css;
                            style_row["background-position"] = "top left";
                            style_row["background-repeat"] = "no-repeat";
                            style_row["background-size"] = "100%";
                        }else{
                           style_row[value] = css; 
                        }
                    });
                    var attr_row = {};
                    attr_row["background_full"] = $(row).attr("background_full");
                    if( attr_row["background_full"] !="not" ) {
                      attr_row["background_full"] = "ok";
                    }
                    var condition = $(row).attr("data-condition");
                    if( condition === undefined){
                        condition = ""; 
                    }
                    datas["rows"][index] = {style:style_row,
                                            attr: attr_row,
                                            type:   type,
                                            columns: {},
                                            condition: condition
                                           };
                    $(row).find(".builder-row").each(function(index1,row1){ 
                        datas["rows"][index]["columns"][index1]={
                            elements: {}
                        };
                        $(row1).find(".builder-elements-content").each(function(index2,row2){
                          var type = $(row2).data("type");
                          var element = $(row2).pdfbuilder_save_type();
                          datas["rows"][index]["columns"][index1]["elements"][index2]= element;
                        })
                    })                       
                })
                return JSON.stringify(datas);
            },
            json_to_email: function(){
                var data_json = $(".data_email").val();
                var id = $("#post_ID").val();
                var datas = {};
                if( data_json ==""){
                   return;
                }
                datas = JSON.parse(data_json);
                var container =$('<body><div data-pdfbuilderemailid="'+id+'" class="wap" width="100%" style="margin: 0 auto;"><div class="container" style="margin: 0 auto;"class="email-container" ></div></div>');
                var background_body ='<style>body {background-color: '+datas["container"]["background-color"]+' !important;}';
                background_body += ' @page{margin: '+datas["container"]["padding-top"]+' '+datas["container"]["padding-right"]+' '+datas["container"]["padding-bottom"]+' '+datas["container"]["padding-left"]+';}';
                background_body += '</style>';
                delete datas["container"]['padding-top'];
                delete datas["container"]['padding-right'];
                delete datas["container"]['padding-bottom'];
                delete datas["container"]['padding-left'];
                 container.css(datas["container"]);
                for (let index_row in datas['rows'] ) {
                    var row_style = datas['rows'][index_row].style;
                    var row_attr = datas['rows'][index_row].attr;
                    var row_columns = datas['rows'][index_row].columns;
                    var row_type = datas['rows'][index_row].type;
                    var row_container = $('<div class="container-row" style="width:100%"></div>');
                    for (const [key, value] of Object.entries(row_attr)) {
                      switch(key) { 
                          case "background_full":
                              if( value !== "not"){
                                row_container.css("background-color",row_style["background-color"]);
                              }
                            break
                          default:
                             row_container.attr(key,value);
                      }
                    }
                    var row =$('<div class="row"></div>');
                    row = row.css(row_style);
                   var i = 0;
                   for (let index_column in row_columns ) {
                       i++;
                       var col_width = "100%";
                       switch(row_type) {
                          case "row2":
                            col_width = "50%";
                            break;
                          case "row3":
                              if( i == 1){
                                col_width = "65%";  
                              }else{
                                col_width = "35%";
                              } 
                          break;
                          case "row4":
                              if( i == 1){
                                col_width = "35%";  
                              }else{
                                col_width = "65%";
                              } 
                              break;
                          case "row5":
                              col_width = "33.33%;";
                              break;
                          case "row6":
                              col_width = "25%;";
                              break;
                          default:
                              col_width = "100%;";
                        }
                       var column = $('<div class="col" style="width: '+col_width+'"></div>');
                       var elements = row_columns[index_column].elements;
                       var col_container = $("<div class='col-container'></div>");
                       for (const [key, value] of Object.entries(elements)) {
                          var element_type = value.type;
                          var element = $.pdfbuilder_load_type(element_type,value,true);
                          element.find(".builder-elements-content .text-content").remove();
                          element.appendTo(col_container);
                        }
                       col_container.appendTo(column);
                       column.appendTo(row);
                   } 
                   row.appendTo(row_container);
                   row_container.appendTo(container.find(".container"));                             
                }
                return container[0].outerHTML + background_body;
            },
            json_to_email_head: function(){
              return ''
            }
        }
        pdfbuilder_builder_main.json_to_builder();
        $( ".builder-row-container-row" ).each(function( index ) {
          if( $(this).attr("background_full") != "not" ){
            $(this).closest(".builder-row-container").css("background-color",$(this).css("background-color"));
          }
        });
        $('body').on("click",".builder-row-container",function(e){
            e.preventDefault();
            $(this).find(".builder-row-container-row").click();
         })
        $('body').on("click",".button-pdfcreator-save",function(e){
             e.preventDefault();
             $(this).html("....");
             var email_json = pdfbuilder_builder_main.builder_to_json();
             $(".data_email").val(email_json);
              var email = pdfbuilder_builder_main.json_to_email();
              $(".data_email_email").val(email);
            $("#publish").click();
        })
        $("body").on("click",".wp-builder-email-view-email",function(e){
            e.preventDefault();
             var email_json = pdfbuilder_builder_main.builder_to_json();
             $(".data_email").val(email_json);
             var email = pdfbuilder_builder_main.json_to_email();
            $(".data_email_email").val(email);
        })
        $('body').on("click",".pdfbuilder-email-testting-send",function(e){
            e.preventDefault();
            var email = $("#pdfbuilder-email-testting").val();
            var id = $("#post_ID").val();
            if( email =="" || id == ""){
              alert("Enter Email or Save Post");
            }else{
                $(this).html("Sending...");
                var data = {
                    'action': 'pdfbuilder_builder_send_email_testing',
                    'id': id,
                    'email' : email
                  };
                jQuery.post(ajaxurl, data, function(response) {
                  alert(response);
                  $(this).html("Send Email");
                });
            }
         })
        $('body').on("click",".momongaDelete",function(e){
             e.preventDefault();
             e.stopPropagation();
             $(".builder__editor .builder__editor--item").addClass('hidden');
             if(  $(this).closest(".builder-elements").length < 1 ){
                $(this).closest(".builder-row-container").remove();
             }else{
                $(this).closest('.builder-elements').remove();
             }
        })
        $('body').on("click",".momongaDuplicate",function(e){
             e.preventDefault();
             e.stopPropagation();
             if(  $(this).closest(".builder-elements").length > 0 ){
                var main_item = $(this).closest('.builder-elements');
                var newItem = main_item.clone(true);
                newItem.find(".builder__toolbar").remove();
                newItem.find(".builder-elements-content").removeClass("wp_builder_pdf_focus");
                main_item.after(newItem);
             }else{
                var main_item = $(this).closest('.builder-row-container');
                var newItem = main_item.clone(true);
                newItem.find(".builder__toolbar").remove();
                newItem.removeClass('wp_builder_pdf_show').find(".builder-row-container-row").removeClass("wp_builder_pdf_focus");
                newItem.find(".builder-elements-content").removeClass("wp_builder_pdf_focus");
                main_item.after(newItem);
             }   
        })
        $("body").on('mouseenter', '.builder-elements', function() {
            if( $(this).closest(".wp_builder_pdf_show").length < 1  ){
               $(this).closest('.builder-row-container').addClass('wp_builder_pdf_hover');
                $(this).addClass('wp_builder_pdf_hover');     
            }else{
                $(this).addClass('wp_builder_pdf_hover');  
            }
        });
        $("body").on('mouseleave', '.builder-elements', function() {
            $(this).closest('.builder-row-container').removeClass('wp_builder_pdf_hover');
            $(this).removeClass('wp_builder_pdf_hover');
        });
        $("body").on('mouseenter', '.builder-row-container-row', function() {
            if( $(this).closest(".wp_builder_pdf_show").length < 1  ){
               $(this).closest('.builder-row-container').addClass('wp_builder_pdf_hover');
            }
        });
        $("body").on('mouseleave', '.builder-row-container-row', function() {
            $(this).closest('.builder-row-container').removeClass('wp_builder_pdf_hover');
        });
        $('body').on("click",".builder__tab a",function(e){
             e.preventDefault();
             $(".builder__tab a").removeClass("active");
             $(this).addClass("active");
             var tab = $(this).attr('id');
             $('.tab__content').hide();
             $(tab).show();
        })
        $('body').on("click",".wp-builder-email-reset a",function(e){
             e.preventDefault();
             if (confirm("Do you want to reset the template?") == true) {
                  var data = {
                        'action': 'pdf_reset_template',
                        'id': $("#post_ID").val()
                    };
                    jQuery.post(ajaxurl, data, function(response) {
                        location.reload(true);
                    });
            }
        })
        $('body').on('click', '.wp-builder-email-import', function(e){
            e.preventDefault();
                var button = $(this),
                    custom_uploader = wp.media({
                title: 'Import template',
                library : {
                    type : [ 'json',"text"]
                },
                button: {
                    text: 'Import template' // button label text
                },
                multiple: false // for multiple image selection set to true
            }).on('select', function() { // it also has "open" and "close" events 
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $.getJSON(attachment.url, function(data){
                    $(".data_email").val(data);
                    pdfbuilder_builder_main.json_to_builder();
                    $( ".builder-row-container-row" ).each(function( index ) {
                      if( $(this).attr("background_full") != "not" ){
                        $(this).closest(".builder-row-container").css("background-color",$(this).css("background-color"));
                      }
                    });
                }).fail(function(){
                  alert("Error");
                });
            })
            .open();
        });
        $("body").on("click",".wp-builder-email-export",function(){
            $("<a />", {
                "download": "pdf_template.json",
                "href" : "data:text/plain;charset=utf-8," + encodeURIComponent(JSON.stringify($(".data_email").val()))
              }).appendTo("body")
              .click(function() {
                 $(this).remove()
              })[0].click();
        })
        $("body").on("click",".wp-builder-email-export-html",function(){
            var id = $("#post_ID").val();
            var data = {
              'action': 'pdfbuilder_builder_export_html',
              'id': id
            };
            jQuery.post(ajaxurl, data, function(response) {
              var data = new Blob([response], {type: 'text/html'});
              var textFile = window.URL.createObjectURL(data);
              $("<a />", {
                "download": "pdf_template.html",
                "href" : textFile,
              }).appendTo("body")
              .click(function() {
                 $(this).remove()
              })[0].click();
            });
        })
        $("body").on("click",".wp-builder-email-choose-template",function(e){
            e.preventDefault();
            tb_show("Templates", "#TB_inline?width=930&height=550&inlineId=wp-builder-email-templates");
            return false;
        })
        $("body").on("click",".pdf-remove-font",function(e){
            e.preventDefault();
            if (confirm("Do you want remove font?") == true) {
              var font_name = $(this).closest(".container-list-fonts").find(".pdf-font-name").html();
              $(this).closest(".container-list-fonts").remove();
               var formData ={
                        'action': 'pdfceator_remove_font',
                        'font_name': font_name
                    };
                jQuery.post(ajaxurl, formData, function(response) {
                });
            }
            return false;
        })
        $("body").on("click",".wp-builder-email-actions-import",function(e){
            e.preventDefault();
            var attachment = $(this).closest(".grid-item").data("file");
                $.getJSON(attachment, function(data){
                    $(".data_email").val(data);
                    $(".builder__list").html("");
                    pdfbuilder_builder_main.json_to_builder();
                    $( ".builder-row-container-row" ).each(function( index ) {
                      if( $(this).attr("background_full") != "not" ){
                        $(this).closest(".builder-row-container").css("background-color",$(this).css("background-color"));
                      }
                    });
                    tb_remove();
                }).fail(function(){
                  alert("Error");
                });
        })
      $("body").on("click",".woocommerce-pdfcreator-expand",function(e){
          e.preventDefault();
          var type = $(this).data("type");
          if( type == "left"){
              $(".builder__widget").effect( "size", {
                                  to: { width: 900, }
                                }, 500 );
              $(this).closest('div').find(".woocommerce-pdfcreator-shrink").removeClass("hidden");
              $(this).addClass('hidden');
          }else{
              $("#poststuff #post-body.columns-2").css("margin-right","300px");
              $(".wp-builder-email-slide").removeClass('hidden');
              $(".wpbuideremail-expand-right").addClass('hidden');
          }
      })
      $("body").on("click",".woocommerce-pdfcreator-shrink",function(e){
          e.preventDefault();
          var type = $(this).data("type");
          if( type == "left"){
              $(".builder__widget").effect( "size", {
                                  to: { width: 420, }
                                }, 500 );
              $(this).closest('div').find(".woocommerce-pdfcreator-expand").removeClass("hidden");
              $(this).addClass('hidden');
          }else{
              $("#poststuff #post-body.columns-2").css("margin-right","0");
              $(".wp-builder-email-slide").addClass('hidden');
              $(".wpbuideremail-expand-right").removeClass('hidden');
          }
      }) 
    })
})(jQuery);