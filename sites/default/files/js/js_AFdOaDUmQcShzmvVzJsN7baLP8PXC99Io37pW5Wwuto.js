/**
 * @file
 * Workgrid Toolbar behaviors.
 */

(function ($, Drupal, drupalSettings) {


    /**
     * Calls the toolbar init method and calls auth using config settings
     * Event listeners size toolbar according to configuration within the block
     */
    function toolbarauth() {
        return fetch('/workgrid-toolbar/get-toolbar-token', { headers: { Accept: 'application/json' } })
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

                workgrid.addEventListener('layout', function (event) {
          
                    var margintop = drupalSettings.workgrid_toolbar.margintop;
                    var marginbottom = drupalSettings.workgrid_toolbar.marginbottom;
                    document.getElementById('workgrid-stylable-wrap').style.marginTop = margintop + 'px';
                    document.getElementById('workgrid-stylable-wrap').style.marginBottom = marginbottom + 'px';

                    var height = window.innerHeight - margintop - marginbottom;
                    document.getElementById('workgrid-stylable-wrap').style.height = height + 'px';
                   
                });
                
                window.onresize = function () {
                    var margintop = drupalSettings.workgrid_toolbar.margintop;
                    var marginbottom = drupalSettings.workgrid_toolbar.marginbottom;
                    document.getElementById('workgrid-stylable-wrap').style.marginTop = margintop + 'px';
                    document.getElementById('workgrid-stylable-wrap').style.marginBottom = marginbottom + 'px';

                    var height = window.innerHeight - margintop - marginbottom;
                    document.getElementById('workgrid-stylable-wrap').style.height = height + 'px';
                } 
                var spaceId = drupalSettings.workgrid_toolbar.spaceId;
                var companyCode = drupalSettings.workgrid_toolbar.companyCode;
                workgrid.init(toolbarauth, spaceId, companyCode);
            });
        }
    };
})(jQuery, Drupal, drupalSettings);;
