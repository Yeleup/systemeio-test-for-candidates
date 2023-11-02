<?php

namespace App\Validator;

use App\Repository\TaxRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsCorrectTaxNumberValidator extends ConstraintValidator
{
    public function __construct(protected TaxRepository $taxRepository)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }

        // Здесь $value - это значение налогового номера
        $countryCode = substr($value, 0, 2);
        $tax = $this->taxRepository->findOneBy(['countryCode' => $countryCode]);

        if (!$tax) {
            $this->context->buildViolation($constraint->messageCountryCode)
                ->setParameter('{{ country_code }}', $countryCode)
                ->addViolation();
            return;
        }

        // Теперь у вас есть правильный формат для страны, и вы можете применить его
        $taxFormat = $tax->getTaxFormat();

        // Преобразование формата в регулярное выражение
        $regex = $this->convertFormatToRegex($taxFormat);

        if (!preg_match($regex, $value)) {
            $this->context->buildViolation($constraint->messageTaxNumber)
                ->setParameter('{{ tax_number }}', $value)
                ->addViolation();
        }
    }

    private function convertFormatToRegex($format)
    {
        // Заменяем все 'X' на [0-9], что представляет одну цифру
        $format = str_replace('X', '[0-9]', $format);

        // Заменяем все 'Y' на [A-Za-z], что представляет одну букву
        $format = str_replace('Y', '[A-Za-z]', $format);

        // Создаем регулярное выражение, обрамляя формат выражением,
        // которое означает начало и конец строки (для полного соответствия)
        $regex = "/^" . $format . "$/";

        // Возвращаем регулярное выражение
        return $regex;
    }
}
