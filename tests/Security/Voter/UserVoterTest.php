<?php

namespace AppBundle\Tests\Security\Voter;

use App\Entity\Task;
use App\Entity\User;
use App\Security\Voter\UserVoter;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserVoterTest extends WebTestCase
{

     /**
     * @dataProvider voterProvider
     */
    public function testUserVoter($user, $expected, $action): void
    {
        // create the voter for testing
        $voter = new UserVoter();
        // create the task
        $task = new Task();
        $token = new AnonymousToken('secret', 'anonymous');
        if ($user) {
            // Generate a  user login
            $token = new UsernamePasswordToken($user, 'credentials', 'memory');
            // Defined $user for a task
            $user->addTask($task);
        }
        // Compare
        $this->assertSame($expected, $voter->vote($token, $user, [$action]));
    }


    public function voterProvider(): array
    {
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn(1);

        return [
            [$user, -1, 'USER_READ'],
            [null, 0, 'USER_READ'],
            [$user, 1, 'USER_EDIT'],
            [null, 0, 'USER_EDIT'],
            [$user, -1, 'USER_DELETE'],
            [null, 0, 'USER_DELETE'],
        ];
    }
}
