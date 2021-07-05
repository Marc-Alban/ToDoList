<?php

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Test\TypeTestCase;

class UserTypeTest extends TypeTestCase
{
    public function testUserType()
    {
        $formData = [
            'username' => 'test',
            'password' => 'test',
            'email' => 'test@gmail.com',
            'roles' => [
                'ROLE_ADMIN'
            ]
        ];

        $formData2 = [
            'username' => 'test',
            'password' => 'test',
            'email' => 'test@gmail.com',
            'roles' => [
                'ROLE_ADMIN'
            ]
        ];

        $form = $this->factory->create(UserType::class);

        $form->submit($formData);

        $this->assertEquals($form->getData(), $formData2);
    }

}