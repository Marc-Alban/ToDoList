<?php

namespace Tests\App\Security;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use App\Security\Voter\UserVoter;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class UserVoterTest extends TestCase
{
    /**
     * @dataProvider voterProvider
     */
    public function testUserVoter($task, $user, $expected, $action): void
    {
        // create the voter for testing
    	$voter = new UserVoter();
        $user = new User();
        $token = new AnonymousToken('secret', 'anonymous');
        if($user){
            // Generate a  user login
            $token = new UsernamePasswordToken($user, 'credentials', 'memory');
            $user->addTask($task);
        }
        // Compare 
        $this->assertSame($expected, $voter->vote($token, $user, [$action]));
    }


    public function voterProvider(): array
    {
        $TaskOne = $this->createMock(Task::class);
        $TaskOne->method('getId')->willReturn(1);

        $UserOne = $this->createMock(User::class);
        $UserOne->method('getId')->willReturn(1);

        return [
            [$TaskOne, $UserOne, 1, 'USER_EDIT'],
            [null, $UserOne, -1, 'USER_EDIT'],
            [$TaskOne, $UserOne, 1, 'USER_DELETE'],
            [null, $UserOne, -1, 'USER_DELETE'],
        ];
    }

}