<?php
class Rest_userreward_test extends TestCase
{
    public function test_users_success_post()
    {
        try {
            $output = $this->request(
                'POST', 'api/users',
                [
                    'username' => 'testreward_unittest',
                    'fullname' => 'Test Reward Unittest'
                ]
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(200);
    }

    public function test_user_reward_success_post()
    {
        try {
            $output = $this->request(
                'POST', 'api/user_rewards',
                [
                    'username' => 'testreward_unittest',
                    'date'     => '1900-01-01'
                ]
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(200);
    }

    public function test_user_reward_fail_repost()
    {
        try {
            $output = $this->request(
                'POST', 'api/user_rewards',
                [
                    'username' => 'testreward_unittest',
                    'date'     => '1900-01-01'
                ]
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(400);
    }

    public function test_user_reward_success_delete()
    {
        try {
            $output = $this->request(
                'DELETE', 'api/user_rewards',
                'username=testreward_unittest&date=1900-01-01'
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(200);
    }

    public function test_users_delete()
    {
        try {
            $output = $this->request(
                'DELETE', 'api/users', 'username=testreward_unittest'
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(200);
    }

    public function test_users_again_get()
    {
        try {
            $output = $this->request(
                'GET', 'api/users/testreward_unittest'
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $output = json_decode($output, true);
        $output = sizeof($output['message']);
        $expected = 0;

        $this->assertEquals($expected, $output);
        $this->assertResponseCode(200);
    }
}