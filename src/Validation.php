<?php

/**
 * This file is part of the Phalcon.
 *
 * (c) Phalcon Team <team@phalcon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon;

use Phalcon\Di\Injectable;
use Phalcon\Validation\AbstractCombinedFieldsValidator;

/**
 * Allows to validate data using custom or built-in validators
 */
class Validation extends Injectable implements ValidationInterface
{
    protected $combinedFieldsValidators;
    protected $data;// { get }
    protected $entity;
    protected $filters = [];
    protected $labels = [];
    protected $messages;
    protected $validators;// { set }
    protected $values;

    /**
     * Phalcon\Validation constructor
     *
     * @param array $validators
     */
    public function __construct(array $validators = [])
    {
        $this->validators = array_filter(
            $validators,
            static function ($element) {
                return !is_array($element[0]) || !($element[1] instanceof AbstractCombinedFieldsValidator);
            }
        );

        $this->combinedFieldsValidators = array_filter(
            $validators,
            static function ($element) {
                return is_array($element[0]) && $element[1] instanceof AbstractCombinedFieldsValidator;
            }
        );

        /**
         * Check for an 'initialize' method
         */
        if (method_exists($this, "initialize")) {
            $this->initialize();
        }
    }

    public function add($field, ValidatorInterface $validator): ValidationInterface
    {
        var singleField;

        if typeof field == "array" {
            // Uniqueness validator for combination of fields is handled differently
            if validator instanceof AbstractCombinedFieldsValidator {
                let this->combinedFieldsValidators[] = [field, validator];
            } else {
    for singleField in field {
        let this->validators[singleField][] = validator;
                }
}
} elseif typeof field == "string" {
    let this->validators[field][] = validator;
        } else {
    throw new Exception(
        "Field must be passed as array of fields or string"
    );
}

        return this;
    }
}