<?php
/**
 * Layers js file.
 * 
 * Handles javascript stuff related to layers controller
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Layers JS View
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */
?>
// Layers JS



function fillFields(id, layer_name, parent_id, layer_color, layer_file_old)
{
	$("#adminarea_id").attr("value", unescape(id));
	$("#name").attr("value", unescape(layer_name));
	$("#parent_id").val(unescape(parent_id));
}

function layerAction ( action, confirmAction, id )
{
	var statusMessage;
	var answer = confirm('Are You Sure You Want To ' 
		+ confirmAction)
	if (answer){
		// Set Category ID
		$("#adminarea_id_action").attr("value", id);
		// Set Submit Type
		$("#action_id").val(action);
		// Submit Form
		$("#layerListing").submit();
	}
}


function addNewLevelName()
{
	var nextLevel = $('#next_level').val();
	$('#nolevelnames').hide();
	
	$.get("<?php echo url::site() . 'admin/locationhighlight_settings/new_level_name/'; ?>"+nextLevel,
	function(data){
	
		$('#levelnametable').append(data);
		
	}); 
	
	$('#next_level').val( parseInt(nextLevel)+1);
	return false;
}

//saves a level name
function saveLevelName(level)
{
	var levelName = encodeURIComponent($('#level_name_form_'+level).val());
	
	$.get("<?php echo url::site() . 'admin/locationhighlight_settings/save_level_name/'; ?>"+level+"/"+levelName,
	function(data){
	
		//do something?
		
		level_status_msg = $('#name_level_status'+level);
		level_status_msg.html("<span style=\"background:#aaeeaa; border:solid 1px #88dd88; float:right; padding:5px;\">Saved</span>");
		timeOutStr = "$('#name_level_status"+level+"').html(\"\");";
		setTimeout(timeOutStr, 3000);
	}); 
	return false;
}

//deletes a level name
function deleteLevelName(level)
{
	//set the value of what action we want to happen
	$('#level_action').val('delete');
	//the level we want to delete
	$('#next_level').val(level);
	
	//submit all of this
	$("#layerListing").submit();
}


/****Cities****/

function addNewCity()
{
	if( $('#city_name_A').attr("name"))
	{
		alert("<?php echo Kohana::lang('layer.already_new_city');?>");
	}
	$('#nocitynames').hide();
	
	$.get("<?php echo url::site() . 'admin/locationhighlight_settings/new_city'; ?>",
	function(data){
	
		$('#citytable').append(data);
		setSaveDelFunctions();
		
	}); 
	return false;
}

function setSaveDelFunctions()
{
		//saves a level name
	$("a[id^='save_city_btn_']").click(function()
	{	
	    var id = this.id.substring(14);
		var cityName = $('#city_name_'+id).val();
		var admin_id = $('#city_adminarea_'+id+' option:selected').val();
		var lat = $('#city_lat_'+id).val();
		var lon = $('#city_lon_'+id).val();
		
		$.ajax({url: "<?php echo url::site() . 'admin/locationhighlight_settings/save_city/'?>",
			   dataType: "html",
			   data: {"name":cityName, "admin_id":admin_id, "lat":lat, "lon":lon, "id":id},
			   type:"POST", 
			   success:
				function(data){
					level_status_msg = $('#city_status_'+id);
					level_status_msg.html("<span style=\"background:#aaeeaa; border:solid 1px #88dd88; float:right; padding:5px;\">Saved</span>");
					timeOutStr = "$('#city_status_"+id+"').html(\"\");$('#city_status_"+data+"').html(\"\");";				
					setTimeout(timeOutStr, 3000);
					
					//if ID = a then we need to update that
					if(id == 'A')
					{
						$('#city_name_A').attr("name","city_name_"+data);
						$('#city_name_A').attr("id","city_name_"+data);
						
						$('#city_adminarea_A').attr("name","city_adminarea_"+data);
						$('#city_adminarea_A').attr("id","city_adminarea_"+data);
						
						$('#city_lat_A').attr("name","city_lat_"+data);
						$('#city_lat_A').attr("id","city_lat_"+data);
											
						$('#city_lon_A').attr("name","city_lon_"+data);
						$('#city_lon_A').attr("id","city_lon_"+data);
						
						$('#city_status_A').attr("id","city_status_"+data);
						
						$('#save_city_btn_A').attr("id","save_city_btn_"+data);
	
						$('#del_city_btn_A').attr("id","del_city_btn_"+data);
						
					}
					
		}}); 
		return false;
	});
	
	//deletes a city
	$("a[id^='del_city_btn_']").click(function()
	{
	    var id = this.id.substring(13);
		$.ajax({url: "<?php echo url::site() . 'admin/locationhighlight_settings/del_city/'?>",
			   dataType: "html",
			   data: {"id":id},
			   type:"POST", 
			   success:
				function(data){
						$('#city_row_'+id).remove();			
		}}); 
		return false;  
	});
}


jQuery(function() {
	setSaveDelFunctions();
});



