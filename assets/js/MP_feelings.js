/**
 * !!! ne marche qu'avec un seul élément
 * class pour gérer les interaction entre le form type Fields et le user
 * en gros on click sur un label, ça coche/décoche la checkbox cachée
 * @type {{mpFields: module.exports.mpFields}}
 */
module.exports = {

    MP_feelings : function(selector){

        function getElPosition(child, parent, tag){
            var children = parent.getElementsByTagName(tag);
            var i =0;
            while(i<children.length){
                if(child == children[i]){
                    return i;
                }
                i++;
            }
        }

        var el = document.getElementsByClassName(selector);
        if(el.length){
            el = el[0];
            var hiddenCBs = el.getElementsByTagName('option');
            var ui = el.getElementsByClassName('mpFieldsUI')[0];
            var labels = ui.getElementsByTagName('span');
            var i = 0;
            while(i<labels.length){
                labels[i].onclick = function(){
                    var n = getElPosition(this, ui, 'span');
                    hiddenCBs[n].selected = !hiddenCBs[n].selected;
                    this.className = hiddenCBs[n].selected ? 'badge badge-success' : 'badge badge-secondary';
                }
                i++;
            }
        }
    }

}
