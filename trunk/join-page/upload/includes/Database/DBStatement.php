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
 * Statement class
 *
 * This library allows us to easily peform prepared statements
 * and simple SQL queries on the database without having to look
 * for errors every time.
 *
 * @package JoinPage
 * @author  Alessandro Desantis <desa.alessandro@gmail.com>
 * @version $Id$
 * @link    http://www.shauku.org
 * @link    http://www.php.net/manual/en/class.pdostatement.php
 */
class DBStatement extends PDOStatement
{
    /**
     * Executes the statement on the database, replacing the
     * placeholders with their respective values. Shows an
     * error and stops the execution if something goes wrong.
     *
     * @param array Placeholders' values.
     *
     * @access public
     */
    public function execute($values = array())
    {
        if (!parent::execute($values)) {
            $err_info = $this->errorInfo();

            Database::showError(Database::ERR_STATEMENT, array(
                'message' => $err_info[2],
                'sql_code' => $this->queryString,
                'values' => $values,
            ));
        }
    }

    /**
     * Returns an associative array containing the data of the
     * next row in the resultset.
     *
     * @return array
     * @access public
     */
    public function fetch()
    {
        return parent::fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Returns an array of associative arrays containing the data
     * of each row in the resultset.
     *
     * @return array
     * @access public
     */
    public function fetchAll()
    {
        return parent::fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
