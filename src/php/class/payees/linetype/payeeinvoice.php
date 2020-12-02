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
            (object) [
                'name' => 'icon',
                'type' => 'icon',
                'fuse' => "'docpdf'",
                'derived' => true,
            ],
            (object) [
                'name' => 'date',
                'type' => 'date',
                'groupable' => true,
                'fuse' => '{t}.date',
            ],
            (object) [
                'name' => 'payee',
                'type' => 'text',
                'fuse' => '{t}.payee',
            ],
            (object) [
                'name' => 'description',
                'type' => 'text',
                'fuse' => '{t}.description',
            ],
            (object) [
                'name' => 'amount',
                'type' => 'number',
                'dp' => 2,
                'summary' => 'sum',
                'fuse' => '{t}.amount',
            ],
            (object) [
                'name' => 'file',
                'type' => 'file',
                'icon' => 'docpdf',
                'path' => 'invoice',
                'supress_header' => true,
            ],
            (object) [
                'name' => 'broken',
                'type' => 'text',
                'fuse' => "if({t}.payee is null or {t}.payee = '', 'broken', '')",
                'derived' => true,
                'calc' => function($line) {
                    if (@$line->broken) {
                        return $line->broken;
                    }

                    $fy = date('Y') + (date('m') > 3 ? 1 : 0);
                    $afterdate = ($fy - 8) . '-04-01';

                    if (strcmp($line->date, $afterdate) >= 0 && !@$line->file_path) {
                        return 'broken';
                    }
                },
            ],
        ];
        $this->unfuse_fields = [
            '{t}.date' => (object) [
                'expression' => ':{t}_date',
                'type' => 'date',
            ],
            '{t}.payee' => (object) [
                'expression' => ':{t}_payee',
                'type' => 'varchar(40)',
            ],
            '{t}.amount' => (object) [
                'expression' => ':{t}_amount',
                'type' => 'decimal(10,2)',
            ],
            '{t}.description' => (object) [
                'expression' => ':{t}_description',
                'type' => 'varchar(255)',
            ],
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
