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

use Phalcon\Collection;
use Phalcon\Helper\Arr;
use Phalcon\Messages\Message;
use Phalcon\Validation;

/**
 * This is a base class for validators
 */
abstract class AbstractValidator implements ValidatorInterface
{
    /**
     * Message template
     *
     * @var string|null
     */
    protected $template;

    /**
     * Message templates
     *
     * @var array
     */
    protected $templates = [];

    protected $options;

    /**
     * Phalcon\Validation\Validator constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $template = current(Arr::whiteList($options, ["template", "message", 0]));

        if (is_array($template)) {
            $this->setTemplates($template);
        } elseif (is_string($template)) {
            $this->setTemplate($template);
        }

        if ($template) {
            unset($options["template"], $options["message"], $options[0]);
        }

        $this->options = $options;
    }

    /**
     * Get the template message
     *
     * @param string|null $field
     * @return string
     * @throw InvalidArgumentException When the field does not exists
     */
    public function getTemplate(?string $field = null): string
    {
        //TODO where is Exception in original code ?

        // there is a template in field
        if ($field !== null && isset($this->templates[$field])) {
            return $this->templates[$field];
        }

        // there is a custom template
        if ($this->template) {
            return $this->template;
        }

        // default template message
        return "The field :field is not valid for " . get_class($this);
    }

    /**
     * Get templates collection object
     *
     * @return array
     */
    public function getTemplates(): array
    {
        return $this->templates;
    }

    /**
     * Clear current templates and set new from an ar ray,
     *
     * @param array $templates
     * @return ValidatorInterface
     */
    public function setTemplates(array $templates): ValidatorInterface
    {
        $this->templates = [];

        foreach ($templates as $field => $template) {
            $this->templates[(string)$field] = (string)$template;
        }

        return $this;
    }

    /**
     * Set a new template message
     *
     * @param string $template
     * @return ValidatorInterface
     */
    public function setTemplate(string $template): ValidatorInterface
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Returns an option in the validator's options
     * Returns null if the option hasn't set
     *
     * @param string $key
     * @param mixed $defaultValue
     * @return mixed
     */
    public function getOption(string $key, $defaultValue = null)
    {
        if (!isset($this->options[$key])) {
            return $defaultValue;
        }

        $value = $this->options[$key];

        /*
         * If we have attribute it means it's Uniqueness validator, we
         * can have here multiple fields, so we need to check it
         */
        if ($key === "attribute" && isset($value[$key])) {
            return $value[$key];
        }

        return $value;
    }

    /**
     * Checks if an option is defined
     *
     * @param string $key
     * @return bool
     */
    public function hasOption(string $key): bool
    {
        return isset($this->options[$key]);
    }

    /**
     * Sets an option in the validator
     *
     * @param string $key
     * @param $value
     */
    public function setOption(string $key, $value): void
    {
        $this->options[$key] = $value;
    }

    /**
     * Executes the validation
     *
     * @param Validation $validation
     * @param $field
     * @return bool
     */
    abstract public function validate(Validation $validation, $field): bool;

    /**
     * Prepares a validation code.
     * @param string $field
     * @return int|null
     */
    protected function prepareCode(string $field): ?int
    {
        $code = $this->getOption("code");

        if (is_array($code)) {
            return $code[$field];
        }

        return $code;
    }

    /**
     * Prepares a label for the field.
     *
     * @param Validation $validation
     * @param string $field
     * @return mixed
     */
    protected function prepareLabel(Validation $validation, string $field)
    {
        $label = $this->getOption("label");

        if (is_array($label)) {
            $label = $label[$field];
        }

        if (empty($label)) {
            $label = $validation->getLabel($field);
        }

        return $label;
    }

    public function messageFactory(Validation $validation, $field, array $replacements = []): Message
    {
        if (is_array($field)) {
            $singleField = implode(", ", $field);
        } elseif (is_string($field)) {
            $singleField = $field;
        } else {
            throw new Exception("The field can not be printed");
        }

        $replacements = array_merge(
            [
                ":field" => $this->prepareLabel($validation, $singleField),
            ],
            $replacements
        );

        return new Message(
            strtr($this->getTemplate($singleField), $replacements),
            $field,
            get_class($this),
            $this->prepareCode($singleField)
        );
    }
}