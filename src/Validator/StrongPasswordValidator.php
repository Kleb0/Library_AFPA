<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class StrongPasswordValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (null === $value || '' === $value) {
            return; // Ne valide pas si le mot de passe est vide
        }

        // Logique pour vérifier la force du mot de passe
        $strength = 0;

        if (preg_match('/[a-z]/', $value)) $strength++; // Lettres minuscules
        if (preg_match('/[A-Z]/', $value)) $strength++; // Lettres majuscules
        if (preg_match('/[0-9]/', $value)) $strength++; // Chiffres
        if (preg_match('/[\W_]/', $value)) $strength++; // Caractères spéciaux

        // Si le mot de passe ne respecte pas tous les critères
        if ($strength < 4) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
