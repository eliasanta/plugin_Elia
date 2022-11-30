<?php

/**
 * @package Elia plugin
 * @version 0.0.1
 */
class EliaPluginDeactivate
{
    public static function deactivate()
    {
        flush_rewrite_rules(); //wp fa un refresh e un check per vedere cosa è cambiato nel db
    }
}
