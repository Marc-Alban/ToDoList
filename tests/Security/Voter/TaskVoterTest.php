<?php

namespace Tests\App\Security;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use App\Security\Voter\TaskVoter;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class TaskVoterTest extends TestCase
{
    /**
     * @dataProvider voterProvider
     */
    public function testTaskVoter($user, $expected, $action): void
    {
        // create the voter for testing
        $voter = new TaskVoter();
        // create the task
        $task = new Task();
        $token = new AnonymousToken('secret', 'anonymous');
        if ($user) {
            // Generate a  user login
            $token = new UsernamePasswordToken($user, 'credentials', 'memory');
            // Defined $user for a task
            $task->setUser($user);
        }
        // Compare
        $this->assertSame($expected, $voter->vote($token, $task, [$action]));
    }


    public function voterProvider(): array
    {
        $userOne = $this->createMock(User::class);
        $userOne->method('getId')->willReturn(1);
        return [
            [$userOne, 1, 'TASK_EDIT'],
            [null, -1, 'TASK_EDIT'],
            [$userOne, 1, 'TASK_DELETE'],
            [null, -1, 'TASK_DELETE'],
        ];
    }
}
