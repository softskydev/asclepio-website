// var page = 0;
var limit = 4;
var limit_testi = 8;
var sort = 'terbaru';
var search_input = $("#search").val();
// $(document).ready(function () {
//     get_data(page, limit);

// });

function setLimit(item) {
    limit = item;
    loadPagination(global_url + 'Testimoni/get_rating/0');
}

function sortBy(item) {
    sort = item;
    loadPagination(global_url + 'Testimoni/get_rating/0');
}

function search(item) {
    search_input = item;
    loadPagination(global_url + 'Testimoni/get_rating/0');
}


$(document).on("click", ".pag-list .pagination li a", function (event) {
    event.preventDefault();
    var pageno = $(this).attr('href');
    loadPagination(pageno);
});

$(document).on("click", ".pag-list-testi .pagination li a", function (event) {
    event.preventDefault();
    var pageno_testi = $(this).attr('href');
    loadPaginationTesti(pageno_testi);
});


loadPagination(global_url + 'Testimoni/get_rating/0');
loadPaginationTesti(global_url + 'Testimoni/get_testi/0');

function loadPagination(pagno) {
    $.ajax({
        type: "post",
        url: pagno,
        data: {
            sort: sort,
            search: search_input,
            limit: limit,
        },
        dataType: "json",
        success: function (response) {
            $('.pag-list').html(response.pagination);
            createTable(response);
        }
    });
}
function loadPaginationTesti(pagno_testi) {
    $.ajax({
        type: "post",
        url: pagno_testi,
        data: {
            limit_testi: limit_testi,
        },
        dataType: "json",
        success: function (response) {
            $('.pag-list-testi').html(response.pagination);
            createCard(response);
        }
    });
}

function createTable(response) {
    var html = '';
    $.each(response.data, function (i, item) {
        html += "<tr>" +
            "<td><span>" + item.judul_kelas + "</span></td>" +
            "<td><span>" + item.rating + "</span></td>" +
            "<td><span>" + item.pengulas + "</span></td>" +
            "</tr>";
    });

    tableBody = $("#table_body");
    tableBody.html(html);
    // $("#last_query").val(response.last_query);
}
function createCard(response) {
    var html = '';
    $.each(response.data, function (i, item) {
        html += "<div class='col-md-3 mb-3'>"+
                    "<div class='box-card card-pemateri'>"+
                        "<div class='box-card__namepos'>"+
                            "<h3>"+item.judul_kelas+"</h3>"+
                            "<p>"+item.ulasan+"</p>"+
                            "<div class='writer-rating'>"+
                                "<div class='rating' style='display: inline-flex;'>"+item.rating+"</div>"+
                                "<div class='writer'>"+
                                    "<div class='name'>"+item.nama_lengkap+"</div>"+
                                    "<small class='position'>"+item.universitas+"</small>"+
                                "</div>"+
                            "</div>"+
                        "</div>"+
                        "<div class='action'>"+
                            "<div class='dot'><img src="+global_url+"assets/admin/images/ic-three-dots.svg /></div>"+
                            "<div class='action-sub'>"+
                                "<ul>"+
                                    "<li class='dlt'><a href="+global_url+"Testimoni/delete_testi/"+item.id+">Remove</a></li>"+
                                "</ul>"+
                            "</div>"+
                        "</div>"+
                    "</div>"+
                "</div>";
    });

    cardBody = $("#box-testi");
    cardBody.html(html);
    // $("#last_query").val(response.last_query);
}