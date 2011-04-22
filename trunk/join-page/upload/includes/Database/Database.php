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
 * @link    http://www.php.net/manual/en/book.pdo.php
 */

/**
 * @ignore
 */
if (!defined('IN_APPLICATION')) {
    exit();
}

/**
 * Loads the statement class.
 */
require_once dirname(__FILE__) . '/DBStatement.php';

/**
 * Database access library
 *
 * This library allows us to easily access to the database and
 * handle all the errors that could occur without having to try
 * and catch exceptions. This is very useful in bigger scripts.
 *
 * @package JoinPage
 * @author  Alessandro Desantis <desa.alessandro@gmail.com>
 * @version $Id$
 * @link    http://www.shauku.org
 * @link    http://www.php.net/manual/en/class.pdo.php
 */
class Database extends PDO
{
    /**
     * Database connection error.
     */
    const ERR_CONNECTION = 1;

    /**
     * Database statement error.
     */
    const ERR_STATEMENT = 2;

    /**
     * Contains the instance of the class.
     *
     * @var    Database
     * @access private
     */
    static private $_instance = null;

    /**
     * The singleton is a famous design pattern used to make sure
     * that you have only one instance of a class. It is also used
     * to avoid having global variables.
     *
     * @return Database
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
     * This method is used to show the most common database errors.
     * It will stop the execution and show the appropriate error
     * page. Please, note that additional debug information will
     * be only shown if debug mode was activated in {@link config.php}.
     *
     * @param int   Error's type (see class' ERR_* constants).
     * @param array Error's info ('message' item is mandatory, and
     *              for ERR_STATEMENT 'sql_code' and 'values' are, too).
     *
     * @access public
     */
    static public function showError($type, $info)
    {
        global $config;

        $tpl = Template::getInstance();

        if ($config['app']['debug_mode']) {
            $tpl->assign('message', $info['message']);

            if ($type == self::ERR_STATEMENT) {
                $tpl->assign('sql_code', $info['sql_code']);
                $tpl->assign('values', $info['values']);
            }
        }

        switch ($type) {
            case self::ERR_CONNECTION:
                $tpl_file = 'errors/db_connection.html';
                break;

            case self::ERR_STATEMENT:
                $tpl_file = 'errors/db_statement.html';
                break;
        }

        die($tpl->display($tpl_file));
    }

    /**
     * Creates a connection to the database and, in case of error,
     * shows an error message and stops the execution. It'll also
     * show debug information if debug mode is active.
     * You should use {@link Database::getInstance()} to get an
     * instance of the class instead of calling the constructor,
     * which has public visibility just for technical limitations.
     *
     * @return Database
     * @access public
     * @uses   Database::showError()
     */
    public function __construct()
    {
        global $config;

        try {
            parent::__construct($config['db']['dsn'], $config['db']['user'], $config['db']['pass']);
        }
        catch (PDOException $e) {
            self::showError(self::ERR_CONNECTION, array(
                'message' => $e->getMessage(),
            ));
        }

        $this->setAttribute(PDO::ATTR_STATEMENT_CLASS, array('DBStatement'));
    }

    /**
     * Executes an SQL query on the database. Actually this method
     * just creates a new {@link DBStatement} object and then executes
     * it, so it is possible to specify placeholders and use them as
     * you would do with a prepared statement.
     * This is useful if you want to use a prepared statement just
     * one time.
     *
     * @param string SQL code.
     * @param array  Placeholders' values.
     *
     * @return DBStatement
     * @access public
     * @uses   DBStatement
     */
    public function query($sql, $values = array())
    {
        $stm = $this->prepare($sql);
        $stm->execute($values);

        return $stm;
    }
}
?>
