/**
 * set progress bar width for animation
 * @type {{progressBar: module.exports.progressBar}}
 */
module.exports = {

    MP_progressBar : function(selector){

        this.draw = function(el){

            var w = Math.round(100*(el.getAttribute('aria-valuenow')/el.getAttribute('aria-valuemax'))*100)/100;
            el.style.width = w+'%';
            el.innerHTML = '<span>' + w + '%</span>';
            el.parentElement.setAttribute('data-original-title', el.getAttribute('aria-valuenow') + '/' + el.getAttribute('aria-valuemax'));
            if(w==100){
                el.style.backgroundColor = '#5bcc36';
            }else{
                el.style.backgroundColor = '#337ab7';
            }
            if(w==0){
                el.style.color = 'black';
            }else{
                el.style.color = 'black';
            }

        }



        this.updateBar = function(id, i){
            var el = document.getElementById(id);
            el.setAttribute('aria-valuenow', parseInt(el.getAttribute('aria-valuenow')) + i);
            this.draw(el);
        }

        // constructor
        var pbs = document.getElementsByClassName(selector);
        var i = 0;
        while(i < pbs.length){
            var pb = pbs[i];
            this.draw(pb);
            i++;
        }

    }

}
