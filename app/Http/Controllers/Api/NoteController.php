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
        $note = Note::make($request->validated());
        auth()->user()->notes()->save($note);
        return $this->json([
            'message' => 'Successfully created note',
            'note' => new NoteResource($note)
        ]);
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
    public function update(NoteRequest $request, int $id)
    {
        if (!$note = Note::find($id)) {
            return $this->json(['error' => 'note not found'], 404);
        }

        if (auth()->id() !== $note->user()->first()->id) {
            return $this->json(['error' => 'Unauthorized'], 401);
        };

        $note->update($request->validated());
        $note->save();

        return $this->json([
            'message' => 'Successfully updated note',
            'note' => new NoteResource($note)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        if (auth()->id() !== $note->user->id) {
            return $this->json(['error' => 'Unauthorized'], 401);
        }

        $note->delete();
        return $this->json([
            'message' => 'Deleted note!'
        ]);
    }
}
