<?php


class ProductTest extends ApiTest
{
    private $productId = null;

    public function testGetAllProducts()
    {
        $response = $this->http->request('GET', 'products');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertArrayHasKey('links', $data);
        $this->assertArrayHasKey('meta', $data);
        $this->assertNotEmpty($data['data']);
        $this->assertEquals(
            [
                'id',
                'sku',
                'name',
                'title',
                'price',
                'image_url',
                'stock',
            ],
            array_keys($data['data'][0])
        );

        return $data;
    }

    /**
     * @depends testGetAllProducts
     */
    public function testGetProduct(array $products)
    {

        $productId = $products['data'][0]['id'];

        $response = $this->http->request('GET', 'products/' . $productId);

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertEquals($productId, $data['data']['id']);
        $this->assertEquals(
            [
                'id',
                'sku',
                'name',
                'title',
                'url',
                'abstract',
                'description',
                'price',
                'image_url',
                'stock',
            ],
            array_keys($data['data'])
        );

    }

    public function testGetProductNotFound()
    {
        $response = $this->http->request('GET', 'products/dasd', ['http_errors' => false]);

        $this->assertEquals(404, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('error', $data);
    }

    /**
     * @param string $userToken
     * @depends AuthTest::testLoginUser
     */
    public function testPostProduct(string $userToken)
    {
        $productParams = [
            'sku' => uniqid().'test',
            'title' => 'title',
            'url' => 'url',
            'price' => 20.00
        ];
        $response = $this->http->request('POST', 'products', [
            'form_params' => $productParams,
            'headers' => [
                'Authorization' => 'Bearer ' . $userToken,
            ]
        ]);

        $this->assertEquals(201, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('data', $data);
        $this->assertEquals($productParams['sku'], $data['data']['sku']);
        $this->assertEquals(
            [
                'id',
                'sku',
                'name',
                'title',
                'url',
                'abstract',
                'description',
                'price',
                'image_url',
                'stock',
            ],
            array_keys($data['data'])
        );
    }

    /**
     * @param string $userToken
     * @depends AuthTest::testLoginUser
     */
    public function testPostProductInvalidData(string $userToken)
    {
        $response = $this->http->request('POST', 'products', [
            'form_params' => [
                'sku' => uniqid().'test',
                'title' => 'title'
            ],
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . $userToken,
            ]
        ]);

        $this->assertEquals(422, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $data = json_decode($response->getBody(), true);

        $this->assertArrayHasKey('errors', $data);
        $this->assertArrayHasKey('url', $data['errors']);
        $this->assertArrayHasKey('price', $data['errors']);
    }

    /**
     * @param string $userToken
     */
    public function testPostProductUnauthorized()
    {
        $response = $this->http->request('POST', 'products', [
            'form_params' => [
                'sku' => uniqid().'test',
                'title' => 'title'
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