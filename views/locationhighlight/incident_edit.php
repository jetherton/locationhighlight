<div class="row" style="border: 2px solid gray; padding: 10px; width:340px; margin:auto; margin-top:10px; margin-bottom:10px;" >

	<script type="text/javascript">

		/*
		Add KML/KMZ Layers
		*/
		function switchArea(level)
		{
			var layerColor = "AAAAAA";
			var layerID = "";
			var layerData = $('#admin_area_'+level).val();
			var maxLevel = $('#max_admin_area_level').val();
			if (level > maxLevel)
			{
				$('#max_admin_area_level').val(level);
			}
			//need to seperate out the URL and the ID number
			var seperatorPos =  layerData.indexOf("|");
			var adminAreaId = layerData.substring(0, seperatorPos);
			var layerURL = layerData.substring(seperatorPos+1);
			
			//start the little spinny waiting deal
			$('#admin_area_loading_'+level).html('<img src="<?php echo url::base(); ?>media/img/loading_g.gif"/>');

			
			//gets all the things off the map
			clearMap(level);
			//create new layer
			var layer = new OpenLayers.Layer.Vector("adminArea"+level, {
				projection: map.displayProjection,
				strategies: [new OpenLayers.Strategy.Fixed()],
				protocol: new OpenLayers.Protocol.HTTP({
					url: layerURL,
					format: new OpenLayers.Format.KML({
						extractStyles: true,
						extractAttributes: true
					})
				})
			});
            
			
			// Add New Layer
			map.addLayer(layer);
			//get the HTML for the next set of kid admin areas
			$.get("<?php echo url::base() ?>locationhighlight/get_admin_areas/"+adminAreaId+"/"+(level+1),
			function(data){
				$('#adminarea_level_'+level).html(data);
				$('#admin_area_loading_'+level).html("");
			});
			
			return false;
		}

		function switchCities(level)
		{
			var layerData = $('#cities_'+level).val();
			var locationName = $('#cities_'+level).text();

			for(i = (parseInt(level)-1); i>=0; i--)
			{
				locationName = locationName + ", " + $('#admin_area_'+i).text();
			}
			
			var seperatorPos =  layerData.indexOf("|");
			var lat = layerData.substring(0, seperatorPos);
			var lon = layerData.substring(seperatorPos+1);


			placeLocation(lat,lon,locationName);
		}


		/***************************************
		*Put things on the map based on a geolocation
		****************************************/
		function placeLocation(lat, lon, name)
		{
			// Clear the map first
			vlayer.removeFeatures(vlayer.features);
			$('input[name="geometry[]"]').remove();
			
			point = new OpenLayers.Geometry.Point(lon, lat);
			OpenLayers.Projection.transform(point, proj_4326,proj_900913);
			
			
			f = new OpenLayers.Feature.Vector(point);
			vlayer.addFeatures(f);
			
			// create a new lat/lon object
			myPoint = new OpenLayers.LonLat(lon, lat);
			myPoint.transform(proj_4326, map.getProjectionObject());

			// display the map centered on a latitude and longitude
			var default_zoom = $("#default_zoom").text();
			map.setCenter(myPoint, default_zoom);
			
			// Update form values
			$("#latitude").attr("value", lat);
			$("#longitude").attr("value", lon);
			$("#location_name").attr("value", name);

			return false;
		}
		
		
		function clearMap(level)
		{
			var maxLevel = $('#max_admin_area_level').val();
			
			//remove layer
			for(var k=level; k <= maxLevel; k++)
			{
				new_layer = map.getLayersByName("adminArea"+k);
				if (new_layer)
				{
					for (var i = 0; i < new_layer.length; i++)
					{
						map.removeLayer(new_layer[i]);
					}
				}
			}

			return false;
		}

	</script>


	<span style="float:right;"><a href="#" onclick="clearMap(0); $('#adminarea_level_0').html(''); return false;"><?php echo Kohana::lang('layer.clear');?></a></span>
	<h4 style="margin-bottom:5px;"><?php echo Kohana::lang('layer.select');?> <?php echo $level_name; ?>:
	</h4>
	
	<input type="hidden" id="max_admin_area_level" name="max_admin_area_level" value="0" />
	<?php print form::dropdown('admin_area_0', $admin_areas, 'standard'); ?>
	
	<a href="#" onclick="switchArea(0);  return false;"><?php echo Kohana::lang('layer.update');?></a> <span id="admin_area_loading_0"></span>

	<div id="adminarea_level_0"></div>

</div>