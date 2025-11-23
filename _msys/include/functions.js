/* FUNCTIONS FOR DRAWING GOOGLE MAPS WITH GPS VISUALIZER (http://www.gpsvisualizer.com/) */

google_api_version = gv_api_version = FindGoogleAPIVersion();

if (!self.gv_options) { GV_Setup_Global_Variables(); }
function GV_Setup_Global_Variables() {
	// Define parameters of different marker types
	if (!self.gv_icons) { gv_icons = new Array(); }
	gv_icons['circle'] = { is:[11,11],ia:[5,5],ss:[13,13],iwa:[10,2],isa:[5,9],im:[0,0, 10,0, 10,10, 0,10, 0,0],letters:true };
	gv_icons['pin'] = { is:[15,26],ia:[7,25],ss:[30,26],iwa:[7,1],isa:[12,16],im:[5,25, 5,15, 2,13, 1,12, 0,10, 0,5, 1,2, 2,1, 4,0, 10,0, 12,1, 13,2, 14,4, 14,10, 13,12, 12,13, 9,15, 9,25, 5,25 ],letters:true };
	gv_icons['square'] = { is:[11,11],ia:[5,5],ss:[13,13],iwa:[10,2],isa:[5,9],im:[0,0, 10,0, 10,10, 0,10, 0,0],letters:true };
	gv_icons['triangle'] = { is:[13,13],ia:[6,6],ss:[15,15],iwa:[11,3],isa:[6,10],im:[0,11, 6,0, 12,11, 0,11],letters:false };
	gv_icons['diamond'] = { is:[13,13],ia:[6,6],ss:[13,13],iwa:[11,3],isa:[6,10],im:[6,0, 12,6, 6,12, 0,6, 6,0],letters:false };
	gv_icons['airport'] = { is:[17,17],ia:[8,8],ss:[19,19],iwa:[13,3],isa:[13,17],im:[6,0, 10,0, 16,6, 16,10, 10,16, 6,16, 0,10, 0,6, 6,0],letters:false };
	gv_icons['google'] = { is:[20,34],ia:[9,34],ss:[37,34],iwa:[9,2],isa:[18,25],im:[8,33, 8,23, 1,13, 1,6, 6,1, 13,1, 18,6, 18,13, 11,23, 11,33],letters:true };
	gv_icons['googleblank'] = { is:[20,34],ia:[9,34],ss:[37,34],iwa:[9,2],isa:[18,25],im:[8,33, 8,23, 1,13, 1,6, 6,1, 13,1, 18,6, 18,13, 11,23, 11,33],letters:true };
	gv_icons['googlemini'] = { is:[12,20],ia:[6,20],ss:[22,20],iwa:[5,1],isa:[10,15],im:[4,19, 4,14, 0,7, 0,3, 4,0, 7,0, 11,3, 11,7, 7,14, 7,19, 4,19],letters:true };
	gv_icons['blankcircle'] = { is:[64,64],ia:[31,31],ss:[70,70],iwa:[55,8],isa:[31,63],im:[19,3, 44,3, 60,19, 60,44, 44,60, 19,60, 3,44, 3,19, 19,3],letters:false };
	gv_icons['camera'] = { is:[17,13],ia:[8,6],ss:[19,15],iwa:[13,3],isa:[13,10],im:[1,3, 6,1, 10,1, 15,3, 15,11, 1,11, 1,3],letters:false };
	gv_icons['tickmark'] = { is:[13,13],ia:[6,6],ss:[],iwa:[11,3],isa:[],im:[6,0, 12,6, 6,12, 0,6, 6,0],letters:false };
	
	// Make sure defaults have been set; if not, things break. (Some backwards-compatibility (BC) stuff here)
	if (self.gv_default_marker) {
		gv_marker_icon = (gv_default_marker['icon']) ? gv_default_marker['icon'] : 'googlemini';
		gv_marker_color = (gv_default_marker['color']) ? gv_default_marker['color'] : 'red';
		if (!gv_default_marker['icon_size']) { gv_default_marker['icon_size'] = gv_default_marker['size']; }
		gv_marker_icon_size = (gv_default_marker['icon_size']) ? gv_default_marker['icon_size'] : null; // a two-item list
		if (!gv_default_marker['icon_anchor']) { gv_default_marker['icon_anchor'] = gv_default_marker['anchor']; }
		gv_marker_icon_anchor = (gv_default_marker['icon_anchor']) ? gv_default_marker['icon_anchor'] : null; // a two-item list
		gv_marker_icon_trans = (gv_default_marker['transparent']) ? gv_default_marker['transparent'] : null; // a URL
		gv_marker_icon_imagemap = (gv_default_marker['imagemap']) ? gv_default_marker['imagemap'] : null; // a list with an even number of items
	} else {
		if (!self.gv_marker_icon) { gv_marker_icon = (self.default_icon_style) ? default_icon_style : 'googlemini'; } // BC
		if (!self.gv_marker_color) { gv_marker_color = (self.default_icon_color) ? default_icon_color : 'red'; } // BC
		gv_marker_icon_size = gv_marker_icon_trans = gv_marker_icon_imagemap = null;
	}
	if (!self.gv_marker_link_target) { gv_marker_link_target = (self.marker_link_target) ? marker_link_target : '_blank'; } // BC
	if (!self.gv_maptypecontrol_style) { gv_maptypecontrol_style = (self.maptypecontrol_style) ? maptypecontrol_style : 'menu'; } // BC
	if (self.gv_filter_map_types==null) { gv_filter_map_types = (self.filter_map_types!=null) ? filter_map_types : true; }
	if (!self.gv_bg_opacity) { gv_bg_opacity = (self.gv_bg_opacity) ? gv_bg_opacity : 100; }
	if (!self.gv_icon_directory) { gv_icon_directory = 'http://maps.gpsvisualizer.com/google_maps/icons/'; }
	if (self.gv_driving_directions==null) { gv_driving_directions = false; }
	if (self.gv_label_offset && self.gv_label_offset.length > 1) { gv_label_offset_x = gv_label_offset[0]; gv_label_offset_y = gv_label_offset[1]; } else { gv_label_offset_x = 0; gv_label_offset_y = 0; }
	
	// use the new "maps." URL for icons and such
	gv_icon_directory = gv_icon_directory.replace(/http:\/\/www\.gpsvisualizer\.com\/google_maps\//,'http://maps.gpsvisualizer.com/google_maps/');
	
	// Some stuff related to marker lists
	gv_marker_list_exists = null; gv_marker_list_html = ''; gv_marker_list_count = 0;
	gv_marker_list_div = null; gv_marker_list_div_name = null; gv_marker_list_map_name = null;
	gv_marker_array_name = (self.gv_marker_list_options && gv_marker_list_options['array']) ? gv_marker_list_options['array'] : 'wpts';
	if (self.gv_marker_list_options) {
		gv_marker_list_html = '';
		gv_marker_list_count = 0;
		gv_marker_list_map_name = (gv_marker_list_options['map']) ? gv_marker_list_options['map'] : 'gmap';
		if (gv_marker_list_options['id']) { // compatibility with version that had only 'id'
			gv_marker_list_options['div'] = gv_marker_list_options['id'];
		} else if (gv_marker_list_options['floating'] === false || gv_marker_list_options['floating'] === true) { // check for presence of "floating" parameter
			if (gv_marker_list_options['floating'] === false) {
				gv_marker_list_options['div'] = (gv_marker_list_options['id_static']) ? gv_marker_list_options['id_static'] : 'gv_marker_list';
			} else {
				gv_marker_list_options['div'] = (gv_marker_list_options['id_static']) ? gv_marker_list_options['id_floating'] : 'gv_marker_list';
			}
		}
		if (document.getElementById(gv_marker_list_options['div'])) {
			gv_marker_list_div_name = gv_marker_list_options['div'];
			gv_marker_list_div = document.getElementById(gv_marker_list_div_name);
		} else if (document.getElementById('gv_marker_list')) {
			gv_marker_list_div_name = 'gv_marker_list';
			gv_marker_list_div = document.getElementById(gv_marker_list_div_name);
		} else {
			gv_marker_list_div_name = '';
			gv_marker_list_div = null;
		}
		if (gv_marker_list_div) {
			if (gv_marker_list_options['list'] === false) { // this trumps everything
				gv_marker_list_div.style.display = 'none';
				gv_marker_list_exists = false;
			} else if (gv_marker_list_div.style.display == '' || gv_marker_list_options['list'] == true) {
				gv_marker_list_div.style.display = 'block';
				gv_marker_list_exists = true;
			} else {
				gv_marker_list_exists = false;
			}
		} else {
			gv_marker_list_exists = false;
		}
	}
	
	// Some stuff related to filtering waypoints
	gv_filter_waypoints = null; gv_filter_marker_list = null;
	if (self.gv_marker_filter_options) {
		gv_filter_marker_list = (gv_marker_filter_options['update_list']) ? true : false;
		gv_filter_waypoints = (gv_marker_filter_options['filter']) ? true : false;
		if (gv_marker_filter_options['dynamic_marker_options'] && gv_marker_filter_options['dynamic_marker_options']['url']) {
			gv_marker_filter_options['filter'] = false; gv_filter_waypoints = false;
		}
	}
	
	// Create a default icon for all markers
	defaultIcon = new GIcon();
	if (gv_marker_icon.substring(0,7) == 'http://') {
		defaultIcon.image = gv_marker_icon;
		defaultIcon.iconSize = (gv_marker_icon_size && gv_marker_icon_size[0] && gv_marker_icon_size[1]) ? new GSize(gv_marker_icon_size[0],gv_marker_icon_size[1]) : new GSize(32,32);
		defaultIcon.iconAnchor = (gv_marker_icon_anchor && gv_marker_icon_anchor[0] != null && gv_marker_icon_anchor[1] != null) ? new GPoint(gv_marker_icon_anchor[0],gv_marker_icon_anchor[1]) : new GPoint(defaultIcon.iconSize.width*0.5,defaultIcon.iconSize.height*0.5);
		defaultIcon.infoWindowAnchor = new GPoint(defaultIcon.iconSize.width*0.75,0);
		defaultIcon.infoShadowAnchor = new GPoint(defaultIcon.iconSize.width*0.5,defaultIcon.iconSize.height);
		defaultIcon.transparent = (gv_marker_icon_trans && gv_marker_icon_trans.substring(0,7) == 'http://') ? gv_marker_icon_trans : null;
		defaultIcon.imageMap = (gv_marker_icon_imagemap && gv_marker_icon_imagemap.length > 5) ? gv_marker_icon_imagemap : [ 0,0, 0,defaultIcon.iconSize.height-1, defaultIcon.iconSize.width-1,defaultIcon.iconSize.height-1, defaultIcon.iconSize.width-1,0, 0,0 ];
		defaultIcon.shadow = null; defaultIcon.shadowSize = null;
		gv_icons[gv_marker_icon] = { is:[defaultIcon.iconSize.width,defaultIcon.iconSize.height],ia:[defaultIcon.iconAnchor.width,defaultIcon.iconAnchor.height],ss:null,iwa:[defaultIcon.infoWindowAnchor.width,defaultIcon.infoWindowAnchor.height],isa:[defaultIcon.infoShadowAnchor.width,defaultIcon.infoShadowAnchor.height],im:defaultIcon.imageMap };
	} else {
		if (!gv_icons[gv_marker_icon]) { gv_marker_icon = 'pin'; }
		defaultIcon.image = gv_icon_directory+gv_marker_icon+'/'+gv_marker_color+'.png';
		defaultIcon.transparent = gv_icon_directory+gv_marker_icon+'/'+gv_marker_color+'-t.png';
		defaultIcon.iconSize = new GSize(gv_icons[gv_marker_icon]['is'][0],gv_icons[gv_marker_icon]['is'][1]);
		defaultIcon.iconAnchor = new GPoint(gv_icons[gv_marker_icon]['ia'][0],gv_icons[gv_marker_icon]['ia'][1]);
		defaultIcon.shadow = (gv_icons[gv_marker_icon]['ss'] && gv_icons[gv_marker_icon]['ss'][0]) ? gv_icon_directory+gv_marker_icon+'/shadow.png' : null;
		defaultIcon.shadowSize = (gv_icons[gv_marker_icon]['ss'] && gv_icons[gv_marker_icon]['ss'][0]) ? new GSize(gv_icons[gv_marker_icon]['ss'][0],gv_icons[gv_marker_icon]['ss'][1]) : null;
		defaultIcon.infoWindowAnchor = new GPoint(gv_icons[gv_marker_icon]['iwa'][0],gv_icons[gv_marker_icon]['iwa'][1]);
		defaultIcon.infoShadowAnchor = new GPoint(gv_icons[gv_marker_icon]['isa'][0],gv_icons[gv_marker_icon]['isa'][1]);
		defaultIcon.imageMap = (gv_icons[gv_marker_icon]['im']) ? gv_icons[gv_marker_icon]['im'] : [ 0,0, 0,gv_icons[gv_marker_icon]['is'][1]-1, gv_icons[gv_marker_icon]['is'][0]-1,gv_icons[gv_marker_icon]['is'][1]-1, gv_icons[gv_marker_icon]['is'][0]-1,0, 0,0 ];
	}
}

GV_Styles();
function GV_Styles() {
	// Set up some styles
	document.writeln('		<style type="text/css">');
	document.writeln('			img.gv_wpt_thumbnail { display:block; text-decoration:none; margin:0px; }');
	document.writeln('			img.gv_wpt_photo { display:block; text-decoration:none; margin:0px; }');
	document.writeln('			.gv_tooltip { background-color:#FFFFFF; filter:alpha(opacity=100); -moz-opacity:1.0; border:1px solid #666666; padding:2px; text-align:left; font:10px Verdana,sans-serif; color:#000000; white-space: nowrap; }');
	document.writeln('			.gv_tooltip img.gv_wpt_thumbnail { display:block; padding-top:3px; }');
	document.writeln('			.gv_tooltip img.gv_wpt_photo { display:none; }');
	document.writeln('			.gv_wpt { font: 10px Verdana,sans-serif; }');
	document.writeln('			.gv_wpt img.gv_wpt_thumbnail { border:1px solid; margin:6px 0px 6px 0px; }');
	document.writeln('			.gv_wpt img.gv_wpt_photo { margin:8px 0px 8px 0px; }');
	document.writeln('			.gv_driving_directions { background-color:#EEEEEE; padding:4px; margin-top:12px; }');
	document.writeln('			.gv_driving_directions_heading { color:#666666; font-weight:bold; }');
	document.writeln('			img.hidden_in_info_window { display:none; }');
	document.writeln('			.gv_label { filter:alpha(opacity=90); -moz-opacity:0.9; background-color:#333333; border:1px solid #000000; padding:1px; font:9px Verdana,sans-serif; color:#FFFFFF; text-align:left; white-space: nowrap; }');
	document.writeln('			.gv_label img { display:none; }');
	document.writeln('			.gv_legend_item { padding-bottom:0px; line-height:1em; font-weight:bold; }');
	document.writeln('			.gv_tracklist_item { padding-bottom:2px; }');
	document.writeln('			.gv_tracklist_item .trackname { font-weight:bold; }');
	document.writeln('			.gv_marker_list { font-family:Verdana,sans-serif; font-size:10px; }');
	document.writeln('			.gv_marker_list_item { padding:2px 0px 4px 0px; font-family:Verdana,sans-serif; font-size:10px; line-height:1.2em; }');
	document.writeln('			.gv_marker_list_item .name { font-size:10px; font-weight:bold; }');
	document.writeln('			.gv_marker_list_item .desc { font-size:9px; filter:alpha(opacity=80); -moz-opacity:0.8; }');
	document.writeln('			.gv_marker_list_item .icon { cursor:crosshair; float:left; margin-right:4px; margin-bottom:1px; }');
	document.writeln('			.gv_marker_list_thumbnail { display:none; }');
	document.writeln('			.gv_maptypelink { background-color:#DDDDDD; color:#000000; text-align:center; white-space: nowrap; border:1px solid; border-color: #999999 #222222 #222222 #999999; padding:1px 2px 1px 2px; margin-bottom:3px; font:9px Verdana,sans-serif; text-decoration:none; cursor:pointer; }');
	document.writeln('			.gv_maptypelink_selected { background-color:#FFFFFF; }');
	document.writeln('		</style>');
	document.writeln('		<style type="text/css" media="print">'); // force stuff to print even though Google thinks it shouldn't
	document.writeln('			img[src^="http://www.gpsvisualizer.com/"].gmnoprint { display:inline; }'); // anything GV puts up
	document.writeln('			img[src^="http://maps.gpsvisualizer.com/"].gmnoprint { display:inline; }'); // anything GV puts up
	document.writeln('			img[src^="http://mt.google.com/mld"].gmnoprint { display:inline; }'); // Google Maps tracks
	document.writeln('			img[src$="transparent.png"].gmnoprint { display:none; }');
	document.writeln('			img[src$="shadow.png"].gmnoprint { display:none; }');
	document.writeln('			img[src$="crosshair.gif"].gmnoprint { display:none; }');
	document.writeln('			.gv_label { color:#000000; background-color:#FFFFFF; filter:alpha(opacity=100); -moz-opacity:1.0; }');
	document.writeln('		</style>');
}


function GV_Setup_Map(opts) { // opts = options hash
	var map_name = opts['map'] || 'gmap'; var map = eval(map_name); if (!map) { return false; }
	var marker_array_name = opts['marker_array'] || 'wpts';
	var track_info_array_name = opts['track_info_array'] || 'trk_info';
	
	// Variables that used to be separately specified and may be needed by other functions:
	gv_default_marker = opts['default_marker'];
	gv_icon_directory = opts['icon_directory'];
	gv_marker_link_target = opts['marker_link_target'];
	gv_driving_directions = opts['driving_directions'];
	gv_hide_labels = opts['hide_labels'];
	gv_label_offset = opts['label_offset'];
	gv_marker_filter_options = opts['marker_filter_options'];
	if (opts['marker_list_options']) { gv_marker_list_options = opts['marker_list_options']; }
	else { gv_marker_list_options = new Array(); } // it needs to be created or the next statements will throw errors
	gv_marker_list_options['map'] = map_name;
	gv_marker_list_options['array'] = marker_array_name;
	
	if (opts['full_screen']) {
		document.body.style.margin = '0px';
		document.body.style.overflow = 'hidden';
		GV_Fill_Window_With_Map(map.getContainer().id); // we may have already done this, and will probably do it again, but it doesn't hurt anything
		map.getContainer().style.margin = '0px';
		gv_marker_list_options['floating'] = true;
	}
	
	GV_Setup_Global_Variables(); // this is the part of functions.js that, in the absence of gv_options, would have already happened (GV_Styles HAS been run, though)
	
	if (!opts['doubleclick_zoom']) {
		map.disableDoubleClickZoom();
	}
	
	if (opts['mousewheel_zoom']) {
		if (opts['mousewheel_zoom'] == 'reverse') {
			GEvent.addDomListener(document.getElementById(opts['map_div']),"DOMMouseScroll", GV_MouseWheelReverse); // mouse-wheel zooming for Firefox
			GEvent.addDomListener(document.getElementById(opts['map_div']),"mousewheel", GV_MouseWheelReverse); // mouse-wheel zooming for IE
		} else {
			GEvent.addDomListener(document.getElementById(opts['map_div']),"DOMMouseScroll", GV_MouseWheel); // mouse-wheel zooming for Firefox
			GEvent.addDomListener(document.getElementById(opts['map_div']),"mousewheel", GV_MouseWheel); // mouse-wheel zooming for IE
		}
	}
	
	map.setCenter(new GLatLng(opts['center'][0],opts['center'][1]), opts['zoom'], eval(opts['map_type']));
	
	if (opts['map_type_control'] && opts['map_type_control']['style'] && opts['map_type_control']['style'] == 'google') {
		map.addControl(gv_maptypecontrol = new GMapTypeControl());
	
	} else if (opts['map_type_control'] && opts['map_type_control']['style'] && opts['map_type_control']['style'] != 'none') {
		map.addControl(gv_maptypecontrol = new GV_MapTypeControl(opts['map_type_control']));
	}
	if (opts['map_opacity_control']) {
		map.addControl(gv_mapopacitycontrol = new GV_MapOpacityControl(opts['map_opacity'])); // add custom map type switcher
	} else if (opts['map_opacity'] != 1 && opts['map_opacity'] != 100) {
		GV_Background_Opacity(map,opts['map_opacity']); // redundant if control has already been placed
	}
	if (opts['zoom_control'] && opts['zoom_control'] != 'none' && opts['zoom_control'] != 'false') {
		if (opts['zoom_control'] == 'small') { map.addControl(new GSmallMapControl()); }
		else { map.addControl(new GLargeMapControl()); }
	}
	if (opts['scale_control']) {
		map.addControl(new GScaleControl());
	}
	
	if (opts['tracklist_options'] && opts['tracklist_options']['tracklist']) {
		// the DIVs are as follows: container_id.table_id.(handle_id & id)
		var o = opts['tracklist_options'];
		o['container_id'] = o['id']+'_container';
		o['table_id'] = o['id']+'_table';
		o['handle_id'] = o['id']+'_handle';
		if (document.getElementById(o['container_id']) && o['position'] && o['position'].length >= 3) {
			if (document.getElementById(o['table_id']) && document.getElementById(o['handle_id']) && o['draggable']) {
				var vertical_offset = 2000;
				document.getElementById(o['table_id']).style.top = '-'+vertical_offset+'px';
				if (o['position'][0].indexOf('_BOTTOM_') > -1) {
					GV_Place_Control(map,o['container_id'],eval(o['position'][0]),o['position'][1],o['position'][2]-vertical_offset);
				} else {
					GV_Place_Control(map,o['container_id'],eval(o['position'][0]),o['position'][1],o['position'][2]+vertical_offset);
				}
				Drag.init(document.getElementById(o['handle_id']),document.getElementById(o['table_id']));
				if (o['collapsible']) {
					GV_Windowshade_Setup(o['handle_id'],o['id']);
				}
			} else {
				GV_Place_Control(map,o['container_id'],eval(o['position'][0]),o['position'][1],o['position'][2]);
				if (document.getElementById(o['handle_id'])) { document.getElementById(o['handle_id']).style.display = 'none'; }
			}
		}
	}
	
	if (gv_marker_list_options['list'] && gv_marker_list_exists) {
		var o = gv_marker_list_options;
		if (o['floating'] === false && o['id_static']) { o['id'] = o['id_static']; }
		else if (o['floating'] && o['id_floating']) { o['id'] = o['id_floating']; }
		else if (!o['id']) { o['id'] = 'gv_marker_list'; }
		o['container_id'] = o['id']+'_container';
		o['table_id'] = o['id']+'_table';
		o['handle_id'] = o['id']+'_handle';
		if (o['floating'] && o['container_id'] && document.getElementById(o['container_id'])) {
			if (o['width']) { document.getElementById(o['id']).style.width = o['width']+'px'; }
			if (o['height']) { document.getElementById(o['id']).style.height = o['height']+'px'; }
			if (document.getElementById(o['container_id']) && o['position'] && o['position'].length >= 3) {
				if (document.getElementById(o['table_id']) && document.getElementById(o['handle_id']) && o['draggable']) {
					var vertical_offset = 2000;
					document.getElementById(o['table_id']).style.top = '-'+vertical_offset+'px';
					if (o['position'][0].indexOf('_BOTTOM_') > -1) {
						GV_Place_Control(map,o['container_id'],eval(o['position'][0]),o['position'][1],o['position'][2]-vertical_offset);
					} else {
						GV_Place_Control(map,o['container_id'],eval(o['position'][0]),o['position'][1],o['position'][2]+vertical_offset);
					}
					Drag.init(document.getElementById(o['handle_id']),document.getElementById(o['table_id']));
					if (o['collapsible']) {
						GV_Windowshade_Setup(o['handle_id'],o['id']);
					}
				} else {
					GV_Place_Control(map,o['container_id'],eval(o['position'][0]),o['position'][1],o['position'][2]);
					if (document.getElementById(o['handle_id'])) { document.getElementById(o['handle_id']).style.display = 'none'; }
				}
			}
		} else {
			if (document.getElementById(o['id'])) {
				document.getElementById(o['id']).style.display = 'block';
			}
		}
	}
	
	if (opts['legend_options'] && opts['legend_options']['legend']) {
		// the DIVs are as follows: container_id.table_id.(handle_id & id)
		var o = opts['legend_options'];
		o['container_id'] = o['id']+'_container';
		o['table_id'] = o['id']+'_table';
		o['handle_id'] = o['id']+'_handle';
		if (document.getElementById(o['container_id']) && o['position'] && o['position'].length >= 3) {
			if (document.getElementById(o['table_id']) && document.getElementById(o['handle_id']) && o['draggable']) {
				var vertical_offset = 2000;
				document.getElementById(o['table_id']).style.top = '-'+vertical_offset+'px';
				if (o['position'][0].indexOf('_BOTTOM_') > -1) {
					GV_Place_Control(map,o['container_id'],eval(o['position'][0]),o['position'][1],o['position'][2]-vertical_offset);
				} else {
					GV_Place_Control(map,o['container_id'],eval(o['position'][0]),o['position'][1],o['position'][2]+vertical_offset);
				}
				Drag.init(document.getElementById(o['handle_id']),document.getElementById(o['table_id']));
				if (o['collapsible']) {
					GV_Windowshade_Setup(o['handle_id'],o['id']);
				}
			} else {
				GV_Place_Control(map,o['container_id'],eval(o['position'][0]),o['position'][1],o['position'][2]);
				if (document.getElementById(o['handle_id'])) { document.getElementById(o['handle_id']).style.display = 'none'; }
			}
		}
	}
	
	if (opts['center_coordinates']) {
		// set up and place the box that shows the coordinates
		if (!document.getElementById('gv_center_container')) {
			var center_div = document.createElement('div'); center_div.id = 'gv_center_container';
			center_div.style.display = 'none';
			center_div.innerHTML = '<table style="cursor:crosshair; filter:alpha(opacity=80); -moz-opacity:0.80;" cellspacing="0" cellpadding="0" border="0"><tr><td><div id="gv_center_coordinates" style="background-color:#FFFFFF; border:solid #666666 1px; padding:1px; font-family:Arial; font-size:10px; line-height:11px;" class="gmnoprint" onClick="GV_Toggle(\'gv_crosshair\'); gv_crosshair_temporarily_hidden = false;" title="Click here to turn center crosshair on or off"></div></td></tr></table>';
			map.getContainer().appendChild(center_div);
		}
		GV_Place_Control(map,'gv_center_container',G_ANCHOR_BOTTOM_LEFT,4,40);
		
		// set up the box that holds the crosshair in the middle -- but use the GV_Setup_Crosshair function to center it
		if (!document.getElementById('gv_crosshair_container')) {
			var crosshair_div = document.createElement('div'); crosshair_div.id = 'gv_crosshair_container';
			crosshair_div.style.display = 'none'; crosshair_div.className= 'gmnoprint';
			crosshair_div.innerHTML = '<div id="gv_crosshair" align="center" style="width:15px; height:15px; display:block;"><img src="http://maps.gpsvisualizer.com/google_maps/crosshair.gif" alt="" width="15" height="15"></div>';
			// map.getPane(G_MAP_FLOAT_PANE).appendChild(crosshair_div);
			map.getContainer().appendChild(crosshair_div);
		}
		if (document.getElementById('gv_crosshair')) {
			document.getElementById('gv_crosshair').style.display = (opts['crosshair_hidden']) ? 'none' : 'block';
			gv_hidden_crosshair_is_still_hidden = true;
		}
		GV_Setup_Crosshair(map,{crosshair_container_id:'gv_crosshair_container',crosshair_graphic_id:'gv_crosshair',crosshair_width:15,center_coordinates_id:'gv_center_coordinates',fullscreen:opts['full_screen']});
	}
	
	if (!document.getElementById('gv_credit')) {
		var credit_div = document.createElement('div'); credit_div.id = 'gv_credit';
		credit_div.style.display = 'none'; credit_div.style.font = '10px Verdana,sans-serif'; credit_div.style.padding = '1px'; credit_div.style.backgroundColor = '#FFFFFF';
		credit_div.style.filter = 'alpha(opacity=80)'; credit_div.style.MozOpacity = 0.8; credit_div.style.KhtmlOpacity = 0.8;
		credit_div.innerHTML = (gv_options['custom_credit'] && gv_options['custom_credit'].indexOf('gpsvisualizer.com') > -1) ? gv_options['custom_credit'] : '<b>Map created at <a target="_top" href="http://www.gpsvisualizer.com/">GPSVisualizer.com</a></b>';
		map.getContainer().appendChild(credit_div);
	}
	GV_Place_Control(map,'gv_credit',G_ANCHOR_BOTTOM_RIGHT,6,20);
	
}

function GV_Setup_Waypoint_Processing_Events(map_name,marker_array_name) {
	map_name = (map_name) ? map_name : 'gmap'; var map = eval(map_name); if (!map) { return false; }
	marker_array_name = (marker_array_name) ? marker_array_name : 'wpts';
	if (eval('self.'+marker_array_name)) {
		var marker_array = eval(marker_array_name);
		if (gv_filter_waypoints) {
			GEvent.addListener(map, "moveend", function() { window.setTimeout('GV_Process_Waypoints('+map_name+','+marker_array_name+')',50) });
			GEvent.addListener(map, "resize", function() { window.setTimeout('GV_Process_Waypoints('+map_name+','+marker_array_name+')',50) });
		}
		if (gv_options['dynamic_marker_options'] && gv_options['dynamic_marker_options']['url']) {
			GEvent.addListener(map, "moveend", function() { window.setTimeout('GV_Get_Dynamic_Markers(gv_options)',50) });
		}
		GV_Process_Waypoints(map,marker_array);
	}
}

function GV_Process_Waypoints (map,wpt_array) {
	if (!wpt_array) {
		return false;
	}
	
	var infowindow_open = false;
	if (map.getInfoWindow() && map.getInfoWindow().isHidden() === false) {
		infowindow_open = true;
	}
	if (gv_filter_waypoints) {
		GV_Filter_Waypoints_In_View(map,wpt_array);
	}
	if (gv_marker_list_exists) {
		GV_Marker_List();
	}
	if (self.gv_labels_are_visible && gv_labels_are_visible && self.gv_options && gv_options['marker_array']) {
		GV_Toggle_All_Labels(gv_options['marker_array'],true);
	}
	if (gv_filter_waypoints && infowindow_open && gv_open_infowindow_index != null) {
		GEvent.trigger(wpt_array[gv_open_infowindow_index],"click");
		GEvent.trigger(wpt_array[gv_open_infowindow_index],"mouseout");
	}

}

function GV_Finish_Map(opts) {
	var map_name = opts['map'] || 'gmap'; var map = eval(map_name); if (!map) { return false; }
	var marker_array_name = opts['marker_array'] || 'wpts';
	var track_info_array_name = opts['track_info_array'] || 'trk_info';
	
	if (eval('self.'+track_info_array_name) && opts['filter_tracks']) {
		// The delay on tracks is slightly longer than that of waypoints because we want track filtering to happen AFTER waypoint filtering, in case some waypoints are attached to tracks
		GEvent.addListener(map, "moveend", function() { window.setTimeout('GV_Filter_Tracks('+map_name+','+track_info_array_name+')',75); });
	}
	
	if (opts['full_screen']) {
		window.onresize = function(){ GV_Fill_Window_With_Map(map.getContainer().id); map.checkResize(); }
		window.setTimeout(map_name+'.checkResize(); '+map_name+'.setCenter(new GLatLng('+opts['center'][0]+','+opts['center'][1]+'));',100); // give the full-screen map a moment to think before filling the screen and recentering
	}
	
	if (document.location.toString().match(/[&\\?](gv_force_recenter)=([^&]+)/)) {
		window.setTimeout("GV_Recenter_Per_URL({center_key:'gv_force_recenter'})",100);
	}
	
	// Now that everything's settled down, that hidden crosshair can finally be shown (when the map is first moved)
	window.setTimeout("gv_hidden_crosshair_is_still_hidden = false;",150);
	
	// Move the processing of the waypoints to the very end so the centering and resizing don't trigger extra filtering jobs
	window.setTimeout('GV_Setup_Waypoint_Processing_Events("'+map_name+'","'+marker_array_name+'")',200); // the delay lets IE6 realize the markers are in the cache so it doesn't reload them all if there's a marker list
}

var gv_marker_count = 0;
function GV_Marker(map,marker_info,lon,name,desc,url,color,style,width,label_id) {
	// The following variables need to have been defined:
	//   gv_icons (array of icon info), gv_icon_directory (absolute URL)
	//   gv_marker_icon (string), gv_marker_color (string), gv_marker_link_target (string)
	//   google_api_version (number), gv_marker_list_exists (boolean), gv_marker_list_html (string)
	
	var m = {};
	
	// The old "GV_Marker" function had everything in a particular order; this new one uses more user-friendly named parameters.
	// If the second argument has a 'lat' item INSIDE of it, then it's the new version; otherwise that's just the latitude.
	if (marker_info['lat'] != undefined || marker_info['address'] != undefined) {
		m = marker_info;
		if (m['style'] && !m['icon']) { m['icon'] = m['style']; } // this one changed recently
	} else {
		m['lat'] = marker_info; m['lon'] = lon; m['name'] = name; m['desc'] = desc; m['url'] = url; m['color'] = color; m['icon'] = style; m['window_width'] = width; m['label_id'] = label_id;
	}
	
	if (m['address'] && !m['lat']) { // allow an "address" field to define the location in a pinch
		var geocoder = new GClientGeocoder();
		geocoder.getLatLng(
			m['address'],
			function(coords){
				if (coords) {
					m['lat'] = coords.lat(); m['lon'] = coords.lng();
					GV_Marker(map,m);
				}
			}
		);
		return;
	}
	
	var tempIcon = new GIcon(defaultIcon);
	var scale = (m['scale'] > 0) ? m['scale'] : 1;
	
	if (m['icon_url'] || (m['icon'] && m['icon'].substring(0,7) == 'http://') || (!m['icon'] && gv_marker_icon.substring(0,7) == 'http://')) {
		tempIcon.image = (m['icon_url']) ? m['icon_url'] : m['icon'] || gv_marker_icon;
		var default_width = (self.gv_marker_icon_size && gv_marker_icon_size[0]) ? gv_marker_icon_size[0] : 32; var default_height = (self.gv_marker_icon_size && gv_marker_icon_size[1]) ? gv_marker_icon_size[1] : 32;
		tempIcon.iconSize = (m['icon_size'] && m['icon_size'][0] && m['icon_size'][1]) ? new GSize(m['icon_size'][0]*scale,m['icon_size'][1]*scale) : new GSize(default_width*scale,default_height*scale);
		var default_anchor_x = (self.gv_marker_icon_anchor && gv_marker_icon_anchor[0]) ? gv_marker_icon_anchor[0] : tempIcon.iconSize.width*0.5; var default_anchor_y = (self.gv_marker_icon_anchor && gv_marker_icon_anchor[1]) ? gv_marker_icon_anchor[1] : tempIcon.iconSize.height*0.5;
		tempIcon.iconAnchor = (m['icon_anchor'] && m['icon_anchor'][0]  != null && m['icon_anchor'][1] != null) ? new GPoint(m['icon_anchor'][0],m['icon_anchor'][1]) : new GPoint(default_anchor_x,default_anchor_y);
		tempIcon.infoWindowAnchor = new GPoint(tempIcon.iconSize.width*0.75,0);
		tempIcon.infoShadowAnchor = new GPoint(tempIcon.iconSize.width*0.5,tempIcon.iconSize.height);
		tempIcon.shadow = null; tempIcon.shadowSize = null;
		tempIcon.transparent = null; tempIcon.imageMap = null;
	} else if (m['icon'] || m['color'] || m['letter'] || m['opacity'] || m['rotation'] != undefined || m['scale'] > 0) {
		var icon = (m['icon'] && gv_icons[m['icon']]) ? m['icon'] : gv_marker_icon;
		var color = (m['color']) ? m['color'] : gv_marker_color;
		if (color.substring(0,1) == '#') { color = color.replace(/^\#/,''); }
		var rotation = (m['rotation'] != undefined) ? '-r'+( 1000+( 5*Math.round(((m['rotation']+360) % 360)/5)) ).toString().substring(1,4) : '';
		var base_url = (gv_icons[icon]['directory']) ? gv_icons[icon]['directory'] : gv_icon_directory+icon;
		tempIcon.iconSize = new GSize(gv_icons[icon]['is'][0]*scale,gv_icons[icon]['is'][1]*scale);
		tempIcon.iconAnchor = new GPoint(gv_icons[icon]['ia'][0]*scale,gv_icons[icon]['ia'][1]*scale);
		tempIcon.shadow = (gv_icons[icon]['ss'] && gv_icons[icon]['ss'][0]) ? base_url+'/shadow.png' : null;
		tempIcon.shadowSize = (gv_icons[icon]['ss'] && gv_icons[icon]['ss'][0]) ? new GSize(gv_icons[icon]['ss'][0]*scale,gv_icons[icon]['ss'][1]*scale) : null;
		tempIcon.infoWindowAnchor = (gv_icons[icon]['iwa'] && gv_icons[icon]['iwa'][0]) ? new GPoint(gv_icons[icon]['iwa'][0]*scale,gv_icons[icon]['iwa'][1]*scale) : null;
		tempIcon.infoShadowAnchor = (gv_icons[icon]['isa'] && gv_icons[icon]['isa'][0]) ? new GPoint(gv_icons[icon]['isa'][0]*scale,gv_icons[icon]['isa'][1]*scale) : null;
		var opacity = ''; if (m['opacity'] && m['opacity'] > 0 && m['opacity'] < 1) {
			opacity = '-'+Math.round(m['opacity']*100);
			tempIcon.shadow = null; tempIcon.shadowSize = null;
		}
		tempIcon.image = base_url+'/'+color.toLowerCase()+rotation+opacity+'.png';
		if (scale != 1) { tempIcon.imageMap = new Array(); for (j=0; j<gv_icons[icon]['im'].length; j++) { tempIcon.imageMap[j] = gv_icons[icon]['im'][j]*scale; } }
		else { tempIcon.imageMap = gv_icons[icon]['im']; }
		if (m['letter'] && gv_icons[icon]['letters']) {
			tempIcon.transparent = base_url+'/transparent-'+m['letter'].toUpperCase()+'.png'; // not the most kosher solution, but it seems to work
		} else {
			tempIcon.transparent = base_url+'/'+color.toLowerCase()+rotation+'-t.png';
		}
	}
	
	// overload!!!!
	if (document.location.toString().indexOf('moveon.org') > -1) {
		var color = (m['color']) ? m['color'] : gv_marker_color;
		tempIcon.image = 'http://labs.google.com/ridefinder/images/mm_20_'+color+'.png';
		tempIcon.shadow = 'http://labs.google.com/ridefinder/images/mm_20_shadow.png';
		tempIcon.transparent = null;
	}
	var marker = (google_api_version >= 2) ? new GMarker( new GLatLng(m['lat'],m['lon']), {icon:tempIcon, draggable:false} ) : new GMarker( new GPoint(m['lon'],m['lat']), tempIcon );
	gv_marker_count += 1;
	var iw_html = '';
	if (m['name']) {
		if (m['url'] && m['url'] != null) { iw_html = iw_html + '<b><a target="'+gv_marker_link_target+'" href="'+m['url']+'" title="'+m.url+'">'+m['name']+'</a></b>'; }
		else { iw_html = iw_html + '<b>'+m['name']+'</b>'; }
	}
	if (m['thumbnail'] && !m['photo']) {
		var tn_style = (m['thumbnail_width']) ? ' style="width:'+m['thumbnail_width']+'px;"' : '';
		var thumbnail = '<img class="gv_wpt_thumbnail" src="'+m['thumbnail']+'"'+tn_style+'>';
		if (m['url']) { thumbnail = '<a target="'+gv_marker_link_target+'" href="'+m['url']+'">'+thumbnail+'</A>'; }
		iw_html = iw_html + thumbnail;
	} else if (m['photo']) {
		iw_html = iw_html + '<div><img class="gv_wpt_photo" src="'+m['photo']+'"></div>';
	}
	if (m['desc']) {
		iw_html = iw_html + '<div>' + m['desc'] + '</div>';
	}
	if (m['dd'] || (gv_driving_directions && m['dd']!==false)) {
		iw_html = iw_html + '<table class="gv_driving_directions" cellspacing="0" cellpadding="0" border="0"><tr><td><form action="http://maps.google.com/maps" target="_blank" style="margin:0px;">';
		iw_html = iw_html + '<input type="hidden" name="daddr" value="'+(m['dd_lat']||m['lat'])+','+(m['dd_lon']||m['lon'])+' ('+m['name'].replace(/<[^>]*>/g,'').replace(/"/g,"&quot;")+')'+'">';
		iw_html = iw_html + '<p class="gv_driving_directions_heading" style="margin:2px 0px 4px 0px; white-space:nowrap">Driving directions to this point</p>';
		iw_html = iw_html + '<p style="margin:0px; white-space:nowrap;">Enter your starting address:<br><input type="text" size="20" name="saddr" value="">&nbsp;<input type="submit" value="Go"></p>';
		iw_html = iw_html + '</td></tr></table>';
	}
	var absolute_max_width = (google_api_version >= 2) ? map.getSize().width-100 : 500;
	var window_width = (parseFloat(m['window_width']) < 200) ? 200 : parseFloat(m['window_width']);
	var width_style = (window_width <= absolute_max_width) ? 'width:'+window_width+'px;' : ''; // apparently you can't make it less than 217 (let's leave 17 for the close box though)
	var info_html = '<DIV style="text-align:left; '+width_style+'" class="gv_wpt">'+iw_html+'</DIV>';
	if (iw_html) { GEvent.addListener(marker, "click", function(){ marker.openInfoWindowHtml(info_html, {maxWidth:absolute_max_width}); gv_open_infowindow_index = marker.index; }); }
	
	var out_of_range = false;
	if (gv_filter_waypoints) {
		var min_lat = map.getBounds().getSouthWest().lat();
		var min_lon = map.getBounds().getSouthWest().lng();
		var max_lat = map.getBounds().getNorthEast().lat();
		var max_lon = map.getBounds().getNorthEast().lng();
		if (max_lon < min_lon) { min_lon = -180; max_lon = 180; } // Date Line weirdness
		if (m['lon'] < min_lon || m['lon'] > max_lon || m['lat'] < min_lat || m['lat'] > max_lat) {
			out_of_range = true;
		}
	}
	
	if (m['name'] || m['thumbnail']) {
		if (m['label'] || m['label_id']) { // draw a permanent label
			var label_text = (m['label']) ? m['label'] : m['name'];
			var label_id = (m['label_id']) ? m['label_id'] : gv_marker_array_name+'_label['+(gv_marker_count-1)+']';
			var label_hide = (self.gv_hide_labels && gv_hide_labels) ? true : false;
			var offset_x = gv_label_offset_x; var offset_y = gv_label_offset_y;
			if (m['label_offset'] && m['label_offset'].length > 1) { offset_x = m['label_offset'][0]; offset_y = m['label_offset'][1]; }
			var label = new ELabel(new GLatLng(m['lat'],m['lon']),label_text,"gv_label",new GSize(tempIcon.iconSize.width/2+1+offset_x,8+offset_y),80,false,label_id,label_hide);
			map.addOverlay(label);
			marker.label_object = label;
		}
		if (google_api_version >= 2) {
			// v2 tooltips, adapted from http://www.econym.demon.co.uk/googlemaps/tooltips4.htm
			if (!document.getElementById('gv_tooltip')) { tooltip = GV_Initialize_Marker_Tooltip(map); } // initialize it if it hasn't been done yet
			var tooltip_html = m['name']+' ';
			if (m['thumbnail']) {
				var tn_style = (m['thumbnail_width']) ? ' style="width:'+m['thumbnail_width']+'px;"' : '';
				tooltip_html = tooltip_html + '<img class="gv_wpt_thumbnail" src="'+m['thumbnail']+'"'+tn_style+'>';
			}
			if (m['photo']) { tooltip_html = tooltip_html + '<img class="gv_wpt_photo" src="'+m['photo']+'">'; } // photo is hidden in tooltip but gets pre-loaded!
			marker.tooltip = '<div class="gv_tooltip">'+tooltip_html+'</div>';
			GEvent.addListener(marker,'mouseover', function() { GV_Create_Marker_Tooltip(map,marker); });
			GEvent.addListener(marker,'mouseout', function() { tooltip.style.visibility = 'hidden' });
		} else {
			// v1 tooltips, adapted from http://www.econym.demon.co.uk/googlemaps1/tooltips.htm
			var topElement = marker.images[0];
			if (marker.iconImage) { topElement = marker.iconImage; }
			if (marker.transparentIcon) { topElement = marker.transparentIcon; }
			if (marker.imageMap) { topElement = marker.imageMap; }
			topElement.setAttribute("title",m['name']);
		}
	}
	if (google_api_version >= 2) {
		// This info can be used by other functions, like the "marker list":
		marker.index = gv_marker_count-1;
		marker.name = (m['name']) ? m['name'] : '[unnamed]';
		marker.desc = (m['desc']) ? m['desc'] : '';
		marker.url = (m['url']) ? m['url'] : '';
		marker.shortdesc = (m['shortdesc']) ? m['shortdesc'] : '';
		marker.html = info_html;
		marker.window_width = (m['window_width']) ? m['window_width'] : '';
		marker.color = (m['color']) ? m['color'] : gv_marker_color;
		marker.width = tempIcon.iconSize.width;
		marker.height = tempIcon.iconSize.height;
		marker.image = tempIcon.image;
		marker.coords = new GLatLng(m['lat'],m['lon']);
		marker.thumbnail = (m['thumbnail']) ? m['thumbnail'] : '';
		marker.thumbnail_width = (m['thumbnail_width']) ? m['thumbnail_width'] : '';
		marker.type = (m['type']) ? m['type'] : '';
		
		if (gv_marker_list_exists && (m['type'] != 'tickmark' || gv_marker_list_options['include_tickmarks']) && (m['type'] != 'trackpoint' || gv_marker_list_options['include_trackpoints']) && !m['nolist']) {
			marker.list_html = GV_Marker_List_Item(marker,gv_marker_list_map_name,gv_marker_array_name+'['+(gv_marker_count-1)+']');
			if (!gv_filter_marker_list || !out_of_range) {
				if (gv_marker_list_options['limit'] && gv_marker_list_options['limit'] > 0 && gv_marker_list_count >= gv_marker_list_options['limit']) {
					// do nothing; we're over the limit
				} else {
					if (marker.list_html != 'undefined') {
						gv_marker_list_html += marker.list_html;
						gv_marker_list_count += 1;
					}
				}
			}
		}
	}
	if (!gv_filter_waypoints) { // if filtering is on, the GV_Process_Waypoints & GV_Filter_Waypoints_In_View functions will add them to the map
		map.addOverlay(marker);
	}
	
	return marker;
}

function GV_Initialize_Marker_Tooltip(map) {
	var tt = document.createElement('div');
	tt.id = 'gv_tooltip';
	tt.style.visibility = 'hidden';
	map.getPane(G_MAP_FLOAT_PANE).appendChild(tt);
	return (tt);
}

function GV_Create_Marker_Tooltip(map,marker) {
	// copied almost verbatim from http://www.econym.demon.co.uk/googlemaps/tooltips4.htm
	tooltip.innerHTML = marker.tooltip;
	var point=map.getCurrentMapType().getProjection().fromLatLngToPixel(map.fromDivPixelToLatLng(new GPoint(0,0),true),map.getZoom());
	var offset=map.getCurrentMapType().getProjection().fromLatLngToPixel(marker.getPoint(),map.getZoom());
	var anchor=marker.getIcon().iconAnchor;
	var width=marker.getIcon().iconSize.width;
	var height=tooltip.clientHeight;
	offset.x += -1; offset.y += 4; // a little adjustment
	height = 18; // makes all tooltips hover near the mouse, even if they're tall and have thumbnails or whatnot (they expand downward instead of upward)
	var pos = new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(offset.x - point.x - anchor.x + width, offset.y - point.y -anchor.y -height)); 
	pos.apply(tooltip);
	tooltip.style.visibility = 'visible';
}

function GV_Marker_List() {
	if (gv_marker_list_exists) {
		var header = (gv_marker_list_options['header']) ? gv_marker_list_options['header'] : '';
		var footer = (gv_marker_list_options['footer']) ? gv_marker_list_options['footer'] : '';
		gv_marker_list_div.innerHTML = header+gv_marker_list_html+footer;
		gv_marker_list_count = 0;
	}
	if (document.getElementById(gv_marker_list_div_name+'_handle') && document.getElementById(gv_marker_list_div_name+'_table')) {
		if (!document.getElementById(gv_marker_list_div_name+'_handle').root) { // only needs to be done once
			Drag.init(document.getElementById(gv_marker_list_div_name+'_handle'),document.getElementById(gv_marker_list_div_name+'_table'));
		}
	}
}

function GV_Marker_List_Item(m,map_name,marker_name) {
	var default_color = (gv_marker_list_options['default_color']) ? gv_marker_list_options['default_color'] : '#000000';
	var color = (gv_marker_list_options['colors']) ? m.color : default_color;
	var color_style = 'color:'+color;
	
	var unhide = '';
	var center = (gv_marker_list_options['center']) ? map_name+'.setCenter('+marker_name+'.coords); ' : '';
	var zoom_in = (gv_marker_list_options['zoom']) ? map_name+'.zoomIn(); ' : '';
	var hide_crosshair = (gv_marker_list_options['center'] && document.getElementById('gv_crosshair')) ? "document.getElementById('gv_crosshair').style.display = 'none'; gv_crosshair_temporarily_hidden = true;" : '';
	var open_info_window = (gv_marker_list_options['info_window']) ? 'GEvent.trigger('+marker_name+',\'click\'); ' : '';
	var toggle = (gv_marker_list_options['toggle']) ? 'GV_Toggle_Marker('+map_name+','+marker_name+',this,\''+color+'\');' : '';
	
	var mouseover = (m.tooltip) ? 'onMouseOver="GV_Create_Marker_Tooltip('+map_name+','+marker_name+');" ' : '';
	var mouseout = (m.tooltip) ? 'onMouseOut="tooltip.style.visibility = \'hidden\';" ' : '';
	
	var text_click = unhide+toggle+zoom_in+center+hide_crosshair+open_info_window;
	var icon_click = unhide+zoom_in+center+hide_crosshair+open_info_window;
	
	var thumbnail = '';
	if (m.thumbnail) {
		var tn_display = (gv_marker_list_options['thumbnails']) ? 'display:block; ' : '';
		var tn_width = (m.thumbnail_width) ? 'width:'+m.thumbnail_width+'px; ' : '';
		thumbnail = '<div class="gv_marker_list_thumbnail" style="'+tn_display+'"><img class="gv_wpt_thumbnail" src="'+m.thumbnail+'" style="'+tn_width+tn_display+'"></div>';
	}
	
	var wrap_style = ''; var indent_style = ''; var nobr_open = ''; var nobr_close = ''; var image_align = 'text-top';
	var icon_margin_right = 4;
	if (gv_marker_list_options['wrap_names']) { image_align = 'text-top'; }
	else { wrap_style = 'white-space:nowrap; '; nobr_open ='<nobr>'; nobr_close = '</nobr>'; }
	if (1==2 && gv_marker_list_options['wrap_names'] && gv_marker_list_options['icons']) { indent_style = 'margin-left:'+(m.width+icon_margin_right)+'px; text-indent:-'+(m.width+icon_margin_right)+'px '; } // 1==2 because we don't need this when we're doing "float:left" on the icons
	var icon_scaling = 'width:'+m.width+'px; height:'+m.height+'px';
	var icon = (gv_marker_list_options['icons']) ? '<img class="icon" '+mouseover+mouseout+'onClick="'+icon_click+'" style="vertical-align:'+image_align+'; '+icon_scaling+'" src="'+m.image+'" alt="">' : '';
	var name = '<wbr/><span '+mouseover+mouseout+'onClick="'+text_click+'" class="name" style="'+wrap_style+'cursor:crosshair; '+color_style+';">'+m.name + thumbnail + '<'+'/span>';
	name = (gv_marker_list_options['url_links'] && m.url) ? '<a target="'+gv_marker_link_target+'" href="'+m.url+'" title="'+m.url+'">'+name+'</a>' : name;
	var d = (m.shortdesc) ? m.shortdesc : m.desc;
	var desc = (gv_marker_list_options['desc'] && d) ? '<div style="clear:both;"><span class="desc" style="'+color_style+'">'+d+'<'+'/span>'+'<'+'/div>' : '';
	var first = (gv_marker_count == 1) ? ' gv_marker_list_first_item' : '';
	var html = '<div id="gv_list:'+marker_name+'" class="gv_marker_list_item'+first+'" style="'+indent_style+'">' + nobr_open + icon + name + nobr_close + desc + '</div><div class="gv_marker_list_item_bottom" style="clear:both;"></div>'+"\n";
	return (html);
}

function GV_Toggle_Marker(map,marker,link,link_color,dimmed_color) {
	if (marker.gv_hidden) {
		map.addOverlay(marker);
		marker.gv_hidden = false;
	} else {
		map.removeOverlay(marker);
		marker.gv_hidden = true;
	}
	if (link_color && link.style.color) {
		link_color = Color_Hex2CSS(link_color);
		dimmed_color = (dimmed_color) ? Color_Hex2CSS(dimmed_color) : Color_Hex2CSS('#999999');
		if (marker.gv_hidden) { link.style.color = dimmed_color; }
		else { link.style.color = link_color; }
	}
}

function GV_Toggle_All_Labels(marker_array_name,force_show) {
	var label_visibility;
	if (force_show || (self.gv_hide_labels && gv_hide_labels == true)) {
		label_visibility = 'visible';
		gv_labels_are_visible = true;
		gv_hide_labels = false;
	} else {
		label_visibility = 'hidden';
		gv_labels_are_visible = false;
		gv_hide_labels = true;
	}
	if (eval('self.'+marker_array_name)) {
		var marker_array = eval(marker_array_name);
		if (marker_array && marker_array.length > 0) {
			for (i=0; i<marker_array.length; i++) {
				var label_id = marker_array_name+'_label['+i+']';
				if (document.getElementById(label_id)) {
					// Note that it's the parentNode -- the div containing the label -- that gets hidden or shown
					document.getElementById(label_id).parentNode.style.visibility = label_visibility;
				}
			}
		}
	}
}

function GV_Toggle_Track_And_Label(map,id,color) {
	if (!color) { // older versions of this function only had two parameters
		color = id; id = map; map = gmap;
	} 
	GV_Toggle_Overlays(map,eval(id)); // this one ("trkX") is stored in a variable
	GV_Toggle_Label_Opacity(document.getElementById(id+'_label'),color); // this one ("trkX_label") is a page element
}

function GV_Toggle_Overlays(map,overlay_array) {
	if (google_api_version >= 2) {
		if (overlay_array.gv_hidden) {
			if (!overlay_array.gv_oor) { // don't turn it on if it's "out of range"
				for (j=0; j<overlay_array.length; j++) {
					map.addOverlay(overlay_array[j]);
					if (overlay_array[j].label_object) { map.addOverlay(overlay_array[j].label_object); }
				}
			}
			overlay_array.gv_hidden = false;
		} else {
			for (j=0; j<overlay_array.length; j++) {
				map.removeOverlay(overlay_array[j]);
				if (overlay_array[j].label_object) { map.removeOverlay(overlay_array[j].label_object); }
			}
			overlay_array.gv_hidden = true;
		}
	} else {
		for (j=0; j<overlay_array.length; j++) {
			var item = overlay_array[j];
			if (eval(item.drawElement)) {
				if (item.drawElement.style.display == 'none') { item.drawElement.style.display = ''; }
				else { item.drawElement.style.display = 'none'; }
			} else if (eval(item.images)) {
				for (var i=0; i < item.images.length; i++) {
					if (item.images[i].style.display == 'none') { item.images[i].style.display = ''; }
					else { item.images[i].style.display = 'none'; }
				}
			}
		}
	}
}

function GV_Toggle_Label_Opacity(label,original_color) {
	original_color = Color_Hex2CSS(original_color);
	current_color = Color_Hex2CSS(label.style.color);
	dimmed_color = Color_Hex2CSS('#AAAAAA');
//	if (current_color == dimmed_color) { label.style.color = original_color; }
//	else { label.style.color = dimmed_color; }
	if (label.gv_hidden) { label.gv_hidden = false; label.style.color = original_color; }
	else { label.gv_hidden = true; label.style.color = dimmed_color; }
}

function GV_Toggle(id) {
	if (document.getElementById(id).style.display == 'none') {
		document.getElementById(id).style.display = '';
	} else {
		document.getElementById(id).style.display = 'none';
	}
}
function GV_Windowshade_Setup(handle_id,box_id) {
	if (document.getElementById(handle_id) && document.getElementById(box_id)) {
		GEvent.addDomListener(document.getElementById(handle_id), "dblclick", function(){ 
			if (document.getElementById(box_id).style.visibility == 'hidden') {
				document.getElementById(box_id).style.visibility = 'visible';
				document.getElementById(box_id).style.display = 'block';
			} else {
				document.getElementById(handle_id).style.width = (document.getElementById(box_id).parentNode.clientWidth-2)+'px'; // -2 for the border
				document.getElementById(box_id).style.visibility = 'hidden';
				document.getElementById(box_id).style.display = 'none';
			}
		});
	}
}


function GV_Filter_Tracks (map,info) {
	if (info == null || info == undefined || typeof(info) != 'object') { return false; }
	var trk_array_name = (gv_options && gv_options['track_array'] && eval('self.'+gv_options['track_array'])) ? gv_options['track_array'] : 'trk';
	var min_lat = map.getBounds().getSouthWest().lat();
	var min_lon = map.getBounds().getSouthWest().lng();
	var max_lat = map.getBounds().getNorthEast().lat();
	var max_lon = map.getBounds().getNorthEast().lng();
	if (max_lon < min_lon) { min_lon = -180; max_lon = 180; } // Date Line weirdness
	if (info[1]) { // new style: the bounds are in trk_info[n]['bounds'], and there's (almost) always a trk_info[1].
		for (var t in info) {
			if (info[t]['bounds']['e'] < min_lon || info[t]['bounds']['w'] > max_lon || info[t]['bounds']['n'] < min_lat || info[t]['bounds']['s'] > max_lat) {
				GV_Track_OutOfRange(map,eval(trk_array_name+'[\''+t+'\']'),true);
			} else {
				GV_Track_OutOfRange(map,eval(trk_array_name+'[\''+t+'\']'),false);
			}
		}
	} else { // old style: bounds are directly in the trk_info hash
		for (var t in info) {
			if (info[t]['e'] < min_lon || info[t]['w'] > max_lon || info[t]['n'] < min_lat || info[t]['s'] > max_lat) {
				GV_Track_OutOfRange(map,eval(t),true);
			} else {
				GV_Track_OutOfRange(map,eval(t),false);
			}
		}
	}
}
function GV_Track_OutOfRange (map,trk_array,is_oor) {
	if (is_oor) {
		if (!trk_array.gv_hidden) { // if it's already hidden, there's nothing to do
			for (j=0; j<trk_array.length; j++) { map.removeOverlay(trk_array[j]); }
		}
		trk_array.gv_oor = true;
	} else {
		if (trk_array.gv_oor) { // only add it if it was previously out of range
			if (!trk_array.gv_hidden) { // if it's supposed to be hidden, don't show it
				for (j=0; j<trk_array.length; j++) { map.addOverlay(trk_array[j]); }
			}
		}
		trk_array.gv_oor = false;
	}
}

function GV_Filter_Waypoints_In_View (map,wpt_array) {
	var limit = (gv_marker_filter_options['limit'] > 0) ? gv_marker_filter_options['limit'] : 0;
	var update_list = (gv_marker_filter_options['update_list']) ? true : false;
	var sort_list_by_distance = (gv_marker_filter_options['sort_list_by_distance']) ? true : false;
	var min_lat = map.getBounds().getSouthWest().lat();
	var min_lon = map.getBounds().getSouthWest().lng();
	var max_lat = map.getBounds().getNorthEast().lat();
	var max_lon = map.getBounds().getNorthEast().lng();
	if (max_lon < min_lon) { min_lon = -180; max_lon = 180; } // Date Line weirdness
	if (gv_marker_list_exists && update_list) {
		gv_marker_list_html = '';
		gv_marker_list_count = 0;
	}
	var min_zoom = (gv_marker_filter_options['min_zoom'] && gv_marker_filter_options['min_zoom'] > 0) ? gv_marker_filter_options['min_zoom'] : 0;
	var show_no_markers = (map.getZoom() >= min_zoom) ? false : true;
	var to_be_added = new Array();
	for (j=0; j<wpt_array.length; j++) {
		var w = wpt_array[j];
		map.removeOverlay(w);
		if (w.label_object) {
			map.removeOverlay(w.label_object);
		}
		if (show_no_markers) {
			// we're in "don't show anything" mode, so there's no point in doing calculations
		} else {
			if (w.coords.lng() < min_lon || w.coords.lng() > max_lon || w.coords.lat() < min_lat || w.coords.lat() > max_lat) {
				// do nothing; it's out of range
			} else {
				if (!limit && !update_list) { // add everything that's in the viewport
					to_be_added.push(j);
				} else {
					if (limit > 0 || sort_list_by_distance) {
						w.dist_from_center = map.getCenter().distanceFrom(w.coords);
						var key = (w.dist_from_center/10000000).toFixed(8);
						to_be_added.push(key+' '+j);
					} else {
						to_be_added.push(j);
					}
				}
			}
		}
	}
	if (show_no_markers) {
		if (map.getZoom() < min_zoom) {
			gv_marker_list_html = (gv_marker_list_options['zoom_message'] && gv_marker_list_options['zoom_message'] != '') ? gv_marker_list_options['zoom_message'] : '<p>Zoom in further to see markers.</p>';
		}
	} else {
		if (limit > 0 || (sort_list_by_distance && update_list)) {
			to_be_added = to_be_added.sort();
			if (limit > 0 && limit < to_be_added.length) { to_be_added.length = limit; }
			for (j=0; j<to_be_added.length; j++) {
				var parts = to_be_added[j].split(' ');
				to_be_added[j] = parseInt(parts[1]);
			}
			if (!sort_list_by_distance) { // back to the original order
				to_be_added = to_be_added.sort(function(a,b){ return(a-b) });
			}
		}
		for (j=0; j<to_be_added.length; j++) {
			var w = wpt_array[to_be_added[j]];
			if (!w.gv_hidden) { // if it's supposed to be hidden, don't show it
				map.addOverlay(w);
				if (w.label_object) {
					map.addOverlay(w.label_object);
				}
			}
			if (gv_marker_list_exists && update_list && (w.type != 'tickmark' || gv_marker_list_options['include_tickmarks']) && (w.type != 'trackpoint' || gv_marker_list_options['include_trackpoints']) && !w.nolist) {
				if (limit > 0 && gv_marker_list_count >= limit) {
					// do nothing; we're over the limit
				} else {
					if (w.list_html != 'undefined') {
						gv_marker_list_html += w.list_html;
						gv_marker_list_count += 1;
					}
				}
			}
		}
	}
}

function GV_Filter_Waypoints (map,wpt_array) { // For backwards compatibility
	GV_Process_Waypoints(map,wpt_array);
}

function GV_Recenter_Per_URL(opts) {
	var new_center = null; var new_zoom = null; var hide_crosshair = false;
	var map = (opts && opts['map'] && eval('self.'+opts['map'])) ? eval(opts['map']) : null;
	if (map == null) { if (self.gmap) { map = gmap; } else { return false; } }
	var center_key = (opts && opts['center_key']) ? opts['center_key'] : 'center';
	var zoom_key = (opts && opts['zoom_key']) ? opts['zoom_key'] : 'zoom';
	
	var zoom_pattern = new RegExp('[&\\?]'+zoom_key+'=([0-9]+)','i');
	if (document.location.toString().match(zoom_pattern)) {
		var zoom_match = zoom_pattern.exec(document.location.toString());
		if (zoom_match && zoom_match[1]) { // the appropriate variable was found in the URL's query string
			var z = unescape(zoom_match[1]);
			if (z.match(/[0-9]/)) {
				z = parseFloat(z); if (z > 19) { z = 19; } if (z < 0) { z = 0; }
				new_zoom = z;
			}
		}
	}
	var center_pattern = new RegExp('[&\\?]'+center_key+'=([^&]+)','i');
	if (document.location.toString().match(center_pattern)) {
		var center_match = center_pattern.exec(document.location.toString());
		if (center_match && center_match[1]) {
			// the appropriate variable was found in the URL's query string
			var c = center_match[1].replace(/\+/g,' ');
			c = unescape(c);
			var coordinate_pattern = new RegExp('([NS])? *(-?[0-9]*\.?[0-9]*) *([NS])? *, *([EW])? *(-?[0-9]*\.?[0-9]*) *([EW])?','i');
			if (c.match(coordinate_pattern)) { // the query looks like a pair of numeric coordinates
				var coordinate_match = coordinate_pattern.exec(c.toUpperCase());
				if (coordinate_match && coordinate_match[2] != null && coordinate_match[5] != null) {
					var lat = parseFloat(coordinate_match[2]); var lon = parseFloat(coordinate_match[5]);
					if (coordinate_match[1] == 'S' || coordinate_match[3] == 'S') { lat = 0 - lat; }
					if (coordinate_match[4] == 'W' || coordinate_match[6] == 'W') { lon = 0 - lon; }
					if (Math.abs(lat) <= 90 && Math.abs(lon) <= 180) {
						new_center = new GLatLng(lat,lon);
					}
				}
			} else { // they didn't request a coordinate pair, so look to see if any waypoint's name matches the query
				var marker_array = (opts && opts['marker_array'] && eval('self.'+opts['marker_array'])) ? eval(opts['marker_array']) : null;
				if (marker_array == null) { if (self.wpts) { marker_array = wpts; } else { return false; } }
				for (i=0; i<marker_array.length; i++) {
					if (marker_array[i].name == c) {
						new_center = marker_array[i].coords;
						hide_crosshair = true;
					}
				}
			}
		}
	}
	if (new_center) {
		if (new_zoom) {
			map.setCenter(new_center,new_zoom);
		} else {
			map.setCenter(new_center);
		}
		if (hide_crosshair && document.getElementById('gv_crosshair')) {
			document.getElementById('gv_crosshair').style.display = 'none';
			gv_crosshair_temporarily_hidden = true;
		}
		return true;
	} else if (new_zoom) {
		map.setZoom(new_zoom);
		return true;
	} else {
		return false;
	}
}

function GV_Setup_Crosshair(map,opts) {
	if (!opts['crosshair_container_id']) { opts['crosshair_container_id'] = 'gv_crosshair_container'; }
	if (!opts['crosshair_graphic_id']) { opts['crosshair_graphic_id'] = 'gv_crosshair'; }
	if (!opts['crosshair_width']) { opts['crosshair_width'] = 15; }
	if (!opts['center_coordinates_id']) { opts['center_coordinates_id'] = 'gv_center_coordinates'; }
	
	GV_Recenter_Crosshair(map,opts['crosshair_container_id'],opts['crosshair_width']);
	GV_Show_Center_Coordinates(gmap,opts['center_coordinates_id']);
	GEvent.addListener(map, "moveend", function() {
		GV_Show_Hidden_Crosshair(map,opts['crosshair_graphic_id']);
		GV_Show_Center_Coordinates(map,opts['center_coordinates_id']);
	});
	// if (opts['fullscreen'] || opts['full_screen']) {
		GEvent.addListener(map, "resize", function() {
			GV_Recenter_Crosshair(map,opts['crosshair_container_id'],opts['crosshair_width']);
			GV_Show_Hidden_Crosshair(map,opts['crosshair_graphic_id']);
			GV_Show_Center_Coordinates(map,opts['center_coordinates_id']);
		});
	// }
	
}

function GV_Show_Center_Coordinates(map,id) {
	if (document.getElementById(id)) {
		var lat = map.getCenter().lat().toFixed(5);
		var lng = map.getCenter().lng().toFixed(5);
		document.getElementById(id).innerHTML = "Center: "+lat+","+lng;
	}
	gv_last_center = map.getCenter(); // this will come in handy; make sure it happens AFTER the crosshair is potentially unhidden
}

var gv_crosshair_temporarily_hidden = true;
function GV_Show_Hidden_Crosshair(map,id) {
	// only do something upon the FIRST movement of the map, or when it's been hidden, e.g. because of a centering action
	if (self.gv_crosshair_temporarily_hidden && (!self.gv_last_center || gv_last_center.lat() != map.getCenter().lat() || gv_last_center.lng() != map.getCenter().lng())) {
		if (self.gv_hidden_crosshair_is_still_hidden && gv_hidden_crosshair_is_still_hidden == true) {
			// don't do anything
		} else {
			document.getElementById(id).style.display = 'block';
			gv_crosshair_temporarily_hidden = false;
		}
	}
}

function GV_Recenter_Crosshair(map,container_id,crosshair_size) {
	if (document.getElementById(container_id)) {
		if (document.getElementById(container_id).align) { // in the older version, we always used align="left" in the DIV
			document.getElementById(container_id).style.position = 'absolute';
			document.getElementById(container_id).style.top = Math.round(map.getContainer().clientHeight/2-(crosshair_size/2))+'px';
			document.getElementById(container_id).style.left = Math.round(map.getContainer().clientWidth/2-(crosshair_size/2))+'px';
		} else {
			var x = Math.round(map.getContainer().clientWidth/2-(crosshair_size/2));
			var y = Math.round(map.getContainer().clientHeight/2-(crosshair_size/2));
			GV_Place_Control(map,container_id,G_ANCHOR_TOP_LEFT,x,y);
		}
	}
}

function GV_Place_Control(map,control_id,anchor,x,y) {
	if (document.getElementById(control_id)) {
		document.getElementById(control_id).style.display = 'block';
		var gv_position = new GControlPosition(anchor, new GSize(x,y));
		gv_position.apply(document.getElementById(control_id));
		map.getContainer().appendChild(document.getElementById(control_id));
	}
}

function GV_Background_Opacity(map,opacity) {
	if (opacity == null) { return; }
	if (opacity <= 0) { opacity = 0; }
	else if (opacity > 1) { opacity = opacity/100; }
	gv_bg_opacity = opacity; // this is a global and absolutely necessary for the "moveend" listener
	var screen_opacity = 1-opacity; // this function alters the screen, not the bg
	var id = 'gv_opacity_screen';
	if (!document.getElementById(id)) {
		var new_screen = document.createElement("div");
		new_screen.id = id;
		new_screen.className = 'gmnoprint';
		new_screen.style.position = "absolute";
		new_screen.style.backgroundColor = "#ffffff";
		new_screen.style.opacity = screen_opacity;
		new_screen.style.filter = "alpha(opacity="+screen_opacity*100+")";
		new_screen.style.KhtmlOpacity = screen_opacity;
		new_screen.style.MozOpacity = screen_opacity;
		map.getPane(G_MAP_MAP_PANE).appendChild(new_screen);
		GEvent.addListener(map, "moveend", function() {
			GV_Background_Opacity(map,eval('gv_bg_opacity'));
		});
	}
	GV_Update_Background_Screen(map,id,screen_opacity);
}
function GV_Update_Background_Screen(map,id,screen_opacity) {
	if (map && document.getElementById(id) && screen_opacity != null) {
		var screen = document.getElementById(id);
		var screen_scale = 3; // how many times bigger than the current width & height is it?
		var map_width = map.getSize().width;
		var map_height = map.getSize().height;
		var nw = new GLatLng(map.getBounds().getNorthEast().lat(),map.getBounds().getSouthWest().lng());
		var offset = map.fromLatLngToDivPixel(nw);
		screen.style.opacity = screen_opacity;
		screen.style.filter = "alpha(opacity="+screen_opacity*100+")";
		screen.style.KhtmlOpacity = screen_opacity;
		screen.style.MozOpacity = screen_opacity;
		screen.style.left = offset.x-(map_width*((screen_scale-1)/2))+"px"; screen.style.top = offset.y-(map_height*((screen_scale-1)/2))+"px";
		screen.style.width = screen_scale*map_width+"px"; screen.style.height = screen_scale*map_height+"px";
		if (document.getElementById('gv_opacity_selector')) {
			var op_menu = document.getElementById('gv_opacity_selector');
			for (i=0; i<op_menu.length; i++) {
				if (op_menu[i].value != '' && op_menu[i].value == Math.round(100*(1-screen_opacity))/100) {
					op_menu.selectedIndex = i;
				}
			}
		}
	}
}

function GV_Fill_Window_With_Map(mapdiv_id) {
	if (!document.getElementById(mapdiv_id)) { return false; }
	var mapdiv = document.getElementById(mapdiv_id);
	var window_size = GV_GetWindowSize();
	mapdiv.style.position = 'absolute';
	mapdiv.style.left = '0px';
	mapdiv.style.top = '0px';
	mapdiv.style.width = window_size[0]+'px';
	mapdiv.style.height = window_size[1]+'px';
}
function GV_GetWindowSize() {
	// from http://www.quirksmode.org/viewport/compatibility.html
	var x,y;
	if (window.innerHeight) { // all except Explorer
		x = window.innerWidth;
		y = window.innerHeight;
	} else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
		x = document.documentElement.clientWidth;
		y = document.documentElement.clientHeight;
	} else if (document.body) { // other Explorers
		x = document.body.clientWidth;
		y = document.body.clientHeight;
	}
	return [x,y];
}

function GV_MouseWheel(e) {
	if (!e || !self.gmap) { return false; }
	if (e.detail) { // Firefox
		if (e.detail < 0) { gmap.zoomIn(); }
		else if (e.detail > 0) { gmap.zoomOut(); }
	} else if (e.wheelDelta) { // IE
		if (e.wheelDelta > 0) { gmap.zoomIn(); }
		else if (e.wheelDelta < 0) { gmap.zoomOut(); }
	}
}
function GV_MouseWheelReverse(e) {
	if (!e || !self.gmap) { return false; }
	if (e.detail) { // Firefox
		if (e.detail < 0) { gmap.zoomOut(); }
		else if (e.detail > 0) { gmap.zoomIn(); }
	} else if (e.wheelDelta) { // IE
		if (e.wheelDelta > 0) { gmap.zoomOut(); }
		else if (e.wheelDelta < 0) { gmap.zoomIn(); }
	}
}

function Color_Hex2CSS(c) {
	if (c == null) { return null; }
	var rgb = new Array(); rgb = c.match(/([A-F0-9]{2})([A-F0-9]{2})([A-F0-9]{2})/i);
	if (rgb) {
		return ('rgb('+parseInt(rgb[1],16)+','+parseInt(rgb[2],16)+','+parseInt(rgb[3],16)+')');
	} else {
		return (c.replace(/ +/g,''));
	}
}
function GV_Color_Name2Hex(color_name) {
	if (color_name.match(/^#[A-F0-9][A-F0-9][A-F0-9][A-F0-9][A-F0-9][A-F0-9]$/i)) { return color_name; }
	var c = new Array();
	c['aqua'] = '#00FFFF'; c['black'] = '#000000'; c['blue'] = '#0000FF'; c['brown'] = '#7A4328';
	c['cyan'] = '#00FFFF'; c['default'] = '#FF776B'; c['fuchsia'] = '#FF00FF'; c['gray'] = '#AAAAAA';
	c['green'] = '#009900'; c['grey'] = '#AAAAAA'; c['lime'] = '#00FF00'; c['magenta'] = '#FF00FF';
	c['maroon'] = '#800000'; c['navy'] = '#000080'; c['olive'] = '#808000'; c['orange'] = '#FF6600';
	c['pink'] = '#FF99CC'; c['purple'] = '#990099'; c['red'] = '#FF0000'; c['silver'] = '#808080';
	c['tan'] = '#C1945F'; c['teal'] = '#008080'; c['violet'] = '#6600FF'; c['white'] = '#FFFFFF';
	c['yellow'] = '#FFFF00';
	var color_name_trimmed = color_name.replace(/^\#/,'');
	if (c[color_name_trimmed]) { return c[color_name_trimmed]; } else { return color_name_trimmed; }
}



/**************************************************
 * Custom map layers:
 * Adapted from Jef Poskanzer's Acme Mapper
 * (http://mapper.acme.com/)
 **************************************************/
if (google_api_version >= 2) {
	USGS_TOPO_TILES = WMSCreateMap([{name:'Topo',copyright:'Topo maps by USGS via terraserver-usa.com',errorMessage:'Topo maps unavailable',minResolution:5,maxResolution:17,tileSize:400,baseUrl:'http://terraservice.net/ogcmap6.ashx?version=1.1.1&request=GetMap&styles=&srs=EPSG:4326&format=image/jpeg&bgcolor=0xCCCCCC&exceptions=INIMAGE&layers=DRG'}]);
	USGS_AERIAL_TILES = WMSCreateMap([{name:'Aerial',copyright:'Imagery by USGS via terraserver-usa.com',errorMessage:'USGS aerial imagery unavailable',minResolution:7,maxResolution:18,tileSize:400,baseUrl:'http://terraservice.net/ogcmap6.ashx?version=1.1.1&request=GetMap&styles=&srs=EPSG:4326&format=image/jpeg&bgcolor=0xCCCCCC&exceptions=INIMAGE&layers=DOQ'}]);
	USGS_AERIAL_HYBRID_TILES = WMSCreateMap([{name:'Aerial+',copyright:'Imagery by USGS via terraserver-usa.com',errorMessage:'USGS aerial imagery unavailable',minResolution:7,maxResolution:18,tileSize:256,baseUrl:'http://terraservice.net/ogcmap6.ashx?version=1.1.1&request=GetMap&styles=&srs=EPSG:4326&format=image/jpeg&bgcolor=0xCCCCCC&exceptions=INIMAGE&layers=DOQ',foreground:'G_HYBRID_MAP'}]);
	NRCAN_TOPO_TILES = WMSCreateMap([{name:'NRCan',copyright:'Maps by NRCan.gc.ca',errorMessage:'NRCan maps unavailable',minResolution:6,maxResolution:18,tileSize:600,baseUrl:'http://wms.cits.rncan.gc.ca/cgi-bin/cubeserv.cgi?version=1.1.3&request=GetMap&format=image/png&bgcolor=0xFFFFFF&exceptions=application/vnd.ogc.se_inimage&srs=EPSG:4326&layers=PUB_50K:CARTES_MATRICIELLES/RASTER_MAPS'}]);
	NRCAN_TOPO_NAMES_TILES = WMSCreateMap([{name:'NRCan+',copyright:'Maps by NRCan.gc.ca',errorMessage:'NRCan maps unavailable',minResolution:11,maxResolution:18,tileSize:600,baseUrl:'http://wms.cits.rncan.gc.ca/cgi-bin/cubeserv.cgi?version=1.1.3&request=GetMap&format=image/png&bgcolor=0xFFFFFF&exceptions=application/vnd.ogc.se_inimage&srs=EPSG:4326&layers=PUB_50K:CARTES_MATRICIELLES/RASTER_MAPS,TOPONYME_0:BNDT_50K/NTDB_50K'}]);
	NEXRAD_TILES = WMSCreateMap([{name:'NEXRAD',copyright:'NEXRAD imagery from Iowa Environmental Mesonet',errorMessage:'NEXRAD imagery unavailable',minResolution:3,maxResolution:14,tileSize:256,baseUrl:'http://mesonet.agron.iastate.edu/cgi-bin/wms/nexrad/n0r.cgi?version=1.1.1&request=GetMap&service=WMS&srs=EPSG:4326&format=image/png&transparent=true&styles=&layers=nexrad-n0r',opacity:0.7,background:'G_HYBRID_MAP'}]); // NOTE: for combo maps using Google tiles, tileSize MUST be 256!!!
	LANDSAT_TILES = WMSCreateMap([{name:'Landsat',copyright:'Map by NASA',errorMessage:'OnEarth server unavailable',minResolution:3,maxResolution:15,tileSize:260,baseUrl:'http://onearth.jpl.nasa.gov/wms.cgi?request=GetMap&styles=&srs=EPSG:4326&format=image/jpeg&layers=global_mosaic'}]);
	BLUEMARBLE_TILES = WMSCreateMap([{name:'BlueMarble',copyright:'Map by NASA',errorMessage:'OnEarth server unavailable',minResolution:3,maxResolution:8,tileSize:260,baseUrl:'http://onearth.jpl.nasa.gov/wms.cgi?request=GetMap&styles=&srs=EPSG:4326&format=image/jpeg&layers=modis'}]);
	// BLUEMARBLE_TILES = WMSCreateMap([{name:'BlueMarble',copyright:'Map by DEMIS',errorMessage:'DEMIS server unavailable',minResolution:3,maxResolution:8,tileSize:260,baseUrl:'http://www2.demis.nl/wms/wms.asp?service=WMS&wms=BlueMarble&wmtver=1.0.0&request=GetMap&srs=EPSG:4326&format=jpeg&transparent=false&exceptions=inimage&wrapdateline=true&layers=Earth+Image,Borders'}]);
	DAILY_TERRA_TILES = WMSCreateMap([{name:'"Terra"',copyright:'Map by NASA',errorMessage:'OnEarth server unavailable',minResolution:3,maxResolution:10,tileSize:260,baseUrl:'http://onearth.jpl.nasa.gov/wms.cgi?request=GetMap&styles=&srs=EPSG:4326&format=image/jpeg&layers=daily_terra'}]);
	DAILY_AQUA_TILES = WMSCreateMap([{name:'"Aqua"',copyright:'Map by NASA',errorMessage:'OnEarth server unavailable',minResolution:3,maxResolution:10,tileSize:260,baseUrl:'http://onearth.jpl.nasa.gov/wms.cgi?request=GetMap&styles=&srs=EPSG:4326&format=image/jpeg&layers=daily_aqua'}]);
	SRTM_COLOR_TILES = WMSCreateMap([{name:'SRTM',copyright:'SRTM elevation data by NASA',errorMessage:'SRTM elevation data unavailable',minResolution:6,maxResolution:14,tileSize:260,baseUrl:'http://onearth.jpl.nasa.gov/wms.cgi?request=GetMap&srs=EPSG:4326&format=image/jpeg&styles=&layers=huemapped_srtm'}]);
}

function GV_Add_Custom_Layers(map) {
	map.addMapType(USGS_TOPO_TILES);
	map.addMapType(USGS_AERIAL_TILES);
	map.addMapType(USGS_AERIAL_HYBRID_TILES);
	map.addMapType(NEXRAD_TILES);
	map.addMapType(NRCAN_TOPO_TILES);
	map.addMapType(NRCAN_TOPO_NAMES_TILES);
	map.addMapType(LANDSAT_TILES);
	map.addMapType(BLUEMARBLE_TILES);
	map.addMapType(DAILY_TERRA_TILES);
	// map.addMapType(DAILY_TERRA_HYBRID_TILES);
	map.addMapType(DAILY_AQUA_TILES);
	// map.addMapType(DAILY_AQUA_HYBRID_TILES);
	map.addMapType(SRTM_COLOR_TILES);
	// map.addMapType(SRTM_COLOR_HYBRID_TILES);
}

/**************************************************
 * Custom map-type control:
 * more or less from Google's own documentation
 **************************************************/
function GV_MapTypeControl(options) {
	this.control_style = (options && options['style'] != null) ? options['style'] : gv_maptypecontrol_style;
	this.filter_map_types = (options && options['filter'] != null) ? options['filter'] : gv_filter_map_types;
	this.excluded_map_types = (options && options['excluded'] != null) ? options['excluded'] : this.excluded_map_types;
}
if (google_api_version >= 2) {
	GV_MapTypeControl.prototype = new GControl();
	GV_MapTypeControl.prototype.getDefaultPosition = function() {
		return new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(7,7));
	}
	GV_MapTypeControl.prototype.initialize = function(map) {
		GV_Add_Custom_Layers(map);
		var map_types = new Array();
		map_types.push(
			{ label:'G. map',type:'G_NORMAL_MAP',title:'Google street map',bounds:[-180,-90,180,90],excluded:[] }
			,{ label:'G. satellite',type:'G_SATELLITE_MAP',title:'Google satellite map',bounds:[-180,-90,180,90],excluded:[] }
			,{ label:'G. hybrid',type:'G_HYBRID_MAP',title:'Google "hybrid" map',bounds:[-180,-90,180,90],excluded:[] }
		);
		if (self.G_PHYSICAL_MAP) {
			map_types.push( { label:'G. terrain',type:'G_PHYSICAL_MAP',title:'Google terrain map',bounds:[-180,-90,180,90],excluded:[] } );
		}
		map_types.push(
			{ label:'USGS topo',type:'USGS_TOPO_TILES',title:'USGS topographic map',bounds:[-169,18,-66,72],excluded:[],country:'us' }
			,{ label:'USGS aerial',type:'USGS_AERIAL_TILES',title:'USGS aerial photos (black/white)',bounds:[-152,17,-65,65],excluded:[],country:'us' }
			,{ label:'USGS aerial+G.',type:'USGS_AERIAL_HYBRID_TILES',title:'USGS aerial photos (black/white) + Google street map',bounds:[-152,17,-65,65],excluded:[],country:'us' }
			,{ label:'U.S. Nexrad',type:'NEXRAD_TILES',title:'United States NEXRAD weather radar',bounds:[-152,17,-65,65],excluded:[],country:'us' }
			,{ label:'Canada topo',type:'NRCAN_TOPO_TILES',title:'NRCan/Toporama maps with contour lines',bounds:[-141,41.7,-52,85],excluded:[-141,41.7,-86,48],country:'ca' }
			,{ label:'Can. topo+names',type:'NRCAN_TOPO_NAMES_TILES',title:'NRCan/Toporama topo maps with feature names',bounds:[-141,41.7,-52,85],excluded:[-141,41.7,-86,48],country:'ca' }
			,{ label:'Landsat 30m',type:'LANDSAT_TILES',title:'NASA Landsat 30-meter imagery',bounds:[-180,-90,180,90],excluded:[] }
			,{ label:'Blue Marble',type:'BLUEMARBLE_TILES',title:'NASA "Visible Earth" image',bounds:[-180,-90,180,90],excluded:[] }
			,{ label:'Daily "Terra"',type:'DAILY_TERRA_TILES',title:'Daily imagery from "Terra" satellite',bounds:[-180,-90,180,90],excluded:[] }
			// ,{ label:'"Terra"+Google',type:'DAILY_TERRA_HYBRID_TILES',title:'Daily imagery from "Terra" satellite + Google street map',bounds:[-180,-90,180,90],excluded:[] }
			,{ label:'Daily "Aqua"',type:'DAILY_AQUA_TILES',title:'Daily imagery from "Aqua" satellite',bounds:[-180,-90,180,90],excluded:[] }
			// ,{ label:'"Aqua"+Google',type:'DAILY_AQUA_HYBRID_TILES',title:'Daily imagery from "Aqua" satellite + Google street map',bounds:[-180,-90,180,90],excluded:[] }
			,{ label:'SRTM elevation',type:'SRTM_COLOR_TILES',title:'SRTM elevation data, as color',bounds:[-180,-90,180,90],excluded:[] }
			// ,{ label:'SRTM elev.+G.',type:'SRTM_COLOR_HYBRID_TILES',title:'SRTM elevation data, as color + Google street map',bounds:[-180,-90,180,90],excluded:[] }
		);
		if (self.gv_custom_map_types && gv_custom_map_types.length > 0) {
			for (j=0; j<gv_custom_map_types.length; j++) { map_types.push(gv_custom_map_types[j]); }
		}
		var center_lat = map.getCenter().lat();
		var center_lng = map.getCenter().lng();
		
		var excluded_maps = new Array;
		if (this.filter_map_types && this.excluded_map_types) {
			for (j=0; j<this.excluded_map_types.length; j++) {
				excluded_maps[this.excluded_map_types[j]] = true;
			}
		}
		for (j=0; j<map_types.length; j++) {
			if (self.gv_country && gv_country) {
				if (map_types[j]['country'] && map_types[j]['country'].indexOf(gv_country) < 0) {
					excluded_maps[map_types[j]['type']] = true;
				}
			} else {
				if (!(center_lng >= map_types[j]['bounds'][0] && center_lat >= map_types[j]['bounds'][1] && center_lng <= map_types[j]['bounds'][2] && center_lat <= map_types[j]['bounds'][3]) || (center_lng >= map_types[j]['excluded'][0] && center_lat >= map_types[j]['excluded'][1] && center_lng <= map_types[j]['excluded'][2] && center_lat <= map_types[j]['excluded'][3]) ) {
					excluded_maps[map_types[j]['type']] = true;
				}
			}
		}
		if (this.control_style == 'menu') {
			var map_selector = document.createElement("select");
			map_selector.id = 'gv_map_selector';
			map_selector.title = "Choose a background map";
			map_selector.style.font = '10px Verdana';
			map_selector.style.backgroundColor = '#FFFFFF';
			for (j=0; j<map_types.length; j++) {
				if (!this.filter_map_types || !excluded_maps[map_types[j]['type']]) {
					var opt = document.createElement("option");
					opt.value = map_types[j]['type'];
					opt.appendChild(document.createTextNode(map_types[j]['label']));
					map_selector.appendChild(opt);
					if (map.getCurrentMapType() == eval(opt.value)) { map_selector.selectedIndex = map_selector.length - 1; }
				}
			}
			GEvent.addDomListener(map_selector, "change", function(){
				map.setMapType(eval(this.value));
				// if (self.gv_maptypecontrol) {
				// 	map.removeControl(gv_maptypecontrol);
				// 	map.addControl(gv_maptypecontrol);
				// }
			} );
			map.getContainer().appendChild(map_selector);
			return map_selector;
		} else { // 'list'
			var map_type_container = document.createElement("div");
			for (j=0; j<map_types.length; j++) {
				var map_ok = true;
				if (this.filter_map_types && !(center_lng >= map_types[j]['bounds'][0] && center_lat >= map_types[j]['bounds'][1] && center_lng <= map_types[j]['bounds'][2] && center_lat <= map_types[j]['bounds'][3]) || (center_lng >= map_types[j]['excluded'][0] && center_lat >= map_types[j]['excluded'][1] && center_lng <= map_types[j]['excluded'][2] && center_lat <= map_types[j]['excluded'][3]) ) { map_ok = false; }
				if (self.gv_country && gv_country && map_types[j]['country'] && map_types[j]['country'].indexOf(gv_country) < 0) { map_ok = false; }
				if (excluded_maps[map_types[j]['type']]) { map_ok = false; }
				if (map_ok) {
					var maplink = document.createElement("div");
					maplink.className = 'gv_maptypelink';
					if (self.gv_maptypecontrol && map.getCurrentMapType() == eval(map_types[j]['type'])) {
						maplink.className = 'gv_maptypelink gv_maptypelink_selected';
					}
					maplink.title = map_types[j]['title'];
					maplink.type = map_types[j]['type'];
					map_type_container.appendChild(maplink);
					maplink.appendChild(document.createTextNode(map_types[j]['label']));
					GEvent.addDomListener(maplink, "click", function(){
						map.setMapType(eval(this.type));
						if (self.gv_maptypecontrol) {
							map.removeControl(gv_maptypecontrol);
							map.addControl(gv_maptypecontrol);
						}
					} );
				}
			}
			map.getContainer().appendChild(map_type_container);
			return map_type_container;
		}
	}
}

/**************************************************
 * More custom map layer functions:
 * Adapted from Jef Poskanzer's Acme Mapper
 * (http://mapper.acme.com/)
 **************************************************/
function WMSCreateMap(layer_info,copyright,errorMessage,minResolution,maxResolution,tileSize,baseUrl) {
	// The old "GV_Marker" function had everything in a particular order; this new one uses more user-friendly named parameters.
	// If the second argment has a 'lat' item INSIDE of it, then it's the new version; otherwise that's just the latitude.
	var array_input = (layer_info[0] != undefined && layer_info[0]['name'] != undefined) ? 1 : 0;
	var layers = [];
	
	if (!array_input) {
		layers[0] = [];
		layers[0]['name'] = layer_info;
		layers[0]['copyright'] = copyright;
		layers[0]['errorMessage'] = errorMessage;
		layers[0]['minResolution'] = minResolution;
		layers[0]['maxResolution'] = maxResolution;
		layers[0]['tileSize'] = tileSize;
		layers[0]['baseUrl'] = baseUrl;
	} else {
		layers = layer_info; // everything's okay; there was only one parameter, and it's an array
	}
	
	var tileLayers = [];
	for (j=0; j<layers.length; j++) {
		var mi = layers[j]; // mi stands for "map info"
		var tileLayer = new GTileLayer(new GCopyrightCollection(mi['copyright']),mi['minResolution'],mi['maxResolution']);
		tileLayer.baseUrl = mi['baseUrl'];
		tileLayer.tileSize = mi['tileSize'];
		tileLayer.getTileUrl = WMSGetTileUrl;
		tileLayer.getCopyright = function() { return { prefix:'',copyrightTexts:[mi['copyright']]}; };
		if (mi['opacity'] != undefined) { tileLayer.getOpacity = function() { return mi['opacity']; } }
		if (mi['background'] != undefined) {
			var bg_layers = eval(mi['background']+'.getTileLayers()');
			for(var i in bg_layers) {
				if (mi['bg_opacity'] != undefined) { bg_layers[i].getOpacity = function() { return mi['bg_opacity']; } }
				tileLayers.push(bg_layers[i]);
			}
		}
		tileLayers.push(tileLayer);
		if (mi['foreground'] != undefined) {
			var fg_layers = eval(mi['foreground']+'.getTileLayers()');
			for (var i=0; i<fg_layers.length; i++) {
				if (mi['foreground'] != 'G_HYBRID_MAP' || (mi['foreground'] == 'G_HYBRID_MAP' && i == (fg_layers.length-1))) { // if the foreground is Google hybrid, only use the last (transparent) layer
					tileLayers.push(fg_layers[i]);
				}
			}
		}
	}
	
	return new GMapType(tileLayers,G_SATELLITE_MAP.getProjection(),mi['name'],{errorMessage:mi['errorMessage'],tileSize:mi['tileSize']});
}
function WMSGetTileUrl(tile,zoom) {
	var southWestPixel = new GPoint(tile.x*this.tileSize,(tile.y+1)*this.tileSize);
	var northEastPixel = new GPoint((tile.x+1)*this.tileSize,tile.y*this.tileSize);
	var southWestCoords = G_NORMAL_MAP.getProjection().fromPixelToLatLng(southWestPixel,zoom);
	var northEastCoords = G_NORMAL_MAP.getProjection().fromPixelToLatLng(northEastPixel,zoom);
	var bbox = southWestCoords.lng()+','+southWestCoords.lat()+','+northEastCoords.lng()+','+northEastCoords.lat();
	var ts = (this.baseUrl.indexOf('onearth.jpl.nasa.gov') > -1 && this.tileSize == 256) ? 257 : this.tileSize;
	return this.baseUrl+'&bbox='+bbox+'&width='+ts+'&height='+ts;
}



function GV_MapOpacityControl(op) {
	this.initial_opacity = (op != null) ? parseFloat(op) : 100;
}
GV_MapOpacityControl.prototype = new GControl();
GV_MapOpacityControl.prototype.getDefaultPosition = function() {
	var from_right = 6;
	if (document.getElementById('gv_map_selector')) {
		from_right = document.getElementById('gv_map_selector').offsetWidth + 7 + 4;
	} else if (self.gv_maptypecontrol && gv_maptypecontrol) { // google default map switcher?
		from_right = 200;
	}
	return new GControlPosition(G_ANCHOR_TOP_RIGHT, new GSize(from_right,7));
}
GV_MapOpacityControl.prototype.initialize = function(map) {
	var opacity_selector = document.createElement("select");
	opacity_selector.id = 'gv_opacity_selector';
	opacity_selector.title = "Adjust the background map's opacity";
	opacity_selector.style.font = '10px Verdana';
	opacity_selector.style.backgroundColor = '#FFFFFF';
	var opt = document.createElement("option");
	opt.value = '';
	opt.appendChild(document.createTextNode('opacity'));
	opacity_selector.appendChild(opt);
	for (j=0; j<=10; j++) {
		var opt = document.createElement("option");
		opt.value = j / 10;
		opt.appendChild(document.createTextNode(j*10 + '%'));
		opacity_selector.appendChild(opt);
	}
	GEvent.addDomListener(opacity_selector, "change", function(){
		GV_Background_Opacity(map,this.value);
	} );
	map.getContainer().appendChild(opacity_selector);
	GV_Background_Opacity(map,this.initial_opacity);
	return opacity_selector;
}

function GV_Add_Track_to_Tracklist(opts) {
	if (!opts || !document.getElementById('gv_tracklist_links')) { return false; }
	if (self.gv_options && gv_options['tracklist_options'] && gv_options['tracklist_options']['tracklist'] === false) { return false; }
	var tracklinks = document.getElementById('gv_tracklist_links');
	if (opts['color'].toUpperCase() == '#FFFFFF' || opts['color'] == 'white') { opts['color'] = '#DDDDDD'; }
	opts['desc'] = opts['desc'].replace(/"/g,'&amp;quot;');
	var id_escaped = opts['id'].replace(/'/g,"\\'");
	tracklinks.innerHTML += '<div class="gv_tracklist_item">'+opts['bullet']+'<span id="'+opts['id']+'_label" class="trackname" style="color:'+opts['color']+'; cursor:pointer;" onclick="GV_Toggle_Track_And_Label('+opts['map_name']+',\''+id_escaped+'\',\''+opts['color']+'\');" onmouseover="this.style.textDecoration=\'underline\'; GV_Tracklist_Tooltip_Show(\''+id_escaped+'_label\',\''+eval(opts['map_name']).getContainer().id+'\');" onmouseout="this.style.textDecoration=\'none\'; GV_Tracklist_Tooltip_Hide(\''+id_escaped+'_label\');" title="'+opts['desc']+'">'+opts['name']+'</span></div>';
}

function GV_Tracklist_Tooltip_Show(item_div_name,map_div_name) {
	var map_div, legend_div, item_div, tooltip_div;
	if (!map_div_name) { map_div_name = 'gmap_div'; }
	if (document.getElementById(item_div_name)) { item_div = document.getElementById(item_div_name); } else { return false; }
	if (document.getElementById(map_div_name)) { map_div = document.getElementById(map_div_name); } else { return false; }
	if (document.getElementById('gv_legend_tooltip')) { tooltip_div = document.getElementById('gv_legend_tooltip'); }
	else if (document.getElementById('gv_tracklist_tooltip')) { tooltip_div = document.getElementById('gv_tracklist_tooltip'); }
	else { return false; }
	if (item_div.title && !item_div.description) {
		item_div.description = item_div.title; item_div.title = '';
	}
	if (item_div && tooltip_div && item_div.description) {
		tooltip_div.innerHTML = item_div.description;
		var map_pos = findPos(map_div);
		var item_pos = findPos(item_div);
		var item_height = item_div.offsetHeight || 12;
		var map_right = map_pos[0] + parseInt(map_div.offsetWidth);
		var tooltip_padding = parseInt(tooltip_div.style.padding);
		var tooltip_border = parseInt(tooltip_div.style.borderWidth);
		var tooltip_width = parseInt(tooltip_div.style.width) || 200;
		var max_right = parseInt(map_right-tooltip_width-tooltip_padding*2-tooltip_border*2);
		tooltip_div.style.left = (item_pos[0] > max_right) ? max_right+'px' : item_pos[0]+'px';
		tooltip_div.style.top = parseInt(item_pos[1]+item_height+3)+'px';
		tooltip_div.style.position = 'absolute';
		tooltip_div.style.zIndex = 99999;
		tooltip_div.style.display = 'block';
		tooltip_div.style.visibility = 'visible';
		// var tooltip_width = parseInt(tooltip_div.offsetWidth);
	}
}

function GV_Tracklist_Tooltip_Hide(item_div_name) {
	var item_div, tooltip_div;
	if (document.getElementById('gv_legend_tooltip')) { tooltip_div = document.getElementById('gv_legend_tooltip'); }
	else if (document.getElementById('gv_tracklist_tooltip')) { tooltip_div = document.getElementById('gv_tracklist_tooltip'); }
	else { return false; }
	if (document.getElementById(item_div_name)) { item_div = document.getElementById(item_div_name); }
	if (tooltip_div) {
		tooltip_div.innerHTML = '';
		tooltip_div.style.visibility = 'hidden';
		tooltip_div.style.display = 'none';
		tooltip_div.style.top = '-2000px';
		// window.setTimeout("GV_Tracklist_Tooltip_Hide_Delayed('"+tooltip_div.id+"')",3000);
	}
}

function GV_Tracklist_Tooltip_Hide_Delayed(tooltip_div_name) {
	var tooltip_div = document.getElementById(tooltip_div_name);
	if (tooltip_div) {
		tooltip_div.innerHTML = '';
		tooltip_div.style.visibility = 'hidden';
		tooltip_div.style.display = 'none';
		tooltip_div.style.top = '-2000px';
	}
}

function findPos(obj) {
	var left = 0; var top = 0;
	if (obj.offsetParent) {
		left = obj.offsetLeft; top = obj.offsetTop;
		while (obj = obj.offsetParent) {
			left += obj.offsetLeft; top += obj.offsetTop;
		}
	}
	return [left,top];
}


// These are here only for backwards compatibilty:
function GPSV_Waypoint(lon,lat,name,desc,url,color,style,width,label_id) { GV_Marker(gmap,lat,lon,name,desc,url,color,style,width,label_id); }
function GPSV_Toggle_Track_And_Label(id,color) { GV_Toggle_Track_And_Label(id,color); } // for backwards compatibility
function GPSV_Toggle_Opacity(overlay_array) { GV_Toggle_Overlays(overlay_array); } // for backwards compatibility
function GPSV_Toggle_Label_Opacity(label,original_color) { GV_Toggle_Label_Opacity(label,original_color); } // for backwards compatibility
function GPSV_MapTypeControl() {}
if (google_api_version >= 2) { GPSV_MapTypeControl.prototype = GV_MapTypeControl.prototype; }
function GV_Legend_Tooltip_Show(item_div_name,map_div_name) { GV_Tracklist_Tooltip_Show(item_div_name,map_div_name); }
function GV_Legend_Tooltip_Hide(item_div_name) { GV_Tracklist_Tooltip_Hide(item_div_name); }
function GV_Legend_Tooltip_Hide_Delayed(tooltip_div_name) { GV_Tracklist_Tooltip_Hide_Delayed(tooltip_div_name); }



function GV_Load_Markers_From_XML(opts) {
	var map_name = opts['map'] || 'gmap'; var map = eval(map_name);
	var array_name = opts['array'] || 'wpts'; var marker_array = eval(array_name);
	var filename = opts['xml'] || 'markers.xml';
	if (opts['prevent_caching']) {
		var nocache_punctuation = (filename.indexOf('?') > -1) ? '&' : '?';
		var timestamp = new Date();
		filename = filename+nocache_punctuation+'gv_nocache='+timestamp.valueOf();
	}
	GDownloadUrl(filename, function(data, responseCode) {
		var xml = GXml.parse(data);
		var markers = xml.documentElement.getElementsByTagName(opts['tag']||'marker');
		for (var i = 0; i < markers.length; i++) {
			var m = new Array;
			m['lat'] = m['lon'] = null;
			if (markers[i].getAttribute('latitude')) { m['lat'] = parseFloat(markers[i].getAttribute('latitude')); }
			else if (markers[i].getAttribute('lat')) { m['lat'] = parseFloat(markers[i].getAttribute('lat')); }
			var lon = null;
			if (markers[i].getAttribute('longitude')) { m['lon'] = parseFloat(markers[i].getAttribute('longitude')); }
			else if (markers[i].getAttribute('lon')) { m['lon'] = parseFloat(markers[i].getAttribute('lon')); }
			else if (markers[i].getAttribute('lng')) { m['lon'] = parseFloat(markers[i].getAttribute('lng')); }
			else if (markers[i].getAttribute('long')) { m['lon'] = parseFloat(markers[i].getAttribute('long')); }
			if (m['lat'] && m['lon']) {
				m['name'] = m['desc'] = m['color'] = m['icon'] = '';
				if (markers[i].getAttribute('name'))  { m['name']  = markers[i].getAttribute('name'); }
				if (markers[i].getAttribute('desc'))  { m['desc']  = markers[i].getAttribute('desc'); }
				if (markers[i].getAttribute('color')) { m['color'] = markers[i].getAttribute('color'); }
				if (markers[i].getAttribute('icon'))  { m['icon']  = markers[i].getAttribute('icon'); }
				  else if (markers[i].getAttribute('sym'))  { m['icon']  = markers[i].getAttribute('sym'); }
				  else if (markers[i].getAttribute('symbol'))  { m['icon']  = markers[i].getAttribute('symbol'); }
				if (markers[i].getAttribute('icon_size') && markers[i].getAttribute('icon_size').match(/([0-9]+)[^0-9]+([0-9]+)/)) { 
					var parts = markers[i].getAttribute('icon_size').match(/([0-9]+)[^0-9]+([0-9]+)/);
					m['icon_size']  = [parts[1],parts[2]];
				} else if (markers[i].getAttribute('width') && markers[i].getAttribute('height')) {
					m['icon_size']  = [markers[i].getAttribute('width'),markers[i].getAttribute('height')];
				}
				if (markers[i].getAttribute('scale'))  { m['scale']  = markers[i].getAttribute('scale'); }
				marker_array.push( GV_Marker(map,{lat:m['lat'],lon:m['lon'],name:m['name'],desc:m['desc'],color:m['color'],icon:m['icon'],scale:m['scale'],icon_size:m['icon_size']}) );
			}
		}
		
		// This needs to be done here because otherwise, due to "asynchronicity" or something, the map might get finished before this subroutine completes
		window.setTimeout('GV_Process_Waypoints('+map_name+','+array_name+')',200);
		
	});
}



function GV_Get_Dynamic_Markers(opts) { // opts = options hash
	// this next line checks whether ALL gv_options were sent, or just the dynamic_marker_options:
	var dmo = (opts['dynamic_marker_options']) ? opts['dynamic_marker_options'] : opts;
	if (!dmo['db'] || !dmo['url']) { return; }
	
	var program_on_server = dmo['url'];
	var map_name = opts['map'] || 'gmap'; var map = eval(map_name); if (!map) { return false; }
	var array_name = opts['marker_array'] || 'gv_dynamic_markers';
	
	if (self.gv_options && gv_options['marker_filter_options']) { gv_options['marker_filter_options']['filter'] = false; }
	gv_filter_waypoints = false;
	
	if (!eval('self.'+array_name)) { eval(array_name+' = new Array();'); }
	var marker_array = eval(array_name);
	
	var SW = map.getBounds().getSouthWest(); var NE = map.getBounds().getNorthEast();
	var lat_center = map.getCenter().lat().toFixed(7);
	var lon_center = map.getCenter().lng().toFixed(7);
	
	var moved_enough = true;
	if (self.gv_zoom_when_reloaded && (map.getZoom() < gv_zoom_when_reloaded)) {
		moved_enough = true; // regardless of how far they moved, reload if they zoomed out
	} else if (self.gv_center_when_reloaded && self.gv_last_radius) {
		if (map.getCenter().distanceFrom(gv_center_when_reloaded) < gv_last_radius*0.4) {
			moved_enough = false; // they moved, but not very far, so don't reload
		}
	}
	if (moved_enough) {
		for (var i = 0; i < marker_array.length; i++) { map.removeOverlay(marker_array[i]); }
		gv_marker_count = 0;
		marker_array.length = 0; // this is important!
		if (gv_marker_list_exists) {
			gv_marker_list_div.innerHTML = 'Loading markers...';
			gv_marker_list_html = '';
		}
		var fields = (dmo['fields']) ? dmo['fields'] : 'name,description,latitude,longitude';
		var sort = (dmo['sort']) ? dmo['sort'] : '';
		var url = program_on_server+'?db='+dmo['db']+'&fields='+escape(fields)+'&lat_center='+lat_center+'&lon_center='+lon_center+'&lat_min='+SW.lat().toFixed(7)+'&lat_max='+NE.lat().toFixed(7)+'&lon_min='+SW.lng().toFixed(7)+'&lon_max='+NE.lng().toFixed(7)+'&quota='+dmo['limit']+'&sort='+sort;
		GDownloadUrl(url, function(data, responseCode) {
			var xml = GXml.parse(data);
			var marker_tags = xml.documentElement.getElementsByTagName("marker");
			for (var i = 0; i < marker_tags.length; i++) {
				var this_color = (marker_tags[i].getAttribute("color")) ? marker_tags[i].getAttribute("color") : '';
				var this_icon = (marker_tags[i].getAttribute("icon")) ? marker_tags[i].getAttribute("icon") : '';
				var this_label = (marker_tags[i].getAttribute("label")) ? marker_tags[i].getAttribute("label") : marker_tags[i].getAttribute("name");
				var this_shortdesc = (marker_tags[i].getAttribute("shortdesc")) ? marker_tags[i].getAttribute("shortdesc") : '';
				this_label = (dmo['labels']) ? this_label : '';
				var m = GV_Marker(map,{
					lat:marker_tags[i].getAttribute("lat"),
					lon:marker_tags[i].getAttribute("lon"),
					name:marker_tags[i].getAttribute("name"),
					desc:marker_tags[i].getAttribute("desc"),
					shortdesc:this_shortdesc,
					color:this_color,
					icon:this_icon,
					label:this_label
				});
				marker_array.push(m);
			}
			gv_last_radius = 0.7 * map.getCenter().distanceFrom(map.getBounds().getSouthWest()); // in case the XML doesn't have a radius
			if (dmo['circle']) {
				var trackpoints = xml.documentElement.getElementsByTagName("trkpt");
				if (trackpoints.length) {
					var tracks = xml.documentElement.getElementsByTagName("trk"); gv_last_radius = tracks[0].getAttribute("radius");
					var pts = new Array();
					for (var i = 0; i < trackpoints.length; i++) {
						pts.push( new GLatLng(trackpoints[i].getAttribute("lat"),trackpoints[i].getAttribute("lon")) );
					}
					var circle_color = (gv_marker_color) ? gv_marker_color : 'white';
					marker_array.push (new GPolyline(pts,GV_Color_Name2Hex(circle_color),2,0.2));
					map.addOverlay(marker_array[marker_array.length-1]);
				}
			}
			if (gv_marker_list_exists) {
				GV_Marker_List();
			}
		});
		gv_center_when_reloaded = map.getCenter();
		gv_zoom_when_reloaded = map.getZoom();
		
	}
}



function FindGoogleAPIVersion() {
	var v = 2;
	var scripts = document.getElementsByTagName("script");
	for (var i=0; i<scripts.length; i++) {
		var pattern = /\/mapfiles\/([0-9]+)\/maps([0-9])?\.api\//;
		var m = pattern.exec(scripts[i].src);
		if (m != null && m[1] && m[2]) {
			v = parseFloat(m[2]+'.'+m[1]);
			break;
		}
	}
	return v;
}




/**************************************************
elabel.js
(adapted from http://www.econym.demon.co.uk/googlemaps/elabel.htm)
(My modification: adding the "label_id" parameter)
**************************************************/

function ELabel(point, html, classname, pixelOffset, percentOpacity, overlap, label_id, hide) {
	// Mandatory parameters
	this.point = point;
	this.html = html;
	
	// Optional parameters
	this.classname = classname || "";
	this.pixelOffset = pixelOffset || new GSize(0,0);
	if (percentOpacity) {
		if (percentOpacity < 0) { percentOpacity = 0; }
		if (percentOpacity > 100) { percentOpacity = 100; }
	}
	this.percentOpacity = percentOpacity;
	this.overlap = overlap || false;
	this.label_id = label_id;
	this.hide = hide;

}

if (google_api_version >= 2) {
	ELabel.prototype = new GOverlay();
	
	ELabel.prototype.initialize = function (map) {
		var div = document.createElement("div");
		div.style.position = "absolute";
		div.style.visibility = (this.hide) ? 'hidden' : 'visible';
		div.innerHTML = '<div id = "' + this.label_id + '" class="' + this.classname + '">' + this.html + '</div>' ;
		map.getPane(G_MAP_FLOAT_SHADOW_PANE).appendChild(div);
		this.map_ = map;
		this.div_ = div;
		if (this.percentOpacity) {
			if (typeof(div.style.filter) == 'string') { div.style.filter='alpha(opacity:'+this.percentOpacity+')'; }
			if (typeof(div.style.KHTMLOpacity) == 'string') { div.style.KHTMLOpacity=this.percentOpacity/100; }
			if (typeof(div.style.MozOpacity) == 'string') { div.style.MozOpacity=this.percentOpacity/100; }
			if (typeof(div.style.opacity) == 'string') { div.style.opacity=this.percentOpacity/100; }
		}
		if (this.overlap) {
			var z = GOverlay.getZIndex(this.point.lat());
			this.div_.style.zIndex = z;
		}
	}
	
	ELabel.prototype.remove = function() {
		this.div_.parentNode.removeChild(this.div_);
	}
	
	ELabel.prototype.copy = function() {
		return new ELabel(this.point, this.html, this.classname, this.pixelOffset, this.percentOpacity, this.overlap);
	}
	
	ELabel.prototype.redraw = function(force) {
		var p = this.map_.fromLatLngToDivPixel(this.point);
		var h = parseInt(this.div_.clientHeight);
		this.div_.style.left = (p.x + this.pixelOffset.width) + "px";
		this.div_.style.top = (p.y +this.pixelOffset.height - h) + "px";
	}
	
	ELabel.prototype.show = function() {
		this.div_.style.display="";
	}
	
	ELabel.prototype.hide = function() {
		this.div_.style.display="none";
	}
	
	ELabel.prototype.setContents = function(html) {
		this.html = html;
		this.div_.innerHTML = '<div id = "' + this.label_id + '" class="' + this.classname + '">' + this.html + '</div>' ;
		this.redraw(true);
	}
	
	ELabel.prototype.setPoint = function(point) {
		this.point = point;
		if (this.overlap) {
			var z = GOverlay.getZIndex(this.point.lat());
			this.div_.style.zIndex = z;
		}
		this.redraw(true);
	}
	
	ELabel.prototype.setOpacity = function(percentOpacity) {
		if (percentOpacity) {
			if (percentOpacity < 0) { percentOpacity=0; }
			if (percentOpacity > 100) { percentOpacity=100; }
		}
		this.percentOpacity = percentOpacity;
		if (this.percentOpacity) {
			if (typeof(this.div_.style.filter) == 'string') { this.div_.style.filter='alpha(opacity:'+this.percentOpacity+')'; }
			if (typeof(this.div_.style.KHTMLOpacity) == 'string') { this.div_.style.KHTMLOpacity=this.percentOpacity/100; }
			if (typeof(this.div_.style.MozOpacity) == 'string') { this.div_.style.MozOpacity=this.percentOpacity/100; }
			if (typeof(this.div_.style.opacity) == 'string') { this.div_.style.opacity=this.percentOpacity/100; }
		}
	}
}

/**************************************************
 * dom-drag.js
 * 09.25.2001
 * www.youngpup.net
 * Script featured on Dynamic Drive (http://www.dynamicdrive.com) 12.08.2005
 **************************************************
 * 10.28.2001 - fixed minor bug where events
 * sometimes fired off the handle, not the root.
 **************************************************/
var Drag = {

	obj : null,

	init : function(o, oRoot, minX, maxX, minY, maxY, bSwapHorzRef, bSwapVertRef, fXMapper, fYMapper) {
		if (!o) { return false; }
		o.onmousedown	= Drag.start;

		o.hmode			= bSwapHorzRef ? false : true ;
		o.vmode			= bSwapVertRef ? false : true ;

		o.root = oRoot && oRoot != null ? oRoot : o ;

		if (o.hmode  && isNaN(parseInt(o.root.style.left  ))) o.root.style.left   = "0px";
		if (o.vmode  && isNaN(parseInt(o.root.style.top   ))) o.root.style.top    = "0px";
		if (!o.hmode && isNaN(parseInt(o.root.style.right ))) o.root.style.right  = "0px";
		if (!o.vmode && isNaN(parseInt(o.root.style.bottom))) o.root.style.bottom = "0px";

		o.minX	= typeof minX != 'undefined' ? minX : null;
		o.minY	= typeof minY != 'undefined' ? minY : null;
		o.maxX	= typeof maxX != 'undefined' ? maxX : null;
		o.maxY	= typeof maxY != 'undefined' ? maxY : null;

		o.xMapper = fXMapper ? fXMapper : null;
		o.yMapper = fYMapper ? fYMapper : null;

		o.root.onDragStart	= new Function();
		o.root.onDragEnd	= new Function();
		o.root.onDrag		= new Function();
	},

	start : function(e) {
		var o = Drag.obj = this;
		e = Drag.fixE(e);
		var y = parseInt(o.vmode ? o.root.style.top  : o.root.style.bottom);
		var x = parseInt(o.hmode ? o.root.style.left : o.root.style.right );
		o.root.onDragStart(x, y);

		o.lastMouseX	= e.clientX;
		o.lastMouseY	= e.clientY;

		if (o.hmode) {
			if (o.minX != null)	o.minMouseX	= e.clientX - x + o.minX;
			if (o.maxX != null)	o.maxMouseX	= o.minMouseX + o.maxX - o.minX;
		} else {
			if (o.minX != null) o.maxMouseX = -o.minX + e.clientX + x;
			if (o.maxX != null) o.minMouseX = -o.maxX + e.clientX + x;
		}

		if (o.vmode) {
			if (o.minY != null)	o.minMouseY	= e.clientY - y + o.minY;
			if (o.maxY != null)	o.maxMouseY	= o.minMouseY + o.maxY - o.minY;
		} else {
			if (o.minY != null) o.maxMouseY = -o.minY + e.clientY + y;
			if (o.maxY != null) o.minMouseY = -o.maxY + e.clientY + y;
		}
		
		gv_onmousemove_before_dragging = document.onmousemove; // preserve this and put it back later
		gv_onmouseup_before_dragging = document.onmouseup; // preserve this and put it back later
		document.onmousemove	= Drag.drag;
		document.onmouseup		= Drag.end;

		return false;
	},

	drag : function(e) {
		e = Drag.fixE(e);
		var o = Drag.obj;

		var ey	= e.clientY;
		var ex	= e.clientX;
		var y = parseInt(o.vmode ? o.root.style.top  : o.root.style.bottom);
		var x = parseInt(o.hmode ? o.root.style.left : o.root.style.right );
		var nx, ny;

		if (o.minX != null) ex = o.hmode ? Math.max(ex, o.minMouseX) : Math.min(ex, o.maxMouseX);
		if (o.maxX != null) ex = o.hmode ? Math.min(ex, o.maxMouseX) : Math.max(ex, o.minMouseX);
		if (o.minY != null) ey = o.vmode ? Math.max(ey, o.minMouseY) : Math.min(ey, o.maxMouseY);
		if (o.maxY != null) ey = o.vmode ? Math.min(ey, o.maxMouseY) : Math.max(ey, o.minMouseY);

		nx = x + ((ex - o.lastMouseX) * (o.hmode ? 1 : -1));
		ny = y + ((ey - o.lastMouseY) * (o.vmode ? 1 : -1));

		if (o.xMapper)		nx = o.xMapper(y)
		else if (o.yMapper)	ny = o.yMapper(x)

		Drag.obj.root.style[o.hmode ? "left" : "right"] = nx + "px";
		Drag.obj.root.style[o.vmode ? "top" : "bottom"] = ny + "px";
		Drag.obj.lastMouseX	= ex;
		Drag.obj.lastMouseY	= ey;

		Drag.obj.root.onDrag(nx, ny);
		return false;
	},

	end : function() {
		// document.onmousemove = null;
		// document.onmouseup   = null;
		document.onmousemove = (self.gv_onmousemove_before_dragging) ? gv_onmousemove_before_dragging : null;
		document.onmouseup = (self.gv_onmouseup_before_dragging) ? gv_onmouseup_before_dragging : null;
		Drag.obj.root.onDragEnd(	parseInt(Drag.obj.root.style[Drag.obj.hmode ? "left" : "right"]), 
									parseInt(Drag.obj.root.style[Drag.obj.vmode ? "top" : "bottom"]));
		Drag.obj = null;
	},

	fixE : function(e) {
		if (typeof e == 'undefined') e = window.event;
		if (typeof e.layerX == 'undefined') e.layerX = e.offsetX;
		if (typeof e.layerY == 'undefined') e.layerY = e.offsetY;
		return e;
	}
};

