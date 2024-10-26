<?php

namespace sneakypanel\Http\Requests\Admin\Settings;

use sneakypanel\Http\Requests\Admin\AdminFormRequest;

class AdvancedSettingsFormRequest extends AdminFormRequest
{
    /**
     * Return all the rules to apply to this request's data.
     */
    public function rules(): array
    {
        return [
            'recaptcha:enabled' => 'required|in:true,false',
            'recaptcha:secret_key' => 'required|string|max:191',
            'recaptcha:website_key' => 'required|string|max:191',
            'sneakypanel:guzzle:timeout' => 'required|integer|between:1,60',
            'sneakypanel:guzzle:connect_timeout' => 'required|integer|between:1,60',
            'sneakypanel:client_features:allocations:enabled' => 'required|in:true,false',
            'sneakypanel:client_features:allocations:range_start' => [
                'nullable',
                'required_if:sneakypanel:client_features:allocations:enabled,true',
                'integer',
                'between:1024,65535',
            ],
            'sneakypanel:client_features:allocations:range_end' => [
                'nullable',
                'required_if:sneakypanel:client_features:allocations:enabled,true',
                'integer',
                'between:1024,65535',
                'gt:sneakypanel:client_features:allocations:range_start',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'recaptcha:enabled' => 'reCAPTCHA Enabled',
            'recaptcha:secret_key' => 'reCAPTCHA Secret Key',
            'recaptcha:website_key' => 'reCAPTCHA Website Key',
            'sneakypanel:guzzle:timeout' => 'HTTP Request Timeout',
            'sneakypanel:guzzle:connect_timeout' => 'HTTP Connection Timeout',
            'sneakypanel:client_features:allocations:enabled' => 'Auto Create Allocations Enabled',
            'sneakypanel:client_features:allocations:range_start' => 'Starting Port',
            'sneakypanel:client_features:allocations:range_end' => 'Ending Port',
        ];
    }
}
