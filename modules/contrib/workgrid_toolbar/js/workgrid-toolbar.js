/**
 * @file
 * Workgrid Toolbar behaviors.
 */

 (function ($, Drupal, drupalSettings) {

    'use strict';
  
    /**
     * Behavior description.
     */
      function toolbarauth(authendpoint) {
            console.log("apiendpoint");
            return fetch(authendpoint, { headers: { Accept: 'application/json', 
          }}
        ).then(resp => {
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
            var authendpoint = drupalSettings.workgrid_toolbar.authendpoint;
            if (authendpoint != "") {
            workgrid.addEventListener('layout', function(event) {
              var toolbartray = document.getElementById('toolbar-item-administration-tray');
              var toolbar = document.getElementById('toolbar-bar');

              var margintop = toolbartray.offsetHeight + toolbar.offsetHeight+1;
              document.getElementById('workgrid-stylable-wrap').style.marginTop = margintop + 'px';

              var height = window.innerHeight - margintop;
              document.getElementById('workgrid-stylable-wrap').style.height = height + 'px';  
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
          
              }
              else if (window.innerWidth >= 775) {
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

            var spaceId = drupalSettings.workgrid_toolbar.spaceId;
            var companyCode = drupalSettings.workgrid_toolbar.companyCode;

            workgrid.init(toolbarauth(authendpoint), spaceId, companyCode);
          }
          else {
            console.log("Auth endpoint is empty.");
          }

//          workgrid.init(toolbarauth,"615f8474-7527-4493-afd4-f2c2d9e078cd", "workgridsoftware.dev");
        });
      }
    };
  })(jQuery, Drupal, drupalSettings);