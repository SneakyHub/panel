<?php

namespace sneakypanel\Transformers\Api\Application;

use sneakypanel\Models\Egg;
use sneakypanel\Models\EggVariable;

class EggVariableTransformer extends BaseTransformer
{
    /**
     * Return the resource name for the JSONAPI output.
     */
    public function getResourceName(): string
    {
        return Egg::RESOURCE_NAME;
    }

    public function transform(EggVariable $model)
    {
        return $model->toArray();
    }
}
