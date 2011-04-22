<?php
/**
 * Shauku - An open source social networking platform.
 * Copyright (C) 2011 The Shauku Team
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 *
 * @package JoinPage
 * @author  Alessandro Desantis <desa.alessandro@gmail.com>
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License
 * @version $Id$
 * @link    http://www.shauku.org
 * @link    http://www.smarty.net
 */

/**
 * @ignore
 */
if (!defined('IN_APPLICATION')) {
    exit();
}

/**
 * Loads Smarty.
 */
require_once dirname(__FILE__) . '/Smarty/Smarty.class.php';

/**
 * Template engine
 *
 * This class is an extension of Smarty, the most famous template engine
 * for PHP. A template engine is a library which allows you to separate
 * the program's logic from its output.
 *
 * @package JoinPage
 * @author  Alessandro Desantis <desa.alessandro@gmail.com>
 * @version $Id$
 * @link    http://www.shauku.org
 * @link    http://www.smarty.net/docs/en/
 */
class Template extends Smarty
{
    /**
     * Contains the instance of the class.
     *
     * @var    Template
     * @access private
     */
    static private $_instance = null;

    /**
     * The singleton is a famous design pattern used to make sure
     * that you have only one instance of a class. It is also used
     * to avoid having global variables.
     *
     * @return Template
     * @access public
     */
    static public function getInstance()
    {
        if (self::$_instance == null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Instantiates the class and sets the correct directories path.
     * You shouldn't call this method directly: it's public just
     * because of technical limitations.
     *
     * @return Template
     * @access public
     */
    public function __construct()
    {
        global $config, $lang;

        $this->template_dir = dirname(dirname(__FILE__)) . "/templates/{$config['app']['template']}/html";
        $this->compile_dir  = dirname(dirname(__FILE__)) . "/templates/{$config['app']['template']}/compiled";

        $tpl_config = array(
            'site' => $config['site'],
            'app'  => $config['app'],
        );

        $this->assign('config', $tpl_config);
        $this->assign('lang', $lang);
    }

    /**
     * Clears the code using HTML Tidy before sending its output.
     *
     * @param string      Template to display.
     * @param mixed       Cache ID.
     * @param mixed       Compile ID.
     * @param object|null Variable's higher level.
     * @param boolean     Display the template?
     *
     * @return string Template's output (only if the last parameter is false).
     * @access public
     */
    public function fetch($tpl, $cache_id = null, $compile_id = null, $parent = null, $display = false)
    {
        ob_start();

        parent::fetch($tpl, $cache_id, $compile_id, $parent, true);

        $contents = ob_get_contents();
        ob_end_clean();

        $config = array(
            'indent'          => true,
            'output-xhtml'    => true,
            'clean'           => true,
            'wrap'            => 200,
            'hide-comments'   => true,
            'indent-cdata'    => true,
            'indent-spaces'   => 4,
            'break-before-br' => true,
            'markup'          => true,
            'sort-attributes' => 'alpha',
            'vertical-space'  => true,
            'hide-comments'   => true,
        );

        $tidy = new tidy();
        $tidy->parseString($contents, $config, 'utf8');
        $tidy->cleanRepair();

        if ($display) {
            echo $tidy;
        }
        else {
            return $tidy;
        }
    }

    /**
     * Shows an error message and stops the execution.
     *
     * @param string Error message.
     *
     * @access public
     */
    public function showError($message)
    {
        global $lang;

        $this->assign('page_title', $lang['error_title']);
        $this->assign('error_text', $message);

        $this->display('errors/generic_body.html');
        exit();
    }
}
?>
