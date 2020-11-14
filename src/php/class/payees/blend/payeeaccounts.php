<?php
namespace payees\blend;

class payeeaccounts extends \Blend
{
    public function __construct()
    {
        $this->label = 'Accounts';
        $this->linetypes = ['payeeinvoice', 'transaction',];
        $this->showass = ['list', 'graph',];
        $this->groupby = 'date';
        $this->past = true;
        $this->cum = true;
        $this->fields = [
            (object) [
                'name' => 'icon',
                'type' => 'icon',
                'derived' => true,
            ],
            (object) [
                'name' => 'date',
                'type' => 'date',
                'groupable' => true,
                'main' => true,
            ],
            (object) [
                'name' => 'payee',
                'type' => 'text',
                'main' => true,
                'filteroptions' => function($token) {
                    $payees = get_values($token, 'payee', 'payee');
                    sort($payees);

                    return $payees;
                },
            ],
            (object) [
                'name' => 'description',
                'type' => 'text',
            ],
            (object) [
                'name' => 'amount',
                'type' => 'number',
                'dp' => '2',
                'summary' => 'sum',
            ],
            (object) [
                'name' => 'file',
                'type' => 'file',
                'icon' => 'docpdf',
                'default' => '',
                'path' => 'invoice',
                'supress_header' => true,
            ],
            (object) [
                'name' => 'broken',
                'type' => 'class',
                'default' => '',
            ],
        ];
    }
}
