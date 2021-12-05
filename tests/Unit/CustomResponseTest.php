<?php

namespace Unit;

use Exception;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class CustomResponseTest extends TestCase
{
    public function test_error_custom_response_without_err_trace()
    {
        $response = custom_error_response('test message')->getData();

        $testResponse = json_encode([
            'message' => 'test message',
            'errors'  => []
        ]);

        $this->assertJsonStringEqualsJsonString(json_encode($response), $testResponse);
    }


    public function test_error_custom_response_with_err_trace()
    {
        $exception = new Exception('test');

        $response = custom_error_response('test message', $exception->getTrace())->getData();

        $testResponse = json_encode([
            'message' => 'test message',
            'errors'  => $exception->getTrace()
        ]);

        $this->assertJsonStringEqualsJsonString(json_encode($response), $testResponse);
    }

    public function test_error_custom_response_without_err_trace_when_production()
    {
        app()->detectEnvironment(function () {
            return 'production';
        });

        $exception = new Exception('test');

        $response = custom_error_response('test message', $exception->getTrace())->getData();

        $testResponse = json_encode([
            'message' => 'test message'
        ]);

        $this->assertJsonStringEqualsJsonString(json_encode($response), $testResponse);
    }


    public function test_error_custom_response_should_log_err_trace_when_production()
    {
        app()->detectEnvironment(function () {
            return 'production';
        });

        $exception = new Exception('test');
        custom_error_response('test message', $exception->getTrace())->getData();

        Log::shouldReceive('error')
            ->with($exception->getTrace());
    }
}
