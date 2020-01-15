<?php


class AuthTest extends ApiTest
{
    public function testRegisterUser()
    {
        $userData = [
            'email'=> 'test'.uniqid().'@apptest.com',
            'password' => '123456'
        ];

        $response = $this->http->request('POST', 'register',[
            'form_params' =>
                array_merge($userData, [
                    'name' => 'test name'
                ])
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('access_token', $data);
        $this->assertArrayHasKey('token_type', $data);
        $this->assertArrayHasKey('expires_in', $data);

        return $userData;
    }

    public function testRegisterUserWithInvalidData()
    {
        $response = $this->http->request('POST', 'register',[
            'form_params' => [
               'email' => 'test name'
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(422, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('email', $data['errors']);
        $this->assertArrayHasKey('password', $data['errors']);
        $this->assertArrayHasKey('name', $data['errors']);

    }

    /**
     * @depends testRegisterUser
     */
    public function testLoginUser(array $userData)
    {
        $response = $this->http->request('POST', 'login',['form_params' => $userData ]);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('access_token', $data);
        $this->assertArrayHasKey('token_type', $data);
        $this->assertArrayHasKey('expires_in', $data);

        return $data['access_token'];
    }

    public function testLoginUserWithEmptyData()
    {
        $response = $this->http->request('POST', 'login', ['http_errors' => false]);

        $this->assertEquals(422, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('email', $data['errors']);
        $this->assertArrayHasKey('password', $data['errors']);
    }

    public function testLoginUserWithInvalidData()
    {
        $response = $this->http->request('POST', 'login',[
            'form_params' => [
                'email'=> 'sdasda@email.com',
                'password' => '123456'
            ],
            'http_errors' => false
        ]);

        $this->assertEquals(401, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('error', $data);
    }

}