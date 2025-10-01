var _TargetInput;

$(document).on('change','.jFrmInput.Type-Radio-CheckBox input',function(){
    let _Parent = $(this).closest('.jFrmInput'),
        _checked    = $(this).is(':checked'); 
    let _InputType = $(this).attr('type');
        
    if(_checked){ 
        if(_InputType=='radio'){
            _Parent.find('.jfrmICB').removeClass('active');   
            $(this).closest('.jgrICB').find('.jfIcon').css({'background':''});
            $(this).closest('.jgrICB').find('.jfText').css({'color':''});
        }
        $(this).closest('.jgrICB').find('.jfrmICB').addClass('active'); 
        if(_Parent.hasClass('jfColorField')){
            const _fIcon = $(this).closest('.jgrICB').find('.jfIcon');
            _fIcon.css({'background':_fIcon.data('color')});
            $(this).closest('.jgrICB').find('.jfText').css({'color':_fIcon.data('color')});
        }
    }else{
        $(this).closest('.jgrICB').find('.jfIcon').css({'background':''});
        $(this).closest('.jgrICB').find('.jfText').css({'color':''});
    }  
}).on('change','.jFrmInput.Type-ColorPick input',function(){
    let _Parent = $(this).closest('.jFrmInput'),
        _checked    = $(this).is(':checked'); 
    let _InputType = $(this).attr('type');
         
    if(_checked){ 
        if(_InputType=='radio'){
            _Parent.find('.jfrmICB').removeClass('active');    
        }
        $(this).closest('.jgrICB').find('.jfrmICB').addClass('active'); 
    }else{
       $(this).closest('.jgrICB').find('.jfrmICB').removeClass('active'); 
    }  
}).on('click','.jFrmInput.Type-Radio-CheckBox .jfrmICB',function(){
    let _Input = $(this).closest('.jgrICB').find('input');  
    if(_Input.is(':checked')){
        _Input.prop('checked',false).trigger('change');
        $(this).removeClass('active'); 
        return false;/*required*/
    }
}).on('click','.jFrmInput.Type-StatusCheckList .jfrmLabel',function(){
    let _Input = $(this).closest('.jscItem').find('input');  
    if(_Input.is(':checked')){
        _Input.prop('checked',false).trigger('change');
        $(this).removeClass('active'); 
        return false;/*required*/
    }
}).on('change','.jFrmInput.Type-StatusCheckList input',function(){
    const _Parent       = $(this).closest('.jFrmInput'),
          _checked      = $(this).is(':checked'),
          _jItem        = $(this).closest('.jscItem');
    const _InputType    = $(this).attr('type');
   
    if(_checked){   
        if(_InputType=='radio'){
            _Parent.find('.jscItem.active').removeClass('active');
        }
        $(this).closest('.jscItem').addClass('active');  
    }else{ 
        $(this).closest('.jscItem').removeClass('active');
    }  
}).on('change','.jFrmInput.Type-NumberHasUnit .jfUnitList input',function(){
    let _Parent = $(this).closest('.jfUnitList'),
        _checked    = $(this).is(':checked');   
    if(_checked){  
        _Parent.find('.jfItemsUni').removeClass('active');   
        $(this).closest('.jfItemsUni').addClass('active'); 
    }  
}).on('change','.jFrmInput.Type-NumberMoneyPercent .jfUnitList input',function(){
    const _Parent = $(this).closest('.jfUnitList'),
        _checked    = $(this).is(':checked'),
        _val        = $(this).val(),
        _Ele        = $(this).closest('.jFrmInput').find('.jEle');

    if(_checked){  
        _Parent.find('.jfItemsUni').removeClass('active');   
        $(this).closest('.jfItemsUni').addClass('active'); 
        _Ele.data('autoNumericInstance').set(0);
        if(_val==2){
            _Ele.removeClass('jNumberFormat').addClass('jPercentFormat'); 
                _Ele.autoNumeric('update', {
                    'mDec': 2, 
                    'vMax': 99, 
                    'vMin':0,
              });
         
        }else{
            _Ele.removeClass('jPercentFormat').addClass('jNumberFormat');
            let _imc = _Ele.attr('mDec'),
              _ivm = _Ele.attr('vMax'),
              _ivi = _Ele.attr('vMin'); 
            _Ele.autoNumeric('update', {
                'mDec': (_imc)?_imc:0,
                'vMax': (_ivm)?_ivm:999999999999,
                'vMin': (_ivi)?_ivi:0,
           });
        } 
        _Ele.select().trigger('change');
    }  
}).on('click','.jFrmInput .jfsRemove',function(){
    /*for Remove Value Search*/
    const _Parent = $(this).closest('.jFrmInput');
    const _Type = _Parent.data('type');
 

    if(_Type=='Text'||_Type=='Day'||_Type=='FromToDay'||_Type=='FromToText'){
        _Parent.find('.jEle').val('');
    }else if(_Type=='TreeRadio'||_Type=='TreeRadioExpand'||_Type=='CheckListContent'||_Type=='SelectListContent'){
        _Parent.find('input[type="radio"]').prop('checked',false); 
    }else if(_Type=='TreeCheckBox'){
        _Parent.find('input[type="checkbox"]').prop('checked',false); 
    }else if(_Type=='Select'){ 
        _Parent.find('.jEle').val(0).trigger('change'); 
    }else if(_Type=='NumberQuantity'||_Type=='Number'||_Type=='FromToNumber'){
        _Parent.find('.jEle').each(function(){
            $(this).data('autoNumericInstance').set('');
        })
         
        _Parent.find('.jEle').trigger('change'); 
    }else if(_Type=='tAutoComplete'){
        _Parent.find('.jAfterSet').val('');
    }  
    _Parent.removeClass('fsHasValue'); 
    if(!_Parent.hasClass('jAutoSubmit')||_Parent.hasClass('Type-tAutoComplete')||_Parent.hasClass('jRemoveAutoSubmit')){
        $(this).closest('form').submit();
    } 
    return false;
}).on('click','.jFrmShowPass',function(){
    let _Parent = $(this).closest('.jFrmInput');
    let _showclass = $(this).attr('show-class');
    let _hideclass = $(this).attr('hide-class');

    if($(this).data('IsShow')){
      $(this).removeClass(_hideclass).addClass(_showclass);
      $(this).data('IsShow',0);
      _Parent.find('.jEle').attr('type','password');
    }else{
      $(this).removeClass(_showclass).addClass(_hideclass);
      $(this).data('IsShow',1);
      _Parent.find('.jEle').attr('type','text');
    }
}).on('change','.jFrmInput.Type-SelectListContent input',function(){
    let _Parent = $(this).closest('.jFrmInput'),
        _checked    = $(this).is(':checked'); 
    let _InputType = $(this).attr('type');
        
    if(_checked){ 
     
        _Parent.find('.jfrmICB').removeClass('active');   
 
        $(this).closest('.jgrICB').find('.jfrmICB').addClass('active'); 

        let _HtmlText = $(this).closest('.jgrICB').find('.jfText').html();
        _Parent.find('.jfChoose').empty().append(_HtmlText);
    }  
}).on('change','.ddjFrmInput.Type-CheckListContent input',function(){
    let _Parent = $(this).closest('.jFrmInput'),
        _checked    = $(this).is(':checked'); 
    let _InputType = $(this).attr('type');
        
    if(_checked){  
        _Parent.find('.jfrmICB').removeClass('active');   
 
        $(this).closest('.jgrICB').find('.jfrmICB').addClass('active'); 

        let _HtmlText = $(this).closest('.jgrICB').find('.jfText').html();
        _Parent.find('.jfChoose').empty().append(_HtmlText);
    }else{ 
    }  
}).on('click','.jFrmInput.Type-CheckListContent .jfrmICB',function(){
    let _Input = $(this).closest('.jgrICB').find('.jEle'); 
    let _Parent = $(this).closest('.jFrmInput');
    let _InputType = _Input.attr('type');
    
    if(!$(this).hasClass('active')){   
        if(_InputType=='radio'){
            _Parent.find('.jfrmICB').removeClass('active');
        } 
        $(this).addClass('active');  
        _Input.prop('checked',true).change();
    }else{ 
        $(this).removeClass('active'); 
        _Input.prop('checked',false).change();
    }  
}).on('click','.jFrmInput.Type-SelectListContent .jfrmICB',function(){
    let _Input = $(this).closest('.jgrICB').find('input'); 
    let _Parent = $(this).closest('.jFrmInput');
    $(this).closest('.jFrmInput.Type-SelectListContent').removeClass('active');
    if(_Input.is(':checked')){
        return false;
        /*_Input.prop('checked',false).trigger('change');
        $(this).removeClass('active'); 
        _Parent.find('.jfChoose').empty(); 
        return false; */
    }
}).on('click','.jFrmInput.Type-SelectListContent',function(){
    if($(this).hasClass('active')){
        $(this).removeClass('active');
    }else{
        $(this).addClass('active');
    }
}).on('click','.jfDevSetting',function(){
     
     let _InputType  = $(this).attr('input-type'),
         _FixKey     = $(this).data('fixkey');

      let _Link = 'Config_DevSetting/Edit_SettingInput';
      Html = dtl_GetAniHtml(_Link,{'InputType':_InputType,'FixKey':_FixKey});
      if(Html){ 
        CallRockerPopup('GenerateFile-Config_Modules', Html); 
      } 
      return false;
}).on('click','.jFrmInput .jEx',function(){
    /*for TreeRadio AND TreeCheckBox*/
    const parent = $(this).closest('.jItems');
    const isOpen = parent.hasClass('active');
    const iconClass = isOpen ? $(this).data('open') : $(this).data('close');

    parent.toggleClass('active');
    $(this).find('i').attr('class', iconClass);
    return false;
}).on('change','.jFrmInput.Type-TreeRadio input',function(){
    /*for TreeRadio*/
    let _value = $(this).val();
    let _Name = $(this).data('name');
    let _Parent = $(this).closest('.jFrmInput');

    let _DefaultLabel = _Parent.find('.jfDefaultLabel');

    let _ChooseLabel = _DefaultLabel.data('chooselabel');


    _DefaultLabel.empty().append(_Name);
    _DefaultLabel.addClass('HasChoose'); 
    $('.ActiveOut').removeClass('ActiveOut');

}).on('click','.jFrmInput.Type-TreeRadio',function(){
    /*for TreeRadio*/ 
   let _this = $(this);
    _this.toggleClass('ActiveOut'); 
    if (!_this.data('openValue')) {
        let _checkedRadio = _this.find('input[type="radio"]:checked'); 
        if (_checkedRadio.length) {
            _checkedRadio.parents('.jItems').addClass('active');
            _this.find('.jItems.active').each(function() {
                let _jEx = $(this).find('.jEx').first();
                let iconClass = _jEx.data('close');
                _jEx.find('i').attr('class', iconClass);
            });
        } 
        _this.data('openValue', 1);
    }


}).on('change','.jFrmInput.Type-TreeRadioExpand input',function(){
    /*for TreeRadioExpand*/
    let _value = $(this).val();
    let _Name = $(this).data('name');
    let _Parent = $(this).closest('.jFrmInput');

    let _DefaultLabel = _Parent.find('.jfDefaultLabel');

    let _ChooseLabel = _DefaultLabel.data('chooselabel');


    _DefaultLabel.empty().append(_Name);
    _DefaultLabel.addClass('HasChoose'); 
    $('.ActiveOut').removeClass('ActiveOut');

}).on('click','.jFrmInput.Type-TreeRadioExpand',function(){
    /*for TreeRadioExpand*/ 
   let _this = $(this);
    _this.toggleClass('ActiveOut'); 
    if (!_this.data('openValue')) {
        let _checkedRadio = _this.find('input[type="radio"]:checked'); 
        if (_checkedRadio.length) {
            _checkedRadio.parents('.jItems').addClass('active');
            _this.find('.jItems.active').each(function() {
                let _jEx = $(this).find('.jEx').first();
                let iconClass = _jEx.data('close');
                _jEx.find('i').attr('class', iconClass);
            });
        } 
        _this.data('openValue', 1);
    }


}).on('change','.jFrmInput.Type-TreeCheckBox input',function(){
    /*for TreeCheckBox*/ 
    const _s  = $(this).closest('.jItems.active'); 
    const _ListCheckAll = ($(this).closest('.jItems.jChangeAll').length)?_s.find('input[type="checkbox"]'):'';
  
    if($(this).is(':checked')){ 
      if(_ListCheckAll) _ListCheckAll.prop("checked",true); 
    }else{ 
      if(_ListCheckAll) _ListCheckAll.prop("checked",false); 
    }  


}).on('click','.jFrmInput.Type-TreeCheckBox',function(){
    /*for TreeCheckBox*/ 
   let _this = $(this);
    _this.toggleClass('ActiveOut'); 
    if (!_this.data('openValue')) {
        let _checkedCheckBox = _this.find('input[type="checkbox"]:checked'); 
        if (_checkedCheckBox.length) {
            _checkedCheckBox.parents('.jItems').addClass('active');
            _this.find('.jItems.active').each(function() {
                let _jEx = $(this).find('.jEx').first();
                let iconClass = _jEx.data('close');
                _jEx.find('i').attr('class', iconClass);
            });
        } 
        _this.data('openValue', 1);
    } 

}).on('change','.jFrmInput.Type-TreeCheckBoxList input[type="checkbox"]',function(){
    /*for TreeCheckBoxList*/ 
 
    const parent = $(this).closest('.jItems');
    const isOpen = parent.hasClass('active');
    
    const _FrmInput = $(this).closest('.FrmInput');
    if(!_FrmInput.hasClass('isExpandAll')){
        if($(this).is(':checked')){  
          parent.addClass('active');
          parent.find('.jItems').find('input[type="checkbox"]').prop("checked",true);  
         parent.find('.jItems').addClass('active');

        }else{  
          parent.removeClass('active');
          parent.find('.jItems').removeClass('active'); 
          parent.find('.jItems').find('input[type="checkbox"]').prop("checked",false); 
        }
    }

        
    return false;  

}).on('click','.jFrmInput.Type-TreeCheckBoxList',function(){
    /*for TreeCheckBoxList*/ 
   let _this = $(this);

   if(!_this.find('.FrmInput').hasClass('isExpandAll')){ 
        _this.toggleClass('ActiveOut'); 
        if (!_this.data('openValue')) {
            let _checkedCheckBox = _this.find('input[type="checkbox"]:checked'); 
            if (_checkedCheckBox.length) {
                _checkedCheckBox.parents('.jItems').addClass('active');
                _this.find('.jItems.active').each(function() {
                    let _jEx = $(this).find('.jEx').first();
                    let iconClass = _jEx.data('close');
                    _jEx.find('i').attr('class', iconClass);
                });
            } 
            _this.data('openValue', 1);
        } 
   }
    

}).on('change keyup keydown','.jTriggerSeo .jEle',function(){
    let _TrSeo = $(this).closest('.jTriggerSeo');
    let _KeyLang = _TrSeo.data('lang');
    let _Tg = $('.jfSeoTitle_'+_KeyLang).find('.jEle');
    let _SeoVal = _Tg.val(); 
     
    _Tg.val($(this).val());
 
}).on('focus','input[autocomplete-input="1"]',function(event){  
    /*for tAutoComplete*/
    

    const _ThisInput = $(this);
    const _payloadFunction = _ThisInput.attr('function-payload');
    const _clearinput = _ThisInput.data('clearinput');

    let _DataPayload = {};
    if (_payloadFunction) {
      _DataPayload = window[_payloadFunction](_ThisInput);/*Chỉ truyền được đúng một lần khởi tạo đầu tiên*/
    } 
    const veee = _ThisInput.tautocomplete({
      cols: _ThisInput.data('cols'),
      defaultValue: _ThisInput.val(),
      multichoice: _ThisInput.data('multichoice'),
      debug:_ThisInput.data('debug'),
      FixTop:_ThisInput.data('fixtop'),
      clearinput: _clearinput,
      
      ajax: {
        url: _ThisInput.data('query'),
        data: _DataPayload,
        success: function(data) {
            if (!data) return false;  
            const searchData = new RegExp(veee.searchdata().replace(/\//g, ''), 'i');
            const searchDataShift = new RegExp(veee.searchdata().replace(/\s+/g, '-'), 'i');
            const searchDataOnlyCharacter = new RegExp(veee.searchdata().replace(/[^a-zA-Z0-9]/g, ''), 'i');

            return data.filter(v => { 
              return Object.values(v).some(val => typeof val === 'string' && (val.match(searchData)||val.match(searchDataShift)||val.match(searchDataOnlyCharacter)));
            });  
        },
        error: function() {}
      },
      select: function(obj, input) {  
        if(obj){
            const _funcName = _ThisInput.attr('function-select');
        
            const _setfromfield = _ThisInput.data('setfromfield');
            const _textshowinput = _ThisInput.data('textshowinput');
            
            var _TextShowValue = obj?.TextShowInput;

            if(_textshowinput){
                _TextShowValue = (obj?.[_textshowinput])??'Data trả về cẩn có Field: '+_textshowinput;
            }
            if(_TextShowValue){
                input.val(_TextShowValue);
            }
            
            if(_setfromfield&&obj?.[_setfromfield]){
                _ThisInput.closest('.jFrmInput').find('.jAfterSet').val(obj[_setfromfield]);
            }else if(_setfromfield){
                 /*RockerMessage('Error',_setfromfield,'Not Found In obj return');*/ 
                _ThisInput.closest('.jFrmInput').find('.jAfterSet').val('');
            } 
            if (_funcName) {
              window[_funcName](obj, input);
            }
            if(!_clearinput){
                input.closest('.jFrmInput').find('.fMarktAuto').addClass('active');
                input.blur();
            }
        }else{
            input.val('');
        }
        
      }
    });
}).on('click','.jRemoveMarktAuto',function(){
 
    const _jFrmInput = $(this).closest('.jFrmInput'); 
    _jFrmInput.find('.jEle').val('').trigger('change');
    $(this).closest('.fMarktAuto').removeClass('active');
    _jFrmInput.find('.jEle').focus();
    _jFrmInput.find('.jAfterSet').val('').trigger('change');
     
}).on('focus','.jFrmInput.Type-tAutoComplete .jEle',function(){
 
    const _jFrmInput = $(this).closest('.jFrmInput');
    if(_jFrmInput.find('.fMarktAuto.active').length){
        _jFrmInput.find('.jAfterSet').val('');
        _jFrmInput.find('.jEle').val('').trigger('change');
        _jFrmInput.find('.fMarktAuto.active').removeClass('active'); 
    }
    
    
     
}).on('click','.js-fRating',function(){
    /*fRating*/
    const _Parent = $(this).closest('.jfRat');

    let _rating = $(this).data('rating');

    $('.js-fRating').each(function(){
        let _cRa = $(this).data('rating');
        if(_cRa<=_rating){
            $(this).addClass('Checked');
        }else{
            $(this).removeClass('Checked');
        }
    });
    _Parent.addClass('Rated');
    _Parent.find('.jEle').val(_Parent.find('.js-fRating.Checked').length)
}).on('click','.jfQuantity .jfqBtn',function(){
    const _Parent = $(this).closest('.jfQuantity');
    const _InputQuantity = _Parent.find('.jNumberFormat');

    const _vmin = _InputQuantity.attr('vmin');
    const _vmax = _InputQuantity.attr('vmax');

    var _Quantity = _InputQuantity.data('autoNumericInstance').getNumber();
    _Quantity = (_Quantity)?parseInt(_Quantity):0;

    if($(this).hasClass('jSub')){
        _Quantity =_Quantity - 1;
    }else{
         _Quantity =_Quantity + 1;
    }
    if(_Quantity<_vmin||_Quantity>_vmax) return false;

    _InputQuantity.data('autoNumericInstance').set(_Quantity);
    _InputQuantity.trigger('change');

}).on('keydown','.jfQuantity .jNumberFormat',function(){
    const _Parent   = $(this).closest('.jfQuantity'); 
    const _vmin     = $(this).attr('vmin');
    const _vmax     = $(this).attr('vmax');

    var _Quantity = $(this).data('autoNumericInstance').getNumber();
    _Quantity = (_Quantity)?parseInt(_Quantity):0;

    const _evkey = event.which;
   
    if(_evkey==38){
        /*up*/
        _Quantity =_Quantity + 1;
    }else if(_evkey==40){
        _Quantity =_Quantity - 1;
    }
    if(_Quantity<_vmin||_Quantity>_vmax) return false;
     
    $(this).data('autoNumericInstance').set(_Quantity);
    $(this).trigger('change');

}).on('click','.jFrmInput.Type-RadioSwitch',function(){ 
    let _jfGroupRadioSwitch = $(this).find('.jfGroupRadioSwitch');
    
    if(_jfGroupRadioSwitch.hasClass('active')){
        _jfGroupRadioSwitch.removeClass('active');
        _jfGroupRadioSwitch.find('.jfrs-no').prop('checked',true).trigger('change'); 
    }else{
        _jfGroupRadioSwitch.addClass('active');
        _jfGroupRadioSwitch.find('.jfrs-yes').prop('checked',true).trigger('change');
    } 
}).on('change','.jAutoSubmit .jEle',function(){
    $(this).closest('form').submit();
}).on('click','.jFrmFontIcon',function(){
    _TargetInput = $(this).closest('.jFrmInput');
    _Data = {
        IconType:$(this).data('icon-type'),

    };
    var Html = dtl_GetAniHtml('RockerAjax/NoRequired_FrmFontIcon',_Data);   
    CallRockerPopup('FontIcon', Html);


}).on('click','.jItemChooseFontIcon',function(){
     var _font = $(this).html();

     _TargetInput.find('.jFrmFontIcon').empty().append(_font);
     _TargetInput.find('.jEle').val(_font).trigger('change');
     $(this).closest('.jRockerPopup').find('.jClose').trigger('click');

}).on('change','.jFrmFontIconInput[type="text"]',function(){
     var _font = $(this).val();
     $(this).closest('.jFrmInput').find('.jFrmFontIcon').empty().append(_font); 
}).on('click','.jFrmInput.Type-File .jRemoveValue',function(){

    const _Parent = $(this).closest('.jFrmInput');
    
    

    const _DefLabel = _Parent.find('.jEle').data('text');
    const _DefIcon  = _Parent.find('.jEle').data('icon'); 
     
    _Parent.find('.jLabelChoose').empty().append(_DefLabel); 
    _Parent.find('.jfGroupFile').addClass('NoFile');
    _Parent.find('label').find('i').attr('class',_DefIcon);
    _Parent.removeClass('Items-HasValue');
    _Parent.find('.jEle').val('');
    _Parent.find('.jCurrentValue').val('');

}).on('change','.jFrmInput.Type-File .jEle',function(){

    const _Parent = $(this).closest('.FrmItems');

    const _value    = $(this).val();
    const _FileName = _value.replace(/.*[\/\\]/, '');
    const _FileType = _value.substr(_value.lastIndexOf('.')+1,_value.length).toLowerCase();
    const _accept   = $(this).attr('accept');

    const _AcceptArr = _accept.split(',');
 


    if(!_AcceptArr.includes(_FileType)){

        const _DefLabel = $(this).data('text');
        const _DefIcon  = $(this).data('icon'); 
        CallErrorTags(_Parent, 'Chỉ được phép up file có định dạng: '+_accept); 
        _Parent.find('.jLabelChoose').empty().append(_DefLabel); 
        _Parent.find('.jfGroupFile').addClass('NoFile');
        _Parent.find('label').find('i').attr('class',_DefIcon);
        _Parent.removeClass('Items-HasValue');
        _Parent.find('.jCurrentValue').val('');
        return false;
    }else{
        
        _Parent.find('.NoFile').removeClass('.NoFile');

        $.ajax({
          url: site_url + 'RockerAjax/NoRequired_CheckFileIcon',
          type: 'GET',
          cache: false, 
          async: false,
          data: {  
              FileName : _FileName,
          },
          success: function(resp){ 
            const _IsImage =  resp?.Data?.IsImage;
            const _IconFile =  resp?.Data?.IconFile;
            const _ClassType =  resp?.Data?.ClassType;
 
            _Parent.find('.jLabelChoose').empty().append(_FileName);
            if(_Parent.find('.jLabelChoose').find('label').find('i').length){
                _Parent.find('.jLabelChoose').find('label').replaceWith(_IconFile);
            }else{
                _Parent.find('.jLabelChoose').find('label').append(_IconFile);
            } 

            _Parent.find('.jfGroupFile').removeClass('NoFile').addClass(_ClassType);
            _Parent.addClass('Items-HasValue');
          }
       });
 


    }


     
}).on('click','.jFrmInput .jDisableInputCheck',function(){
      const _InputCheck = $(this).find('.jValCheck');
      const _FrmInput = $(this).closest('.jFrmInput');
      const _Ele = _FrmInput.find('.jEle');
      const _TextCheck = _FrmInput.find('.jDisableInputCheckText');

 

      var _IsNumber = _Ele.hasClass('jIsNumberic');
       
      if(_InputCheck.val()==1){
        $(this).removeClass('active');
        _InputCheck.val(0);
        _TextCheck.removeClass('active');
        _Ele.focus();
      }else{
        $(this).addClass('active');
        _InputCheck.val(1); 
        _TextCheck.addClass('active'); 
        if(_IsNumber){
            _Ele.data('autoNumericInstance').set(0);
        }else{
            _Ele.val('');
        }
        
      }

}).on('click','.jFrmInput .jEnableInputCheck',function(){
      const _InputCheck = $(this).find('.jValCheck');
      const _FrmInput = $(this).closest('.jFrmInput');
      const _Ele = _FrmInput.find('.jEle');
      const _TextCheck = _FrmInput.find('.jEnableInputCheckText');

 

      var _IsNumber = _Ele.hasClass('jIsNumberic');
       
      if(_InputCheck.val()==0){
        $(this).addClass('active');
        _InputCheck.val(1);
        _TextCheck.addClass('active');
        _Ele.focus();
      }else{
        $(this).removeClass('active');
        _InputCheck.val(0); 
        _TextCheck.removeClass('active'); 
        if(_IsNumber){
            _Ele.data('autoNumericInstance').set(0);
        }else{
            _Ele.val('');
        }
        
      }

}).on('change keyup keydown','.jFrmInput.Type-Text[data-required-type="Number"] .jEle,.jFrmInput.Type-FromToText[data-required-type="Number"] .jEle',function(){
    var _InputItem = $(this).closest('.jFrmInput');
    var _Type = _InputItem.data('type');
    let _val = $(this).val(); 
    _val = (_val)?_val.replace(/[^0-9]/g, ''):''; 
    
    $(this).val(_val);
    

}).on('click','.jFrmInput.Type-FromToNumber .jSuggestListButton',function(){
    const _Parent = $(this).closest('.jFrmInput'); 
    if(_Parent.hasClass('ActiveSuggess')){
        _Parent.removeClass('ActiveSuggess');
    }else{
        $('.jFrmInput.ActiveSuggess').removeClass('ActiveSuggess');
        _Parent.addClass('ActiveSuggess');
    } 
}).on('click',function (e)
{ 
    const _list = $(".jFrmInput.ActiveSuggess .jiSuggestList"); 
    var _btn = $(".jFrmInput.ActiveSuggess .jSuggestListButton"); 
    if (!_list.is(e.target) && _list.has(e.target).length === 0&&!_btn.is(e.target) && _btn.has(e.target).length === 0)
    {
      _list.closest('.jFrmInput.ActiveSuggess').removeClass('ActiveSuggess'); 
    }  
}).on('click','.jFrmInput.Type-FromToNumber .jitt',function(){
    const _Parent = $(this).closest('.jFrmInput'); 

    const _FromValue = $(this).data('from');
    const _ToValue = $(this).data('to');

    _Parent.find('.jEle.iFrom').data('autoNumericInstance').set(_FromValue);
    _Parent.find('.jEle.iTo').data('autoNumericInstance').set(_ToValue);
    _Parent.removeClass('ActiveSuggess');
    if(_Parent.closest('.jFormSearch').length){
        _Parent.closest('.jFormSearch').submit();
    }
}).on('input', '.jTextareaAutoHeight', function () {
    $(this).css('height', 'auto'); // Reset chiều cao trước khi tính toán
    $(this).css('height', this.scrollHeight + 'px'); // Cập nhật chiều cao dựa trên nội dung
});


function Numberic_Format(_InputValue){ 
    /*Remove .*/ 
    _InputValue = (_InputValue)?_InputValue.replace(/\./g,''):_InputValue;
    /*Change , to . decimal type*/ 
    _InputValue = (_InputValue)?_InputValue.replace(/,/g,'.'):_InputValue;
    return _InputValue;
}
/*************************/
/******--------------*****/
/*************************/

 
 
$(document).on('click','.jSubmitPage',function(){
    if($('.jFormMain').length&&!_decl){
        $('.jFormMain').submit();
    }else if($('.jFormMainImport').length&&!_decl){
        $('.jFormMainImport').submit();
    } 
}).on('click','.jSubmitPopup',function(){
    if($('.jFormMainPopup').length&&!_decl){
        $(this).closest('.jRockerPopup').find('.jFormMainPopup').submit();
    }
}).on('submit','.jFormMain,.jFormMainPopup,.jFormMainExport,.jFormOpenAccess',function(){ 

    if(_decl==1) return false;
    _decl = 1;
    _PriValidate = $(this).attr('pri-validate');/*return true if valid and false if invalid*/

    if (!fvd($(this))){
        _decl = 0;
        return false;
    }else if(_PriValidate&&!window[_PriValidate]($(this))){
        _decl = 0;
        return false;
    }  
    const _this = $(this);
    const _funcAfterSubmit = _this.attr('func-aftersubmit');
    const _funcDataToForm = _this.attr('func-datatoform');

    var a = new FormData(this),
        b = $(this).attr("action"),
          
    b = b.replace(site_url, "");
   
    if(_funcDataToForm){
        var _dataToForm = window[_funcDataToForm](_this); 
        Object.keys(_dataToForm).forEach(key => {
            if(Array.isArray(_dataToForm[key])){
                _dataToForm[key].forEach(value => {
                    a.append(key, value);
                });
            }else{
                a.append(key, _dataToForm[key]);
            }
        }); 
    }

    if(_this.find('.jFrmInput.Type-Select.jGetChooseName').length){
        _this.find('.jFrmInput.Type-Select.jGetChooseName').each(function(){ 
            let _InputItem = $(this),
                _Input     = $(this).find('select.jEle');
            let _InputName = _Input.attr('name'); 
            if(_InputName){
                a.append((_InputName+'ChooseName'), _Input.find('option:selected').text());
            } 
            let _ChooseNameField = _InputItem.data('choosenamefield');  
            if(_ChooseNameField){
                a.append((_ChooseNameField), _Input.find('option:selected').text());
            }
        });
    }
    if(_this.find('.jFrmInput.Type-Radio.jGetChooseName').length){
        _this.find('.jFrmInput.Type-Radio.jGetChooseName').each(function(){ 
            let _InputItem = $(this),
                _Input     = $(this).find('input.jEle:checked');
            let _InputName = _Input.attr('name'); 
        
            if(_InputName){
                a.append((_InputName+'ChooseName'), _Input.data('name'));
            } 
            let _ChooseNameField = _InputItem.data('choosenamefield');  
            if(_ChooseNameField){
                a.append((_ChooseNameField), _Input.data('name'));
            }
        });
    }

    /*bg Type-TreeRadio*/
    if(_this.find('.jFrmInput.Type-TreeRadio.jGetChooseName').length){
        _this.find('.jFrmInput.Type-TreeRadio.jGetChooseName').each(function(){ 
            let _InputItem = $(this),
                _Input     = $(this).find('input[type="radio"]:checked');
            let _InputName = _Input.attr('name'); 
        
            if(_InputName){
                a.append((_InputName+'ChooseName'), _Input.data('name'));
            } 
            let _ChooseNameField = _InputItem.data('choosenamefield');  
            if(_ChooseNameField){
                a.append((_ChooseNameField), _Input.data('name'));
            }
        });
    }
    /*ed Type-TreeRadio*/

    /*bg Type-TreeCheckBox*/
    if(_this.find('.jFrmInput.Type-TreeCheckBox.jGetChooseName').length){
        _this.find('.jFrmInput.Type-TreeCheckBox.jGetChooseName').each(function(){ 
            var _TextValue = []; 
            $(this).find('input[type="checkbox"]').each(function() { 
                if ($(this).is(':checked')) {
                    _TextValue.push($(this).data('name')); 
                }
            });
            let _ChooseNameField = $(this).data('choosenamefield');  
            if(_ChooseNameField){ 
                a.append((_ChooseNameField), JSON.stringify(_TextValue));
            } 
        });
    }
    /*ed Type-TreeCheckBox*/

    /*for CheckBox*/
    if(_this.find('.jFrmInput.Type-CheckBox.jGetChooseName').length){
        _this.find('.jFrmInput.Type-CheckBox.jGetChooseName').each(function(){ 
      
            var _TextValue = []; 
            $(this).find('input[type="checkbox"]').each(function() { 
                if ($(this).is(':checked')) {
                    _TextValue.push($(this).closest('.jgrICB').find('.jfText').text()); 
                }
            });
            let _ChooseNameField = $(this).data('choosenamefield');  
            if(_ChooseNameField){ 
                a.append((_ChooseNameField), JSON.stringify(_TextValue));
            } 
        });
    }
    /*ed for CheckBox*/
     
    a = Frm_ReFormatDataForm1_BeforSubmit(_this,a); 

    a.append('Lat',_lade);
    a.append('Long',_lode); 

    if(_this.hasClass('jFormOpenAccess')){
        $.ajax({
            url: site_url + b,
            type: "POST",
            cache: !1,
            contentType: false, 
            processData: false, 
            data: a,
            beforeSend: function(resp) { 
                 Bg_Sending();
            },
            complete: function() {
                 _decl = false;
                  
            },
            success: function(resp) { 
                _decl = false;
                if(_funcAfterSubmit){
                    window[_funcAfterSubmit](resp,_this); 
                }else{
                    Ed_Sending(resp);
                }  
                
            },
            error: function(xhr, ajaxOptions, thrownError) {  
                Ed_ErrorXhr(xhr, ajaxOptions, thrownError);
                if(_funcAfterSubmit){
                    window[_funcAfterSubmit](xhr?.responseJSON,_this);
                }
                 
            } 
        });
    }else{
        $.ajax({
            url: site_url + b,
            type: "POST",
            cache: !1,
            contentType: false, 
            processData: false, 
            data: a,
            beforeSend: function(resp) { 
                 dtl_showProcess();
            },
            complete: function() {
                 _decl = false;
                 dtl_endProcess(); 
            },
            success: function(resp) { 
                _decl = false;
                if(_funcAfterSubmit){
                    window[_funcAfterSubmit](resp,_this); 
                }else{
                    rfh_AfterSubmitForm(resp,_this);
                }

                
            },
            error: function(xhr, ajaxOptions, thrownError) {  
                ErrorXhr(xhr, ajaxOptions, thrownError);
                if(_funcAfterSubmit){
                    window[_funcAfterSubmit](xhr?.responseJSON,_this);
                }
                 
            } 
        });
    }
    
         
    return false;
}).on('submit','.jFormGen',function(){ 

    if(_decl==1) return false;
    _decl = 1; 
   
    _PriValidate = $(this).attr('pri-validate');/*return true if valid and false if invalid*/

    if (!fvd($(this))){
        _decl = 0;
        return false;
    }else if(_PriValidate&&!window[_PriValidate]($(this))){
        _decl = 0;
        return false;
    }


    GlobalBackLink = decodeURIComponent(location.href);
    
    var _this = $(this);
 
        var a = new FormData(this),
        action = $(this).attr('action'),
        modules = $(this).data("action")+'/Add_BeforeGenerate';

    if($(this).hasClass('jBeforeGenerateImport')){
        modules = $(this).data("action")+'/Import_BeforeGenerate';

    }


    var a = new FormData(this),
        b = $(this).attr("action"),
        b = b.replace(site_url, ""); 

    if(_this.find('.jFrmInput.Type-Select.jGetChooseName').length){
        _this.find('.jFrmInput.Type-Select.jGetChooseName').each(function(){ 
            let _InputItem = $(this),
                _Input     = $(this).find('select.jEle');
            let _InputName = _Input.attr('name');    
            if(_InputName){
                a.append((_InputName+'ChooseName'), _Input.find('option:selected').text());
            } 
            let _ChooseNameField = _InputItem.data('choosenamefield');  
            if(_ChooseNameField){
                a.append((_ChooseNameField), _Input.find('option:selected').text());
            }
        });
    } 
    if(_this.find('.jFrmInput.Type-Radio.jGetChooseName').length){
        _this.find('.jFrmInput.Type-Radio.jGetChooseName').each(function(){ 
            let _InputItem = $(this),
                _Input     = $(this).find('input.jEle:checked');
            let _InputName = _Input.attr('name'); 
        
            if(_InputName){
                a.append((_InputName+'ChooseName'), _Input.data('name'));
            } 
            let _ChooseNameField = _InputItem.data('choosenamefield');  
            if(_ChooseNameField){
                a.append((_ChooseNameField), _Input.find('option:selected').text());
            }
        });
    } 
    if(_this.find('.jFrmInput.Type-TreeRadio.jGetChooseName').length){
        _this.find('.jFrmInput.Type-TreeRadio.jGetChooseName').each(function(){ 
            let _InputItem = $(this),
                _Input     = $(this).find('input[type="radio"]:checked');
            let _InputName = _Input.attr('name');  
            if(_InputName){
                a.append((_InputName+'ChooseName'), _Input.data('name'));
            } 
            let _ChooseNameField = _InputItem.data('choosenamefield');  
            if(_ChooseNameField){
                a.append((_ChooseNameField), _Input.find('option:selected').text());
            }
        });
    }    
    a = Frm_ReFormatDataForm1_BeforSubmit(_this,a);
    console.log(modules);
    $.ajax({
        url: site_url + modules,
        type: "POST",
        cache: !1,
        contentType: false, 
        processData: false, 
        data: a,
        beforeSend: function(resp) { 
             
        },
        complete: function() {
             _decl = 0;
        },
        success: function(resp) { 
            if(typeof resp.RespondRocker !== 'undefined'){
                  
                let _GenId = resp.Data.GenId;

                var time = new Date().getTime();
     
                if(action.indexOf('?')>0) action = action+''; else action = action +'?';
                action = action+'GenId='+_GenId;
                 

                History.pushState(null, document.title, decodeURIComponent(action+ '&&t=' + time));
     
                $('.jRockerPopup .jClose').trigger('click');
                return false;  
            } 
        },
        error: function(xhr, ajaxOptions, thrownError) {  

            ErrorXhr(xhr, ajaxOptions, thrownError);
             
        } 
    });
         
    return false;
}).on('submit','.jFormSearch',function(e){ 
    
    e.preventDefault();
    const $this = $(this);
    const action = $this.attr("action");
    const isActionQuery = action.indexOf('?') > 0;
    const actionWithAmpersand = isActionQuery ? action+'&' : action+'?';
    if (_decl) {
      RockerMessage('Error','Please waiting');
      return false;
    } 
    $('.ActiveOut').removeClass('ActiveOut');  
    var formValues = $this.serializeArray(); 


     if ($this.find('.jFrmInput.Type-Select.jGetChooseName').length) {
        $this.find('.jFrmInput.Type-Select.jGetChooseName').each(function() { 
            let _InputItem = $(this),
                _Input     = _InputItem.find('select.jEle');
            let _InputName = _Input.attr('name');    
            if (_InputName) {
                formValues.push({ name: _InputName + 'ChooseName', value: _Input.find('option:selected').text() });
            } 
            let _ChooseNameField = _InputItem.data('choosenamefield');  
            if (_ChooseNameField) {
                formValues.push({ name: _ChooseNameField, value: _Input.find('option:selected').text() });
            }
        });
    }

    formValues = Frm_ReFormatDataForm2_BeforSubmit($(this),formValues);
     
    const _ParamForm = $.param(formValues);

    const href = decodeURIComponent(`${actionWithAmpersand}${_ParamForm}`);
    const time = new Date().getTime();
    History.pushState(null, document.title, `${href}${href.indexOf('?') !== -1 ? '&' : '?'}t=${time}`); 
    return false; 
    
          
}).on("keyup keydown click  change", ".jEle", function(e) {
  
    let _InputItem = $(this).closest('.jFrmInput');
    let _RequiredType = _InputItem.data('required-type');
    if(_RequiredType=='Phone'){
        let _val = $(this).val();
        $(this).val(_val.replace(/\D/g, ""));
    }
    _InputItem.removeClass('Warning');  
    _InputItem.find('.ErrorTags').remove(); 
    if((e.key=='Enter'&&$(this).closest('.jRockerPopup').length) ||$(this).closest('form.jSubmitOnEnter').length){
        $(this).closest('form').submit();
    } 
}).on("keyup keydown  change focus", ".inputTags-field", function() {
    let _InputItem = $(this).closest('.jFrmInput'); 
    _InputItem.removeClass('Warning');  
    _InputItem.find('.ErrorTags').remove();
    
}).on("click", ".jDynamicSmallData", function() {
     const _DynamicKey = $(this).attr('dynamickey'); 
     CallDynamicAddBoard(_DynamicKey);
     return false; 
}).on("click", ".jDynamicTableData", function() {
     const _Link = $(this).attr('href'); 

     const _FunctionData = $(this).attr('func-data'); 
     var _Data = [];
     if(_FunctionData){
        _Data = window[_FunctionData]();
     }  
     var Html = dtl_GetAniHtml(_Link,_Data);   
     CallRockerPopup('PopupDynamicTableData', Html);

     return false; 
}).on('click','.jFormSearch .jSearchExpand',function(){
   $(this).closest('.jFormSearch').toggleClass('ActiveExpand');

}); 

function ExportSearchFormData() {
    const dataArray = {};
    const url = new URL(window.location.href);
    const params = new URLSearchParams(url.search);

    for (const [key, value] of params.entries()) {
        if (dataArray.hasOwnProperty(key)) {
            if (!Array.isArray(dataArray[key])) {
                dataArray[key] = [dataArray[key]];
            }
            dataArray[key].push(value);
        } else {
            dataArray[key] = value;
        }
    }

    return dataArray;
}


function ExportFilesFromAjax(resp,_form){ 

    const _LinkFile = resp?.Data?.LinkFiles;
    if(_LinkFile){

        var $a = $("<a>");
        $a.attr("href",_LinkFile); 
        $("body").append($a);
        $a.attr("download",_LinkFile); 
        $a[0].click();
        $a.remove();
        $('.jRockerPopup .jClose').trigger('click'); 
        
        var _reload = resp?.Data?.Reload;
        if(_reload){
            hp_Reload();
        }
    }
}
function rfh_AfterSubmitForm(resp,_form){  
    if(resp?.RespondRocker){ 
        var DetailsMessage  = resp.DetailsMessage,
            Message         = resp.Message;
            if(DetailsMessage) 
            RockerMessage('Success',Message,DetailsMessage); 
    } 

    if(resp?.Data?.IsFreeAdd){
        rfh_FreeAddAfterSubmit(_form,resp);
    }else   if(resp?.Data?.Link){
        /*
        #pending: đang bị lỗi, khi submit view Edit trong view có tabCat thì ra ngoài tự filter Cat
        if($('.js-Tab').length){
            let _Param = ($('.js-Tab').attr('paramname'));
            let _CurCat = $('.js-Tab-nav-items.active').attr('setvalue');
            resp.Data.Link = hp_replaceParam(_Param,_CurCat,resp.Data.Link); 
        }
        */
        hp_ToLink(resp.Data.Link);
    }else if($('.jRockerPopup.active').length || !_form.attr('no-reloadupdate')){ 
        hp_Reload();
    }
}
function CallDynamicAddBoard(_DynamicKey){
    var Html = dtl_GetAniHtml('DynamicSmallData/Edit_ShowBoard', {'DynamicKey': _DynamicKey,'Action':$('#MainPageContainer').data('action')}); 
   
    CallRockerPopup('DynamicSmallDataPopup', Html);
    
}
function DynamicSmallDataAfterSubmit(resp){
    const _Data = resp.Data; 
    const DynamicKey = _Data.DynamicKey;
    const _Id   = _Data.Id;
    const _Name = _Data.Name;

    var _Input = $('[dynamickey="'+DynamicKey+'"]').closest('.jFrmInput');
    const _InputType = _Input.data('type');

    if(_InputType=='Select'){ 
        var option = new Option(_Name, _Id);
            _Input.find('select.jEle').append(option); 
            _Input.find('select.jEle').val(_Id).trigger("change")
    }
    $('.jRockerPopup .jClose').trigger('click'); 
}
 
function checkParentHidden(element, recursionCount,_Check) {
    if (recursionCount <= 0){
        _Check = false;
    }  
    if(!_Check)return _Check;  
    var parent = element.parent('div');
    var _CheckIsTab = parent.hasClass('js-Tab-content');   
    if (!_CheckIsTab&&parent.length > 0) {
        var computedStyle = window.getComputedStyle(parent[0]);  
        if (computedStyle.display == "none") { 
            _Check =  true;
        } else { 
            _Check = checkParentHidden(parent, recursionCount - 1,_Check);
        }
    } else {
        _Check = false;
    }
    return _Check;
}
function fvd(_Frm) { 

    let r = _Frm;
    _Frm.find('.jFrmInput').removeClass('Warning'); 

    let _Error = false;
    _Frm.find('.jFrmInput.jFVD').each(function(){

        let _InputItem = $(this),
            _Input     = $(this).find('.jEle'),
            _LabelText = $(this).find('.jFrmLabel').data('label');

        let _Required     = _InputItem.data('required'),
            _RequiredType = _InputItem.data('required-type'),
            _InputType    = _InputItem.data('type'),
            _MinLength    = _InputItem.data('mile'),
            _MaxLength    = _InputItem.data('male');

 
        const closestTab = _InputItem.closest('.js-Tab-content');
        const closestLgTab = _InputItem.closest('.js-LgTab-content');/*Language Tab*/

        var _ItemValue = '';
        var _ErrorText = '';

        if(_InputItem.is(":hidden")){
            let _tmrt = true;
            if((closestLgTab.length&&closestLgTab.is(":hidden"))||closestTab.length&&closestTab.is(":hidden")){ 
                var computedStyle = window.getComputedStyle(this);
                if(computedStyle.display=='none'){ 
                    return true;
                } 
                /*Check trường hợp Input nằm trong một Div ẩn, không phải là Tab*/
                let recursionCount = 6;
                var _CheckParentHidden = checkParentHidden(_InputItem,recursionCount,true);
                /*ed Check trường hợp Input nằm trong một Div ẩn, không phải là Tab*/
                if(!_CheckParentHidden){
                    _tmrt = false;
                }   
            }
            if(_tmrt) return true; 
        }
        if(_InputItem.hasClass('HasDisableInputCheck')){
            var _jValCheck = _InputItem.find('.jValCheck').val();
            if(_jValCheck) return true;
        }
        if(_InputItem.hasClass('HasEnableInputCheck')){
            var _jValCheck = _InputItem.find('.jValCheck').val();
            if(_jValCheck) return true;
        }
 
        if(_Required||_RequiredType){ 
            _ErrorText = 'Cần Nhập'; 
            if(_InputType=='Select'){ 
                _ItemValue = _Input.find(":selected").val();
                _ItemValue = (_ItemValue&&_ItemValue!=0)?_ItemValue:''; 
                _ErrorText = 'Cần Chọn'; 
            }else if(_InputType=='Radio'||_InputType=='TreeRadio'||_InputType=='TreeRadioExpand'||_InputType=='CheckListContent'||_InputType=='SelectListContent'||_InputType=='StatusCheckList'){  
                if($(this).find('input[type="radio"]:checked').length){
                    if ($(this).find('input[type="radio"]:checked').length <= 0) {
                        _ErrorText = 'Cần Chọn'; 
                    }else{
                        _ItemValue = $(this).find('input[type="radio"]:checked').val(); 
                    } 
                }else{
                    if ($(this).find('input[type="checkbox"]:checked').length <= 0) {
                        _ErrorText = 'Cần Chọn'; 
                    }else{
                        _ItemValue = $(this).find('input[type="checkbox"]:checked').val(); 
                    } 
                }
                
                 
            }else if(_InputType=='TreeCheckBox'||_InputType=='TreeCheckBoxList'||_InputType=='CheckBox'){  
                
                if ($(this).find('input[type="checkbox"]:checked').length <= 0) {
                    _ErrorText = 'Cần Chọn'; 
                }else{
                    _ItemValue = $(this).find('input[type="checkbox"]:checked').val(); 
                } 
                 
            }else if(_InputType=='FromToText'||_InputType=='FromToNumber'){   
                let _tmpAddVal = '';
                let _tmpCheckNoval = false;

                let _Label_PlaceHolder = '';

                _Input.each(function(ei){ 
                   if(!$(this).val().trim()){
                    _ItemValue = $(this).val().trim(); 
                    _tmpCheckNoval = true;
                    _Label_PlaceHolder = $(this).attr('placeholder');
                    return false;
                   }else{
                    _tmpAddVal = $(this).val().trim(); 
                   }
                });  
                if(!_tmpCheckNoval){
                    _ItemValue = _tmpAddVal;
                }
                _LabelText = (_Label_PlaceHolder)?_Label_PlaceHolder:_LabelText;

            }else if(_InputType=='ImageUpload'){
                _ItemValue = $(this).find('.js-InputFile').val();  
            }else if(_InputType=='MultiUpload'){
                _ItemValue = $(this).find('.jInpMultiForGet').val();  
            }else{
                _ItemValue = _Input.val();
            }
            _ItemValue = (_ItemValue)?_ItemValue.trim():'';
            _ErrorText = _ErrorText+' '+_LabelText;

            if(_Required&&!_ItemValue){
                CallErrorTags(_InputItem,_ErrorText);
                _Error = true;
                return false;              
            }
            if(_InputType=='FromToNumber'){
                var _AcceptZeroValue = _Input.attr('acceptzero'); 

                let _tmpErrorNumber = false;
               
                _Input.each(function(ei){
                    let _tmpNumberValue =  $(this).val().trim();

                    if(_tmpNumberValue&&_AcceptZeroValue=='2'&&Hp_isNumber(_tmpNumberValue)&&_tmpNumberValue<=0){
                         _tmpErrorNumber = true;
                    }
                });
                if(_tmpErrorNumber){
                    _ErrorText = _LabelText+' '+translator.getStr('NotYetValid');
                    CallErrorTags(_InputItem,_ErrorText);
                    _Error = true;
                    return false; 
                }


            }else if((_InputType=='Number'&&_Required)||_RequiredType=='Number'){
                var _AcceptZeroValue = _Input.attr('acceptzero');  

                if(_Input.hasClass('jIsNumberic')&&_Input.hasClass('IsSet')){
                 _ItemValue = _Input.data('autoNumericInstance').getNumber();
                }else{
                    _ItemValue = _Input.val();
                }

                var tmp_NumberValue = parseFloat(_ItemValue);
      
                if(_ItemValue&&_AcceptZeroValue=='2'&&Hp_isNumber(tmp_NumberValue)&&tmp_NumberValue<=0){
                  
                    _ErrorText = _LabelText+' '+translator.getStr('NotYetValid');
                    CallErrorTags(_InputItem,_ErrorText);
                    _Error = true;
                    return false; 
                }
            }
            
        }
        if(!_Error&&_ItemValue&&(_MinLength||_MaxLength)){
                let _StrLength = _ItemValue.length; 
            if(_Input.hasClass('jIsNumberic')){
                _StrLength = _ItemValue.replace(/[^0-9]/g, '').length;  
            }  
            

            if(_MinLength&&_StrLength<_MinLength){
                _ErrorText = _LabelText+' '+translator.getStr('MinLength',_MinLength);
                CallErrorTags(_InputItem,_ErrorText);
                _Error = true;
                return false; 
            }  

            if(_MaxLength&&_StrLength>_MinLength){
                _ErrorText = _LabelText+' '+translator.getStr('MaxLength',_MaxLength);
                CallErrorTags(_InputItem,_ErrorText);
                _Error = true;
                return false; 
            }
        }

        if(!_Error&&_InputType=='FromToText'){

            let _ErrorMinMaxFromTo = false;
            let _LengError = '';
            let _Label_PlaceHolder = '';

            _Input.each(function(ei){
                let _thisMinLength = $(this).data('mile');
                let _thisMaxLength = $(this).data('male');

                if(_thisMinLength||_thisMaxLength){

                    let _tmpStrLength = ($(this).val())?$(this).val().length:0;
                    if(_thisMinLength&&_tmpStrLength<_thisMinLength){
                        _ErrorMinMaxFromTo = 'MinLength';
                        _LengError = _thisMinLength;
                        _Label_PlaceHolder = ($(this).attr('placeholder'));
                        return false;
                    }

                    if(_thisMaxLength&&_tmpStrLength>_thisMaxLength){
                        _ErrorMinMaxFromTo = 'MaxLength';
                        _LengError = _thisMinLength;
                        _Label_PlaceHolder = ($(this).attr('placeholder'));
                        return false;
                    }

                }   
            });

            if(_ErrorMinMaxFromTo) {
                _Label_PlaceHolder = (_Label_PlaceHolder)?_Label_PlaceHolder:_LabelText;

                _ErrorText = _Label_PlaceHolder+' '+translator.getStr(_ErrorMinMaxFromTo,_LengError);
                CallErrorTags(_InputItem,_ErrorText);
                _Error = true;
                return false; 
            }
        }


        if((!_Error&&_RequiredType&&_ItemValue) || _ItemValue==0){ 
            if(_RequiredType==='Number'){ 
                if(!Hp_isNumber(_ItemValue)){
                    _ErrorText = _LabelText+' '+translator.getStr('NotYetValid');
                    CallErrorTags(_InputItem,_ErrorText);
                    _Error = true;
                    return false; 
                }

           
            }else if(_ItemValue&&_RequiredType==='Phone'){ 
                if(!PhoneValidate(_ItemValue)){  
                    _ErrorText = _LabelText+' '+translator.getStr('NotYetValid');
                    CallErrorTags(_InputItem,_ErrorText);
                    _Error = true;
                    return false; 
                }
            }else if(_ItemValue&&_RequiredType==='Email'){ 
                if(!EmailValidate(_ItemValue)){  
                    _ErrorText = _LabelText+' '+translator.getStr('NotYetValid');
                    CallErrorTags(_InputItem,_ErrorText);
                    _Error = true;
                    return false; 
                }
            }
        }
    });

    return (_Error)?false:true;
}
function  DmyValidate(str, separator = '-',_helperformat=false) {
    /*Validate Day/Month/Year*/
    /*_helperformat = true => change month -> day and reverse when month > 12*/

    var getvalue = str.split(separator);
    var day = parseInt(getvalue[0]);
    var month = parseInt(getvalue[1]);
    var year = parseInt(getvalue[2]);
    if(year < 1901 || year > 2100){
       return false;
    }
    if(_helperformat){
      /*when format mdy covert to dmy*/
        if (month < 1 || month > 12) { 
           let _tmp = day;
           day = month;
           month = _tmp;
        } 
    }

    if (month < 1 || month > 12) { 
       return false;
    }
    if (day < 1 || day > 31) {
       return false;
    }
    
    
    if ((month==4 && month==6 && month==9 && month==11) && day==31) {
       return false;
    }
    if (month == 2) { /* check for february 29th*/
       var isleap = (year % 4 == 0 && (year % 100 != 0 || year % 400 == 0));
       if (day>29 || (day==29 && !isleap)) {
          return false;
       }
    }
    else{
       return true;
    }
    return true;  
  }
 
function EmailValidate(_Email){ 
    var email_regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i; 
    return email_regex.test(_Email);
  }
function PhoneValidate(_Phone){  
    var mobile_regex = /((09|03|07|08|05|02)+([0-9]{8})\b)/g;
    var phone_regex = /((02)+([0-9]{9})\b)/g; /*/((02)+([0-9]{9})\b)/g;*/  
    var phone_foreign1 = /((1)+(808)+([0-9]{7})\b)/g;

    var phone_foreign2 = /((00140|0140)+([0-9]{8})\b)/g;

    let testphone   = phone_regex.test(_Phone.replace(/\D/g, ''));
    let testmobile  = mobile_regex.test(_Phone.replace(/\D/g, '')); 

    let testforeign1 = phone_foreign1.test(_Phone.replace(/\D/g, '')); 

    let testforeign2 = phone_foreign2.test(_Phone.replace(/\D/g, '')); 
 
    return (testphone||testmobile||testforeign1||testforeign2)?true:false; 
  }

function ErrorTags(_Text){
    return '<div class="ErrorTags nslt" ><i class="fal fa-exclamation-triangle"></i><div class="arrow"></div>'+_Text+'!</div>';
}

function CallErrorTags(_InputItem, _TextError = '') {
  var closestBody = _InputItem.closest('.jRockerPopup');/*jpBody*/
  const closestTab = _InputItem.closest('.js-Tab-content');
  const closestLgTab = _InputItem.closest('.js-LgTab-content');/*Language Tab*/
 

  let errorTags = ErrorTags(_TextError); 
  
  closestBody = (closestBody.length)?closestBody:_InputItem.closest('.jScrollArea');



  if (closestTab.length && !closestTab.hasClass('active')) {
    let nav = closestTab.data('nav');
    $(nav).trigger('click');
  }
  if (closestLgTab.length && !closestLgTab.hasClass('active')) {
    let nav = closestLgTab.data('nav');
    $(nav).trigger('click');
  } 

  _InputItem.find('.ErrorTags').remove();
  _InputItem.append(errorTags);
   
  setTimeout(function(){
    if (closestBody.length&&Hp_isElementOffContainer(closestBody,_InputItem.find('.ErrorTags'))) { 
         _InputItem.find('.ErrorTags').addClass('eBottom');
    }else if(_InputItem.find('.ErrorTags').hasClass('eBottom')){
        _InputItem.find('.ErrorTags').removeClass('eBottom');
    }
    _InputItem.addClass('Warning');
    const audio = new Audio('./refer/ast/sound/wrong2.mp3'); audio.play(); 

    if(!_InputItem.hp_isInViewport()){ 
        if(closestBody.length){
            Hp_scrollToElement(closestBody,_InputItem);
        }else{
            Hp_scrollToElement($('html'),_InputItem,(-240));
        }  
    }else if(!_InputItem.hp_isInViewParent(closestBody)){
        Hp_scrollToElement(closestBody,_InputItem);
    }

  },20);
}

function rfh_FreeAddAfterSubmit(_Frm,resp){
    const _IsFreeAdd = resp.Data.IsFreeAdd; 
    const _Modules = _Frm.attr('refer'); 
    if(_Modules=='ExpandField'){
        const _ExpandShortForm  = resp.Data.ExpandShortForm;
        let _LangList     = resp.Data.LangList; 
        if(_LangList){
            for (var i = _LangList.length - 1; i >= 0; i--) {  
                _KeyLang = _LangList[i]['KeyLanguage']; 
                let _ItemInput = _ExpandShortForm[_KeyLang]; 
                $('.js-SortAddItems-'+_KeyLang).append(_ItemInput); 
                 
            }
        } 
    }
    _Frm.closest('.jRockerPopup').find('.jESC').trigger('click');

}



$('body').on('keyup keydown','.js-TextareaTrigger-txt',function(){ 
    var _parent = $(this).closest('.js-TextareaTrigger');
    var _thisvalue = $(this).val(); 
    _parent.find('.js-show-txt').text(_thisvalue);   
}).on('click',function (e)
{ 
    var ctNote = $(".js-TextareaTrigger.active"); 
    if (!ctNote.is(e.target) && ctNote.has(e.target).length === 0)
    {
      ctNote.removeClass('active');
      var _input      = ctNote.find('.js-TextareaTrigger-txt');
      var _showtxt    = ctNote.find('.js-show-txt'); 
      var value       = _input.val();
      var _defaulftxt = _showtxt.attr('text-defaulf');
      if(!value) _showtxt.text(_defaulftxt);
    }  
}).on('click','.js-TextareaTrigger-calls',function(){
 
    $('.js-TextareaTrigger').removeClass('active');     
    var _parent = $(this).closest('.js-TextareaTrigger'); 
    _parent.addClass('active'); 
}).on('keyup keydown change','.jFrmCompactNumber .jEle',function(){  
    const _value = $(this).data('autoNumericInstance').getNumber();
    const _FrmInput = $(this).closest('.jFrmInput');
    if(!_value||_value<10_000_000){
        _FrmInput.removeClass('ActiveFrmBottomLabel');
    }else if(!_FrmInput.hasClass('ActiveFrmBottomLabel')){
        _FrmInput.addClass('ActiveFrmBottomLabel');
    }
    const _BottomLabel = $(this).closest('.jFrmInput').find('.jFrmBottomLabel');
    const _CompactValue = hp_CompactNumber(_value);
    _BottomLabel.text(_CompactValue); 

});


$(document).on('keydown',function(event){
    
    if(event.which == 27){ 
        $('.jESC').trigger('click');
        /*LETTER --> condition private*/
    }

    else if(event.which == 13){ 
        /*ENTER*/
        $('.jEnter').trigger('click'); 
    }

    else if(event.which == 113){ 
        if($('.jTriggerClick-F2').length) $('.jTriggerClick-F2').trigger('click');
        $('.jFocus-F2').focus();
    }
    else if(event.which == 114){ 
        $('.jFocus-F3').focus();
    }
    else if(event.which == 115){ 
        $('.jFocus-F4').focus();
    }
    else if(event.which == 116){ 
        $('.jFocus-F5').focus();
    }
    else if(event.which == 117){ 


        $('.jFocus-F6').focus();
    }
    else if(event.which == 118){ 
        $('.jFocus-F7').focus();
    }
    else if(event.which == 119){ 
        $('.jFocus-F8').focus();
    }
    else if(event.which == 120){ 
        $('.jFocus-F9').focus();
    }
    else if(event.which == 121){ 
        $('.jFocus-F10').focus();
    }
    else if(event.which == 122){ 
        $('.jFocus-F11').focus();
    }
    else if(event.which == 123){ 
        $('.jFocus-F12').focus();
        /*LETTER --> condition private*/
    }

});
 



function Frm_ReFormatDataForm1_BeforSubmit(_form,dataForm){
    /*for Form has Data:-> new FormData(this)*/
    dataForm = Numberic_ClearNumberFormat1(_form,dataForm);
    dataForm = Frm_AddInputFiles(_form,dataForm);
    return dataForm;
}
function Numberic_ClearNumberFormat1(_form,dataForm){
    /*for Form has Data:-> new FormData(this)*/
    _form.find('.jIsNumberic').each(function(){
        let _InputValue = String($(this).data('autoNumericInstance').getNumber()),
            _InputName  = $(this).attr('name'); 
            /*_InputValue = Numberic_Format(_InputValue);  */
            dataForm.set(_InputName,_InputValue); 
    }); 
    return dataForm;
}
function Frm_AddInputFiles(_frm,n){
    if(_frm.find('input[type="files"]').length){
      _frm.find('input[type="files"]').each(function(){
        /*n.append('LinkCV', $(this)[0].files[0]);*/
        n.append($(this).attr('name'), $(this)[0].files[0]);/*#001:close*/
      });
    }
    return n;
}

/*---------------*/
function Frm_ReFormatDataForm2_BeforSubmit(_form,formValues){
    /*for Form has Data:-> serializeArray*/
    /*for Form has Data:-> serializeArray*/ 
    formValues.forEach((field) => { 
      if(_form.find('[name="'+(field.name)+'"]').hasClass('jIsNumberic')){
       field.value = Numberic_Format(field.value);  
      }else if(_form.find('[name="'+(field.name)+'"][data-dateformat="DD-MM-YYYY"]').hasClass('jDay')){
        field.value = Frm_FormatDay(field.value);
      }
    });
    return formValues; 
}

 
/*-------*/

function Frm_FormatDay(_DayString=null){
    /*Day to YYYY-MM-DD*/
    if(!_DayString) return _DayString;
 
    let dateParts = _DayString.split("-");
    let originalDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]); 
    let newDateStr = originalDate.getFullYear() + "-" + ("0" + (originalDate.getMonth() + 1)).slice(-2) + "-" + ("0" + originalDate.getDate()).slice(-2);
    return newDateStr; 

}
function Frm_GetCheckBoxValue(_ItemClass){ 
    /*get value of check box*/
    var checkedValues = []; 
    _ItemClass.find('input[type="checkbox"]').each(function() { 
        if ($(this).is(':checked')) {
            checkedValues.push($(this).val()); /* Thêm giá trị của checkbox đã chọn vào mảng*/
        }
    });
    return checkedValues;
}

/*bg DynamicList*/

$(document).on('click','.js-rmDy',function(){
  let _Parent = $(this).closest('.js-rDyna'),
      _DynamicContent = $(this).closest('.js-DynamicContent'),
      _TextContent = $(this).attr('data-content'); 
      _TextContent = (_TextContent)?_TextContent:'';

    $.confirm({
      title: translator.getStr('DeleteCofirm'),
      content: _TextContent,
      icon: 'lar la-question-circle',
      theme: 'supervan',
      closeIcon: false, 
      buttons: {
        ok: {
          text: translator.getStr('Delete'),
          action: function () {
            _Parent.remove();
            Dy_synstt(_DynamicContent); 
          }
        },
        cancle: {
          text: translator.getStr('Cancle'),
          action: function () { 
            
          }
        }

      } 
    });  
    /*Not accept return any*/

}).on('click','.js-add-rmDy',function(){
  let _Label = $(this).data('label'),
      _LinkView    = $(this).data('linkitemview'),
      _Tar   = $(this).closest('.js-DynamicContent'),
      _single = $(this).data('single'),
      _RowClass = $(this).data('rowclass'),
      _FieldNameParam = $(this).attr('fieldname-param'),
      _GroupKey = $(this).data('groupkey');

  if(_single){
    Dy_LoadRmDy(_LinkView,1,_Tar,_RowClass,_GroupKey,_FieldNameParam); 
  }else{
      $.confirm({
        title: '',
        content: '' +
        '<form action="" class="formName">' +
        '<div class="form-group">' +
        '<label>'+translator.getStr('Enter')+' Số lượng '+_Label+'</label>' +
        '<input type="text"  class="j-val form-control" required />' +
        '</div>' +
        '</form>',
        theme: 'supervan',
        buttons: {
            formSubmit: {
                text: translator.getStr('AddNew'),
                btnClass: 'btn-blue',
                action: function () {
                    var _ne = this.$content.find('.j-val').val();
                    if(!_ne){ 
                        this.$content.find('.j-val').focus();
                        return false;
                    }
                    Dy_LoadRmDy(_LinkView,_ne,_Tar,_RowClass,_GroupKey,_FieldNameParam)

                }
            },
            cancle: {
              text: translator.getStr('Cancle'),
              action: function () { 
                
              }
            }
        },
        onContentReady: function () {
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); 
            });
        }
    });
  }

  
}); 
function Dy_AfterHandleSort(_this,event,ui){
    Dy_synstt(_this.closest('.js-dcend'));
}
function Dy_synstt(_DynamicContent=''){
  let _i = 1;
  if(_DynamicContent.find('.js-rDyna').length){
    _DynamicContent.find('.js-rDyna').each(function(){
        $(this).find('.jSTT').empty().append(_i);
        _i++;
      }); 
      _DynamicContent.addClass('HasData');
       setTimeout(function(){
        hp_InitEx();
       },500);
  }else{
    _DynamicContent.removeClass('HasData');
  }
  
}
function Dy_LoadRmDy(_LinkView,_NumberRows,_DynamicContent,_Class,_GroupKey,_FieldNameParam){
  let Start = 0;
  _DynamicContent.find('.js-rDyna').each(function(){
    let _crs = parseInt($(this).data('key'));
    Start = (Start<_crs)?_crs:Start; 
  }); 
  $.ajax({
      url: site_url + 'RockerAjax/NoRequired_DynamicRow',
      type: 'GET',
      cache: false, 
      async: false,
      data: {  
          LinkItemView : _LinkView,
          NumRows:_NumberRows,
          Start:Start,
          RowClass:_Class, 
          GroupKey:_GroupKey,
          FieldNameParam:_FieldNameParam
      },
      success: function(resp){ 
       
        const _Html =  resp?.Data?.Html;
        
        if(resp?.Data?.Html){
            Html = resp.Data.Html; 
            _DynamicContent.find('.js-dcend').append(Html); 
            Dy_synstt(_DynamicContent);   
        } 
      }
   });
} 

/*bg DynamicList*/

























 
 