var tiny; 

jQuery.fn.outerHTML = function() {
  return jQuery('<div />').append(this.eq(0).clone()).html();
};

function Hp_CallPrint(_Content,_Test=false){
  
    let _PrintArea = $('body').find('#AreaPrint');
    if(!_PrintArea.length){
        $('body').append('<div id="AreaPrint">'+_Content+'</div>');
    }else{
        _PrintArea.empty().append(_Content);
    } 
    if(!_Test){
        setTimeout(function(){
            window.print();
        },200)
        
    }else{
        $('#AreaPrint').append('<span class="jAreaClose AreaClose"><i class="fal fa-times"></i></span>');
        $('#AreaPrint').addClass('Test');  
    } 
}

$(document).on('click','.jAreaClose',function(){
    $(this).closest('#AreaPrint').remove();
});
 
  
function hp_ChangeVietNamPhone(phone){
    

    let _oldPrefix = phone.substring(0,4);
    let _After     = phone.replace(_oldPrefix,'');
    var _ListPhone ={
        '0169':'039',
        '0168':'038',
        '0167':'037',
        '0166':'036',
        '0165':'035',
        '0164':'034',
        '0163':'033',
        '0162':'032',
        '0120':'070',
        '0121':'079',
        '0122':'077',
        '0126':'076',
        '0128':'078',
        '0123':'083',
        '0124':'084',
        '0125':'085',
        '0127':'081',
        '0129':'082', 
        '0186':'056',
        '0188':'058'
    };
    if(_ListPhone[_oldPrefix] !== undefined) return _ListPhone[_oldPrefix]+_After;else return phone;    
}
 

function hp_SpeedComplete(){
 
    if($('.jSpeedComplete').length){
        hp_importcss('./refer/ast/ex/speedcomplete/s.css?v='+_versions);
        hp_importjs('./refer/ast/ex/speedcomplete/s.js?v='+_versions);
        setTimeout(function(){
            $('.jSpeedComplete').each(function(){
                speedcomplete($(this));  
            });
        },200);
        
    }  
}
function hpImportFileOwl(){
    hp_importcss('./refer/ast/ex/owl-slider/owcl.css?v='+_versions);
    hp_importjs('./refer/ast/ex/owl-slider/owcl.v2.3.4.js?v='+_versions);  
}
function hp_OwlSlider(_Obj,_Option){
    hpImportFileOwl();
    return _Obj.owlCarousel(_Option);  
    
}
function hp_RockerZoom(_target,_Option){
    /*
    Zoom ảnh, ví dụ:
    if($('.js-tozoom').length){
      hp_RockerZoom($('.js-tozoom'),{hasDes:true});
    }
    */
    hpImportFileOwl();
    hp_importcss('./refer/ast/ex/imgfull/f.css?v='+_versions);
    hp_importjs('./refer/ast/ex/imgfull/f.js?v='+_versions); 

 
    setTimeout(function(){_target.RImgFull(_Option); },500);
}
 

function hp_Sticky(_Obj,_Option){
    hp_importjs('./refer/ast/ex/Other/Sticky.js?v='+_versions);
      setTimeout(function(){
        _Obj.stick_in_parent(_Option); 
    },200); 
}
function hp_ToolTip(){
    if($('[data-tooltip]').length){  
      hp_importjs('./refer/ast/ex/Other/ToolTip.js?v='+_versions); 
      setTimeout(function(){
        tooltip.refresh();
        },100)
      
    } 
}
function hp_InputTags(){
    if($('.jTags').length){ 
      hp_importjs('./refer/ast/ex/Other/InputTags.js?v='+_versions);
        
      setTimeout(function(){
        $('.jTags:not(.jDoneTags)').each(function(){
                let _max = $(this).data('max'),
                    _maxLength = $(this).data('maxlength');
                $(this).inputTags({ max: _max,maxLength:_maxLength});
              })
        },100)
      
    } 
}
function hp_MultiUpload(){
    if($('.js-MultiUpload').length){
        hp_importjs('./refer/ast/ex/multiupload/js/jquery.uploadfile.min.js?v='+_versions);
        hp_importjs('./refer/ast/ex/multiupload/js/init.uploadfile.min.js?v='+_versions);   
        setTimeout(function(){
            innitMiltiUpload(); 
        },300);
    } 
}
function hp_Crop(){
    if($('.js-CallCrop').length){ 
        hp_importjs('./refer/ast/js/rocker.pcrer.ori.js?v='+_versions);
        hp_importjs('./refer/ast/js/rocker.pcr.ori.js?v='+_versions);   
    }
}

function hp_RockerTools(){
    if($('.jRockerToolsGroup').length){
        hp_importjs('./refer/ast/ex/RockerTools/script.js?v='+_versions);   
    }
}
function hp_CallTiny(){
    if($('.jFrmInput.Type-TextHtml').length){
        hp_importjs('./refer/ast/ex/folderfiles/js/folder.galleries.js?v='+_versions);
        hp_importjs('./refer/ast/ex/tinymce/tinymce.full.min.js?v='+_versions);
        hp_importjs('./refer/ast/ex/tinymce/MyPlugins/rocker.tiny.helper.js?v='+_versions);
        hp_importjs('./refer/ast/ex/tinymce/tinymce.call.js?v='+_versions); 

        var toolbar_tiny =  $('.jFrmInput.Type-TextHtml').find('.jEle').data('toolbar');

        tiny = calltiny('.jFrmInput.Type-TextHtml .jEle',toolbar_tiny);
    }
    if($('.js-TinyMini').length){ 
        hp_importjs('./refer/ast/ex/tinymce/tinymce.full.min.js?v='+_versions);
        CallTinyShort();
    }
} 

function hp_InitEx(){ 
     
    if($('input[autocomplete-input="1"]').length){
        hp_importcss('./refer/ast/ex/tautocomplete/css/tautocomplete.css?v='+_versions);
        hp_importjs('./refer/ast/ex/tautocomplete/js/tautocomplete.js?v='+_versions); 
    }
    

    if($('.js-Table-FixHeader').length){
        $('.js-Table-FixHeader').each(function(){
            $(this).fixedHeader();
        });
    }
    

    if($('.jColorPicker').length){
        hp_importcss('./refer/ast/ex/colorpicker/css/spectrum.css?v='+_versions);
        hp_importjs('./refer/ast/ex/colorpicker/js/spectrum.min.js?v='+_versions);
        setTimeout(function(){
           $('.jColorPicker').spectrum({
                    type: "component", 
            }); 
        },200);  
    } 

    if($('.jViewSlideMode').length){
        hp_importcss('./refer/ast/ex/ViewSlideMode/f.css?v='+_versions);
        hp_importjs('./refer/ast/ex/ViewSlideMode/f.js?v='+_versions); 
    }  

    if($('.jDynamicSearchPropertyPlace').length){
        /* #byRocker Giành riêng cho cụm Tính năng tìm kiếm và thêm Property vào list, liên quan modules Property*/
        hp_importcss('./refer/ast/css/pri_css/PropertyDynamic_AddList.css?v='+_versions);
        hp_importjs('./refer/ast/js/pri_js/PropertyDynamic_AddList.js?v='+_versions); 
    }

    TimeCountDownMinuteSec();
    hp_ToolTip();
    
    makeDragsort();    
    hp_SpeedComplete();
    hp_Day();
    hp_NumberInput();
    hp_PercentInput();
    
    hp_RockerTools();
    hp_MultiUpload();
    hp_Crop(); 
    hp_InputTags(); 
    hp_CallTiny(); 
    RockerLazyLoad();
    hp_Select2();
    hp_pdfLoad();


    if($('.jFix').length&&$(window).width()>1000&&_Device=='3'){ 
            if($(".jFix").length){  
                hp_Sticky($('.jFix'),{
                    parent:'.jFixParent',
                    offset_top:130,  
                }); 
           }  
    } 


    if($('.jShortText').length){
        hp_Html_ShortText();
    }
    

    /*for zoomimg*/
    if ($('.jAvatar').length) {
        $('.jAvatar').click(function () {
            let _Avatar = $(this);
            let _Img = _Avatar.find('img[data-avatar="1"]');
            let _Frame = _Avatar.find('img[data-avatar="2"]');
            if (_Img.length && _Frame.length) {
                _Img = _Img.eq(0).attr('src');
                _Frame = _Frame.eq(0).attr('src');
                RockerAvatar(_Img, _Frame);
            }
        });
    }

    if($('.jZoomImg').length){
        $('.jZoomImg').each(function(){
            var parentzoom = $(this).attr('parentzoom');
            var ImageList = (parentzoom)?$(this).closest(parentzoom).data('imagelist'):''; /*<span class="jImagesList" isvideo="false" src-origin="" data-alt=""></span>*/
            /*parentzoom = (parentzoom)?parentzoom:'';*/
            hp_RockerZoom($(this),{ParentClass:parentzoom,ImageList:ImageList,hasDes:true,ShowThumb:true});
        }); 
    }

    if($('.jZoomGroupImg').length){
        $('.jZoomGroupImg').each(function(){
            var parentzoom = '.jZoomGroupImg';
            var ImageList = $(this).attr('zoom-imagelist'); /*<span class="jImagesList" isvideo="false" src-origin="" data-alt=""></span>*/
            var _TargetImg = $(this).attr('zoom-targetimg'); 
            _TargetImg = (_TargetImg)?_TargetImg:'img'; 

            var _HasDes = $(this).attr('zoom-hasdes');
            _HasDes = (_HasDes)?_HasDes:false;
            var _ShowThumbs = $(this).attr('zoom-showthumbs');
            _ShowThumbs = (_ShowThumbs)?_ShowThumbs:true; 

            $(this).find(_TargetImg).each(function(){
                hp_RockerZoom($(this),{ParentClass:parentzoom,ImageList:ImageList,hasDes:_HasDes,ShowThumb:_ShowThumbs}); 
            }); 
            if(_TargetImg=='img'){
                $(this).find('video').each(function(){
                    hp_RockerZoom($(this),{ParentClass:parentzoom,ImageList:ImageList,hasDes:_HasDes,ShowThumb:_ShowThumbs}); 
                }); 
            }
        });
    }

    /*ed for zoomimg*/

    /*bg jSortOrder*/
    if($('.jSortOrder').length){
      $('.jSortOrder').each(function(){ 
        const _FunctionAfterSort = $(this).attr('after-sort');
        $(this).sortable(
          {
            handle: $(this).attr('handle-sort'),
            stop: function(event, ui) {
              if(_FunctionAfterSort){
                window[_FunctionAfterSort]($(this),event,ui);
              }
            }
          }
        );
      });
    }  
    /*ed jSortOrder*/
}

function RockerAvatar(img,frame){
    let background = img.replace('/thumbs','/gallery');
    img = img.replace('/thumbs','');
    let _Html = `
    <div class="ShowFullAvatar jShowFullAvatar">
        <div class="Background" style="background-image: url(&quot;${background}&quot;);"></div>
        <span class="Close jCloseShowFullAvatar" aria-label="Đóng trình chiếu ảnh"><i class="fal fa-times"></i></span>
        <div class="Content">
            <div class="Container">
                <img class="Image" src="${img}" alt="Ảnh đại diện">
                <img class="Frame" src="${frame}" alt="Khung ảnh">
                <div class="Frame"></div>
            </div>
        </div>
        <a href="javascript:void(0)" class="El-DownloadAvatar jDownloadAvatar" data-img="${img}" data-frame="${frame}" data-func="">Bấm để tải hình <i class="fas fa-download"></i> </a>
    </div>
    `
    $('body').append(_Html);
    $('.jCloseShowFullAvatar').click(function(){
        $(this).closest('.jShowFullAvatar').remove();
        return false;
    });
    $('.jDownloadAvatar').click(function(e){
        let _Img = $(this).data('img');
        let _Frame = $(this).data('frame');
        if (!_Img || !_Frame) return false;
        var _Data   = {LinkImage:_Img,LinkFrame:_Frame};

        var _Resp = dtl_CallAjax('RockerAjax/NoRequired_DownloadAvatar',_Data);

        if (_Resp.Status == 200 && _Resp?.Data?.DataImage) {
            let DataImage = _Resp.Data.DataImage;
            let FileName = _Resp.Data.FileName;
            let $downloadLink = $('<a>')
                .attr('href', 'data:image/png;base64,'  + DataImage )
                .attr('download', FileName)
                .appendTo('body');
            $downloadLink[0].click();
            $downloadLink.remove();
        }
        return false;
    });
}


function RockerLazyLoad(){
var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
        var lazyBackgrounds = [].slice.call(document.querySelectorAll(".lazy-bg"));
        var iAnimate = [].slice.call(document.querySelectorAll("html.Loaded .iani"));
         
        if ("IntersectionObserver" in window) {
            let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        let lazyImage = entry.target;
             
                        var _loadsrc = lazyImage.getAttribute('src-load');
                        if(_loadsrc){
                            rsc = _loadsrc; 
                        }else if (lazyImage.classList.contains('lazy-origin')) {
                            rsc = lazyImage.src.replace("/gallery", "");
                            rsc = rsc.replace("/thumbs", "");

                        } else {
                            rsc = lazyImage.src.replace("/gallery", "/thumbs");
                        }
                        lazyImage.src = rsc;
                        lazyImage.onload = function() {
                            lazyImage.classList.remove("lazy");
                        };
                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });
            lazyImages.forEach(function(lazyImage) {
                lazyImageObserver.observe(lazyImage);
            }); /*bg*/
            let lazyBackgroundObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        let lazyBg = entry.target; 
                        let newbg = lazyBg.getAttribute('style'); 

                        if (lazyBg.classList.contains('lazy-origin')) {
                            if(lazyBg.classList.contains('lazy-mobile')&&_device==1){
                                lazyBg.style = newbg.replace("/gallery", "/thumbs");
                            }else{
                                lazyBg.style = newbg.replace("/gallery", "");
                            }
                            lazyBg.classList.remove("lazy-bg");
                            lazyBg.classList.add("lazy-loaded");
                        } else {
                            lazyBg.style = newbg.replace("/gallery", "/thumbs");
                            lazyBg.classList.remove("lazy-bg");
                            lazyBg.classList.add("lazy-loaded");
                        } 
                        
                           
                        lazyBackgroundObserver.unobserve(lazyBg);
                    }
                });
            });
            lazyBackgrounds.forEach(function(lazyBg) {
                lazyBackgroundObserver.observe(lazyBg);
            }); /*ani*/
            
            let iAnimateObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) { 
                    if (entry.isIntersecting) {  
                        let iAnimated = entry.target;
                        iAnimated.classList.add("iani_go");
                    } 
                });
            },
            { 
                threshold: 0
            }
            );
            iAnimate.forEach(function(iAnimated) {
                iAnimateObserver.observe(iAnimated);
            });
            

             
        }
}

function CallTinyShort(){
  /*bg des_vn*/ 
  var tinyDes = tinymce.init({
    selector: '.js-TinyMini',
   
    height:400,
    menubar: false,
    theme: "modern", 

    mode : "specific_textareas",
    plugins: [
      'advlist autolink lists link paste anchor textcolor', 
    ],
      paste_auto_cleanup_on_paste : false,
      paste_remove_styles: true,
      paste_remove_styles_if_webkit: true,
      paste_strip_class_attributes: true, 
      paste_as_text: true,
    toolbar: 'undo redo | bold italic | bullist numlist  | forecolor backcolor | removeformat alignleft aligncenter alignright alignjustify',
    setup: function (editor) {
          editor.on('change', function () {
              tinymce.triggerSave();
          });   
    },init_instance_callback: function (editor) { /*Bắt sự kiện trong editor*/
      editor.on('KeyUp', function (e) { 
          if(e.keyCode === 8||e.keyCode==46) {
              var img = editor.selection.getNode(); 
              var parent  = editor.dom.getParent(img,'.tny-FramedImage'); 
              if(parent) parent.replaceWith(''); 
          }
        
      });
    }
    /*content_css: [
      '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
      '//www.tiny.cloud/css/codepen.min.css'
    ]*/
  });
  /*ed des_vn*/
} 

 
function ImportautoNumbericJS(){  
    hp_importjs('./refer/ast/js/autoNumeric.v2.min.js?v='+_versions);
}

function hp_NumberInput(_Update=false){
    if($('.jNumberFormat').length){  
          ImportautoNumbericJS(); 

          $('.jNumberFormat:not(.IsSet)').each(function(){  
            let _imc = $(this).attr('mDec'),
                _ivm = $(this).attr('vMax'),
                _ivi = $(this).attr('vMin');   
            const aNumberic = new AutoNumeric(this, {
                decimalPlaces: (_imc) ? _imc : 0,
                maximumValue: (_ivm) ? _ivm : '999999999999',
                minimumValue: (_ivi) ? _ivi : '0',

                decimalCharacter: ',',
                digitGroupSeparator: '.',
                modifyValueOnWheel: false,

            });
            $(this).data('autoNumericInstance', aNumberic);
            $(this).addClass('IsSet'); 
            $(this).addClass('jIsNumberic'); 
            $(this).addClass('jOK'); 
        });
    }
}
function hp_PercentInput(){
    if($('.jPercentFormat').length){   
        ImportautoNumbericJS(); 
          $('.jPercentFormat:not(.IsSet)').each(function(){ 
            let _imc = $(this).attr('mDec'),
                _ivm = $(this).attr('vMax'),
                _ivi = $(this).attr('vMin'); 
            
            const aNumberic = new AutoNumeric(this, {
                decimalPlaces: 2, 
                maximumValue: 99, 
                minimumValue: (_ivi) ? _ivi : 0, 
                suffixText: '%',
                decimalCharacter: '.',
                digitGroupSeparator: '',
                modifyValueOnWheel: false,
            });

            $(this).data('autoNumericInstance', aNumberic);
            $(this).addClass('IsSet'); 
            $(this).addClass('jIsNumberic'); 
        });
    }
}
 

function hp_Select2(){
    if($('.jSelect2').length){ 
        hp_importcss('./refer/ast/ex/select2/css/select2.css');
        hp_importjs('./refer/ast/ex/select2/js/select2.min.js');
        setTimeout(function(){
            $('select.jSelect2').select2({
                placeholder: "Chọn 2",
                allowClear: true, 
            });
        },500)
      } 
}

function hp_ImportDateCssJs(){
    hp_importcss('./refer/ast/ex/datetimepicker/css/bootstrap-datetimepicker.css?v='+_versions);
    hp_importcss('./refer/ast/ex/datetimepicker/css/bootstrap-datetimepicker-standalone.css?v='+_versions); 
    hp_importjs('./refer/ast/js/moment-with-locales.min.js?v='+_versions);
    hp_importjs('./refer/ast/ex/datetimepicker/js/bootstrap-datetimepicker.min.js?v='+_versions);
} 
function hp_Day(){
    if($('input.jDay').length){   
        hp_ImportDateCssJs();


        $('input.jDay').each(function() { 
              var _dayViewHeaderFormat = "MMMM YYYY";

              var dateFormat = $(this).data('dateformat');
              if (!dateFormat||dateFormat == '' || dateFormat == null) {
                  dateFormat = 'DD-MM-YYYY';
              }else if(dateFormat=='DD'||dateFormat=='DD-MM'){ 
                /*_dayViewHeaderFormat = "MMMM";*/
              }
              
              var _MinDay = $(this).data('minday');
              var _MaxDay = $(this).data('maxday');
              
              var _Debug = false;/*Debug for dev*/



            
            if(_MaxDay){
                _MaxDay = new Date(_MaxDay);
                _MaxDay.setHours(23);
                _MaxDay.setMinutes(59);
                _MaxDay.setSeconds(0);
            }  
            if(_MinDay){
                _MinDay = new Date(_MinDay);
                _MinDay.setHours(0);
                _MinDay.setMinutes(0);
                _MinDay.setSeconds(0);
            }  

              if(_MinDay&&_MaxDay){
                 $(this).datetimepicker({
                        dayViewHeaderFormat: _dayViewHeaderFormat,
                        format: dateFormat,
                        locale:jLanguage, 
                        minDate: new Date(_MinDay),  
                        maxDate: _MaxDay,  
                        debug: _Debug, 
                  });
              }else if(_MinDay){
                 $(this).datetimepicker({
                        dayViewHeaderFormat: _dayViewHeaderFormat,
                        format: dateFormat,
                        locale:jLanguage, 
                        minDate: new Date(_MinDay),  
                  });
              }else if(_MaxDay){ 
                 $(this).datetimepicker({
                        dayViewHeaderFormat: _dayViewHeaderFormat,
                        format: dateFormat,
                        locale:jLanguage, 
                        maxDate: _MaxDay,  
                        debug: _Debug, 
                  }).on('dp.change', function(e) {
               
                });;

              }else{
                $(this).datetimepicker({
                        dayViewHeaderFormat: _dayViewHeaderFormat,
                        format: dateFormat,
                        locale:jLanguage,   
                        debug: _Debug, 
                  });
              }
              
        });
      } 

    if ($('input.jTime').length) {
        hp_ImportDateCssJs();
        $('input.jTime').each(function() {
            /*var dateFormat = $(this).data('format');
            if (dateFormat == '' || dateFormat == null) {*/
                dateFormat = 'HH:mm';
            /*}*/
            $(this).datetimepicker({
                format: dateFormat,
                locale: jLanguage, 
            });
        });
    }
 
}

function Hp_TotalDisplayChange(_number,reset=false){
    const _DisNumber = $('.jTotalDisplay').find('.jNumber');
    if(!reset){
        var _thisNumber = parseInt(_DisNumber.text());
        _DisNumber.text(_thisNumber + _number);
    }else{
        _DisNumber.text(_number);
    }
    
}

function hp_contextmenu(_this,_elementhtml,e){
    $('#tooltip').remove();
    let offset = _this.offset(); 
    let _topct = (e.pageY - offset.top),
    _lefct = (e.pageX - offset.left);

 
    let _contextmenuHtml = '<ul class="la-contextmenu la-BoxShadow ActiveOut" style="top:'+_topct+';left:'+_lefct+'">'+_elementhtml+'</ul>';

    $('.la-contextmenu').removeClass('ActiveOut');

    let _contextmenu = _this.find('.la-contextmenu');
    if(!_contextmenu.length){
      _this.append(_contextmenuHtml)
    }else{
      _contextmenu.css({"top":_topct,"left":_lefct});
      setTimeout(function(){_contextmenu.addClass('ActiveOut')},200)
    }  
} 
function hp_GetFileName(fullPath){  

    if (fullPath)
   {
      var m = fullPath.toString().match(/.*\/(.+?)\./);
      if (m && m.length > 1)
      {
         return m[1];
      }
   }
   return "";
}
function hp_autoHeighTextarea(jq_in){
    jq_in.each(function(index, elem){ 
        elem.style.height = elem.scrollHeight+'px'; 
    });
}
function Hp_isNumber(_value) { 
  return (!isNaN(parseFloat(_value)) && isFinite(_value));
}
function Hp_isElementOffContainer(_container,element) {
    /**container is Div or $(window)*/
  var window_top = _container.scrollTop();
  var window_bottom = window_top + _container.height()-120;
  var element_top = $(element).offset().top;
  var element_bottom = element_top + $(element).height();
 

  return (element_bottom < window_top || element_top > window_bottom);
}

$.fn.hp_isInViewport = function(_Plus=0) { 

    var this_Top = $(this)?.offset()?.top;
    if(!this_Top)return true;

    let _HeightHeader = parseInt($('header').height());
    let _HeightNav    = $('body.fix').find('.js-group-nav').height();
    if(_HeightNav) _HeightHeader = parseInt(_HeightNav)+_HeightHeader;

    if(_Plus>0)_HeightHeader = _HeightHeader + parseInt(_Plus);
  
    var elementTop = $(this).offset().top-_HeightHeader;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
};

$.fn.hp_isInViewParent = function(_Parent = '') {
    
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = _Parent.scrollTop();
    var viewportBottom = viewportTop + _Parent.height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
};
function Hp_scrollToElement(_container, _element,_plus = 0) { 
  if(!_container.length) return false; 
  var containerTop = _container.offset().top; 
   if(_container.hasClass('jRockerPopup')){ 
    containerTop = 0; 
   }   
  var elementTop = _element.offset().top;
  var offset = elementTop - containerTop;
  _container.animate({ scrollTop: (offset+_plus) }, 'slow'); 
}
function hp_HeadCode(_List,_Type="css"){
    if(_List.length){
        if(_Type=='css'){
            for (var i = 0; i < _List.length; i++) {
                hp_importcss(_List[i]); 
            }
        }else if(_Type=='js'){
            for (var i = 0; i < _List.length; i++) {
                hp_importjs(_List[i]); 
            }
        }  
    }
}
function hp_importcss(_linkfile=''){ 
    if(!_linkfile) return false;
    if (!$('link[href="'+_linkfile+'"]').length)
    $('<link href="'+_linkfile+'"  rel="stylesheet">').appendTo("head");    
}
function hp_importjs(_linkfile=''){ 
    if(!_linkfile) return false;
    if (!$('script[src="'+_linkfile+'"]').length)
    $('<script type="text/javascript" src="' + _linkfile + '"></script>').appendTo("head");    
}
function hp_removeParam(key, sourceURL='') {
    if(!sourceURL) sourceURL = location.href;
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}
function hp_replaceParam( paramName, paramValue,url)
{
    if(!url) url = location.href;

    if (paramValue == null) {
        paramValue = '';
    }
    var pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
    if (url.search(pattern)>=0) {
        return url.replace(pattern,'$1' + paramValue + '$2');
    }
    url = url.replace(/[?#]$/,'');
    return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
}
function getAllURLParams(url) {
  var queryString = url ? url.split('?')[1] : window.location.search.slice(1);
  var obj = {};
  
  if (queryString) {
    queryString = queryString.split('#')[0];
    var arr = queryString.split('&');

    for (var i = 0; i < arr.length; i++) {
      var a = arr[i].split('=');
      var paramName = decodeURIComponent(a[0]);
      var paramValue = typeof (a[1]) === 'undefined' ? true : decodeURIComponent(a[1]);
      
      if (paramName.match(/\[(\d+)?\]$/)) {
        var key = paramName.replace(/\[(\d+)?\]/, '');
        if (!obj[key]) obj[key] = [];
        
        if (paramName.match(/\[\d+\]$/)) {
          var index = /\[(\d+)\]/.exec(paramName)[1];
          obj[key][index] = paramValue;
        } else {
          obj[key].push(paramValue);
        }
      } else {
        if (!obj[paramName]) {
          obj[paramName] = paramValue;
        } else if (obj[paramName] && typeof obj[paramName] === 'string'){
          obj[paramName] = [obj[paramName]];
          obj[paramName].push(paramValue);
        } else {
          obj[paramName].push(paramValue);
        }
      }
    }
  }
  return obj;
}
function hp_editParam(param, paramVal,replaceUrl = true)
{
    url = location.href;
    var TheAnchor = null;
    var newAdditionalURL = "";
    var tempArray = url.split("?");
    var baseURL = tempArray[0];
    var additionalURL = tempArray[1];
    var temp = "";

    if (additionalURL) 
    {
        var tmpAnchor = additionalURL.split("#");
        var TheParams = tmpAnchor[0];
            TheAnchor = tmpAnchor[1];
        if(TheAnchor)
            additionalURL = TheParams;

        tempArray = additionalURL.split("&");

        for (var i=0; i<tempArray.length; i++)
        {
            if(tempArray[i].split('=')[0] != param)
            {
                newAdditionalURL += temp + tempArray[i];
                temp = "&";
            }
        }        
    }
    else
    {
        var tmpAnchor = baseURL.split("#");
        var TheParams = tmpAnchor[0];
            TheAnchor  = tmpAnchor[1];

        if(TheParams)
            baseURL = TheParams;
    }

    if(TheAnchor)
        paramVal += "#" + TheAnchor;

    var rows_txt = temp + "" + param + "=" + paramVal;

    if(replaceUrl){
        history.replaceState('', '', baseURL + "?" + newAdditionalURL + rows_txt); 
    }else{
        return baseURL + "?" + newAdditionalURL + rows_txt;
    } 
}
function hp_numberTrash(numbers){
    let _Trash = $('.js-numberTrash');
    if(numbers=='-'||numbers=='+'){
        let _currentnumbers = parseInt(_Trash.text());
        if(numbers=='-'){
            numbers = _currentnumbers - 1;
        }else{
            numbers = _currentnumbers + 1;
        }
    }  
    if(_Trash.length) _Trash.empty().append(numbers);
}
function urldecode(url) {
    return decodeURIComponent(url.replace(/\+/g, ' '));
}
function hp_ReloadNotClosePopup(){

    let _href = location.href;

    _href = hp_removeParam("t",_href);
    _href = urldecode(_href);
    
    var time = new Date().getTime(); 

    var encodedTime = encodeURIComponent(time);

    History.pushState(null, document.title, _href + (_href.indexOf('?') != -1 ? '&' : '?') + 't=' + encodedTime);
    
    setTimeout(function(){$('#tooltip').remove();},100);
    return false;
}
function hp_Reload(){

    let _href = location.href;

    _href = hp_removeParam("t",_href);
    _href = urldecode(_href);
    
    var time = new Date().getTime(); 

    var encodedTime = encodeURIComponent(time);

    History.pushState(null, document.title, _href + (_href.indexOf('?') != -1 ? '&' : '?') + 't=' + encodedTime);
    
    $('.jRockerPopup .jClose').trigger('click'); 
    $('.jRockerPopup').remove();
    setTimeout(function(){$('#tooltip').remove();},100);
    return false;
}
function hp_ToLink(_href){ 
    if (_decl == true) {
        console.log("waiting...");
        return false;
    }    
    var time = new Date().getTime(); 
    History.pushState(null, document.title, _href + (_href.indexOf('?') != -1 ? '&' : '?') + 't=' + time);
    
    $('.jRockerPopup .jClose').trigger('click'); 

    return false;
}
function hp_NumberFormat(n,IsMoney=false) {
    let _Prefix = (IsMoney)?' ₫':'';
    var parts=n.toString().split(".");
    return parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".") + (parts[1] ? "," + parts[1] : "")+_Prefix;
}
/*for copy*/

window.Clipboard = (function(window, document, navigator) {
    var textArea,
        copy;

    function isOS() {
        return navigator.userAgent.match(/ipad|iphone/i);
    }

    function createTextArea(text) {
        textArea = document.createElement('textArea');
        textArea.value = text;
        document.body.appendChild(textArea);
    }

    function selectText() {
        var range,
            selection;

        if (isOS()) {
            range = document.createRange();
            range.selectNodeContents(textArea);
            selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            textArea.setSelectionRange(0, 999999);
        } else {
            textArea.select();
        }
    }

    function copyToClipboard() {        
        document.execCommand('copy');
        document.body.removeChild(textArea);
    }

    copy = function(text) {
        createTextArea(text);
        selectText();
        copyToClipboard();
    };

    return {
        copy: copy
    };
})(window, document, navigator);

$(document).on('click','[CopyText]',function(event){  
    event.stopPropagation();
  ClipboardHelper.copyText($(this).attr('CopyText'));  
}).on('click','[CopyHtml]',function(event){  
    event.stopPropagation();
    var htmlContent = $(this).find('.HtmlForCopy').html();
    ClipboardHelper.copyText(htmlContent);  
}).on('click','.jCopyTextTarget',function(){ 
    var _TargetCopy = $(this).data('target');
    var htmlContent = $(_TargetCopy).html();
    htmlContent = ClipboardHelper.formatHtmlToText(htmlContent);
    var _NotiText = $(this).data('noti');
    _NotiText = (_NotiText)?_NotiText:'';
    ClipboardHelper.copyText(htmlContent,_NotiText);  
});

var ClipboardHelper = {
    formatHtmlToText: function(htmlContent) {
        const tempDiv = document.createElement('div');
        tempDiv.innerHTML = htmlContent;

        const specialElements = tempDiv.querySelectorAll('br, p, div, li, tr');
        specialElements.forEach(el => {
            if (el.tagName === 'BR') {
                el.replaceWith('\n');
            } else {
                el.insertAdjacentText('beforeend', '\n');
            }
        });

        const lists = tempDiv.querySelectorAll('ul, ol');
        lists.forEach(list => {
            const items = list.querySelectorAll('li');
            items.forEach((item, index) => {
                item.insertAdjacentText('beforebegin', `${index + 1}. `);
            });
        });

        const tables = tempDiv.querySelectorAll('table');
        tables.forEach(table => {
            const rows = table.querySelectorAll('tr');
            rows.forEach(row => {
                const cells = row.querySelectorAll('td, th');
                cells.forEach((cell, index) => {
                    if (index > 0) cell.insertAdjacentText('beforebegin', ' | ');
                });
                row.insertAdjacentText('afterend', '\n');
            });
        });

        let text = tempDiv.textContent
            .replace(/\n\s*\n/g, '\n') 
            .replace(/^\s+|\s+$/g, '')
            .replace(/&nbsp;/gi, ' ')
            .replace(/&amp;/gi, '&')
            .replace(/&lt;/gi, '<')
            .replace(/&gt;/gi, '>')
            .replace(/&quot;/gi, '"')
            .replace(/&#39;/gi, "'");

        return text;
    },

    copyElement: function($element) {
        this.copyText(this.formatHtmlToText($element.html()));
    },

    copyText: function(text, ContentMss = '') {
        text = text.replace('=&gt;', '=>');
        
        // Create and configure textarea
        const $tempInput = $('<textarea>')
            .css({
                position: 'fixed',
                left: '-9999px',
                top: '0',
                opacity: '0'
            })
            .val(text);

        // Append, select and copy
        $('body').append($tempInput);
        $tempInput.select();
        
        try {
            document.execCommand('copy');
            RockerMessage('Info', translator.getStr('Copied'), ContentMss || text);
        } catch (err) {
            console.error('Failed to copy text: ', err);
            RockerMessage('Error', translator.getStr('CopyFailed'), '');
        } finally {
            $tempInput.remove();
        }
    }
};
/*ed for copy*/

$(document).on('click','.jhpClose',function(){
    $(this).closest('.jhpParent').remove();
}).on('click','.jFocusAll .jEle,input.jFocusAll',function(){
    $(this).select(); 
}).on('click','.jhpTextEnCrypt',function(){
     
  var _val = $(this).data('text'); 
  var _showDecr = $(this).find('.jShowDecr');  
  var _action = $('#MainPageContainer').data('action');

  if($(this).hasClass('active')){ 
    _showDecr.empty().append(_showDecr.data('star'));
    $(this).removeClass('active'); 
  }else{ 
    var _Resp = dtl_CallAjax(_action+ '/View_DecrText',{Value:_val}); 
    if(_Resp.Status==200&&_Resp?.Data?.String){
        _showDecr.empty().append(_Resp.Data.String); 
        $(this).addClass('active'); 
    } 
  } 
}).on('click','.jhpTextEnCryptShowData',function(){
     
  var _val = $(this).data('text'); 
  var _showDecr = $(this).find('.jShowDecr');  
  var _action = $('#MainPageContainer').data('action');

  if($(this).hasClass('active')){ 
    _showDecr.empty().append(_showDecr.data('star'));
    $(this).removeClass('active'); 
  }else{ 
    var _Resp = dtl_CallAjax(_action+ '/View_DecrText',{Value:_val}); 
    if(_Resp.Status==200&&_Resp?.Data?.String){
        _showDecr.empty().append(_Resp.Data.String); 
        $(this).addClass('active'); 
    } 
  } 
}).on('click','.jhpShowDataTextCrypt',function(){
     
  var _val = $(this).data('text'); 
  var _showDecr = $(this).find('.jShowDecr');  
  var _action = $('#MainPageContainer').data('action');
  var _RightsShowData = $(this).data('rights');

  if($(this).hasClass('active')){ 
    _showDecr.empty().append(_showDecr.data('star'));
    $(this).removeClass('active'); 
  }else{ 
    var _Resp = dtl_CallAjax(_action+ '/RightsShowData_DecrText',{Value:_val,RightsShowData:_RightsShowData}); 
    if(_Resp.Status==200&&_Resp?.Data?.String){
        _showDecr.empty().append(_Resp.Data.String); 
        $(this).addClass('active'); 
    } 
  } 
}).on('click','.jPrint',function(){
     
   var _Link = $(this).attr('href');
   var _DataTest = $(this).data('test');

   var _getParamUrl = $(this).attr('get-url-param');

   var _Data = (_getParamUrl&&_getParamUrl!='0')?getAllURLParams():{};
   var _Html = dtl_GetAniHtml(_Link,_Data);
   var _test = ((_DataTest)?true:false);/*true -> turn on test*/
   Hp_CallPrint(_Html,_test);

   return false;
}).on('click','.jDowloadTrack',function(){
    var _LinkDowload = $(this).attr('href');
    var _Modules = $(this).data('modules');
    hp_DowloadTrack(_LinkDowload,_Modules);
    return false;
});


function OLD_hp_DowloadTrack(_LinkDowload,_Modules=''){
    var _Resp = dtl_CallAjax(_Modules+ '/View_DownloadFile',{LinkDowload:_LinkDowload});
    var _ToDowload = _Resp?.Data?.LinkDowload;
    if(_ToDowload){ 
        var downloadLink = document.createElement('a');
        downloadLink.href = _ToDowload;
        downloadLink.target='_blank';
        downloadLink.download = '';
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
}
function hp_DowloadTrack(_LinkDowload,_Modules=''){
    const _Resp = dtl_CallAjax(_Modules+ '/View_DownloadFile',{LinkDowload:_LinkDowload});
    const _ToDowload = _Resp?.Data?.LinkDowload;
    const _DataImage = _Resp?.Data?.DataImage;
    const _FileName = _Resp?.Data?.FileName;
    const _Type = _Resp?.Data?.Type;
    if(_ToDowload){
        const downloadLink = document.createElement('a');
        downloadLink.href = _DataImage? ((_Type == 'png') ? 'data:image/png;base64,' : 'data:image/jpeg;base64,') + _DataImage : _ToDowload;
        downloadLink.target='_blank';
        downloadLink.download = _FileName;
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }
}


function hp_CompactNumber(_number) {
    const _Thousand = 'Ngàn';
    const _Million = 'Triệu';
    const _Billion = 'Tỷ';
    const _Point = '.';
    
    let _NumberResult = '';
    let _leftValue = _number;
    if (_number <= 1000) {
        return _number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, _Point);
    }
    const processUnit = (unit, unitString) => {
        if (_leftValue >= unit) {
            const _Value = Math.floor(_leftValue / unit);
            _NumberResult += _Value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, _Point) + ' ' + unitString + ' ';
            _leftValue -= _Value * unit;
        }
    };
    processUnit(1000000000, _Billion); 
    processUnit(1000000, _Million); 
    processUnit(1000, _Thousand); 
    if (_leftValue > 0) {
        _NumberResult += _leftValue.toString().replace(/\B(?=(\d{3})+(?!\d))/g, _Point);
    }
    return _NumberResult;
}


function TimeCountDownMinuteSec(){
    if(!$('.jCountDownMS').length)return false;

    $('.jCountDownMS').each(function(){
    
        const _this    = $(this); 
        const _TarSec  = _this.find('.jSec');
        const _TarMin  = _this.find('.jMinute');

        const _funcAfter = _this.attr('jfunction');

        


        let downloadTimer = setInterval(function(){
          if(!$('.jCountDownMS').length){
             clearInterval(downloadTimer);
             return false;
          }
          
          let _curSec  = parseInt(_TarSec.text());
          let _curMin  = parseInt(_TarMin.text());
          
          

          if(_curSec<=0&&_curMin>0){ 
            _curSec = 60; /*Reset lại số giây về 60 để tính toán*/
            _curMin = _curMin - 1;
            _TarMin.text(_curMin);
          } 

          if(_curSec <= 0 && $('.jCountDownMS').length){
            clearInterval(downloadTimer);

            if (_funcAfter) {
              window[_funcAfter](_this);
            }else{
              location.reload();
            } 
          }   
          _TarSec.text(_curSec - 1);  
        }, 1000); 

      }); 
}

function RemoveAfterTimeCount(_this){
    _this.closest('.jToolsItems').remove();
}

function WaitingForCount(NumberSecond){
    var _Html ='<div class="WaitingForCount" id="waitingForCount"> <div class="Text">Vui Lòng Đợi</div> <div class="Time"><span class="jCount" id="jCount">'+NumberSecond+'</span> giây</div> </div>';
    $('body').append(_Html);
    
    let count = NumberSecond;
    const jCountElement = document.getElementById('jCount');
    const waitingForCountElement = document.getElementById('waitingForCount');

     

    var countdown = setInterval(() => {
        count--;
        jCountElement.textContent = count;
        if (count <= 0) {
            clearInterval(countdown);
            waitingForCountElement.style.display = 'none';
        }
    }, 1000);
 
}

function hp_pdfLoad(){
    if($('.jItemsLoadPdf').length){  
      
      hp_importjs('./refer/ast/ex/pdf/pdf.min.js?v='+_versions); 
      hp_importjs('./refer/ast/ex/pdf/pdf.worker.min.js?v='+_versions);   
      var pdfDoc = null,
    pageNum = 1,
    scale = 1.5,
    pdfContainer = document.querySelector(".jItemsLoadPdf");
  var infoFileElement = document.querySelector(".jItemsLoadPdf");

  var infoFileData = infoFileElement.getAttribute("data-info-file");

  if (infoFileData) {
    async function renderAllPages() {
      for (let i = 1; i <= pdfDoc.numPages; i++) {
        const page = await pdfDoc.getPage(i);
        const canvas = document.createElement('canvas');
        pdfContainer.appendChild(canvas);

        const viewport = page.getViewport({ scale: scale });
        canvas.height = viewport.height;
        canvas.width = viewport.width;

        const context = canvas.getContext('2d');
        await page.render({ canvasContext: context, viewport: viewport }).promise;
      }
    
    }

 
    pdfjsLib.getDocument({data: atob(infoFileData)}).promise.then((doc) => {
      pdfDoc = doc;
      renderAllPages(pageNum);
      infoFileElement.classList.remove('jItemsLoadPdf');
    }).catch((error) => {
      
    });
  } else {
    
  }
    } 
}


function hp_Html_ShortText(element,_FunctionJavascript=''){
    if(!$('.jShortText').length||!element) return false;
    
    var shortText = element.closest('.jShortText');
    var fullText = shortText.nextElementSibling;

    if (fullText.style.display === "none") {
        shortText.style.display = "none";
        fullText.style.display = "inline";
        element.innerText = "Thu gọn";
        if(_FunctionJavascript){
            window[_FunctionJavascript](element);
        }
    }  
}

