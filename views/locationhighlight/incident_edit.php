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
			var layerURL = "<?php echo url::base().Kohana::config('upload.relative_directory').'/'; ?>" + encodeURIComponent(layerData.substring(seperatorPos+1));
			
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


	<span style="float:right;"><a href="#" onclick="clearMap(1); $('#adminarea_level_1').html(''); return false;"><?php echo Kohana::lang('file.clear');?></a></span>
	<h4><?php echo Kohana::lang('file.select');?><?php echo $level_name; ?>:
	</h4>
	
	<input type="hidden" id="max_admin_area_level" name="max_admin_area_level" value="1" />
	<?php print form::dropdown('admin_area_1', $admin_areas, 'standard'); ?>
	
	<a href="#" onclick="switchArea(1);  return false;"><?php echo Kohana::lang('file.update');?></a> <span id="admin_area_loading_1"></span>

	<div id="adminarea_level_1"></div>

</div>