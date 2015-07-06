<?php

namespace DB\ServiceBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType {

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('name');
    }

    public function getParent() {
        return 'fos_user_registration';
    }

    public function getName() {
        return 'db_service_registration';
    }

}
