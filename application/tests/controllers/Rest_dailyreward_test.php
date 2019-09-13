<?php
class Rest_dailyreward_test extends TestCase
{
    public function test_dailyreward_success_post()
    {
        try {
            $output = $this->request(
                'POST', 'api/daily_rewards',
                [
                    'date' => '1900-01-01',
                    'amount' => 100000
                ]
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(200);
    }

    public function test_dailyreward_error_post()
    {
        try {
            $output = $this->request(
                'POST', 'api/daily_rewards',
                [
                    'date' => '1900-01-02'
                ]
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(400);
    }

    public function test_dailyreward_success_put()
    {
        try {
            $output = $this->request(
                'PUT', 'api/daily_rewards',
                'date=1900-01-01&amount=120000'
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(200);
    }

    public function test_dailyreward_get()
    {
        try {
            $output = $this->request(
                'GET', 'api/daily_rewards/1900-01-01'
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

    public function test_dailyreward_delete()
    {
        try {
            $output = $this->request(
                'DELETE', 'api/daily_rewards', 'date=1900-01-01'
            );
        } catch (CIPHPUnitTestExitException $e) {
            $output = ob_get_clean();
        }

        $this->assertResponseCode(200);
    }

    public function test_dailyreward_again_get()
    {
        try {
            $output = $this->request(
                'GET', 'api/daily_rewards/1900-01-01'
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