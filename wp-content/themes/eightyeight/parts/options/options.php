<?php

// Array of All Options
$mto = get_option( 'mto_option_name' );

$footer_menu_title_pl = $mto['mto_footer_menu_title_pl'] ?? null;

$contact_data_title_pl = $mto['mto_contact_data_title_pl'] ?? null;
$address = $mto['mto_address'] ?? null;
$phone = $mto['mto_phone'] ?? null;
$email = $mto['mto_email'] ?? null;

// A few regulars with translations

$error_title_pl = "Oops! Strony nie znaleziono! :(";
$error_text_pl = "Wróć do";

$no_posts_pl = "Brak wpisów";
$no_posts_en = "No posts";

$search_title_pl = "Wyniki wyszukiwania: ";
$search_title_en = "Search results: ";