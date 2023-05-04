<?php

namespace payees\linetype;

use simplefields\traits\SimpleFields;

class payee extends \jars\Linetype
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
