<?php
class Rest_user_test extends TestCase
{
    public function test_users_success_post()
    {
        try {
            $output = $this->request(
                'POST', 'api/users',
                [
                    'username' => 'test_unittest',
                    'fullname' => 'Test Unittest'
                ]
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(200);
    }

    public function test_users_error_post()
    {
        try {
            $output = $this->request(
                'POST', 'api/users',
                [
                    'fullname' => 'Test Unittest 2'
                ]
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(400);
    }

    public function test_users_success_put()
    {
        try {
            $output = $this->request(
                'PUT', 'api/users',
                'username=test_unittest&fullname=ChangedName'
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(200);
    }

    public function test_users_get()
    {
        try {
            $output = $this->request(
                'GET', 'api/users/test_unittest'
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $output = json_decode($output, true);
        $output = sizeof($output['message']);
        $expected = 1;

        $this->assertEquals($expected, $output);
        $this->assertResponseCode(200);
    }

    public function test_users_delete()
    {
        try {
            $output = $this->request(
                'DELETE', 'api/users', 'username=test_unittest'
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
                'GET', 'api/users/test_unittest'
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