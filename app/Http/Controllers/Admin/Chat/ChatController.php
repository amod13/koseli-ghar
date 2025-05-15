<?php

namespace App\Http\Controllers\Admin\Chat;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $chats = Chat::latest()->take(50)->get()->reverse();
        return view('admin.page.chat.index', compact('chats'));
    }


    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $chat = Chat::create([
            'user_id' => Auth::id(),
            'message' => $request->message,
            'sender' => 'user',
        ]);

        // Very simple bot response logic
        $replyText = $this->generateBotReply($request->message);

        Chat::create([
            'user_id' => Auth::id(),
            'message' => $replyText,
            'sender' => 'bot',
        ]);

        return response()->json(['success' => true]);
    }



    protected function generateBotReply($message)
    {
        $message = strtolower($message);

        // Common greetings
        if (str_contains($message, 'hello') || str_contains($message, 'hi')) {
            return 'Hello! How can I help you today?';
        }

        // Order-related
        if (str_contains($message, 'order') && str_contains($message, 'status')) {
            return 'You can check your order status in your dashboard under "My Orders".';
        }

        if (str_contains($message, 'cancel order')) {
            return 'To cancel your order, please contact our support team or go to your order page.';
        }

        if (str_contains($message, 'track order') || str_contains($message, 'where is my order')) {
            return 'You can track your order from your account > Orders > Track.';
        }

        // Payment-related
        if (str_contains($message, 'payment') && str_contains($message, 'fail')) {
            return 'If your payment failed, please try again or use another payment method.';
        }

        if (str_contains($message, 'refund')) {
            return 'Refunds are processed within 5-7 business days after approval.';
        }

        // Delivery-related
        if (str_contains($message, 'delivery') && str_contains($message, 'time')) {
            return 'Delivery usually takes 2–4 working days.';
        }

        if (str_contains($message, 'shipping cost')) {
            return 'Shipping is free for orders over NPR 1000. Otherwise, a small fee may apply.';
        }

        // Product-related
        if (str_contains($message, 'warranty')) {
            return 'All products come with a minimum of 1-year warranty unless otherwise stated.';
        }

        if (str_contains($message, 'return policy')) {
            return 'You can return items within 7 days if they are unused and in original packaging.';

        }

        // Default fallback
        return 'I\'m not sure how to answer that yet. A team member will get back to you shortly.';
    }

}
