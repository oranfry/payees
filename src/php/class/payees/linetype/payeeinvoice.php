<?php
namespace payees\linetype;

class payeeinvoice extends \Linetype
{
    public function __construct()
    {
        $this->label = 'Payee Invoice';
        $this->icon = 'docpdf';
        $this->table = 'payeeinvoice';
        $this->fields = [
            'icon' => function($records) {
                return 'docpdf';
            },
            'date' => function($records) {
                return $records['/']->date;
            },
            'payee' => function($records) {
                return $records['/']->payee;
            },
            'description' => function($records) {
                return $records['/']->description;
            },
            'amount' => function($records) {
                return $records['/']->amount;
            },
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
            'date' => function($line, $oldline) {
                return $line->date;
            },
            'payee' => function($line, $oldline) {
                return $line->payee;
            },
            'amount' => function($line, $oldline) {
                return $line->amount;
            },
            'description' => function($line, $oldline) {
                return $line->description;
            },
        ];
    }

    public function get_suggested_values($token)
    {
        $payees = get_values($token, 'payee', 'payee');

        sort($payees);

        return [
            'payee' => $payees,
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
