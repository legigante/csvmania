/**
 * bordel de fonctions utiles
 * @type {{mpAjax: module.exports.mpAjax}}
 */

module.exports = {

    mpAjax: function (url, method, json, cb) {
        $.ajax({
            url: url,
            data: json,
            dataType: 'json',
            method: method,
            success: function (res) {
                cb(0, res);
            },
            error: function (res) {
                console.log('error ' + res.status + ' ' + res.statusText);
                console.log(res.responseText);
                cb(1, res.responseText);
            }
        });
    }
}
