<?php

namespace payees\linetype;

class payee extends \jars\Linetype
{
    function __construct()
    {
        $this->table = 'payee';

        $this->fields = [
            'payee' => fn ($records) => $records['/']->payee,
            'name' => fn ($records) => $records['/']->name,
        ];

        $this->unfuse_fields = [
            'payee' => fn ($line, $oldline) => $line->payee,
            'name' => fn ($line, $oldline) => $line->name,
        ];
    }

    function validate($line)
    {
        $errors = [];

        if (!@$line->payee) {
            $errors[] = 'no payee';
        }

        if (!@$line->name) {
            $errors[] = 'no name';
        }

        return $errors;
    }
}
