// Canvas renderer
function Canvasrenderer() 
{	
	// List of all valid canvas functions
	// No other operation in the XML should be possible to run
	var validFuctions = ['beginpath', 'moveto', 'lineto', 'stroke', 'createlineargradient', 'createpattern', 'createradialgradient', 'rect', 'fillrect', 'strokerect', 'clearrect', 'fill', 'closepath', 'clip', 'quadraticcurveto', 'beziercurveto', 'arc', 'arcto', 'ispointinpath', 'scale', 'rotate', 'translate', 'transform', 'measuretext', 'drawimage', 'createimagedata', 'getimagedata', 'putimagedata', 'state_fillstyle', 'state_strokestyle', 'state_shadowcolor', 'state_shadowblur', 'state_shadowoffsetx', 'state_shadowoffsety', 'state_linecap', 'state_linejoin', 'state_linewidth', 'state_miterlimit', 'state_font', 'state_textalign', 'state_textbaseline', 'state_width', 'state_height', 'state_data', 'state_globalapha', 'state_globalcompositeoperation'];


	// Execute timestep nodes
	this.executeTimestep = function(nodes){
		// Step through nodes
		for(x = 0; x < nodes.length; x++) {
			console.log(nodes[x].attributes);

			if(nodes[x].attributes != null){
				console.log("attribute length " + nodes[x].attributes.length);
				// Continue if invalid node (i.e. #text)
				if(nodes[x].nodeName.substring(0,1) == "#") continue;
				console.log("nodes: "+nodes[x].nodeName);

				// Check number of arguments and call canvas function
				// TODO: Add for functions with more arguments
				if(nodes[x].attributes.length == 0){
					this[nodes[x].nodeName]();
				}
				else if(nodes[x].attributes.length == 1){
					this[nodes[x].nodeName](nodes[x].attributes.item(0).nodeValue);
				}
				else if(nodes[x].attributes.length == 2){
					this[nodes[x].nodeName](nodes[x].attributes.item(0).nodeValue, nodes[x].attributes.item(1).nodeValue);
				}
				else if(nodes[x].attributes.length == 3){
					this[nodes[x].nodeName](nodes[x].attributes.item(0).nodeValue, nodes[x].attributes.item(1).nodeValue, nodes[x].attributes.item(2).nodeValue);
				}
				else if(nodes[x].attributes.length == 4){
					this[nodes[x].nodeName](nodes[x].attributes.item(0).nodeValue, nodes[x].attributes.item(1).nodeValue, nodes[x].attributes.item(2).nodeValue, nodes[x].attributes.item(3).nodeValue);
				}
				else if(nodes[x].attributes.length == 5){
					this[nodes[x].nodeName](nodes[x].attributes.item(0).nodeValue, nodes[x].attributes.item(1).nodeValue, nodes[x].attributes.item(2).nodeValue, nodes[x].attributes.item(3).nodeValue, nodes[x].attributes.item(4).nodeValue);
				}
				else if(nodes[x].attributes.length == 6){
					this[nodes[x].nodeName](nodes[x].attributes.item(0).nodeValue, nodes[x].attributes.item(1).nodeValue, nodes[x].attributes.item(2).nodeValue, nodes[x].attributes.item(3).nodeValue, nodes[x].attributes.item(4).nodeValue, nodes[x].attributes.item(5).nodeValue);
				}
				else if(nodes[x].attributes.length == 7){
					this[nodes[x].nodeName](nodes[x].attributes.item(0).nodeValue, nodes[x].attributes.item(1).nodeValue, nodes[x].attributes.item(2).nodeValue, nodes[x].attributes.item(3).nodeValue, nodes[x].attributes.item(4).nodeValue, nodes[x].attributes.item(5).nodeValue, nodes[x].attributes.item(6).nodeValue);
				}
				else if(nodes[x].attributes.length == 8){
					this[nodes[x].nodeName](nodes[x].attributes.item(0).nodeValue, nodes[x].attributes.item(1).nodeValue, nodes[x].attributes.item(2).nodeValue, nodes[x].attributes.item(3).nodeValue, nodes[x].attributes.item(4).nodeValue, nodes[x].attributes.item(5).nodeValue, nodes[x].attributes.item(6).nodeValue, nodes[x].attributes.item(7).nodeValue);
				}
				else if(nodes[x].attributes.length == 9){
					this[nodes[x].nodeName](nodes[x].attributes.item(0).nodeValue, nodes[x].attributes.item(1).nodeValue, nodes[x].attributes.item(2).nodeValue, nodes[x].attributes.item(3).nodeValue, nodes[x].attributes.item(4).nodeValue, nodes[x].attributes.item(5).nodeValue, nodes[x].attributes.item(6).nodeValue, nodes[x].attributes.item(7).nodeValue, nodes[x].attributes.item(8).nodeValue);
				}
			}	
		}	
	}
	
	/*
	 * Canvas functions
	 */
	this.beginpath = function() {
		ctx.lineWidth = 5;
		ctx.beginPath();
	}

	this.moveto = function(x, y) {
		ctx.moveTo(x,y);
	}

	this.lineto = function(x, y) {
		ctx.lineTo(x, y);
	}

	this.stroke = function() {
		ctx.stroke();
	}
	
	this.createlineargradient = function(x, y, x1,y1){		      
	    ctx.createLinearGradient(x, y, x1,y1);
	}
	
	this.createpattern = function(x, y,img){		        
	    ctx.createPattern(x, y,img);
	}
	this.createradialgradient = function(x, y,r, x1,y1,r1){   
	    ctx.createRadialGradient(x, y,r, x1,y1,r1);
	}
		
		// Rectangle functions
	this.rect = function(x, y, width, height){
	    ctx.rect(x, y, width, height);
	}
	
	this.fillrect = function(x, y, width, height){		
	    ctx.fillrect(x, y, width, height);
	}
		
	this.strokerect = function(x, y, width, height){        
	    ctx.strokeRect(x, y, width, height);
	}
	
	this.clearrect = function(x, y, width, height){	    
	    ctx.clearRect(x, y, width, height);
	}
	// Path functions
	this.fill = function(){	
	    ctx.fill();
	}
	
	this.closepath = function(){       
		ctx.closePath();		
	}
	
	this.clip = function(){	   
	    ctx.clip();
	}
	this.quadraticcurveto = function(x, y, cpx, cpy){        
	    ctx.quadraticCurveTo(x, y, cpx, cpy);
	}
	
	this.beziercurveto = function(x, y, cpx, cpy, cpx1, cpy1){        
	     ctx.bezierCurveTo(x, y, cpx, cpy, cpx1, cpy1);
	}
	
	this.arc = function(x, y,r,sAngle,eAngle,counterclockwise){        
	    ctx.arc(x, y,r,sAngle,eAngle,counterclockwise);
	}
	
	this.arcto = function(x, y,r,x1,y1){
	    ctx.arcTo(x, y,r,x1,y1);
	}
	
	this.ispointinpath = function(x, y){	      
	    ctx.isPointInPath(x, y);
	}
	// Transformation functions
	this.scale = function(width, height){   
	    ctx.scale(width, height);
	}
		
	this.rotate = function(angle){	      
	    ctx.rotate(angle);
	}
		
	this.translate = function(x, y){	      
	    ctx.translate(x, y);
	}
	this.transform = function(a,b,c,d,e,f){
        ctx.transform(a,b,c,d,e,f);
	}
		
	this.settransform = function(a,b,c,d,e,f){	      
	    ctx.setTransform(a,b,c,d,e,f);
	}
	// Text functions
	this.filltext = function(x, y,text,maxWidth){		
		ctx.fillText(x, y,text,maxWidth);
	}
	this.stroketext = function(x, y,text,maxWidth){		
		ctx.strokeText(x, y,text,maxWidth);
	}
	this.measuretext = function(text){		
		ctx.measureText(text);
	}
	// Image draw functions
	this.drawimage = function(img,sx,sy,swidth,sheight,x,y,width,height){		
		ctx.drawImage(img,sx,sy,swidth,sheight,x,y,width,height);
	}
	// Pixel manipulation functions
	this.createimagedata = function( imageData, width, height){		
		ctx.createImageData( imageData, width, height);
	}
	this.getimagedata = function(x, y, width, height){		
		ctx.getImageData(x, y, width, height);
	}
	this.putimagedata = function(imgData,x,y,dirtyX,dirtyY,dirtyWidth,dirtyHeight){		
		ctx.putImageData(imgData,x,y,dirtyX,dirtyY,dirtyWidth,dirtyHeight);
	}	

	/*
	 *
	 * Start running XML
	 *
	 */
	var c = document.getElementById('Canvas');
	var ctx = c.getContext("2d");
	var delay = 0;
	
	if (window.XMLHttpRequest){   
		  // code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}else {	
		  // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	  
	// Open XML
	xmlhttp.open("GET","canvas.xml",false);
  	xmlhttp.send();
  	xmlDoc=xmlhttp.responseXML;
	
  	// Load timesteps
  	timesteps = xmlDoc.getElementsByTagName("script")[0].childNodes;
	var totalTime = 0;

	// Step through timesteps
	for(i = 0; i < timesteps.length; i++){		 
		timestepElements = xmlDoc.getElementsByTagName("timestep");

		// Check for elements
		if(timestepElements[i]){
			// Fetch delay
			delay = timestepElements[i].getAttribute("delay");
			totalTime += parseInt(delay);
			
			// Fetch timestep nodes
			nodes = timestepElements[i].childNodes;

			// Execute timestep nodes after specified delay
			setTimeout(executeTimestep, totalTime, nodes);
		}
	}	
}