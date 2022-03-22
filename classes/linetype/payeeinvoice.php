<?php

namespace payees\linetype;

class payeeinvoice extends \jars\Linetype
{
    public function __construct()
    {
        $this->table = 'payeeinvoice';

        $this->fields = [
            'icon' => fn ($records) => 'docpdf',
            'date' => fn ($records) => $records['/']->date,
            'payee' => fn ($records) => $records['/']->payee,
            'description' => fn ($records) => $records['/']->description,
            'amount' => fn ($records) => $records['/']->amount,
            // (object) [
            //     'name' => 'file',
            //     'type' => 'file',
            //     'icon' => 'docpdf',
            //     'path' => 'invoice',
            //     'supress_header' => true,
            // ],
            'broken' => function ($records) {
                if (!@$records['/']->user) {
                    return 'no user';
                }

                // $fy = date('Y') + (date('m') > 3 ? 1 : 0);
                // $afterdate = ($fy - 8) . '-04-01';

                // if (strcmp($line->date, $afterdate) >= 0 && !@$line->file_path) {
                //     return 'no receipt';
                // }
            },
        ];

        $this->unfuse_fields = [
            'date' => fn ($line, $oldline) => $line->date,
            'payee' => fn ($line, $oldline) => $line->payee,
            'amount' => fn ($line, $oldline) => $line->amount,
            'description' => fn ($line, $oldline) => @$line->description,
        ];
    }

    public function validate($line)
    {
        $errors = [];

        if ($line->date == null) {
            $errors[] = 'no date';
        }

        return $errors;
    }
}
