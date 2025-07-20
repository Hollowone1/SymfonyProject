<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
final class BanWord extends Constraint
{
    
    public string $message = 'The string "{{ banword }}" contains an illegal character: it can only contain letters or numbers.';

    public function __construct(array $banWord = ['Badword','viagra','xxx'], string $message = 'these words should not be tell', array $groups = null, mixed $payload = null)
    {
        $this->banWords = $banWord;
        $this->message = $message;

        parent::__construct($groups, $payload);
    }
}
