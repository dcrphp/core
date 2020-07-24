<?php

declare(strict_types=1);

namespace app\Model;

use app\Model\Concerns\Model;
use app\Model\TraitClass\ToolsTableEdit;

class Tools implements Model
{
    use ToolsTableEdit;

    public function validate($entity)
    {
        // TODO: Implement validate() method.
    }
}
