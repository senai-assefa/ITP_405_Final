<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Trip;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class QuestionsController extends Controller
{
    public function disaplyQuestions()
    {
        //Fetch all questions from the database 
        $allTrips = Trip::all();
        return view('questions', ['allTrips' => $allTrips]);
    }

    public function addTrip(){
        return view('addTrip');
    }

    public function storeTrip(Request $request){
        // Validate the request data
        $request->validate([
            'start_location' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'best_thing' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        #create a new trip instance and store in the database
        $trip = new Trip();
        $trip->user_id = auth()->id(); // Assuming you have user authentication
        $trip->start_location = $request->input('start_location');
        $trip->destination = $request->input('destination');
        $trip->best_thing = $request->input('best_thing');
        $trip->rating = $request->input('rating');
        $trip->comment = $request->input('comment');
        $trip->save();

        return redirect()->route('questions.display')->with('success', 'Question added successfully!');
    }

    public function editTrip($id)
    {
        $trip = Trip::findOrFail($id);
        return view('editTrip', ['trip' => $trip]);
    }

    public function updateTrip(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'start_location' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'best_thing' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Find the trip and update it
        $trip = Trip::findOrFail($id);
        $trip->start_location = $request->input('start_location');
        $trip->destination = $request->input('destination');
        $trip->best_thing = $request->input('best_thing');
        $trip->rating = $request->input('rating');
        $trip->comment = $request->input('comment');
        $trip->save();

        return redirect()->route('questions.display')->with('success', 'Trip updated successfully!');
    }

    public function destroyTrip($id)
    {
        $trip = Trip::findOrFail($id);
        $trip->delete();

        return redirect()->route('questions.display')->with('success', 'Trip deleted successfully!');
    }

    public function showTripComments($id)
    {
        $trip = Trip::findOrFail($id);
        #order the comments by created_at in descending order
        $trip->comments = $trip->comments()->orderBy('created_at', 'desc')->get();
        return view('Comments', ['trip' => $trip]);
    }

    public function storeComment(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Find the trip and create a comment
        $trip = Trip::findOrFail($id);
        $trip->comments()->create([
            'user_id' => auth()->id(), // Assuming you have user authentication
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('trip.comments', ['trip' => $trip])->with('success', 'Comment added successfully!');
    }

    public function showEditComment($tripId, $commentId)
    {
        // Find the comment
        $comment = Comment::findOrFail($commentId);
        $trip = Trip::findOrFail($tripId);

        return view('editComment', ['trip' => $trip, 'comment' => $comment]);
    }

    public function editComment(Request $request, $tripId, $commentId)
    {
        // Validate the request data
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        // Find the comment and update it
        $comment = Comment::findOrFail($commentId);
        $comment->comment = $request->input('comment');
        $comment->save();

        return redirect()->route('trip.comments', ['trip' => $tripId])->with('success', 'Comment updated successfully!');
    }

    public function deleteComment($tripId, $commentId)
    {
        // Find the comment and delete it
        $comment = Comment::findOrFail($commentId);
        $comment->delete();
        return redirect()->route('trip.comments', ['trip' => $tripId])->with('success', 'Comment deleted successfully!');
    }

    public function bookmarkTrip(Request $request, $tripId)
    {
        // Find the trip
        $trip = Trip::findOrFail($tripId);

        // Check if the trip is already bookmarked by the user
        $user = Auth::user();
        if ($user->bookmarkedTrips()->where('trip_id', $trip->id)->exists()) {
            return redirect()->route('questions.display')->with('error', 'Trip already bookmarked!');
        }

        // Bookmark the trip
        $user->bookmarkedTrips()->attach($trip);

        return redirect()->route('questions.display')->with('success', 'Trip bookmarked successfully!');
    }

    public function displayBookmarks()
    {
        // Fetch all bookmarked trips for the authenticated user
        $user = Auth::user();
        $bookmarkedTrips = $user->bookmarkedTrips()->get();
        return view('bookmarks', ['bookmarkedTrips' => $bookmarkedTrips]);

    }

    public function removeBookmark($tripId)
    {
        $trip = Trip::findOrFail($tripId);
        $user = Auth::user();
        $user->bookmarkedTrips()->detach($trip);

        return redirect()->route('bookmarks.display')->with('success', 'Bookmark removed successfully!');
    }

    public function generateTrips(Request $request)
    {

        $request -> validate([
            'api_input' => 'required|string|max:255',
        ]);

        $api_input = $request->input('api_input');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $api_input,
                ],
            ],
            'temperature' => 0.7,
        ]);

        if ($response->successful()) {
            $result = $response->json();
            $reply = $result['choices'][0]['message']['content'];
            return redirect() -> route('dashboard')->with('ai_response', $reply);
        } else {
            return redirect()-> route('dashboard')->with('error', $response->json()['error']['message']);
        }
    }
}
