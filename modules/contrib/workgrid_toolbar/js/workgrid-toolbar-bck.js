/**
 * @file
 * Workgrid Toolbar behaviors.
 */

 (function ($, Drupal, drupalSettings) {

    'use strict';
  
    /**
     * Behavior description.
     */
      function toolbarauth() {
          console.log("apiendpoint");
          return fetch(drupalSettings.path.baseUrl + '/workgrid_toolbar/rest_resource?_format=json', { headers: { Accept: 'application/json', 
//          Authorization: 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE2MTY2ODMxNjQsImV4cCI6MTYxNjY4Njc2NCwiZHJ1cGFsIjp7InVpZCI6IjEifX0.6P56-wN6k3zkzHPyMD2reIvgcp0CDyarn6fEfsWDSfs'
          }}
          )
              .then(resp => {
              if (resp.ok) {
              return resp.text();
              } else {
              throw new Error('An error occurred attempting to get the token');
              }
              })
      }
      Drupal.behaviors.workgridToolbar = {
        attach: function (context, settings) {
           $('main', context).once('workgridToolbar').each(function () {
  
  
           workgrid.addEventListener('layout', function(event) {
              var toolbartray = document.getElementById('toolbar-item-administration-tray');
              var toolbar = document.getElementById('toolbar-bar');
  
              var margintop = toolbartray.offsetHeight + toolbar.offsetHeight+1;
              document.getElementById('workgrid-stylable-wrap').style.marginTop = margintop + 'px';
  
              var height = window.innerHeight - margintop;
              document.getElementById('workgrid-stylable-wrap').style.height = height + 'px';
  
  
  /** 
              if (window.innerHeight >= 975) {
                      var toolbartray = document.getElementById('toolbar-item-administration-tray');
                      var toolbar = document.getElementById('toolbartray');
          
                      var margintop = toolbartray.offsetHeight + toolbar.offsetHeight+1;
                      document.getElementById('workgrid-stylable-wrap').style.marginTop = margintop + 'px';
          
                      var height = window.innerHeight - margintop;
                      document.getElementById('workgrid-stylable-wrap').style.height = height + 'px';
          
              } else if (window.innerWidth >= 775) {
                      var toolbartray = document.getElementById('toolbar-item-administration-tray');
                      var toolbar = document.getElementById('toolbartray');
          
                      var margintop = toolbartray.offsetHeight + 1;
                      document.getElementById('workgrid-stylable-wrap').style.marginTop = margintop + 'px';
          
                      var height = window.innerHeight - margintop;
                      var width =  toolbartray.offsetwidth + 1;
                      document.getElementById('workgrid-stylable-wrap').style.height = height + 'px';
                      document.getElementById('workgrid-stylable-wrap').style.marginLeft = width + 'px';
              } else {
                      var width= window.innerWidth + 1;
                      document.getElementById('workgrid-stylable-wrap').style.marginLeft = width + 'px'; 	    
              }
  */
              // '79px' 
              // 855px
      //  		document.getElementById('workgrid-stylable-wrap').style.marginTop=drupalSettings.workgrid_toolbar.margintop;
      //  		document.getElementById('workgrid-stylable-wrap').style.height=drupalSettings.workgrid_toolbar.height;
  
  
  //      		document.getElementById('workgrid-stylable-wrap').style.marginLeft=drupalSettings.workgrid_toolbar.marginleft;
  //      		document.getElementById('workgrid-stylable-wrap').style.marginRight=drupalSettings.workgrid_toolbar.marginright;
  //      		document.getElementById('workgrid-stylable-wrap').style.marginBottom=drupalSettings.workgrid_toolbar.marginbottom;
  //      		document.getElementById('workgrid-stylable-wrap').style.Orientation=drupalSettings.workgrid_toolbar.orientation;
  
        });
  
  
  
              window.onresize = function() {
                  if (window.innerWidth >= 975) {
                          console.log(window.innerHeight );
                          var toolbartray = document.getElementById('toolbar-item-administration-tray');
                          var toolbar = document.getElementById('toolbar-bar');
              
                          var margintop = toolbartray.offsetHeight + toolbar.offsetHeight+1;
                                      console.log(window.innerHeight );
              
                          document.getElementById('workgrid-stylable-wrap').style.marginTop = margintop + 'px';
              
                          var height = window.innerHeight - margintop;
                          console.log(height);
                          document.getElementById('workgrid-stylable-wrap').style.height = height + 'px';
              
                  } else if (window.innerWidth >= 775) {
                          var toolbartray = document.getElementById('toolbar-item-administration-tray');
                          var toolbar = document.getElementById('toolbar-bar');
              
                          var margintop = toolbartray.offsetHeight + 1;
                          document.getElementById('workgrid-stylable-wrap').style.marginTop = margintop + 'px';
              
                          var height = window.innerHeight - margintop;
                          var width =  toolbartray.offsetwidth + 1;
                          document.getElementById('workgrid-stylable-wrap').style.height = height + 'px';
                          document.getElementById('workgrid-stylable-wrap').style.marginLeft = width + 'px';
                  } else {
                          var width= window.innerWidth + 1;
                          document.getElementById('workgrid-stylable-wrap').style.marginLeft = width + 'px'; 	    
                  }
              }
  
          workgrid.init(toolbarauth,"615f8474-7527-4493-afd4-f2c2d9e078cd", "workgridsoftware.dev");
         });
      }
    };
  })(jQuery, Drupal, drupalSettings);