// JavaScript Document
function abbreviate(){
	list = CRM.SmartyStreets.json_abbreviate;
	cj.each(list, function(key, value) {  
	  cj("select option:contains("+value+")").val(key);
	});
}
	
function idSwitch(){
	list = CRM.SmartyStreets.json_states;
	cj.each(list, function(key, value) {  
	  cj("select option:contains("+value+")").val(key);
	});
}
	
function checkScripts(){
	var loaded = 0;
}
	
function loadScripts(loaded){
	if (loaded != 1){
		alert(loaded);
	  cj.getScript(CRM.SmartyStreets.plugin)
			.done(function(){
				cj.getScript(CRM.SmartyStreets.helper)
					.done(function(){
						loadSmartyStreets();
					});
			}); 
	} 
}
	
function buildAddresses(){
	var addresses = [];
	cj("input[name*=\'street_address\']").each(function(){
	  var id = cj(this).attr("id");
	  var pre = id.split("street_address");
	  var prefix = pre[0];
	  var postfix = pre[1];
	  if(prefix.indexOf("address") >= 0){
	  	var state = "state_province_id";
	  } else {
	  	var state = "state_province";
	  }
	  addresses.push({
	  	id: id, 
	  	street: "#"+prefix+"street_address"+postfix, 
	  	city:  "#"+prefix+"city"+postfix, 
	  	state:  "#"+prefix+state+postfix,  
	  	zipcode:  "#"+prefix+"postal_code"+postfix
	  });
	  var zipcode = "#"+prefix+"postal_code"+postfix;
	});	
	return addresses;
}
	
function loadSmartyStreets(){
	if(cj("input[name*=\'street_address\']").length == 0){
		return;
  }
	var liveaddress = cj.LiveAddress({
	   	key: CRM.SmartyStreets.settings.HTML_KEY,
	    debug: CRM.SmartyStreets.settings.debug,
	   	autoVerify: CRM.SmartyStreets.settings.auto_verify,
	   	invalidMessage: CRM.SmartyStreets.settings.invalid,
	   	ui: CRM.SmartyStreets.settings.UI,
	   	geolocate: CRM.SmartyStreets.settings.geolocate,
	   	ambiguousMessage: CRM.SmartyStreets.settings.ambiguous,
	   	autocomplete: CRM.SmartyStreets.settings.autocomplete,
	   	candidates: CRM.SmartyStreets.settings.candidates,
	   	addresses: buildAddresses(),
	  });
liveaddress.on("Completed", function(event, data, previousHandler){
	if(cj(".crm_postal_code_suffix").length > 0 && cj('.crm_postal_code').val().length > 6){
		//alert("suffix");
		 cj(".crm_postal_code_suffix").val(cj(".crm_postal_code").val().slice(-4));
	   cj(".crm_postal_code").val(cj(".crm_postal_code").val().slice(0,5));
	   previousHandler(event, data);
	 }
});
cj(window).trigger('resize');
cj.ajaxSetup({ cache: true });
abbreviate();
cj("form").submit(function(){
	idSwitch();
});
return;
};
cj(document).ready(function(){
	loadSmartyStreets();
	cj("input").click(function(){
			cj(window).trigger('resize');
	});
});


var loaded = 0;
cj(document).ajaxComplete(function(){
	loadScripts(loaded);
	loaded = 1;
});