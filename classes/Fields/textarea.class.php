<?php
/**
 * Class to handle textarea profile items.
 *
 * @author      Lee Garner <lee@leegarner.com>
 * @copyright   Copyright (c) 2018 Lee Garner <lee@leegarner.com>
 * @package     profile
 * @version     1.2.0
 * @since       1.2.0
 * @license     http://opensource.org/licenses/gpl-2.0.php
 *              GNU Public License v2 or later
 * @filesource
 */
namespace Profile\Fields;

/**
 * Class for textarea input fields
 *
 * @package profile
 */
class textarea extends \Profile\Field
{
    /**
     * Get the form field for rendering.
     *
     * @return  string  HTML for form field.
     */
    public function FormField()
    {
        global $LANG_PROFILE, $_CONF;

        $this->_FormFieldInit();

        // Textareas get width attributes from the layout CSS, so counteract
        // by setting the width
        $fld = '<textarea style="width:90%;" ' .
                "{$this->_frmClass} name=\"{$this->name}\" " .
                'rows="' . $this->getOption('rows', '5') . '" ' .
                'cols="' . $this->getOption('cols', '40') . '" ' .
                "id=\"{$this->name}\" {$this->_frmReadonly}>" .
                $this->value . "</textarea>\n";
        return $fld;
    }


    /**
     * Return the value formatted for display.
     *
     * @param   string  $value  Optional value, current value if empty
     * @return         Formatted value for display.
     */
    public function FormatValue($value = '')
    {
        if (empty($value))
            $value = $this->value;

        return nl2br(htmlspecialchars($value));
    }


    /**
     * Sanitize multi-line input.
     * Don't call COM_checkHTML() since that will remove newlines.
     * Our FormatValue() function escapes all HTML anyway.
     *
     * @param   string  $val    Original value
     * @return  string          Sanitized version.
     */
    public function Sanitize($val)
    {
        return COM_checkWords($val);
    }


    /**
     * Get the values for the field editing form.
     *
     * @return  array   Array of key->value pairs
     */
    public function editValues()
    {
        return array(
            'default'   => $this->getOption('default'),
            'rows'      => $this->getOption('rows'),
            'cols'      => $this->getOption('cols'),
            'help_txt'  => $this->getOption('help_text'),
        );
    }


    /**
     * Prepare to save a value to the DB.
     * This type returns the submitted value without modification.
     *
     * @param   array   $vals   Array of all submitted values
     * @return  string          Value to save
     */
    public function prepareToSave($vals)
    {
        return $vals[$this->name];
    }


    /**
     * Actually gets the options array specific to this field.
     *
     * @param   array   $A      Form values
     * @return  array           Array of options to save
     */
    public function setOptions($A)
    {
        // Set the size and maxlength to reasonable values
        $this->options['rows'] = isset($A['rows']) ? (int)$A['rows'] : 5;
        $this->options['cols'] = isset($A['cols']) ? (int)$A['cols'] : 80;
        return $this->options;
    }

}

?>
