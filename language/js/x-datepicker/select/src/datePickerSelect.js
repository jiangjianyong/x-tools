/**
 *
 * 时间选择插件
 * jquery.select v1.0.1
 * 事件绑定在 class="date_picker" 上
 */
jQuery.fn.extend({
  datePickerSelect: function(settings) {
  	
  	/* function */
  	var Dates = {}, HtmTools = {}, EventTools = {};
  	Dates.gcaches = {};
  	//判断闰年
	Dates.isleap = function(year){
	    return year && ( (year%4 === 0 && year%100 !== 0) || year%400 === 0 );
	};

	Dates.splitDates = function(_dateString){
  		if(!_dateString) return [];

  		if(Dates.gcaches[_dateString]){
  			return Dates.gcaches[_dateString];
  		}

  		var _tmp = _dateString.split('-');
  		for(var $i = 0; $i < _tmp.length; $i++){
  			_tmp[$i] = parseInt(_tmp[$i]) || 0;
  		}

  		Dates.gcaches[_dateString] = _tmp;
  		return _tmp;
  	};

  	Dates.values = {
  		min_year : function(options){
			var _tmp    = Dates.splitDates(options.min_date),
				dateObj = new Date();
  			return _tmp[0] || dateObj.getFullYear();
  		},
  		max_year : function(options){
  			var _tmp = Dates.splitDates(options.max_date),
				dateObj = new Date();
  			return _tmp[0] || dateObj.getFullYear() + 1;
  		},
  		min_month : function(options){
  			var min_month = 1,
				_tmp = Dates.splitDates(options.min_date);

			if(_tmp[1] && (_tmp[0] == options.year)){
				min_month = parseInt(_tmp[1]) || 1;
			}
			return min_month;
		},
		max_month : function(options){
			var _tmp 	  = null,
	  			max_month = 12;
			
			_tmp = Dates.splitDates(options.max_date);
			if(_tmp[1] && (_tmp[0] == options.year) ){
				max_month =  parseInt(_tmp[1]) || 12;
			}
			
			return max_month;
		},
		min_day : function(options){
	  		Dates.values.set_leap_year(options);
	  		var _tmp    = null,
	  			min_day = 1;

			_tmp = Dates.splitDates(options.min_date);
			if(_tmp[0] == options.year && _tmp[1] == options.month ){
				min_day	= parseInt(_tmp[2]) || 1;
			}
			return min_day;
		},
		max_day : function(options){
	  		Dates.values.set_leap_year(options);
	  		var _tmp    = null,
	  			max_day = options.days[options.month] || 12;

			_tmp = Dates.splitDates(options.max_date);
			if(_tmp[0] == options.year && _tmp[1] == options.month ){
				max_day	= parseInt(_tmp[2]) || 1;
			}

			return max_day;
		},
		set_leap_year : function(options){
			if(Dates.isleap(options.year)){
	  			options.days[2] = 29;
	  		}
		}
  	};

  	Dates.getYears = function(options){
  		var _tmp 	 = null, 
  			_years   = {},
  			min_year = Dates.values.min_year(options),
  			max_year = Dates.values.max_year(options);
  		
  		for(var $i = min_year; $i <= max_year; $i++){
  			_years[$i] = $i;
  		}
  		return _years;
  	};

  	Dates.getMonths = function(options){
  		var _tmp 	  = null,
  			_months   = {},
  			min_month = Dates.values.min_month(options),
  			max_month = Dates.values.max_month(options);

  		for(var $i = min_month; $i <= max_month; $i++){
  			_months[$i] = $i;
  		}
  		return _months;
  	};
  	
  	Dates.getDays = function(options){
  		var min_day = Dates.values.min_day(options),
  			max_day = Dates.values.max_day(options);

  		var _days = {};
  		for (var $i = min_day; $i <= max_day; $i++){
  			_days[$i] = $i;
  		}
  		return _days;
  	};

  	HtmTools.ObjectToLabelHtml = function(labelTpl, $object, $selectedValue){

  		var _optionBox = [], _tp = new HtmTools.easyTemplate(labelTpl);
  	
  		if(!$.isEmptyObject($object)){
  			for(var i in $object){
				_optionBox.push(_tp({
					value : i,
					title : $object[i],
					selected: $selectedValue
				}).toString());
  			}
  		}
  		
  		return _optionBox.length ? _optionBox.join('') : '';
  	};

  	HtmTools.easyTemplate = function(s,d){
	    if(!s){
			return '';
		}
	    
	    var separate = function(s){
	        var r = /\\'/g;
	        var sRet = s.replace(/(<(\/?)#(.*?(?:\(.*?\))*)>)|(')|([\r\n\t])|(\$\{([^\}]*?)\})/g,function(a,b,c,d,e,f,g,h){
	                if(b){return '{|}'+(c?'@':'+')+d+'{|}';}
	                if(e){return '\\\'';}
	                if(f){return '';}
	                if(g){return '\'+('+h.replace(r,'\'')+')+\'';}
	            });
	            return sRet;
	    };
	    
	    var parsing = function(s){
	            var mName,vName,sTmp,aTmp,sFL,sEl,aList,aStm = ['var aRet = [];'];
	            aList = s.split(/\{\|\}/);
	            var r = /\s/;
	            while(aList.length){
	                sTmp = aList.shift();
	                if(!sTmp){continue;}
	                sFL = sTmp.charAt(0);
	                if(sFL!=='+'&&sFL!=='@'){
	                    sTmp = '\''+sTmp+'\'';aStm.push('aRet.push('+sTmp+');');
	                    continue;
	                }
	                aTmp = sTmp.split(r);
	                switch(aTmp[0]){
	                    case '+et':mName = aTmp[1];vName = aTmp[2];break;
	                    case '@et':;break;
	                    case '+if':aTmp.splice(0,1);aStm.push('if'+aTmp.join(' ')+'{');break;
	                    case '+elseif':aTmp.splice(0,1);aStm.push('}else if'+aTmp.join(' ')+'{');break;
	                    case '@if':aStm.push('}');break;
	                    case '+else':aStm.push('}else{');break;
	                    default:break;
	                }
	            }
	            aStm.push('return aRet.join("");');
	            return [vName,aStm.join('')];
	    };
	    
	    if(s !== this.template){
	        this.template = s;
	        this.aStatement = parsing(separate(s));
	    }
	    
	    var aST = this.aStatement;
	    var process = function(d2){
	        if(d2){d = d2;}
	        return arguments.callee;
	    };
	    process.toString = function(){
	        return (new Function(aST[0],aST[1]))(d);
	    };
	    return process;
	};

	HtmTools.setResult = function(obj, options){
		var eventValueNode = $(obj).find('input[type=hidden]:eq(0)');
		eventValueNode.val(HtmTools.easyTemplate(options.resultTpl, options).toString());
		return true;
	};

	HtmTools.initDatePickerHtml = function(obj, options){
		var _datasInfo = {};
		_datasInfo.name  = options.name;
		_datasInfo.year  = (options.formatResult[0] == 'Y') ? HtmTools.ObjectToLabelHtml(options.labelTpl, Dates.getYears(options),  options.year) 	: '';
    	_datasInfo.month = (options.formatResult[1] == 'm') ? HtmTools.ObjectToLabelHtml(options.labelTpl, Dates.getMonths(options), options.month) 	: '';
    	_datasInfo.day 	 = (options.formatResult[2] == 'd') ? HtmTools.ObjectToLabelHtml(options.labelTpl, Dates.getDays(options),   options.day)  	: '';

    	// 解析模板
    	datePickerHtml = HtmTools.easyTemplate(options.tpl, _datasInfo).toString();
    	$(obj).html(datePickerHtml);
    	HtmTools.setResult(obj, options);
    	return true;
	};

	EventTools.initChangeEvent = function(that, options){
		try{
			$(that.find(options.year_node)).on(options.event_type, function(){
	    		options.year  = $(this).val();
	    		options.month = Dates.values.min_month(options);
	    		if(options.formatResult[2]) {
	    			options.day = Dates.values.min_day(options);
	    		}

	    		HtmTools.initDatePickerHtml(that, options);
	    		EventTools.initChangeEvent(that,  options);
	    	});
    	}catch(e){}

    	try{
	    	$(that.find(options.month_node)).on(options.event_type, function(){
	    		options.month = $(this).val();
	    		if(options.formatResult[2]) {
	    			options.day = Dates.values.min_day(options);
	    		}
	    		HtmTools.initDatePickerHtml(that, options);
	    		EventTools.initChangeEvent(that,  options);
	    	});
    	}catch(e){}

    	try{
	    	$(that.find(options.day_node)).on(options.event_type, function(){
	    		options.day = $(this).val();
	    		HtmTools.initDatePickerHtml(that, options);
	    		EventTools.initChangeEvent(that,  options);
	    	});
    	}catch(e){}
	};

    return this.each(function() { 
    	var options = {
	  		format		: 'Y-m',
	  		days		: [null, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31],
	  		year_node 	: '.date_picker:eq(0)',
	  		month_node 	: '.date_picker:eq(1)',
	  		day_node 	: '.date_picker:eq(2)',
	  		event_type 	: 'change',
  			min_date 	: '',
	  		max_date 	: '',
	  		date 		: '',
	  		year 		: 0,
	  		month 		: 0,
	  		day 		: 1,
	  		resultTpl 	: '<#et date_result datas>${datas.year}-${datas.month}<#if (datas.day) >-${datas.day}</#if></#et>',
	  		labelTpl 	: '<#et date_picker_label datas><option value="${datas.value}" <#if (datas.value==datas.selected)>selected</#if>>${datas.title}</option></#et>',
	  		tpl 	 	: '<#et date_picker datas><input type="hidden" name="${datas.name}" value=""/><select class="date_picker">${datas.year}</select><br/><select class="date_picker">${datas.month}</select> <#if (datas.day) ><br/> <select class="date_picker">${datas.day}</select></#if></#et>'
	  	};

	  	settings = settings || {};
	  	$.extend(options, settings);
  	
  		var that 	 = $(this),
			currOpts = that.data() || {};

    	$.extend(options, currOpts);
    	options.formatResult = options.format.split('-') || [];
    	options.year  = Dates.values.min_year(options);
    	options.month = Dates.values.min_month(options);
    	options.day   = Dates.values.min_day(options);

    	HtmTools.initDatePickerHtml(that, options);
    	EventTools.initChangeEvent(that,  options);
    	return true;
    });
  }
});