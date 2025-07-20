<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class BanWordValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        /* @var BanWord $constraint */

        if (null === $value || '' === $value) {
            return;
        }


        $value= strtolower($value);
        foreach ($constraint->banWords as $BanWord){
            if (str_contains($value, strtolower($BanWord))){
                $this->context->buildViolation($constraint->message)
                ->setParameter('{{ banword }}', $BanWord)
                ->addViolation();
                return;
            }
        }
    }
}
