
/**
 * @requires OpenLayers/Marker.js
 *
 * Class: OpenLayers.Marker.LabelMarker
 *
 * Inherits from:
 *  - <OpenLayers.Marker> 
 */
OpenLayers.Marker.LabelMarker = OpenLayers.Class(OpenLayers.Marker, {

    /** 
     * Property: label 
     * {String} Marker label.
     */
    label: "",
    
    markerDiv: null,
    
    initialize: function(lonlat, icon, label) {
        OpenLayers.Marker.prototype.initialize.apply(this, [lonlat, icon]);
        
        this.markerDiv = OpenLayers.Util.createDiv();
        this.markerDiv.appendChild(this.icon.imageDiv);
        var txtDiv = OpenLayers.Util.createDiv();
        txtDiv.className = 'markerLabel';
        OpenLayers.Util.modifyDOMElement(txtDiv, null, new
OpenLayers.Pixel(0, this.icon.size.h));
        txtDiv.appendChild(document.createTextNode(this.name));
        this.markerDiv.appendChild(txtDiv);
    },
    
    /** 
     * Method: destroy
     * Nullify references and remove event listeners to prevent circular 
     * references and memory leaks
     */
    destroy: function() {
        OpenLayers.Marker.prototype.destroy.apply(this, arguments);
        this.markerDiv.innerHTML = "";
        this.markerDiv = null;
    },
    
    draw: function(px) {
        OpenLayers.Util.modifyAlphaImageDiv(this.icon.imageDiv, 
                                            null, 
                                            null, 
                                            this.icon.size, 
                                            this.icon.url);
                                            
        OpenLayers.Util.modifyDOMElement(this.markerDiv, null, px);

        return this.markerDiv;
    },
    
    redraw: function(px) {
        if ((px != null) && (this.markerDiv != null)) {
            OpenLayers.Util.modifyDOMElement(this.markerDiv, null, px);
        }
    },
    
    moveTo: function (px) {
        this.redraw(px);
        this.lonlat = this.map.getLonLatFromLayerPx(px);
    },
    
    isDrawn: function() {
        // nodeType 11 for ie, whose nodes *always* have a parentNode
        // (of type document fragment)
        var isDrawn = (this.markerDiv && this.markerDiv.parentNode && 
                       (this.markerDiv.parentNode.nodeType != 11));    

        return isDrawn; 
    },

    CLASS_NAME: "OpenLayers.Marker.LabelMarker"
});
