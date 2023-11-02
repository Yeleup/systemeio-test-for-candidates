<?php

namespace App\Validator;

use App\Repository\ProductRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class ProductExistsValidator extends ConstraintValidator
{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ProductExists) {
            throw new UnexpectedTypeException($constraint, ProductExists::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (null === $this->productRepository->find($value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ productId }}', $value)
                ->addViolation();
        }
    }
}
