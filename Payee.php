<?php

namespace OranFry\Payees\Linetypes;

use OranFry\SimpleFields\Traits\SimpleFields;

class Payee extends \OranFry\Jars\Core\Linetype
{
    use SimpleFields;

    function __construct()
    {
        $this->table = 'payee';

        $this->simple_string('payee');
        $this->simple_string('name');
    }

    function validate($line): array
    {
        $errors = parent::validate($line);

        if (!@$line->payee) {
            $errors[] = 'no payee';
        }

        if (!@$line->name) {
            $errors[] = 'no name';
        }

        return $errors;
    }
}
