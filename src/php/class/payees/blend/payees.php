<?php
namespace payees\blend;

class payees extends \Blend
{
    public function __construct()
    {
        $this->label = 'Payees';
        $this->linetypes = ['payee'];
        $this->showass = ['list',];

        $this->fields = [
            (object) [
                'name' => 'payee',
                'type' => 'text',
            ],
            (object) [
                'name' => 'name',
                'type' => 'text',
            ],
        ];
    }
}
