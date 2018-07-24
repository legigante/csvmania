/**
 * mettre id talbeau puis callbakc pour mettre à jour les bars de prog
 * @type {{mpTableAjax: module.exports.mpTableAjax}}
 */
module.exports = {

    MP_tableAjax: function (tableDOM, cb) {

        tableDOM.find('input:text').change(function () {
            var el = $(this);
            var val = el.val();
            var json = {value: val};

            // get all table, tr,td and input data attributes
            $.each(el.closest('table').data(), function (key, val) {
                json[key] = val;
            });
            $.each(el.closest('tr').data(), function (key, val) {
                json[key] = val;
            });
            $.each(el.closest('td').data(), function (key, val) {
                json[key] = val;
            });
            $.each(el.data(), function (key, val) {
                json[key] = val;
            });

            mpAjax(json.url, 'POST', json, function (err, res) {
                var colorBef = el.css('background-color');
                if (!err) {
                    var color = res.error == '' ? 'green' : 'red';
                    if (res.error != '') {
                        alert(res.error);
                    }

                } else {
                    var color = 'red';
                }

                el.css('background-color', color);
                setTimeout(function () {
                    el.css('background-color', colorBef)
                }, 750);

                // callback success
                cb(res);

            });
        });


    }

}