<?php

namespace App\Tests\Form;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testTaskType(): void
    {

        $formData = [
            'title' => 'test',
            'content' => 'test2'
        ];

        $taskToCompare = new Task();

        $form = $this->factory->create(TaskType::class, $taskToCompare);

        $task = new Task();
        $task->setTitle('test');
        $task->setContent('test2');

        $form->submit($formData);
        $this->assertEquals($task->getTitle(), $taskToCompare->getTitle());
        $this->assertEquals($task->getContent(), $taskToCompare->getContent());
    }

}