<?php

namespace payees\linetype;

use simplefields\traits\SimpleFields;

class payeeinvoice extends \jars\Linetype
{
    use SimpleFields;

    public function __construct()
    {
        $this->table = 'payeeinvoice';

        $this->simple_date('date');
        $this->simple_string('payee');
        $this->simple_string('external_id');
        $this->simple_string('description');
        $this->simple_float('amount', 2);

        $this->children = [
            (object) [
                'linetype' => 'payeeinvoiceline',
                'property' => 'lines',
                'tablelink' => 'payeeinvoice_line',
                'only_parent' => 'payeeinvoice_id',
           ],
        ];
    }

    public function validate($line): array
    {
        $errors = parent::validate($line);

        if ($line->date == null) {
            $errors[] = 'no date';
        }

        return $errors;
    }
}
