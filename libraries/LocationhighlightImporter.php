<?php
/**
 * Report Importer Library
 *
 * Imports reports within CSV file referenced by filehandle.
 * 
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com>
 * @package    Ushahidi - http://source.ushahididev.com
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL)
 *
 */
class LocationhighlightImporter {
	
	function __construct() 
	{
		$this->notices = array();
		$this->errors = array();		
		$this->totalrows = 0;
		$this->importedrows = 0;
		$this->incidents_added = array();
		$this->categories_added = array();
		$this->locations_added = array();
		$this->incident_categories_added = array();
		$this->adminAreas = array();
		$this->areasArray = array();
	}
	
	/**
	 * Function to import CSV file referenced by the file handle
	 * @param string $filehandle
	 * @return bool 
	 */
	function import($filehandle) 
	{
		$csvtable = new Csvtable($filehandle);

		// Set the required columns of the CSV file
		$requiredcolumns = array('CITY_NAME','LAT', 'LON');
		/*
		foreach ($requiredcolumns as $requiredcolumn)
		{
			// If the CSV file is missing any required column, return an error
			if (!$csvtable->hasColumn($requiredcolumn))
			{
				$this->errors[] = 'CSV file is missing required column "'.$requiredcolumn.'"';
			}
		}
		
		if (count($this->errors))
		{
			return false;
		}
		*/

		
		$rows = $csvtable->getRows();
		$this->totalrows = count($rows);
		$this->rownumber = 0;
		
		//figure out what the admin area names are
		$adminAreaDb = ORM::factory("adminareas_level_names")->orderby('level', 'asc')->find_all();
		
		foreach($adminAreaDb as $a)
		{
			$this->adminAreas[$a->level] = $a->name;
		}
	 	
		// Loop through CSV rows
	 	foreach($rows as $row)
	 	{
			$this->rownumber++;
			if ($this->importdata($row))
			{
				$this->importedrows++;
			}
			else
			{
				return false;
			}
		} 
		return true;
	}
	
	
	
	/**
	 * Function to import a data form a row in the CSV file
	 * @param array $row
	 * @return bool
	 */
	function importdata($row)
	{
		//check for valid columns		
		$foundColumns = array();
		$requiredcolumns = array('CITY_NAME'=>'CITY_NAME','LAT'=>'LAT', 'LON'=>'LON');
		foreach($row as $key=>$val)
		{
			foreach($requiredcolumns as $reqCol)
			{
				
				if(strtoupper(trim($key)) == $reqCol)
				{
					$foundColumns[$reqCol] = $key;
				}
			}
		}
		 

		if(count($requiredcolumns) != count($foundColumns))
		{
			$i = 0;
			$colStr = "";
			$missingStr = "";
			foreach($foundColumns as $key => $fCol)
			{
				$i++;
				if($i>1){$colStr .= ", ";}
				$colStr .= '"'.$fCol.'"';
			}
			$i = 0;
			foreach($requiredcolumns as $key)
			{
				if(!isset($foundColumns[$key]))
				{
					$i++;
					if($i>1){$missingStr .= ", ";}
					$missingStr = '"'.$key.'"';
				}
			}
			
			$this->errors[] = "Found the following columns: $colStr, but missing $missingStr";
			return false;
		}
		
		
		// STEP 1: Look at the admin areas in increasing level and add them if they're not already in the database
		$parentID = null;
		foreach($this->adminAreas as $level => $adminArea)
		{
			if(isset($row[$adminArea]))
			{
				$areaName = $row[$adminArea];
				//check and see if this level has already been added to the array
				if(!isset($this->areasArray[$level]))
				{
					//there's no array for this level so add it
					$this->areasArray[$level] = array();
				}
				if(!isset($this->areasArray[$level][$areaName]))
				{
					$areaDB = ORM::factory("adminareas");
					$areaDB->name = $areaName;
					$areaDB->file = url::base()."plugins/locationhighlight/kml/blank.kml";
					$areaDB->parent_id = $parentID;
					$areaDB->save();
					$this->areasArray[$level][$areaName] = $areaDB->id;
					$parentID = $areaDB->id;
				}
				else
				{
					$parentID = $this->areasArray[$level][$areaName]; 
				}
			}
			else
			{
				$this->errors[] = $adminArea . "not set at ". $this->rownumber;
				return; 
			}
		}//end for loop of admin areas
		
		// STEP 2: parse the cities
		$city_name = null;
		$lat = null;
		$lon = null;
		
		if(isset($row[$foundColumns["CITY_NAME"]]))
		{
			$city_name = $row[$foundColumns["CITY_NAME"]];
		}
		else
		{
			$this->errors[] = "There's no CITY_NAME on row ". $this->rownumber;
			return;
		}
		
		if(isset($row[$foundColumns["LAT"]]))
		{
			$lat = $row[$foundColumns["LAT"]];
		}
		else
		{
			$this->errors[] = "There's no LAT on row ". $this->rownumber;
			return;
		}
		
		if(isset($row[$foundColumns["LON"]]))
		{
			$lon = $row[$foundColumns["LON"]];
		}
		else
		{
			$this->errors[] = "There's no LON on row ". $this->rownumber;
			return;
		}
		
		$cityDB = ORM::factory("location_highlight_cities");
		$cityDB->name = $city_name;
		$cityDB->latitude = $lat;
		$cityDB->longitude = $lon;
		$cityDB->adminarea_id = $parentID;
		$cityDB->save();
		 
		return true;
	}//end method
}

?>
