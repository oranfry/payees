<?php

namespace payees\linetype;

use simplefields\traits\SimpleFields;

class payeeinvoiceline extends \jars\Linetype
{
    use SimpleFields;

    public function __construct()
    {
        $this->table = 'payeeinvoiceline';

        $this->simple_int('num');
        $this->simple_string('description');
        $this->simple_float('amount', 2);

        $this->borrow['date'] = fn ($line): ?string => @$line->invoice->date;

        $this->inlinelinks[] = (object) [
            'linetype' => 'payeerinvoice',
            'tablelink' => 'payeerinvoice_line',
            'property' => 'invoice',
            'reverse' => true,
            'orphanable' => true,
        ];
    }

    public function unpack($line, $oldline, $old_inlines)
    {
        $line->invoice = 'unchanged';
    }

    public function validate($line): array
    {
        $errors = parent::validate($line);

        if (@$line->description === null) {
            $errors[] = 'no description';
        }

        return $errors;
    }
}
