<?php

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Validation language settings
return [
    // Core Messages
    'noRuleSets'      => 'No rule sets specified in Validation configuration.',
    'ruleNotFound'    => '"{0}" is not a valid rule.',
    'groupNotFound'   => '"{0}" is not a validation rules group.',
    'groupNotArray'   => '"{0}" rule group must be an array.',
    'invalidTemplate' => '"{0}" is not a valid Validation template.',

    // Rule Messages
    'alpha'                 => 'The {field} field may only contain alphabetical characters.',
    'alpha_dash'            => 'The {field} field may only contain alphanumeric, underscore, and dash characters.',
    'alpha_numeric'         => 'The {field} field may only contain alphanumeric characters.',
    'alpha_numeric_punct'   => 'The {field} field may contain only alphanumeric characters, spaces, and  ~ ! # $ % & * - _ + = | : . characters.',
    'alpha_numeric_space'   => 'The {field} field may only contain alphanumeric and space characters.',
    'alpha_space'           => 'The {field} field may only contain alphabetical characters and spaces.',
    'decimal'               => 'The {field} field must contain a decimal number.',
    'differs'               => 'The {field} field must differ from the {param} field.',
    'equals'                => 'The {field} field must be exactly: {param}.',
    'exact_length'          => 'Pole musí obsahovat přesně {param} znaků',
    'greater_than'          => 'Pole musí obsahovat číslo větší než {param}.',
    'greater_than_equal_to' => 'Pole musí obsahovat číslo větší nebo rovno než {param}.',
    'hex'                   => 'The {field} field may only contain hexadecimal characters.',
    'in_list'               => 'Hodnota pole musí být z výběru: {param}.',
    'integer'               => 'Pole musí obsahovat integer',
    'is_natural'            => 'Pole musí obsahovat pouze číslice',
    'is_natural_no_zero'    => 'Pole musí obsahovat pouze číslice větší než nula',
    'is_not_unique'         => 'The {field} field must contain a previously existing value in the database.',
    'is_unique'             => 'The {field} field must contain a unique value.',
    'less_than'             => 'Pole musí obsahovat číslo menší než {param}.',
    'less_than_equal_to'    => 'The {field} musí obsahovat číslo menší nebo rovno než {param}.',
    'matches'               => 'Pole se neshoduje s polem {param}.',
    'max_length'            => 'Pole může obsahovat maximálně {param} znaky',
    'min_length'            => 'Pole musí obsahovat minimálně {param} znaky',
    'not_equals'            => 'The {field} field cannot be: {param}.',
    'not_in_list'           => 'Pole {field} obsahuje nepovolenou hodnotu',
    'numeric'               => 'Pole {field} musí obsahovat pouze čísla',
    'regex_match'           => 'Pole {field} není ve správném formátu.',
    'required'              => 'Pole je povinné.',
    'required_with'         => 'Pole je povinné pokud Pole {param} je zadané',
    'required_without'      => 'Pole je povinné pokud Pole {param} není zadané.',
    'string'                => 'Pole {field} musí obsahovat string řetězec.',
    'timezone'              => 'Pole {field} musí obsahovat validní timezone.',
    'valid_base64'          => 'The {field} field must be a valid base64 string.',
    'valid_email'           => 'Pole {field} musí obsahovat validní emailovou adresu',
    'valid_emails'          => 'The {field} field must contain all valid email addresses.',
    'valid_ip'              => 'The {field} field must contain a valid IP.',
    'valid_url'             => 'The {field} field must contain a valid URL.',
    'valid_url_strict'      => 'The {field} field must contain a valid URL.',
    'valid_date'            => 'Pole {field} musí obsahovat validní datum.',
    'valid_json'            => 'The {field} field must contain a valid json.',

    //Custom
    'invalid_value'         => 'Vybrali jste neplatnou hodnotu',
    'duplicit_ec'           => 'Duplicitní EC kód.',

    // Credit Cards
    'valid_cc_num' => '{field} does not appear to be a valid credit card number.',

    // Files
    'uploaded' => '{field} is not a valid uploaded file.',
    'max_size' => '{field} is too large of a file.',
    'is_image' => '{field} is not a valid, uploaded image file.',
    'mime_in'  => '{field} does not have a valid mime type.',
    'ext_in'   => '{field} does not have a valid file extension.',
    'max_dims' => '{field} is either not an image, or it is too wide or tall.',
];