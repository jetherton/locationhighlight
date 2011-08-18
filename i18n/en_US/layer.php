<?php
/**
 *  Location Highlight English Language file
 *
 * This plugin was written for Ushahidi Liberia, by the contractors of Ushahidi Liberia
 * 2011
 *
 * @package  Location Highlight plugin
 * @author     Carter Draper <carjimdra@gmail.com>
 * 
 */

	$lang = array(
		'file'=>array('default'=>'File must be a KML or KMZ file'),
		'name'=>array('default'=>'Name must be between 3 and 80 characters long'),
		'clear' => 'Clear Map',
		'select' =>'Select',
		'update' => 'Update Map',
		'save'  => 'Save',
		'delete' => 'Delete',
		'admin' => 'Administrative area levels',
		'admin_explain' => 'Administrative area levels are the names given by a country to its administrative areas. For example, in the United States the top level administrative areas are called "states" and the next level down are called "counties." In Ghana the top level administrative areas are called "Regions" and the next level down is called "Districts."',
	    'add_edit_area' => 'Add/Edit Administrative Areas',
		'add_edit_area_explain' => 'Use this form to add a new addministrative area to your map. For example, in the United states if you wanted to add the state of California, you would enter its name and set the "Parent Admin Area" to "--Top Level--, since there are no higher administative areas than states in the US. <br/><br/>If you have a KML file for your administrative area you can uplaod it, but it is not required. ',
		'admin_area_name' => 'Administrative Area Name',
		'new' => 'Add New',
		'level' => 'Level',
		'level_name' => 'Level Name',
		'parent' => 'Parent Admin Area:',
		'area' => 'Administrative Areas',
		'for' => 'for',
		'cityname'=> 'City Name',
		'adminarea'=> 'Administrative Area City is in',
		'lat_long'=> 'Latitude, Longitude',
		'cities' => 'Cities',
		'newcity' => 'Add New City',
		'lat'=>'Latitude',
		'lon'=>'Longitude',
		'already_new_city' => 'There is already a new city that needs to be saved',
		'csv_upload' =>'Upload CSV data',
		'csv_upload_details'=>'CSV should have the following columns:<br/><br/>CITY_NAME,&lt;admin area 1&gt;,&lt;admin area 2&gt;,...&lt;admin area N&gt;,LAT, LON<br/><br/> Be sure to define your admin areas before running the import. You will also need to upload the KML files manually, sorry.<br/><br/> <strong>Take note:</strong> To reduce database load the importer does not check for duplication, use caution when importing data into a database that is not empty.',
		'kml_kmz_upload'=>'Upload KMZ/KML File*',
		'kml_kmz_upload_optional'=>'*It is optional to upload a KML/KMZ',
	
	);
?>
