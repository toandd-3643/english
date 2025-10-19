<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Lấy thống kê người dùng
        $stats = [
            'learned_vocabularies' => 0, // TODO: Implement logic
            'completed_quizzes' => 0, // TODO: Implement logic
            'average_score' => 0, // TODO: Implement logic
            'streak_days' => 0, // TODO: Implement logic
        ];
        
        return view('client.profile.index', compact('stats'));
    }
    
    public function edit()
    {
        return view('client.profile.edit');
    }
    
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level' => 'required|in:beginner,intermediate,advanced',
        ], [
            'name.required' => 'Vui lòng nhập tên',
            'level.required' => 'Vui lòng chọn trình độ',
        ]);
        
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'level' => $request->level,
        ]);
        
        return redirect()->route('client.profile')
            ->with('success', 'Cập nhật thông tin thành công!');
    }
}
