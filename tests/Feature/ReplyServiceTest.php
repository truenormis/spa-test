<?php

namespace Tests\Feature;

use App\Http\Requests\StoreReplyRequest;
use App\Services\ReplyService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ReplyServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateReplyWithoutParent()
    {
        $request = $this->createMock(StoreReplyRequest::class);
        $request->expects($this->once())
            ->method('validated')
            ->willReturn([
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'reply' => 'This is a test reply',
            ]);

        $reply = new ReplyService($request);

        $this->assertInstanceOf(ReplyService::class, $reply);
    }
}
