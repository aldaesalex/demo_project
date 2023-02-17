<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ZipCodeTest extends TestCase
{
    /**
     * Test of a found code.
     *
     * @return void
     */
    public function test_codeFound()
    {
        $response = $this->get('/api/zip-codes/91580');
        $response->assertJsonFragment([trans('messages.zip_code') => '91580',trans('messages.locality') => 'COATEPEC']);
        $response->assertStatus(200);
    }

     /**
     * Test of a found code.
     *
     * @return void
     */
    public function test_code_95094()
    {
        $response = $this->get('/api/zip-codes/95094');
        $response->assertJsonFragment([trans('messages.zip_code') => '95094',trans('messages.locality') => '']);
        $response->assertStatus(200);
    }
    

    /**
     * Test of a code not found.
     *
     * @return void
     */
    public function test_codeNotFound()
    {
        $response = $this->get('/api/zip-codes/1111');
        $response->assertJson([]);
        $response->assertStatus(404);
    }

    /**
     * Testing a non-numeric code.
     *
     * @return void
     */
    public function test_codeNotNumeric()
    {
        $response = $this->get('/api/zip-codes/demo'); 
        $response->assertStatus(422);
        $response->assertJson([
            'type' => ['0'=>trans('messages.not_numeric')],
        ]);
    }

    /**
     * Test length greater than 5 digits.
     *
     * @return void
     */
    public function test_codeMaxLength()
    {
        $response = $this->get('/api/zip-codes/9509423');
        $response->assertJson([
            'len' => ['0'=>trans('messages.maxlength')],
        ]);
        $response->assertStatus(422);
    }
}
