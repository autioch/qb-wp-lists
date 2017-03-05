<?php
/* 1.2.0 */

/**
 * Single class for creating, generating and evaluating HTML forms.
 * Larger than usual, performs many roles and in does not always follow 
 * the PHP scripting rules, but does not require any other files.   
 */
class qbWebForm {

    /**
     * @var string Id of the form, defaults to "qbf" 
     */
    private $id;

    /**
     * @var string Address to which form will be submitted 
     */
    private $action;

    /**
     * @var string Source of the data to validate, defined as 'get' or 'post'
     */
    private $method;

    /**
     * @var array List of the standard fields
     */
    public $fields = array();

    /**
     * @var array List of the hidden fields
     */
    public $hidden = array();

    /**
     * @var array List of the submit fields
     */
    public $submit = array();

    /**
     * @var boolean Is the form sent and all the inserted values are valid
     */
    public $valid = false;

    /**
     * @var boolean Is the form sent
     */
    public $sent;

    /**
     * @var array $_POST or $_GET, based on method
     */
    private $source;

    /**
     * @var array Default array of errors, can be overwritten at any time.
     */
    public $errors = array(
        'antybot' => 'Proszę wypełnić pole.',
        'checkbox' => 'Proszę zatwierdzić.',
        'email' => 'Proszę sprawdzić adres e-mail.',
        'file' => 'Proszę wybrać plik.',
        'hidden' => '',
        'label' => '',
        'number' => 'Proszę wprowadzić wartość liczbową',
        'password' => 'Proszę wprowadzić hasło.',
        'radio' => 'Proszę wybrać opcję.',
        'select' => 'Proszę wybrać opcję.',
        'submit' => '',
        'date' => 'Proszę wybrać datę',
        'text' => 'Proszę wypełnić pole.',
        'textarea' => 'Proszę wprowadzić dłuższą wypowiedź.'
    );

    /**
     * Constructor of the form.
     * @param string $id Id of the form
     * @param string $action Address to which form will be submitted 
     * @param string $method Source of the data to validate, defined as 'get' or 'post'
     * @param string $class Class of the main container
     */
    function __construct($id = 'qbf', $action = '', $method = 'get', $class = 'qbf') {
        $this->id = $id;
        $this->action = $action;
        $this->method = $method;
        $this->class = $class;
        $this->source = ($method == 'get') ? $_GET : $_POST;
        $this->filter = ($method == 'get') ? INPUT_GET : INPUT_POST;
        $this->sent = isset($this->source[$id]);
    }

    /**
     * General method for adding a field to the form.
     * @param string $id Identificator of the field
     * @param string $type Type of the field
     * @param string $label Displayed label of the field
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     * @param mixed $value Depending on the field type, this is the default value of the field
     */
    private function add($id, $type, $label, $error, $required, $value) {
        $e = (strlen(trim($error)) > 0 ) ? trim($error) : $this->errors[$type];
        $this->fields[$id] = array(
            'id' => trim($id),
            'type' => trim($type),
            'label' => trim($label),
            'error' => $e,
            'required' => $required,
            'value' => trim($value),
            'valid' => true
        );
    }

    /**
     * Creates a text input that expects a certain value, usually hinted in the label.
     * Value should be hard enough to prevent bots from guessing it, but easy enough for
     * people to quickly guess it, so they won't resign from submitting the form.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param string $expected Expected value of the field to pass validation
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     * @param string $value Default value of the field
     */
    public function add_antybot($id, $label, $expected, $error = '', $required = true, $value = '') {
        $this->add($id, 'antybot', $label, $error, $required, $value);
        $this->fields[$id]['expected'] = $expected;
    }

    /**
     * Creates a simple checkbox.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     * @param string $value Default value of the field
     */
    public function add_checkbox($id, $label, $error = '', $required = true, $value = '') {
        $this->add($id, 'checkbox', $label, $error, $required, $value);
    }

    /**
     * Creates a text input that expects a valid email address. If the compare param is set,
     * value of this field must be the same as value of the field identified by compare param.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param string $compare Identificator of the field to compare values.
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     * @param string $value Default value of the field
     */
    public function add_email($id, $label, $compare = '', $error = '', $required = true, $value = '') {
        $this->add($id, 'email', $label, $error, $required, $value);
        if (strlen($compare) > 0) {
            $this->fields[$id]['compare'] = $compare;
        }
    }

    /**
     * Creates a file input. Currently not validaded, must be handled by the user.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     */
    public function add_file($id, $label, $error = '', $required = true) {
        $this->add($id, 'file', $label, $error, $required, '');
    }

    /**
     * Creates a hidden input. It's not validated by default, but it's still possible manually.
     * @param string $id Identificator of the field
     * @param string $name Name of the field
     * @param string $value Default value of the field
     */
    public function add_hidden($id, $name, $value, $required = true) {
        $this->hidden[$id] = array(
            'id' => $id,
            'type' => 'hidden',
            'name' => $name,
            'value' => $value,
            'expected' => $value,
            'required' => $required
        );
    }

    /**
     * Creates a label. This field serves as a title for groups of fields.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     */
    public function add_label($id, $label) {
        $this->add($id, 'label', $label, '', false, '');
    }

    /**
     * Creates a text input. Expects a numeric value.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     * @param string $value Default value of the field
     */
    public function add_number($id, $label, $error = '', $required = true, $value = '') {
        $this->add($id, 'number', $label, $error, $required, $value);
    }

    /**
     * Creates a text password. Value is hidden by the browser and can be accessed by javascript.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     */
    public function add_password($id, $label, $error = '', $required = true) {
        $this->add($id, 'password', $label, $error, $required, '');
    }

    /**
     * Creates a list of radio inputs. Expects value greater than -1.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param array  $options List of key => value pairs.
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     * @param string $value Default value of the field
     */
    public function add_radio($id, $label, array $options, $error = '', $required = true, $value = '') {
        $this->add($id, 'radio', $label, $error, $required, $value);
        $this->fields[$id]['options'] = $options;
    }

    /**
     * Creates a select. Expects value greater than -1.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param array  $options List of key => value pairs.
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     * @param string $value Default value of the field
     */
    public function add_select($id, $label, array $options, $error = '', $required = true, $value = '') {
        $this->add($id, 'select', $label, $error, $required, $value);
        $this->fields[$id]['options'] = $options;
    }

    /**
     * Creates a submit input. Not validated.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param string $value Default value of the field
     */
    public function add_submit($id, $label) {
        $this->submit[$id] = array(
            'id' => trim($id),
            'type' => 'submit',
            'label' => '',
            'error' => '',
            'required' => false,
            'value' => $label,
            'valid' => true
        );
    }

    /**
     * Creates a text input. Expects minimum 2 characters as a valid value.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     * @param string $value Default value of the field
     */
    public function add_text($id, $label, $error = '', $required = true, $value = '') {
        $this->add($id, 'text', $label, $error, $required, $value);
    }

    /**
     * Creates a textarea. Expects minimum 10 characters as a valid value.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     * @param string $value Default value of the field
     */
    public function add_textarea($id, $label, $error = '', $required = true, $value = '') {
        $this->add($id, 'textarea', $label, $error, $required, $value);
    }

    /**
     * Creates a text input. Expects date in format yy-mm-dd.
     * @param string $id Identificator of the field
     * @param string $label Displayed label of the field
     * @param string $error Error displayed if value is invalid
     * @param string $required Is the field required for submition
     * @param string $value Default value of the field
     */
    public function add_date($id, $label, $error = '', $required = true, $value = '') {
        $this->add($id, 'date', $label, $error, $required, $value);
    }

    /* GETTERS, SETTERS */

    /**
     * Retrieves the value of the selected field.
     * @param mixed $id Identificator or the array of the field.
     * @return string Value of the named field.
     */
    public function get($id) {
        $f = $this->getField($id);
        if ($f['type'] == 'checkbox') {
            if (is_numeric($f['value']) && ($f['value'] > 0)) {
                return 1;
            } else {
                return 0;
            }
        }
        return $f['value'];
    }

    /**
     * Retrieves an array of the selected field.
     * @param mixed $id Identificator or the array of the field. If it's an array, just returns it.
     * @return array Array of the selected field.
     * @throws Exception If there's no standard or hidden field with selected identificator, throw exception.
     */
    public function getField($id) {
        if (is_array($id)) {
            return $id;
        }
        if (array_key_exists($id, $this->fields)) {
            return $this->fields[$id];
        }
        if (array_key_exists($id, $this->hidden)) {
            return $this->hidden[$id];
        }
        if (array_key_exists($id, $this->submit)) {
            return $this->submit[$id];
        }
        throw new Exception('No such field in the form');
    }

    /**
     * Retrieves an array of values for every standard and hidden field. 
     * @return array Pairs of identificators and values for each field.
     */
    public function getAll() {
        $values = array();
        foreach ($this->fields as $key => $value) {
            if ($value['type'] != 'submit') {
                $values[$key] = stripslashes($this->get($key));
            }
        }
        foreach ($this->hidden as $key => $value) {
            $values[$key] = $this->hidden[$key]['value'];
        }
        return $values;
    }

    public function stripSlashes() {
        foreach ($this->fields as $key => $value) {
            $this->set($key, stripslashes($this->get($key)));
        }
        foreach ($this->hidden as $key => $value) {
            $this->set($key, stripslashes($this->get($key)));
        }
    }

    /**
     * Retrieves an array of values for every standard and hidden field. 
     * @return array Pairs of identificators and values for each field.
     */
    public function getAllDb() {
        $values = array();
        foreach ($this->fields as $key => $value) {
            if ($value['type'] != 'submit') {
                $values[$key] = stripslashes($this->get($key));
                if (strlen($values[$key]) == 0) {
                    $values[$key] = 'NULL';
                }
            }
        }
        foreach ($this->hidden as $key => $value) {
            $values[$key] = $this->hidden[$key]['value'];
            if (strlen($values[$key]) == 0) {
                $values[$key] = 'NULL';
            }
        }
        return $values;
    }

    /**
     * Sets a value for selected field
     * @param string $id Identificator for the selected field.
     * @param mixed $value Value to set for the selected field.
     */
    public function set($id, $value) {
        $this->fields[$id]['value'] = $value;
    }

    /* RENDER */

    /**
     * Renders the complete form.
     * @param string $style Dom structure to use for the form. Uses 'table' or 'div'.
     */
    public function render($style = 'table') {
        echo $this->renderFormBegin();
        foreach ($this->hidden as $id => $field) {
            echo $this->renderField($field);
        }
        if ($style == 'div') {
            $this->renderForm_div();
        } else {
            $this->renderForm_table();
        }
        echo $this->renderFormEnd();
    }

    private function renderForm_table() {
        ?>
        <table class="qbf-container" id="<?php echo $this->id ?>-container">
            <tbody>
                <?php foreach ($this->fields as $id => $field): ?>
                    <tr class="qbf-field qbf-field-<?php echo $field['type'], $field['valid'] ? '' : ' invalid' ?>">
                        <?php if ($field['type'] == 'label'): ?>
                            <td class="qbf-field-label" colspan="3"><?php echo $this->renderField($field) ?></td>
                        <?php else: ?>
                            <td class="qbf-field-label"><?php echo $this->renderLabel($field) ?></td>
                            <td class="qbf-field-field"><?php echo $this->renderField($field) ?></td>
                            <td class="qbf-field-error"><?php echo $this->renderError($field) ?></td>                        
                        <?php endif ?>
                    </tr>
                <?php endforeach ?>
                <tr class="qbf-field qbf-field-submit">
                    <td class="qbf-field-field" colspan="3">                    
                        <?php foreach ($this->submit as $id => $field): ?>
                            <?php echo $this->renderField($field) ?>
                        <?php endforeach ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php
    }

    private function renderForm_div() {
        ?>
        <div class="qbf-container" id="<?php echo $this->id ?>-container">
            <?php foreach ($this->fields as $id => $field): ?>
                <div class="qbf-field qbf-field-<?php echo $field['type'], $field['valid'] ? '' : ' invalid' ?>">
                    <?php if ($field['type'] == 'label'): ?>
                        <div class="qbf-field-label"><?php echo $this->renderField($field) . "\n"; ?></div>
                    <?php else: ?>
                        <div class="qbf-field-label"><?php echo $this->renderLabel($field) . "\n"; ?></div>
                        <div class="qbf-field-field"><?php echo $this->renderField($field) . "\n"; ?></div>
                        <div class="qbf-field-error"><?php echo $this->renderError($field) . "\n"; ?></div>                        
                    <?php endif ?>
                </div>
            <?php endforeach ?>
            <div class="qbf-field qbf-field-submit">
                <div class="qbf-field-field" colspan="3">                    
                    <?php foreach ($this->submit as $id => $field): ?>
                        <?php echo $this->renderField($field) ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Renders opening tag for the form.
     * @return string Returns form tag with required values.
     */
    public function renderFormBegin() {
        $form = '<form id="' . $this->id . '" method="' . $this->method . '"';
        if (strlen($this->class) > 0) {
            $form.=' class="' . $this->class . '"';
        }
        if (strlen($this->action) > 0) {
            $form.=' action="' . $this->action . '"';
        }
        return "\n$form>";
    }

    /**
     * Renders enclosing tag for the form.
     * @return string Returns just enclosing tag for the form.
     */
    public function renderFormEnd() {
        return "</form>\n";
    }

    /**
     * Renders label for the selected field
     * @param mixed $id Identificator or the array of the field
     * @return string For any field other than radio, returns label tag enclosed in span. For radio, returns just span.
     */
    public function renderLabel($id) {
        $f = $this->getField($id);
        $label = '<span>';
        if ($f['type'] != 'radio') {
            $label .='<label for="' . $this->attrId($f, false) . '">' . $f['label'] . '</label>';
        } else {
            $label .=$f['label'];
        }
        return "$label</span>";
    }

    /**
     * Renders error if any for the selected field
     * @param mixed $id Identificator or the array of the field
     * @return string Returns error value enclosed in span element.
     */
    public function renderError($id) {
        $f = $this->getField($id);
        return '<span>' . ($f['valid'] ? '' : $f['error']) . '</span>';
    }

    /**
     * Renders selected field 
     * @param mixed $id Identificator or the array of the field
     * @return string Returns generated DOM structure for the selected element.
     */
    public function renderField($id) {
        $f = $this->getField($id);
        switch ($f['type']) {
            case 'checkbox':
                return $this->renderCheckbox($f);
            case 'label':
                return '<p' . $this->attrClass($f) . $this->attrId($f) . '>' . $f['label'] . '</p>';
            case 'radio':
                return $this->renderRadio($f);
            case 'select':
                return $this->renderSelect($f);
            case 'textarea':
                return '<textarea' . $this->attrName($f) . $this->attrClass($f) . $this->attrId($f) . '>' . $f['value'] . '</textarea>';
            default: //text, date, antybot, email, number, submit, file, hidden, password
                return $this->renderText($f);
        }
    }

    private function renderText($field) {
        $noValue = array('file');
        $ownType = array('file', 'hidden', 'submit', 'password');
        $f = $this->getField($field);
        $result = '<input' . $this->attrName($f) . $this->attrClass($f) . $this->attrId($f);
        $result .= ' type="' . (in_array($f['type'], $ownType) ? $f['type'] : 'text') . '"';
        if (!in_array($f['type'], $noValue)) {
            $result .= ' value="' . $f['value'] . '"';
        }
        return $result . '>';
    }

    private function renderCheckbox($field) {
        $f = $this->getField($field);
        $checked = $f['value'] ? ' checked="checked"' : '';
        $def = '<input value="0"' . $this->attrName($f) . ' id="' . $this->attrId($f, false) . '_"' . ' type="hidden">';
        $vis = '<input value="1"' . $this->attrName($f) . $this->attrId($f) . $this->attrClass($f) . ' type="checkbox" ' . $checked . '>';
        return $def . "\n" . $vis;
    }

    private function renderRadio($field) {
        $f = $this->getField($field);
        $result = '<ul>';
        foreach ($f['options'] as $key => $val) {
            $id = $this->attrId($f, false) . '-' . $key;
            $result .= "\n<li><input" . (strcmp($f['value'], $key) == 0 ? ' checked="checked"' : '') . ' id="' . $id . '"' . $this->attrName($f) . ' value="' . $key . '" type="radio">';
            $result .= '<label for="' . $id . '">' . $val . '</label></li>';
        }
        $result .= '</ul>';
        return $result;
    }

    private function renderSelect($field) {
        $f = $this->getField($field);
        $result = '<select' . $this->attrName($f) . $this->attrClass($f) . $this->attrId($f) . '>';
        $result .= '<option value="-1"> </option>';
        foreach ($f['options'] as $key => $val) {
            $result .= "\n<option" . (strcmp($f['value'], $key) == 0 ? ' selected="selected"' : '') . ' value="' . $key . '">' . $val . '</option>';
        }
        $result .= '</select>';
        return $result;
    }

    /**
     * Creates an identificator attribute for the selected field
     * @param mixed $id Identificator or the array of the field
     * @param type $full Defines if method should return the whole atttribute or just the value
     * @return string Returns value or the whole attribute
     */
    public function attrId($id, $full = true) {
        $f = $this->getField($id);
        $attr = $this->id . '-' . $f['id'];
        if ($full) {
            $attr = ' id="' . $attr . '"';
        }
        return $attr;
    }

    /**
     * Creates a name attribute for the selected field
     * @param mixed $id Identificator or the array of the field
     * @param type $full Defines if method should return the whole atttribute or just the value
     * @return string Returns value or the whole attribute
     */
    public function attrName($id, $full = true) {
        $f = $this->getField($id);
        $attr = $this->id . '[' . $f['id'] . ']';
        if ($full) {
            $attr = ' name="' . $attr . '"';
        }
        return $attr;
    }

    /**
     * Creates a class attribute for the selected field
     * @param mixed $id Identificator or the array of the field
     * @param type $full Defines if method should return the whole atttribute or just the value
     * @return string Returns value or the whole attribute
     */
    public function attrClass($id, $full = true) {
        $f = $this->getField($id);
        $attr = 'qbf-' . $f['type'];
        if ($full) {
            $attr = ' class="' . $attr . '"';
        }
        return $attr;
    }

    /* VALIDATION */

    /* TODO fix not required field validation, rewrie this */

    /**
     * 
     * This method checks if the form has been submitted, and if, validates it.
     * 
     * 
     * if it has been submitted. If yes, if the field is required, it is validated.
     * @return boolean Sets and returns the state of the form.
     */
    public function validate() {
        $this->valid = $this->sent; // if not sent then not valid else validate :)
        if ($this->sent) {
            $this->validateFields();
            $this->validateHidden();
        }
        return $this->valid;
    }

    private function validateFields() {
        foreach ($this->fields as $id => $field) {
            if ("" != trim($this->source[$this->id][$id])) {
                $this->fields[$id]['value'] = trim($this->source[$this->id][$id]);
                if (!$this->validateField($this->fields[$id])) {
                    $this->fields[$id]['valid'] = false;
                    $this->valid = false;
                }
            } else {
                $this->fields[$id]['value'] = '';
                if ($this->fields[$id]['required']) {
                    $this->fields[$id]['valid'] = false;
                    $this->valid = false;
                }
            }
        }
    }

    private function validateHidden() {
        foreach ($this->hidden as $id => $field) {
            if ("" != trim($this->source[$this->id][$id])) {
                $this->hidden[$id]['value'] = trim($this->source[$this->id][$id]);
                if ($this->hidden[$id]['required']) {
                    if (!$this->validateField($this->hidden[$id])) {
                        $this->hidden[$id]['valid'] = false;
                        $this->valid = false;
                    }
                }
            } else {
                if ($this->hidden[$id]['required']) {
                    $this->hidden[$id]['valid'] = false;
                    $this->valid = false;
                }
            }
        }
    }

    /**
     * Validates selected field
     * @param mixed $id Identificator or the array of the field
     * @return boolean Returns true if there's no validation for the type.
     */
    public function validateField($id) {
        $f = $this->getField($id);
        switch ($f['type']) {
            case 'antybot': case 'hidden':
                return (strcmp(strtolower($f['value']), strtolower($f['expected'])) == 0);
            case 'checkbox':
                return is_numeric($f['value']) && ($f['value'] > -1);
            case 'date':
                return $this->validateDate($f);
            case 'email':
                return $this->validateEmail($f);
            case 'number':
                return is_numeric(str_replace(',', '.', $f['value']));
            case 'radio': case 'select':
                return ($f['value'] > -1);
            case 'text':
                return (strlen($f['value']) > 2);
            case 'textarea':
                return (strlen($f['value']) > 10);
            default: //file, label, password
                return true;
        }
    }

    private function validateDate($field) {
        $list = explode('-', $field['value']);
        return (count($list) === 3) ? checkdate($list[1], $list[2], $list[2]) : false; //wat?
    }

    private function validateEmail($field) {
        $result = preg_match('/^.+@.+\..{2,3}$/', $field['value']);
        $compare = true;
        if (isset($field['compare'])) {
            $compare = (strcmp($field['value'], $this->fields[$field['compare']]['value']) == 0);
        }
        return ($result && $compare);
    }

}
