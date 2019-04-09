(function($){
	
	'use strict';
	
	$('input.cs-boxshadow-text, input.wp-color-picker').on('change input propertychange paste', function(){
			
		var field_id = $(this).attr('data-field-id');
		var shadow_property = $(this).attr('data-shadow-property');
		var css_unit = $(this).attr('data-unit');
		
		if(typeof field_id === 'undefined')
			return;			
			
		$('code.cs-property-value[data-field-id="' + field_id + '"][data-shadow-property="' + shadow_property + '"]').text( $(this).val() + css_unit);
		
		var horizontal_length = $('input.cs-boxshadow-text[data-field-id="' + field_id + '"][data-shadow-property=horizontal-length]').val();
		var vertical_length = $('input.cs-boxshadow-text[data-field-id="' + field_id + '"][data-shadow-property=vertical-length]').val();
		var blur_radius = $('input.cs-boxshadow-text[data-field-id="' + field_id + '"][data-shadow-property=blur-radius]').val();
		var spread_radius = $('input.cs-boxshadow-text[data-field-id="' + field_id + '"][data-shadow-property=spread-radius]').val();
		var color = $('input[data-field-id="' + field_id + '"][data-shadow-property=color]').val();
		var opacity = $('input.cs-boxshadow-text[data-field-id="' + field_id + '"][data-shadow-property=opacity]').val();
		
		var rgba = cs_convertHex(color, opacity);
		
		var box_shadow  = horizontal_length + 'px ';
			box_shadow += vertical_length + 'px ';
			box_shadow += blur_radius + 'px ';
			box_shadow += spread_radius + 'px ';
			box_shadow += rgba;
		
		$('input[type=hidden][data-field-id="' + field_id + '"][id="box-shadow"]').val(box_shadow);
		
		$('div.cs-boxshadow-preview[data-field-id="' + field_id + '"] > .cs_box').css('box-shadow', box_shadow);
		$('code.cs-boxshadow-code[data-field-id="' + field_id + '"]').show().text('box-shadow: ' + box_shadow);
		
	});
	
	var interval; 

	$('button.cs-boxshadow-plus').mousedown(function(e){
		e.preventDefault();
		var field_id = $(this).attr('data-field-id');
		var shadow_property = $(this).attr('data-shadow-property');
		interval = setInterval(function(){ 
			$('input[type=range][data-field-id="'+field_id+'"][data-shadow-property="'+ shadow_property +'"]')[0].stepUp(1);
		}, 50);
	}).mouseup(function(){
		var field_id = $(this).attr('data-field-id');
		var shadow_property = $(this).attr('data-shadow-property');
		clearInterval(interval);
		$('input[type=range][data-field-id="'+field_id+'"][data-shadow-property="'+ shadow_property +'"]').trigger('change');
	});		

	$('button.cs-boxshadow-minus').mousedown(function(e){
		e.preventDefault();
		var field_id = $(this).attr('data-field-id');
		var shadow_property = $(this).attr('data-shadow-property');
		interval = setInterval(function(){ 
			$('input[type=range][data-field-id="'+field_id+'"][data-shadow-property="'+ shadow_property +'"]')[0].stepDown(1);
		}, 50);
	}).mouseup(function(){
		var field_id = $(this).attr('data-field-id');
		var shadow_property = $(this).attr('data-shadow-property');
		clearInterval(interval);
		$('input[type=range][data-field-id="'+field_id+'"][data-shadow-property="'+ shadow_property +'"]').trigger('change');
	});		
	
})( jQuery );

function cs_convertHex(hex, opacity){
	
    hex = hex.replace('#', '');
	
    red = parseInt(hex.substring(0,2), 16);
    green = parseInt(hex.substring(2,4), 16);
    blue = parseInt(hex.substring(4,6), 16);

   	return 'rgba(' + red + ',' + green + ',' + blue + ',' + opacity + ')';
		
}
