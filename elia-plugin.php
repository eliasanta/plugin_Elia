
<?php

/**
 * @package Elia plugin
 * @version 0.0.1
 */
/*
Plugin Name: Elia Plugin
Description: This is a plugin built followed the youtube tutorial
Author: Elia Santagiuliana
Author URI:https://eliasantagiuliana.netlify.app/
Version: 0.0.1
License:GPLv2 or later
Text-Domain:Elia-plugin

*/
/* This program is free software: you can redistribute it and/or modify it under the terms of 
the GNU General Public License as published by the Free Software Foundation, either version 3
of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. 
See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program. 
If not, see <https://www.gnu.org/licenses/>.*/

if (!defined('ABSPATH')) {
    die;
}
class EliaPlugin
{

    function __construct()
    { //object oriented programming way
        $this->create_post_type(); //imposto create_post_type protected in modo che non possano accedere esternamente
    }
    public function register()
    {
        //admin_enqueue_scripts per il backend
        //wp_enqueue_scripts per il frontend
        add_action('admin_enqueue_scripts', array($this, 'enqueue'));
        add_action('admin_menu', array($this, 'add_admin_pages'));
    }
    public function add_admin_pages()
    {
        add_menu_page('elia Plugin', 'elia', 'manage_options', 'elia_plugin', array($this, 'admin_index'), 'dashicons-store');
    }
    public function admin_index()
    {
        //require template
        require_once plugin_dir_path(__FILE__) . './templates/admin.php';
    }
    protected function create_post_type()
    {
        add_action('init', array($this, 'custom_post_type')); //
    }

    function uninstall()
    {
        //delete custom post type
        //delete all the plugin data from database
    }
    function custom_post_type()
    {

        register_post_type('book', ['public' => true, 'label' => 'Books']);
    }
    function enqueue()
    {
        //enqueue all our scripts and css style files

        wp_enqueue_style('mypluginstyle', plugins_url('/assets/mystyle.css', __FILE__));
        wp_enqueue_script('mypluginscript', plugins_url('/assets/myscript.js', __FILE__));
    }
    function activate()
    {
        require_once plugin_dir_path(__FILE__) . './Inc/elia-plugin-activate.php';
        EliaPluginActivate::activate(); //il metodo creato è statico
    }
}

//instanzio la classe solo se esiste
if (class_exists('EliaPlugin')) {
    $eliaPlugin = new EliaPlugin('inizializzato'); //instazio la classe
    $eliaPlugin->register(); //richiamo la funzione che a sua volta richiama la funzione per mettere in coda gli script
}
//activation******************************************************************
//__FILE__ significa che mi eve cercare la funzione all'interno di questo file
//un modo per chiamarla
register_activation_hook(__FILE__, array($eliaPlugin, 'activate'));

//deactivation****************************************************************
//altro modo per chiamarla
require_once plugin_dir_path(__FILE__) . './Inc/elia-plugin-deactivate.php';
register_deactivation_hook(__FILE__, array('EliaPluginDeactivate', 'deactivate'));
//uninstall
register_uninstall_hook(__FILE__, array($eliaPlugin, 'uninstall'));

?>
