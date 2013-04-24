<?php
/**
 *  DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *          Version 2, December 2004
 *
 * Copyright (C) 2012 JustAddicted.com
 *
 * Everyone is permitted to copy and distribute verbatim or modified
 * copies of this license document, and changing it is allowed as long
 * as the name is changed.
 *
 *            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
 *   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
 *
 *  0. You just DO WHAT THE FUCK YOU WANT TO.
 */
namespace JustAddicted\Loader {

    /**
     * A simple namespace-driven autoloader for PHP5.3+
     */
    class Loader {

        private static $_namespaces = array();

        /**
         * Registers the Autoloader
         *
         * @static
         * @return void
         */
        public static function registerLoader() {
            spl_autoload_register("\\JustAddicted\\Loader\\Loader::loadClass");
        }

        /**
         * Includes a class
         *
         * @static
         *
         * @param string $classname Classname to load
         *
         * @return void
         */
        public static function loadClass($classname) {
            $path = explode("\\", $classname);

            if (array_key_exists($path[0], self::$_namespaces)) {
                $parentdir = self::$_namespaces[$path[0]];
                $path[0] = "";
                $newpath = $parentdir . implode("/", $path) . ".php";
                if (file_exists($newpath)) include_once ("$newpath");
            }
        }

        /**
         * Registers a namespace with a specific path
         *
         * @static
         *
         * @param string $namespace PHP-Namespace to register
         * @param string $path      filesystem path, where the namespace has its root
         *
         * @return void
         */
        public static function registerNamespace($namespace, $path) {
            self::$_namespaces[$namespace] = $path;
        }

    }
}