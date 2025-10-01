/*table*/

var hasTouch = 'ontouchstart' in document.documentElement,
    startEvent = hasTouch ? 'touchstart' : 'mousedown',
    moveEvent = hasTouch ? 'touchmove' : 'mousemove',
    endEvent = hasTouch ? 'touchend' : 'mouseup';
/*if (hasTouch) {
    $.each("touchstart touchmove touchend".split(" "), function(i, name) {
        jQuery.event.fixHooks[name] = jQuery.event.mouseHooks
    });
}
*/
jQuery.tableDnD = {
    currentTable: null,
    dragObject: null,
    mouseOffset: null,
    oldY: 0,
    build: function(options) {
        this.each(function() {
            this.tableDnDConfig = jQuery.extend({
                onDragStyle: null,
                onDropStyle: null,
                onDragClass: "tDnD_whileDrag",
                onDrop: null,
                onDragStart: null,
                scrollAmount: 5,
                serializeRegexp: /[^\-]*$/,
                serializeParamName: null,
                dragHandle: null
            }, options || {});
            jQuery.tableDnD.makeDraggable(this)
        });
        return this
    },
    makeDraggable: function(table) {
        var config = table.tableDnDConfig;
        if (config.dragHandle) {
            var cells = jQuery(table.tableDnDConfig.dragHandle, table);
            cells.each(function() {
                jQuery(this).bind(startEvent, function(ev) {
                    jQuery.tableDnD.initialiseDrag(jQuery(this).parents('tr')[0], table, this, ev, config);
                    return false
                })
            })
        } else {
            var rows = jQuery("tr", table).not('.nodrop');
            rows.each(function() {
                var row = jQuery(this);
                if (!row.hasClass("nodrag")) {
                    row.bind(startEvent, function(ev) {
                        if (ev.target.tagName == "TD") {
                            jQuery.tableDnD.initialiseDrag(this, table, this, ev, config);
                            return false
                        }
                    }).css("cursor", "default")
                }
            })
        }
    },
    initialiseDrag: function(dragObject, table, target, evnt, config) {
        jQuery.tableDnD.dragObject = dragObject;
        jQuery.tableDnD.currentTable = table;
        jQuery.tableDnD.mouseOffset = jQuery.tableDnD.getMouseOffset(target, evnt);
        jQuery.tableDnD.originalOrder = jQuery.tableDnD.serialize();
        jQuery(document).bind(moveEvent, jQuery.tableDnD.mousemove).bind(endEvent, jQuery.tableDnD.mouseup);
        if (config.onDragStart) {
            config.onDragStart(table, target)
        }
    },
    updateTables: function() {
        this.each(function() {
            if (this.tableDnDConfig) {
                jQuery.tableDnD.makeDraggable(this)
            }
        })
    },
    mouseCoords: function(ev) {
        if (ev.pageX || ev.pageY) {
            return {
                x: ev.pageX,
                y: ev.pageY
            }
        }
        return {
            x: ev.clientX + document.body.scrollLeft - document.body.clientLeft,
            y: ev.clientY + document.body.scrollTop - document.body.clientTop
        }
    },
    getMouseOffset: function(target, ev) {
        ev = ev || window.event;
        var docPos = this.getPosition(target);
        var mousePos = this.mouseCoords(ev);
        return {
            x: mousePos.x - docPos.x,
            y: mousePos.y - docPos.y
        }
    },
    getPosition: function(e) {
        
        var left = 0;
        var top = 0;
        if (e.offsetHeight == 0) {
            e = e.firstChild
        } 
        if(e == 'null' || !e) return false;
        while (e.offsetParent) {
            left += e.offsetLeft;
            top += e.offsetTop;
            e = e.offsetParent
        }
        left += e.offsetLeft;
        top += e.offsetTop;
        return {
            x: left,
            y: top
        }
    },
    mousemove: function(ev) {
        if (jQuery.tableDnD.dragObject == null) {
            return
        }
        if (ev.type == 'touchmove') {
            event.preventDefault()
        }
        var dragObj = jQuery(jQuery.tableDnD.dragObject);
        var config = jQuery.tableDnD.currentTable.tableDnDConfig;
        var mousePos = jQuery.tableDnD.mouseCoords(ev);
        var y = mousePos.y - jQuery.tableDnD.mouseOffset.y;
        var yOffset = window.pageYOffset;
        if (document.all) {
            if (typeof document.compatMode != 'undefined' && document.compatMode != 'BackCompat') {
                yOffset = document.documentElement.scrollTop
            } else if (typeof document.body != 'undefined') {
                yOffset = document.body.scrollTop
            }
        }
        if (mousePos.y - yOffset < config.scrollAmount) {
            window.scrollBy(0, - config.scrollAmount)
        } else {
            var windowHeight = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : document.body.clientHeight;
            if (windowHeight - (mousePos.y - yOffset) < config.scrollAmount) {
                window.scrollBy(0, config.scrollAmount)
            }
        }
        if (y != jQuery.tableDnD.oldY) {
            var movingDown = y > jQuery.tableDnD.oldY;
            jQuery.tableDnD.oldY = y;
            if (config.onDragClass) {
                dragObj.addClass(config.onDragClass)
            } else {
                dragObj.css(config.onDragStyle)
            }
            var currentRow = jQuery.tableDnD.findDropTargetRow(dragObj, y);
            if (currentRow) {
                if (movingDown && jQuery.tableDnD.dragObject != currentRow) {
                    jQuery.tableDnD.dragObject.parentNode.insertBefore(jQuery.tableDnD.dragObject, currentRow.nextSibling)
                } else if (!movingDown && jQuery.tableDnD.dragObject != currentRow) {
                    jQuery.tableDnD.dragObject.parentNode.insertBefore(jQuery.tableDnD.dragObject, currentRow)
                }
            }
        }
        return false
    },
    findDropTargetRow: function(draggedRow, y) {
        var rows = jQuery.tableDnD.currentTable.rows;
        for (var i = 0; i < rows.length; i++) {
            var row = rows[i];
            var rowY = this.getPosition(row).y;
            var rowHeight = parseInt(row.offsetHeight) / 2;
            if (row.offsetHeight == 0) {
                rowY = this.getPosition(row.firstChild).y;
                rowHeight = parseInt(row.firstChild.offsetHeight) / 2
            }
            if ((y > rowY - rowHeight) && (y < (rowY + rowHeight))) {
                if (row == draggedRow) {
                    return null
                }
                var config = jQuery.tableDnD.currentTable.tableDnDConfig;
                if (config.onAllowDrop) {
                    if (config.onAllowDrop(draggedRow, row)) {
                        return row
                    } else {
                        return null
                    }
                } else {
                    var nodrop = jQuery(row).hasClass("nodrop");
                    if (!nodrop) {
                        return row
                    } else {
                        return null
                    }
                }
            }
        }
        return null
    },
    mouseup: function(e) {
        if (jQuery.tableDnD.currentTable && jQuery.tableDnD.dragObject) {
            jQuery(document).unbind(moveEvent, jQuery.tableDnD.mousemove).unbind(endEvent, jQuery.tableDnD.mouseup);
            var droppedRow = jQuery.tableDnD.dragObject;
            var config = jQuery.tableDnD.currentTable.tableDnDConfig;
            if (config.onDragClass) {
                jQuery(droppedRow).removeClass(config.onDragClass)
            } else {
                jQuery(droppedRow).css(config.onDropStyle)
            }
            jQuery.tableDnD.dragObject = null;
            var newOrder = jQuery.tableDnD.serialize();
            if (config.onDrop && (jQuery.tableDnD.originalOrder != newOrder)) {
                config.onDrop(jQuery.tableDnD.currentTable, droppedRow)
            }
            jQuery.tableDnD.currentTable = null
        }
    },
    serialize: function() {
        if (jQuery.tableDnD.currentTable) {
            return jQuery.tableDnD.serializeTable(jQuery.tableDnD.currentTable)
        } else {
            return "Error: No Table id set, you need to set an id on your table and every row"
        }
    },
    serializeTable: function(table) {
        var result = "";
        var tableId = table.id;
        var rows = table.rows;
        for (var i = 0; i < rows.length; i++) {
            if (result.length > 0) result += "&";
            var rowId = rows[i].id;
            if (rowId && rowId && table.tableDnDConfig && table.tableDnDConfig.serializeRegexp) {
                rowId = rowId.match(table.tableDnDConfig.serializeRegexp)[0]
            }
            result += tableId + '[]=' + rowId
        }
        return result
    },
    serializeTables: function() {
        var result = "";
        this.each(function() {
            result += jQuery.tableDnD.serializeTable(this)
        });
        return result
    }
};
jQuery.fn.extend({
    tableDnD: jQuery.tableDnD.build,
    tableDnDUpdate: jQuery.tableDnD.updateTables,
    tableDnDSerialize: jQuery.tableDnD.serializeTables
}); 

 

function makeDragsort()
{
    if(!$('.jSortTable').length) return false;
    

    $('.jSortTable').tableDnD({
        onDragClass: 'tr-whendrag',
        dragHandle:'.js-dragsMove *',
        onDrop: function(table, row) {
            let rows = table.tBodies[0].rows;
            let _tableName    = table.getAttribute('data-modules');

            let debugStr = translator.getStr('MovedIt')+": " +_tableName+' '+ $(row).attr('rowlabel');
            let _id      = $(row).attr('id'); 
            let IDs = ""; 
            for (let i = 0; i < rows.length; i++)
            {
                IDs += rows[i].id+',';   
            }

            table_synStt($(row).closest('.jTable'));

             let   _actionlink    = table.getAttribute('data-actionlink');
            
            if(_actionlink){
                $.ajax({
                      /*url: site_url + 'RockerAjax/RjxEd_SortOrder',*/
                      url: site_url +_actionlink+'/Edit_SortOrder',
                      type: 'GET',
                      cache: false, 
                      async: false,
                      data: {
                          IDs: IDs, 
                      },
                      beforeSend: function(e) {  
                          dtl_Loading();
                      },
                      complete: function() {
                          dtl_Loaded(); 
                      },
                      success: function(resp) {   
                           
                      },
                      error: function(xhr, ajaxOptions, thrownError) { 
                          ErrorXhr(xhr, ajaxOptions, thrownError);
                           
                      } 
                });
            }
              
            
        }
    });
}


(function($) {

    $.fn.fixedHeader = function(options) {
        var config = {
            topOffset: 119
        };
        if (options) {
            $.extend(config, options);
        }
        return this.each(function() {
            var o = $(this);
            var $win = $(window),
                $head = $('thead:first-child', o),
                isFixed = 0,
                $parent = $('.jRockerTableShow');
            var headTop = $head.length && $head.offset().top - config.topOffset+170;

            function processScroll() {
                if (!o.is(':visible')) return;
                
                if (o.find('thead.HeaderCopy').length) {
                    o.find('thead.HeaderCopy').width($head.width());
                    var i, scrollTop = $win.scrollTop();
                }
                var t = $head.length && $head.offset().top - config.topOffset+170;
                if (!isFixed && headTop != t) {
                    headTop = t;
                }
 
                
                if (scrollTop >= headTop && !isFixed) {
                    isFixed = 1;
                } else if (scrollTop <= headTop && isFixed) {
                    isFixed = 0;
                }
          
                isFixed ? o.find('thead.HeaderCopy', o).show().offset({
                    left: $head.offset().left
                }).addClass('isFixed') : $('thead.HeaderCopy', o).hide(); 
         
                headerCopyRectify();
            }
            function labelCopyRectify(){
                /*create label for mobile*/
                o.addClass('block-mobile');
                /*o.find('tbody  tr >').each(function(v,tr){
                    o.find('thead:first-child > tr > th').each(function(i, h) {
                        var lbl   = $(h).text();
                        var td    = o.find('tbody  tr:eq('+v+') td:eq(' + i + ')');
                        var tdtxt = '<div class="block-content">'+td.html()+'</div>';  
                        if(!td.attr('colspan'))
                        td.empty().append('<div class="block-lbl">'+lbl+'</div>'+tdtxt);
                        
                    });
                });*/
                
            }
            function headerCopyRectify() {
                o.find('thead:first-child > tr > th').each(function(i, h) {
                    var w = $(h).width();
                    o.find('thead.HeaderCopy> tr > th:eq(' + i + ')').width(w)
                });
            }
            $parent.on('scroll', processScroll);
            $win.on('scroll', processScroll);
            $win.on('resize', processScroll);
            $head.on('click', function() {
                if (!isFixed) setTimeout(function() {
                    $win.scrollTop($win.scrollTop() - 57)
                }, 10);
            });
            if(!$('.HeaderCopy.HeaderFixed').length){
                $head.clone(true).removeClass('fixh nodrop').addClass('HeaderCopy HeaderFixed').css({
                    'position': 'fixed',
                    'top': config['topOffset'], 
                }).appendTo(o);
            } 
            
            o.find('thead.HeaderCopy').width($head.width());
            headerCopyRectify();
            var mobile = o.attr('no-mobile');
           
            if(!mobile)labelCopyRectify();
            $head.css({
                margin: '0 auto',
                width: o.width(),
                /*'background-color': config.bgColor*/
            });
            processScroll();
        });
    };
})(jQuery);



/*Table js*/
$(document).on('click','.jrowSwitch',function(){
    const _Parent = $(this).closest('.jSwitchParent');
    const _Table = $(this).closest('.jTable, .jGetInfo'); 

    const _Tr = _Table.hasClass('jGetInfo') ? $(this).closest('.jItems') : $(this).closest('.jTr, .jItems');
    const _id = _Tr.data('id');
    const _i = $(this).find('i');
    const _Field = $(this).data('field');
    const _ActionLink = _Table.data('actionlink');
    const _Val = _Parent.hasClass('active') ? 0 : 1;
    const _Success = dtl_ChangeField(_ActionLink, _Field, _Val, _id);

    if (_Success) {
        if (_Val === 0) {
            _i.attr('class', _Parent.attr('iOff'));
            _Parent.removeClass('active');
            _Tr.addClass('TurnOff'); 
        } else {
            _i.attr('class', _Parent.attr('iOn'));
            _Parent.addClass('active');
            _Tr.removeClass('TurnOff'); 
        }
    } 
}).on('click','.jTools-Delete',function(){ 
    const _Table = $(this).closest('.jTable, .jGetInfo');
    const _Tr = $(this).closest('.jTr, .jItems');

    if (!_Table.length && $(this).closest('.jGetInfo').length > 0) {
        const _trList = _Tr.find('.jdd-list').find('.jItems');
        if (_trList.length > 0) {
            _Tr.find('.jdd-list').addClass('AniLeftRight');
            setTimeout(function() {
                _Tr.find('.jdd-list').removeClass('AniLeftRight');
            }, 2000); 
            const _TitleMes = translator.getStr('IsNotAllowedAction', translator.getStr('Delete'));
            const _DetaMes = translator.getStr('BecauseExistsChildLevel');
            RockerMessage('Error', _TitleMes, _DetaMes);
            return false;
        }
    }

    const _id = _Tr.data('id');
    const _ActionLink = _Table.data('actionlink');
    const _Success = dtl_Delete(_ActionLink, _id);

    if (_Success) {
        _Tr.removeClass('jTr');
        _Tr.css({ 'opacity': '1', 'position': 'fixed', 'z-index': '100' }).animate( { top: $('.jTrash').find("i").offset().top-20, left: $('.jTrash').find("i").offset().left+20, opacity:1, width:10, height:10, filter:"blur(10px)" }, 1000, function() { });
        setTimeout(function(){
            _Tr.remove();
            $('.js-numberTrash').text(parseInt($('.js-numberTrash').text())+1);
        }, 1000);
        table_synStt(_Table);
    } 


}).on('click','.jEmptyTrash',function(){ 
    const $table = $('.jTable, .jGetInfo').first();
    const actionLink = $table.data('actionlink');

    $.confirm({
      title: translator.getStr('EmptyTrashCofirm'),
      content: translator.getStr('EmptyTrashCofirmContent'),
      icon: 'fad fa-question-circle',
      theme: 'supervan',
      closeIcon: false, 
      buttons: {
        ok: {
          text: translator.getStr('Delete'),
          action: function() {
            const success = dtl_EmptyTrash(actionLink);
            if (success) {
              $table.find('.jTr').remove();
            }
          }
        },
        cancle: {
          text: translator.getStr('Cancle'),
          action: function() {
            // Do nothing
          }
        }
      } 
    });

    return false;


}).on('click','.jTools-DeleteForever',function(){ 
  const _Table = $(this).closest('.jTable, .jGetInfo');
  const _Tr = $(this).closest('.jTr, .jItems');
   

  let _id      = _Tr.data('id');
  let _ActionLink = _Table.data('actionlink');
  let _rowlabel = _Tr.attr('rowlabel');

  $.confirm({
      title: translator.getStr('DeleteCofirm',_rowlabel),
      content: (_rowlabel)?translator.getStr('DeleteCofirmContent',_rowlabel):'',
      icon: 'fad fa-question-circle',
      theme: 'supervan',
      closeIcon: false, 
      buttons: {
          ok: {
              text: translator.getStr('Delete'),
              action: function () { 

                let _Success = dtl_Delete(_ActionLink,_id,2);
                if(_Success){  
                  _Tr.remove();
                  table_synStt(_Table);
                }
              }
          },
          cancle: {
              text: translator.getStr('Cancle'),
              action: function () { 
                 
              }
          }
           
      } 
  });


}).on('click','.jPinToTop',function(){ 
  const _Table = $(this).closest('.jTable, .jGetInfo');
  const _Tr = $(this).closest('.jTr, .jItems');

  let _id      = _Tr.data('id');
  let _ActionLink = _Table.data('actionlink');
  let _rowlabel = _Tr.attr('rowlabel');

  $.confirm({
      title: translator.getStr('ToTopConfirm',_rowlabel),
      content: (_rowlabel)?translator.getStr('ToTopConfirmContent',_rowlabel):'',
      icon: 'fad fa-question-circle',
      theme: 'supervan',
      closeIcon: false, 
      buttons: {
          ok: {
              text: translator.getStr('Move'),
              action: function () { 

                let _Success = dtl_PinToTop(_ActionLink,_id);
                if(_Success){  
                  _decl = false;
                  let url = location.href;
                  url = hp_removeParam("t",url);
                  url = hp_removeParam("page",url);  


                  if($('.js-Tab-nav-items.active').length){
                      let _CurCat = $('.js-Tab-nav-items.active').attr('setvalue');
                      url = hp_removeParam("page_Group"+_CurCat,url);  
                  }  
                  hp_ToLink(url);
                }
              }
          },
          cancle: {
              text: translator.getStr('Cancle'),
              action: function () { 
                 
              }
          }
           
      } 
  });


}).on('click','.jTools-PutBack',function(){ 
  const _Table = $(this).closest('.jTable, .jGetInfo');
  const _Tr = $(this).closest('.jTr, .jItems');

  let _id      = _Tr.data('id');
  let _ActionLink = _Table.data('actionlink');
  let _rowlabel = _Tr.attr('rowlabel');

  $.confirm({
      title: translator.getStr('PutBackCofirm',''),
      content: (_rowlabel)?_rowlabel:'',
      icon: 'fad fa-question-circle',
      theme: 'supervan',
      closeIcon: false, 
      buttons: {
          ok: {
              text: translator.getStr('PutBack'),
              action: function () { 

                let _Success = dtl_Delete(_ActionLink,_id,1);
                if(_Success){  
                  _Tr.remove();
                  table_synStt(_Table);
                }
              }
          },
          cancle: {
              text: translator.getStr('Cancle'),
              action: function () { 
                 
              }
          }
           
      } 
  }); 
  return false;


}).on('click','.jRockerTableShow tr',function(){
  
  if(!$(this).hasClass('Choose')){
    $('.jRockerTableShow tr').removeClass('Choose');
    $(this).addClass('Choose');
  }else{
    $(this).removeClass('Choose');
  }
}).on('click','.jPaging .jPageTotalDropDown',function(){
  
   $(this).toggleClass('ShowDropDown');
}).on('mouseup',function(e) 
{
  let container = $('.jRockerTableShow'); 
  if (!container.is(e.target) && container.has(e.target).length === 0) 
  {
    container.find('tr.Choose').removeClass('Choose');
  }

  let ct = $('.jPaging .jPageTotalDropDown'); 
  if (!ct.is(e.target) && ct.has(e.target).length === 0) 
  {
    ct.removeClass('ShowDropDown');
  }
})
/* Edit by Chau*/
.on('click','.jsTableSort',function(){
    $('.TableSort').toggleClass('active');
})
.on('click', 'input[name="sort-radio"]', function() {
    const params = new URLSearchParams(window.location.search);
    const sortValue = $(this).data('name');
    const sortType = $(this).val();
    updateUrlAndHistory(params, sortValue, sortType);
    $('.TableSort').toggleClass('active');
    dtl_Loading();
})
.on('click', '.jsDefault', function() {
    const params = new URLSearchParams(window.location.search);
    params.delete('Sort');
    params.delete('SortType');
    updateUrlAndHistory(params);
})
.on('click', 'i.js-Sort', function() {
    const params = new URLSearchParams(window.location.search);
    const parent = $(this).closest('th');
    const sortValue = parent.data('sort');
    let sortType = parent.data('sorttype') === 'ASC' ? 'DESC' : 'ASC';
    updateUrlAndHistory(params, sortValue, sortType);
});
function updateUrlAndHistory(params, sortValue, sortType) {
    params.delete('t');
    if (sortValue) {
        params.set('Sort', sortValue);
    }
    if (sortType) {
        params.set('SortType', sortType);
    }
    const url = new URL(window.location.href);
    url.search = params.toString();
    const href = decodeURIComponent(url.toString());
    const time = new Date().getTime();
    History.pushState(null, document.title, `${href}${href.includes('?') ? '&' : '?'}t=${time}`);
}
/* End Edit by Chau*/
;


function table_synStt(_Table){
    var _countrow = _Table.find('.jTr');
    var _i = 1;
    _countrow.each(function(){  
            $(this).find('.jSTT').html(_i); 
            _i++;   
    });
}
/*ed Table js*/
/*ed table*/

/*jLa*/
$(document).on('click','.jLaLinkPopup',function(){
    var _Link   = $(this).attr('href'); 

    var _Class = $(this).attr('popup-class');
     _Class  = (_Class)?_Class:_Link.replace(/[^a-zA-Z0-9]/g, '');

    var _Html = dtl_GetAniHtml(_Link);
    CallRockerPopup('Popup-'+_Class,_Html);
    return false; 
}).on('click','[popup-viewlink]',function(){
    var _ViewLink   = $(this).attr('popup-viewlink'); 
    var _Link = './RockerAjax/NoRequired_PopupByViewLink';

    var _Class = $(this).attr('popup-class');
     _Class  = (_Class)?_Class:_Link.replace(/[^a-zA-Z0-9]/g, '');

    var _Html = dtl_GetAniHtml(_Link,{ViewLink:_ViewLink});
    CallRockerPopup('Popup-'+_Class,_Html);
    return false; 
});
/*ed jLa*/ 

/*Popup*/ 


/*if link use a href add class jLaLinkPopup -> to callpopup*/
function CallRockerPopup(_classtarget,_Content){ 
    /*Call BodyShield before settime out 50, CallRockerPopup*/  
    if(!_Content) return false;

    $('body').addClass('BodyShowPopup');
    BodyShield();
 
    setTimeout(function(){

        if(!$('.j'+_classtarget).length){
            let _Html = '<div class="RockerPopup jRockerPopup j'+_classtarget+' '+_classtarget+'"> <div class="Content"> <span class="Close jClose jESC"><i class="fal fa-times"></i></span> <div class="jLct">'+_Content+'</div> </div> </div>';
            $('body').append(_Html);
        }else if(_Content){
          $('.j'+_classtarget).find('.jLct').empty().append(_Content);
        }
        setTimeout(function(){$('.j'+_classtarget).addClass('active');},50); 
        hp_InitEx();
    },50);
    
} 
function BodyShield(_turnon = true){ 
    if(_turnon){
        $('body').addClass('ShowShield');
    }else{
        $('body').removeClass('ShowShield');
    }
} 
$(document).on('click','.jAddPopup',function(){
      let _href = $(this).attr('href');
      let _gettabcat = $(this).attr('gettabcat');

      let _ActionLink = $(this).data('actionlink');
      /*let _Modules = $(this).data('modules');*/

      let _ClassPopupPrefix = $(this).data('prefixpopup');
      _ClassPopupPrefix = (_ClassPopupPrefix)?_ClassPopupPrefix:_ActionLink;
 

      if(_gettabcat){
          let _paramvalue = $('.js-Tab-nav-items.active').attr('setvalue');
          _href = hp_replaceParam(_gettabcat,_paramvalue,_href);
      } 
       
      Html = dtl_GetAniHtml(_href); 
      if(Html){ 
        CallRockerPopup('PopupAdd-'+_ClassPopupPrefix,Html);  
      } 

    return false;
});
/*ed Popup*/

$(document).on('click','.jCallImportPage',function(){ 
      let _href         = $(this).attr('href'),
      _time             = new Date().getTime();   
      let _ActionLink   = $(this).data('actionlink');
      let _ClassPopupPrefix = $(this).data('prefixpopup');
      _ClassPopupPrefix = (_ClassPopupPrefix)?_ClassPopupPrefix:_ActionLink; 
       
      var _Rsp      = dtl_CallAjax(_href,{FromJs:true}); 
      var _IsPopup  =_Rsp?.Data?.IsPopup;

      if(_IsPopup){
         CallRockerPopup('PopupAdd-'+_ClassPopupPrefix,_Rsp?.Data?.Html);  
      }else{  
          History.pushState(null, document.title, _href + (_href.indexOf('?') != -1 ? '&' : '?') + 't=' + _time); 
      }

    return false;
});

$(document).on('click','.js-Tab-nav-items',function(){
  /*AdminTemplate Tab*/
    let _parent = $(this).closest('.js-Tab');
    let _value = $(this).attr('setvalue'); 
    let _paramName = _parent.attr('paramName');
    let _target = $('#js-Tab-contents-'+_paramName+'-' + _value);
    let _numberDeleted = $(this).attr('settrash');

    _parent.find('.Tab-content-items.active').removeClass('active');
    _parent.find('.js-Tab-nav-items.active').removeClass('active');
    _target.addClass('active'); 
 
    $(this).addClass('active'); 
    hp_editParam(_paramName, _value);
    hp_numberTrash(_numberDeleted);  
    setTimeout(function(){
        _parent.find('.jHtmlTabValue').val(_value).trigger('change');
    },50);
    return false;
 }).on('click','.jRockerPopup .jClose',function(){
  /*popup*/ 
    $(this).closest('.jRockerPopup').removeClass('active');
    $('body').removeClass('BodyShowPopup');
    BodyShield(false);
    return false;
}).on('click','.js-LgTab-nav-items',function(){
  /*AdminTemplate LgTab*/
    let _parent = $(this).closest('.js-LgTab');
    let _value = $(this).attr('setvalue'); 
    let _paramName = _parent.attr('paramName');
    let _target = _parent.find('.js-LgTab-contents-'+_paramName+'-' + _value);
  

    _parent.find('.LgTab-content-items.active').removeClass('active');
    _parent.find('.js-LgTab-nav-items.active').removeClass('active');
    _target.addClass('active'); 
    $(this).addClass('active'); 
    hp_editParam(_paramName, _value); 
    return false;
 });

/*bg for Other Tool*/
$(document).on('click', '.jAll-ShowQRCodeSingle', function (e) {
    e.preventDefault();
    const _Msg = $(this).data('msg'); 
    const _TitleName = $(this).data('title-name');
    if(!_Msg){
        RockerMessage('Error','Lỗi Link','Không tìm thấy Link In');
        return false;
    }
    hp_importcss('./refer/ast/ex/qr-code/qrcode.css?v='+_versions);
    hp_importjs('./refer/ast/ex/qr-code/scriptqr.js?v='+_versions);
    hp_importjs('./refer/ast/ex/qr-code/qrcodesvg.min.js?v='+_versions);
    hp_importjs('./refer/ast/ex/canvas/html2canvas.min.js?v='+_versions);    
    hp_importjs('./refer/ast/ex/jsPDF/jspdf.umd.min.js?v='+_versions);   

    const _id = $(this).data('id');
    const _Data = { Msg: _Msg,TitleName:_TitleName};
    const _resp = dtl_CallAjax('RockerAjax/NoRequired_PopupShowPopupQRCodeSingle',_Data,"POST");
    const _Html = _resp?.Data.Html;  
    CallRockerPopup('PopupPrintQRCodeSingle', _Html);  
    
});
/*bg for Other Tool*/

/*bg BeforeGen*/
 $(document).on('click', '.jBeforeGen', function() { 
    let _ActionLink = $(this).data('actionlink');
    let _Modules = $(this).data('modules');
    let _Link = _ActionLink + '/BeforeGenerate';
    let _gettabcat = $(this).attr('gettabcat');
    if(_gettabcat){
          let _paramvalue = $('.js-Tab-nav-items.active').attr('setvalue'); 
          _Link = hp_replaceParam(_gettabcat,_paramvalue,_Link); 
    } 

    var _DataParam = {};


    if($(this).hasClass('ForAddSub')){ 
        _Link = hp_replaceParam('Parent',$(this).data('id'),_Link); 
        console.log($(this).data('id'));
    }

    Html = dtl_GetAniHtml(_Link);
    if(Html){
       CallRockerPopup('BeforeGen-' + _Modules, Html);
      
    } 
    return false;
}).on('click', '.jSubmitGen', function() {
    $(this).closest('.jLct').find('.jFormGen').submit();
});
/*ed BeforeGen*/

/*BG FOR All localStorage*/
$(document).ready(function() { 
    var currentDate = new Date().toLocaleDateString(); 
    var storedDate = localStorage.getItem('storedDate'); 
    if (!storedDate || storedDate !== currentDate) { 
         for (var key in localStorage) {
            if (key.startsWith('SlideModeSeen-')) {
                localStorage.removeItem(key);
            }
        }
        localStorage.setItem('storedDate', currentDate);
    } 
});
/*ED FOR All localStorage*/

/*bg For Ele-ReactionsViewContent*/
$(document).on('click','.jEle-ReactionsViewContent .jiViews',function(){
    const _Parent   = $(this).closest('.jEle-ReactionsViewContent');
    const _tb       = _Parent.data('tb');
    const _id       = _Parent.data('id');

    var _html = dtl_GetAniHtml('RockerAjax/NoRequired_ReactionsViewContentListPopup',{Table:_tb,TableId:_id});
    if (_html) {  
        CallRockerPopup('ShowListReactionViewContent', _html);  
    }
});
/*ed For Ele-ReactionsViewContent*/

/*bg For Ele-ReactionsContent*/
$(document).on('click','.jEle-ReactionsContent .jiBoxReaction .jeItemsEmoj',function(){
    const _Parent = $(this).closest('.jEle-ReactionsContent');
    var _Key = $(this).data('key'); 

    if(_Parent.find('.jrBtn.Reacted').find('.jeItemsEmoj[data-key="'+_Key+'"]').length){
        _Parent.find('.jEle-ReactionsContent.IsShowReact').removeClass('IsShowReact'); 
        return false;
    }
    var _EmojiType = $(this).data('type');
    const _Rsp = ReactionsContent_Transfer(_Parent,1,_EmojiType);

    if(_Rsp?.Status==200){ 
        let _html = $(this).outerHTML();  
        _Parent.find('.jrBtn').find('.jeItemsEmoj').remove();
        _Parent.find('.jrBtn').addClass('Reacted').append(_html);

        const _EmojiElement = _Parent.find('.irEmojis').find('.eItemsEmoj[data-type="'+_Key+'"]');
        if(!_EmojiElement.length){
            const _Type = '<div class="eItemsEmoj e'+_Key+' jeItemsEmoj" data-type="'+_EmojiType+'" data-key="'+_Key+'"></div>';
            _Parent.find('.irEmojis').append(_Type);
        }
    } 
    $('.jEle-ReactionsContent.IsShowReact').removeClass('IsShowReact');



}).on('click','.jEle-ReactionsContent .jrBtn',function(){
    const _Parent = $(this).closest('.jEle-ReactionsContent');

    if($(this).hasClass('Reacted')){
        var _EmojiType = $(this).find('.jeItemsEmoj').data('type');
        const _Rsp = ReactionsContent_Transfer(_Parent,2,_EmojiType);

        $(this).find('.jeItemsEmoj').remove();
        $(this).removeClass('Reacted'); 
    }else{
        $('.jEle-ReactionsContent.IsShowReact').removeClass('IsShowReact');
        _Parent.addClass('IsShowReact');
    }
    
}).on('click', function (event) {
    if (!$(event.target).closest('.jEle-ReactionsContent').length) {
        $('.jEle-ReactionsContent.IsShowReact').removeClass('IsShowReact');
    }
}).on('click','.jEle-ReactionsContent .jirTextCount.active',function(){
    const _Parent   = $(this).closest('.jEle-ReactionsContent');
    const _tb       = _Parent.data('tb');
    const _id       = _Parent.data('id');

    var _html = dtl_GetAniHtml('RockerAjax/NoRequired_ReactionsContentListPopup',{Table:_tb,TableId:_id});
    if (_html) {  
        CallRockerPopup('ShowListReactionContent', _html);  
    }
}).on('click','.jEle-ReactionTabPanel .jcTab',function(){
    console.log('z')
    var _target = $(this).data('target');
    const _Parent = $(this).closest('.jEle-ReactionTabPanel');
    const _Target =  _Parent.find('.'+_target); 
    if(!_Target.hasClass('active')){
        _Parent.find('.jItemsTab.active').removeClass('active');
        _Target.addClass('active');
    }
});


function ReactionsContent_Transfer(_ReactionsContentItem,UpDown=1,EmojiType){
    /*UpDown = 1 -> Up; UpDown =2 Down*/
    const _tb    = _ReactionsContentItem.data('tb');
    const _id    = _ReactionsContentItem.data('id');

    var _Rsp = dtl_CallAjax('RockerAjax/NoRequired_ReactionsContent',{Table:_tb,TableId:_id,UpDown:UpDown,EmojiType:EmojiType});
    let _CountTotal = _Rsp?.Data?.ReactionsContentTotal;
    _ReactionsContentItem.find('.jirNumber').text(_CountTotal);
    if(_CountTotal>0){
        _ReactionsContentItem.find('.irTextCount').addClass('active');
    }else{
        _ReactionsContentItem.find('.irTextCount').removeClass('active');
    }
    return _Rsp;

}

$(window).on('scroll',function(){
    $('.jEle-ReactionsContent.IsShowReact').removeClass('IsShowReact');
})
/*ed For Ele-ReactionsContent*/



 


