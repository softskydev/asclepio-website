$(document).ready(function () {
    load_chart();
});

function load_chart() {
    $.ajax({
        type: "get",
        url: global_url + "Admin/get_chart",
        dataType: "json",
        success: function (response) {
            var jsonfile = response;
            // var jsonfile = {
            //     "items": [{
            //         "label": "jan",
            //         "asclepedia": 12,
            //         "asclepiogo": 12
            //     }, {
            //         "label": "feb",
            //         "asclepedia": 14,
            //         "asclepiogo": 14
            //     }]
            // };

            var labels = jsonfile.items.map(function (e) {
                return e.label;
            });
            var data_pedia = jsonfile.items.map(function (e) {
                return e.asclepedia;
            });
            var data_piogo = jsonfile.items.map(function (e) {
                return e.asclepiogo;
            });

            var ctx = document.getElementById('myChart').getContext('2d');
            var config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Asclepedia',
                        data: data_pedia,
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)'
                    }, {
                        label: 'Asclepio Go',
                        data: data_piogo,
                        backgroundColor: 'rgb(255, 159, 64)',
                        borderColor: 'rgb(255, 159, 64)'
                    }]
                }
            };

            var chart = new Chart(ctx, config);
        }
    });

}