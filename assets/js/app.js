/**
 * Ici les scripts génériques présents partout
 */


// librairies
var $ = require('jquery');
require('bootstrap-sass');
require('flatpickr');
require('flatpickr/dist/l10n/fr.js');
require('flatpickr/dist/l10n/es.js');

// customed
require('../css/app.scss');



// on document ready
$(function () {

});







/* drag and drop file */
function oDndFile() {
    // constructor
    var alreadyUploaded = false;
    var dndFile = document.getElementById('dndFile');
    var that = this;
    if (dndFile) {
        var holder = dndFile.getElementsByClassName('dndholder')[0];
        holder.ondragover = function () {
            if(!alreadyUploaded){
                this.className = 'dndholder dndhover';
            }
            return false;
        };
        holder.ondragend = function () {
            if(!alreadyUploaded){
                this.className = 'dndholder dnddefault';
            }
            return false;
        };
        holder.ondragstart = function () {
            if(!alreadyUploaded){
                this.className = 'dndholder dndhover';
            }
            return false;
        };
        holder.ondragleave = function () {
            if(!alreadyUploaded){
                this.className = 'dndholder dnddefault';
                return false;
            }
        };
        holder.ondrop = function (e) {
            if(!alreadyUploaded){
                this.className = 'dndholder dnddefault';
                e.preventDefault();
                that.readFile(e.dataTransfer.files);
            }else{
                return false;
            }
        }
    }

    // read file
    this.readFile = function (file) {
        reader = new FileReader();
        reader.onload = function (event){
            // check format
            var data64 = event.target.result.split('base64,')[1];
            data = atob(data64);
            if(/^([^\r\n]*);([^\r\n;]+)$/gm.test(data)){
                var nbRow = (data.match(/[\r\n]/g) || []).length;
                dndFile.getElementsByTagName('input')[0].value = data64;
                var span = holder.getElementsByTagName('span')[1];
                span.innerHTML = span.innerHTML.replace('%n', nbRow);
                holder.className = 'dndholder dndsuccess';
                alreadyUploaded = true;
            }else{
                holder.className = 'dndholder dndbadformat';
            }
        }
        reader.readAsDataURL(file[0]);
    }
}
var oDND = new oDndFile();




/* flatpickr */
const fp = flatpickr(".flatpickr", {
    locale: document.documentElement.lang,
    allowInput: true,
    onChange: function(selectedDates, dateStr, instance){
        var d = selectedDates[0];
        var elName = instance.input.name;
        document.getElementById(elName+'_day').value = d.getDay();
        document.getElementById(elName+'_month').value = d.getMonth()+1;
        document.getElementById(elName+'_year').value = d.getFullYear();
    }
});
