<?php
namespace payees\linetype;

class payee extends \Linetype
{
    function __construct()
    {
        $this->label = 'Payee';
        $this->table = 'payee';

        $this->fields = [
            (object) [
                'name' => 'payee',
                'type' => 'text',
                'fuse' => '{t}.payee',
            ],
            (object) [
                'name' => 'name',
                'type' => 'text',
                'fuse' => '{t}.name',
            ],
        ];

        $this->unfuse_fields = [
            '{t}.payee' => ':{t}_payee',
            '{t}.name' => ':{t}_name',
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
