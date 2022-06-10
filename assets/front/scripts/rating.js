$('.star').on('mouseover', function () {
    var value = $(this).data('value');
    $('#rating').val(value);
    $('.star').attr('src', global_url + 'assets/front/images/ic-star-grey.svg');
    switch (value) {
        case 1:
            $('.star1').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('#kepuasan').text('Tidak Puas!');
            break;
        case 2:
            $('.star1').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('.star2').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('#kepuasan').text('Kurang Puas!');
            break;
        case 3:
            $('.star1').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('.star2').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('.star3').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('#kepuasan').text('Lumayan lah');
            break;
        case 4:
            $('.star1').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('.star2').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('.star3').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('.star4').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('#kepuasan').text('Puas!');
            break;
        case 5:
            $('.star1').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('.star2').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('.star3').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('.star4').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('.star5').attr('src', global_url + 'assets/front/images/ic-star.svg');
            $('#kepuasan').text('Sangat Puas!');
            break;
    }
});