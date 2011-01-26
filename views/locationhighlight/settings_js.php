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