<?php
namespace payees\linetype;

class payee extends \Linetype
{
    function __construct()
    {
        $this->label = 'Payee';
        $this->table = 'payee';

        $this->fields = [
            'payee' => function ($records) {
                return $records['/']->payee;
            },
            'name' => function ($records) {
                return $records['/']->name;
            },
        ];

        $this->unfuse_fields = [
            'payee' => function($line, $oldline) {
                return $line->payee;
            },
            'name' => function($line, $oldline) {
                return $line->name;
            },
        ];
    }

    function validate($line) {
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
