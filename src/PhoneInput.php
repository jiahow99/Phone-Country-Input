<?php

namespace Mices\PhoneInput;

use Laravel\Nova\Fields\Field;

class PhoneInput extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'phone-input';

    public function options($options)
    {
        return $this->withMeta([
            'options' => $options,
        ]);
    }
}
