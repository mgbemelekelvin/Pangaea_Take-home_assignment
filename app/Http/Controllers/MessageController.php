<?php

namespace App\Http\Controllers;

use App\Events\MessagePublished;
use App\Models\Message;
use App\Models\Subscriber;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Messages';
        $msgs = Message::whereHas('topic')->get();
        return view('message.index', compact('title','msgs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Create Message';
        $topics = Auth::user()->topics;
        return view('message.create', compact('title','topics'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'topic_id' => 'required',
            'message' => 'required'
        ]);
        $topic = Topic::findOrFail($request->topic_id);
        $msg = new Message();
        $msg->topic_id = $topic->id;
        $msg->message = $request->message;
        if ($msg->save()){
            //An event listener to send diverse notifications when a message is created
            event(new MessagePublished($topic->id, $msg));
            return redirect('messages')->with('success', 'Created Successfully.');
        } else {
            return back()->with('failed','Failed something went wrong!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        $title = 'Edit "'. Str::limit($message->message, 20, $end='...').'"';
        $topics = Auth::user()->topics;
        return view('message.edit', compact('title','message','topics'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        $this->validate($request, [
            'topic_id' => 'required',
            'message' => 'required'
        ]);
        $message->topic_id = $request->topic_id;
        $message->message = $request->message;
        if ($message->update()){
            return back()->with('success', 'Updated Successfully.');
        } else {
            return back()->with('failed','Failed something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $message->delete();
        return back()->with('success','Deleted Successfully');
    }

    public function store_api(Request $request, $topic)
    {
        if ($topic) {
            //trying to fetch the topic from the database
            $topic = Topic::where('id',$topic)->first();
            if ($topic){
                //if topic exist then validate the form request
                $validator = \Validator::make($request->all(), [
                    'message' => 'required'
                ]);
                if ($validator->fails()) {
                    $response['status'] = 422;
                    $response['message'] = $validator->messages();
                } else {
                    $msg = new Message();
                    $msg->topic_id = $topic->id;
                    $msg->message = $request->message;
                    $msg->save();
//                    $response =
                    //An event listener to send diverse notifications when a message is created
                        event(new MessagePublished($topic->id, $msg));
                        $response['status'] = 200;
                        $response['message'] = 'Done';
                }
            } else {
                $response['status'] = 422;
                $response['message'] = 'Error Cant Fetch Topic';
            }
        } else {
            $response['status'] = 422;
            $response['message'] = 'Error Cant Find Topic ID';
        }
        return response()->json($response);
    }
}
