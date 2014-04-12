
M.qtype_easyoddname={
    insert_easyoddname_applet : function(Y, topnode, feedback, readonly, stripped_answer_id, slot){
       // var javaparams = ['mol', Y.one(topnode+' input.mol').get('value')];   ///CRL changed smiles to mol
//        var javaparams = new Array();



	



        /*if (appletoptions) {
            easyoddnameoptions[easyoddnameoptions.length] = appletoptions;



        }*/











        if (readonly) {
//            easyoddnameoptions[easyoddnameoptions.length] = "false";  ///crl changed depict to true
//	     javaparams.menubar = "false";	    
//            easyoddnameoptions[easyoddnameoptions.length + 1] = "false";  ///crl changed depict to true
//	    easyoddnameoptions[easyoddnameoptions.length] = Y.one(topnode+' input.mol').get('value');  ///crl changed depict to true
	   // easyoddnameoptions[easyoddnameoptions.length] = Y.one(topnode+' input.mol').get('value');  ///crl 


        }


	    var inputdiv = Y.one(topnode);
	    inputdiv.ancestor('form').on('submit', function (){

		
		//var	pos0=document.getElementById('apos0'+slot).value;
		//var	pos1=document.getElementById('apos1'+slot).value;
		//var	pos2=document.getElementById('apos2'+slot).value;
		//var	pos3=document.getElementById('apos3'+slot).value;
		//var	pos4=document.getElementById('apos4'+slot).value;
		//var	pos5=document.getElementById('apos5'+slot).value;


		var items = document.getElementById('list1'+slot).childNodes;
	            var out = ""; 
	            for (i=1;i<items.length;i=i+1) {
			if (i == items.length - 1){
	                out += items[i].innerHTML;
			}
			else{
			out += items[i].innerHTML;
			}
	            } 

		
	// textfieldid = topnode+' input.answer';
	// textfieldid = 'id_answer_' + buttonnumber;
	// document.getElementById(textfieldid).value = out;


	//	textfieldid = topnode+' input.answer';
		//orderstring = arr.join("-");
		//console.log("orderstring="+orderstring);
		Y.one(topnode+' input.answer').set('value', out);
		//Y.one(topnode+' input.mol').set('value', orderstring);
		//alert('break');

//                Y.one(topnode+' input.answer').set('value', this.find_java_applet(name).smiles());
//                Y.one(topnode+' input.jme').set('value', this.find_java_applet(name).jmeFile());
//                Y.one(topnode+' input.mol').set('value', this.find_java_applet(name).molFile())
            }, this);


    },













    show_error : function (Y, topnode) {
        var errormessage = '<span class ="javawarning">'
            +M.util.get_string('enablejava', 'qtype_easyoddname')+
            '</span>';
        Y.one(topnode+ ' .ablock').insert(errormessage, 1);
    },
    /**
     * Gets around problem in ie6 using appletname
     */
    find_java_applet : function (appletname) {
//	alert(appletname);
        for (appletno in document.applets) {
            if (document.applets[appletno].name == appletname) {
                return document.applets[appletno];
            }
        }
        return null;
    },

    nextappletid : 1,
    javainstalled : -99,
    doneie6focus : 0,
    doneie6focusapplets : 0,
 // Note: This method is also called from mod/audiorecorder




    show_java : function (id, appletid, appletname, java, width, height, appletclass, javavars, stripped_answer_id) {
        if (this.javainstalled == -99 ) {
            this.javainstalled = PluginDetect.isMinVersion(
                'Java', 1.5, 'plugindetect.getjavainfo.jar', [0, 2, 0]) == 1;
        }
        var warningspan = document.getElementById(id);
        warningspan.innerHTML = '';
        if (!this.javainstalled) {
            return false;
        }
        var newApplet = document.createElement("applet");
        newApplet.code=appletclass;
        newApplet.archive=java;
        newApplet.name=appletname;
        newApplet.width=width;
        newApplet.height=height;
        newApplet.tabIndex = -1; // Not directly tabbable
        newApplet.mayScript = true;     
	newApplet.id = appletid;
//	newApplet.setAttribute('molFormat', "smiles");
//	newApplet.setAttribute('mol', '');



//	newApplet.setAttribute('mol', document.getElementById(stripped_answer_id).value);
//	newApplet.setAttribute('codebase','../../../easyoddname');
//	newApplet.setAttribute('autoscale','true');
	newApplet.setAttribute('codebase','/marvin');
	newApplet.setAttribute('implicitH','heteroterm');
	
//	newApplet.setAttribute('menuconfig','customization_mech_student.xml');
//	newApplet.setAttribute('autoscale','true');
//	newApplet.setAttribute('importConv','-a');
        // In case applet supports the focushack system, we
        // pass in its id as a parameter.
        javavars[javavars.length] = 'focushackid';
        javavars[javavars.length] = newApplet.id;
        for (var i=0;i<javavars.length;i+=2) {
            var param=document.createElement('param');
            param.appletname=javavars[i];
            param.value=javavars[i+1];
            newApplet.appendChild(param);
        }
/*            param.name='viewonly';
            param.value='false';
	    param.name='menubar';
            param.value='false';
*/

	 var s = document.getElementById(stripped_answer_id).value;
	s=encodeURIComponent(s);
//	newApplet.setAttribute('mol', s);
	    param.name='mol';
            param.value = s;




        warningspan.appendChild(newApplet);

        if(document.body.className.indexOf('ie6')!=-1 && !this.doneie6focus) {
            var fixFocus = function() {
                if(document.activeElement && document.activeElement.nodeName.toLowerCase()=='applet') {
                    setTimeout(fixFocus, 100);
                    this.doneie6focus = 1;
                    this.doneie6focusapplets ++;
                    window.focus();
                } else {
                    this.doneie6focus++;
                    if(this.doneie6focus == 2 && this.doneie6focusapplets > 0) {
                        // Focus one extra time after applet gets it
                        window.focus();
                    }
                    if(this.doneie6focus < 50) {
                        setTimeout(fixFocus, 100);
                    }
                }
            };
            window.arghApplets = 0;
            setTimeout(fixFocus, 100);
            this.doneie6focus=1;
        }
        return true;
    }



}


M.qtype_easyoddname.dragndrop = function(Y, slot){


YUI().use('dd-constrain', 'dd-proxy', 'dd-drop', function(Y) {



    //Listen for all drop:over events
    Y.DD.DDM.on('drop:over', function(e) {
        //Get a reference to our drag and drop nodes
        var drag = e.drag.get('node'),
            drop = e.drop.get('node');
        
	//check to see that we are dropping on list1
	if (drop.get('id') === 'list1'+slot || drop.get('parentNode').get('id') === 'list1'+slot) {
		//Are we dropping on a li node?
		if (drop.get('tagName').toLowerCase() === 'li') {
		    //Are we not going up?
		    if (!goingUp) {
		        drop = drop.get('nextSibling');
		    }
		    //Add the node to this list
		    e.drop.get('node').get('parentNode').insertBefore(drag, drop);
		    //Resize this nodes shim, so we can drop on it later.
		    e.drop.sizeShim();
		}
	}


    });
    //Listen for all drag:drag events
    Y.DD.DDM.on('drag:drag', function(e) {
        //Get the last y point
        var y = e.target.lastXY[1];
        //is it greater than the lastY var?
        if (y < lastY) {
            //We are going up
            goingUp = true;
        } else {
            //We are going down.
            goingUp = false;
        }
        //Cache for next check
        lastY = y;
    });
    //Listen for all drag:start events
    Y.DD.DDM.on('drag:start', function(e) {
        //Get our drag object
        var drag = e.target;
        //Set some styles here
        drag.get('node').setStyle('opacity', '.25');
        nextsibling = drag.get('node').next();
	dragparentid = drag.get('node').get('parentNode').get('id');
        drag.get('dragNode').set('innerHTML', drag.get('node').get('innerHTML'));
        drag.get('dragNode').setStyles({
            opacity: '.5',
            borderColor: drag.get('node').getStyle('borderColor'),
            backgroundColor: drag.get('node').getStyle('backgroundColor')
        }); 
    });
    //Listen for a drag:end events
    Y.DD.DDM.on('drag:end', function(e) {

	//alert('drag:end');

        var drag = e.target;
        //Put our styles back  crl-this is style of dragged node
        drag.get('node').setStyles({
            visibility: '',
            opacity: '1'
        }); 
    });


    Y.DD.DDM.on('drop:hit', function(e) {
	var drop = e.drop.get('node'),
            drag = e.drag.get('node');
        var flag = false;
	if(drop.get('tagName').toLowerCase() === "li" && drop.get('id') === 'list1'+slot){
	flag = true;
	}	


		if(dragparentid !== "list1"+slot && (drop.get('id') === "list1"+slot || drop.get('tagName').toLowerCase() === 'li')){

			if(nextsibling !== null){
			var newnode = drag.get('parentNode').insertBefore('<li class="list2">'+drag.get('innerHTML')+'</li>', nextsibling);
			}
			else{
			var newnode = drag.get('parentNode').insertBefore('<li class="list2">'+drag.get('innerHTML')+'</li>', Y.one('#'+dragparentid).get('lastChild'));
			}

			dd = new Y.DD.Drag({
			    node: newnode,
			    target: {
				padding: '0 0 0 20'
			    }
			}).plug(Y.Plugin.DDProxy, {
			    moveOnEnd: false,
			}).plug(Y.Plugin.DDConstrained, {
			    constrain2node: '#play'+slot
			});
		}
    });



    //Listen for all drag:drophit events
    Y.DD.DDM.on('drag:drophit', function(e) {

        var drop = e.drop.get('node'),
            drag = e.drag.get('node');

        if (drop.get('tagName').toLowerCase() !== 'li') {
            if (!drop.contains(drag)) {
                drop.appendChild(drag);
            }
        }
    });
    
    //Static Vars
    var goingUp = false, lastY = 0;
    var nextsibling = '';
    var dragparentid = '';

    // Get the list of li's in the lists and make them draggable

    var lis = Y.Node.all('.list2');
    lis.each(function(v, k) {
        var dd = new Y.DD.Drag({
            node: v,
            target: {
                padding: '0 0 0 20'
            }
        }).plug(Y.Plugin.DDProxy, {
            moveOnEnd: false,
        }).plug(Y.Plugin.DDConstrained, {
        });
    }); 


    var uls = Y.Node.all('.dropable');
    uls.each(function(v, k) {
        var tar = new Y.DD.Drop({
            node: v
        });
    });
    
});


};

