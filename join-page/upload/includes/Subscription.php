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
 */

/**
 * @ignore
 */
if (!defined('IN_APPLICATION')) {
    exit();
}

/**
 * Subscription class
 *
 * This class represents a subscription. Using this class it is
 * possible to perform useful tasks without directly executing
 * SQL queries on the subscriptions' table.
 *
 * @package JoinPage
 * @author  Alessandro Desantis <desa.alessandro@gmail.com>
 * @version $Id$
 * @link    http://www.shauku.org
 */
class Subscription
{
    /**
     * Contains the unique identificator's column's name.
     *
     * @var    string
     * @access private
     */
    private $_column = '';

    /**
     * Contains the unique identificator's column's value.
     *
     * @var    string|int
     * @access private
     */
    private $_key = '';

    /**
     * Contains the subscription's data.
     *
     * @var    array
     * @access private
     */
    private $_data = array();

    /**
     * Deletes all the expired subscriptions from the database.
     *
     * @access public
     */
    static public function clear()
    {
        global $config;

        $expiring = $config['app']['expiring'] * 60 * 60 * 24;

        $db = Database::getInstance();
        $db->query("DELETE FROM `subscriptions` WHERE (UNIX_TIMESTAMP() - `date_added`) > {$expiring} AND `active` = '0'");
    }

    /**
     * Adds a subscription to the database and returns the resulting
     * {@link Subscription} object.
     *
     * @param string E-mail.
     *
     * @return Subscription|bool The object or false on error.
     * @access public
     */
    static public function create($email)
    {
        global $config, $lang;

        $chars = 'a b c d e f g h i j k l m n o p q r s t u v w x y z ';
        $chars .= strtoupper($chars) . '1 2 3 4 5 6 7 8 9 0';
        $chars = explode(' ', $chars);

        $code = '';
        for ($i = 0; $i < 8; $i++) {
            shuffle($chars);
            $code .= $chars[0];
        }

        $body = sprintf($lang['email_text'], "{$config['site']['url']}/activate/{$code}/", $config['app']['expiring']);
        $body .= "{$lang['email_signature']}\n";
        $body .= $lang['team_name'];


        try {
            $transport = Swift_SmtpTransport::newInstance($config['email']['host'], $config['email']['port'])
            ->setUsername($config['email']['username'])
            ->setPassword($config['email']['password']);

            $mailer = Swift_Mailer::newInstance($transport);

            $message = Swift_Message::newInstance()
            ->setSubject($lang['email_subject'])
            ->setFrom(array($config['email']['from_email'] => $lang['team_name']))
            ->setTo(array($email))
            ->setBody($body);

            $mailer->send($message);
        }
        catch (Exception $e) {
            return false;
        }



        $db = Database::getInstance();
        $db->query("INSERT INTO `subscriptions` (code, email, date_added) VALUES (?, ?, UNIX_TIMESTAMP())", array(
            $code,
            $email,
        ));

        $subscription = new Subscription($code);
        return $subscription;
    }

    /**
     * Returns the number of active subscriptions.
     *
     * @return int
     * @access public
     */
    static public function getActive()
    {
        $db = Database::getInstance();
        $stm = $db->query("SELECT COUNT(*) FROM `subscriptions` WHERE `active` = '1'");

        return $stm->fetchColumn();
    }

    /**
     * Loads the subscription's data if a subscription matching
     * the specified criteria is found.
     *
     * @param string Subscription's email or code.
     *
     * @return Subscription
     * @access public
     * @throws Exception    If no subscription is found.
     */
    public function __construct($key)
    {
        if (filter_var($key, FILTER_VALIDATE_EMAIL)) {
            $column = 'email';
        }
        else {
            $column = 'code';
        }

        $db = Database::getInstance();
        $stm = $db->query("SELECT * FROM `subscriptions` WHERE `{$column}` = ?", array($key));

        if (!$stm->rowCount()) {
            throw new Exception("No subscription whose '{$column}' column matches '{$key}' was found.");
        }

        $this->_data = $stm->fetch();

        $this->_column = $column;
        $this->_key    = $key;
    }

    /**
     * Allows to access the columns as they were properties of the
     * instance.
     *
     * @param string Column's name.
     *
     * @return mixed
     * @access public
     */
    public function __get($column)
    {
        if (!$this->__isset($column)) {
            return null;
        }

        return $this->_data[$column];
    }

    /**
     * Tries to set a column's value, which results in Fatal error.
     *
     * @param string Column's name.
     * @param string Column's new value.
     *
     * @access public
     */
    public function __set($column, $new_value)
    {
        if ($this->__isset($column)) {
            trigger_error(E_USER_ERROR, "Trying to edit 'DBStatement::{$column}'. Cannot edit a database table's column's value!");
        }
    }

    /**
     * Allows to check if the colums were set as they were
     * properties of the instance.
     *
     * @param string Column's name.
     *
     * @return boolean
     * @access public
     */
    public function __isset($column)
    {
        return isset($this->_data[$column]);
    }

    /**
     * Tries to unset a column, which results in Fatal error.
     *
     * @param string Column's value.
     *
     * @access public
     */
    public function __unset($column)
    {
        if ($this->__isset($column)) {
            trigger_error(E_USER_ERROR, "Trying to unset 'DBStatement::{$column}'. Cannot unset a database table's column!");
        }
    }

    /**
     * Activates the subscription.
     *
     * @return boolean Operation's result.
     * @access public
     */
    public function activate()
    {
        if ($this->__get('active') == '1') {
            return false;
        }

        $db = Database::getInstance();
        $db->query("UPDATE `subscriptions` SET `active` = '1' WHERE `{$this->_column}` = ?", array($this->_key));

        return true;
    }
}
?>
