<?php
function start_created($average)
{

    if ($average == 0 || $average < 0.5) {
        $x = '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
    } else if ($average >= 0.5 && $average < 1) {
        $x = '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-half.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
    } else if ($average >= 1 && $average < 1.5) {
        $x = '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
    } else if ($average >= 1.5 && $average < 2) {
        $x = '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-half.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
    } else if ($average >= 2 && $average < 2.5) {
        $x = '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
    } else if ($average >= 2.5 && $average < 3) {
        $x = '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-half.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
    } else if ($average >= 3 && $average < 3.5) {
        $x = '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
    } else if ($average >= 3.5 && $average < 4) {
        $x = '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-half.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
    } else if ($average >= 4 && $average < 4.5) {
        $x = '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-grey.svg">';
    } else if ($average >= 4.5 && $average < 5) {
        $x = '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star-half.svg">';
    } else {
        $x = '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
        $x .= '<img class="rt" src="' . base_url() . 'assets/front/images/ic-star.svg">';
    }

    return $x;
}
