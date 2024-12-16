<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class StrongPassword extends Constraint
{
    public $message = 'Le mot de passe doit contenir des lettres minuscules, majuscules, chiffres et caractères spéciaux.';
}
