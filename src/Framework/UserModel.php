<?php

namespace Efsystems\Framework;

use Efsystems\Framework\DB\DbModel;

abstract class UserModel extends DbModel
{
    abstract public function getDisplayName(): string;
}