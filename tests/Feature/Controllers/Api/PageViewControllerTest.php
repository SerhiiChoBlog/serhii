<?php

namespace Tests\Feature\Controllers\Api;

use App\Http\Controllers\Api\PageViewController;
use App\Http\Requests\Api\PageViewController\UpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Mockery;
use Stevebauman\Location\Location;
use Tests\TestCase;

class PageViewControllerTest extends TestCase
{
    use RefreshDatabase;

    private string|null $updateUrl;
    private PageViewController $controller;

    public function setUp(): void
    {
        parent::setUp();
        $this->updateUrl = action([PageViewController::class, 'update']);
        $this->controller = new PageViewController();
    }

    private function createRequestWithParams(array $params): UpdateRequest
    {
        $request = new UpdateRequest($params);
        $request->server->add(['REMOTE_ADDR' => '114.119.153.160']);

        return $request;
    }

    /** @test */
    public function cant_send_request_without_slug_param_throws_exception(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);

        $this->post($this->updateUrl, []);
    }

    /** @test */
    public function request_with_valid_params_creates_page_view_and_visitor_in_database(): void
    {
        $page_view_params = ['slug' => 'some-slug', 'page_type' => 'other'];
        $request = $this->createRequestWithParams($page_view_params);

        $position = (object) ['countryName' => 'Italy', 'cityName' => 'Rome'];

        $location = Mockery::mock(Location::class);
        $location->shouldReceive('get')->andReturn($position);

        $this->controller->update($request, $location);

        $this->assertDatabaseHas('page_views', array_merge($page_view_params, ['views' => 1]));
        $this->assertDatabaseHas('visitors', ['country' => 'Italy', 'city' => 'Rome']);
    }
}
