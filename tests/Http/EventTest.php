<?php
/**
 * Created by PhpStorm.
 * User: jesign
 * Date: 7/19/19
 * Time: 8:30 PM
 */

namespace Tests\Http;

use App\Event;
use Tests\TestCase;

class EventTest extends TestCase
{
    public function testEventIndex()
    {
        $response = $this->json('GET','api/events');
        $response->assertStatus(200);
    }

    public function testEventCreate()
    {
        $data = [
            'title' => 'Event Title',
            'description' => 'lorem ipsum dolor sit amet'
        ];

        $response = $this->json('POST','api/events', $data);

        $response->assertStatus(200)->assertJson($data);
    }

    public function testEventUpdate()
    {
        $event = factory(Event::class)->create();
        $data = [
            'id' => $event->id,
            'title' => 'Event Title',
            'description' => 'lorem ipsum dolor sit amet'
        ];

        $response = $this->json('POST','api/events', [
            'id' => $event->id,
            'title' => 'Event Title',
            'description' => 'lorem ipsum dolor sit amet'
        ]);

        $response->assertStatus(200)->assertJson($data);
    }

    public function testEventDelete()
    {
        $event = factory(Event::class)->create();

        $response = $this->json('POST','api/events/' . $event->id . '/delete');

        $response->assertStatus(200)->assertJson([
            'success' => true
        ]);
    }
}