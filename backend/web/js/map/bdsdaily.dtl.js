var GlobalBackLink = '';

var startTimeMicro;
var timerInterval;

$(window).bind('statechange', function() { 
    _decl = true;   
    var _statechangeData = false; 
    if(typeof _BeforeState !=='undefined'){
        _statechangeData = window[_BeforeState](); 
    }  
    $.ajax({
        url: window.location,
        type: 'GET',
        data: _statechangeData,
        async: true,
        cache: true,
        contentType: false,
        processData: (_statechangeData)?true:false,
        beforeSend: function(e) { 
            $('.activeout').removeClass('activeout');
            dtl_Loading();
            if($('.jCountTimeLoad29').length){
                startTimeMicro = performance.now();  
                timerInterval = setInterval(CountLoad_updateTimer, 10);  
            } 
        },
        complete: function() {
            dtl_Loaded(); 
            _decl = false; 
        },
        success: function(resp) { 
        	let Mss = resp.statusText;   
            if($('#tooltip').length)$('#tooltip').remove();
          
            $('.QQR5').empty().append(resp.Data.Html); 
          
            if(typeof resp.Title !='undefined'){
                document.title = resp.Title;
            }
            $('body').removeClass('BodyExpands');
            if($('.jCountTimeLoad29').length){
                clearInterval(timerInterval);
                var currentTimeMicro = performance.now();
                var elapsedTimeMicro = CountLoad_formatMicroTime(currentTimeMicro - startTimeMicro);
                $('.jCountTimeLoad29').text(elapsedTimeMicro);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
        	ErrorXhr(xhr, ajaxOptions, thrownError,true); 
        }
    });
});

function CountLoad_updateTimer() {
    var currentTimeMicro = performance.now();
    var elapsedTimeMicro = CountLoad_formatMicroTime(currentTimeMicro - startTimeMicro);
    $('.jTimeCount').text(elapsedTimeMicro);
}
function CountLoad_formatMicroTime(milliseconds) { 
    var seconds = Math.floor((milliseconds % 60000) / 1000);
    var micros = Math.floor(milliseconds % 1000);
    return  CountLoad_pad(seconds) + " : " + CountLoad_padMicros(micros);
}

function CountLoad_pad(num) {
    return (num < 10 ? '0' : '') + num;
}

function CountLoad_padMicros(num) {
    var microsStr = num.toString();
    while (microsStr.length < 6) {
        microsStr = '0' + microsStr;
    }
    return microsStr;
}


function dtl_GetAniHtml(_Link,_addData=false,_async = false){
    var Html = ''; 
 
    var _data = {}; 
    _data[ctk]      = cth; 
    if(_addData){ 
        var mergedArray = Object.assign({}, _data, _addData);
        _data = mergedArray;
    } 
 

    $.ajax({
        url: site_url+_Link,
        type: 'GET',
        data: _data,  
        cache: false, 
        async: _async,
        beforeSend: function(e) {  
            dtl_Loading();
        },
        complete: function() {
            dtl_Loaded(); 
        },
        success: function(resp) {      
            if(resp?.Data?.Html){
                Html = resp.Data.Html; 
            }
        },
        error: function(xhr, ajaxOptions, thrownError) { 
            ErrorXhr(xhr, ajaxOptions, thrownError);
             
        } 
    });
    return Html;
}

function dtl_CallAjax(_Link,_addData=false,_Method = "GET",_async = false){
    var Html = '';

 
    var _data = {}; 
    _data[ctk]      = cth; 
    if(_addData){ 
        var mergedArray = Object.assign({}, _data, _addData);
        _data = mergedArray;
    } 
    var _Rsp = ''; 
    $.ajax({
        url: site_url+_Link,
        type: _Method,
        data: _data,  
        cache: false, 
        async: _async,
        beforeSend: function(e) {  
            dtl_Loading(); 
        },
        complete: function() {
            dtl_Loaded(); 
        },
        success: function(resp) {  
            _Rsp =  resp; 
        },
        error: function(xhr, ajaxOptions, thrownError) { 
            ErrorXhr(xhr, ajaxOptions, thrownError);
             
        } 
    });
    return _Rsp;
}


function dtl_SortCategories(_ActionLink,dataSort){
 
    var Success = false;

    var _data = {'dataSort':dataSort}; 
    _data[ctk]      = cth;  
 
    $.ajax({
        url: site_url+_ActionLink+'/Edit_SortCategories',
        type: 'POST',
        data: _data,  
        cache: false, 
        async: false,
        beforeSend: function(e) {  
            
        },
        complete: function() {
           
        },
        success: function(resp) {     
            Success = true; 
        },
        error: function(xhr, ajaxOptions, thrownError) { 
            ErrorXhr(xhr, ajaxOptions, thrownError);
             
        } 
    });
    return Success;
}
function dtl_Delete(_ActionLink,_id,_Flags=0){
    var Success = false;

    var _data = {'id':_id,'Flags':_Flags}; 
    _data[ctk]      = cth;   
    $.ajax({
        url: site_url+_ActionLink+'/DeleteItem',
        type: 'POST',
        data: _data,  
        cache: false, 
        async: false,
        beforeSend: function(e) {  
            dtl_Loading();
        },
        complete: function() {
            dtl_Loaded(); 
        },
        success: function(resp) {     
            Success = true;
           
            if(typeof resp.RespondRocker !== 'undefined'){
                var DetailsMessage  = resp.DetailsMessage,
                    Message         = resp.Message;
                    if(DetailsMessage) RockerMessage('Success',Message,DetailsMessage);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) { 
            ErrorXhr(xhr, ajaxOptions, thrownError);
             
        } 
    });
    return Success;
}
function dtl_EmptyTrash(_ActionLink){
    var Success = false;

    var _data = {}; 
    _data[ctk]      = cth;  
 
    $.ajax({
        url: site_url+_ActionLink+'/EmptyTrash',
        type: 'POST',
        data: _data,  
        cache: false, 
        async: false,
        beforeSend: function(e) {  
            dtl_Loading();
        },
        complete: function() {
            dtl_Loaded(); 
        },
        success: function(resp) {     
            Success = true;
           
            if(typeof resp.RespondRocker !== 'undefined'){
                var DetailsMessage  = resp.DetailsMessage,
                    Message         = resp.Message;
                    if(DetailsMessage) RockerMessage('Success',Message,DetailsMessage);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) { 
            ErrorXhr(xhr, ajaxOptions, thrownError);
             
        } 
    });
    return Success;
}
function dtl_PinToTop(_ActionLink,_id){
    var Success = false;

    var _data = {'id':_id}; 
    _data[ctk]      = cth;  
 
    $.ajax({
        url: site_url+_ActionLink+'/PinToTop',
        type: 'POST',
        data: _data,  
        cache: false, 
        async: false,
        beforeSend: function(e) {  
            dtl_Loading();
        },
        complete: function() {
            dtl_Loaded(); 
        },
        success: function(resp) {     
            Success = true;
           
            if(typeof resp.RespondRocker !== 'undefined'){
                var DetailsMessage  = resp.DetailsMessage,
                    Message         = resp.Message;
                    if(DetailsMessage) RockerMessage('Success',Message,DetailsMessage);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) { 
            ErrorXhr(xhr, ajaxOptions, thrownError);
             
        } 
    });
    return Success;
}
function dtl_ChangeField(_ActionLink,_Field,_Value,_id){
    var Success = false;

    var _data = {'Field':_Field,'Value':_Value,'id':_id}; 
    _data[ctk]      = cth;  
 
    $.ajax({
        url: site_url+_ActionLink+'/EditField',
        type: 'POST',
        data: _data,  
        cache: false, 
        async: false,
        beforeSend: function(e) {  
            dtl_Loading();
        },
        complete: function() {
            dtl_Loaded(); 
        },
        success: function(resp) {     
            Success = true;
           
            if(typeof resp.RespondRocker !== 'undefined'){
                var DetailsMessage  = resp.DetailsMessage,
                    Message         = resp.Message;
                    if(DetailsMessage) RockerMessage('Success',Message,DetailsMessage);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) { 
            ErrorXhr(xhr, ajaxOptions, thrownError);
             
        } 
    });
    return Success;
}
function ErrorXhr(xhr, ajaxOptions, thrownError,_emptyPage = false){
    dtl_endProcess(); 
    
    let responseText = xhr.responseText; 
    
    

    let _status = xhr.status,
        _rJ     = xhr.responseJSON; 
    var _TitleMes = xhr.statusText,
        _DetaMes  = '',
        _LineEr   = '',
        _FileEr   = '',
        _HtmlPage = '',
        _View_SlideModeHtml='';
    
    var _ConfirmLink = _rJ?.Data?.ConfirmLink;
    if(_ConfirmLink){

      $.confirm({
          title: translator.getStr('Exist'),
          content: translator.getStr('ItemExist',_rJ.DetailsMessage),
          icon: 'lar la-question-circle',
          theme: 'supervan',
          closeIcon: false, 
          buttons: {
              ok: {
                  text: translator.getStr('ItemViewDetail',' '),
                  action: function () {
                      hp_ToLink(_ConfirmLink)
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
    }

    if(xhr.responseJSON && typeof _rJ.RespondRocker !== 'undefined' ){
        if(typeof _rJ.Data.SystemError !=='undefined'){
            /*system Error*/
            let _Da = _rJ.Data.SystemError;

            _FileEr = _Da.file;
            _LineEr     = _Da.line;
            _DetaMes    = _Da.message;
            _FileEr += (_LineEr)?' <b>#'+_LineEr:'</b>';
        }else{
            /*control Error*/ 
            _DetaMes = _rJ.DetailsMessage;

            _FileEr  = _rJ?.CodeFile;
            _LineEr  = _rJ?.CodeLine;
            
            _FileEr += (_LineEr)?' <b>#'+_LineEr:'</b>';

            if(_rJ?.Data?.Html){
                _HtmlPage = _rJ.Data.Html;
            }
        

            _View_SlideModeHtml = _rJ?.Data?.View_SlideModeHtml;
     
        } 
    }else if(_rJ){ 
        /*system Error*/
        _FileEr = _rJ.file;
        _LineEr     = _rJ.line;
        _DetaMes    = _rJ.message;
        _FileEr += (_LineEr)?' <b>#'+_LineEr:'</b>'; 
    }else{
        /*Non Format Json*/
        /*var _json = responseText.substr(responseText.indexOf('{'), responseText.lastIndexOf('}'));*/
        try{
            var _json = responseText.substr(responseText.indexOf('{'));
            if(_json){ 
                _json = JSON.parse(_json); 
                 /*system Error*/
                _FileEr = _json.file;
                _LineEr     = _json.line;
                _DetaMes    = _json.message;
                _FileEr += (_LineEr)?' <b>#'+_LineEr:'</b>'; 
            }  
        }catch (error) {
            RockerMessage('Error','Connect Error',error);
            _decl = false;
        }
        
    } 
    if(_View_SlideModeHtml){
        $('.jSlideModeArea').find('.jSMA-Content').empty().append(_View_SlideModeHtml);
    }


    if(_HtmlPage){
        $('.QQR5').empty().append(_HtmlPage);
    }else if(_emptyPage){ 
        _FileEr = (_FileEr)?_FileEr.replace('.php','.rocker'):_FileEr;
        RockerMessage('Error',_TitleMes,_DetaMes,_FileEr);
        $('.QQR5').empty();
    }else{
        _FileEr = (_FileEr)?_FileEr.replace('.php','.rocker'):_FileEr;
        RockerMessage('Error',_TitleMes,_DetaMes,_FileEr);
    } 

    if(_status==401){
        setTimeout(function(){location.reload();},3000);
    }else if(_status==400&&_TitleMes=="Debug Data"){
        console.table(_rJ.Data);
    }
   
    
}

$(document).ready(function(){ 
    if($('.ZMEST').length){ 
        let _href = decodeURIComponent(window.location.href); _href     = hp_removeParam('t',_href); let time = new Date().getTime(); History.pushState(null, document.title, _href + (_href.indexOf('?') != -1 ? '&' : '?') + 't=' + time); 
    }
}).on('click','.jSmk',function(e){
	e.preventDefault(); 
    CloseMessage();
	if(_decl==true){ console.log("waiting..."); return false; } 
    $('.ActiveOut').removeClass('ActiveOut');
    $('.jSlideModeArea').remove(); 
    $('.jRockerPopup').remove();
    $('#tooltip').remove();
    GlobalBackLink = decodeURIComponent(location.href);
	let _href = decodeURIComponent($(this).attr('href')),
	 	_time = new Date().getTime();  

    if($(this).hasClass('jHeadAddNew')){
        let _gettabcat = $(this).attr('gettabcat');
        if(_gettabcat){
          let _paramvalue = $('.js-Tab-nav-items.active').attr('setvalue');
          _href = hp_replaceParam(_gettabcat,_paramvalue,_href);
      } 
    }

	History.pushState(null, document.title, _href + (_href.indexOf('?') != -1 ? '&' : '?') + 't=' + _time); 
	return false;
}).on('click','.jSmkPage',function(e){
    e.preventDefault(); 
    CloseMessage();
    if(_decl==true){ console.log("waiting..."); return false; } 
    $('.ActiveOut').removeClass('ActiveOut');
    GlobalBackLink = decodeURIComponent(location.href);
    let _href = decodeURIComponent($(this).attr('href')),
        _time = new Date().getTime(); 
    if($('.MainPage').find('.js-Tab-nav-items.active').length){
        let _CurCat = $('.js-Tab-nav-items.active').attr('setvalue');
        _href = hp_replaceParam('Cat',_CurCat,_href);
    } 
    History.pushState(null, document.title, _href + (_href.indexOf('?') != -1 ? '&' : '?') + 't=' + _time); 
    return false;
}).on('click','.jBackPage',function(e){ 
  if (_decl == true) {
      console.log("waiting...");
      return false;
  }
 
  let _href =GlobalBackLink;
  if(_href){
    _href = hp_removeParam('t',_href);
  }else{
    _href = $(this).attr('href');
  } 
  _href = decodeURIComponent(_href);
   
  e.preventDefault();
  var time = new Date().getTime();
  History.pushState(null, document.title, _href + (_href.indexOf('?') != -1 ? '&' : '?') + 't=' + time);
  return false;
}).on('click','.jTrash',function(e){ 
  if (_decl == true) {
      console.log("waiting...");
      return false;
  } 
  let _href =location.href;
  GlobalBackLink = _href; 
  _href = hp_removeParam('t',_href);
   _href = hp_replaceParam('deleted',1,_href);
  _href = decodeURIComponent(_href); 
   
  e.preventDefault();
  var time = new Date().getTime();
  History.pushState(null, document.title, _href + (_href.indexOf('?') != -1 ? '&' : '?') + 't=' + time);
  return false;
}).on('click','.jDevShow',function(){
    let _Link = $(this).attr('href');
    $.ajax({
        url: site_url+_Link,
        type: 'GET', 
        cache: false, 
        async: false,
        beforeSend: function(e) {  
            dtl_Loading();
        },
        complete: function() {
            dtl_Loaded(); 
        },
        success: function(resp) {   
            location.reload();
        },
        error: function(xhr, ajaxOptions, thrownError) { 
            ErrorXhr(xhr, ajaxOptions, thrownError);
             
        } 
    });
    return false;

}).on('click','.jhp-ECTJs .js-Oi',function(){
  var _parent = $(this).closest('.jhp-ECTJs');
  var _val = _parent.data('text');
  var _this = $(this);
  var _show = $(this).attr('data-show');
  var _showDecr = _parent.find('.j-ShowsDecr'); 

  var _action = $('#MainPageContainer').data('action')

  if(_show=="1"){ 
    _showDecr.empty().append(_showDecr.data('star'))
    _this.attr('data-show',"0");
     $(this).removeClass('fa-eye-slash').addClass('fa-eye');
  }else{

    var _Resp = dtl_CallAjax(_action+ '/View_DecrText',{Value:_val});

    if(_Resp.Status==200&&_Resp?.Data?.String){
        _showDecr.empty().append(_Resp.Data.String); 
    } 
  } 
}).on('click', '.jExportSearch', function() { 
    dtl_showProcess(); 
    let _n = $('.jFormSearch').serializeArray(); 
    let _li = $(this).attr('href');
  


    $.ajax({
        url: site_url +_li,
        type: 'POST',
        data: $.param(_n),
        success: function(resp) { 

            var BeforeExport = resp?.Data?.BeforeExport;
            if(BeforeExport){
                if(resp?.Data?.Html){
                    Html = resp.Data.Html; 
                    CallRockerPopup('ExportFile', Html);  
                }
            }else{ 
                ExportFilesFromAjax(resp)
            }
            
            dtl_endProcess(); 
            return false; 
            
        }
    }); 
    return false;
});


function dtl_Loading(){  
  _decl = true; 
  $('body').removeClass('EndLoad').removeClass('Loaded').addClass('Loading');
  $('.LineProcess').css('opacity',1); 
}
function dtl_Loaded(){ 
   $('body').addClass('EndLoad').addClass('Loaded').removeClass('Loading');
   setTimeout(function(){$('body').removeClass('EndLoad');_decl = false;},300); 
}
var myTimeoutProcess;

var htmlProcessing = '<div class="js-processing wrab-processing"></div>';
function dtl_showProcess(_TimeSet = 500){ 
  if(!$('.js-processing').length) $('body').append(htmlProcessing); 

    myTimeoutProcess = setTimeout(function() {
      $('body').addClass('processing');
    }, _TimeSet);
}

function dtl_endProcess(){  
  clearTimeout(myTimeoutProcess);
  $('body').removeClass('processing');
   
}
