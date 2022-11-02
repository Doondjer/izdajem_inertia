<template>
    <div id="map">
        <div id="mapContainer" ref="map"></div>
    </div>
</template>

<script setup>
import H from '@here/maps-api-for-javascript';
import { client } from "@/Services/Client";

import {nextTick, onMounted, reactive, ref, watch} from "vue";

let emits = defineEmits(['autocomplete', 'update:searchDistance', 'update:distance', 'update:processing']);

let props = defineProps({
    zoom: {
        type: Number,
        default: 15
    },
    markers: Object,
    center: Object,
    destLocation: Object,
    searchDistance: String,
    is_center_marker: {
        type: Boolean,
        default: true
    },
    isAutocomplete: {
        type: Boolean,
        default: true
    },
    apiKey: {
        type: String,
        default: import.meta.env.VITE_HERE_API_KEY
    },
})
let routeObjects = reactive([]);

let hereMap = reactive({});
let ui = reactive({});

watch(() => props.markers, _.throttle(
        (newValue, oldValue) => {
            if(Object.keys(hereMap).length){
                hereMap.removeObjects(hereMap.getObjects());
            }

          nextTick(() => {
              hereMap.getViewPort().resize();
              dropMarkers(newValue);
          });
        }, 200),{immediate: true}
);

watch(() => props.searchDistance, _.throttle(
        (newValue, oldValue) => {
            if(props.isAutocomplete && newValue) {
                hereAutocomplete(newValue);
            }
        }, 200)
);
watch(() => props.destLocation,
        (newValue, oldValue) => {
            clearMap();

            emits('update:processing', true);

            createRoute({ lat: newValue[0], lng: newValue[1] }, props.center, newValue[2])
                .then(data => {
                    emits('update:distance', data);
                    emits('update:processing', false);
                })
                .catch(e => {
                    emits('update:processing', true);
                    console.dir(e)
                })
        },{deep: true}
);

let drawRoute = (result) => {
    // ensure that at least one route was found
    if (result.routes.length) {
        result.routes[0].sections.forEach((section) => {
            // Create a linestring to use as a point source for the route line
            let linestring = H.geo.LineString.fromFlexiblePolyline(section.polyline);

            // Create an outline for the route polyline:
            var routeOutline = new H.map.Polyline(linestring, {
                style: {
                    lineWidth: 10,
                    strokeColor: 'rgb(17, 132, 232)',
                    lineTailCap: 'arrow-tail',
                    lineHeadCap: 'arrow-head'
                }
            });
            // Create a patterned polyline:
            var routeArrows = new H.map.Polyline(linestring, {
                    style: {
                        lineWidth: 10,
                        fillColor: 'white',
                        strokeColor: 'rgba(255, 255, 255, 1)',
                        lineDash: [0, 2],
                        lineTailCap: 'arrow-tail',
                        lineHeadCap: 'arrow-head' }
                }
            );
            // create a group that represents the route line and contains
            // outline and the pattern
            var routeLine = new H.map.Group();
            routeLine.addObjects([routeOutline, routeArrows]);

            // Create a marker icon from an image URL:
            var icon = new H.map.Icon('/image/destination.svg', { size: { w: 30, h: 30 } });

            // Create a marker using the previously instantiated icon:
            var endMarker = new H.map.Marker(section.arrival.place.location, { icon: icon });

            // Add the route polyline and the two markers to the map:
            hereMap.addObjects([routeLine, endMarker]);

            routeObjects = [routeLine, endMarker];

            // Set the map's viewport to make the whole route visible:
            hereMap.getViewModel().setLookAtData({bounds: routeLine.getBoundingBox()});
        });
    }
};

let createRoute = (to, from = props.center, tMode = 'car', rMode = 'fast') => {
    return new Promise((resolve, reject) => {
        let router = platform.getRoutingService(null, 8)

        router.calculateRoute({
                'routingMode': rMode,
                'transportMode': tMode,
                'origin': `${from.lat},${from.lng}`,
                'destination': `${to.lat},${to.lng}`,
                'return': 'polyline,summary'
            }, data => {
                if(data.routes.length > 0 && data.routes[0].sections.length > 0) {
                    drawRoute(data);
                    resolve(data.routes[0].sections[0].summary);
                } else {
                    resolve(null);
                }
            },
            function(error) {
                reject(error);
            });
    })
}

let hereAutocomplete =  _.throttle((search) => {

        if (search.length < 3) {
            return;
        }

        emits('update:processing', true);

        client.get(`https://places.ls.hereapi.com/places/v1/autosuggest`, {
            params: {
                q: search,
                apiKey: props.apiKey,
                at: `${props.center.lat},${props.center.lng}`,
                country: 'SRB',
                'Accept-Language': 'sr-Latn-CS',
                beginHighlight: '<b>',
                endHighlight: '</b>',
            },
            transformRequest: (data, headers) => {
                delete headers.common['X-Requested-With'];
                return data;
            }

        }).then(({data}) => {
            emits('autocomplete', data.results);
            emits('update:processing', false);
        }).catch(e => {
            emits('update:processing', false);
            console.dir(e)
        });
},500);

let clearMap = () => {

    if( ! routeObjects.length) {
        return;
    }

    hereMap.removeObjects(routeObjects);
    routeObjects.slice(0,routeObjects.length);
};

const platform = new H.service.Platform({
    'apikey': props.apiKey
});

let dropMarkers = (locations, svg = '/icons/circles.svg') => {
    let markers = [];
        // Create single Icon instance
    let icon = new H.map.Icon(svg, { size: { w: 21, h: 21 } });

    for (var i = 0; i < locations.length; i++) {
        let marker = new H.map.Marker(locations[i], {icon: icon});
        marker.setData(`
        <div class="uk-padding-small uk-width-small">
            <div class="uk-text-small uk-text-bold">${locations[i].title}</div>
            <div class="uk-text-danger">
                <div class="uk-display-inline-block uk-text-muted"><img src="/icons/floor-plan.svg" width="16" height="16" alt="br soba" uk-svg><span class="uk-text-middle uk-margin-small-left">${locations[i].nb_room}</span></div>
                <div class="uk-text-bold uk-display-inline uk-float-right">${locations[i].price}</div>
             </div>
        </div>
        `);
        markers.push(marker);
    }

    hereMap.addObjects(markers);
    var group = new H.map.Group();

    // add markers to the group
    group.addObjects(markers);
    group.addEventListener('tap', (evt) => {
        console.log(evt);
        console.log(evt.target.getGeometry());

        // event target is the marker itself, group is a parent event target
        // for all objects that it contains
        var bubble = new H.ui.InfoBubble(evt.target.getGeometry(), {
            // read custom data
            content: evt.target.getData()
        });
        // show info bubble
        ui.addBubble(bubble);
    }, false);
    hereMap.addObject(group);


    // get geo bounding box for the group and set it to the map
    hereMap.getViewModel().setLookAtData({
        bounds: group.getBoundingBox()
    });
}

onMounted(() => {
    // Obtain the default map types from the platform object
    var maptypes = platform.createDefaultLayers();

    // Instantiate (and display) a map object:
    var map = new H.Map(
        document.getElementById('mapContainer'),
        maptypes.vector.normal.map,
        {
            zoom: props.zoom,
            center: props.center
        });
    // add a resize listener to make sure that the map occupies the whole container
    window.addEventListener('resize', () => map.getViewPort().resize());

    // add behavior control
    new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

    ui = H.ui.UI.createDefault(map, maptypes);

    if(props.is_center_marker) {
        // Create a marker icon from an image URL:
        var icon = new H.map.Icon('/image/location.svg', { size: { w: 56, h: 56 } });

        // Create a marker using the previously instantiated icon:
        var marker = new H.map.Marker(props.center, { icon: icon });

        map.addObject(marker);
    }

    hereMap = map;
})

</script>

<style>
.H_ui {
    font-size: 10px;
    font-family: "Lucida Grande", Arial, Helvetica, sans-serif;
    -moz-user-select: none;
    -khtml-user-select: none;
    -webkit-user-select: none;
    -o-user-select: none;
    -ms-user-select: none;
    /* position ui on top of imprint to make both clickable */
    z-index: 2;
    position: absolute;
    width: 100%;
    height: 100%;
    left: 100%;
}
.H_ui * {
    /* normalize in case some other normalization CSS likes things differently */
    box-sizing: content-box;
    -moz-box-sizing: content-box;
}
.H_noevs {
    pointer-events: none;
}

/*
 * Layout
 */
.H_l_left {
    position: absolute;
    left: 16px;
    margin-left: -100%;
}
.H_l_center {
    position: absolute;
    left: -50%;
}
.H_l_right {
    position: absolute;
    right: calc(100% + 16px);
    margin-left: -100%;
}
.H_l_top {
    top: 16px;
}
.H_l_middle {
    top: 50%;
}
.H_l_bottom {
    bottom: 16px;
}

/* Fix MAPSJS-579 for modern browsers */
[class^=H_l_] {
    pointer-events: none;
}
.H_ctl {
    /* hack for IE9-10, auto doesn't work for them */
    pointer-events: visiblePainted;
    pointer-events: auto;
}

.H_l_horizontal .H_ctl {
    float: left;
}

.H_l_anchor {
    clear: both;
    float: right;
}

.H_l_vertical .H_ctl {
    clear: both;
}

.H_l_right .H_l_vertical .H_ctl {
    float: right;
}

.H_l_right.H_l_middle.H_l_vertical .H_ctl{
    float: right;
}

/**
 *  Element styles
 */

.H_ctl {
    margin: .8em;
    position: relative;
    -ms-touch-action: none;
}

.H_btn {
    cursor: pointer;
}

.H_grp .H_btn,
.H_rdo_buttons .H_btn {
    box-shadow: none;
}
.H_grp .H_btn.H_active,
.H_rdo_buttons .H_btn.H_active {
    background: none;
}

.H_btn {
    box-shadow: 0em 0 0.4em 0 rgba(15, 22, 33, 0.6);
    border-radius: 0.5em;
    width: 4em;
    height: 4em;
    background: #fff;
}

.H_disabled,
.H_disabled:hover {
    cursor: default;
}

.H_rdo_title {
    font-size: 14px;
    height: 40px;
    line-height: 40px;
    background-color: #575B63;
    color: #fff;
    padding-left: 16px;
    padding-right: 16px;
    border-radius: 5px 5px 0 0;
    margin-bottom: 8px;
    cursor: default;
}

.H_ui[dir=rtl] .H_rdo_title {
    text-align: right;
}

.H_rdo ul {
    list-style: none;
    margin: 0 auto;
    padding: 0;
}

/**
 *   Base Elements
 */
.H_ctl.H_grp {
    background: #fff;
    box-shadow: 0em 0 0.4em 0 rgba(15, 22, 33, 0.6);
    border-radius: 0.5em;
}
/* Button divider */
.H_zoom .H_el {
    position: relative;
}
.H_l_vertical .H_zoom .H_el:last-child::after,
.H_l_horizontal .H_zoom .H_el:last-child::after {
    content: none;
}

.H_l_vertical .H_zoom .H_el {
    margin-bottom: 0.1em;
}
.H_l_vertical .H_zoom .H_el:last-child {
    margin-bottom: 0;
}
.H_l_vertical .H_zoom .H_el::after {
    content: "";
    position: absolute;
    width: 2.6em;
    height: 0.1em;
    bottom: -0.1em;
    left: 0.7em;
    background: rgba(15, 22, 33, 0.1);
}

.H_l_horizontal .H_zoom .H_el {
    margin-right: 0.1em;
}
.H_l_horizontal .H_zoom .H_el:last-child {
    margin-right: 0;
}
.H_l_horizontal .H_zoom .H_el::after {
    content: "";
    position: absolute;
    width: 0.1em;
    height: 2.6em;
    top: 0.7em;
    right: -0.1em;
    background: rgba(15, 22, 33, 0.1);
}
/* End: Button divider */
.H_l_horizontal .H_grp .H_btn,
.H_l_vertical .H_ctl {
    float: left;
}


/** Menu panel */
.H_overlay {
    font-size: 14px;
    color: rgba(15, 22, 33, 0.6);
    box-shadow: 0px 0 4px 0 rgba(15, 22, 33, 0.6);
    border-radius: 5px;
    position: absolute;
    min-width: 200px;
    background: #fff;
    display: none;
    z-index: 100;
    padding-bottom: 4px;
}

.H_overlay .H_separator {
    content: "";
    position: relative;
    display: block;
    margin: 8px 16px 8px 16px;
    height: 1px;
    background: rgba(15, 22, 33, 0.1);
}

.H_overlay .H_btn,
.H_overlay .H_rdo li {
    width: 184px;
    height: 24px;
    line-height: 24px;
    padding: 8px 16px;
}
.H_overlay .H_btn{
    border-radius: 0px;
}

.H_overlay .H_btn:hover,
.H_overlay .H_rdo li:hover {
    color: rgba(15, 22, 33, 0.8);
}

.H_overlay .H_btn.H_disabled,
.H_overlay .H_rdo.H_disabled li,
.H_overlay .H_btn.H_disabled:hover,
.H_overlay .H_rdo.H_disabled li:hover {
    color: rgba(15, 22, 33, 0.2);
}

.H_overlay .H_btn.H_active,
.H_overlay .H_rdo.H_active li,
.H_overlay .H_btn.H_active:hover,
.H_overlay .H_rdo.H_active li:hover {
    color: #0F1621;
}

.H_overlay>*:last-child {
    clear: both;
}
.H_overlay>.H_btn {
    white-space: nowrap;
}

.H_overlay.H_open {
    display: block;
}

.H_overlay::before, .H_overlay::after {
    content: " ";
    width: 0;
    height: 0;
    border-style: solid;
    position: absolute;
}
.H_overlay.H_left::before {
    border-width: 10px 10px 10px 0;
    border-color: transparent rgba(15, 22, 33, 0.2) transparent transparent;
    left: -12px;
}
.H_overlay.H_left::after {
    border-width: 10px 10px 10px 0;
    border-color: transparent #fff transparent transparent;
    left: -10px;
}
.H_overlay.H_top.H_left::after {
    border-color: transparent #575B63 transparent transparent;
}

.H_overlay.H_right::before {
    border-width: 10px 0 10px 10px;
    border-color: transparent transparent transparent rgba(15, 22, 33, 0.2);
    left: calc(100% + 1px);
}
.H_overlay.H_right::after {
    border-width: 10px 0 10px 10px;
    border-color: transparent transparent transparent #fff;
    left: 100%;
}
.H_overlay.H_top.H_right::after {
    border-color: transparent transparent transparent #575B63;
}

.H_overlay.H_top::before,
.H_overlay.H_top::after {
    top: 10px;
}
.H_overlay.H_bottom::before,
.H_overlay.H_bottom::after {
    bottom: 10px;
}
.H_overlay.H_middle::before,
.H_overlay.H_middle::after {
    top: 50%;
    margin-top: -10px;
}

.H_overlay.H_top.H_center::before {
    border-width: 0 10px 10px 10px;
    border-color: transparent transparent rgba(15, 22, 33, 0.2) transparent;
    top: -11px;
    left: 50%;
    margin-left: -10px;
}
.H_overlay.H_top.H_center::after {
    border-width: 0 10px 10px 10px;
    border-color: transparent transparent #575B63 transparent;
    top: -10px;
    left: 50%;
    margin-left: -10px;
}

.H_overlay.H_bottom.H_center::before {
    border-width: 10px 10px 0 10px;
    border-color: rgba(15, 22, 33, 0.2) transparent transparent transparent;
    bottom: -11px;
    left: 50%;
    margin-left: -10px;
}
.H_overlay.H_bottom.H_center::after {
    border-width: 10px 10px 0 10px;
    border-color: #fff transparent transparent transparent;
    bottom: -10px;
    left: 50%;
    margin-left: -10px;
}


/** InfoBubble */
.H_ib {
    position: absolute;
    left: .91em;
    left: -100%;
}
.H_ib_tail {
    position: absolute;
    width: 20px;
    height: 10px;
    margin: -10px -10px;
}

.H_ib_tail::before{
    bottom: -1px;
    border-width: 10px;
    position: absolute;
    display: block;
    content: "";
    border-color: transparent;
    border-style: solid;
    right: 0px;
}

.H_ib_tail::after{
    bottom: 0;
    position: absolute;
    display: block;
    content: "";
    border-color: white;
    border-style: solid;
    border-width: 10px;
}

.H_ib.H_ib_top .H_ib_tail::after {
    border-width: 10px 10px 0px 10px;
    border-color: white transparent;
}

.H_ib.H_ib_top .H_ib_tail::before {
    border-top-color: rgba(15, 22, 33, 0.2);
    border-bottom-width: 0px;
}

.H_ib_notail .H_ib_tail {
    display: none;
}
.H_ib_body {
    background: white;
    position: absolute;
    bottom: .5em;
    padding: 0;
    right: 0px;
    border-radius: 5px;
    margin-right: -3em;
    box-shadow: 0px 0 4px 0 rgba(15, 22, 33, 0.6);
    margin-bottom: 0.5em;
}

.H_ib_close {
    font-size: .6em;
    position: absolute;
    right: 12px;
    width: 12px;
    height: 12px;
    cursor: pointer;
    top: 12px;
    z-index: 1;
    background: none;
    box-shadow: none;
}

.H_ui[dir=rtl] .H_ib_close {
    left: 12px;
    right: auto;
}

.H_ib_close svg.H_icon {
    top: 0;
    transform: none;
    width: auto;
    height: auto;
}

.H_ib_noclose .H_ib_close {
    display: none;
}
.H_ib_noclose .H_ib_body {
    padding: 0 0 0 0;
}

.H_ib_content {
    min-width: 6em;
    font: 14px "Lucida Grande", Arial, Helvetica, sans-serif;
    line-height: 24px;
    margin: 16px 28px 20px 16px;
    color: rgba(15,22,33,.8);
    user-select: text;
    -moz-user-select: text;
    -khtml-user-select: text;
    -webkit-user-select: text;
    -o-user-select: text;
    -ms-user-select: text;
}

.H_ui[dir=rtl] .H_ib_content {
    margin: 16px 16px 20px 28px;
}


/*##################################################  SLIDER  ########################################################*/

.H_l_horizontal .H_zoom_slider {
    min-width: 262px;
}
.H_slider {
    cursor: pointer;
}
.H_l_horizontal.H_slider {
    float: left;
    height: 4em;
    width: auto;
    padding: 0 1em;
}

.H_slider .H_slider_track {
    width: 0.4em;
    height: 100%;
}

.H_l_horizontal.H_slider .H_slider_track {
    height: 0.4em;
    width: 100%;
}

.H_l_horizontal.H_slider .H_slider_cont {
    height: 100%;
}

.H_l_horizontal.H_slider .H_slider_knob_cont {
    margin-top: -0.4em;
}

.H_slider {
    background-color: #fff;
    padding: 1em 0em;
    width: 4em;
}


.H_slider .H_slider_cont {
    position: relative;
}

.H_slider .H_slider_knob_cont,
.H_slider .H_slider_knob_halo {
    width: 1.8em;
    height: 1.8em;
    margin-left: 0em;
    border-radius:9em;
}


.H_slider .H_slider_knob {
    width: 1.2em;
    height: 1.2em;
    background-color: white;
    border-radius:9em;
    -webkit-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    box-shadow: 0em 0 0.5em 0 rgba(15, 22, 33, 0.6);
    position: absolute;
}

.H_slider:hover .H_slider_knob {
    box-shadow: 0em 0 0.5em 0 rgba(15, 22, 33, 0.8);
}
.H_slider.H_disabled .H_slider_knob {
    box-shadow: 0em 0 0.5em 0 rgba(15, 22, 33, 0.2);
}
.H_slider.H_slider_active .H_slider_knob {
    box-shadow: 0em 0 0.5em 0 rgba(15, 22, 33, 1);
}

.H_slider:hover .H_slider_track {
    background-color: rgba(15, 22, 33, 0.8);
}

.H_disabled .H_slider_track {
    background-color: rgba(15, 22, 33, 0.2);
}
.H_slider:hover .H_slider_track_active {
    background-color: rgba(0, 182, 178, 0.8);
}
.H_disabled .H_slider_track_active {
    background-color: rgba(0, 182, 178, 0.2);
}
.H_slider.H_slider_active .H_slider_track {
    background-color: rgba(15, 22, 33, 1.0);
}
.H_slider.H_slider_active .H_slider_track_active {
    background-color: rgba(0, 182, 178, 1.0);
}

.H_slider .H_slider_track,
.H_slider .H_slider_knob_cont{
    position:relative;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    transform: translate(-50%,-50%);
}

.H_slider .H_slider_track {
    background-color: rgba(15, 22, 33, 0.6);
    overflow: hidden;
}
.H_slider .H_slider_track_active {
    background-color: #00B6B2;
    position: absolute;
    transform: translate(-50%,0%);
}

.H_slider.H_disabled .H_slider_track {
    background-color: rgba(15, 22, 33, 0.2);
}
.H_slider.H_disabled .H_slider_track_active {
    background-color: #bae2e3;
}

.H_slider.H_l_horizontal .H_slider_track_active {
    transform: translate(-200%, -50%);
}

.H_slider.H_disabled {
    cursor: default;
}

/*###############################################  CONTEXT MENU  #####################################################*/
.H_context_menu {
    font-size: 14px;
    min-width: 158px;
    max-width: 40%;
    box-shadow: 0em 0 0.4em 0 rgba(15, 22, 33, 0.6);
    position: absolute;
    left: -100%;
    top: 0;
    color: rgba(15, 22, 33, 0.6);
    background-color: #fff;
    -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    -o-border-radius: 5px;
    border-radius: 5px;
    padding: 16px 16px 4px 16px;
    -moz-user-select: initial;
    -khtml-user-select: initial;
    -webkit-user-select: initial;
    -o-user-select: initial;
    -ms-user-select: initial;
    z-index: 200;
}

.H_context_menu_closed {
    display: none;
}

.H_context_menu_item {
    text-overflow: ellipsis;
    overflow: hidden;
    line-height: 24px;
    margin-bottom: 16px;
    outline: none;
}

.H_context_menu_item.clickable:hover {
    color: rgba(15, 22, 33, 0.8);
    cursor: pointer;
}
.H_context_menu_item.disabled:hover,
.H_context_menu_item.disabled {
    background: transparent !important;
    color: rgba(15, 22, 33, 0.2);
    cursor: default !important;

    -moz-user-select: none;
    -khtml-user-select: none;
    -webkit-user-select: none;
    -o-user-select: none;
    -ms-user-select: none;
}
.H_context_menu_item_separator {
    height: 0;
    border-top: 1px solid rgba(15, 22, 33, 0.1);
    padding-bottom: 16px;
    line-height: 0;
    font-size: 0;
}


/*#################################################  SCALE BAR  ######################################################*/
.H_scalebar {
    margin-top: 36px;
    box-shadow: none;
    display: flex;
    align-items: center;
    text-shadow:
        -1px -1px 0 rgba(255, 255, 255, 0.7),
        1px -1px 0 rgba(255, 255, 255, 0.7),
        -1px 1px 0 rgba(255, 255, 255, 0.7),
        1px 1px 0 rgba(255, 255, 255, 0.7);
}


/*###################################  DISTANCE MEASUREMENT AND TRAFFIC INCIDENTS ####################################*/

/*.H_tib_content {
    width: 25em;
    position: relative;
    margin: -16px -28px -20px -16px;
}

[dir="rtl"] .H_tib_content {
    margin: -16px -16px -20px -28px;
}

.H_tib .H_tib_desc { padding: 0px 16px 20px 16px }
.H_tib .H_tib_time {color: rgba(15,22,33,.4);margin-top: 0.8em;}
.H_tib_right { float:right; }

.H_tib .H_btn > svg.H_icon {
    fill: rgba(255,255,255, .6);
}

.H_tib .H_btn:hover > svg.H_icon {
    fill: white;
}

.H_dm_label {
    font: 12px "Lucida Grande", Arial, Helvetica, sans-serif;
    color: black;
    text-shadow: 1px 1px .5px #FFF, 1px -1px .5px #FFF, -1px 1px .5px #FFF, -1px -1px .5px #FFF;
    white-space: nowrap;
    margin-left: 12px;
    margin-top: -7px;
    !* This will not work on IE9, but it is accepted! *!
    pointer-events: none;
}*/


/*###################################################  ICON  #########################################################*/
/*svg.H_icon {
    display: block;
    position: relative;
    top: 50%;
    transform: translateY(-50%);
    margin:auto;
    width: 24px;
    height: 24px;
    fill: rgba(15, 22, 33, 0.6);
}
svg.H_icon .H_icon_stroke {
    stroke: rgba(15, 22, 33, 0.6);
    fill: none;
}
.H_btn:hover > svg.H_icon {
    fill: rgba(15, 22, 33, 0.8);
}
.H_btn:hover > svg.H_icon .H_icon_stroke {
    stroke: rgba(15, 22, 33, 0.8);
}
.H_btn.H_active {
    background-color: #CFD0D3;
}
.H_rdo .H_btn.H_active {
    background: none;
}

.H_active > svg.H_icon,
.H_active:hover > svg.H_icon {
    fill: #0F1621 !important;
}
.H_active > svg.H_icon .H_icon_stroke,
.H_active:hover > svg.H_icon .H_icon_stroke {
    stroke: #0F1621;
}

.H_disabled svg.H_icon,
.H_disabled:hover svg.H_icon {
    fill: rgba(15, 22, 33, 0.2);
    cursor: default;
}
.H_disabled svg.H_icon .H_icon_stroke,
.H_disabled:hover svg.H_icon .H_icon_stroke {
    stroke: rgba(15, 22, 33, 0.2);
}*/

/*###############################################  OVERVIEW MAP  #####################################################*/
.H_overview {
    transition: width 0.2s,height 0.2s,margin-top 0.2s, padding 0.2s;
    width: 0em;
    height: 0em;
    overflow: hidden;
    cursor: default;
    position: absolute;
    margin: auto;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    box-shadow: 0em 0 0.4em 0 rgba(15, 22, 33, 0.6);
}

.H_l_vertical .H_overview_active {
    margin: auto 5px;
}

.H_l_horizontal .H_overview_active {
    margin: 5px auto;
}

.H_l_center .H_overview {
    left: -9999px;
    right: -9999px;
}

.H_l_middle .H_overview {
    top: -9999px;
    bottom: -9999px;
}

.H_l_right .H_overview {
    right: 100%;
}

.H_l_left .H_overview {
    left: 100%;
}

.H_l_bottom .H_overview {
    bottom: 0;
}
.H_l_center.H_l_bottom .H_overview {
    bottom: 100%;
}

.H_l_top .H_overview {
    top: 0;
}
.H_l_center.H_l_top .H_overview {
    top: 100%;
}

.H_overview .H_overview_map {
    background-color: rgba(256,256,256,0.6);
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    box-shadow: 0em 0 0.4em 0 rgba(15, 22, 33, 0.6);
}


.H_overview_map .H_ui {
    display: none;
}

.H_zoom_lasso {
    position: absolute;
    display: none;
    box-shadow: 0em 0 0.4em 0 rgba(15, 22, 33, 0.6);
    z-index: 100000;
    background-color: rgba(15, 22, 33, 0.2);
}

.uk-border-rounded-xl #mapContainer > div {
    border-radius: 0 0 12px 12px;
}

.H_ib_top .H_ib_tail {
    display: none;
}
.l-c {
    text-align: center;
}
.l-c > svg {
    stroke:#fff;
    stroke-width:1px;
}
.l-c .t {
    font-size: 10px;
    color: black;
    -webkit-text-fill-color: #000; /* Will override color (regardless of order) */
    -webkit-text-stroke-width: 0.65px;
    -webkit-text-stroke-color: #fff;
    font-weight: bolder;
}
.pulsing-container {
    position:absolute;
    bottom:-9px;
    left:29px;
    z-index:-1
}
.pulsing-element {
    display:block;
    position:absolute;
    z-index:20;
    left:50%;
    top:50%;
    -webkit-transform:translateX(-50%) translateY(-50%);
    -ms-transform:translateX(-50%) translateY(-50%);
    transform:translateX(-50%) translateY(-50%);
    width:50px;
    height:50px;
    pointer-events:none
}
.pulsing-element::before {
    content:'';
    position:relative;
    display:block;
    width:120px;
    height:120px;
    -webkit-box-sizing:border-box;
    -moz-box-sizing:border-box;
    box-sizing:border-box;
    margin-left:-100%;
    margin-top:-100%;
    border-radius:50%;
    background-color:#cb2027;
    -webkit-animation:pulse-ring 4s infinite;
    animation:pulse-ring 4s infinite
}
@-webkit-keyframes pulse-ring {
    0% {
        opacity:.5;
        -webkit-transform:scale(.1);
        transform:scale(.1)
    }
    40% {
        opacity:0;
        -webkit-transform:scale(1);
        transform:scale(1)
    }
    100% {
        opacity:0
    }
}
@keyframes pulse-ring {
    0% {
        opacity:.5;
        -webkit-transform:scale(.1);
        transform:scale(.1)
    }
    40% {
        opacity:0;
        -webkit-transform:scale(1);
        transform:scale(1)
    }
    100% {
        opacity:0
    }
}
.svg-marker .listing-marker {
    width:28px;
    height:34px;
    position:relative;
    pointer-events:none
}
.svg-marker .listing-marker .listing-marker-pin {
    width:28px;
    height:34px;
    position:absolute;
    top:0;
    left:0;
    z-index:2;
    pointer-events:none
}
.svg-marker .listing-marker .marker-shape {
    fill:#cb2027;
    stroke:#fff;
    stroke-width:1px;
    pointer-events:none;
    z-index:1
}
.svg-marker .listing-marker .marker-icon {
    width:8px;
    height:8px;
    background-color:#fff;
    border:1px solid #fff;
    border-radius:50%;
    position:absolute;
    top:9px;
    left:9px;
    pointer-events:none;
    z-index:2
}
.svg-marker .listing-marker .svg-shadow {
    fill:#000;
    fill-opacity:.24;
    z-index:1;
    position:absolute;
    width:12px;
    height:4px;
    top:30px;
    left:8px
}
@-webkit-keyframes pulse {
    0% {
        opacity:.5;
        -webkit-transform:scale(0.1);
        transform:scale(0.1)
    }
    40% {
        opacity:0;
        -webkit-transform:scale(1);
        transform:scale(1)
    }
    100% {
        opacity:0
    }
}
@keyframes pulse {
    0% {
        opacity:.5;
        -webkit-transform:scale(0.1);
        transform:scale(0.1)
    }
    40% {
        opacity:0;
        -webkit-transform:scale(1);
        transform:scale(1)
    }
    100% {
        opacity:0
    }
}
.svg-marker .listing-marker {
    -webkit-transform:scale(1.45);
    -ms-transform:scale(1.45);
    transform:scale(1.45);
    -webkit-animation-name:drop-marker;
    animation-name:drop-marker;
    -webkit-animation-duration:.4s;
    animation-duration:.4s;
    -webkit-transition-timing-function:ease-in;
    transition-timing-function:ease-in
}
@-webkit-keyframes drop-marker {
    from {
        top:-24px
    }
    to {
        top:0
    }
}
@keyframes drop-marker {
    from {
        top:-24px
    }
    to {
        top:0
    }
}
.svg-marker .listing-marker-pin {
    -webkit-transform:translateY(0px) scale(1);
    -ms-transform:translateY(0px) scale(1);
    transform:translateY(0px) scale(1);
    -webkit-animation:none;
    animation:none
}
.H_ib_content {
    margin: 0 !important;
}
.map-input-container .uk-inline {
    z-index: 1010;
    margin-top: 10px;
    right: 10px;
}
.map-input-container {
    top: 0;
    position: absolute;
    cursor: pointer;
    height: 56px;
}
.map-input-container .uk-card {
    padding-left: 60px;
    padding-right: 10px;
}
.map-search-results.visible {
    visibility: visible;
}

.map-search-results {
    height: 100%;
    position: absolute;
    top: 50px;
    display: block;
    overflow-x: hidden;
    overflow-y: scroll;
    -webkit-overflow-scrolling: touch;
}
.uk-modal.map-modal {
    overflow-y: initial;
}
</style>
