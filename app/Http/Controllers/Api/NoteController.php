<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use App\Http\Resources\UserResource;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        return $this->json([
            'notes' => NoteResource::collection($user->notes)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteRequest $request)
    {
        return $this->json(['status' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $note)
    {
        $note = Note::find($note);
        if (!$note) {
            return $this->json(['error' => 'note not exists!', 'note' => null], 404);
        }

        if (auth()->id() !== $note->user_id) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        return $this->json([
            'message' => 'note found!',
            'note' => new NoteResource($note)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        //
    }
}
