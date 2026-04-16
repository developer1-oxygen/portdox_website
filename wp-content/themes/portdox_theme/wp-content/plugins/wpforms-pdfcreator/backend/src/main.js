(function($) {
    "use strict";
    $( document ).ready( function () {
        // Save bulder to josn
         $.fn.pdfbuilder_save_type = function (type) { 
            var html_emlement = $(this);
            var type = $(this).data("type");
            var container_style = {};
            var container_attr = {};
            var inner_style = {};
            var inner_attr = {};
            var style_container_element = wp_builder_pdf["block"][type]["editor"]["container"]["style"];
            var style_inner_element = wp_builder_pdf["block"][type]["editor"]["inner"]["style"];
            var attr_inner_element = wp_builder_pdf["block"][type]["editor"]["inner"]["attr"];
            //Save style container
            $.each( style_container_element, function( key, value ) {
                var data = html_emlement.css(value);
                if( value == "background-image"){
                    container_style[value] = data;
                    container_style["background-position"] = "center";
                    container_style["background-repeat"] = "no-repeat";
                    container_style["background-size"] = "cover";
                }else{
                    container_style[value] = data;
                }
            });
            //Save style inner
            $.each( style_inner_element, function( key, value ) {
               var style_content= {};
                $.each( value , function( index, style ) {
                   var data = html_emlement.find(key).css(style);
                   if( style == "background-image"){
                      style_content[style] = data;
                      style_content["background-position"] = "center";
                      style_content["background-repeat"] = "no-repeat";
                      style_content["background-size"] = "cover";
                    }else{
                      style_content[style] = data
                    }
                })
                inner_style[key] = style_content;
            });
            //Save attr
            $.each( attr_inner_element, function( key, value ) {
                var attr_content= {};
                $.each( value , function( index, style ) { 
                    switch(style) {
                      case "text":
                        var data = html_emlement.find(key).html();
                        break;
                      case "menu":
                         var menu = {};
                         var i =0;
                         html_emlement.find( ".pdfbuilder-menu td" ).each(function() {
                              var text_menu = $(this).find("a").html();
                              var href = $(this).find("a").attr("href");
                              var background = $(this).find("a").css("background-color");
                              var color = $(this).find("a").css("color");
                              color = $.email_builder_cover_color(color);
                              background = $.email_builder_cover_color(background);
                              menu[i] = {"text":text_menu,"background":background,"color":color,"href":href} ;
                              i++;
                          });
                        var data = menu;
                        break;
                      case "html":
                      case "html_hide":
                        var data = html_emlement.find(key).html(); 
                        break;  
                      default:
                        var data = html_emlement.find(key).attr(style);
                    }
                    attr_content[style] = data
                })
                inner_attr[key] = attr_content;
            });
            var condition = "";
            condition = html_emlement.attr("data-condition");
            if( condition === undefined || condition == "" ){
                condition = ""; 
            }
            return {"type":type,"container_style":container_style,"inner_style":inner_style,"inner_attr":inner_attr,"condition":condition };
         }
         //Click editor -> set element
         var ajax_change_editor = null;
         $.fn.pdfbuilder_set_type_editor = function ( row ) {
                var builder = $(this);
                var type = $(this).data("type");
                if (typeof type === "undefined") {
                    return
                }
                var style_container_element = wp_builder_pdf["block"][type]["editor"]["container"]["style"];
                var attr_container_element = wp_builder_pdf["block"][type]["editor"]["container"]["attr"];
                //set editor in container element style
                $.each( style_container_element, function( key, value ) {
                    $.pdfbuilder_set_css_element(key,value,builder);
                });
                $.each( attr_container_element, function( key, value ) {
                    var data = $(key).val();
                    if( $(key).attr("type") == "checkbox" ){
                        if(  $(key).is(':checked') ){
                          data = "ok";
                        }else{
                          data = "not";
                        }
                    }
                    builder.attr(value,data);
                });
                 var condition = $(".builder__editor--item-condition .builder__editor--condition").val();
                    builder.attr("data-condition",condition);
                    console.log(condition);
                //Element
                if( builder.closest(".builder-elements").length > 0 ) {
                    var attr_inner_element = wp_builder_pdf["block"][type]["editor"]["inner"]["attr"];
                    var style_inner_element = wp_builder_pdf["block"][type]["editor"]["inner"]["style"];
                    //set editor in element style
                    $.each( style_inner_element, function( key, value ) {
                       $.each( value , function( index, style ) {
                           $.pdfbuilder_set_css_element(index,style,builder,key);
                        })
                    });
                    //set editor in  element attr
                    $.each( attr_inner_element, function( key, value ) {
                        $.each( value , function( index, attr ) {
                           var data = $(index).val();
                           var data_value = $(index).data("after_value");
                            if (data_value !== undefined) {
                                data +=data_value;
                            }
                            switch(attr) {
                              case "html":
                              case "html_hide1":
                                break;
                              case "text":
                                builder.find(key).html(data);
                                break;
                              case "menu":
                                 var tr = $('<tr class="links"></tr');
                                 var i_menu = 0;
                                 $( ".builder__editor--item-menu .menu-content-tool li.data" ).each(function() {
                                      var text_menu = $(this).find(".text").val();
                                      var href = $(this).find(".text_url").val();
                                      var background = $(this).find(".text_background").val();
                                      var color = $(this).find(".text_color").val();
                                      var td = $('<td align="center" valign="top"><a target="_blank" href=""></a></td>');
                                      td.find("a").css("background-color",background);
                                      td.find("a").css("color",color);
                                      td.find("a").attr("href",href);
                                      td.find("a").html(text_menu);
                                      td.appendTo(tr);
                                      i_menu++;
                                  });
                                 builder.find("tr").remove();
                                 tr.appendTo(builder.find("table"));
                                 var menu_width = 100 / i_menu;
                                 builder.find("td").css("width",menu_width);
                                 $.each( style_inner_element, function( key, value ) {
                                     $.each( value , function( index, style ) {
                                         $.pdfbuilder_set_css_element(index,style,builder,key);
                                      })
                                  });
                                break;
                              case "data-src": 
                                var youtube_id = $.youtube_parser(data);
                                if( youtube_id ) {
                                    var img_youtube = 'http://cors-anywhere.herokuapp.com/http://img.youtube.com/vi/'+youtube_id+'/0.jpg';
                                    var img = new Image();
                                      img.src = img_youtube;
                                      img.setAttribute('crossorigin', 'anonymous'); 
                                    var img_logo = new Image(64,44);
                                      img_logo.src = pdfbuilder_settings.youtube_play_src;    
                                      img_logo.setAttribute('crossorigin', 'anonymous');
                                    img.onload = function(){
                                      var mycanvas = document.createElement("canvas");
                                      mycanvas.width = 480;
                                      mycanvas.height = 270;
                                      var ctx = mycanvas.getContext('2d');
                                      ctx.drawImage(img,0, 45,480, 270,0,0,480,270 );
                                      ctx.drawImage(img_logo,208, 113, img_logo.width, img_logo.height );
                                      var dataURL = mycanvas.toDataURL();
                                      builder.find(key).attr("src",dataURL);
                                      var data = {
                                        'action': 'pdfbuilder_builder_save_video',
                                        'img': dataURL,
                                        'id': youtube_id
                                      };
                                      jQuery.post(ajaxurl, data, function(response) {
                                        builder.find(key).attr("src",response);
                                         builder.find(key).attr(attr,response);
                                      });
                                    };
                                }
                                break;
                            case "data-template": 
                            case "data-showimg": 
                            case "data-totals": 
                                var template = $(".builder__editor--item-detail-template .detail-template").val();
                                var showimg = $(".builder__editor--item-detail-template .detail-img").val();
                                var totals = $(".builder__editor--item-detail-template .detail-totals").val();
                                var sku = $(".builder__editor--item-detail-template .detail-sku").val();
                                var des = $(".builder__editor--item-detail-template .detail-des").val();
                                var shortcode ="[woo_builder_order_product_details type='"+template+"' show_img='"+showimg+"' item_totals='"+totals+"' item_sku='"+sku+"' show_des='"+des+"' ]";
                                $(".builder-elements-content.wp_builder_pdf_focus .text-content-data").html(shortcode);
                                builder.find(key).attr(attr,data);
                                var data = {
                                    'action': 'pdfbuilder_builder_text',
                                    'type': $(".builder-elements-content.wp_builder_pdf_focus").data("type"),
                                    'order_id': $(".builder_pdf_woo_testing").val(),
                                    'text': shortcode
                                };
                                $.post(ajaxurl, data, function(response) {
                                    $(".builder-elements-content.wp_builder_pdf_focus .text-content").html(response); 
                                });
                                break  
                            default:
                               builder.find(key).attr(attr,data);
                               break;  
                           }
                        })
                    });
                }
          }
         //Click emlement -> get and show editor
         $.fn.pdfbuilder_load_type_editor = function (row ) {
            var type = $(this).data("type");
            var builder = $(this);
            var show_class_container = wp_builder_pdf["block"][type]["editor"]["container"]["show"];
            var style_container_element = wp_builder_pdf["block"][type]["editor"]["container"]["style"];
            var attr_container_element = wp_builder_pdf["block"][type]["editor"]["container"]["attr"];
            //Show eidtor
            $.each( show_class_container, function( key, value ) {
              $(".builder__editor--item-"+value).removeClass("hidden");
            });
            //set editor in container element style
            $.each( style_container_element, function( key, value ) {
                var data = builder.css(value);
                if(value == "font-family"){
                    data = data.replaceAll('"',"");
                }
                $.pdfbuilder_set_css_editor(value,key,data);
            });
            $.each( attr_container_element, function( key, value ) {
                var data = builder.attr(value);
                var type = $(key).attr("type");
                if( type == "checkbox"){
                  if( data != "ok"){
                        $(key).prop('checked', false);;
                     }else{
                        $(key).prop('checked', true);
                     }
                }
                $(key).val(data);
            });
            var condition = builder.attr("data-condition");
            if( condition === undefined || condition == "" ){
                condition = ""; 
            }
            $(".builder__editor--item-condition .builder__editor--condition").val(condition);
            if( !row ){
                var attr_inner_element = wp_builder_pdf["block"][type]["editor"]["inner"]["attr"];
                var style_inner_element = wp_builder_pdf["block"][type]["editor"]["inner"]["style"];
                //set editor in element style
                $.each( style_inner_element, function( key, value ) {
                   $.each( value , function( index, style ) {
                       var data = builder.find(key).css(style); 
                       $.pdfbuilder_set_css_editor(style,index,data);
                    })
                });
                //set editor in  element attr
                $.each( attr_inner_element, function( key, value ) {
                    $.each( value , function( index, attr ) {
                        switch(attr) {
                              case "data-type":
                                var value =  builder.find(key).attr(attr); 
                                $(index).val(value);
                                if( value == 0 ){
                                    $(".pdfcreator-image-type-upload").removeClass("hidden");
                                    $(".pdfcreator-image-type-field").addClass("hidden");
                                }else{
                                    $(".pdfcreator-image-type-upload").addClass("hidden");
                                    $(".pdfcreator-image-type-field").removeClass("hidden");
                                }
                                break;
                              case "html_hide":
                              case "data-src":      
                                break;
                              case "text":
                                var data = builder.find(key).html();
                                $(index).val(data);
                                break;
                              case "html":
                                if( builder.find(key+"-data").length > 0 ){
                                    var data = builder.find(key +"-data").html(); 
                                }else{
                                    var data = builder.find(key).html(); 
                                }
                                tinyMCE.get('builder__editor--js').setContent(data);
                                break;
                              case "html_ajax":
                                var data = builder.find(key+"-data").html();
                                tinyMCE.get('builder__editor--js').setContent(data);
                                break;
                              case "menu":
                                var html_menu=$("<ul></ul>");
                                $( builder.find(".pdfbuilder-menu td") ).each(function() {
                                    var text_menu = $(this).find("a").html();
                                    var href = $(this).find("a").attr("href");
                                    var background = $(this).find("a").css("background-color");
                                    var color = $(this).find("a").css("color");
                                    color = $.email_builder_cover_color(color);
                                    background = $.email_builder_cover_color(background);
                                    var menu = $(".builder__editor--item-menu-hidden").clone().removeClass('hidden builder__editor--item-menu-hidden');
                                    menu.find(".text").val(text_menu);
                                    menu.find(".text_url").val(href);
                                    menu.find(".text_background").val(background);
                                    menu.find(".text_color").val(color);
                                    var container_li = $("<li class='data'></li>");
                                    menu.appendTo(container_li);
                                    container_li.appendTo(html_menu);
                                });
                                html_menu.removeClass('hidden');
                                $(".builder__editor--item-menu .menu-content-tool ul").remove();
                                html_menu.appendTo($(".menu-content-tool"));
                                $('.menu-content-tool .text_background,.menu-content-tool .text_color').wpColorPicker({
                                    change: function(event, ui){
                                        $(".wp_builder_pdf_focus").pdfbuilder_set_type_editor();   
                                    }
                                });
                                break;
                              default:
                                var data = builder.find(key).attr(attr); 
                                $(index).val(data);
                                break;
                        }
                    })
                });
            }
         } 
         // Drop emlement and load builder -> show data builder  
         $.pdfbuilder_load_type = function (type,elements,save_html=false) { 
                if( type in wp_builder_pdf["block"] ) {
                    var html = $(wp_builder_pdf["block"][type]["builder"]);
                }else{
                    var html = $(wp_builder_pdf["block"]["text"]["builder"]);
                }     
                if( elements ){
                    var container_style = elements.container_style;
                    var inner_style = elements.inner_style;
                    var inner_attr = elements.inner_attr;
                    html.find(".builder-elements-content").css(container_style);
                    $.each( inner_style, function( key, value ) {
                        if( value != "") {
                           html.find(key).css(value); 
                        }
                    });
                    if( elements.condition != ""){
                         html.find(".builder-elements-content").attr("data-condition",elements.condition);
                    }
                    $.each( inner_attr, function( key, value ) {
                            var check_type_img = 0;
                            $.each( value, function( k, v ) { 
                                 switch(k) {
                                      case "text":
                                      case "html":
                                      case "html_hide":
                                        if( save_html ) {
                                            if( type == "qrcode" ){
                                                var v = '[wp_builder_pdf_qrcode]'+v+'[/wp_builder_pdf_qrcode]';
                                            }else if( type == "barcode") {
                                                var v = '[wp_builder_pdf_barcode]'+v+'[/wp_builder_pdf_barcode]';
                                            }
                                        }
                                        html.find(key).html(v);
                                        break;
                                      case "data-src":
                                        html.find(key).attr("src",v);
                                        html.find(key).attr(k,v);
                                        break;
                                      case "menu":
                                        var menu_main ="";
                                        var width = 100 / _.size(v);
                                        $.each( v, function(menu_key, menu ) {
                                           menu_main += '<td style="width:'+width+'%" align="center" valign="top"><a style="color:'+menu.color+';background-color:'+menu.background+';" target="_blank" href="'+menu.href+'">'+menu.text+'</a></td>';
                                        })
                                        html.find("tr").html(menu_main);
                                        $.each( inner_style, function( key, value ) {
                                            if( value != "") {
                                               html.find(key).css(value); 
                                            }  
                                        });
                                        break;
                                        case "data-type":
                                            check_type_img = v;
                                            html.find(key).attr(k,v);
                                            break;
                                        case "data-field":
                                            if( check_type_img == 1 && save_html ){
                                              html.find(key).attr("src",v); 
                                            }
                                            html.find(key).attr(k,v);
                                            break;
                                      default:
                                        html.find(key).attr(k,v);
                                    }
                            })
                    });
                }
             return html;
          }
          //Cover grb to hex
          $.email_builder_cover_color = function (rgb) {
              if( rgb == "" ){
                  return "";
              } 
              if( "rgba(0,0,0,0)" == rgb.replace(/\s/g, '') ){
                  return "transparent";
              }
              rgb = rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);
              return (rgb && rgb.length === 4) ? "#" +
                      ("0" + parseInt(rgb[1],10).toString(16)).slice(-2) +
                      ("0" + parseInt(rgb[2],10).toString(16)).slice(-2) +
                      ("0" + parseInt(rgb[3],10).toString(16)).slice(-2) : '';
          }
        $.pdfbuilder_style = function () {  
            var list_css = ["background-color","background-image",
                            "text-align",
                            "padding-top","padding-bottom","padding-left","padding-right",
                            ];
            return list_css;
        }
        //set css edit
        $.youtube_parser =function( url ) {
            var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
            var match = url.match(regExp);
            return (match&&match[7].length==11)? match[7] : false;
        }
        $.pdfbuilder_background_img =function( data ) {
            var img = data.replace('url(','').replace(')','').replace(/\"/gi, "");
            return img
        }
        $.pdfbuilder_set_css_editor =function( style, index,data) {
            switch(style) {
                case "border-color":
                case "background-color":
                case "color":
                    data = $.email_builder_cover_color(data);
                    $(index).val(data);
                    $(index).closest(".wp-picker-container").find(".button").css("background-color",data);
                  break;
                case "background-image":
                    if( data == "none"){
                      data = "";
                    }else{
                      data = $.pdfbuilder_background_img(data);
                    }
                    $(index).val(data); 
                    break;
                case "border-style":
                    data= "solid";
                    $(index).val(data); 
                  break;
                case "text-align":
                    $(index).val(data); 
                    $(index).closest(".builder__editor--item").find(".button__align").removeClass("active");
                    $(index).closest(".builder__editor--item").find(".builder__editor--align-"+data).addClass("active");
                    if( data == "stat")
                  break;
                default:
                  data = data.replace("px",""); 
                  var type_text = $(index).attr("type");
                  if( type_text == "checkbox"){
                       if( data== "none"){
                          $(index).prop('checked', false);;
                       }else{
                          $(index).prop('checked', true);
                       }
                  } 
                  $(index).val(data); 
              }
        }
      $.pdfbuilder_set_css_element =function( selector, style,builder,key) {
        var data = $(selector).val();
        var data_value = $(selector).data("after_value");
        if (data_value !== undefined) {
            data +=data_value;
        }
        if(key){
          builder = builder.find(key);
        }
        switch(style) {
          case "display":
            if( $(selector).is(':checked') ) { 
               builder.css(style,"inline-block");  
            }else{
                builder.css(style,"none"); 
            }
            break;
          case "text":
            builder.html(data);
            break;
          case "border-style":
            data= "solid";
            builder.css(style,data);
            break;
          case "background-image":
           if( data == ""){
              builder.css("background-image","");
           }else{
              builder.css({"background-image":'url("' + data + '")',
                          "background-position": "center",
                          "background-repeat": "no-repeat",
                          "background-size": "cover"
                        });
           }
            break;
           case "font-size":
              data = Number(data);  
              builder.css("font-size",data);
           default:
                builder.css(style,data);
                break;
        }   
      }  
    })
})(jQuery);