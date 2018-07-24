
/**
 * drag and drop file (!!! ne marche qu'avec un seul input !!!)
 * @type {{dndFile: module.exports.dndFile}}
 */
module.exports = {
    MP_dndFile : function (selector) {

        // constructor
        var alreadyUploaded = false;
        var dndFile = document.getElementsByClassName(selector);

        if (dndFile.length) {
            var that = this;


            // handle default value
            this.setData = function (data64) {
                var data = atob(data64);
                if (/^([^\r\n]*);([^\r\n;]+)$/gm.test(data)) {
                    console.log(data)
                    var nbRow = (data.match(/[\r\n]/g) || []).length;
                    dndTextarea.value = data64;
                    var span = dndHolder.getElementsByTagName('span')[1];
                    span.innerHTML = span.innerHTML.replace('%n', nbRow);
                    dndHolder.className = 'form-control dndholder dndsuccess';
                    alreadyUploaded = true;
                } else {
                    dndHolder.className = 'form-control dndholder dndbadformat';
                }
            }
            // read file
            this.readFile = function (file) {
                var reader = new FileReader();
                reader.onload = function (event) {
                    // check format
                    var data64 = event.target.result.split('base64,')[1];
                    that.setData(data64);
                }
                reader.readAsDataURL(file[0]);
            }


            // group element
            dndFile = dndFile[0];

            // find form and hidden input file
            var dndForm = dndFile.parentElement;
            var dndInputFile = null;
            while (dndForm.tagName.toUpperCase() != 'FORM') {
                if (dndInputFile == null && dndForm.className.indexOf('form-group') >= 0) {
                    dndInputFile = dndForm.getElementsByTagName('input')[0];
                }
                dndForm = dndForm.parentElement;
            }

            // drag and drop event
            var dndHolder = dndFile.getElementsByClassName('dndholder')[0];
            dndHolder.ondragover = function () {
                if (!alreadyUploaded) {
                    this.className = 'form-control dndholder dndhover';
                }
                return false;
            };
            dndHolder.ondragend = function () {
                if (!alreadyUploaded) {
                    this.className = 'form-control dndholder dnddefault';
                }
                return false;
            };
            dndHolder.ondragstart = function () {
                if (!alreadyUploaded) {
                    this.className = 'form-control dndholder dndhover';
                }
                return false;
            };
            dndHolder.ondragleave = function () {
                if (!alreadyUploaded) {
                    this.className = 'form-control dndholder dnddefault';
                    return false;
                }
            };
            dndHolder.ondrop = function (e) {
                if (!alreadyUploaded) {
                    this.className = 'form-control dndholder dnddefault';
                    e.preventDefault();
                    that.readFile(e.dataTransfer.files);
                } else {
                    return false;
                }
            };
            dndHolder.onclick = function () {
                dndInputFile.click();
            }

            dndInputFile.onchange = function () {
                that.readFile(this.files);
            }

            // find textarea
            var dndTextarea = dndFile.getElementsByTagName('textarea')[0];
            if (dndTextarea.value != '') {
                this.setData(dndTextarea.value);
            }

            // on met rouge si required et vide
            if (dndTextarea.required == true) {
                dndTextarea.required = false;
                dndForm.onsubmit = function () {
                    if (!alreadyUploaded) {
                        dndHolder.className = 'form-control dndholder dndrequired';
                        return false;
                    }
                }
            }
        }
    }
}