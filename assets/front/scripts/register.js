$(document).ready(function () {
    getUniv();
    getProvinsi();
});

function getProvinsi() {
    $.ajax({
        type: "get",
        url: "https://ibnux.github.io/data-indonesia/propinsi.json",
        dataType: "json",
        success: function (response) {
            var len = response.length;
            var select = $("select[id='select_provinsi']");
            for (var i = 0; i < len; i++) {
                var id = response[i]['id'];
                var selected = '';
                var nama = response[i]['nama'];

                if (select.attr('value') == id) {
                    var selected = 'selected';
                }
                $(select).append("<option value='" + id + "' " + selected + ">" + nama + "</option>");

            }
            $(select).selectpicker('refresh');
        }
    });
}
$("select[id='select_provinsi']").on('change', function () {
    getKota();
    $("#provinsi_name").val($("select[id='select_provinsi'] option:selected").text());

});

function getKota() {
    var id = $("select[id='select_provinsi']").val();
    $.ajax({
        type: "get",
        url: "https://ibnux.github.io/data-indonesia/kabupaten/" + id + ".json",
        dataType: "json",
        success: function (response) {
            var len = response.length;
            var select = $("select[id='select_kota']");
            $(select).empty();
            for (var i = 0; i < len; i++) {
                var id = response[i]['id'];
                var selected = '';
                var nama = response[i]['nama'];

                if (select.attr('value') == id) {
                    var selected = 'selected';
                }
                $(select).append("<option value='" + nama + "' " + selected + ">" + nama + "</option>");

            }
            $(select).selectpicker('refresh');
        }
    });
}

function getUniv() {
    $.ajax({
        type: "get",
        url: global_url + "Front/univ",
        dataType: "json",
        success: function (response) {
            var len = response.data.length;
            var select = $("select[id='select_univ']");
            for (var i = 0; i < len; i++) {
                // var id = response.data[i]['id'];
                var selected = '';
                var nama_univ = response.data[i]['nama_univ'];

                if (select.attr('value') == nama_univ) {
                    var selected = 'selected';
                }
                $(select).append("<option value='" + nama_univ + "' " + selected + ">" + nama_univ + "</option>");

            }
            $(select).selectpicker('refresh');
        }
    });
}