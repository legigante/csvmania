


module.exports = {

    MP_edit : function (id) {


        function hideInputs(arr){
            for(el of arr){
                el.className += ' d-none';
            }
        }
        function showInputs(arr){
            for(el of arr){
                el.className = el.className.replace('d-none','');
            }
        }
        function initChangeEvent(arr){
            for(el of arr){
                el.onchange = function(e){
                    var prop = el.getAttribute('data-prop');
                    var val = el.value;

                    var json = {
                        prop: prop,
                        val: val
                    }

                }
            }
        }


        var block = document.getElementById(id);
        if(block!=null){

            var readOnly = true;
            var butSwitch = block.getElementsByClassName('fa-edit');
            var url = block.getAttribute('action');
            var mpRead = block.getElementsByClassName('mpRead');
            var mpWrite = block.getElementsByClassName('mpWrite');
            var objID = block.getAttribute('data-id');

            butSwitch[0].onclick = function(e){

                readOnly = !readOnly;
                if(readOnly){
                    hideInputs(mpWrite);
                    showInputs(mpRead);
                }else{
                    hideInputs(mpRead);
                    showInputs(mpWrite);
                }

            }

        }
    }
}