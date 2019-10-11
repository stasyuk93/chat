<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\MessageRepository;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * @var MessageRepository
     */
    protected $repository;

    public function __construct()
    {
        $this->repository = new MessageRepository();
    }

    public function chat()
    {
        $messages =  Message::with('user')->get();
        return view('chat',compact('messages'));
    }


}
