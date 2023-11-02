<?php
namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute] class ProductExists extends Constraint
{
    public string $message = 'The product "{{ productId }}" does not exist.';
}