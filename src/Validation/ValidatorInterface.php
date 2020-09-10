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

namespace Phalcon\Validation;

use Phalcon\Validation;

/**
 * Interface for Phalcon\Validation\AbstractValidator
 */
interface ValidatorInterface
{
    /**
     * Returns an option in the validator's options
     * Returns null if the option hasn't set
     *
     * @param string $key
     * @param null $defaultValue
     * @return mixed
     */
    public function getOption(string $key, $defaultValue = null);

    /**
     * Checks if an option is defined
     *
     * @param string $key
     * @return boolean
     */
    public function hasOption(string $key): bool;

    /**
     * Executes the validation
     *
     * @param Validation $validation
     * @param $field
     * @return boolean
     */
    public function validate(Validation $validation, $field): bool;

    /**
     * Get the template message
     *
     * @param string $field
     * @return string
     * @throw InvalidArgumentException When the field does not exists
     */
    public function getTemplate(string $field): string;

    /**
     * Get message templates
     *
     * @return array
     */
    public function getTemplates(): array;

    /**
     * Clear current template and set new from an array,
     *
     * @param array $templates
     * @return ValidatorInterface
     */
    public function setTemplates(array $templates): ValidatorInterface;

    /**
     * Set a new template message
     *
     * @param string $template
     * @return ValidatorInterface
     */
    public function setTemplate(string $template): ValidatorInterface;
}