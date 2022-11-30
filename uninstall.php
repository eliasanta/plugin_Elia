<?php

/**
 * @package Elia plugin
 * @version 0.0.1
 */
if (!defined('WP_UNINSTALL_PLUGIN')) { //security check
    die;
}
//cleared database store datas
/* $books = get_posts(array('post_type' => 'book', 'numberposts' = -1));

foreach ($books as $book) {
    wp_delete_post($book->ID, true); //passo l'id e gli dico di cancellarlo anche se è gia nel cestino, con false non viene cancellato se è gia nel cestino
}
 */
//access the database via SQL
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type='book'");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN(SELECT id FROM wp_posts)"); //wp_postmeta è connesso con wp_posts
$wpdb->query("DELETE FROM wp_term_relationship WHERE object_id NOT IN(SELECT id FROM wp_posts)");
