<?php

namespace App\Form;

use Symfony\Component\Form\Event\PreSubmitEvent;

class FormListenerFactory{

    public function autoSlug(string $field):callable
    {
        return function(PreSubmitEvent $event) use ($field) {
            $data = $event->getData();
            if (isset($data[$field]) && !empty($data[$field])) {
                $data['slug'] = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $data[$field])));
                $event->setData($data);
            }
        };
    }
    public function timestamps():callable
    {
        return function(PreSubmitEvent $event) {
            $data = $event->getData();
            $now = new \DateTimeImmutable();
            if (!isset($data['createdAt'])) {
                $data['createdAt'] = $now;
            }
            $data['updatedAt'] = $now;
            $event->setData($data);
        };
    }
}