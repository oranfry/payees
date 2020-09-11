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
            '{t}.date' => ':{t}_date',
            '{t}.payee' => ':{t}_payee',
            '{t}.amount' => ':{t}_amount',
            '{t}.description' => ':{t}_description',
        ];
    }

    public function get_suggested_values()
    {
        $payees = get_values('payee', 'payee');

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
