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
		setTimeout("level_status_msg.html(\"\");", 3000);
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