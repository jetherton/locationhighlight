<div class="row" style="border: 2px solid gray; padding: 10px; width:340px; margin:auto; margin-top:10px; margin-bottom:10px;" >

	<script type="text/javascript">

		/*
		Add KML/KMZ Layers
		*/
		function switchArea()
		{
			var layerColor = "AAAAAA";
			var layerID = "";
			var layerURL = $('#admin_area').val();
			//remove layer

			new_layer = map.getLayersByName("adminArea");
			if (new_layer)
			{
				for (var i = 0; i < new_layer.length; i++)
				{
					map.removeLayer(new_layer[i]);
				}
			}

	
			//create new layer
			var layer = new OpenLayers.Layer.Vector("adminArea", {
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
			
			return false;
		}

	</script>


	<h4>
		Select administrative area:
	</h4>
	<?php print form::dropdown('admin_area', $admin_areas, 'standard'); ?>
	
	<a href="#" onclick="switchArea(); return false;">update map</a>

	

</div>