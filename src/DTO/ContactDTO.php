<?php

namespace App\DTO;
use Symfony\Component\Validator\Constraints as Assert;

class ContactDTO
{
    #[Assert\NotBlank(message: 'le nom est obligatoire')]
    #[Assert\Length(max: 50, maxMessage: 'Le nom ne peut pas dépasser 50 caractères')]
    public string $name= '';

    #[Assert\NotBlank(message: 'l\'email est obligatoire')]
    #[Assert\Email(message: 'L\'email n\'est pas valide')]
    public string $email = '';

    #[Assert\NotBlank(message: 'le service est obligatoire')]
    public string $service = '';

    #[Assert\NotBlank(message: 'le message est obligatoire')]
    public string $message = '';
}
