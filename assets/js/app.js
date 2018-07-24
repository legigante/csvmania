/**
 * main
 */

// librairies
require('bootstrap-sass');

// customed css
require('../css/app.scss');
require('../css/login.scss');
require('../css/admin.scss');

// slider
require('rangeslider.js');

// date picker
require('flatpickr');
require('flatpickr/dist/l10n/fr.js');
require('flatpickr/dist/l10n/es.js');

// customed libraries
import MP_dndFile from './MP_dndFile.js';
import MP_edit from './MP_edit.js';
import MP_feelings from './MP_feelings.js';
import MP_tableAjax from './MP_tableAjax.js';
import MP_progressBar from './MP_progressBar.js';

// customed scripts
require('./login.js');

// on document ready
$(function () {



    var oEdit = new MP_edit.MP_edit('task-gen');



    var oDND = new MP_dndFile.MP_dndFile('dndFile');



    var oPB = new MP_progressBar.MP_progressBar('progress-bar');


    var el = $('#tokenedit');
    if(el.length){
        var ote = new MP_tableAjax.MP_tableAjax(el, function(res){
            console.log('cb' + ' - ' + JSON.stringify(res));
            if(res.action == 'notif1_admin'){
                oPB.updateBar('barValidated', res.value);
            }else if(res.action == 'notif1'){
                oPB.updateBar('barDone', res.value);
            }
        });
    }



    /* bootstrap tooltype */
    $('.mptooltype').tooltip();



    var oMPF = new MP_feelings.MP_feelings('mpFields');



    /**
     * flatpickr : https://flatpickr.js.org/
     * @type {*|Instance|Instance[]}
     */
    const fp = flatpickr(".flatpickr", {
        locale: document.documentElement.lang,
        allowInput: false,
        // on met à jour les champs cachés à la sélection d'une date
        onChange: function(selectedDates, dateStr, instance){
            var d = selectedDates[0];
            var elName = instance.input.name;
            document.getElementById(elName+'_day').value = d.getDate();
            document.getElementById(elName+'_month').value = d.getMonth()+1;
            document.getElementById(elName+'_year').value = d.getFullYear();
        }
    });



    // slider
    function RS_upd_color(val, left, right){
        var r1 = 204+(204-194)*(1-val/100);
        var g1 = 86+(204-86)*(val/100);
        var b1 = 54+(54-43)*(1-val/100);
        var r2 = 91+(204-91)*(1-val/100);
        var g2 = 204+(204-204)*(val/100);
        var b2 = 54+(54-54)*(val/100);
        left.css('background', 'linear-gradient(to right, rgb('+r1+','+g1+','+b1+'), rgb('+r2+','+g2+','+b2+')');
        //right.css('background', 'linear-gradient(to left, #5bcc36, #cc562b)');
    }

    $('input[type="range"]').rangeslider({
        polyfill: false,
        onInit: function(){
            RS_upd_color(50, this.$fill, this.$range);
        },
        onSlide: function(pos, val){
            RS_upd_color(val, this.$fill, this.$range);
        }
    });




});











